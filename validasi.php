<?php
session_start(); // Wajib untuk session

// koneksi database
include './config/koneksi.php';

// panggil post inputan
$username   = $_POST['username'];
$password   = $_POST['password'];

// untuk query
$query  = "SELECT * FROM tbl_user WHERE username = '$username' AND password = '$password'";

// eksekusi query
$result = $koneksi->query($query);

// cek hasil query
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Ambil data user sebagai array asosiatif
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];
    echo '<script>
            alert("Anda berhasil login!");
            window.location.href = "./dashboard.php";
          </script>';
} else {
    echo '<script>
            alert("Username dan Password tidak ditemukan!");
            window.location.href = "./index.php";
          </script>';
}
?>
