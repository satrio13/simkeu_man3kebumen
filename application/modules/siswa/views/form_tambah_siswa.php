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
            <li class="breadcrumb-item"><a href="<?= base_url('backend/siswa'); ?>">Siswa</a></li>
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
            if($this->session->flashdata('msg-siswa'))
            {
                echo pesan_sukses($this->session->flashdata('msg-siswa'));
            }elseif($this->session->flashdata('msg-gagal-siswa'))
            {
                echo pesan_gagal($this->session->flashdata('msg-gagal-siswa'));
            }
            ?>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">FORM <?= strtoupper($title); ?></h3>
                </div>
                <?php echo form_open('backend/tambah-siswa','id="form"'); ?>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">NAMA LENGKAP <span class="text-danger">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="nama" maxlength="100" value="<?= set_value('nama'); ?>" class="form-control required" placeholder="NAMA LENGKAP">
                            <?php echo form_error('nama'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">NIS <span class="text-danger">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="nis" maxlength="30" value="<?= set_value('nis'); ?>" class="form-control required" placeholder="NIS">
                            <?php echo form_error('nis'); ?>
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
                  <a href="<?= base_url(); ?>backend/siswa" class="btn btn-danger btn-flat float-right"><i class="fa fa-arrow-left"></i> BATAL</a>
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