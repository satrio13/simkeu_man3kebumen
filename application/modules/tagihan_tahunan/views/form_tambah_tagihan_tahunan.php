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
            <li class="breadcrumb-item"><a href="<?= base_url('backend/tagihan-tahunan'); ?>">Tagihan Tahunan</a></li>
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
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">FORM <?= strtoupper($title); ?></h3>
                </div>
                <?php echo form_open('backend/tambah-tagihan-tahunan','id="form"'); ?>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">TAHUN PELAJARAN *</label>
                        <div class="col-sm-5">
                            <select name="id_tahunpelajaran" class="form-control required">
                                <?php foreach($tahunpelajaran as $r): ?>
                                    <option value="<?= $r->id_tahunpelajaran; ?>" <?= set_select('id_tahunpelajaran',$r->id_tahunpelajaran); ?> ><?= $r->tahunpelajaran; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('id_tahunpelajaran'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">TAGIHAN *</label>
                        <div class="col-sm-5">
                            <select name="id_tagihan" class="form-control required" id="id_tagihan">
                                <?php foreach($tagihan as $r): ?>
                                    <option value="<?= $r->id_tagihan; ?>" <?= set_select('id_tagihan',$r->id_tagihan); ?> ><?= $r->tagihan; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('id_tagihan'); ?>
                        </div>
                    </div>
                    <div class="form-group row" 
                      <?php 
                      if($submit AND $id_jenistagihan == 3){
                        
                      }else{
                        echo'style="display: none;"';
                      } ?>
                      id="id_semester">
                        <label class="col-sm-3 col-form-label">SEMESTER *</label>
                        <div class="col-sm-5">
                            <select name="id_semester" class="form-control">
                              <?php foreach($semester as $r): ?>
                                <option value="<?= $r->id_semester; ?>" <?= set_select('id_semester',$r->id_semester); ?> ><?= $r->semester; ?> / <?= $r->smt; ?></option>
                              <?php endforeach; ?>
                            </select>
                            <?php echo form_error('id_semester'); ?>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">BIAYA PERANGKATAN</label>
                        <div class="col-sm-5">
                            <input type="number" name="perangkatan" min="0" value="<?= set_value('perangkatan'); ?>" class="form-control" placeholder="BIAYA PERANGKATAN">
                            <?php echo form_error('perangkatan'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">BIAYA PERANGKATAN BSM</label>
                        <div class="col-sm-5">
                            <input type="number" name="perangkatan_bsm" min="0" value="<?= set_value('perangkatan_bsm'); ?>" class="form-control" placeholder="BIAYA PERANGKATAN BSM">
                            <?php echo form_error('perangkatan_bsm'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">BIAYA KELAS 10</label>
                        <div class="col-sm-5">
                            <input type="number" name="kelas10" min="0" value="<?= set_value('kelas10'); ?>" class="form-control" placeholder="BIAYA KELAS 10">
                            <?php echo form_error('kelas10'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">BIAYA KELAS 10 BSM</label>
                        <div class="col-sm-5">
                            <input type="number" name="kelas10_bsm" min="0" value="<?= set_value('kelas10_bsm'); ?>" class="form-control" placeholder="BIAYA KELAS 10 BSM">
                            <?php echo form_error('kelas10_bsm'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">BIAYA KELAS 11</label>
                        <div class="col-sm-5">
                            <input type="number" name="kelas11" min="0" value="<?= set_value('kelas11'); ?>" class="form-control" placeholder="BIAYA KELAS 11">
                            <?php echo form_error('kelas11'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">BIAYA KELAS 11 BSM</label>
                        <div class="col-sm-5">
                            <input type="number" name="kelas11_bsm" min="0" value="<?= set_value('kelas11_bsm'); ?>" class="form-control" placeholder="BIAYA KELAS 11 BSM">
                            <?php echo form_error('kelas11_bsm'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">BIAYA KELAS 12</label>
                        <div class="col-sm-5">
                            <input type="number" name="kelas12" min="0" value="<?= set_value('kelas12'); ?>" class="form-control" placeholder="BIAYA KELAS 12">
                            <?php echo form_error('kelas12'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">BIAYA KELAS 12 BSM</label>
                        <div class="col-sm-5">
                            <input type="number" name="kelas12_bsm" min="0" value="<?= set_value('kelas12_bsm'); ?>" class="form-control" placeholder="BIAYA KELAS 12 BSM">
                            <?php echo form_error('kelas12_bsm'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-sm-3 col-sm-10">
                          <label class="form-check-label" for="exampleCheck2">*) Field Wajib Diisi</label>  
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="submit" value="Submit" class="btn btn-info btn-flat"><i class="fa fa-check"></i> SIMPAN</button>
                  <a href="<?= base_url(); ?>backend/tagihan-tahunan" class="btn btn-danger btn-flat float-right"><i class="fa fa-arrow-left"></i> BATAL</a>
                </div>
              <?php echo form_close() ?>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>      