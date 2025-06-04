<?php
ob_start();
session_start();

// Menghapus semua variabel sesi
$_SESSION = array();

// Menghapus cookie sesi jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Menghancurkan sesi
session_unset();
session_destroy();

// Mencegah caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Mengarahkan kembali ke halaman login
header("Location: ../index.php");
exit();
?>
