<!-- Content Wrapper. Contains page content -->
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
            <?php echo form_open_multipart('backend/tambah-user','id="form-user"'); ?>
                <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NAMA *</label>
                    <div class="col-sm-5">
                      <input type='text' name='nama' maxlength="100" class='form-control required' placeholder='Nama' value="<?= set_value('nama'); ?>">
                      <?php echo form_error('nama'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NIP</label>
                    <div class="col-sm-5">
                      <input type='text' name='nip' maxlength="30" class='form-control' placeholder='NIP' value="<?= set_value('nip'); ?>">
                      <?php echo form_error('nip'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">USERNAME *</label>
                    <div class="col-sm-5">
                    <input type='text' name='username' class='form-control sepasi required' minlength="5" maxlength="30" placeholder='Username' value="<?= set_value('username'); ?>" autocomplete="off">
                    <?php echo form_error('username'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">PASSWORD *</label>
                    <div class="col-sm-5">
                    <input type='password' name='password1' id="password1" class='form-control sepasi required' minlength="5" maxlength="30" placeholder='Password' value="<?= set_value('password1'); ?>" autocomplete="off">
                    <?php echo form_error('password1'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ULANG PASSWORD *</label>
                    <div class="col-sm-5">
                    <input type='password' name='password2' id="password2" class='form-control sepasi required' minlength="5" maxlength="30" placeholder='Ulang Password' value="<?= set_value('password2'); ?>" autocomplete="off">
                    <?php echo form_error('password2'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">EMAIL *</label>
                    <div class="col-sm-5">
                    <input type='email' name='email' maxlength="100" class='form-control sepasi required' placeholder='Email' value="<?= set_value('email'); ?>"><?php echo form_error('email'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">LEVEL USER *</label>
                    <div class="col-sm-5">
                        <select name="level" class="form-control required">
                            <option value="operator" <?= set_select('level','operator'); ?> >Operator</option>
                        </select>
                        <?php echo form_error('level'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">FOTO</label>
                    <div class="col-sm-5">
                        <img class='img-responsive' id='preview_gambar' width='150px'>
                        <input type='file' name='gambar' id='file-upload' accept='image/png, image/jpeg' class='form-control' onchange='readURL(this);'>
                        <small style="color: red"> *) format file JPG/PNG ukuran maksimal 1 MB</small>
                    </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-2 col-form-label">STATUS AKTIF *</label>
                      <div class="col-sm-5">
                          <div class="icheck-primary d-inline">
                              <input type="radio" name="is_active" value="1" id="radioPrimary1" <?= set_radio('is_active',1); ?> required> 
                              <label for="radioPrimary1">Aktif</label> 
                              &nbsp;&nbsp;&nbsp; 
                          </div>
                          <div class="icheck-primary d-inline">
                              <input type="radio" name="is_active" value="0" id="radioPrimary2" <?= set_radio('is_active',0); ?> required> 
                              <label for="radioPrimary2">Non Aktif</label>
                          </div>
                          <br><label for="is_active" class="error"></label>
                          <?php echo form_error('is_active'); ?>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <label class="form-check-label" for="exampleCheck2">*) Field Wajib Diisi</label>  
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