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
            if($this->session->flashdata('msg-tagihan-tahunan'))
            {
                echo pesan_sukses($this->session->flashdata('msg-tagihan-tahunan'));
            }elseif($this->session->flashdata('msg-gagal-tagihan-tahunan'))
            {
                echo pesan_gagal($this->session->flashdata('msg-gagal-tagihan-tahunan'));
            }
            ?>
            <div class="card">
                <div class="card-header">
                    <a href="<?= base_url(); ?>backend/tambah-tagihan-tahunan" class="btn bg-primary btn-flat text-white"><i class="fa fa-plus"></i> TAMBAH TAGIHAN TAHUNAN</a>
                    <a href="" target="_self" class="btn bg-info btn-flat"><i class="fas fa-sync-alt"></i> REFRESH</a>
                    <br>
                    <h3 class="text-center"><?= strtoupper($title); ?></h3>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped" id="table-tagihan-tahunan">
                            <thead class="bg-secondary text-center">
                                <tr>
                                    <th width="5%" nowrap>NO</th>
                                    <th nowrap>TP</th>
                                    <th nowrap>TAGIHAN</th>
                                    <th nowrap>PERANGKATAN</th>
                                    <th nowrap>PERANGKATAN BSM</th>
                                    <th nowrap>KELAS 10</th>
                                    <th nowrap>KELAS 10 BSM</th>
                                    <th nowrap>KELAS 11</th>
                                    <th nowrap>KELAS 11 BSM</th>
                                    <th nowrap>KELAS 12</th>
                                    <th nowrap>KELAS 12 BSM</th>
                                    <th width="20%" nowrap>AKSI</th>
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

<div class="modal fade" id="konfirmasi_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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