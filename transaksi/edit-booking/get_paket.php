<?php
// get_paket.php

include '../../config/koneksi.php';

// Cek apakah id_gunung dikirim
if (isset($_POST['id_gunung'])) {
    $id_gunung = intval($_POST['id_gunung']);

    // Ambil data paket berdasarkan id_gunung
    $result = mysqli_query($conn, "SELECT * FROM paket WHERE id_gunung = $id_gunung AND status = 'aktif'");

    echo '<option value="">Pilih Paket</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nama_paket']) . '</option>';
    }
}
?>
