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
            <li class="breadcrumb-item active"><?= $title; ?></li>
          </ol>
        </div>
      </div>
    </div>
  </div>

<section class="content">
  <div class="row">
    <div class="col-12">            
      <div class="card">
        <div class="card-header bg-info">
          <h3 class="card-title">FORM PENCARIAN</h3> 
        </div>
        <div class="card-body">
        <?php echo form_open('backend/laporan-riwayat'); ?>
          <div class="form-group row">
            <div class="col-sm-3">
              <b>Tahun Pelajaran :</b>
              <select name="id_tahunpelajaran" class="form-control">
                <?php foreach($tahun->result() as $r): ?>
                  <option value="<?= $r->id_tahunpelajaran; ?>" <?= set_select('id_tahunpelajaran', $r->id_tahunpelajaran); ?> ><?= $r->tahunpelajaran; ?></option> 
                <?php endforeach; ?>
              </select>
              <?php echo form_error('id_tahunpelajaran'); ?>
            </div>
            <div class="col-sm-3">
              <b>Tingkatan :</b>
              <select name="tingkatan" class="form-control">
                <option value="0" <?= set_select('tingkatan','0'); ?> >Semua Tingkatan</option>
                <option value="X" <?= set_select('tingkatan','X'); ?> >X</option>
                <option value="XI" <?= set_select('tingkatan','XI'); ?> >XI</option>
                <option value="XII" <?= set_select('tingkatan','XII'); ?> >XII</option>
              </select>
              <?php echo form_error('tingkatan'); ?>
            </div>
            <div class="col-sm-3">
              <b>Tagihan :</b>
              <select name="id_tagihan" class="form-control">
                <option value="0" <?= set_select('id_tagihan', '0'); ?> >Semua Tagihan</option>
                <?php foreach($tagihan->result() as $r): ?>
                  <option value="<?= $r->id_tagihan; ?>" <?= set_select('id_tagihan', $r->id_tagihan); ?> ><?= $r->tagihan; ?></option> 
                <?php endforeach; ?>
              </select>
              <?php echo form_error('id_tagihan'); ?>
            </div>
            <div class="col-sm-3">
              <b>Periode Awal :</b>
              <input type='date' name='tgl_awal' required class='form-control' value="<?= set_value('tgl_awal'); ?>">
              <?php echo form_error('tgl_awal'); ?>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-3">
              <b>Periode Akhir :</b>
              <input type='date' name='tgl_akhir' required class='form-control' value="<?= set_value('tgl_akhir'); ?>">
              <?php echo form_error('tgl_akhir'); ?>
            </div>
            <div class="col-sm-3">
              <br><button type="submit" name="submit" value="Submit" class="btn bg-dark btn-flat"><i class="fa fa-search"></i> Cari Data</button>
            </div>
          </div>
        <?php echo form_close() ?>
        </div>
      </div>
     </div>
    </div>
</section>

