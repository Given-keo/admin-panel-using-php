<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <img src="img/img-login.jpg" class="img-fluid" alt="">
    </div>
    <div class="sidebar-brand-text mx-3">Booking Gunung</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="dashboard.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <hr class="sidebar-divider">

  <!-- Data Master -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDataMaster" aria-expanded="true" aria-controls="collapseDataMaster">
      <i class="fas fa-fw fa-cog"></i>
      <span>Data Master</span>
    </a>
    <div id="collapseDataMaster" class="collapse" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="data-master/data_gunung.php">Data Gunung</a>
        <a class="collapse-item" href="data-master/data_jalur.php">Jalur Pendakian</a>
        <a class="collapse-item" href="data-master/data_paket_pendakian.php">Paket Pendakian</a>
        <a class="collapse-item" href="data-master/data_kuota.php">Kuota Harian</a>
        <a class="collapse-item" href="data-master/data_admin.php">Master Petugas / Admin</a>
      </div>
    </div>
  </li>

  <!-- Transaksi -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransaksi" aria-expanded="true" aria-controls="collapseTransaksi">
      <i class="fas fa-fw fa-exchange-alt"></i>
      <span>Transaksi</span>
    </a>
    <div id="collapseTransaksi" class="collapse" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="transaksi/daftar_transaksi.php">Daftar Transaksi</a>
        <a class="collapse-item" href="transaksi/pembayaran.php">Daftar Pembayaran</a>
        <a class="collapse-item" href="transaksi/metode_pembayaran.php">Metode Pembayaran</a>
      </div>
    </div>
  </li>

  <!-- Laporan -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="true" aria-controls="collapseLaporan">
      <i class="fas fa-fw fa-file-alt"></i>
      <span>Laporan</span>
    </a>
    <div id="collapseLaporan" class="collapse" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="laporan/laporan_transaksi.php">Laporan Transaksi</a>
        <a class="collapse-item" href="laporan/laporan_booking.php">Laporan Booking</a>
        <a class="collapse-item" href="laporan/laporan_kuota.php">Laporan Kuota</a>
        <a class="collapse-item" href="laporan/laporan_pendapatan.php">Laporan Pendapatan/Metode</a>
      </div>
    </div>
  </li>

  <!-- Sidebar Toggler -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
