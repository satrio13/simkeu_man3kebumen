<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">GANTI PASSWORD</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('backend'); ?>">Home</a></li>
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
        if($this->session->flashdata('msg'))
        {
            echo pesan_sukses($this->session->flashdata('msg'));
        }elseif($this->session->flashdata('msg-gagal-ganti-password'))
        {
            echo pesan_gagal($this->session->flashdata('msg-gagal-ganti-password'));
        }
      ?>
     <!-- Horizontal Form -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">FORM <?= strtoupper($title); ?></h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <?php echo form_open('backend/ganti-password'); ?>
          <div class="card-body">
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">USERNAME *</label>
              <div class="col-sm-5">
                <input type="text" name="username" minlength="5" maxlength="30" readonly class="form-control sepasi" value="<?= $username; ?>">
                <?php echo form_error('username'); ?>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">PASSWORD BARU *</label>
              <div class="col-sm-5">
                <input type="password" name="pass1" value="<?= set_value('p1'); ?>" placeholder="Password Baru" class="form-control sepasi">
                <?php echo form_error('pass1'); ?>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">ULANG PASSWORD BARU *</label>
              <div class="col-sm-5">
                <input type="password" name="pass2" value="<?= set_value('p2'); ?>" placeholder="Ketik Ulang Password Baru" class="form-control sepasi">
                <?php echo form_error('pass2'); ?>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">PASSWORD LAMA *</label>
              <div class="col-sm-5">
                <input type="password" name="pass3" value="<?= set_value('p3'); ?>" placeholder="Password Lama" id="sepasi3" class="form-control">
                <?php echo form_error('pass3'); ?>
              </div>
            </div>
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <div class="form-check">
                    <label class="form-check-label" for="exampleCheck2">*) Field Wajib Diisi</label>
                    </div>
                </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" name="submit" value="Submit" class="btn btn-info btn-flat"><i class="fa fa-check"></i> SIMPAN</button>
                <button type="button" class='btn btn-danger btn-flat float-right' onclick='self.history.back()'><i class="fa fa-arrow-left"></i> BATAL</button>
            </div>
            <!-- /.card-footer -->
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