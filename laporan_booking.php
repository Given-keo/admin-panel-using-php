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
    <title>Detail Booking | Sistem Manajemen Booking Gunung</title>

    <!-- Font & Style -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet"/>
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
                    <h4 class="text-light">Detail Booking</h4>
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

                    // Validasi id_booking
                    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                        echo '<div class="alert alert-danger">Error: ID Booking tidak valid.</div>';
                        echo '<a href="dashboard.php" class="btn btn-primary mt-3">Kembali ke Dashboard</a>';
                        exit;
                    }
                    $id_booking = (int)$_GET['id'];

                    // Ambil detail booking
                    $stmt_booking = $conn->prepare("SELECT b.id_booking, b.nama_pemesan, b.tanggal_booking, b.status, b.jumlah_orang, b.nominal, 
                                                    g.nama_gunung, j.nama_jalur, k.jumlah_kuota, 
                                                    (SELECT IFNULL(SUM(b2.jumlah_orang), 0) 
                                                     FROM booking b2 
                                                     WHERE b2.id_gunung = b.id_gunung 
                                                     AND b2.id_jalur = b.id_jalur 
                                                     AND b2.status = 'Confirmed' 
                                                     AND b2.is_entered = 1) as kuota_digunakan 
                                                    FROM booking b 
                                                    JOIN gunung g ON b.id_gunung = g.id 
                                                    JOIN jalur j ON b.id_jalur = j.id 
                                                    JOIN kuota k ON k.id_gunung = b.id_gunung AND k.id_jalur = b.id_jalur 
                                                    WHERE b.id_booking = ?");
                    $stmt_booking->bind_param("i", $id_booking);
                    $stmt_booking->execute();
                    $result_booking = $stmt_booking->get_result();
                    $booking = $result_booking->fetch_assoc();
                    $stmt_booking->close();

                    if (!$booking) {
                        echo '<div class="alert alert-danger">Error: Booking tidak ditemukan.</div>';
                        echo '<a href="dashboard.php" class="btn btn-primary mt-3">Kembali ke Dashboard</a>';
                        exit;
                    }

                    // Ambil detail pembayaran
                    $stmt_payment = $conn->prepare("SELECT p.amount, p.payment_date, p.payment_status, pm.method_name 
                                                    FROM payments p 
                                                    JOIN payment_methods pm ON p.payment_method_id = pm.id 
                                                    WHERE p.booking_id = ?");
                    $stmt_payment->bind_param("i", $id_booking);
                    $stmt_payment->execute();
                    $payment = $stmt_payment->get_result()->fetch_assoc();
                    $stmt_payment->close();
                    ?>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Booking</li>
                        </ol>
                    </nav>

                    <!-- Detail Booking -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3 bg-primary text-white">
                                    <h6 class="m-0 font-weight-bold">Detail Booking (ID: <?php echo htmlspecialchars($booking['id_booking']); ?>)</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="font-weight-bold text-primary">Informasi Pemesan</h6>
                                            <dl class="row mb-0">
                                                <dt class="col-sm-4">Nama Pemesan</dt>
                                                <dd class="col-sm-8"><?php echo htmlspecialchars($booking['nama_pemesan']); ?></dd>
                                                <dt class="col-sm-4">Jumlah Orang</dt>
                                                <dd class="col-sm-8"><?php echo $booking['jumlah_orang']; ?> Orang</dd>
                                                <dt class="col-sm-4">Tanggal Booking</dt>
                                                <dd class="col-sm-8"><?php echo date('d-m-Y', strtotime($booking['tanggal_booking'])); ?></dd>
                                                <dt class="col-sm-4">Status</dt>
                                                <dd class="col-sm-8">
                                                    <span class="badge badge-<?php echo $booking['status'] == 'Confirmed' ? 'success' : 'warning'; ?>">
                                                        <?php echo htmlspecialchars($booking['status']); ?>
                                                    </span>
                                                </dd>
                                                <dt class="col-sm-4">Total Nominal</dt>
                                                <dd class="col-sm-8">Rp <?php echo number_format($booking['nominal'], 0, ',', '.'); ?></dd>
                                            </dl>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="font-weight-bold text-primary">Informasi Gunung dan Jalur</h6>
                                            <dl class="row mb-0">
                                                <dt class="col-sm-4">Gunung</dt>
                                                <dd class="col-sm-8"><?php echo htmlspecialchars($booking['nama_gunung']); ?></dd>
                                                <dt class="col-sm-4">Jalur</dt>
                                                <dd class="col-sm-8"><?php echo htmlspecialchars($booking['nama_jalur']); ?></dd>
                                                <dt class="col-sm-4">Kuota Tersedia</dt>
                                                <dd class="col-sm-8"><?php echo $booking['jumlah_kuota']; ?> Slot</dd>
                                                <dt class="col-sm-4">Kuota Digunakan</dt>
                                                <dd class="col-sm-8"><?php echo $booking['kuota_digunakan']; ?> Slot</dd>
                                                <dt class="col-sm-4">Kuota Sisa</dt>
                                                <dd class="col-sm-8">
                                                    <?php
                                                    $sisa = $booking['jumlah_kuota'] - $booking['kuota_digunakan'];
                                                    echo $sisa >= 0 ? $sisa : '<span class="badge badge-danger">Penuh</span>';
                                                    ?>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pembayaran -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3 bg-warning text-white">
                                    <h6 class="m-0 font-weight-bold">Detail Pembayaran</h6>
                                </div>
                                <div class="card-body">
                                    <?php if ($payment): ?>
                                    <dl class="row mb-0">
                                        <dt class="col-sm-3">Metode Pembayaran</dt>
                                        <dd class="col-sm-9"><?php echo htmlspecialchars($payment['method_name']); ?></dd>
                                        <dt class="col-sm-3">Jumlah</dt>
                                        <dd class="col-sm-9">Rp <?php echo number_format($payment['amount'], 0, ',', '.'); ?></dd>
                                        <dt class="col-sm-3">Tanggal Pembayaran</dt>
                                        <dd class="col-sm-9"><?php echo date('d-m-Y H:i:s', strtotime($payment['payment_date'])); ?></dd>
                                        <dt class="col-sm-3">Status Pembayaran</dt>
                                        <dd class="col-sm-9">
                                            <span class="badge badge-<?php echo $payment['payment_status'] == 'Lunas' ? 'success' : 'warning'; ?>">
                                                <?php echo htmlspecialchars($payment['payment_status']); ?>
                                            </span>
                                        </dd>
                                    </dl>
                                    <?php else: ?>
                                    <p class="text-center">Tidak ada data pembayaran untuk booking ini.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aksi -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 mb-4">
                            <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
                            <?php if ($booking['status'] != 'Confirmed'): ?>
                            <form action="proses_update_status.php" method="POST" class="d-inline">
                                <input type="hidden" name="id_booking" value="<?php echo $booking['id_booking']; ?>">
                                <button type="submit" name="confirm_booking" class="btn btn-success"><i class="fas fa-check"></i> Konfirmasi Booking</button>
                            </form>
                            <?php endif; ?>
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
</body>
</html>
<?php 
// Tutup koneksi database
if (isset($conn)) {
    mysqli_close($conn);
}
?>