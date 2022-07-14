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
                    <?php echo form_open('backend/laporan-kekurangan'); ?>
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
                            <div class="col-md-3 text-bold">
                                Pembiayaan :
                                <select name="id_tagihan" class="form-control">
                                <?php foreach($tagihan->result() as $r): ?>
                                    <option value="<?= $r->id_tagihan; ?>" <?= set_select('id_tagihan',$r->id_tagihan); ?> ><?= $r->tagihan; ?></option>
                                <?php endforeach; ?>
                                </select>
                                <?= form_error('id_tagihan'); ?>
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
                                    <td width="15%" class="text-bold">Tagihan</td>
                                    <td width="2%" class="text-bold">:</td>
                                    <td><?= tagihan($id_tagihan); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <a href="<?= base_url("backend/cetak-laporan-kekurangan-pdf/$id_tahunpelajaran/$id_kelas/$id_tagihan"); ?>" target="_blank" class="btn bg-navy btn-flat"><i class="fa fa-print"></i> CETAK PDF</a>
                                        <a href="<?= base_url("backend/cetak-laporan-kekurangan/$id_tahunpelajaran/$id_kelas/$id_tagihan"); ?>" target="_blank" class="btn bg-primary btn-flat"><i class="fa fa-print"></i> CETAK BIASA</a>
                                    </td>
                                </tr>
                            </table>
                        <?php } ?>
                            <table class="table table-bordered table-striped">
                                <thead class="bg-secondary text-center">
                                    <tr>
                                        <th width="5%">NO</th>
                                        <th>NIS</th>
                                        <th>NAMA</th>
                                        <th>TP SEKARANG</th>
                                        <th>KELAS SEKARANG</th>
                                        <th>TAGIHAN</th>
                                        <th>BIAYA</th>
                                        <th>DIBAYAR</th>
                                        <th>KURANG</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                if(isset($submit))
                                {
                                    if($data->num_rows() > 0)
                                    {
                                        $no = 1; 
                                        $biaya_akhir = 0;
                                        $sudah_dibayar_akhir = 0;
                                        $kurang_akhir = 0;
                                        foreach($data->result() as $r):
                                            if(id_jenistagihan($id_tagihan) == 1)
                                            { 
                                                include('kurangselamanya.php');
                                            }elseif(id_jenistagihan($id_tagihan) == 2)
                                            { 
                                                include('kurangtahunan.php');
                                            }elseif(id_jenistagihan($id_tagihan) == 3)
                                            { 
                                                include('kurangsemester.php');
                                            }elseif(id_jenistagihan($id_tagihan) == 4)
                                            { 
                                                include('kurangbulanan.php');
                                            }elseif(id_jenistagihan($id_tagihan) == 6)
                                            { 
                                                if($r->tingkat == 'XII')
                                                {
                                                    include('kurangkelulusan.php');
                                                }
                                            }
                                        endforeach;
                                        echo'<tr>
                                                <td colspan="7"></td>
                                                <td class="text-right text-bold">'.number_format($biaya_akhir, 0, ',', '.').'</td>
                                                <td class="text-right text-bold">'.number_format($sudah_dibayar_akhir, 0, ',', '.').'</td>
                                                <td class="text-right text-bold">'.number_format($kurang_akhir, 0, ',', '.').'</td>
                                            </tr>';
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