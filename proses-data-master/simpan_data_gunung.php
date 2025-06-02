<?php
// Koneksi ke database
include('../config/koneksi.php'); // pastikan file koneksi.php sudah ada dan berfungsi dengan benar

// Menangani input dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_gunung = $_POST['nama_gunung'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    // Menangani upload foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp_name = $_FILES['foto']['tmp_name'];
        $foto_size = $_FILES['foto']['size'];

        // Tentukan folder tujuan untuk menyimpan foto
        $upload_dir = 'uploads/';
        $foto_path = $upload_dir . basename($foto_name);

        // Memindahkan foto ke folder tujuan
        if (move_uploaded_file($foto_tmp_name, $foto_path)) {
            // Foto berhasil diupload
        } else {
            echo "Gagal mengupload foto.";
        }
    } else {
        // Jika tidak ada foto yang diupload, set foto menjadi null
        $foto_path = null;
    }

    // Menyimpan data ke database
    $sql = "INSERT INTO gunung (nama_gunung, lokasi, deskripsi, foto, status) 
            VALUES ('$nama_gunung', '$lokasi', '$deskripsi', '$foto_path', '$status')";

    if (mysqli_query($conn, $sql)) {
        // Jika data berhasil disimpan
        echo "<script>alert('Data Gunung berhasil disimpan!'); window.location = '../data-master/data_gunung.php';</script>";
    } else {
        // Jika terjadi kesalahan
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Tutup koneksi database
    mysqli_close($conn);
}
?>
