<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Atur zona waktu ke Asia/Jakarta (WIB)
date_default_timezone_set('Asia/Jakarta');

// Sertakan koneksi database
include '../../config/koneksi.php';
if (!$conn) {
    echo "<script>alert('Error: Koneksi database gagal.'); window.location.href='../laporan_transaksi.php';</script>";
    exit();
}

// Periksa apakah autoloader Dompdf ada
if (!file_exists('../../vendor/autoload.php')) {
    echo "<script>alert('Error: Autoloader Dompdf tidak ditemukan. Silakan instal Dompdf menggunakan Composer (jalankan: composer require dompdf/dompdf di direktori proyek).'); window.location.href='../laporan_transaksi.php';</script>";
    exit();
}

// Sertakan library Dompdf
require_once '../../vendor/autoload.php';

use Dompdf\Dompdf;

// Periksa apakah kelas Dompdf ada
if (!class_exists('Dompdf\Dompdf')) {
    echo "<script>alert('Error: Kelas Dompdf tidak ditemukan. Pastikan Dompdf terinstal dengan benar menggunakan Composer.'); window.location.href='../laporan_transaksi.php';</script>";
    exit();
}

// Tentukan path absolut ke file gambar
$image_path = realpath(__DIR__ . '/../../img/img-login.jpg');
if (!$image_path || !file_exists($image_path)) {
    $image_path = '';
} else {
    $image_path = 'file://' . $image_path;
}

