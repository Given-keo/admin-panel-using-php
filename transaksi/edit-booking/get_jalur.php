<?php
// get_jalur.php

include '../../config/koneksi.php';

// Cek apakah id_gunung dikirim
if (isset($_POST['id_gunung'])) {
    $id_gunung = intval($_POST['id_gunung']);

    // Ambil data jalur berdasarkan id_gunung
    $result = mysqli_query($conn, "SELECT * FROM jalur WHERE id_gunung = $id_gunung AND status = 'aktif'");

    echo '<option value="">Pilih Jalur</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nama_jalur']) . '</option>';
    }
}
?>
