<?php
include '../../config/koneksi.php';

// Ambil dan sanitasi ID dari URL
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// Validasi apakah ID valid
if (empty($id)) {
    echo "<script>alert('ID booking tidak valid.'); window.location.href = '../daftar_transaksi.php';</script>";
    exit();
}

// Cek apakah booking dengan ID tersebut ada
$checkQuery = mysqli_query($conn, "SELECT id_booking FROM booking WHERE id_booking = '$id'");
if (mysqli_num_rows($checkQuery) == 0) {
    echo "<script>alert('Data booking tidak ditemukan.'); window.location.href = '../daftar_transaksi.php';</script>";
    exit();
}

// Hapus data booking (data di tabel payments akan otomatis terhapus karena ON DELETE CASCADE)
$deleteQuery = mysqli_query($conn, "DELETE FROM booking WHERE id_booking = '$id'");

if ($deleteQuery) {
    echo "<script>alert('Data booking berhasil dihapus!'); window.location.href = '../daftar_transaksi.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data booking: " . mysqli_error($conn) . "'); window.location.href = '../daftar_transaksi.php';</script>";
}

exit();
?>