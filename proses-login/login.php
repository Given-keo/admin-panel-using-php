<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit;
}

// Koneksi database
include '../config/koneksi.php';

// Ambil data dari form
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Cek jika input kosong
if (empty($username) || empty($password)) {
    echo '<script>
            alert("Username dan password tidak boleh kosong!");
            window.location.href = "../index.php";
          </script>';
    exit;
}

// Query ambil data admin berdasarkan username
$query = "SELECT * FROM admins WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Cek hasil query
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifikasi password
    if (password_verify($password, $row['password'])) {
        session_regenerate_id(true);
        $_SESSION['username'] = $row['username'];
        $_SESSION['level'] = $row['level'];

        header("Location: ../dashboard.php");
        exit;
    } else {
        echo '<script>
                alert("Password salah!");
                window.location.href = "../index.php";
              </script>';
        exit;
    }
} else {
    echo '<script>
            alert("Username tidak ditemukan!");
            window.location.href = "../index.php";
          </script>';
    exit;
}
?>
