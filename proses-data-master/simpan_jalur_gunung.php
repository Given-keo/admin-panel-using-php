<?php
// koneksi database
include "../config/koneksi.php";

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_gunung = $_POST['id_gunung'];
    $nama_jalur = $_POST['nama_jalur'];
    $deskripsi_jalur = $_POST['deskripsi_jalur'];
    $status = $_POST['status'];

    // Query untuk memasukkan data ke tabel jalur
    $query = "INSERT INTO jalur (id_gunung, nama_jalur, deskripsi, status) 
              VALUES ('$id_gunung', '$nama_jalur', '$deskripsi_jalur', '$status')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman data jalur setelah berhasil menyimpan
        echo "<script>alert('Data Gunung berhasil disimpan!'); window.location = '../data-master/data_gunung.php';</script>";
    } else {
        // Menampilkan pesan error jika gagal
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
} else {
    // Jika tidak ada data yang dikirim lewat POST
    echo "Data tidak lengkap.";
}
?>
