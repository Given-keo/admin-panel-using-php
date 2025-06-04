<?php
include "../config/koneksi.php";

// Tangkap data dari form
$id_gunung = $_POST['id_gunung'];
$id_jalur = $_POST['id_jalur'];
// $tanggal = $_POST['tanggal'];
$jumlah_kuota = $_POST['jumlah_kuota'];
$status = $_POST['status'];

// Validasi sederhana
if (!$id_gunung || !$id_jalur || !$jumlah_kuota || !$status) {
    echo "<script>alert('Semua data harus diisi!'); window.location.href='../data-master/data_kuota.php';</script>";
    exit;
}

// Simpan ke database
$query = "INSERT INTO kuota (id_gunung, id_jalur, jumlah_kuota, status) 
        VALUES ('$id_gunung', '$id_jalur', '$jumlah_kuota', '$status')";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Data kuota berhasil ditambahkan!'); window.location.href='../data-master/data_kuota.php';</script>";
} else {
    echo "<script>alert('Gagal menambahkan data: " . mysqli_error($conn) . "'); window.location.href='../data-master/data_kuota.php';</script>";
}

mysqli_close($conn);
?>
