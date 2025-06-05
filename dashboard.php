<?php 
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['level'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard | Sistem Manajemen Booking Gunung</title>

    <!-- Font & Style -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet"/>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "side_bar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column bg-gradient-light">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-dark bg-primary topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h4 class="text-light">Dashboard Admin Panel</h4>
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle text-light" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none text-light d-lg-inline small"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                <img class="img-profile rounded-circle" src="img/profile-img.png">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Page Content -->
                <div class="container-fluid">

                    <?php
                    // Sertakan koneksi database
                    include 'config/koneksi.php';
                    if (!$conn) {
                        echo '<div class="alert alert-danger">Error: Koneksi database gagal.</div>';
                        exit;
                    }

                    // Atur zona waktu
                    date_default_timezone_set('Asia/Jakarta');
                    $today = date('Y-m-d');
                    $month = date('Y-m');

                    // Total Booking Hari Ini
                    $stmt_booking = $conn->prepare("SELECT COUNT(id_booking) as total FROM booking WHERE DATE(tanggal_booking) = ?");
                    $stmt_booking->bind_param("s", $today);
                    $stmt_booking->execute();
                    $total_booking = $stmt_booking->get_result()->fetch_assoc()['total'] ?? 0;
                    $stmt_booking->close();

                    // Total Wisatawan Bulan Ini
                    $stmt_wisatawan = $conn->prepare("SELECT SUM(jumlah_orang) as total FROM booking WHERE YEAR(tanggal_booking) = YEAR(?) AND MONTH(tanggal_booking) = MONTH(?)");
                    $stmt_wisatawan->bind_param("ss", $month, $month);
                    $stmt_wisatawan->execute();
                    $total_wisatawan = $stmt_wisatawan->get_result()->fetch_assoc()['total'] ?? 0;
                    $stmt_wisatawan->close();

                    // Total Pendapatan Bulan Ini
                    $stmt_pendapatan = $conn->prepare("SELECT SUM(nominal) as total FROM booking WHERE YEAR(tanggal_booking) = YEAR(?) AND MONTH(tanggal_booking) = MONTH(?)");
                    $stmt_pendapatan->bind_param("ss", $month, $month);
                    $stmt_pendapatan->execute();
                    $total_pendapatan = $stmt_pendapatan->get_result()->fetch_assoc()['total'] ?? 0;
                    $stmt_pendapatan->close();

                    // Total Kuota Digunakan Bulan Ini
                    $stmt_kuota = $conn->prepare("SELECT SUM(jumlah_orang) as total FROM booking WHERE status = 'Confirmed' AND is_entered = 1 AND YEAR(tanggal_booking) = YEAR(?) AND MONTH(tanggal_booking) = MONTH(?)");
                    $stmt_kuota->bind_param("ss", $month, $month);
                    $stmt_kuota->execute();
                    $total_kuota = $stmt_kuota->get_result()->fetch_assoc()['total'] ?? 0;
                    $stmt_kuota->close();

                    // Pendapatan Bulan Ini per Metode
                    $stmt_methods = $conn->prepare("SELECT pm.method_name, SUM(p.amount) as total_amount, COUNT(p.id) as transaction_count 
                                                    FROM payments p 
                                                    JOIN payment_methods pm ON p.payment_method_id = pm.id 
                                                    WHERE YEAR(p.payment_date) = YEAR(?) AND MONTH(p.payment_date) = MONTH(?) AND p.payment_status = 'Lunas' 
                                                    GROUP BY pm.method_name");
                    $stmt_methods->bind_param("ss", $month, $month);
                    $stmt_methods->execute();
                    $result_methods = $stmt_methods->get_result();
                    $method_data = [];
                    $total_revenue = 0;
                    $total_transactions = 0;
                    $chart_labels = [];
                    $chart_data = [];
                    $chart_colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'];
                    $color_index = 0;
                    while ($row = $result_methods->fetch_assoc()) {
                        $method_data[] = $row;
                        $total_revenue += (int)$row['total_amount'];
                        $total_transactions += (int)$row['transaction_count'];
                        $chart_labels[] = $row['method_name'];
                        $chart_data[] = $row['total_amount'];
                        $chart_colors[$color_index] = $chart_colors[$color_index % count($chart_colors)];
                        $color_index++;
                    }
                    $stmt_methods->close();

                    // Booking Terbaru
                    $stmt_latest = $conn->prepare("SELECT b.id_booking, b.nama_pemesan, g.nama_gunung, b.tanggal_booking, b.status 
                                                   FROM booking b 
                                                   JOIN gunung g ON b.id_gunung = g.id 
                                                   ORDER BY b.tanggal_booking DESC LIMIT 5");
                    $stmt_latest->execute();
                    $latest_bookings = $stmt_latest->get_result()->fetch_all(MYSQLI_ASSOC);
                    $stmt_latest->close();

                    // Notifikasi Kuota Hampir Penuh
                    $stmt_quota = $conn->prepare("SELECT g.nama_gunung, j.nama_jalur, k.jumlah_kuota, 
                                                 (SELECT IFNULL(SUM(b.jumlah_orang), 0) 
                                                  FROM booking b 
                                                  WHERE b.id_gunung = k.id_gunung 
                                                  AND b.id_jalur = k.id_jalur 
                                                  AND b.status = 'Confirmed' 
                                                  AND b.is_entered = 1) as used 
                                                  FROM kuota k 
                                                  JOIN gunung g ON k.id_gunung = g.id 
                                                  JOIN jalur j ON k.id_jalur = j.id 
                                                  WHERE k.status = 1");
                    $stmt_quota->execute();
                    $quota_alerts = [];
                    $result_quota = $stmt_quota->get_result();
                    while ($row = $result_quota->fetch_assoc()) {
                        $remaining = (int)$row['jumlah_kuota'] - (int)$row['used'];
                        if ($remaining <= 10 && $remaining >= 0) {
                            $quota_alerts[] = [
                                'gunung' => $row['nama_gunung'],
                                'jalur' => $row['nama_jalur'],
                                'remaining' => $remaining
                            ];
                        }
                    }
                    $stmt_quota->close();
                    ?>

                    <!-- Banner Welcome -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-primary text-white shadow">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="font-weight-bold">Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h5>
                                        <p class="mb-0">Kelola booking, pantau kuota, dan lihat laporan pendapatan dengan mudah.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Booking Terbaru -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Booking Terbaru</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th>No</th>
                                                    <th>ID Booking</th>
                                                    <th>Nama Pemesan</th>
                                                    <th>Gunung</th>
                                                    <th>Tanggal Booking</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($latest_bookings)): ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">Tidak ada booking terbaru.</td>
                                                </tr>
                                                <?php else: ?>
                                                <?php $no = 1; foreach ($latest_bookings as $booking): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($booking['id_booking']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['nama_pemesan']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['nama_gunung']); ?></td>
                                                    <td><?php echo date('d-m-Y', strtotime($booking['tanggal_booking'])); ?></td>
                                                    <td>
                                                        <span class="badge badge-<?php echo $booking['status'] == 'Confirmed' ? 'success' : 'warning'; ?>">
                                                            <?php echo htmlspecialchars($booking['status']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="laporan_booking.php?id=<?php echo $booking['id_booking']; ?>" class="btn btn-primary btn-sm">Detail</a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- /.container-fluid -->

            </div> <!-- End of Main Content -->

            <?php include "footer.php"; ?>

        </div> <!-- End of Content Wrapper -->
    </div> <!-- End of Page Wrapper -->

    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
                </div>
                <div class="modal-body">Pilih "Logout" untuk keluar dari sesi.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="proses-login/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        // Pie Chart untuk Pendapatan per Metode
        var ctx = document.getElementById('revenuePieChart').getContext('2d');
        var revenuePieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($chart_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($chart_data); ?>,
                    backgroundColor: <?php echo json_encode($chart_colors); ?>,
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.raw || 0;
                                return label + ': Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
<?php 
// Tutup koneksi database
if (isset($conn)) {
    mysqli_close($conn);
}
?>