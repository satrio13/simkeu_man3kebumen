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
            <div class="card">
                <div class="card-header bg-info">
                    <?php echo form_open('backend/laporan-persiswa'); ?>
                        <div class="row">
                            <div class="col-md-3 text-bold">
                                Tahun Pelajaran :
                                <select name="id_tahunpelajaran" class="form-control">
                                <?php foreach($tahun->result() as $r): ?>
                                    <option value="<?= $r->id_tahunpelajaran; ?>" <?= set_select('id_tahunpelajaran',$r->id_tahunpelajaran); ?> ><?= $r->tahunpelajaran; ?></option>
                                <?php endforeach; ?>
                                </select>
                                <?= form_error('id_tahunpelajaran'); ?>
                            </div>
                            <div class="col-md-3 text-bold">
                                Kelas :
                                <select name="id_kelas" class="form-control">
                                <?php foreach($kelas->result() as $r): ?>
                                    <option value="<?= $r->id_kelas; ?>" <?= set_select('id_kelas',$r->id_kelas); ?> ><?= $r->kelas; ?></option>
                                <?php endforeach; ?>
                                </select>
                                <?= form_error('id_kelas'); ?>
                            </div>
                            <div class="col-md-3"><br>
                                <button type="submit" name="submit" value="Submit" class="btn bg-dark btn-flat text-white border border-white"><i class="fa fa-search"></i> Cari Data</button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="card-body">
                    <br><h3 class="text-center"><?= strtoupper($title); ?></h3>
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
                    <table class="table table-bordered table-striped table-sm" id="datatable">
                        <thead class="bg-secondary text-center">
                            <tr>
                                <th width="5%">NO</th>
                                <th width="15%">NIS</th>
                                <th>NAMA</th>
                                <th width="15%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($submit))
                        {
                            if($data->num_rows() > 0)
                            {
                                $no = 1; 
                                foreach($data->result() as $r): 
                                echo'<tr>
                                        <td class="text-center">'.$no++.'</td>
                                        <td>'.$r->nis.'</td>
                                        <td>'.$r->nama.'</td>
                                        <td class="text-center">
                                            <a href="'.base_url("backend/cetak-laporan-persiswa-pdf/$r->id_siswa").'" target="_blank" class="btn bg-navy btn-flat btn-xs text-bold"><i class="fa fa-file-pdf"></i> CETAK PDF</a>
                                            <a href="'.base_url("backend/cetak-laporan-persiswa/$r->id_siswa").'" target="_blank" class="btn bg-info btn-flat btn-xs text-bold"><i class="fa fa-file-pdf"></i> CETAK</a>    
                                        </td>
                                    </tr>';
                                endforeach;
                            }else
                            {
                                echo'<tr>
                                    <td colspan="4" class="text-center text-danger text-bold">HASIL PENCARIAN KOSONG</td>
                                </tr>';
                            }
                        }else
                        {
                            echo'<tr>
                                    <td colspan="4" class="text-center text-danger">ANDA BELUM MELAKUKAN PENCARIAN</td>
                                </tr>';
                        } 
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