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
                    <?php echo form_open('backend/laporan-semua-kekurangan'); ?>
                        <div class="row">
                            <div class="col-md-3 text-bold">
                                Tahun Pelajaran :
                                <select name="id_tahunpelajaran" class="form-control">
                                <?php foreach($tahun->result() as $r): ?>
                                    <option value="<?= $r->id_tahunpelajaran; ?>" <?= set_select('id_tahunpelajaran',$r->id_tahunpelajaran); ?> ><?= $r->tahunpelajaran; ?></option>
                                <?php endforeach; ?>
                                </select>
                                <?= form_error('id_tahunpelajaran'); ?>
                            </div>
                            <div class="col-md-3 text-bold">
                                Kelas :
                                <select name="id_kelas" class="form-control">
                                <?php foreach($kelas->result() as $r): ?>
                                    <option value="<?= $r->id_kelas; ?>" <?= set_select('id_kelas',$r->id_kelas); ?> ><?= $r->kelas; ?></option>
                                <?php endforeach; ?>
                                </select>
                                <?= form_error('id_kelas'); ?>
                            </div>
                            <div class="col-md-3"><br>
                                <button type="submit" name="submit" value="Submit" class="btn bg-dark btn-flat text-white border border-white"><i class="fa fa-search"></i> Cari Data</button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                    </div>
                    <div class="card-body">
                        <br><h3 class="text-center"><?= strtoupper($title); ?></h3>
                        <div class="table table-responsive">
                        <?php if(isset($submit)){ ?>
                            <table class="table" width="100%">
                                <tr>
                                    <td width="15%" class="text-bold">Tahun Pelajaran</td>
                                    <td width="2%" class="text-bold">:</td>
                                    <td><?= tahun($id_tahunpelajaran); ?></td>
                                </tr>
                                <tr>
                                    <td width="15%" class="text-bold">Kelas</td>
                                    <td width="2%" class="text-bold">:</td>
                                    <td><?= kelas($id_kelas); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <a href="<?= base_url("backend/cetak-laporan-semua-kekurangan-pdf/$id_tahunpelajaran/$id_kelas"); ?>" target="_blank" class="btn bg-navy btn-flat"><i class="fa fa-print"></i> CETAK PDF</a>
                                        <a href="<?= base_url("backend/cetak-laporan-semua-kekurangan/$id_tahunpelajaran/$id_kelas"); ?>" target="_blank" class="btn bg-primary btn-flat"><i class="fa fa-print"></i> CETAK BIASA</a>
                                        <a href="<?= base_url("backend/cetak-laporan-semua-kekurangan-excel/$id_tahunpelajaran/$id_kelas"); ?>" target="_blank" class="btn btn-flat bg-olive"><i class="fa fa-file-pdf"></i> CETAK EXCEL</a>
                                    </td>
                                </tr>
                            </table>
                        <?php } ?>
                            <table class="table table-bordered table-striped">
                                <thead class="bg-secondary text-center">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <?php
                                        if(isset($submit))
                                        {
                                            if($data->num_rows() > 0)
                                            {
                                                foreach($pemb_sekaliselamanya as $p):
                                                    echo'<th>'.$p->tagihan.'</th>';
                                                endforeach;

                                                foreach($pemb_tiaptahun as $p):
                                                    echo'<th>'.$p->tagihan.'</th>';
                                                endforeach;

                                                foreach($pemb_bulanan as $p):
                                                    if($p->id_tagihan == 1 AND $id_tahunpelajaran == 19)
                                                    {
                                                        
                                                    }else
                                                    {
                                                        echo'<th>'.$p->tagihan.'</th>';
                                                    }
                                                endforeach;

                                                foreach($pemb_kelulusan as $p):
                                                    echo'<th>'.$p->tagihan.'</th>';   
                                                endforeach;
                                            }
                                        }
                                        ?>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                if(isset($submit))
                                {
                                    if($data->num_rows() > 0)
                                    {
                                        $no = 1; 
                                        foreach($data->result() as $r):
                                            $jml_kurang = 0;
                                            echo'<tr>
                                                    <td align="center">'.$no++.'</td>
                                                    <td>'.$r->nis.'</td>
                                                    <td>'.$r->nama.'</td>';
                                                    foreach($pemb_sekaliselamanya as $p):
                                                        $cek = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                                                        if($cek)
                                                        {   
                                                            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahunpelajaran,$p->id_tagihan,0);
                                                            $biaya = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                                                            $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
                                                            $kurang = $biaya - $sudah_dibayar;
                                                            $jml_kurang = $jml_kurang + $kurang;
                                                            echo'<td align="right">'.number_format($kurang, 0, ',', '.').'</td>';
                                                        }
                                                    endforeach;

                                                    foreach($pemb_tiaptahun as $p):
                                                        $cek = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                                                        if($cek)
                                                        {   
                                                            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahunpelajaran,$p->id_tagihan,0);
                                                            $biaya = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                                                            $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
                                                            $kurang = $biaya - $sudah_dibayar;
                                                            $jml_kurang = $jml_kurang + $kurang;
                                                            echo'<td align="right">'.number_format($kurang, 0, ',', '.').'</td>';
                                                        }
                                                    endforeach;

                                                    foreach($pemb_bulanan as $p):
                                                        $cek = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                                                        if($cek)
                                                        {   
                                                            if($p->id_tagihan AND $id_tahunpelajaran == 19)
                                                            {

                                                            }else
                                                            {
                                                                $id_tagihan_tahunan = id_tagihan_tahunan($id_tahunpelajaran,$p->id_tagihan,0);
                                                                $biaya = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                                                                $biaya_hasil = $biaya * 12;
                                                                $sudah_dibayar_hasil = 0;
                                                                foreach($bulan->result() as $b):
                                                                    $sudah_dibayar = sudah_dibayar_bulanan($id_tagihan_tahunan,$b->id_bulan,$r->id_siswa);
                                                                    $sudah_dibayar_hasil = $sudah_dibayar_hasil + $sudah_dibayar;
                                                                endforeach;
                                                                $kurang = $biaya_hasil - $sudah_dibayar_hasil;
                                                                $jml_kurang = $jml_kurang + $kurang;
                                                                echo'<td align="right">'.number_format($kurang, 0, ',', '.').'</td>';   
                                                            }
                                                        }
                                                    endforeach;

                                                    if(tingkat_kelas($id_kelas) == 'XII')
                                                    {
                                                        foreach($pemb_kelulusan as $p):
                                                            $cek = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                                                            if($cek)
                                                            {   
                                                                $id_tagihan_tahunan = id_tagihan_tahunan($id_tahunpelajaran,$p->id_tagihan,0);
                                                                $biaya = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                                                                $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
                                                                $kurang = $biaya - $sudah_dibayar;
                                                                $jml_kurang = $jml_kurang + $kurang;
                                                            echo'<td align="right">'.number_format($kurang, 0, ',', '.').'</td>';
                                                            }
                                                        endforeach;
                                                    }

                                                    echo'<td align="right">'.number_format($jml_kurang, 0, ',', '.').'</td>';
                                            echo'</tr>';
                                        endforeach;
                                    }else 
                                    {
                                        echo'<tr>
                                                <td colspan="10" class="text-center text-danger text-bold">HASIL PENCARIAN KOSONG</td>
                                            </tr>';
                                    }
                                }else
                                { 
                                    echo'<tr>
                                          <td colspan="10" class="text-center text-danger">ANDA BELUM MELAKUKAN PENCARIAN</td>
                                        </tr>';
                                } 
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </section>
</div>