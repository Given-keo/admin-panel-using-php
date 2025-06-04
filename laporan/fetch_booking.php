<?php
include '../config/koneksi.php';

$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($conn, $_GET['end_date']) : date('Y-m-d');
$where_clause = "WHERE b.tanggal_booking BETWEEN '$start_date' AND '$end_date'";

// Ambil data booking
$query = mysqli_query($conn, "SELECT b.id_booking, b.nama_pemesan, b.tanggal_booking, g.nama_gunung, j.nama_jalur, b.status, 
                              b.jumlah_orang, b.nominal, p.nama_paket 
                              FROM booking b 
                              JOIN gunung g ON b.id_gunung = g.id 
                              JOIN jalur j ON b.id_jalur = j.id 
                              LEFT JOIN paket p ON b.id_paket = p.id 
                              $where_clause");

// Ambil data kuota untuk statistik
$kuota_query = mysqli_query($conn, "SELECT k.id_gunung, k.id_jalur, g.nama_gunung, j.nama_jalur, k.jumlah_kuota, 
                                   (SELECT IFNULL(SUM(b2.jumlah_orang), 0) 
                                    FROM booking b2 
                                    WHERE b2.id_gunung = k.id_gunung 
                                    AND b2.id_jalur = k.id_jalur 
                                    AND b2.status = 'Confirmed' 
                                    AND b2.is_entered = 1) as used 
                                   FROM kuota k 
                                   JOIN gunung g ON k.id_gunung = g.id 
                                   JOIN jalur j ON k.id_jalur = j.id 
                                   WHERE k.status = 1");

// Hitung statistik
$total_bookings = mysqli_num_rows($query);
$total_people = 0;
$total_revenue = 0;
$gunung_stats = [];
$booking_data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $total_people += $row['jumlah_orang'];
    $total_revenue += $row['nominal'] ?? 0;
    $gunung_stats[$row['nama_gunung']] = ($gunung_stats[$row['nama_gunung']] ?? ['count' => 0, 'people' => 0]) + ['count' => 1, 'people' => $row['jumlah_orang']];
    $gunung_stats[$row['nama_gunung']]['count']++;
    $gunung_stats[$row['nama_gunung']]['people'] += $row['jumlah_orang'];
    $booking_data[] = $row;
}

// Proses data kuota
$kuota_stats = [];
while ($row = mysqli_fetch_assoc($kuota_query)) {
    $remaining = $row['jumlah_kuota'] - $row['used'];
    $kuota_stats[] = [
        'nama_gunung' => $row['nama_gunung'],
        'nama_jalur' => $row['nama_jalur'],
        'remaining' => $remaining
    ];
}

$response = [
    'total_bookings' => $total_bookings,
    'total_people' => $total_people,
    'total_revenue' => $total_revenue,
    'gunung_stats' => $gunung_stats,
    'kuota_stats' => $kuota_stats,
    'booking_data' => $booking_data
];

header('Content-Type: application/json');
echo json_encode($response);
?>