
<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pemesan = mysqli_real_escape_string($conn, $_POST['nama_pemesan']);
    $id_gunung = mysqli_real_escape_string($conn, $_POST['id_gunung']);
    $id_jalur = mysqli_real_escape_string($conn, $_POST['id_jalur']);
    $id_paket = mysqli_real_escape_string($conn, $_POST['id_paket']);
    $tanggal_booking = mysqli_real_escape_string($conn, $_POST['tanggal_booking']);
    $nominal = mysqli_real_escape_string($conn, $_POST['nominal']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $jumlah_orang = (int) mysqli_real_escape_string($conn, $_POST['jumlah_orang']);

    // Cek kuota yang tersedia
    $query = mysqli_query($conn, "SELECT k.jumlah_kuota, 
                                  (SELECT IFNULL(SUM(b.jumlah_orang), 0) 
                                   FROM booking b 
                                   WHERE b.id_gunung = k.id_gunung 
                                   AND b.id_jalur = k.id_jalur 
                                   AND b.status = 'Confirmed' 
                                   AND b.is_entered = 1) as used 
                                  FROM kuota k 
                                  WHERE k.id_gunung = '$id_gunung' 
                                  AND k.id_jalur = '$id_jalur' 
                                  AND k.status = 1");

    if ($row = mysqli_fetch_assoc($query)) {
        $remaining = $row['jumlah_kuota'] - $row['used'];

        if ($remaining >= $jumlah_orang) {
            // Simpan booking
            $insert = mysqli_query($conn, "INSERT INTO booking (nama_pemesan, id_gunung, id_jalur, id_paket, tanggal_booking, nominal, jumlah_orang, status, is_entered, created_at) 
                                          VALUES ('$nama_pemesan', '$id_gunung', '$id_jalur', '$id_paket', '$tanggal_booking', '$nominal', '$jumlah_orang', '$status', 1, NOW())");

            if ($insert) {
                header("Location: ../daftar_transaksi.php?success=1");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Gagal menambahkan booking: " . mysqli_error($conn) . "</div>";
            }
        } else {
            header("Location: booking_tambah.php?error=1&message=Kuota tidak cukup! Sisa kuota: $remaining slot");
            exit();
        }
    } else {
        echo "<div class='alert alert-danger'>Data kuota tidak ditemukan!</div>";
    }
} else {
    header("Location: ../tambah_booking.php");
    exit();
}