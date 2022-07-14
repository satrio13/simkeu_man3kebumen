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
            if($this->session->flashdata('msg-tahun'))
            {
                echo pesan_sukses($this->session->flashdata('msg-tahun'));
            }elseif($this->session->flashdata('msg-gagal-tahun'))
            {
                echo pesan_gagal($this->session->flashdata('msg-gagal-tahun'));
            }
            ?>
            <div class="card">
                <div class="card-header">
                    <a href="<?= base_url(); ?>backend/tambah-tahun" class="btn bg-primary btn-flat text-white"><i class="fa fa-plus"></i> TAMBAH TAHUN PELAJARAN</a>
                    <a href="" target="_self" class="btn bg-info btn-flat"><i class="fas fa-sync-alt"></i> REFRESH</a>
                    <br>
                    <h3 class="text-center"><?= strtoupper($title); ?></h3>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped" id="datatable">
                            <thead class="bg-secondary text-center">
                                <tr>
                                    <th width="5%" nowrap>NO</th>
                                    <th nowrap>TAHUN PELAJARAN</th>
                                    <th width="15%" nowrap>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                            foreach($data as $r):
                                echo'<tr>
                                        <td class="text-center">'.$no++.'.</td>
                                        <td>'.$r->tahunpelajaran.'</td>
                                        <td class="text-center">
                                            <a href="'.base_url("backend/edit-tahun/$r->id_tahunpelajaran").'" class="btn btn-dark btn-xs btn-flat" title="EDIT DATA">EDIT</a>
                                            <a href="javascript:void(0)" class="btn btn-danger btn-xs btn-flat text-white" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="'.base_url('backend/hapus-tahun/'.$r->id_tahunpelajaran.'').'" title="HAPUS DATA">HAPUS</a>
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