<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= strtoupper($title); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('backend'); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('backend/siswa'); ?>">Siswa</a></li>
              <li class="breadcrumb-item active"><?= $title; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header">
                <a href="<?= base_url(); ?>excel/siswa/format-import-data-siswa.xlsx" class="btn bg-maroon btn-flat" target="_blank"><i class="fa fa-download"></i> Download Format</a>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            <?php echo form_open_multipart('backend/form-siswa'); ?>
                <div class="card-body">
                  <div class="callout callout-danger">
                    <h5>CARA MELAKUKAN IMPORT DATA SISWA :</h5>
                    <b>1.</b> Klik tombol <b>Download Format</b> untuk mengunduh file template excel yg dibutuhkan <b>( format-import-data-siswa.xlsx )</b>.<br>
                    <b>2.</b> Setelah file  <b>( format-import-data-siswa.xlsx )</b> berhasil diunduh, kemudian buka file tersebut dan mulailah untuk mengisi datanya mulai dari <b>baris/row 2</b> !! <br>
                    <b>3.</b> Setelah semua data dirasa sudah benar, kemudian simpan <b>( ctrl+s )</b> file tersebut. Langkah selanjutnya adalah melakukan upload file tersebut ke dalam Aplikasi ini. Caranya Klik <b>Choose File / Browse</b> untuk mencari file tersebut kemudian klik <b>Preview</b> untuk divalidasi lebih lanjut oleh sistem.<br>
                    <b>4.</b> Setelah klik Preview dan data telah lolos verifikasi sistem maka <b>Tombol Import</b> akan muncul, dan selanjutnya <b>klik Import</b> untuk melakukan import data ke database.
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-7">
                    <?php
                    if(isset($_POST['preview']))
                    { 
                      if($upload_error)
                      { 
                        echo'<div class="alert alert-danger alert-message">'.$upload_error.'</div>';
                      }
                    } 
                    ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-5">
                      <input type="file" name="file" class="form-control" required>
                      <p style="color: red">*) ukuran file max 5 MB</p>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type='submit' name="preview" value="Preview" class='btn btn-info btn-flat'><i class="fa fa-check"></i> Preview</button>
                  <a href="<?= base_url(); ?>backend/siswa" class="btn btn-danger btn-flat float-right"><i class="fa fa-arrow-left"></i> Batal</a>
                </div>
                <!-- /.card-footer -->
                 <!-- /.card-footer -->
              <?php echo form_close() ?>
<?php
if(isset($_POST['preview']))
{ // Jika user menekan tombol Preview pada form
  if(isset($upload_error))
  { // Jika proses upload gagal
  }else
  {
    echo form_open('backend/import-siswa'); ?>
    <div id='kosong' class='col-md-12 col-xs-12'>
        <div class="alert alert-danger text-white" role="alert">
            KOLOM YANG DIBERI WARNA MERAH HARAP DIISI !
        </div>
    </div>
    <div class="card-body">
      <div class="table table-responsive">
        <table id="example1" class="table table-bordered table-striped">
          <thead class="text-center bg-dark">
            <tr>
              <th width="5%">NO</th>
              <th>NAMA</th>
              <th>NIS</th>
             </tr>
          </thead>
          <tbody>
            <?php
            $numrow = 1;
            $kosong = 0;
            $cek_id = 0;
            $no=1;

            // Array baru untuk menyimpan data unik berdasarkan 'nis'
            $uniqueData = [];
            // Loop melalui data yang diberikan
            foreach($sheet as $item)
            {
              // Gunakan 'nis' sebagai kunci array
              $nis = $item['B'];
              // Jika 'nis' belum ada dalam array $uniqueData, tambahkan data tersebut
              if(!isset($uniqueData[$nis]))
              {
                $uniqueData[$nis] = $item;
              }
            }

            // Ubah kembali array asosiatif menjadi indeks numerik
            $uniqueData = array_values($uniqueData);
            foreach($uniqueData as $row)
            {
              $nama = $row['A'];
              $nis = $row['B'];

               if($nama == "" && $nis == "")
                 continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

               if($numrow > 1)
               {
                  // Validasi apakah semua data telah diisi
                  $nama_td = ( ! empty($nama))? "" : " style='background: crimson;'"; // Jika NIS kosong, beri warna merah
                  $nis_td = ( ! empty($nis))? "" : " style='background: crimson;'"; // Jika NIS kosong, beri warna merah
                  $cek_nis = $this->siswa_model->cek_nis($nis);
                  
                  if($cek_nis)
                  {
                    $msg_nis = '<br><div class="badge badge-danger">NIS SUDAH TERDAFTAR</div>';
                  }else
                  {
                    $msg_nis = '';
                  }

                  if($nama == "" OR $nis == "")
                  {
                    $kosong++; // Tambah 1 variabel $kosong
                  }

                  if($cek_nis)
                  {
                    $cek_id++; 
                  }

                  echo "<tr>";
                    echo "<td class='text-center'>".$no++."</td>";
                    echo "<td".$nama_td." style='font-size: 12pt'>".$nama."</td>";
                    if(!empty($nis))
                    {
                      echo "<td".$nis_td." style='font-size: 12pt' align='center'>".$nis.$msg_nis."</td>";
                    }else
                    {
                      echo "<td".$nis_td." style='font-size: 12pt' align='center'>".$nis."</td>";
                    }               
                  echo "</tr>";
              }
              $numrow++;
          } ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php if($kosong > 0 OR $cek_id > 0)
        { ?>
        <script>
            $(document).ready(function(){
                // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                $("#kosong").show(); // Munculkan alert validasi kosong
            });
        </script>
  <?php }else{ ?>
        <button class='btn btn-primary btn-md btn-flat' type='submit' name='import' value="Import" style='margin-left:10px;margin-bottom:10px'><i class='fa fa-upload'></i> Import</button>
  <?php } ?>
  <?php echo form_close(); 
  }
}?>
</div>
</div>
</div>
</section>
</div>     
