<!-- Start laporan_kuota.php -->
<?php include '../config/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard | Booking Gunung</title>

    <!-- Font & Style -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <h5 class="text-light font-weight-bold">Laporan Kuota</h5>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">Alerts Center</h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">Message Center</h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle text-light" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none text-light d-lg-inline small"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                <img class="img-profile rounded-circle" src="../img/profile-img.png">
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

                    <!-- Laporan Kuota -->
                    <?php
                    include '../config/koneksi.php';

                    if (!$conn) {
                        die("Koneksi database gagal: " . mysqli_connect_error());
                    }

                    // Verifikasi struktur tabel
                    $check_column = mysqli_query($conn, "SHOW COLUMNS FROM booking LIKE 'jumlah_orang'");
                    if (mysqli_num_rows($check_column) == 0) {
                        $add_column = mysqli_query($conn, "ALTER TABLE booking ADD COLUMN jumlah_orang INT NOT NULL DEFAULT 1");
                        if ($add_column) {
                            mysqli_query($conn, "UPDATE booking SET jumlah_orang = 1 WHERE jumlah_orang IS NULL");
                        }
                    }

                    $check_entered_column = mysqli_query($conn, "SHOW COLUMNS FROM booking LIKE 'is_entered'");
                    if (mysqli_num_rows($check_entered_column) == 0) {
                        $add_entered_column = mysqli_query($conn, "ALTER TABLE booking ADD COLUMN is_entered TINYINT(1) NOT NULL DEFAULT 0");
                    }

                    // Filter tanggal
                    $start_date = isset($_GET['start_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['start_date']) 
                        ? mysqli_real_escape_string($conn, $_GET['start_date']) 
                        : date('Y-m-01');
                    $end_date = isset($_GET['end_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['end_date']) 
                        ? mysqli_real_escape_string($conn, $_GET['end_date']) 
                        : date('Y-m-d');
                    if (strtotime($end_date) < strtotime($start_date)) {
                        $end_date = $start_date;
                    }

                    // Ambil data kuota
                    $query = mysqli_query($conn, "SELECT k.id, g.nama_gunung, j.nama_jalur, k.jumlah_kuota, 
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
                    if (!$query) {
                        die("Query gagal: " . mysqli_error($conn));
                    }

                    // Hitung statistik
                    $total_kuota = 0;
                    $total_used = 0;
                    $gunung_stats = [];
                    $kuota_data = [];
                    while ($row = mysqli_fetch_assoc($query)) {
                        $total_kuota += (int)$row['jumlah_kuota'];
                        $row['used'] = (int)($row['used'] ?? 0);
                        $total_used += $row['used'];
                        $gunung_stats[$row['nama_gunung']] = ($gunung_stats[$row['nama_gunung']] ?? 0) + $row['used'];
                        $row['remaining'] = $row['jumlah_kuota'] - $row['used'];
                        $kuota_data[] = $row;
                    }
                    ?>

                    <!-- Filter Tanggal -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Generate Laporan Kuota to PDF</h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" id="filterForm">
                                <div class="row">
                                  
                                    <div class="col-md-4">
                                      
                                        <a href="generate/generate_kuota.php?start_date=<?= htmlspecialchars($start_date) ?>&end_date=<?= htmlspecialchars($end_date) ?>" id="exportPdf" class="btn btn-success">Ekspor PDF</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Statistik -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Total Kuota Tersedia</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="total-kuota"><?= $total_kuota; ?> Slot</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Total Kuota Digunakan</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="total-used"><?= $total_used; ?> Slot</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Penggunaan Per Gunung</h6>
                                </div>
                                <div class="card-body gunung-stats">
                                    <?php foreach ($gunung_stats as $gunung => $used) : ?>
                                        <p><?= htmlspecialchars($gunung) ?>: <?= $used ?> slot</p>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Kuota -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Kuota</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="bg-primary text-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Gunung</th>
                                            <th>Jalur</th>
                                            <th>Kuota Tersedia</th>
                                            <th>Kuota Digunakan</th>
                                            <th>Kuota Sisa</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php
                                        $no = 1;
                                        foreach ($kuota_data as $row) {
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= htmlspecialchars($row['nama_gunung']); ?></td>
                                                <td><?= htmlspecialchars($row['nama_jalur']); ?></td>
                                                <td><?= (int)$row['jumlah_kuota']; ?></td>
                                                <td><?= (int)$row['used']; ?></td>
                                                <td class="<?= $row['remaining'] <= 0 ? 'text-danger' : '' ?>">
                                                    <?= (int)$row['remaining']; ?>
                                                    <?php if ($row['remaining'] <= 0) echo '<span>(Penuh)</span>'; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div> <!-- /.container-fluid -->

            </div> <!-- End of Main Content -->

            <?php include "footer.php"; ?>

        </div> <!-- End of Content Wrapper -->
    </div> <!-- End of Page Wrapper -->

    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" untuk keluar dari sesi.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../proses-login/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "destroy": true
        });

        function updateReport() {
            const startDate = $('#start_date').val();
            const endDate = $('#end_date').val();

            // Perbarui URL tombol Ekspor PDF
            $('#exportPdf').attr('href', 'generate/generate_kuota.php?start_date=' + encodeURIComponent(startDate) + '&end_date=' + encodeURIComponent(endDate));

            // AJAX untuk memperbarui data
            $.ajax({
                url: 'fetch_quota.php',
                method: 'GET',
                data: { start_date: startDate, end_date: endDate },
                dataType: 'json',
                success: function (data) {
                    $('.total-kuota').text(data.total_kuota + ' Slot');
                    $('.total-used').text(data.total_used + ' Slot');

                    let gunungStatsHtml = '';
                    for (let gunung in data.gunung_stats) {
                        gunungStatsHtml += `<p>${gunung}: ${data.gunung_stats[gunung]} slot</p>`;
                    }
                    $('.gunung-stats').html(gunungStatsHtml);

                    let quotaTableHtml = '';
                    data.kuota_data.forEach((row, index) => {
                        quotaTableHtml += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${row.nama_gunung}</td>
                                <td>${row.nama_jalur}</td>
                                <td>${row.jumlah_kuota}</td>
                                <td>${row.used}</td>
                                <td class="${row.remaining <= 0 ? 'text-danger' : ''}">
                                    ${row.remaining}
                                    ${row.remaining <= 0 ? '<span>(Penuh)</span>' : ''}
                                </td>
                            </tr>`;
                    });
                    $('#dataTable tbody').html(quotaTableHtml);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching quota data:', error);
                }
            });
        }

        // Panggil updateReport saat halaman dimuat
        updateReport();

        // Tangani submit form filter
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            updateReport();
        });

        // Refresh data setiap 10 detik
        setInterval(updateReport, 10000);
    });
    </script>

</body>

</html>
<!-- End laporan_kuota.php -->