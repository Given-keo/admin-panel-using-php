<?php
// Koneksi ke database
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = $_POST['password'];
  $repeat_password = $_POST['repeat_password'];

  // Cek apakah password cocok
  if ($password !== $repeat_password) {
    echo "<script>alert('Password tidak cocok!');</script>";
  } else {
    // Hash password untuk keamanan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
    $result = mysqli_query($conn, $query);

    if ($result) {
      // Redirect ke halaman login
      header("Location: ../index.php");
      exit;
    } else {
      echo "<script>alert('Gagal mendaftar!');</script>";
    }
  }
}
?>
