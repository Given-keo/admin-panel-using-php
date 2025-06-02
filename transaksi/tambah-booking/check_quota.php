<?php
include '../../config/koneksi.php';

header('Content-Type: application/json');

$id_gunung = isset($_POST['id_gunung']) ? mysqli_real_escape_string($conn, $_POST['id_gunung']) : '';
$id_jalur = isset($_POST['id_jalur']) ? mysqli_real_escape_string($conn, $_POST['id_jalur']) : '';

if ($id_gunung && $id_jalur) {
    $query = mysqli_query($conn, "SELECT k.jumlah_kuota, 
                                  (SELECT IFNULL(SUM(b.jumlah_orang), 0) 
                                   FROM booking b 
                                   WHERE b.id_gunung = k.id_gunung 
                                   AND b.id_jalur = k.id_jalur 
                                   AND b.status = 'Confirmed' 
                                   AND b.is_entered = 1) as used 
                                  FROM kuota k 
                                  WHERE k.id_gunung = '$id_gunung' 
                                  AND k.id_jalur = '$id_jalur' 
                                  AND k.status = 1");

    if ($row = mysqli_fetch_assoc($query)) {
        $remaining = $row['jumlah_kuota'] - $row['used'];
        echo json_encode(['remaining' => $remaining]);
    } else {
        echo json_encode(['remaining' => 0]);
    }
} else {
    echo json_encode(['remaining' => 0]);
}