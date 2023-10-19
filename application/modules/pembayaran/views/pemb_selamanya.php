<?php 
$cek = 0;
foreach($pemb_sekaliselamanya->result() as $r): 
  $tahun = tahun_ks($siswa->id_siswa);
  foreach($tahun as $k):
    $id_tahun_kelas10 = id_tahun_kelas10($siswa->id_siswa);
    $id_tahun_kelas11 = id_tahun_kelas11($siswa->id_siswa);
    $id_tahun_kelas12 = id_tahun_kelas12($siswa->id_siswa);
    
    $cek_1 = biaya($id_tahun_kelas10,$r->id_tagihan,1,$siswa->bsm);
    $cek_2 = biaya($id_tahun_kelas11,$r->id_tagihan,2,$siswa->bsm);
    $cek_3 = biaya($id_tahun_kelas12,$r->id_tagihan,3,$siswa->bsm);

    if($cek_1)
    { 
      $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas10,$r->id_tagihan,0);
      $biaya = biaya($id_tahun_kelas10,$r->id_tagihan,1,$siswa->bsm);
      $cek++; ?>
      <div class="col-md-4 bg-white border border-info mb-2">
        <div class="row">
          <div class="col-md-12 bg-secondary text-white text-bold">
            &raquo; <?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahun_kelas10); ?> KELAS X )
          </div>
          <div class="col-md-4">
            Biaya
          </div>
          <div class="col-md-8">
            <?php 
              echo form_open('backend/bayar/'.$this->uri->segment('3'));
              echo ': '.number_format($biaya, 0, ',', '.'); 
            ?>
          </div>
          <?php if($cek > 0){ ?>
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
                  <input type="hidden" name="id_tahunpelajaran" value="<?= $id_tahun_kelas10; ?>">
                  <input type="hidden" name="kurang" value="<?= $kurang; ?>" min="0" max="<?= $kurang; ?>" required>
                  <input type="number" name="bayar" min="0" max="<?= $kurang; ?>" class="col-md-10">
              </div>
              <div class="col-md-4 mt-2">
                dari Tabungan
              </div>
              <div class="col-md-8 mt-2">
                : <input type="number" name="daritabungan" min="0" max="<?= tabungan($siswa->id_siswa); ?>" class="col-md-10" <?php if(tabungan($siswa->id_siswa) == 0){ echo'disabled'; } ?> >
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
            <?php }
          } ?>
        </div>
      </div>
      <?php
      break; 
    }elseif($cek_2)
    {
      $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas11,$r->id_tagihan,0);
      $biaya = biaya($id_tahun_kelas11,$r->id_tagihan,2,$siswa->bsm);
      $cek++; ?>
      <div class="col-md-4 bg-white border border-info mb-2">
        <div class="row">
          <div class="col-md-12 bg-secondary text-white text-bold">
            &raquo; <?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahun_kelas11); ?> KELAS XI )
          </div>
          <div class="col-md-4">
            Biaya
          </div>
          <div class="col-md-8">
            <?php 
              echo form_open('backend/bayar/'.$this->uri->segment('3'));
              echo ': '.number_format($biaya, 0, ',', '.'); 
            ?>
          </div>
          <?php if($cek > 0){ ?>
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
                  <input type="hidden" name="id_tahunpelajaran" value="<?= $id_tahun_kelas11; ?>">
                  <input type="hidden" name="kurang" value="<?= $kurang; ?>" min="0" max="<?= $kurang; ?>" required>
                  <input type="number" name="bayar" min="0" max="<?= $kurang; ?>" class="col-md-10">
              </div>
              <div class="col-md-4 mt-2">
                dari Tabungan
              </div>
              <div class="col-md-8 mt-2">
                : <input type="number" name="daritabungan" min="0" max="<?= tabungan($siswa->id_siswa); ?>" class="col-md-10" <?php if(tabungan($siswa->id_siswa) == 0){ echo'disabled'; } ?> >
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
            <?php }
          } ?>
        </div>
      </div>
      <?php
      break; 
    }elseif($cek_3)
    {
      $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas12,$r->id_tagihan,0);
      $biaya = biaya($id_tahun_kelas12,$r->id_tagihan,3,$siswa->bsm);
      $cek++; ?>
      <div class="col-md-4 bg-white border border-info mb-2">
        <div class="row">
          <div class="col-md-12 bg-secondary text-white text-bold">
            &raquo; <?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahun_kelas12); ?> KELAS XII )
          </div>
          <div class="col-md-4">
            Biaya
          </div>
          <div class="col-md-8">
            <?php 
              echo form_open('backend/bayar/'.$this->uri->segment('3'));
              echo ': '.number_format($biaya, 0, ',', '.'); 
            ?>
          </div>
          <?php if($cek > 0){ ?>
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
                  <input type="hidden" name="id_tahunpelajaran" value="<?= $id_tahun_kelas12; ?>">
                  <input type="hidden" name="kurang" value="<?= $kurang; ?>" min="0" max="<?= $kurang; ?>" required>
                  <input type="number" name="bayar" min="0" max="<?= $kurang; ?>" class="col-md-10">
              </div>
              <div class="col-md-4 mt-2">
                dari Tabungan
              </div>
              <div class="col-md-8 mt-2">
                : <input type="number" name="daritabungan" min="0" max="<?= tabungan($siswa->id_siswa); ?>" class="col-md-10" <?php if(tabungan($siswa->id_siswa) == 0){ echo'disabled'; } ?> >
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
            <?php }
          } ?>
        </div>
      </div>
      <?php
      break; 
    }
  endforeach;
endforeach; 

if( ( $cek == 0 ) OR ( $pemb_sekaliselamanya->num_rows() == 0 ) ){
  include('belum_ada_tagihan.php');
} ?>