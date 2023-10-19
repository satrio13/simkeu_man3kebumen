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
            if($this->session->flashdata('msg-user'))
            {
                echo pesan_sukses($this->session->flashdata('msg-user'));
            }elseif($this->session->flashdata('msg-gagal-user'))
            {
                echo pesan_gagal($this->session->flashdata('msg-gagal-user'));
            }
            ?>
            <div class="card">
                <div class="card-header">
                    <a href="<?= base_url('backend/tambah-user'); ?>" class="btn btn-primary text-white btn-flat"><i class="fa fa-plus"></i> TAMBAH USER</a>
                    <a href="" target="_self" class="btn bg-info btn-flat"><i class="fas fa-sync-alt"></i> REFRESH</a>
                    <br>
                    <h3 class="text-center"><?= strtoupper($title); ?></h3>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped table-sm" id="datatable">
                            <thead class="bg-secondary text-center">
                            <tr>
                                <th width="5%">NO</th>
                                <th>NAMA</th>
                                <th>NIP</th>
                                <th>USERNAME</th>
                                <th>EMAIL</th>
                                <th>LEVEL</th>
                                <th>STATUS</th>
                                <th>FOTO</th>
                                <th>TANDA TANGAN</th>
                                <th>AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $no = 1; 
                            foreach($data->result() as $r):
                                if($r->is_active == '1')
                                {
                                    $is_active = '<span class="badge badge-primary">Aktif</span>';
                                }else
                                {
                                    $is_active = '<span class="badge badge-danger">Non Aktif</span>';
                                }

                                if($r->gambar != '' AND file_exists("assets/img/user/$r->gambar"))
                                {  
                                    $foto = '<a href="'.base_url("assets/img/user/$r->gambar").'" target="_blank"><img src="'.base_url("assets/img/user/$r->gambar").'" width="100px"></a>';
                                }else
                                {
                                    $foto = '';
                                }

                                if($r->ttd != '' AND file_exists("assets/img/ttd/$r->ttd"))
                                {  
                                    $ttd = '<img src="'.base_url("assets/img/ttd/$r->ttd").'" width="100px"><a href="'.base_url("backend/ttd/$r->id_user").'"><b>Edit TTD</b></a>';
                                }else
                                {
                                    $ttd = '<a href="'.base_url("backend/ttd/$r->id_user").'"><b>Tambah TTD</b></a>';
                                }

                                if($r->id_user == 16)
                                {
                                    $hapus = '';
                                }else
                                {
                                    $hapus = ' <a href="javascript:void(0)" class="btn btn-danger btn-xs btn-flat text-white" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="'.base_url("backend/hapus-user/$r->id_user").'" title="HAPUS DATA">HAPUS</a>';
                                }
                                echo'<tr>
                                        <td class="text-center">'.$no++.'</td>
                                        <td>'.$r->nama.'</td>
                                        <td>'.$r->nip.'</td>
                                        <td>'.$r->username.'</td>
                                        <td>'.$r->email.'</td>
                                        <td>'.$r->level.'</td>
                                        <td class="text-center">'.$is_active.'</td>
                                        <td class="text-center">'.$foto.'</td>
                                        <td class="text-center">'.$ttd.'</td>
                                        <td class="text-center" nowrap>
                                            <a href="'.base_url("backend/edit-user/$r->id_user").'" class="btn btn-dark btn-xs btn-flat" title="EDIT DATA">EDIT</a>'.$hapus.'
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