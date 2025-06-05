<?php include '../config/auth.php';?>
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
        <h5 class="text-light font-weight-bold">Laporan Transaksi</h5>
          <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-secondary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form> -->

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

         <!-- Laporan Transaksi -->
         <?php
         include '../config/koneksi.php';

         // Filter tanggal
         $start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : date('Y-m-01');
         $end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($conn, $_GET['end_date']) : date('Y-m-d');
         $where_clause = "WHERE p.payment_date BETWEEN '$start_date' AND '$end_date'";

         // Ambil data transaksi
         $query = mysqli_query($conn, "SELECT p.id, p.booking_id, b.nama_pemesan, p.payment_date, p.amount, pm.method_name, p.payment_status 
                                       FROM payments p 
                                       JOIN booking b ON p.booking_id = b.id_booking 
                                       JOIN payment_methods pm ON p.payment_method_id = pm.id 
                                       $where_clause");

         // Hitung statistik
         $total_transactions = mysqli_num_rows($query);
         $total_amount = 0;
         $method_stats = [];
         while ($row = mysqli_fetch_assoc($query)) {
             $total_amount += $row['amount'];
             $method_stats[$row['method_name']] = ($method_stats[$row['method_name']] ?? 0) + 1;
         }
         mysqli_data_seek($query, 0); // Reset pointer untuk digunakan kembali
         ?>

         <!-- Filter Tanggal -->
         <div class="card shadow mb-4">
             <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Filter Laporan Transaksi</h6>
             </div>
             <div class="card-body">
                 <form method="GET">
                     <div class="row">
                         <div class="col-md-4">
                             <label>Tanggal Awal</label>
                             <input type="date" name="start_date" class="form-control" value="<?= $start_date ?>" required>
                         </div>
                         <div class="col-md-4">
                             <label>Tanggal Akhir</label>
                             <input type="date" name="end_date" class="form-control" value="<?= $end_date ?>" required>
                         </div>
                         <div class="col-md-4">
                             <label> </label><br>
                             <button type="submit" class="btn btn-primary">Filter</button>
                             <a href="generate/generate_transaksi.php?start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn btn-success">Ekspor PDF</a>
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
                         <h6 class="m-0 font-weight-bold text-primary">Total Transaksi</h6>
                     </div>
                     <div class="card-body">
                         <h4><?= $total_transactions; ?> Transaksi</h4>
                     </div>
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="card shadow mb-4">
                     <div class="card-header py-3">
                         <h6 class="m-0 font-weight-bold text-primary">Total Pendapatan</h6>
                     </div>
                     <div class="card-body">
                         <h4>Rp <?= number_format($total_amount, 0, ',', '.'); ?></h4>
                     </div>
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="card shadow mb-4">
                     <div class="card-header py-3">
                         <h6 class="m-0 font-weight-bold text-primary">Per Metode Pembayaran</h6>
                     </div>
                     <div class="card-body">
                         <?php foreach ($method_stats as $method => $count) : ?>
                             <p><?= $method ?>: <?= $count ?> transaksi</p>
                         <?php endforeach; ?>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Daftar Transaksi -->
         <div class="card shadow mb-4">
             <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
             </div>
             <div class="card-body">
                 <div class="table-responsive">
                     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                         <thead class="bg-primary text-light text-center">
                             <tr>
                                 <th>No</th>
                                 <th>Nama Pemesan</th>
                                 <th>Tanggal Pembayaran</th>
                                 <th>Nominal</th>
                                 <th>Metode Pembayaran</th>
                                 <th>Status</th>
                             </tr>
                         </thead>
                         <tbody class="text-center">
                             <?php
                             $no = 1;
                             while ($row = mysqli_fetch_assoc($query)) {
                             ?>
                                 <tr>
                                     <td><?= $no++; ?></td>
                                     <td><?= htmlspecialchars($row['nama_pemesan']); ?></td>
                                     <td><?= htmlspecialchars($row['payment_date']); ?></td>
                                     <td>Rp <?= number_format($row['amount'], 0, ',', '.'); ?></td>
                                     <td><?= htmlspecialchars($row['method_name']); ?></td>
                                     <td>
                                         <?php if ($row['payment_status'] == 'Lunas') : ?>
                                             <span class="badge badge-success">Lunas</span>
                                         <?php elseif ($row['payment_status'] == 'Belum Lunas') : ?>
                                             <span class="badge badge-danger">Belum Lunas</span>
                                         <?php else : ?>
                                             <span class="badge badge-warning">Pending</span>
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

      <?php include "footer.php"; ?>

    </div> <!-- End of Content Wrapper -->
  </div> <!-- End of Page Wrapper -->

  <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

  <!-- Logout Modal-->
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

  <script>
  $(document).ready(function () {
    $('#dataTable').DataTable();

    $('#id_paket').change(function () {
      var id = $(this).val();
      var harga = $(this).find(':selected').data('harga');
      if (id) {
        $('#harga_paket_view').val('Rp ' + parseInt(harga).toLocaleString());
        $('#harga_paket').val(harga); // yang ini akan dikirim ke server
      } else {
        $('#harga_paket_view').val('');
        $('#harga_paket').val('');
      }
    });
  });
  </script>

</body>

</html>