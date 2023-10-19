<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-info elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url(); ?>backend" class="brand-link">
    <span class="brand-text font-weight-light d-flex justify-content-center">MAN 3 KEBUMEN</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="mt-3 pb-3 d-flex justify-content-center">
        <div class="info text-center text-white">
          <?php
          $img_user = img_user($this->session->userdata('id_user'));
          if( !empty($img_user) AND file_exists("assets/img/user/$img_user") )
          {
            echo'<img src="'.base_url("assets/img/user/$img_user").'" class="img img-fluid" width="70px"><br>';
          }else
          {
            echo'<br><img src="'.base_url("assets/img/no-image.png").'" class="img img-fluid" width="70px"><br>';
          }
          echo nama_user($this->session->userdata('id_user')); 
          echo'<br><span class="badge badge-danger">'.strtoupper($this->session->userdata('level')).'</span>';
          ?>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= base_url('backend'); ?>" class="<?php if($this->uri->segment('2')=='') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>DASHBOARD</p>
            </a>
          </li>
          
          <li class="nav-item mb-1">
            <a href="<?= base_url('backend/pembayaran'); ?>" class="<?php if($this->uri->segment('2') == 'pembayaran' OR $this->uri->segment('2') == 'bayar' OR $this->uri->segment('2') == 'riwayat') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>PEMBAYARAN</p>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a href="<?= base_url('backend/tabungan'); ?>" class="<?php if($this->uri->segment('2') == 'tabungan' OR $this->uri->segment('2') == 'nabung') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
              <i class="nav-icon fas fa-coins"></i>
              <p>TABUNGAN</p>
            </a>
          </li>
        
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fa fa-cog"></i>
              <p>PENGATURAN</p>
              <i class="right fas fa-angle-down"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('backend/tagihan-tahunan'); ?>" class="<?php if($this->uri->segment('2') == 'tagihan-tahunan' OR $this->uri->segment('2') == 'tambah-tagihan-tahunan' OR $this->uri->segment('2') == 'edit-tagihan-tahunan') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                  <i class="nav-icon far fa-circle"></i>
                  <small>TAGIHAN TAHUNAN</small>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('backend/transaksi-semester'); ?>" class="<?php if($this->uri->segment('2') == 'transaksi-semester' OR $this->uri->segment('2') == 'trans-semester') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                  <i class="nav-icon far fa-circle"></i>
                  <small>TRANSAKSI KELAS</small>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('backend/setting-bsm'); ?>" class="<?php if($this->uri->segment('2') == 'setting-bsm') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                  <i class="nav-icon far fa-circle"></i>
                  <small>SETTING BSM</small>
                </a>
              </li>
            </ul>
          </li>

        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fa fa-database"></i>
            <p>MASTER DATA</p>
            <i class="right fas fa-angle-down"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('backend/tahun'); ?>" class="<?php if($this->uri->segment('2') == 'tahun' OR $this->uri->segment('2') == 'tambah-tahun' OR $this->uri->segment('2') == 'edit-tahun') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>TAHUN PELAJARAN</small>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('backend/jenis-tagihan'); ?>" class="<?php if($this->uri->segment('2') == 'jenis-tagihan' OR $this->uri->segment('2') == 'tambah-jenis-tagihan' OR $this->uri->segment('2') == 'edit-jenis-tagihan') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>JENIS TAGIHAN</small>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('backend/tagihan'); ?>" class="<?php if($this->uri->segment('2') == 'tagihan' OR $this->uri->segment('2') == 'tambah-tagihan' OR $this->uri->segment('2') == 'edit-tagihan') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>TAGIHAN</small>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('backend/jurusan'); ?>" class="<?php if($this->uri->segment('2') == 'jurusan' OR $this->uri->segment('2') == 'tambah-jurusan' OR $this->uri->segment('2') == 'edit-jurusan') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>JURUSAN</small>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('backend/kelas'); ?>" class="<?php if($this->uri->segment('2') == 'kelas' OR $this->uri->segment('2') == 'tambah-kelas' OR $this->uri->segment('2') == 'edit-kelas') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>KELAS</small>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('backend/guru'); ?>" class="<?php if($this->uri->segment('2') == 'guru' OR $this->uri->segment('2') == 'tambah-guru' OR $this->uri->segment('2') == 'edit-guru' OR $this->uri->segment('2') == 'form-guru' OR $this->uri->segment('2') == 'guru-batch') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>GURU</small>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('backend/kelas-wali'); ?>" class="<?php if($this->uri->segment('2') == 'kelas-wali' OR $this->uri->segment('2') == 'tambah-kelas-wali' OR $this->uri->segment('2') == 'edit-kelas-wali') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>WALI KELAS</small>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('backend/siswa'); ?>" class="<?php if($this->uri->segment('2') == 'siswa' OR $this->uri->segment('2') == 'tambah-siswa' OR $this->uri->segment('2') == 'edit-siswa' OR $this->uri->segment('2') == 'form-siswa' OR $this->uri->segment('2') == 'siswa-batch') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>SISWA</small>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fa fa-book"></i>
            <p>LAPORAN</p>
            <i class="right fas fa-angle-down"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('backend/laporan-riwayat'); ?>" class="<?php if($this->uri->segment('2') == 'laporan-riwayat') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>RIWAYAT PEMBAYARAN</small>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('backend/laporan-persiswa'); ?>" class="<?php if($this->uri->segment('2') == 'laporan-persiswa'){ echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>LAPORAN PERSISWA</small>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('backend/laporan-kekurangan'); ?>" class="<?php if($this->uri->segment('2')=='laporan-kekurangan') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small style="font-size: 9pt">KEKURANGAN PER TAGIHAN</small>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('backend/laporan-semua-kekurangan'); ?>" class="<?php if($this->uri->segment('2')=='laporan-semua-kekurangan') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small style="font-size: 8pt">KEKURANGAN SEMUA TAGIHAN</small>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fa fa-user"></i>
            <p>MANAJEMEN USER</p>
            <i class="right fas fa-angle-down"></i>
          </a>
          <ul class="nav nav-treeview">
          <?php if($this->session->userdata('level') == 'superadmin'){ ?>
            <li class="nav-item">
              <a href="<?= base_url('backend/users'); ?>" class="<?php if($this->uri->segment('2') == 'users' OR $this->uri->segment('2') == 'tambah-user' OR $this->uri->segment('2') == 'edit-user') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>USERS</small>
              </a>
            </li>
          <?php } ?>
            <li class="nav-item">
              <a href="<?= base_url('backend/edit-profil'); ?>" class="<?php if($this->uri->segment('2') == 'edit-profil') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>EDIT PROFIL</small>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('backend/ganti-password'); ?>" class="<?php if($this->uri->segment('2') == 'ganti-password') { echo 'nav-link active'; }else{ echo 'nav-link'; } ?>">
                <i class="far fa-circle nav-icon"></i>
                <small>GANTI PASSWORD</small>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fa fa-medkit"></i>
            <p>PERAWATAN</p>
            <i class="right fas fa-angle-down"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('backend/backup'); ?>" class="nav-link active"><i class="far fa-circle nav-icon"></i><small>BACKUP DATABASE</small></a>
            </li>
          </ul>
        </li>
      </nav>
  </div>
</aside>