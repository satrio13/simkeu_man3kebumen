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
            <li class="breadcrumb-item"><a href="<?= base_url('backend/kelas-wali'); ?>">Wali Kelas</a></li>
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
            if($this->session->flashdata('msg-kelas-wali'))
            {
              echo pesan_sukses($this->session->flashdata('msg-kelas-wali'));
            }elseif($this->session->flashdata('msg-gagal-kelas-wali'))
            {
              echo pesan_gagal($this->session->flashdata('msg-gagal-kelas-wali'));
            }
            ?>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">FORM <?= strtoupper($title); ?></h3>
                </div>
                <?php echo form_open('backend/tambah-kelas-wali','id="form"'); ?>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">TAHUN PELAJARAN *</label>
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
                        <label class="col-sm-2 col-form-label">KELAS *</label>
                        <div class="col-sm-5">
                            <select name="id_kelas" class="form-control required">
                                <?php foreach($kelas as $r): ?>
                                    <option value="<?= $r->id_kelas; ?>" <?= set_select('id_kelas',$r->id_kelas); ?> ><?= $r->kelas; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('id_kelas'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">GURU *</label>
                        <div class="col-sm-5">
                            <select name="id_guru" class="form-control required">
                                <?php foreach($guru as $r): ?>
                                    <option value="<?= $r->id_guru; ?>" <?= set_select('id_guru',$r->id_guru); ?> ><?= $r->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('id_guru'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <label class="form-check-label" for="exampleCheck2">*) Field Wajib Diisi</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="submit" value="Submit" class="btn btn-info btn-flat"><i class="fa fa-check"></i> SIMPAN</button>
                  <a href="<?= base_url(); ?>backend/kelas-wali" class="btn btn-danger btn-flat float-right"><i class="fa fa-arrow-left"></i> BATAL</a>
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