// Ambil filter tanggal
$start_date = isset($_GET['start_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['start_date']) 
    ? mysqli_real_escape_string($conn, $_GET['start_date']) 
    : date('Y-m-01');
$end_date = isset($_GET['end_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['end_date']) 
    ? mysqli_real_escape_string($conn, $_GET['end_date']) 
    : date('Y-m-d');
if (strtotime($end_date) < strtotime($start_date)) {
    $end_date = $start_date;
}
$where_clause = "WHERE p.payment_date BETWEEN ? AND ?";

// Ambil data transaksi menggunakan prepared statement
$query = "SELECT p.id, p.booking_id, b.nama_pemesan, p.payment_date, p.amount, pm.method_name, p.payment_status 
          FROM payments p 
          JOIN booking b ON p.booking_id = b.id_booking 
          JOIN payment_methods pm ON p.payment_method_id = pm.id 
          $where_clause";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo "<script>alert('Error: Gagal menyiapkan query database.'); window.location.href='../laporan_transaksi.php';</script>";
    exit();
}
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

// Hitung total nominal
$total_amount = 0;
$transaksi_data = [];
while ($row = $result->fetch_assoc()) {
    $total_amount += (int)$row['amount'];
    $transaksi_data[] = $row;
}

// Format tanggal untuk tampilan
$formatted_start_date = date('d-m-Y', strtotime($start_date));
$formatted_end_date = date('d-m-Y', strtotime($end_date));
$print_date = date('d-m-Y');
$print_time = date('H:i:s');

// Buat HTML untuk PDF
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 30px; 
            color: #333; 
        }
        .container { 
            width: 90%; 
            max-width: 900px; 
            margin: 0 auto; 
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 2px solid #4e73df; 
            padding-bottom: 10px; 
        }
        .header img { 
            max-width: 120px; 
            margin-bottom: 10px; 
        }
        .header h1 { 
            font-size: 22px; 
            color: #4e73df; 
            margin: 0; 
            font-weight: bold; 
        }
        .header p { 
            font-size: 12px; 
            color: #555; 
            margin: 5px 0; 
        }
        .stats { 
            margin-bottom: 20px; 
            font-size: 12px; 
        }
        .stats p { 
            margin: 5px 0; 
            font-weight: bold; 
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        .table th, .table td { 
            border: 1px solid #000; 
            padding: 10px; 
            text-align: left; 
            vertical-align: middle; 
        }
        .table th { 
            background-color: #4e73df; 
            color: white; 
            font-weight: bold; 
            font-size: 12px; 
        }
        .table td { 
            font-size: 11px; 
        }
        .table tr:nth-child(even) { 
            background-color: #f8f9fc; 
        }
        .table .total-row td { 
            font-weight: bold; 
            background-color: #e9ecef; 
        }
        .status-lunas, .status-belum-lunas, .status-pending { 
            display: inline-block; 
            padding: 4px 8px; 
            border-radius: 4px; 
            color: white; 
            font-size: 11px; 
            text-align: center; 
            min-width: 80px; 
        }
        .status-lunas { 
            background-color: #1cc88a; 
        }
        .status-belum-lunas { 
            background-color: #e74a3b; 
        }
        .status-pending { 
            background-color: #f6c23e; 
            color: #333; 
        }
        .footer { 
            text-align: center; 
            margin-top: 30px; 
            border-top: 1px solid #ccc; 
            padding-top: 10px; 
            font-size: 10px; 
            color: #777; 
        }
        .no-column { width: 5%; text-align: center; }
        .nama-column { width: 25%; }
        .tanggal-column { width: 15%; }
        .nominal-column { width: 15%; }
        .metode-column { width: 20%; }
        .status-column { width: 20%; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">';
if ($image_path) {
    $html .= '<img src="' . $image_path . '" alt="Logo">';
}
$html .= '
            <h1>Laporan Transaksi</h1>
            <p>Periode: ' . htmlspecialchars($formatted_start_date) . ' s.d. ' . htmlspecialchars($formatted_end_date) . '</p>
            <p>Tanggal Cetak: ' . htmlspecialchars($print_date) . '</p>
        </div>

        <div class="stats">
            <p>Total Transaksi: ' . count($transaksi_data) . ' Transaksi</p>
            <p>Total Nominal: Rp ' . number_format($total_amount, 0, ',', '.') . '</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th class="no-column">No</th>
                    <th class="nama-column">Nama Pemesan</th>
                    <th class="tanggal-column">Tanggal Pembayaran</th>
                    <th class="nominal-column">Nominal</th>
                    <th class="metode-column">Metode Pembayaran</th>
                    <th class="status-column">Status</th>
                </tr>
            </thead>
            <tbody>';
if (empty($transaksi_data)) {
    $html .= '<tr><td colspan="6" style="text-align: center; padding: 15px;">Tidak ada transaksi ditemukan untuk periode ini.</td></tr>';
} else {
    $no = 1;
    foreach ($transaksi_data as $row) {
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
                    <td class="no-column">' . $no++ . '</td>
                    <td class="nama-column">' . htmlspecialchars($row['nama_pemesan']) . '</td>
                    <td class="tanggal-column">' . htmlspecialchars(date('d-m-Y', strtotime($row['payment_date']))) . '</td>
                    <td class="nominal-column">Rp ' . number_format($row['amount'], 0, ',', '.') . '</td>
                    <td class="metode-column">' . htmlspecialchars($row['method_name']) . '</td>
                    <td class="status-column"><span class="' . $status_class . '">' . htmlspecialchars($row['payment_status']) . '</span></td>
                </tr>';
    }
    // Baris total
    $html .= '
                <tr class="total-row">
                    <td colspan="5" >Total:</td>
                    <td  colspan="1" style="text-align: center;">Rp ' . number_format($total_amount, 0, ',', '.') . '</td>
                </tr>';
}
$html .= '
            </tbody>
        </table>

        <div class="footer">
            <p>Dicetak pada: ' . htmlspecialchars($print_date . ' ' . $print_time) . '</p>
            <p>Sistem Manajemen Booking Gunung</p>
        </div>
    </div>
</body>
</html>';

// Inisialisasi Dompdf dengan opsi
$options = new \Dompdf\Options();
$options->set('isRemoteEnabled', true); // Aktifkan akses gambar remote
$options->set('chroot', realpath(__DIR__ . '/../../')); // Sesuaikan chroot ke root proyek
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);

// Muat konten HTML
$dompdf->loadHtml($html);

// Atur ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'portrait');

// Render HTML menjadi PDF
$dompdf->render();

// Keluarkan PDF ke browser
$filename = "Laporan_Transaksi_" . $start_date . "_" . $end_date . ".pdf";
$dompdf->stream($filename, array("Attachment" => true));

// Tutup koneksi database
$stmt->close();
mysqli_close($conn);
?>