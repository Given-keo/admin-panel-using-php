<?php
include '../../config/koneksi.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = mysqli_query($conn, "SELECT harga FROM paket WHERE id = '$id'");
  $data = mysqli_fetch_assoc($query);
  echo $data ? $data['harga'] : '0';
}
?>
