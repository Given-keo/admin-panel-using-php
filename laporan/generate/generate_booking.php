<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Atur zona waktu ke Asia/Jakarta (WIB)
date_default_timezone_set('Asia/Jakarta');

// Sertakan koneksi database
include '../../config/koneksi.php';
if (!$conn) {
    echo "<script>alert('Error: Koneksi database gagal.'); window.location.href='../laporan_booking.php';</script>";
    exit();
}

// Periksa apakah autoloader Dompdf ada
if (!file_exists('../../vendor/autoload.php')) {
    echo "<script>alert('Error: Autoloader Dompdf tidak ditemukan. Silakan instal Dompdf menggunakan Composer (jalankan: composer require dompdf/dompdf di direktori proyek).'); window.location.href='../laporan_booking.php';</script>";
    exit();
}

// Sertakan library Dompdf
require_once '../../vendor/autoload.php';

use Dompdf\Dompdf;

// Periksa apakah kelas Dompdf ada
if (!class_exists('Dompdf\Dompdf')) {
    echo "<script>alert('Error: Kelas Dompdf tidak ditemukan. Pastikan Dompdf terinstal dengan benar menggunakan Composer.'); window.location.href='../laporan_booking.php';</script>";
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
$where_clause = "WHERE b.tanggal_booking BETWEEN ? AND ?";

// Ambil data booking menggunakan prepared statement
$query = "SELECT b.id_booking, b.nama_pemesan, b.tanggal_booking, g.nama_gunung, j.nama_jalur, b.status, 
                 b.jumlah_orang, b.nominal, p.nama_paket 
          FROM booking b 
          JOIN gunung g ON b.id_gunung = g.id 
          JOIN jalur j ON b.id_jalur = j.id 
          LEFT JOIN paket p ON b.id_paket = p.id 
          $where_clause";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo "<script>alert('Error: Gagal menyiapkan query database.'); window.location.href='../laporan_booking.php';</script>";
    exit();
}
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

// Kumpulkan data dan hitung statistik
$total_bookings = $result->num_rows;
$total_people = 0;
$total_revenue = 0;
$booking_data = [];
while ($row = $result->fetch_assoc()) {
    $total_people += (int)$row['jumlah_orang'];
    $total_revenue += (int)($row['nominal'] ?? 0);
    $booking_data[] = $row;
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
    <title>Laporan Booking</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 30px; 
            color: #333; 
        }
        .container { 
            width: 90%; 
            max-width: 1000px; 
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
        .status-confirmed, .status-pending, .status-canceled { 
            display: inline-block; 
            padding: 4px 8px; 
            border-radius: 4px; 
            color: white; 
            font-size: 11px; 
            text-align: center; 
            min-width: 80px; 
        }
        .status-confirmed { 
            background-color: #1cc88a; 
        }
        .status-pending { 
            background-color: #f6c23e; 
            color: #333; 
        }
        .status-canceled { 
            background-color: #e74a3b; 
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
        .nama-column { width: 15%; }
        .tanggal-column { width: 10%; }
        .gunung-column { width: 10%; }
        .jalur-column { width: 10%; }
        .jumlah-column { width: 10%; text-align: center; }
        .paket-column { width: 15%; }
        .nominal-column { width: 15%; }
        .status-column { width: 10%; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">';
if ($image_path) {
    $html .= '<img src="' . $image_path . '" alt="Logo">';
}
$html .= '
            <h1>Laporan Booking</h1>
            <p>Periode: ' . htmlspecialchars($formatted_start_date) . ' s.d. ' . htmlspecialchars($formatted_end_date) . '</p>
            <p>Tanggal Cetak: ' . htmlspecialchars($print_date) . '</p>
        </div>

        <div class="stats">
            <p>Total Booking: ' . $total_bookings . ' Booking</p>
            <p>Total Jumlah Orang: ' . $total_people . ' Orang</p>
            <p>Total Pendapatan: Rp ' . number_format($total_revenue, 0, ',', '.') . '</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th class="no-column">No</th>
                    <th class="nama-column">Nama Pemesan</th>
                    <th class="tanggal-column">Tanggal Booking</th>
                    <th class="gunung-column">Gunung</th>
                    <th class="jalur-column">Jalur</th>
                    <th class="jumlah-column">Jumlah Orang</th>
                    <th class="paket-column">Paket</th>
                    <th class="nominal-column">Nominal</th>
                    <th class="status-column">Status</th>
                </tr>
            </thead>
            <tbody>';
if (empty($booking_data)) {
    $html .= '<tr><td colspan="9" style="text-align: center; padding: 15px;">Tidak ada booking ditemukan untuk periode ini.</td></tr>';
} else {
    $no = 1;
    foreach ($booking_data as $row) {
        $status_class = '';
        if ($row['status'] == 'Confirmed') {
            $status_class = 'status-confirmed';
        } elseif ($row['status'] == 'Pending') {
            $status_class = 'status-pending';
        } else {
            $status_class = 'status-canceled';
        }
        $html .= '
                <tr>
                    <td class="no-column">' . $no++ . '</td>
                    <td class="nama-column">' . htmlspecialchars($row['nama_pemesan']) . '</td>
                    <td class="tanggal-column">' . htmlspecialchars(date('d-m-Y', strtotime($row['tanggal_booking']))) . '</td>
                    <td class="gunung-column">' . htmlspecialchars($row['nama_gunung']) . '</td>
                    <td class="jalur-column">' . htmlspecialchars($row['nama_jalur']) . '</td>
                    <td class="jumlah-column">' . (int)$row['jumlah_orang'] . '</td>
                    <td class="paket-column">' . htmlspecialchars($row['nama_paket'] ?? 'Tidak ada paket') . '</td>
                    <td class="nominal-column">Rp ' . number_format((int)($row['nominal'] ?? 0), 0, ',', '.') . '</td>
                    <td class="status-column"><span class="' . $status_class . '">' . htmlspecialchars($row['status']) . '</span></td>
                </tr>';
    }
    // Baris total
    $html .= '
                <tr class="total-row">
                    <td colspan="5" style="text-align: right;">Total:</td>
                    <td class="jumlah-column">' . $total_people . '</td>
                    <td colspan="3" style="text-align: center;">Rp ' . number_format($total_revenue, 0, ',', '.') . '</td>

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
$dompdf->setPaper('A4', 'landscape');

// Render HTML menjadi PDF
$dompdf->render();

// Keluarkan PDF ke browser
$filename = "Laporan_Booking_" . $start_date . "_" . $end_date . ".pdf";
$dompdf->stream($filename, array("Attachment" => true));

// Tutup koneksi database
$stmt->close();
mysqli_close($conn);
?>