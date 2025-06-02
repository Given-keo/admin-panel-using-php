<?php
    include 'config/koneksi.php';
    session_start();

    // Redirect ke dashboard jika sudah login
    if (isset($_SESSION['level'])) {
        header("Location: dashboard.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login | Booking Gunung</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="align-content-center pt-3 bg-gradient-light">

  <div class="container mt-5">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <!-- side img login -->
              <div class="col-lg-6 d-none d-lg-block bg-login-image p-5">
                <div class="text-center">
                  <h1 class="text-dark">Welcome Back!</h1>
                </div>
                <h3 class="text-center text-primary">Booking Gunung</h3>
                <img src="img/img-login.jpg" alt="" class="img-fluid">
              </div>
              <!-- main form login -->
              <div class="col-lg-6 align-content-center p-5 bg-primary">

                <h1 class="text-light text-center mb-3 fw-bold">Login</h1>

                <!-- form -->
                <form class="user" action="proses-login/login.php" method="post">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" placeholder="Enter username..." name="username" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" placeholder="Password" name="password" required>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                      <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                      <label class="custom-control-label text-light" for="customCheck">Remember Me</label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-light btn-user btn-block mb-3">
                    Login
                  </button>
                </form>

              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
