<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?= $title; ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
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
              if($this->session->flashdata('msg-jenis-biaya'))
              {
                  echo pesan_sukses($this->session->flashdata('msg-jenis-biaya'));
              }elseif($this->session->flashdata('msg-gagal-jenis-biaya'))
              {
                  echo pesan_gagal($this->session->flashdata('msg-gagal-jenis-biaya'));
              }
            ?>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">FORM <?= strtoupper($title); ?></h3>
                </div>
                <?php echo form_open('backend/edit-jenis-biaya/'.$this->uri->segment('3')); ?>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">JENIS BIAYA *</label>
                        <div class="col-sm-5">
                            <input type="text" name="jenisbiaya" value="<?= $data->jenisbiaya; ?>" class="form-control" id="inputEmail3" placeholder="JENIS BIAYA">
                            <?php echo form_error('jenisbiaya'); ?>
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
                <div class="card-footer">
                  <button type="submit" name="submit" value="Submit" class="btn btn-info btn-flat"><i class="fa fa-check"></i> SIMPAN</button>
                  <a href="<?= base_url(); ?>backend/jenis-biaya" class="btn btn-danger btn-flat float-right"><i class="fa fa-arrow-left"></i> Batal</a>
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