<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Atur zona waktu ke Asia/Jakarta (WIB)
date_default_timezone_set('Asia/Jakarta');

// Sertakan koneksi database
include '../../config/koneksi.php';
if (!$conn) {
    echo "<script>alert('Error: Koneksi database gagal.'); window.location.href='../laporan_pendapatan.php';</script>";
    exit();
}

// Periksa autoloader Dompdf
if (!file_exists('../../vendor/autoload.php')) {
    echo "<script>alert('Error: Autoloader Dompdf tidak ditemukan. Silakan instal Dompdf menggunakan Composer (jalankan: composer require dompdf/dompdf di direktori proyek).'); window.location.href='../laporan_pendapatan.php';</script>";
    exit();
}

// Sertakan library Dompdf
require_once '../../vendor/autoload.php';
use Dompdf\Dompdf;

// Periksa kelas Dompdf
if (!class_exists('Dompdf\Dompdf')) {
    echo "<script>alert('Error: Kelas Dompdf tidak ditemukan. Pastikan Dompdf terinstal dengan benar menggunakan Composer.'); window.location.href='../laporan_pendapatan.php';</script>";
    exit();
}

// Tentukan path logo
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

// Ambil data pendapatan per metode menggunakan prepared statement
$query = "SELECT pm.method_name, SUM(p.amount) as total_amount, COUNT(p.id) as transaction_count 
          FROM payments p 
          JOIN payment_methods pm ON p.payment_method_id = pm.id 
          WHERE p.payment_date BETWEEN ? AND ? AND p.payment_status = 'Lunas' 
          GROUP BY pm.method_name";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo "<script>alert('Error: Gagal menyiapkan query database.'); window.location.href='../laporan_pendapatan.php';</script>";
    exit();
}
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

// Kumpulkan data dan hitung statistik
$total_revenue = 0;
$total_transactions = 0;
$method_stats = [];
$method_data = [];
while ($row = $result->fetch_assoc()) {
    $total_revenue += (int)$row['total_amount'];
    $total_transactions += (int)$row['transaction_count'];
    $method_stats[$row['method_name']] = [
        'amount' => (int)$row['total_amount'],
        'count' => (int)$row['transaction_count']
    ];
    $method_data[] = $row;
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
    <title>Laporan Pendapatan per Metode Pembayaran</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 30px; 
            color: #333; 
        }
        .container { 
            width: 90%; 
            max-width: 800px; 
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
            text-align: center; 
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
        .footer { 
            text-align: center; 
            margin-top: 30px; 
            border-top: 1px solid #ccc; 
            padding-top: 10px; 
            font-size: 10px; 
            color: #777; 
        }
        .no-column { width: 10%; }
        .method-column { width: 40%; }
        .amount-column { width: 30%; }
        .count-column { width: 20%; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">';
if ($image_path) {
    $html .= '<img src="' . $image_path . '" alt="Logo">';
}
$html .= '
            <h1>Laporan Pendapatan per Metode Pembayaran</h1>
            <p>Periode: ' . htmlspecialchars($formatted_start_date) . ' s.d. ' . htmlspecialchars($formatted_end_date) . '</p>
            <p>Tanggal Cetak: ' . htmlspecialchars($print_date) . '</p>
        </div>

        <div class="stats">
            <p>Total Pendapatan: Rp ' . number_format($total_revenue, 0, ',', '.') . '</p>
            <p>Total Transaksi: ' . $total_transactions . ' Transaksi</p>
            <p>Pendapatan per Metode Pembayaran:</p>';
foreach ($method_stats as $method => $data) {
    $html .= '<p>' . htmlspecialchars($method) . ': Rp ' . number_format($data['amount'], 0, ',', '.') . ' (' . $data['count'] . ' transaksi)</p>';
}
$html .= '
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th class="no-column">No</th>
                    <th class="method-column">Metode Pembayaran</th>
                    <th class="amount-column">Total Pendapatan</th>
                    <th class="count-column">Jumlah Transaksi</th>
                </tr>
            </thead>
            <tbody>';
if (empty($method_data)) {
    $html .= '<tr><td colspan="4" style="text-align: center; padding: 15px;">Tidak ada transaksi ditemukan untuk periode ini.</td></tr>';
} else {
    $no = 1;
    foreach ($method_data as $row) {
        $html .= '
                <tr>
                    <td class="no-column">' . $no++ . '</td>
                    <td class="method-column">' . htmlspecialchars($row['method_name']) . '</td>
                    <td class="amount-column">Rp ' . number_format((int)$row['total_amount'], 0, ',', '.') . '</td>
                    <td class="count-column">' . (int)$row['transaction_count'] . '</td>
                </tr>';
    }
    // Baris total
    $html .= '
                <tr class="total-row">
                    <td colspan="2" style="text-align: center;">Total:</td>
                    <td>Rp ' . number_format($total_revenue, 0, ',', '.') . '</td>
                    <td>' . $total_transactions . '</td>
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
$options->set('isRemoteEnabled', true);
$options->set('chroot', realpath(__DIR__ . '/../../'));
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);

// Muat konten HTML
$dompdf->loadHtml($html);

// Atur ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'portrait');

// Render HTML menjadi PDF
$dompdf->render();

// Keluarkan PDF ke browser
$dompdf->stream('Laporan_Pendapatan_' . $start_date . '_' . $end_date . '.pdf', ['Attachment' => true]);

// Tutup koneksi
$stmt->close();
mysqli_close($conn);
?>