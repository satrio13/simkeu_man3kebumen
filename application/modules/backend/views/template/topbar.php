<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    
    <ul class="navbar-nav ml-auto" style="border-left: 1px solid #ccc">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <span class="hidden-xs"><b><?= nama_user($this->session->userdata('id_user')); ?></b></span>
          <i class="right fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="dropdown-divider"></div>
          <a href="https://bit.ly/2XMsUJj" class="dropdown-item">
            <i class="fas fa-bug"></i> REPORT BUGS/ERROR
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url(); ?>backend/edit-profil" class="dropdown-item">
            <i class="fas fa-user"></i> EDIT PROFIL
          </a>
          <a href="<?= base_url(); ?>backend/ganti-password" class="dropdown-item">
            <i class="fas fa-key"></i> GANTI PASSWORD
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url(); ?>auth/logout" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> LOG OUT
          </a>
        </div>
      </li>
    </ul>
  </nav>
