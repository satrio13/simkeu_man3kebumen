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
            <li class="breadcrumb-item"><a href="<?= base_url('backend/kelas'); ?>">Kelas</a></li>
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
            if($this->session->flashdata('msg-kelas'))
            {
                echo pesan_sukses($this->session->flashdata('msg-kelas'));
            }elseif($this->session->flashdata('msg-gagal-kelas'))
            {
                echo pesan_gagal($this->session->flashdata('msg-gagal-kelas'));
            }
            ?>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">FORM <?= strtoupper($title); ?></h3>
                </div>
                <?php echo form_open('backend/edit-kelas/'.$this->uri->segment('3'), 'id="form"'); ?>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">KELAS *</label>
                        <div class="col-sm-5">
                            <input type="text" name="kelas" value="<?= $data->kelas; ?>" class="form-control required" placeholder="KELAS">
                            <?php echo form_error('kelas'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">TINGKAT *</label>
                        <div class="col-sm-5">
                            <select name="tingkat" class="form-control required">
                                <option value="X" <?php if($data->tingkat == 'X'){ echo'selected'; } ?> >X</option>
                                <option value="XI" <?php if($data->tingkat == 'XI'){ echo'selected'; } ?> >XI</option>
                                <option value="XII" <?php if($data->tingkat == 'XII'){ echo'selected'; } ?> >XII</option>
                            </select>
                            <?php echo form_error('tingkat'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">JURUSAN *</label>
                        <div class="col-sm-5">
                            <select name="id_jurusan" class="form-control required">
                                <?php foreach($jurusan as $r): ?>
                                    <option value="<?= $r->id_jurusan; ?>" <?php if($data->id_jurusan == $r->id_jurusan){ echo'selected'; } ?> ><?= $r->jurusan; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('id_jurusan'); ?>
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
                  <a href="<?= base_url(); ?>backend/kelas" class="btn btn-danger btn-flat float-right"><i class="fa fa-arrow-left"></i> BATAL</a>
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