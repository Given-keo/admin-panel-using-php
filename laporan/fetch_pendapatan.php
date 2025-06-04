<?php
header('Content-Type: application/json');
include '../config/koneksi.php';

// Filter tanggal
$start_date = isset($_GET['start_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['start_date']) 
    ? mysqli_real_escape_string($conn, $_GET['start_date']) 
    : date('Y-m-01');
$end_date = isset($_GET['end_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['end_date']) 
    ? mysqli_real_escape_string($conn, $_GET['end_date']) 
    : date('Y-m-d');

// Validasi end_date
if (strtotime($end_date) < strtotime($start_date)) {
    $end_date = $start_date;
}

$where_clause = "WHERE p.payment_date BETWEEN '$start_date' AND '$end_date' AND p.payment_status = 'Lunas'";

// Ambil data pendapatan
$query = mysqli_query($conn, "SELECT pm.method_name, SUM(p.amount) as total_amount, COUNT(p.id) as transaction_count 
                              FROM payments p 
                              JOIN payment_methods pm ON p.payment_method_id = pm.id 
                              $where_clause 
                              GROUP BY pm.method_name");

$total_revenue = 0;
$method_stats = [];
$payment_data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $total_revenue += $row['total_amount'];
    $method_stats[$row['method_name']] = [
        'amount' => $row['total_amount'],
        'count' => $row['transaction_count']
    ];
    $payment_data[] = [
        'method_name' => $row['method_name'],
        'total_amount' => $row['total_amount'],
        'transaction_count' => $row['transaction_count']
    ];
}

// Output JSON
echo json_encode([
    'total_revenue' => $total_revenue,
    'method_stats' => $method_stats,
    'payment_data' => $payment_data
]);

mysqli_close($conn);
?>