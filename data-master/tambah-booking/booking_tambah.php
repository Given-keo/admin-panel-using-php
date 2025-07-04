<?php include '../../config/auth.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard | Booking Gunung</title>

  <!-- Font & Style -->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
  <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
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
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-secondary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

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
                <span class="mr-2 d-none text-light d-lg-inline small">Admin</span>
                <img class="img-profile rounded-circle" src="../../img/profile-img.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
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

          <!-- tambah booking -->
          <h1 class="h3 mb-4 text-gray-800">Form Tambah Booking</h1>
          <div id="message"></div> <!-- Untuk menampilkan pesan validasi -->
          <form action="booking_proses_tambah.php" method="POST" id="bookingForm">

            <label>Nama Pemesan:</label>
            <!-- name: nama_pemesan -->
            <input type="text" name="nama_pemesan" class="form-control" required placeholder="Masukkan nama pemesan">

            <label>Gunung:</label>
            <!-- name: id_gunung -->
            <select name="id_gunung" id="id_gunung" class="form-control" required>
              <option value="" disabled selected>Pilih Gunung</option>
              <?php
              include '../../config/koneksi.php';
              $gunung = mysqli_query($conn, "SELECT * FROM gunung");
              while ($g = mysqli_fetch_assoc($gunung)) {
                echo "<option value='{$g['id']}'>{$g['nama_gunung']}</option>";
              }
              ?>
            </select>

            <label>Jalur:</label>
            <!-- name: id_jalur -->
            <select name="id_jalur" id="id_jalur" class="form-control" required>
              <option value="" disabled selected>Pilih Jalur</option>
              <?php
              $jalur = mysqli_query($conn, "SELECT * FROM jalur");
              while ($j = mysqli_fetch_assoc($jalur)) {
                echo "<option value='{$j['id']}'>{$j['nama_jalur']}</option>";
              }
              ?>
            </select>

            <label>Paket:</label>
            <!-- name: id_paket -->
            <select name="id_paket" id="id_paket" class="form-control" required>
              <option value="" disabled selected>Pilih Paket</option>
              <?php
              $paket = mysqli_query($conn, "SELECT * FROM paket");
              while ($p = mysqli_fetch_assoc($paket)) {
                echo "<option value='{$p['id']}' data-harga='{$p['harga']}'>{$p['nama_paket']}</option>";
              }
              ?>
            </select>

            <!-- harga paket -->
            <label>Harga Paket (Rp):</label>

            <!-- Untuk tampilan saja -->
            <input type="text" id="harga_paket_view" class="form-control mb-2" readonly>

            <!-- name: harga_paket -->
            <input type="number" id="harga_paket" name="nominal" class="form-control d-none">

            <label>Tanggal Booking:</label>
            <!-- name: tanggal_booking -->
            <input type="date" name="tanggal_booking" id="tanggal_booking" class="form-control" required min="<?= date('Y-m-d'); ?>">

            <label>Jumlah Orang:</label>
            <!-- name: jumlah_orang -->
            <input type="number" name="jumlah_orang" id="jumlah_orang" class="form-control" min="1" required>

            <label>Status:</label>
            <!-- name: status -->
            <select name="status" class="form-control" required>
              <option value="Pending">Pending</option>
              <option value="Confirmed">Confirmed</option>
              <option value="Canceled">Canceled</option>
            </select>

            <br>
            <button type="submit" class="btn btn-primary mb-4">Simpan</button>
            <a href="../daftar_transaksi.php" class="btn btn-secondary mb-4">Kembali</a>
          </form>

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
          <a class="btn btn-primary" href="../../proses-login/logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Script -->
  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../../js/sb-admin-2.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
  $(document).ready(function () {
    // Update harga paket
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

    // Validasi kuota secara real-time
    $('#id_gunung, #id_jalur, #jumlah_orang').change(function () {
      var id_gunung = $('#id_gunung').val();
      var id_jalur = $('#id_jalur').val();
      var jumlah_orang = parseInt($('#jumlah_orang').val()) || 0;

      if (id_gunung && id_jalur && jumlah_orang > 0) {
        $.ajax({
          url: 'check_quota.php',
          method: 'POST',
          data: { id_gunung: id_gunung, id_jalur: id_jalur },
          dataType: 'json',
          success: function (response) {
            var remaining = response.remaining;
            if (remaining < jumlah_orang) {
              $('#message').html('<div class="alert alert-danger">Kuota tidak cukup! Sisa kuota: ' + remaining + ' slot</div>');
              $('#bookingForm').find('button[type="submit"]').prop('disabled', true);
            } else {
              $('#message').html('<div class="alert alert-success">Kuota cukup. Sisa kuota: ' + remaining + ' slot</div>');
              $('#bookingForm').find('button[type="submit"]').prop('disabled', false);
            }
          },
          error: function (xhr, status, error) {
            $('#message').html('<div class="alert alert-danger">Error memeriksa kuota: ' + error + '</div>');
            $('#bookingForm').find('button[type="submit"]').prop('disabled', true);
          }
        });
      } else {
        $('#message').html('');
        $('#bookingForm').find('button[type="submit"]').prop('disabled', true);
      }
    });

    // Pastikan tombol submit dinonaktifkan saat form kosong
    $('#bookingForm').on('submit', function () {
      var jumlah_orang = parseInt($('#jumlah_orang').val()) || 0;
      if (jumlah_orang <= 0) {
        $('#message').html('<div class="alert alert-danger">Jumlah orang harus lebih dari 0!</div>');
        return false;
      }
    });
  });
  </script>

</body>

</html>