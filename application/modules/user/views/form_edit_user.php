<?php
$nama = isset($_POST['submit']) ? $this->input->post('nama', TRUE) : $data->nama;
$nip = isset($_POST['submit']) ? $this->input->post('nip', TRUE) : $data->nip;
$username = isset($_POST['submit']) ? $this->input->post('username', TRUE) : $data->username;
$email = isset($_POST['submit']) ? $this->input->post('email', TRUE) : $data->email;
$is_active = isset($_POST['submit']) ? $this->input->post('is_active', TRUE) : $data->is_active;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= strtoupper($title); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('backend'); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('backend/users'); ?>">Users</a></li>
              <li class="breadcrumb-item active"><?= $title; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<section class="content">
  <div class="row">
    <div class="col-md-12">
            <?php 
            if($this->session->flashdata('msg-user'))
            {
              echo pesan_sukses($this->session->flashdata('msg-user'));
            }elseif($this->session->flashdata('msg-gagal-user'))
            {
              echo pesan_gagal($this->session->flashdata('msg-gagal-user'));
            }
            ?>
            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">FORM <?= strtoupper($title); ?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            <?php echo form_open_multipart('backend/edit-user/'.$this->uri->segment('3'), 'id="form-user"'); ?>
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NAMA <span class="text-danger">*</span></label>
                    <div class="col-sm-5">
                      <input type='text' name='nama' maxlength="100" class='form-control required' placeholder='Nama' value="<?= $nama; ?>">
                      <?php echo form_error('nama'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NIP</label>
                    <div class="col-sm-5">
                      <input type='text' name='nip' maxlength="50" class='form-control' placeholder='NIP' value="<?= $nip; ?>">
                      <?php echo form_error('nip'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">USERNAME <span class="text-danger">*</span></label>
                    <div class="col-sm-5">
                    <input type='text' name='username' class='form-control sepasi required' minlength="5" maxlength="30" placeholder='Username' value="<?= $username; ?>" autocomplete="off"><?php echo form_error('username'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">PASSWORD</label>
                    <div class="col-sm-5">
                    <input type='password' name='password' class='form-control sepasi' minlength="5" maxlength="30" placeholder='* Kosongkan jika password tidak ingin diganti.' autocomplete="off"><?php echo form_error('password'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">EMAIL <span class="text-danger">*</span></label>
                    <div class="col-sm-5">
                    <input type='email' name='email' maxlength="100" class='form-control sepasi required' placeholder='Email' value="<?= $email; ?>"><?php echo form_error('email'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">LEVEL USER <span class="text-danger">*</span></label>
                    <div class="col-sm-5">
                        <select name="level" class="form-control required">
                          <?php 
                          if($data->level == 'superadmin')
                          {
                            echo'<option value="superadmin">Super Admin</option>';
                          }else
                          {
                            echo'<option value="operator">Operator</option>';
                          }
                          ?>
                        </select>
                        <?php echo form_error('level'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">FOTO</label>
                    <div class="col-sm-5">
                      <?php if(empty($data->gambar)){ ?>
                          <img class='img-responsive' id='preview_gambar' width='150px'>
                      <?php }else{ ?>
                          <img class='img-responsive' id='preview_gambar' width='150px' src="<?= base_url("assets/img/user/$data->gambar"); ?>">
                      <?php } ?>
                      <input type='file' name='gambar' id='file-upload' accept='image/png, image/jpeg' class='form-control' onchange='readURL(this);'>
                      <small style="color: red"> *) format file JPG/PNG ukuran maksimal 1 MB</small>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">STATUS AKTIF <span class="text-danger">*</span></label>
                    <div class="col-sm-5">
                        <div class="icheck-primary d-inline">
                            <input type="radio" name="is_active" value="1" id="radioPrimary1" <?php if($is_active == '1'){ ?> checked <?php } ?> required> 
                            <label for="radioPrimary1">Aktif</label> 
                            &nbsp;&nbsp;&nbsp; 
                        </div>
                        <div class="icheck-primary d-inline">
                            <input type="radio" name="is_active" value="0" id="radioPrimary2" <?php if($is_active == '0'){ ?> checked <?php } ?> required> 
                            <label for="radioPrimary2">Non Aktif</label>
                        </div>
                        <br><label for="is_active" class="error"></label>
                        <?php echo form_error('is_active'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <span class="text-danger"><b>*</b></span>) Field Wajib Diisi
                      </div>
                  </div>
              </div>
              <div class="card-footer">
                <button type="submit" name="submit" value="Submit" class="btn btn-info btn-flat" onclick="return VerifyUploadSizeIsOK()"><i class="fa fa-check"></i> SIMPAN</button>
                <a href="<?= base_url('backend/users'); ?>" class="btn btn-danger btn-flat float-right"><i class="fa fa-arrow-left"></i> BATAL</a>
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
