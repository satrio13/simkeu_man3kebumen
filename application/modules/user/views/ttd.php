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
            <li class="breadcrumb-item"><a href="<?= base_url('backend/users'); ?>">Users</a></li>
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
            if($this->session->flashdata('msg-gagal-ttd'))
            {
                echo pesan_gagal($this->session->flashdata('msg-gagal-ttd'));
            }
            ?>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">FORM <?= strtoupper($title); ?></h3>
                </div>
                <?php echo form_open_multipart('backend/ttd/'.$this->uri->segment('3')); ?>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">FILE TTD *</label>
                        <div class="col-sm-5">
                        <?php if(empty($data->ttd)){ ?>
                            <img class='img-responsive' id='preview_gambar' width='150px'>
                        <?php }else{ ?>
                            File Sekarang: <img class='img-responsive mb-2' id='preview_gambar' width='150px' src="<?= base_url(); ?>assets/img/ttd/<?= $data->ttd; ?>">
                        <?php } ?>
                        <input type='file' class='form-control' name='ttd' accept='image/png, image/jpeg' onchange='readURL(this);' required>
                        <p style="color: red"> *) format file JPG/PNG ukuran maksimal 1 MB</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="submit" value="Submit" class="btn btn-info btn-flat"><i class="fa fa-check"></i> SIMPAN</button>
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