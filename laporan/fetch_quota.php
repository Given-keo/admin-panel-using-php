<?php
header('Content-Type: application/json');
include '../config/koneksi.php';

if (!$conn) {
    echo json_encode(['error' => 'Koneksi database gagal']);
    exit();
}

// Filter tanggal
$start_date = isset($_GET['start_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['start_date']) 
    ? mysqli_real_escape_string($conn, $_GET['start_date']) 
    : date('Y-m-01');
$end_date = isset($_GET['end_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['end_date']) 
    ? mysqli_real_escape_string($conn, $_GET['end_date']) 
    : date('Y-m-d');
if (strtotime($end_date) < strtotime($start_date)) {
    $end_date = $start_date;
}

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
if (!$query) {
    echo json_encode(['error' => 'Query gagal: ' . mysqli_error($conn)]);
    exit();
}

// Hitung statistik
$total_kuota = 0;
$total_used = 0;
$gunung_stats = [];
$kuota_data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $total_kuota += (int)$row['jumlah_kuota'];
    $row['used'] = (int)($row['used'] ?? 0);
    $total_used += $row['used'];
    $gunung_stats[$row['nama_gunung']] = ($gunung_stats[$row['nama_gunung']] ?? 0) + $row['used'];
    $row['remaining'] = (int)($row['jumlah_kuota'] - $row['used']);
    $kuota_data[] = [
        'nama_gunung' => $row['nama_gunung'],
        'nama_jalur' => $row['nama_jalur'],
        'jumlah_kuota' => (int)$row['jumlah_kuota'],
        'used' => (int)$row['used'],
        'remaining' => (int)$row['remaining']
    ];
}

// Output JSON
echo json_encode([
    'total_kuota' => $total_kuota,
    'total_used' => $total_used,
    'gunung_stats' => $gunung_stats,
    'kuota_data' => $kuota_data
]);

mysqli_close($conn);
?>