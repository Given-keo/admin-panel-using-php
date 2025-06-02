<?php
include '../config/koneksi.php';

// Ambil data dari form
$nama_paket = mysqli_real_escape_string($conn, $_POST['nama_paket']);
$id_gunung  = mysqli_real_escape_string($conn, $_POST['id_gunung']);
$harga      = mysqli_real_escape_string($conn, $_POST['harga']);
$fasilitas  = mysqli_real_escape_string($conn, $_POST['fasilitas']);
$durasi     = mysqli_real_escape_string($conn, $_POST['durasi']);
$status     = mysqli_real_escape_string($conn, $_POST['status']);

// Query insert
$query = "INSERT INTO paket (id_gunung, nama_paket, durasi_hari, harga, fasilitas, status) 
          VALUES ('$id_gunung', '$nama_paket', '$durasi', '$harga', '$fasilitas', '$status')";

if (mysqli_query($conn, $query)) {
    echo "<script>
        alert('Paket pendakian berhasil ditambahkan!');
        window.location.href = '../data-master/data_paket_pendakian.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menambahkan paket: " . mysqli_error($conn) . "');
        window.history.back();
    </script>";
}
?>
