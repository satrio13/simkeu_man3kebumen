<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Apa Saja Menu Dari Aplikasi Ini?</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('backend'); ?>">Home</a></li>
            <li class="breadcrumb-item active"><?= $title; ?></li>
          </ol>
        </div>
      </div>
    </div>
  </div>

<!-- Main content -->
<section class="content">
<div class="container-fluid">
  <!-- Info boxes -->
  <div class="row bg-navy mb-2">
    <div class="col-md-12">
      <h3 class="text-center">&raquo; Menu Utama &laquo;</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box">
        <span class="info-box-icon bg-info elevation-1">
          <a href="<?= base_url('backend/pembayaran'); ?>" class="text-bold"><i class="fas fa-money-check-alt"></i></a>
        </span>
        <div class="info-box-content">
          <span class="info-box-text"><a href="<?= base_url('backend/pembayaran'); ?>" class="text-bold">PEMBAYARAN</a></span>
          adalah menu untuk melakukan/mencatat transaksi pembayaran per siswa.
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-success elevation-1">
          <a href="<?= base_url('backend/tabungan'); ?>" class="text-bold text-white"><i class="fas fa-coins"></i></a>
        </span>
        <div class="info-box-content">
          <span class="info-box-text"><a href="<?= base_url('backend/tabungan'); ?>" class="text-bold">TABUNGAN</a></span>
          adalah menu untuk melakukan/mencatat transaksi tabungan per siswa.
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-primary elevation-1">
          <a href="<?= base_url('backend/tagihan-tahunan'); ?>" class="text-bold text-white"><i class="fas fa-cog"></i></a>
        </span>
        <div class="info-box-content">
          <span class="info-box-text"><a href="<?= base_url('backend/tagihan-tahunan'); ?>" class="text-bold">TAGIHAN TAHUNAN</a></span>
          adalah menu untuk menentukan nilai dari tiap tagihan setiap tahun pelajaran.
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <div class="row justify-content-center">
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-danger elevation-1">
          <a href="<?= base_url('backend/transaksi-semester'); ?>" class="text-bold"><i class="fas fa-arrow-up"></i></a>
        </span>
        <div class="info-box-content">
          <span class="info-box-text"><a href="<?= base_url('backend/transaksi-semester'); ?>" class="text-bold">TRANSAKSI SEMESTER</a></span>
          adalah menu untuk melakukan transaksi memasukan siswa ke semester tertentu.
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-purple elevation-1">
          <a href="<?= base_url('backend/setting-bsm'); ?>" class="text-bold"><i class="fas fa-tasks"></i></a>
        </span>
        <div class="info-box-content">
          <span class="info-box-text"><a href="<?= base_url('backend/setting-bsm'); ?>" class="text-bold">SETTING BSM</a></span>
          adalah menu untuk menentukan / memberi tanda pada siswa yang menerima BSM.
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <div class="row bg-maroon mb-2">
    <div class="col-md-12">
      <h3 class="text-center">&raquo; Menu Master Data &laquo;</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box">
        <div class="info-box-content">
          <span class="info-box-text"><a href="<?= base_url('backend/tahun-pelajaran'); ?>" class="btn btn-primary btn-xs">TAHUN PELAJARAN <i class="fa fa-arrow-right"></i></a></span>
          adalah menu untuk mengelola data tahun pelajaran.
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box">
        <div class="info-box-content">
          <span class="info-box-text"><a href="<?= base_url('backend/jenis-tagihan'); ?>" class="btn btn-primary btn-xs">JENIS TAGIHAN <i class="fa fa-arrow-right"></i></a></span>
          adalah menu untuk mengelola data jenis tagihan.
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box">
        <div class="info-box-content">
          <span class="info-box-text"><a href="<?= base_url('backend/tagihan'); ?>" class="btn btn-primary btn-xs">TAGIHAN <i class="fa fa-arrow-right"></i></a></span>
          adalah menu untuk mengelola data tagihan.
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <div class="row">
  <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <div class="info-box-content">
            <span class="info-box-text"><a href="<?= base_url('backend/jurusan'); ?>" class="btn btn-primary btn-xs">JURUSAN <i class="fa fa-arrow-right"></i></a></span>
            adalah menu untuk mengelola data jurusan.
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <div class="info-box-content">
            <span class="info-box-text"><a href="<?= base_url('backend/kelas'); ?>" class="btn btn-primary btn-xs">KELAS <i class="fa fa-arrow-right"></i></a></span>
            adalah menu untuk mengelola data kelas.
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <div class="info-box-content">
            <span class="info-box-text"><a href="<?= base_url('backend/guru'); ?>" class="btn btn-primary btn-xs">GURU <i class="fa fa-arrow-right"></i></a></span>
            adalah menu untuk mengelola data guru.
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <div class="row justify-content-center">
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <div class="info-box-content">
            <span class="info-box-text"><a href="<?= base_url('backend/kelas-wali'); ?>" class="btn btn-primary btn-xs">WALI KELAS <i class="fa fa-arrow-right"></i></a></span>
            adalah menu untuk mengelola data wali kelas.
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <div class="info-box-content">
            <span class="info-box-text"><a href="<?= base_url('backend/siswa'); ?>" class="btn btn-primary btn-xs">SISWA <i class="fa fa-arrow-right"></i></a></span>
            adalah menu untuk mengelola data siswa.
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
    <!-- /.row -->
  <div class="row bg-purple mb-2">
    <div class="col-md-12">
      <h3 class="text-center">&raquo; Menu Laporan &laquo;</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box">
        <div class="info-box-content">
          <span class="info-box-text"><a href="<?= base_url('backend/laporan-riwayat'); ?>" class="btn btn-primary btn-xs">LAPORAN RIWAYAT PEMBAYARAN <i class="fa fa-arrow-right"></i></a></span>
          adalah menu untuk melihat transaksi yang terjadi pada periode tertentu.
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box">
        <div class="info-box-content">
          <span class="info-box-text"><a href="<?= base_url('backend/laporan-kekurangan'); ?>" class="btn btn-primary btn-xs">LAPORAN KEKURANGAN PER TAGIHAN <i class="fa fa-arrow-right"></i></a></span>
          adalah menu untuk melihat laporan kekurangan pembayaran siswa per tagihan.
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box">
        <div class="info-box-content">
          <span class="info-box-text"><a href="<?= base_url('backend/laporan-semua-kekurangan'); ?>" class="btn btn-primary btn-xs">LAPORAN KEKURANGAN SEMUA TAGIHAN <i class="fa fa-arrow-right"></i></a></span>
          adalah menu untuk melihat laporan kekurangan pembayaran siswa semua tagihan.
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box">
        <div class="info-box-content">
          <span class="info-box-text"><a href="<?= base_url('backend/laporan-persiswa'); ?>" class="btn btn-primary btn-xs ">LAPORAN PER SISWA <i class="fa fa-arrow-right"></i></a></span>
          adalah menu untuk melihat laporan pembayaran per siswa.
        </div>
      </div>
    </div>
  </div>
</section>
</div>