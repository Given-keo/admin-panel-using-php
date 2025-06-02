<?php
include '../config/koneksi.php'; // pastikan file ini berisi koneksi ke database

// Tangkap data dari form dan amankan dengan mysqli_real_escape_string
$nama_admin = mysqli_real_escape_string($conn, $_POST['nama_admin']);
$username   = mysqli_real_escape_string($conn, $_POST['username']);
$password   = mysqli_real_escape_string($conn, $_POST['password']);
$level      = mysqli_real_escape_string($conn, $_POST['level']);

// Hash password untuk keamanan
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Query insert data
$query = "INSERT INTO admins (nama, username, password, level) 
          VALUES ('$nama_admin', '$username', '$hashed_password', '$level')";

if (mysqli_query($conn, $query)) {
    // Jika berhasil
    echo "<script>alert('Data admin berhasil ditambahkan'); window.location.href='../index.php';</script>";
} else {
    // Jika gagal
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
