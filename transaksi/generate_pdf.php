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

// Tentukan path absolut ke file gambar
$image_path = realpath(__DIR__ . '/../img/img-login.jpg');
if (!$image_path || !file_exists($image_path)) {
    $image_path = ''; // Jika gambar tidak ditemukan, gunakan string kosong
} else {
    $image_path = 'file://' . $image_path; // Gunakan skema file:// untuk Dompdf
}

// Ambil filter booking_id jika ada
$filter_booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : null;
$where_clause = $filter_booking_id ? "WHERE p.booking_id = ?" : "";

// Ambil data transaksi menggunakan prepared statement
$query = "SELECT p.id, p.booking_id, b.nama_pemesan, p.payment_date, p.amount, pm.method_name, p.payment_status 
          FROM payments p 
          JOIN booking b ON p.booking_id = b.id_booking 
          JOIN payment_methods pm ON p.payment_method_id = pm.id 
          $where_clause";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo "<script>alert('Error: Gagal menyiapkan query database.'); window.location.href='pembayaran.php';</script>";
    exit();
}
if ($filter_booking_id) {
    $stmt->bind_param("i", $filter_booking_id);
}
$stmt->execute();
$result = $stmt->get_result();

// Buat konten HTML untuk PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { width: 100%; max-width: 800px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0; color: #555; }
        .header img { max-width: 100px; margin-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; font-weight: bold; }
        .status-lunas { color: green; font-weight: bold; }
        .status-belum-lunas { color: red; font-weight: bold; }
        .status-pending { color: orange; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            ' . ($image_path ? '<img src="' . htmlspecialchars($image_path) . '" alt="Logo">' : '<p>Gambar tidak ditemukan</p>') . '
            <h1>Daftar Transaksi</h1>
            <p>Tanggal: ' . date('d-m-Y') . '</p>
            ' . ($filter_booking_id ? '<p>Filter: Booking ID #' . htmlspecialchars($filter_booking_id) . '</p>' : '') . '
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Nominal</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';
if ($result->num_rows == 0) {
    $html .= '<tr><td colspan="6" style="text-align: center;">Tidak ada transaksi ditemukan.</td></tr>';
} else {
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        $status_class = '';
        if ($row['payment_status'] == 'Lunas') {
            $status_class = 'status-lunas';
        } elseif ($row['payment_status'] == 'Belum Lunas') {
            $status_class = 'status-belum-lunas';
        } else {
            $status_class = 'status-pending';
        }
        $html .= '
                <tr>
                    <td>' . $no++ . '</td>
                    <td>' . htmlspecialchars($row['nama_pemesan']) . '</td>
                    <td>' . htmlspecialchars($row['payment_date']) . '</td>
                    <td>Rp ' . number_format($row['amount'], 0, ',', '.') . '</td>
                    <td>' . htmlspecialchars($row['method_name']) . '</td>
                    <td class="' . $status_class . '">' . htmlspecialchars($row['payment_status']) . '</td>
                </tr>';
    }
}
$html .= '
            </tbody>
        </table>
        <div class="footer">
            <p>Dicetak pada: ' . date('d-m-Y H:i:s') . '</p>
            <p>Sistem Manajemen Pembayaran</p>
        </div>
    </div>
</body>
</html>';

$stmt->close();

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
$filename = "Daftar_Transaksi_" . date('Ymd') . ".pdf";
$dompdf->stream($filename, array("Attachment" => true));

// Tutup koneksi database
mysqli_close($conn);
?>