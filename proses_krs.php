<?php
// panggil file koneksi.php
include 'config/koneksi.php';

// tangkap data dari form mahasiswa
$nim = $_POST['nim'];
$id_jadwal = $_POST['id_jadwal'];



$query = mysqli_query($koneksi, "INSERT INTO t_krs VALUES (
    '', '$nim', '$id_jadwal')");

if ($query) {
    header('Location: tampil_krs.php?message=berhasilMasBro');
} else {
    echo "Gagal insert data: " . mysqli_error($koneksi);
}

?>
