<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid bg-dark p-2">
      <div class="row mb-2">
        <div class="col-md-12">
          <?php echo form_open('backend/pembayaran'); ?>
            <div class="row">
              <div class="col-md-3">
                  <input type="text" name="nis" value="<?= set_value('nis'); ?>" placeholder="NIS" class="form-control" required>
              </div>
              <div class="col-md-3">
                  <button type="submit" name="submit" value="Cari" class="btn bg-info btn-flat text-white border border-white text-bold"><i class="fa fa-search"></i> CARI SISWA</button>
              </div>
          <?php echo form_close(); ?>
              <div class="col-md-6 text-right">
                <a href="" target="_self" class="btn bg-info btn-flat text-white border border-white"><i class="fas fa-sync-alt"></i> REFRESH</a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <section class="content">
  <div class="row">
    <div class="col-12"> 
    <?php 
    if($this->session->flashdata('msg-bayar'))
    {
      echo pesan_sukses($this->session->flashdata('msg-bayar'));
    }elseif($this->session->flashdata('msg-gagal-bayar'))
    {
      echo pesan_gagal($this->session->flashdata('msg-gagal-bayar'));
    }
    ?>
    <div class="card">
      <div class="p-2 text-white bg-info text-bold">
        <div class="row">
          <div class="col-md-1">NAMA</div>
          <div class="col-md-4">: <?= $siswa->nama; ?></div>
          <div class="col-md-2">TAHUN PELAJARAN</div>
          <div class="col-md-4">: <?= $siswa->tahunpelajaran; ?></div>
        </div>
        <div class="row">
          <div class="col-md-1">NIS</div>
          <div class="col-md-4">: <?= $siswa->nis; ?></div>
          <div class="col-md-2">KELAS</div>
          <div class="col-md-4">: <?= $siswa->kelas; ?></div>
        </div>
        <div class="row">
          <div class="col-md-12 text-right">
            <button class="btn bg-navy btn-flat border-white text-bold"><i class="fa fa-coins"></i> TABUNGAN SEKARANG: <?= number_format(tabungan($siswa->id_siswa), 0, ',', '.'); ?></button>
            <a href="<?= base_url(); ?>backend/riwayat/<?= $siswa->nis; ?>" class="btn btn-danger btn-flat border-white text-bold" target="_blank"><i class="fa fa-eye"></i> LIHAT RIWAYAT PEMBAYARAN <b></b></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-md-12">
  <div class="row">
    <div class="col-md-12 bg-maroon text-bold p-2">
      <label class="mt-2">TAGIHAN SEKALI SELAMANYA</label>
    </div>
    <?php include('pemb_selamanya.php'); ?>
  </div>                                                                                          
</div>
<br>
<div class="col-md-12">
  <div class="row">
    <div class="col-md-12 bg-maroon text-bold p-2">
      <label class="mt-2">TAGIHAN SETIAP TAHUN</label>
    </div>
    <?php include('pemb_tahunan.php'); ?>
  </div>
</div>
<br>
<!--
<div class="col-md-12">
  <div class="row">
    <div class="col-md-12 bg-maroon text-bold p-2">
      <label class="mt-2">TAGIHAN SETIAP SEMESTER</label>
    </div>
    <?php 
    $semester = romawi_ke_angka($siswa->semester);
    if($semester > 0)
    {     
      include('pemb_semester.php'); 
    }else
    { 
      include('belum_ada_tagihan.php');
    } ?>
  </div>
</div>
<br>
  -->
<div class="col-md-12">
  <div class="row">
    <div class="col-md-12 bg-maroon text-bold p-2">
      <label class="mt-2">TAGIHAN SETIAP BULAN</label>
    </div>
    <?php include('pemb_bulanan.php'); ?>
  </div>
</div>
<br>
<div class="col-md-12">
  <div class="row">
    <div class="col-md-12 bg-maroon text-bold p-2">
      <label class="mt-2">TAGIHAN KELULUSAN</label>
    </div>
    <?php 
    if($siswa->tingkat == 'XII')
    {
      $jml = $pemb_kelulusan->num_rows();
      if($jml > 0)
      {
        include('pemb_kelulusan.php');
      }else{
        include('belum_ada_tagihan.php');
      }
    }else{
      include('belum_ada_tagihan.php');
    } ?>
  </div>
</div>
<br>
</div>
</section>
</div>