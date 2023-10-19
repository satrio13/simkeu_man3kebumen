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
                if($this->session->flashdata('msg-bsm')){
                    echo pesan_sukses($this->session->flashdata('msg-bsm'));
                }elseif($this->session->flashdata('msg-gagal-bsm')){
                    echo pesan_gagal($this->session->flashdata('msg-gagal-bsm'));
                }
            ?>
            <div class="card">
                <div class="card-header bg-info">
                    <?php echo form_open('backend/setting-bsm'); ?>
                        <div class="row">
                            <div class="col-md-3 text-bold">
                                Tahun Pelajaran :
                                <select name="id_tahunpelajaran" class="form-control">
                                <?php foreach($tahun as $r): ?>
                                    <option value="<?= $r->id_tahunpelajaran; ?>" <?= set_select('id_tahunpelajaran',$r->id_tahunpelajaran); ?> ><?= $r->tahunpelajaran; ?></option>
                                <?php endforeach; ?>
                                </select>
                                <?= form_error('id_tahunpelajaran'); ?>
                            </div>
                            <div class="col-md-3 text-bold">
                                Kelas :
                                <select name="id_kelas" class="form-control">
                                <?php foreach($kelas as $r): ?>
                                    <option value="<?= $r->id_kelas; ?>" <?= set_select('id_kelas',$r->id_kelas); ?> ><?= $r->kelas; ?></option>
                                <?php endforeach; ?>
                                </select>
                                <?= form_error('id_kelas'); ?>
                            </div>
                            <div class="col-md-3"><br>
                                <button type="submit" name="submit" value="Submit" class="btn bg-dark btn-flat text-white border border-white"><i class="fa fa-search"></i> Cari Data</button>
                            </div>
                        </div>
                </div>
            <div class="card-body">
                <h3 class="text-center"><?= strtoupper($title); ?></h3>
                <div class="table table-responsive">
                <?php if(isset($submit)){ ?>
                    <table class="table" width="100%">
                        <tr>
                            <td width="15%" class="text-bold">Tahun Pelajaran</td>
                            <td width="2%" class="text-bold">:</td>
                            <td><?= tahun($this->input->post('id_tahunpelajaran', TRUE)); ?></td>
                        </tr>
                        <tr>
                            <td width="15%" class="text-bold">Kelas</td>
                            <td width="2%" class="text-bold">:</td>
                            <td><?= kelas($this->input->post('id_kelas', TRUE)); ?></td>
                        </tr>
                    </table>
                <?php } ?>
                    <table class="table table-bordered table-striped table-sm">
                        <thead class="bg-secondary text-center">
                            <tr>
                                <th width="5%">NO</th>
                                <th>NIS</th>
                                <th>NAMA</th>
                                <th width="20%">BSM</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($submit))
                        {
                            if($data->num_rows() > 0)
                            {
                                $no = 1; $i = 1;
                                foreach($data->result() as $r): 
                                    echo'<tr>
                                            <td class="text-center">'.$no.'</td>
                                            <td>'.$r->nis.'</td>
                                            <td>'.$r->nama.'</td>
                                            <td class="text-center">';
                                                if($r->bsm == 1)
                                                {
                                                    echo'<input type="checkbox" name="cek['.$i.']" value="1" class="check-item" checked>';
                                                }else
                                                {
                                                    echo'<input type="checkbox" name="cek['.$i.']" value="0" class="check-item">';
                                                }
                                            echo'<input type="hidden" name="id_siswa['.$i.']" value="'.$r->id_siswa.'">  
                                                <input type="hidden" name="no" value="'.$no.'">    
                                        </td>
                                    </tr>';
                                $no++; $i++; endforeach;
                                echo'<tr>
                                        <td colspan="3"></td>
                                        <td class="text-center">
                                            <button type="submit" name="submit" value="Trans" class="btn btn-flat bg-primary text-bold"><i class="fa fa-edit"></i> UPDATE</button>
                                        </td>
                                    </tr>';
                            }else
                            {
                                echo'<tr>
                                        <td colspan="4" class="text-center">HASIL PENCARIAN KOSONG</td>
                                    </tr>';
                            }                            
                        }else
                        {
                            echo'<tr>
                                    <td colspan="4" class="text-center">ANDA BELUM MELAKUKAN PENCARIAN</td>
                                </tr>';
                        } 
                        ?>
                        </tbody>
                    </table>
                    <?php echo form_close(); ?>
                </div>
            </div>  
        </div>
    </div>
</div>
</section>
</div>