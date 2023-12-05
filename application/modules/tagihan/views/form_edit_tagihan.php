<?php
$tagihan = isset($_POST['submit']) ? $this->input->post('tagihan', TRUE) : $data->tagihan;
$id_jenistagihan = isset($_POST['submit']) ? $this->input->post('id_jenistagihan', TRUE) : $data->id_jenistagihan;
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
            <li class="breadcrumb-item"><a href="<?= base_url('backend/tagihan'); ?>">Tagihan</a></li>
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
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">FORM <?= strtoupper($title); ?></h3>
                </div>
                <?php echo form_open('backend/edit-tagihan/'.$this->uri->segment('3'), 'id="form"'); ?>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">NAMA TAGIHAN <span class="text-danger">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="tagihan" value="<?= $tagihan; ?>" maxlength="30" class="form-control required" placeholder="NAMA TAGIHAN">
                            <?php echo form_error('tagihan'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">JENIS TAGIHAN <span class="text-danger">*</span></label>
                        <div class="col-sm-5">
                            <select name="id_jenistagihan" class="form-control required">
                                <?php foreach($jenistagihan as $r): ?>
                                    <option value="<?= $r->id_jenistagihan; ?>" <?php if($id_jenistagihan == $r->id_jenistagihan){ echo'selected'; } ?> ><?= $r->jenistagihan; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('id_tagihan'); ?>
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
                  <a href="<?= base_url(); ?>backend/tagihan" class="btn btn-danger btn-flat float-right"><i class="fa fa-arrow-left"></i> BATAL</a>
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
