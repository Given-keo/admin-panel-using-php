<?php
$server     = 'localhost';
$user_id    = 'root';
$pass       = '';
$database   = 'db_kampus';

// koneksi database mysql
$koneksi = mysqli_connect($server, $user_id, $pass, $database);


// cek koneksi
if (!$koneksi) {
    die("Database Tidak Terhubung! " . mysqli_connect_error());
}
// else {
//     echo "Database Terhubung.";
// }
?>
