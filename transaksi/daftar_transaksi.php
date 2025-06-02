<?php include '../config/auth.php';?>
<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi database
include '../config/koneksi.php';
if (!$conn) {
  die("Koneksi database gagal: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>List-Booking | Booking Gunung</title>

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
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-dark bg-primary topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <!-- Search Bar -->
          <h5 class="text-light font-weight-bold">Daftar Booking</h5>
          <!-- Navbar -->
          <!-- <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle text-light" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                <span class="mr-2 d-none d-lg-inline small">Admin</span>
                <img class="img-profile rounded-circle" src="../img/profile-img.png">
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow">
                <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../index.php" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                </a>
              </div>
            </li>
          </ul> -->
        </nav>
        <!-- End of Topbar -->

        <!-- Page Content -->
        <div class="container-fluid">

          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Data Booking</h6>
              <a href="tambah-booking/booking_tambah.php" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Booking 
              </a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead class="bg-primary text-light align-content-center">
                <tr class="">
                  <th>No</th>
                  <th>Nama</th>
                  <th>Gunung</th>
                  <th>Jalur</th>
                  <th>Paket</th>
                  <th>Tanggal</th>
                  <th>Status Booking</th>
                  <th>Status Pembayaran</th>
                  <th>Nominal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                // Query baru dengan JOIN ke tabel payments dan payment_methods
                $query = mysqli_query($conn, "SELECT booking.*, gunung.nama_gunung, jalur.nama_jalur, paket.nama_paket, 
                                              payments.payment_status, payment_methods.method_name 
                                              FROM booking
                                              JOIN gunung ON booking.id_gunung = gunung.id
                                              JOIN jalur ON booking.id_jalur = jalur.id
                                              JOIN paket ON booking.id_paket = paket.id
                                              LEFT JOIN payments ON booking.id_booking = payments.booking_id
                                              LEFT JOIN payment_methods ON payments.payment_method_id = payment_methods.id");
                while ($row = mysqli_fetch_assoc($query)) {
                ?>
                  <tr class="text-dark">
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_pemesan']); ?></td>
                    <td><?= htmlspecialchars($row['nama_gunung']); ?></td>
                    <td><?= htmlspecialchars($row['nama_jalur']); ?></td>
                    <td><?= htmlspecialchars($row['nama_paket']); ?></td>
                    <td><?= htmlspecialchars($row['tanggal_booking']); ?></td>
                    <td>
                      <?php if ($row['status'] == 'approved') : ?>
                        <span class="badge badge-success">Approved</span>
                      <?php elseif ($row['status'] == 'pending') : ?>
                        <span class="badge badge-warning">Pending</span>
                      <?php else : ?>
                        <span class="badge badge-danger"><?= htmlspecialchars($row['status']); ?></span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($row['payment_status'] == 'Lunas') : ?>
                        <span class="badge badge-success"><?= htmlspecialchars($row['payment_status']); ?></span>
                      <?php elseif ($row['payment_status'] == 'Belum Lunas') : ?>
                        <span class="badge badge-danger"><?= htmlspecialchars($row['payment_status']); ?></span>
                      <?php elseif ($row['payment_status'] == 'Pending') : ?>
                        <span class="badge badge-warning"><?= htmlspecialchars($row['payment_status']); ?></span>
                      <?php else : ?>
                        <span class="badge badge-secondary">Belum Dibayar</span>
                      <?php endif; ?>
                    </td>
                    <td>Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                    <td>
                      <a href="edit-booking/edit_booking.php?id=<?= $row['id_booking']; ?>" class="btn btn-sm btn-warning mb-3">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="hapus-booking/hapus_booking.php?id=<?= $row['id_booking']; ?>" class="btn btn-sm btn-danger mb-3" onclick="return confirm('Yakin ingin menghapus data ini?');">
                        <i class="fas fa-trash"></i>
                      </a>
                      <!-- Tombol untuk melihat detail pembayaran -->
                      <a href="pembayaran.php" class="btn btn-sm btn-info mb-3">
                        <i class="fas fa-money-bill"></i>
                      </a>
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

      <?php if (file_exists("footer.php")) include "footer.php"; ?>
    </div> <!-- End of Content Wrapper -->
  </div> <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Keluar dari sesi?</h5>
          <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
        </div>
        <div class="modal-body">Pilih "Logout" untuk keluar dari sesi.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-primary" href="../index.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable();
    });
  </script>
</body>

</html>