<?php 
$ada = 0;
$siswa_smt = siswa_smt($siswa->id_siswa);
foreach($siswa_smt as $k): 
  foreach($pemb_semester->result() as $r): 
    $cek = biaya_semester($k->id_tahunpelajaran,$r->id_tagihan,$k->id_semester,tingkat($k->tingkat),$siswa->bsm);
    if($cek)
    { 
      $ada++; ?>
      <div class="col-md-4 bg-white border border-info mb-2">
        <div class="row">
          <div class="col-md-12 bg-secondary text-white text-bold">
          &raquo; <?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= $k->tahunpelajaran; ?> KELAS <?= $k->tingkat; ?> SEMESTER <?= semester($k->id_semester); ?> / <?= strtoupper($k->smt); ?> ) 
          </div>
          <div class="col-md-4">
              Biaya
          </div>
          <div class="col-md-8">
            <?php 
              echo form_open('backend/bayar/'.$this->uri->segment('3'));
              $id_tagihan_tahunan = id_tagihan_tahunan($k->id_tahunpelajaran,$r->id_tagihan,$k->id_semester);
              $biaya = biaya_semester($k->id_tahunpelajaran,$r->id_tagihan,$k->id_semester,tingkat($k->tingkat),$siswa->bsm);
              if($biaya > 0){
                echo ': '.number_format($biaya, 0, ',', '.'); 
              }else{
                echo': <label class="badge badge-danger">BIAYA BELUM DISETTING</label>';
              } 
            ?>
          </div>
          <?php if($biaya > 0){ ?>
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
                $kurang = $biaya - $sudah_dibayar;
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
                    <input type="hidden" name="id_semester" value="<?= $k->id_semester; ?>">
                    <input type="hidden" name="kurang" value="<?= $kurang; ?>" min="0" max="<?= $kurang; ?>" required>
                    <input type="number" name="bayar" min="0" max="<?= $kurang; ?>" onkeypress="return hanyaAngka(event)" class="col-md-10">
              </div>
              <div class="col-md-4 mt-2">
                dari Tabungan
              </div>
              <div class="col-md-8 mt-2">
                : <input type="number" name="daritabungan" min="0" max="<?= tabungan($siswa->id_siswa); ?>" onkeypress="return hanyaAngka(event)" class="col-md-10">
              </div>
              <div class="col-md-4 mt-2">
                Keterangan
              </div>
              <div class="col-md-8 mt-2 d-flex align-item-top">
                : <textarea name="keterangan" cols="30" class="ml-1"></textarea>
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

if( ( $ada == 0 ) OR ( $pemb_semester->num_rows() == 0 ) ){
  include('belum_ada_tagihan.php');
} ?>