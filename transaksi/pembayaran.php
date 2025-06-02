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

// Proses Tambah Transaksi
if (isset($_POST['tambah_transaksi'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $payment_method_id = mysqli_real_escape_string($conn, $_POST['payment_method_id']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);
    $payment_date = mysqli_real_escape_string($conn, $_POST['payment_date']);

    $query = "INSERT INTO payments (booking_id, payment_method_id, amount, payment_status, payment_date) 
              VALUES ('$booking_id', '$payment_method_id', '$amount', '$payment_status', '$payment_date')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Transaksi berhasil ditambahkan!'); window.location.href = 'pembayaran.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan transaksi: " . mysqli_error($conn) . "');</script>";
    }
}

// Proses Edit Transaksi
if (isset($_POST['edit_transaksi'])) {
    $payment_id = mysqli_real_escape_string($conn, $_POST['payment_id']);
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $payment_method_id = mysqli_real_escape_string($conn, $_POST['payment_method_id']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);
    $payment_date = mysqli_real_escape_string($conn, $_POST['payment_date']);

    $updateQuery = "UPDATE payments SET 
                    booking_id = '$booking_id', 
                    payment_method_id = '$payment_method_id', 
                    amount = '$amount', 
                    payment_status = '$payment_status', 
                    payment_date = '$payment_date' 
                    WHERE id = '$payment_id'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Transaksi berhasil diperbarui!'); window.location.href = 'pembayaran.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui transaksi: " . mysqli_error($conn) . "');</script>";
    }
}

// Proses Hapus Transaksi
if (isset($_GET['hapus_id'])) {
    $payment_id = mysqli_real_escape_string($conn, $_GET['hapus_id']);
    $deleteQuery = mysqli_query($conn, "DELETE FROM payments WHERE id = '$payment_id'");
    if ($deleteQuery) {
        echo "<script>alert('Transaksi berhasil dihapus!'); window.location.href = 'pembayaran.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus transaksi: " . mysqli_error($conn) . "');</script>";
    }
}

// Ambil data untuk filter (jika ada booking_id dari URL)
$filter_booking_id = isset($_GET['booking_id']) ? mysqli_real_escape_string($conn, $_GET['booking_id']) : null;
$where_clause = $filter_booking_id ? "WHERE p.booking_id = '$filter_booking_id'" : "";

// Ambil data transaksi untuk ditampilkan
$query = mysqli_query($conn, "SELECT p.id, p.booking_id, b.nama_pemesan, p.payment_date, p.amount, pm.method_name, p.payment_status 
                              FROM payments p 
                              JOIN booking b ON p.booking_id = b.id_booking 
                              JOIN payment_methods pm ON p.payment_method_id = pm.id 
                              $where_clause");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daftar Transaksi | Dashboard</title>

    <!-- Font & Style -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "side_bar.php"; ?>

        <div id="content-wrapper" class="d-flex flex-column bg-gradient-light">
            <div id="content">
                <nav class="navbar navbar-expand navbar-dark bg-primary topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h5 class="text-light font-weight-bold">Daftar Pembayaran</h5>
                </nav>

                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahTransaksiModal">
                                <i class="fas fa-plus"></i> Tambah Transaksi
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="bg-primary text-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pemesan</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nominal</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                                <td>
                                                    <button class="btn btn-sm btn-warning mb-3 edit-btn" 
                                                            data-id="<?= $row['id']; ?>" 
                                                            data-booking_id="<?= $row['booking_id']; ?>" 
                                                            data-payment_date="<?= $row['payment_date']; ?>" 
                                                            data-amount="<?= $row['amount']; ?>" 
                                                            data-method_name="<?= $row['method_name']; ?>" 
                                                            data-payment_status="<?= $row['payment_status']; ?>" 
                                                            data-toggle="modal" data-target="#editTransaksiModal">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="pembayaran.php?hapus_id=<?= $row['id']; ?>" class="btn btn-sm btn-danger mb-3" onclick="return confirm('Yakin ingin menghapus transaksi ini?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include "../footer.php"; ?>
        </div>
    </div>

    <!-- Modal Tambah Transaksi -->
    <div class="modal fade" id="tambahTransaksiModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Transaksi</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Booking</label>
                            <select name="booking_id" class="form-control" required>
                                <?php
                                $bookingQuery = mysqli_query($conn, "SELECT id_booking, nama_pemesan FROM booking");
                                while ($b = mysqli_fetch_assoc($bookingQuery)) {
                                    $selected = ($filter_booking_id && $b['id_booking'] == $filter_booking_id) ? 'selected' : '';
                                    echo "<option value='{$b['id_booking']}' $selected>{$b['nama_pemesan']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <select name="payment_method_id" class="form-control" required>
                                <?php
                                $methodQuery = mysqli_query($conn, "SELECT * FROM payment_methods");
                                while ($m = mysqli_fetch_assoc($methodQuery)) {
                                    echo "<option value='{$m['id']}'>{$m['method_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nominal</label>
                            <input type="number" name="amount" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status Pembayaran</label>
                            <select name="payment_status" class="form-control" required>
                                <option value="Lunas">Lunas</option>
                                <option value="Belum Lunas">Belum Lunas</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pembayaran</label>
                            <input type="date" name="payment_date" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit" name="tambah_transaksi">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Transaksi -->
    <div class="modal fade" id="editTransaksiModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Transaksi</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="payment_id" id="edit_payment_id">
                        <div class="form-group">
                            <label>Booking</label>
                            <select name="booking_id" id="edit_booking_id" class="form-control" required>
                                <?php
                                mysqli_data_seek($bookingQuery, 0);
                                while ($b = mysqli_fetch_assoc($bookingQuery)) {
                                    echo "<option value='{$b['id_booking']}'>{$b['nama_pemesan']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <select name="payment_method_id" id="edit_payment_method_id" class="form-control" required>
                                <?php
                                mysqli_data_seek($methodQuery, 0);
                                while ($m = mysqli_fetch_assoc($methodQuery)) {
                                    echo "<option value='{$m['id']}' data-method_name='{$m['method_name']}'>{$m['method_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nominal</label>
                            <input type="number" name="amount" id="edit_amount" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status Pembayaran</label>
                            <select name="payment_status" id="edit_payment_status" class="form-control" required>
                                <option value="Lunas">Lunas</option>
                                <option value="Belum Lunas">Belum Lunas</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pembayaran</label>
                            <input type="date" name="payment_date" id="edit_payment_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit" name="edit_transaksi">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();

            // Isi data ke modal edit
            $('.edit-btn').click(function () {
                var id = $(this).data('id');
                var booking_id = $(this).data('booking_id');
                var payment_date = $(this).data('payment_date');
                var amount = $(this).data('amount');
                var method_name = $(this).data('method_name');
                var payment_status = $(this).data('payment_status');

                $('#edit_payment_id').val(id);
                $('#edit_booking_id').val(booking_id);
                $('#edit_payment_date').val(payment_date);
                $('#edit_amount').val(amount);
                $('#edit_payment_status').val(payment_status);
                $('#edit_payment_method_id option').each(function () {
                    if ($(this).data('method_name') == method_name) {
                        $(this).prop('selected', true);
                    }
                });
            });
        });
    </script>
</body>

</html>