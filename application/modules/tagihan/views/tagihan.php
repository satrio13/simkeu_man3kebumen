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
            if($this->session->flashdata('msg-tagihan'))
            {
                echo pesan_sukses($this->session->flashdata('msg-tagihan'));
            }elseif($this->session->flashdata('msg-gagal-tagihan'))
            {
                echo pesan_gagal($this->session->flashdata('msg-gagal-tagihan'));
            }
            ?>
            <div class="card">
                <div class="card-header">
                    <a href="<?= base_url(); ?>backend/tambah-tagihan" class="btn bg-primary btn-flat text-white"><i class="fa fa-plus"></i> TAMBAH TAGIHAN</a>
                    <a href="" target="_self" class="btn bg-info btn-flat"><i class="fas fa-sync-alt"></i> REFRESH</a>
                    <br>
                    <h3 class="text-center"><?= strtoupper($title); ?></h3>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped table-sm" id="datatable">
                            <thead class="bg-secondary text-center">
                                <tr>
                                    <th width="5%" nowrap>NO</th>
                                    <th nowrap>TAGIHAN</th>
                                    <th nowrap>JENIS TAGIHAN</th>
                                    <th width="15%" nowrap>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                            foreach($data as $r):
                                echo'<tr>
                                        <td class="text-center">'.$no++.'.</td>
                                        <td>'.$r->tagihan.'</td>
                                        <td>'.$r->jenistagihan.'</td>
                                        <td class="text-center">
                                            <a href="'.base_url("backend/edit-tagihan/$r->id_tagihan").'" class="btn btn-dark btn-xs btn-flat" title="EDIT DATA">EDIT</a>
                                            <a href="javascript:void(0)" class="btn btn-danger btn-xs btn-flat text-white" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="'.base_url('backend/hapus-tagihan/'.$r->id_tagihan.'').'" title="HAPUS DATA">HAPUS</a>
                                        </td>
                                    </tr>';
                            endforeach;
                            ?>
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