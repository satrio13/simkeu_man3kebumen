<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?= $title; ?></h1>
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

<section class="content">
    <div class="row">
        <div class="col-12">
            <?php 
            if($this->session->flashdata('msg-pembayaran'))
            {
                echo pesan_sukses($this->session->flashdata('msg-pembayaran'));
            }elseif($this->session->flashdata('msg-gagal-pembayaran'))
            {
                echo pesan_gagal($this->session->flashdata('msg-gagal-pembayaran'));
            }
            ?>
            <div class="card">
                <div class="card-header bg-dark">
                    <?php echo form_open('backend/pembayaran'); ?>
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="nis" value="<?= set_value('nis'); ?>" placeholder="NIS" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" name="submit" value="Submit" class="btn btn-primary btn-flat text-white border border-white text-bold"><i class="fa fa-search"></i> CARI SISWA</button>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="" target="_self" class="btn bg-info btn-flat text-white border border-white"><i class="fas fa-sync-alt"></i> REFRESH</a>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="card-body">
                    <h3 class="text-center"><?= strtoupper($title); ?></h3>
                    <h5 class="text-center">(1000 Transaksi Terakhir)</h5>
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped table-sm" id="table-pembayaran">
                            <thead class="bg-secondary text-center">
                                <tr>
                                    <th width="5%" nowrap>NO</th>
                                    <th nowrap>TANGGAL</th>
                                    <th nowrap>JML SETORAN</th>
                                    <th nowrap>NIS</th>
                                    <th nowrap>NAMA</th>
                                    <th nowrap>KELAS</th>
                                    <th nowrap>GUNA MEMBAYAR</th>
                                    <th nowrap>KETERANGAN</th>
                                    <th nowrap>PETUGAS</th>
                                    <th nowrap>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</section>
</div>

<div class="modal fade mt-5" id="konfirmasi_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
               <b>Anda yakin ingin menghapus data ini ?</b><br><br>
               <a class="btn btn-danger btn-ok"> Hapus</a>
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
            </div>
        </div>
    </div>
</div>