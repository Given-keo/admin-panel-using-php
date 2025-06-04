<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Atur zona waktu ke Asia/Jakarta (WIB)
date_default_timezone_set('Asia/Jakarta');

// Sertakan koneksi database
include '../../config/koneksi.php';
if (!$conn) {
    echo "<script>alert('Error: Koneksi database gagal.'); window.location.href='../laporan_kuota.php';</script>";
    exit();
}

// Periksa autoloader Dompdf
if (!file_exists('../../vendor/autoload.php')) {
    echo "<script>alert('Error: Autoloader Dompdf tidak ditemukan. Silakan instal Dompdf menggunakan Composer (jalankan: composer require dompdf/dompdf di direktori proyek).'); window.location.href='../laporan_kuota.php';</script>";
    exit();
}

// Sertakan library Dompdf
require_once '../../vendor/autoload.php';
use Dompdf\Dompdf;

// Periksa kelas Dompdf
if (!class_exists('Dompdf\Dompdf')) {
    echo "<script>alert('Error: Kelas Dompdf tidak ditemukan. Pastikan Dompdf terinstal dengan benar menggunakan Composer.'); window.location.href='../laporan_kuota.php';</script>";
    exit();
}

// Tentukan path logo
$image_path = realpath(__DIR__ . '/../../img/img-login.jpg');
if (!$image_path || !file_exists($image_path)) {
    $image_path = '';
} else {
    $image_path = 'file://' . $image_path;
}

// Ambil filter tanggal (meskipun tidak digunakan dalam query, untuk konsistensi UI)
$start_date = isset($_GET['start_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['start_date']) 
    ? mysqli_real_escape_string($conn, $_GET['start_date']) 
    : date('Y-m-01');
$end_date = isset($_GET['end_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['end_date']) 
    ? mysqli_real_escape_string($conn, $_GET['end_date']) 
    : date('Y-m-d');
if (strtotime($end_date) < strtotime($start_date)) {
    $end_date = $start_date;
}

// Ambil data kuota menggunakan prepared statement untuk subquery
$query = "SELECT k.id, g.nama_gunung, j.nama_jalur, k.jumlah_kuota, 
                 (SELECT IFNULL(SUM(b.jumlah_orang), 0) 
                  FROM booking b 
                  WHERE b.id_gunung = k.id_gunung 
                  AND b.id_jalur = k.id_jalur 
                  AND b.status = 'Confirmed' 
                  AND b.is_entered = 1) as used 
          FROM kuota k 
          JOIN gunung g ON k.id_gunung = g.id 
          JOIN jalur j ON k.id_jalur = j.id 
          WHERE k.status = 1";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo "<script>alert('Error: Query gagal: " . addslashes(mysqli_error($conn)) . "'); window.location.href='../laporan_kuota.php';</script>";
    exit();
}

// Hitung statistik
$total_kuota = 0;
$total_used = 0;
$total_remaining = 0;
$gunung_stats = [];
$kuota_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $total_kuota += (int)$row['jumlah_kuota'];
    $row['used'] = (int)($row['used'] ?? 0);
    $total_used += $row['used'];
    $row['remaining'] = (int)$row['jumlah_kuota'] - $row['used'];
    $total_remaining += $row['remaining'];
    $gunung_stats[$row['nama_gunung']] = ($gunung_stats[$row['nama_gunung']] ?? 0) + $row['used'];
    $kuota_data[] = $row;
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
    <title>Laporan Kuota</title>
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
        .status-penuh { 
            display: inline-block; 
            padding: 4px 8px; 
            border-radius: 4px; 
            background-color: #e74a3b; 
            color: white; 
            font-size: 11px; 
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
        .gunung-column { width: 25%; }
        .jalur-column { width: 25%; }
        .kuota-column { width: 15%; }
        .used-column { width: 15%; }
        .remaining-column { width: 10%; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">';
if ($image_path) {
    $html .= '<img src="' . $image_path . '" alt="Logo">';
}
$html .= '
            <h1>Laporan Kuota</h1>
            <p>Periode: ' . htmlspecialchars($formatted_start_date) . ' s.d. ' . htmlspecialchars($formatted_end_date) . '</p>
            <p>Tanggal Cetak: ' . htmlspecialchars($print_date) . '</p>
        </div>

        <div class="stats">
            <p>Total Kuota Tersedia: ' . $total_kuota . ' Slot</p>
            <p>Total Kuota Digunakan: ' . $total_used . ' Slot</p>
            <p>Total Kuota Sisa: ' . $total_remaining . ' Slot</p>
            <p>Penggunaan per Gunung:</p>';
foreach ($gunung_stats as $gunung => $used) {
    $html .= '<p>' . htmlspecialchars($gunung) . ': ' . $used . ' slot</p>';
}
$html .= '
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th class="no-column">No</th>
                    <th class="gunung-column">Gunung</th>
                    <th class="jalur-column">Jalur</th>
                    <th class="kuota-column">Kuota Tersedia</th>
                    <th class="used-column">Kuota Digunakan</th>
                    <th class="remaining-column">Kuota Sisa</th>
                </tr>
            </thead>
            <tbody>';
if (empty($kuota_data)) {
    $html .= '<tr><td colspan="6" style="text-align: center; padding: 15px;">Tidak ada data kuota ditemukan.</td></tr>';
} else {
    $no = 1;
    foreach ($kuota_data as $row) {
        $remaining_text = (int)$row['remaining'];
        if ($row['remaining'] <= 0) {
            $remaining_text = '<span class="status-penuh">Penuh</span>';
        }
        $html .= '
                <tr>
                    <td class="no-column">' . $no++ . '</td>
                    <td class="gunung-column">' . htmlspecialchars($row['nama_gunung']) . '</td>
                    <td class="jalur-column">' . htmlspecialchars($row['nama_jalur']) . '</td>
                    <td class="kuota-column">' . (int)$row['jumlah_kuota'] . '</td>
                    <td class="used-column">' . (int)$row['used'] . '</td>
                    <td class="remaining-column">' . $remaining_text . '</td>
                </tr>';
    }
    // Baris total
    $html .= '
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">Total:</td>
                    <td>' . $total_kuota . '</td>
                    <td>' . $total_used . '</td>
                    <td>' . $total_remaining . '</td>
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
$dompdf->stream('Laporan_Kuota_' . $start_date . '_' . $end_date . '.pdf', ['Attachment' => true]);

// Tutup koneksi
mysqli_close($conn);
?>