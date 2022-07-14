<?php 
$ada = 0;
$kelas_siswa = kelas_siswa($siswa->id_siswa);
  foreach($kelas_siswa as $k):
    foreach($pemb_tiaptahun->result() as $r): 
      $cek = biaya($k->id_tahunpelajaran,$r->id_tagihan,tingkat($k->tingkat),$siswa->bsm);
      if($cek)
      { 
        $ada++; ?>
        <div class="col-md-4 bg-white border border-info mb-2">
          <div class="row">
            <div class="col-md-12 bg-secondary text-white text-bold">
            &raquo; <?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($k->id_tahunpelajaran); ?> KELAS <?= $k->tingkat; ?> )
            </div>
            <div class="col-md-4">
                Biaya
            </div>
            <div class="col-md-8">
              <?php echo form_open('backend/bayar/'.$this->uri->segment('3')); ?>
              : <?php
                  $biaya_tiaptahun = biaya($k->id_tahunpelajaran,$r->id_tagihan,tingkat($k->tingkat),$siswa->bsm);
                  $id_tagihan_tahunan = id_tagihan_tahunan($k->id_tahunpelajaran,$r->id_tagihan,0);
                  if($biaya_tiaptahun > 0){
                    echo number_format($biaya_tiaptahun, 0, ',', '.');
                  }else{
                    echo'<label class="badge badge-danger">BIAYA BELUM DISETTING</label>';
                  } 
                ?>
            </div>
            <?php if($biaya_tiaptahun > 0){ ?>
              <div class="col-md-4">
                Sudah Dibayar
              </div>
              <div class="col-md-8">
                : <?php
                  $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $siswa->id_siswa);
                  echo number_format($sudah_dibayar, 0, ',', '.');
                  ?>
              </div>
              <div class="col-md-4">
                Kurang
              </div>
              <div class="col-md-8">
                : <?php
                  $kurang = $biaya_tiaptahun - $sudah_dibayar;
                  echo number_format($kurang, 0, ',', '.');
                  ?>
              </div>
              <div class="col-md-4">
                Status
              </div>
              <div class="col-md-8">
                : <?php
                    if($kurang > 0 )
                    {
                      echo'<label class="badge badge-danger">BELUM LUNAS</label>';
                    }else
                    {
                      echo'<label class="badge badge-primary">LUNAS</label>';
                    }
                  ?>
              </div>
              <?php if($kurang > 0){ ?>
                <div class="col-md-12 text-bold">
                  PEMBAYARAN
                </div>
                <div class="col-md-4">
                  Tunai
                </div>
                <div class="col-md-8">
                  : <input type="hidden" name="id_siswa" value="<?= $siswa->id_siswa; ?>">
                    <input type="hidden" name="id_tagihan_tahunan" value="<?= $id_tagihan_tahunan; ?>">
                    <input type="hidden" name="kurang" value="<?= $kurang; ?>" min="0" max="<?= $kurang; ?>" required>
                    <input type="number" name="bayar" min="0" max="<?= $kurang; ?>" onkeypress="return hanyaAngka(event)" class="col-md-10">
                </div>
                <div class="col-md-4 mt-2">
                  dari Tabungan
                </div>
                <div class="col-md-8 mt-2">
                  : <input type="number" name="daritabungan" min="0" max="<?= tabungan($siswa->id_siswa); ?>" onkeypress="return hanyaAngka(event)" class="col-md-10" <?php if(tabungan($siswa->id_siswa) == 0){ echo'disabled'; } ?> >
                </div>
                <div class="col-md-4 mb-2 mt-2">
                    
                </div>
                <div class="col-md-8 mb-2 mt-2">
                  <button type="submit" name="submit" value="Submit" class="btn btn-flat btn-info btn-sm text-white text-bold ml-2">BAYARKAN</button>
                <?php echo form_close(); ?>
                </div>
            <?php } } ?>
          </div>
        </div>
    <?php } 
  endforeach; 
endforeach;

if( ( $ada == 0 ) OR ( $pemb_tiaptahun->num_rows() == 0 ) ){
  include('belum_ada_tagihan.php');
} ?>