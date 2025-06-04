<?php
// panggil file koneksi.php
include 'config/koneksi.php';

// tangkap data dari form mahasiswa
$nim = $_POST['nim'];
$nama = $_POST['nama'];
$id_prodi = $_POST['id_prodi'];
$tempat_lahir = $_POST['tempat_lahir'];
$tgl_lahir = $_POST['tgl_lahir'];

// cek apakah NIM sudah ada di database
// $cek_nim = mysqli_query($koneksi, "SELECT * FROM tbl_mahasiswa WHERE nim = '$nim'");

// jika NIM belum ada, lakukan insert
$query = mysqli_query($koneksi,"UPDATE tbl_mahasiswa SET 
    nama = '$nama',
    id_prodi = '$id_prodi',
    tempat_lahir = '$tempat_lahir',
    tgl_lahir = '$tgl_lahir'
WHERE 
    nim = '$nim'");

if ($query) {
    header('Location: tampil_mhs.php?message=suksesbro');
} else {
    echo "Gagal insert data: " . mysqli_error($koneksi);
}

?>
