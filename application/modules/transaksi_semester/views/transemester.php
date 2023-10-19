<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?= $title; ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                if($this->session->flashdata('msg-trsemester')){
                    echo pesan_sukses($this->session->flashdata('msg-trsemester'));
                }elseif($this->session->flashdata('msg-gagal-trsemester')){
                    echo pesan_gagal($this->session->flashdata('msg-gagal-trsemester'));
                }
            ?>
            <div class="card col-md-12">
            <?php echo form_open('backend/trans-semester'); ?>
                <div class="row">
                    <div class="col-md-6 bg-light pb-2">
                        <div class="row">
                            <div class="col-md-12 text-bold bg-info p-1 text-center text-white">
                            DARI
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-bold mt-2">
                            TAHUN PELAJARAN
                            </div>                        
                            <div class="col-md-6 mt-2">
                                <select name="id_tahunpelajaran" class="form-control">
                                    <option value="0" <?= set_select('id_tahunpelajaran', 0); ?> >Belum Punya TP</option>
                                    <?php foreach($tahun->result() as $r): ?>
                                        <option value="<?= $r->id_tahunpelajaran; ?>" <?= set_select('id_tahunpelajaran', $r->id_tahunpelajaran); ?> ><?= $r->tahunpelajaran; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div> 
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6 text-bold mt-2">
                            KELAS
                            </div>                        
                            <div class="col-md-6">
                                <select name="id_kelas" class="form-control">
                                    <option value="0" <?= set_select('id_kelas', 0); ?> >Belum Punya Kelas</option>
                                    <?php foreach($kelas->result() as $r): ?>
                                        <option value="<?= $r->id_kelas; ?>" <?= set_select('id_kelas', $r->id_kelas); ?> ><?= $r->kelas; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-6 pb-2">
                        <div class="row">
                            <div class="col-md-12 text-bold text-white bg-danger p-1 text-center">
                            KE
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-bold mt-2">
                            TAHUN PELAJARAN
                            </div>                        
                            <div class="col-md-6 mt-2">
                                <select name="id_tahunpelajaran2" class="form-control">
                                    <?php foreach($tahun->result() as $r): ?>
                                        <option value="<?= $r->id_tahunpelajaran; ?>" <?= set_select('id_tahunpelajaran2', $r->id_tahunpelajaran); ?> ><?= $r->tahunpelajaran; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div> 
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6 text-bold mt-2">
                            KELAS
                            </div>                        
                            <div class="col-md-6">
                                <select name="id_kelas2" class="form-control">
                                    <?php foreach($kelas->result() as $r): ?>
                                        <option value="<?= $r->id_kelas; ?>" <?= set_select('id_kelas2', $r->id_kelas); ?> ><?= $r->kelas; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div> 
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12 text-bold text-right mt-2">
                               <button type="submit" name="cari" value="Cari" class="btn btn-flat btn-info"><i class="fa fa-search"></i> CARI DATA</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">PILIH SISWA</h3>
                    <div class="table table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="bg-secondary text-center">
                            <tr>
                                <th width="5%" nowrap>NO</th>
                                <th nowrap>NIS</th>
                                <th nowrap>NAMA</th>
                                <th nowrap>TAHUN PELAJARAN</th>
                                <th nowrap>KELAS</th>
                                <th width="20%" nowrap>AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $cari = $this->input->post('cari', TRUE);
                            if(isset($cari))
                            { 
                                $jumlah = $data->num_rows();
                                if($jumlah > 0)
                                {   
                                    $id_tahunpelajaran2 = strip_tags($this->input->post('id_tahunpelajaran2',true));
		                            $id_kelas2 = strip_tags($this->input->post('id_kelas2',true));
                                    $id_kelas_wali = id_kelas_wali($id_tahunpelajaran2,$id_kelas2);
                                    if(!$id_kelas_wali)
                                    {
                                        echo'<div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <b>WARNING : </b><br>KELAS TUJUAN BELUM PUNYA WALI KELAS, MOHON TAMBAHKAN DATA WALI KELASNYA TERLEBIH DAHULU
                                            </div>';
                                    }
                                    $no=1; $i=1; foreach($data->result() as $r): ?>
                                        <tr>
                                            <td class="text-center"><?= $no; ?></td>
                                            <td><?= $r->nis; ?></td>
                                            <td><?= $r->nama; ?></td>
                                            <td><?php
                                                if($this->input->post('id_tahunpelajaran',true) != 0){
                                                    echo $r->tahunpelajaran;
                                                }else{
                                                    
                                                } 
                                                ?>
                                            </td>
                                            <td><?php
                                                if($this->input->post('id_kelas',true) != 0){
                                                    echo $r->kelas;
                                                }else{

                                                } 
                                                ?>
                                            </td>    
                                            <td class="text-center">
                                                <?php 
                                                if($id_kelas_wali)
                                                {
                                                    echo"<div class='icheck-primary'>
                                                            <input type='checkbox' class='check-item' id='todoCheck[$i]' name='cek[$i]' value='$r->id_siswa'>
                                                            <input type='hidden' name='no' value=$no>    
                                                            <label for='todoCheck[$i]'>Klik Disini</label>
                                                        </div>";
                                                } 
                                                ?>
                                            </td>                                
                                        </tr>
                                    <?php $i++; $no++; endforeach; ?>
                                        <tr>  
                                            <td class="text-center" colspan="5"></td>
                                            <td class="text-center text-bold">
                                            <?php if($id_kelas_wali){ ?>   
                                                <button type="submit" name="trans" value="Trans" class="btn btn-flat btn-sm mb-1 bg-primary text-bold"><i class="fa fa-arrow-up"></i> TRANSAKSIKAN</button> 
                                                <label class="bg-info p-1 text-white">
                                                    CHECK ALL <input type="checkbox" id="check-all">
                                                </label>
                                            <?php } ?>
                                            </td>
                                        </tr>
                                <?php }else{
                                    echo'<td class="text-center text-danger text-bold" colspan="6">DATA KOSONG</td>';
                                }
                            }else{
                                echo'<td class="text-center text-danger text-bold" colspan="6">ANDA BELUM MENCARI DATA</td>';
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</section>
</div>
<?php echo form_close(); ?>