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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        if (file_exists('side_bar.php')) {
            include 'side_bar.php';
        } else {
            echo "<!-- Error: side_bar.php not found -->";
        }
        ?>
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
                    <h5 class="text-light font-weight-bold">Laporan Booking</h5>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
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
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
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
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="User Image">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="User Image">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="User Image">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="User Image">
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
                                <span class="mr-2 d-none text-light d-lg-inline small">Admin</span>
                                <img class="img-profile rounded-circle" src="../img/profile-img.png" alt="Admin Profile">
                            </a>
                            <!-- Dropdown - User Information -->
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

                    <!-- Laporan Booking -->
                    <?php
                    include '../config/koneksi.php';

                    // Filter tanggal
                    $start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : date('Y-m-01');
                    $end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($conn, $_GET['end_date']) : date('Y-m-d');
                    $where_clause = "WHERE b.tanggal_booking BETWEEN '$start_date' AND '$end_date'";

                    // Ambil data booking
                    $query = mysqli_query($conn, "SELECT b.id_booking, b.nama_pemesan, b.tanggal_booking, g.nama_gunung, j.nama_jalur, b.status, 
                                                  b.jumlah_orang, b.nominal, p.nama_paket 
                                                  FROM booking b 
                                                  JOIN gunung g ON b.id_gunung = g.id 
                                                  JOIN jalur j ON b.id_jalur = j.id 
                                                  LEFT JOIN paket p ON b.id_paket = p.id 
                                                  $where_clause");

                    // Ambil data kuota untuk statistik
                    $kuota_query = mysqli_query($conn, "SELECT k.id_gunung, k.id_jalur, g.nama_gunung, j.nama_jalur, k.jumlah_kuota, 
                                                       (SELECT IFNULL(SUM(b2.jumlah_orang), 0) 
                                                        FROM booking b2 
                                                        WHERE b2.id_gunung = k.id_gunung 
                                                        AND b2.id_jalur = k.id_jalur 
                                                        AND b2.status = 'Confirmed' 
                                                        AND b2.is_entered = 1) as used 
                                                       FROM kuota k 
                                                       JOIN gunung g ON k.id_gunung = g.id 
                                                       JOIN jalur j ON k.id_jalur = j.id 
                                                       WHERE k.status = 1");

                    // Hitung statistik
                    $total_bookings = mysqli_num_rows($query);
                    $total_people = 0;
                    $total_revenue = 0;
                    $gunung_stats = [];
                    $kuota_stats = [];
                    while ($row = mysqli_fetch_assoc($query)) {
                        $total_people += $row['jumlah_orang'];
                        $total_revenue += $row['nominal'] ?? 0;
                        if (!isset($gunung_stats[$row['nama_gunung']])) {
                            $gunung_stats[$row['nama_gunung']] = ['count' => 0, 'people' => 0];
                        }
                        $gunung_stats[$row['nama_gunung']]['count'] += 1;
                        $gunung_stats[$row['nama_gunung']]['people'] += $row['jumlah_orang'];
                    }
                    mysqli_data_seek($query, 0); // Reset pointer untuk digunakan kembali

                    // Proses data kuota
                    while ($row = mysqli_fetch_assoc($kuota_query)) {
                        $remaining = $row['jumlah_kuota'] - $row['used'];
                        $kuota_stats[] = [
                            'nama_gunung' => $row['nama_gunung'],
                            'nama_jalur' => $row['nama_jalur'],
                            'remaining' => $remaining
                        ];
                    }
                    ?>

                    <!-- Filter Tanggal -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan Booking</h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" id="filterForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="start_date">Tanggal Awal</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo htmlspecialchars($start_date); ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end_date">Tanggal Akhir</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo htmlspecialchars($end_date); ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label> </label><br>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="generate/generate_booking.php?start_date=<?php echo htmlspecialchars($start_date); ?>&end_date=<?php echo htmlspecialchars($end_date); ?>" id="exportPdf" class="btn btn-success">Ekspor PDF</a>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Total Booking</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="total-bookings"><?php echo $total_bookings; ?> Booking</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Total Orang</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="total-people"><?php echo $total_people; ?> Orang</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Total Pendapatan</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="total-revenue">Rp <?php echo number_format($total_revenue, 0, ',', '.'); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Per Gunung</h6>
                                </div>
                                <div class="card-body gunung-stats">
                                    <?php foreach ($gunung_stats as $gunung => $stats) : ?>
                                        <p><?php echo htmlspecialchars($gunung); ?>: <?php echo $stats['count']; ?> booking, <?php echo $stats['people']; ?> orang</p>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Sisa Kuota Per Jalur</h6>
                                </div>
                                <div class="card-body kuota-stats">
                                    <?php foreach ($kuota_stats as $kuota) : ?>
                                        <p><?php echo htmlspecialchars($kuota['nama_gunung']); ?> (<?php echo htmlspecialchars($kuota['nama_jalur']); ?>): <?php echo htmlspecialchars($kuota['remaining']); ?> slot</p>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Booking -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Booking</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="bg-primary text-light text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pemesan</th>
                                            <th>Tanggal Booking</th>
                                            <th>Gunung</th>
                                            <th>Jalur</th>
                                            <th>Jumlah Orang</th>
                                            <th>Paket</th>
                                            <th>Nominal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo htmlspecialchars($row['nama_pemesan']); ?></td>
                                                <td><?php echo htmlspecialchars($row['tanggal_booking']); ?></td>
                                                <td><?php echo htmlspecialchars($row['nama_gunung']); ?></td>
                                                <td><?php echo htmlspecialchars($row['nama_jalur']); ?></td>
                                                <td><?php echo htmlspecialchars($row['jumlah_orang']); ?></td>
                                                <td><?php echo htmlspecialchars($row['nama_paket'] ?? 'Tidak ada paket'); ?></td>
                                                <td>Rp <?php echo number_format($row['nominal'] ?? 0, 0, ',', '.'); ?></td>
                                                <td>
                                                    <?php if ($row['status'] == 'Confirmed') : ?>
                                                        <span class="badge badge-success">Confirmed</span>
                                                    <?php elseif ($row['status'] == 'Pending') : ?>
                                                        <span class="badge badge-warning">Pending</span>
                                                    <?php else : ?>
                                                        <span class="badge badge-danger">Canceled</span>
                                                    <?php endif; ?>
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

            <!-- Footer -->
            <?php
            if (file_exists('footer.php')) {
                include 'footer.php';
            } else {
                echo "<!-- Error: footer.php not found -->";
            }
            ?>
            <!-- End of Footer -->

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
                        <span aria-hidden="true">&times;</span>
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
        $(document).ready(function() {
            $('#dataTable').DataTable();

            function updateReport() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();

                // Perbarui URL tombol Ekspor PDF
                $('#exportPdf').attr('href', 'generate/generate_booking.php?start_date=' + encodeURIComponent(startDate) + '&end_date=' + encodeURIComponent(endDate));

                $.ajax({
                    url: 'fetch_booking.php',
                    method: 'GET',
                    data: { start_date: startDate, end_date: endDate },
                    dataType: 'json',
                    success: function(data) {
                        $('.total-bookings').text(data.total_bookings + ' Booking');
                        $('.total-people').text(data.total_people + ' Orang');
                        $('.total-revenue').text('Rp ' + data.total_revenue.toLocaleString());

                        let gunungStatsHtml = '';
                        for (let gunung in data.gunung_stats) {
                            gunungStatsHtml += `<p>${gunung}: ${data.gunung_stats[gunung].count} booking, ${data.gunung_stats[gunung].people} orang</p>`;
                        }
                        $('.gunung-stats').html(gunungStatsHtml);

                        let kuotaStatsHtml = '';
                        data.kuota_stats.forEach(row => {
                            kuotaStatsHtml += `<p>${row.nama_gunung} (${row.nama_jalur}): ${row.remaining} slot</p>`;
                        });
                        $('.kuota-stats').html(kuotaStatsHtml);

                        let bookingTableHtml = '';
                        data.booking_data.forEach((row, index) => {
                            let statusBadge = row.status === 'Confirmed' ? '<span class="badge badge-success">Confirmed</span>' :
                                              row.status === 'Pending' ? '<span class="badge badge-warning">Pending</span>' :
                                              '<span class="badge badge-danger">Canceled</span>';
                            bookingTableHtml += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${row.nama_pemesan}</td>
                                    <td>${row.tanggal_booking}</td>
                                    <td>${row.nama_gunung}</td>
                                    <td>${row.nama_jalur}</td>
                                    <td>${row.jumlah_orang}</td>
                                    <td>${row.nama_paket || 'Tidak ada paket'}</td>
                                    <td>Rp ${parseInt(row.nominal || 0).toLocaleString()}</td>
                                    <td>${statusBadge}</td>
                                </tr>`;
                        });
                        $('#dataTable tbody').html(bookingTableHtml);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching booking data:', error);
                    }
                });
            }

            // Panggil updateReport saat halaman dimuat
            updateReport();

            // Tangani submit form filter
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                updateReport();
            });

            // Perbarui secara periodik setiap 10 detik
            setInterval(updateReport, 10000);
        });
    </script>

</body>

</html>