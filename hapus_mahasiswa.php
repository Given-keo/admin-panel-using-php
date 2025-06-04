<?php 
include "config/koneksi.php";

$id = $_GET['id'];
$query = mysqli_query($koneksi,"DELETE FROM tbl_mahasiswa WHERE id_mhs = '$id'");

if($query) {
    header('location: tampil_mhs.php?message=berhasilsukses');
}
?>