<?php
include '../config/koneksi.php';

$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($conn, $_GET['end_date']) : date('Y-m-d');

// Ambil data kuota
$query = mysqli_query($conn, "SELECT k.id, g.nama_gunung, j.nama_jalur, k.jumlah_kuota, 
                              (SELECT IFNULL(SUM(b.jumlah_orang), 0) 
                               FROM booking b 
                               WHERE b.id_gunung = k.id_gunung 
                               AND b.id_jalur = k.id_jalur 
                               AND b.status = 'Confirmed' 
                               AND b.is_entered = 1) as used 
                              FROM kuota k 
                              JOIN gunung g ON k.id_gunung = g.id 
                              JOIN jalur j ON k.id_jalur = j.id 
                              WHERE k.status = 1");

$total_kuota = 0;
$total_used = 0;
$gunung_stats = [];
$kuota_data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $total_kuota += $row['jumlah_kuota'];
    $row['used'] = $row['used'] ?? 0;
    $total_used += $row['used'];
    $gunung_stats[$row['nama_gunung']] = ($gunung_stats[$row['nama_gunung']] ?? 0) + $row['used'];
    $row['remaining'] = $row['jumlah_kuota'] - $row['used'];
    $kuota_data[] = $row;
}

// Ambil daftar booking untuk rentang tanggal tertentu
$booking_query = mysqli_query($conn, "SELECT b.id_booking, b.nama_pemesan, g.nama_gunung, j.nama_jalur, b.tanggal_booking, b.jumlah_orang 
                                     FROM booking b 
                                     JOIN gunung g ON b.id_gunung = g.id 
                                     JOIN jalur j ON b.id_jalur = j.id 
                                     WHERE b.tanggal_booking BETWEEN '$start_date' AND '$end_date' 
                                     AND b.status = 'Confirmed' 
                                     AND b.is_entered = 1");
$booking_data = [];
while ($row = mysqli_fetch_assoc($booking_query)) {
    $booking_data[] = $row;
}

$response = [
    'total_kuota' => $total_kuota,
    'total_used' => $total_used,
    'gunung_stats' => $gunung_stats,
    'kuota_data' => $kuota_data,
    'booking_data' => $booking_data
];

header('Content-Type: application/json');
echo json_encode($response);
?>