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
$cek_nim = mysqli_query($koneksi, "SELECT * FROM tbl_mahasiswa WHERE nim = '$nim'");

if (mysqli_num_rows($cek_nim) > 0) {
    // jika NIM sudah ada 
    echo'<script>
            alert("NIM sudah terdaftar");
            window.location.href = "form-mahasiswa.php";
        </script>';
} else {
    // jika NIM belum ada, lakukan insert
    $query = mysqli_query($koneksi, "INSERT INTO tbl_mahasiswa VALUES (
        '', '$nim', '$nama', '$id_prodi', '$tempat_lahir', '$tgl_lahir'
    )");

    if ($query) {
        header('Location: tampil_mhs.php?message=suksesbro');
    } else {
        echo "Gagal insert data: " . mysqli_error($koneksi);
    }
}
?>
