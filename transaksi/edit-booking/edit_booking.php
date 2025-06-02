<?php include '../../config/auth.php';?>
<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi database
include '../../config/koneksi.php';
if (!$conn) {
  die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil ID booking dari URL
$id_booking = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// Ambil data booking berdasarkan ID
$query = mysqli_query($conn, "SELECT booking.*, gunung.nama_gunung, jalur.nama_jalur, paket.nama_paket 
                              FROM booking
                              JOIN gunung ON booking.id_gunung = gunung.id
                              JOIN jalur ON booking.id_jalur = jalur.id
                              JOIN paket ON booking.id_paket = paket.id
                              WHERE booking.id_booking = '$id_booking'");

if (mysqli_num_rows($query) == 0) {
    die("Data booking tidak ditemukan.");
}

$data = mysqli_fetch_assoc($query);

// Handle proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pemesan = mysqli_real_escape_string($conn, $_POST['nama_pemesan']);
    $id_gunung = mysqli_real_escape_string($conn, $_POST['id_gunung']);
    $id_jalur = mysqli_real_escape_string($conn, $_POST['id_jalur']);
    $id_paket = mysqli_real_escape_string($conn, $_POST['id_paket']);
    $tanggal_booking = mysqli_real_escape_string($conn, $_POST['tanggal_booking']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $nominal = mysqli_real_escape_string($conn, $_POST['nominal']);

    // Update data booking tanpa metode_pembayaran
    $updateQuery = "UPDATE booking SET 
                    nama_pemesan = '$nama_pemesan', 
                    id_gunung = '$id_gunung', 
                    id_jalur = '$id_jalur', 
                    id_paket = '$id_paket', 
                    tanggal_booking = '$tanggal_booking', 
                    status = '$status',
                    nominal = '$nominal'
                    WHERE id_booking = '$id_booking'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Data booking berhasil diperbarui!'); window.location.href = '../daftar_transaksi.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data booking: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Edit Booking | Dashboard</title>

  <!-- Font & Style -->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
  <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

  <div id="wrapper">

    <!-- Sidebar -->
    <?php include "../side_bar.php"; ?>

    <div id="content-wrapper" class="d-flex flex-column bg-gradient-light">
      <div id="content">
        <nav class="navbar navbar-expand navbar-dark bg-primary topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <h3 class="text-light">Edit Booking</h3>
        </nav>

        <div class="container-fluid">
          <h1 class="h3 mb-4 text-gray-800">Edit Data Booking</h1>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Form Edit Booking</h6>
            </div>
            <div class="card-body">
              <form method="POST" action="">
                <div class="form-group">
                  <label for="nama_pemesan">Nama Pemesan</label>
                  <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" value="<?= htmlspecialchars($data['nama_pemesan']); ?>" required>
                </div>
                
                <div class="form-group">
                  <label for="id_gunung">Gunung</label>
                  <select class="form-control" id="id_gunung" name="id_gunung" required>
                    <?php
                    $gunungQuery = mysqli_query($conn, "SELECT * FROM gunung");
                    while ($gunung = mysqli_fetch_assoc($gunungQuery)) {
                    ?>
                      <option value="<?= $gunung['id']; ?>" <?= $gunung['id'] == $data['id_gunung'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($gunung['nama_gunung']); ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="id_jalur">Jalur</label>
                  <select class="form-control" id="id_jalur" name="id_jalur" required>
                    <?php
                    $jalurQuery = mysqli_query($conn, "SELECT * FROM jalur");
                    while ($jalur = mysqli_fetch_assoc($jalurQuery)) {
                    ?>
                      <option value="<?= $jalur['id']; ?>" <?= $jalur['id'] == $data['id_jalur'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($jalur['nama_jalur']); ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="id_paket">Paket</label>
                  <select class="form-control" id="id_paket" name="id_paket" required>
                    <?php
                    $paketQuery = mysqli_query($conn, "SELECT * FROM paket");
                    while ($paket = mysqli_fetch_assoc($paketQuery)) {
                    ?>
                      <option value="<?= $paket['id']; ?>" <?= $paket['id'] == $data['id_paket'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($paket['nama_paket']); ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nominal">Nominal</label>
                  <input type="number" class="form-control" id="nominal" name="nominal" value="<?= htmlspecialchars($data['nominal']); ?>" required>
                </div>

                <div class="form-group">
                  <label for="tanggal_booking">Tanggal Booking</label>
                  <input type="date" class="form-control" id="tanggal_booking" name="tanggal_booking" value="<?= $data['tanggal_booking']; ?>" required>
                </div>

                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" id="status" name="status" required>
                    <option value="Pending" <?= $data['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Confirmed" <?= $data['status'] == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="Canceled" <?= $data['status'] == 'Canceled' ? 'selected' : ''; ?>>Canceled</option>
                  </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Booking</button>
                <a href="../list_booking.php" class="btn btn-secondary">Batal</a>
              </form>
            </div>
          </div>
        </div>
      </div>

      <?php include "../footer.php"; ?>
    </div>

  </div>

  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../../js/sb-admin-2.min.js"></script>

</body>

</html>