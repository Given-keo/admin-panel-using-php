<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Atur zona waktu ke Asia/Jakarta (WIB)
date_default_timezone_set('Asia/Jakarta');

// Sertakan koneksi database
include '../config/koneksi.php';
if (!$conn) {
    echo "<script>alert('Error: Koneksi database gagal.'); window.location.href='pembayaran.php';</script>";
    exit();
}

// Periksa apakah autoloader Dompdf ada
if (!file_exists('../vendor/autoload.php')) {
    echo "<script>alert('Error: Autoloader Dompdf tidak ditemukan. Silakan instal Dompdf menggunakan Composer (jalankan: composer require dompdf/dompdf).'); window.location.href='pembayaran.php';</script>";
    exit();
}

// Sertakan library Dompdf
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;

// Periksa apakah payment_id ada di URL
if (!isset($_GET['payment_id']) || empty($_GET['payment_id'])) {
    echo "<script>alert('Error: ID Transaksi diperlukan.'); window.location.href='pembayaran.php';</script>";
    exit();
}

// Ambil payment_id dan pastikan berupa integer
$payment_id = (int)$_GET['payment_id'];

// Ambil detail transaksi dari database menggunakan prepared statement
$stmt = $conn->prepare("SELECT p.id, p.booking_id, b.nama_pemesan, p.payment_date, p.amount, pm.method_name, p.payment_status 
                        FROM payments p 
                        JOIN booking b ON p.booking_id = b.id_booking 
                        JOIN payment_methods pm ON p.payment_method_id = pm.id 
                        WHERE p.id = ?");
if (!$stmt) {
    echo "<script>alert('Error: Gagal menyiapkan query database.'); window.location.href='pembayaran.php';</script>";
    exit();
}
$stmt->bind_param("i", $payment_id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Periksa apakah data transaksi ditemukan
if (!$row) {
    echo "<script>alert('Error: Transaksi tidak ditemukan.'); window.location.href='pembayaran.php';</script>";
    exit();
}

// Periksa apakah status transaksi adalah Lunas
if ($row['payment_status'] !== 'Lunas') {
    echo "<script>alert('Error: Hanya transaksi dengan status Lunas yang dapat mencetak bukti pelunasan.'); window.location.href='pembayaran.php';</script>";
    exit();
}

// Tentukan path absolut ke file gambar
$image_path = realpath(__DIR__ . '/../img/img-login.jpg');
if (!$image_path || !file_exists($image_path)) {
    $image_path = ''; // Jika gambar tidak ditemukan, gunakan string kosong
} else {
    $image_path = 'file://' . $image_path; // Gunakan skema file:// untuk Dompdf
}

// Buat konten HTML untuk PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pelunasan Transaksi #' . htmlspecialchars($row['id']) . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0; color: #555; }
        .header img { max-width: 100px; margin-bottom: 10px; }
        .receipt { border: 1px solid #ddd; padding: 20px; }
        .receipt h2 { font-size: 18px; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .status-lunas { color: green; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bukti Pelunasan Transaksi</h1>
            <p>Transaksi ID: #' . htmlspecialchars($row['id']) . '</p>
            <p>Tanggal: ' . date('d-m-Y') . '</p>
            ' . ($image_path ? '<img src="' . htmlspecialchars($image_path) . '" alt="Logo">' : '<p>Gambar tidak ditemukan</p>') . '
        </div>
        <div class="receipt">
            <h2>Detail Pembayaran</h2>
            <table class="table">
                <tr>
                    <th>Nama Pemesan</th>
                    <td>' . htmlspecialchars($row['nama_pemesan']) . '</td>
                </tr>
                <tr>
                    <th>Tanggal Pembayaran</th>
                    <td>' . htmlspecialchars($row['payment_date']) . '</td>
                </tr>
                <tr>
                    <th>Nominal</th>
                    <td>Rp ' . number_format($row['amount'], 0, ',', '.') . '</td>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    <td>' . htmlspecialchars($row['method_name']) . '</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td class="status-lunas">Lunas</td>
                </tr>
            </table>
            <p>Terima kasih telah melakukan pembayaran. Transaksi ini telah dinyatakan <strong>Lunas</strong>.</p>
        </div>
        <div class="footer">
            <p>Dicetak pada: ' . date('d-m-Y H:i:s') . '</p>
            <p>Sistem Manajemen Pembayaran</p>
        </div>
    </div>
</body>
</html>
';

// Inisialisasi Dompdf dengan opsi
$options = new \Dompdf\Options();
$options->set('isRemoteEnabled', true); // Aktifkan akses gambar remote (jika diperlukan)
$options->set('chroot', realpath(__DIR__ . '/..')); // Batasi akses file ke direktori proyek
$dompdf = new Dompdf($options);

// Muat konten HTML
$dompdf->loadHtml($html);

// Atur ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'portrait');

// Render HTML menjadi PDF
$dompdf->render();

// Keluarkan PDF ke browser
$dompdf->stream("Bukti_Pelunasan_Transaksi_" . $row['id'] . ".pdf", array("Attachment" => true));

// Tutup koneksi database
mysqli_close($conn);
?>