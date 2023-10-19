<?php
if(isset($_POST['submit']))
{
  $id_tahunpelajaran = $this->input->post('id_tahunpelajaran', TRUE);
  $id_kelas = $this->input->post('id_kelas', TRUE);
  $id_guru = $this->input->post('id_guru', TRUE);
}else
{
  $id_tahunpelajaran = $data->id_tahunpelajaran;
  $id_kelas = $data->id_kelas;
  $id_guru = $data->id_guru;
}
?>
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
                <?php echo form_open('backend/edit-kelas-wali/'.$this->uri->segment('3'), 'id="form"'); ?>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">TAHUN PELAJARAN <span class="text-danger">*</span></label>
                        <div class="col-sm-5">
                            <select name="id_tahunpelajaran" class="form-control required">
                                <?php foreach($tahunpelajaran as $r): ?>
                                    <option value="<?= $r->id_tahunpelajaran; ?>" <?php if($id_tahunpelajaran == $r->id_tahunpelajaran){ echo'selected'; } ?> ><?= $r->tahunpelajaran; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('id_tahunpelajaran'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">KELAS <span class="text-danger">*</span></label>
                        <div class="col-sm-5">
                            <select name="id_kelas" class="form-control required">
                                <?php foreach($kelas as $r): ?>
                                    <option value="<?= $r->id_kelas; ?>" <?php if($id_kelas == $r->id_kelas){ echo'selected'; } ?> ><?= $r->kelas; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('id_kelas'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">GURU <span class="text-danger">*</span></label>
                        <div class="col-sm-5">
                            <select name="id_guru" class="form-control required">
                                <?php foreach($guru as $r): ?>
                                    <option value="<?= $r->id_guru; ?>" <?php if($id_guru == $r->id_guru){ echo'selected'; } ?> ><?= $r->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('id_guru'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <span class="text-danger"><b>*</b></span>) Field Wajib Diisi
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