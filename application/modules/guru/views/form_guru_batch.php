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
            <li class="breadcrumb-item"><a href="<?= base_url('backend/guru'); ?>">Guru</a></li>
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
                if($this->session->flashdata('msg-guru'))
                {
                    echo pesan_sukses($this->session->flashdata('msg-guru'));
                }elseif($this->session->flashdata('msg-gagal-guru'))
                {
                    echo pesan_gagal($this->session->flashdata('msg-gagal-guru'));
                }
            ?>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">FORM <?= strtoupper($title); ?></h3>
                </div>
                <?php echo form_open("backend/guru-batch/$jml"); ?>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                      <thead class="bg-secondary text-center">
                        <tr>
                          <th width="10%">NO</th>
                          <th>NAMA LENGKAP *</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php for($i=1; $i<=$jml; $i++){ ?>
                        <tr>
                          <td class="text-center"><?= $i; ?>.</td>
                          <td>
                              <input type="text" name="nama[<?= $i; ?>]" value="<?= set_value("nama[$i]"); ?>" class="form-control" placeholder="NAMA LENGKAP">
                              <?= form_error("nama[$i]"); ?>
                          </td>
                        </tr>
                      <?php } ?>
                        <tr>
                          <td colspan="5">
                            <button type="submit" name="submit" value="Submit" class="btn btn-info btn-flat"><i class="fa fa-check"></i> SIMPAN</button>
                            <a href="<?= base_url(); ?>backend/guru" class="btn btn-danger btn-flat float-right"><i class="fa fa-arrow-left"></i> Batal</a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
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