<?php if(isset($submit) AND $riwayat->num_rows() > 0){ ?>
<section class="content">
    <div class="row">
      <div class="col-12">            
        <div class="card">
          <div class="card-body">
            <h4 class="text-center">RIWAYAT PEMBAYARAN</h4>   
            <div class="table table-responsive">
                <table class="table" width="100%">
                    <tr>
                        <td width="15%" class="text-bold">Tahun Pelajaran</td>
                        <td width="2%" class="text-bold">:</td>
                        <td><?php echo tahun($id_tahunpelajaran); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Tingkatan</td>
                        <td class="text-bold">:</td>
                        <td><?php 
                            if($tingkatan == '0')
                            {
                                echo'Semua Tingkatan';
                            }else
                            {
                                echo $tingkatan;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Tagihan</td>
                        <td class="text-bold">:</td>
                        <td><?php 
                            if($id_tagihan == '0')
                            {
                                echo'Semua Tagihan';
                            }else
                            {
                                echo tagihan($id_tagihan);
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Tanggal</td>
                        <td class="text-bold">:</td>
                        <td><?php 
                            if($tgl_awal != $tgl_akhir)
                            { 
                                echo date('d-m-Y', strtotime($tgl_awal)).' s.d. '.date('d-m-Y', strtotime($tgl_akhir));
                            }else
                            {
                                echo date('d-m-Y', strtotime($tgl_awal));
                            } 
                            ?>    
                        </td>
                        <td class="text-right">
                            <a href="<?= base_url(); ?>backend/cetak-laporan-riwayat-pdf/<?= $id_tahunpelajaran; ?>/<?= $tingkatan; ?>/<?= $id_tagihan; ?>/<?= $tgl_awal; ?>/<?= $tgl_akhir; ?>" target="_blank" class="btn btn-flat bg-navy"><i class="fa fa-file-pdf"></i> CETAK PDF</a>
                            <a href="<?= base_url(); ?>backend/cetak-laporan-riwayat/<?= $id_tahunpelajaran; ?>/<?= $tingkatan; ?>/<?= $id_tagihan; ?>/<?= $tgl_awal; ?>/<?= $tgl_akhir; ?>" target="_blank" class="btn btn-flat bg-primary"><i class="fa fa-print"></i> CETAK BIASA</a>
                            <a href="<?= base_url(); ?>backend/cetak-laporan-riwayat-excel/<?= $id_tahunpelajaran; ?>/<?= $tingkatan; ?>/<?= $id_tagihan; ?>/<?= $tgl_awal; ?>/<?= $tgl_akhir; ?>" target="_blank" class="btn btn-flat bg-olive"><i class="fa fa-file-pdf"></i> CETAK EXCEL</a>
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered table-striped">
                    <thead class="bg-secondary text-center">
                        <tr>
                            <th width="5%" nowrap>NO</th>
                            <th nowrap>TANGGAL</th>
                            <th nowrap>JML SETORAN</th>
                            <th nowrap>NIS</th>
                            <th nowrap>NAMA</th>
                            <th nowrap>KELAS</th>
                            <th nowrap>KETERANGAN</th>
                            <th nowrap>PETUGAS</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no = 1; 
                    $jml_setoran = 0;
                    foreach($riwayat->result() as $r): 

                        $id_tahunpelajaran = id_tahunpelajaran_pemb($r->id_tagihan_tahunan);
                        $tahun = tahun($id_tahunpelajaran);
                        //$kelas = kelas_lap($r->id_siswa,$id_tahunpelajaran);
                        $tingkat = tingkat_lap($r->id_siswa,$id_tahunpelajaran);
                        $id_tagihan = id_tagihan($r->id_tagihan_tahunan);
                        $id_jenistagihan = id_jenistagihan($id_tagihan);
                            
                        if($r->status == 'l')
                        {
                            $status = 'Pelunasan ';
                        }elseif($r->status == 'a')
                        {
                            $status = 'Angsuran ';
                        }else
                        {
                            $status = '';
                        }

                        if($r->id_semester != 0)
                        {
                            $semester = ' Semester '.semester($r->id_semester);
                        }else
                        {
                            $semester = '';
                        }

                        if($r->id_bulan != 0)
                        {
                            $bulan = ' Bulan '.bulan($r->id_bulan);
                        }else
                        {
                            $bulan = '';
                        }

                        if($id_jenistagihan == 3)
                        {
                            $keterangan = $status.' '.$r->tagihan.' '.$semester.' ( TP '.$tahun.' Kelas '.$tingkat.' )';
                        }elseif($id_jenistagihan == 4)
                        {
                            $keterangan = $status.' '.$r->tagihan.' '.$bulan.' ( TP '.$tahun.' Kelas '.$tingkat.' )';
                        }else
                        {
                            $keterangan = $status.' '.$r->tagihan.' ( TP '.$tahun.' Kelas '.$tingkat.' )';
                        }
                    
                        $jml_setoran = $jml_setoran + $r->bayar;
                    ?>
                    <tr>   
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= date('d-m-Y H:i:s', strtotime($r->tgl)); ?></td>
                        <td class="text-right"><?= number_format($r->bayar, 0, ',', '.'); ?></td>
                        <td><?= $r->nis; ?></td>
                        <td><?= $r->nama; ?></td>
                        <td><?= $r->kelas; ?></td>
                        <td><?= $keterangan; ?></td>
                        <td><?= $r->nama_petugas; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td class="text-bold" colspan="2">JUMLAH SETORAN</td>
                        <td class="text-right text-bold"><?= number_format($jml_setoran, 0, ',', '.'); ?></td>
                        <td colspan="5"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>  
          </div>
      </div>
  </div>
</section>
<?php }elseif(isset($submit) AND $riwayat->num_rows() == 0){
  echo pesan_gagal('HASIL PENCARIAN KOSONG!');
} ?>
</div>