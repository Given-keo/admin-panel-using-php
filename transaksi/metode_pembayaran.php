<?php include '../config/auth.php';?>
<?php
// Koneksi database
include '../config/koneksi.php';
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Proses Tambah Metode Pembayaran
if (isset($_POST['tambah_metode'])) {
    $method_name = mysqli_real_escape_string($conn, $_POST['method_name']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if (empty($method_name)) {
        echo "<script>alert('Nama metode tidak boleh kosong!'); window.location.href = 'metode_pembayaran.php';</script>";
    } else {
        $query = "INSERT INTO payment_methods (method_name, is_active) VALUES ('$method_name', '$is_active')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Metode pembayaran berhasil ditambahkan!'); window.location.href = 'metode_pembayaran.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan metode pembayaran: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Proses Edit Metode Pembayaran
if (isset($_POST['edit_metode'])) {
    $id = mysqli_real_escape_string($conn, $_POST['method_id']);
    $method_name = mysqli_real_escape_string($conn, $_POST['method_name']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if (empty($method_name)) {
        echo "<script>alert('Nama metode tidak boleh kosong!'); window.location.href = 'metode_pembayaran.php';</script>";
    } else {
        $updateQuery = "UPDATE payment_methods SET method_name = '$method_name', is_active = '$is_active' WHERE id = '$id'";
        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Metode pembayaran berhasil diperbarui!'); window.location.href = 'metode_pembayaran.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui metode pembayaran: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Proses Hapus Metode Pembayaran
if (isset($_GET['hapus_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['hapus_id']);
    
    // Cek apakah metode pembayaran sedang digunakan di tabel payments
    $checkQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM payments WHERE payment_method_id = '$id'");
    $check = mysqli_fetch_assoc($checkQuery);
    
    if ($check['total'] > 0) {
        echo "<script>alert('Metode pembayaran tidak dapat dihapus karena masih digunakan!'); window.location.href = 'metode_pembayaran.php';</script>";
    } else {
        $deleteQuery = mysqli_query($conn, "DELETE FROM payment_methods WHERE id = '$id'");
        if ($deleteQuery) {
            echo "<script>alert('Metode pembayaran berhasil dihapus!'); window.location.href = 'metode_pembayaran.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus metode pembayaran: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Ambil data metode pembayaran untuk ditampilkan
$query = mysqli_query($conn, "SELECT * FROM payment_methods");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manajemen Metode Pembayaran | Dashboard</title>

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
                    <h5 class="text-light font-weight-bold">Manajemen Metode Pembayaran</h5>
                </nav>

                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Metode Pembayaran</h6>
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahMetodeModal">
                                <i class="fas fa-plus"></i> Tambah Metode
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="bg-primary text-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Metode</th>
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
                                                <td><?= htmlspecialchars($row['method_name']); ?></td>
                                                <td>
                                                    <?php if ($row['is_active'] == 1) : ?>
                                                        <span class="badge badge-success">Aktif</span>
                                                    <?php else : ?>
                                                        <span class="badge badge-danger">Tidak Aktif</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning mb-3 edit-btn" 
                                                            data-id="<?= $row['id']; ?>" 
                                                            data-method_name="<?= $row['method_name']; ?>" 
                                                            data-is_active="<?= $row['is_active']; ?>" 
                                                            data-toggle="modal" data-target="#editMetodeModal">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="metode_pembayaran.php?hapus_id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus metode pembayaran ini?');">
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

    <!-- Modal Tambah Metode Pembayaran -->
    <div class="modal fade" id="tambahMetodeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Metode Pembayaran</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Metode</label>
                            <input type="text" name="method_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <input type="checkbox" name="is_active" value="1" checked> Aktif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit" name="tambah_metode">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Metode Pembayaran -->
    <div class="modal fade" id="editMetodeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Metode Pembayaran</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="method_id" id="edit_method_id">
                        <div class="form-group">
                            <label>Nama Metode</label>
                            <input type="text" name="method_name" id="edit_method_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1"> Aktif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit" name="edit_metode">Update</button>
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
                var method_name = $(this).data('method_name');
                var is_active = $(this).data('is_active');

                $('#edit_method_id').val(id);
                $('#edit_method_name').val(method_name);
                $('#edit_is_active').prop('checked', is_active == 1);
            });
        });
    </script>
</body>

</html>