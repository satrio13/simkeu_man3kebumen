<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Riwayat Pembayaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Riwayat Pembayaran</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

<section class="content">
    <div class="row">
        <div class="col-12"> 
            <div class="card p-2 text-white bg-info text-bold">
                <div class="row">
                    <div class="col-md-1">NAMA</div>
                    <div class="col-md-4">: <?= $siswa->nama; ?></div>
                    <div class="col-md-2">TAHUN PELAJARAN</div>
                    <div class="col-md-4">: <?= $siswa->tahunpelajaran; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-1">NIS</div>
                    <div class="col-md-4">: <?= $siswa->nis; ?></div>
                    <div class="col-md-2">KELAS</div>
                    <div class="col-md-4">: <?= $siswa->kelas; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a href="<?= base_url(); ?>backend/cetak-riwayat/<?= $siswa->nis; ?>" class="btn btn-dark btn-flat border-white" target="_blank"><i class="fa fa-print"></i> CETAK <b></b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12"> 
            <div class="card">
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped" id="datatable">
                            <thead class="bg-secondary text-center">
                                <tr>
                                    <th width="5%" nowrap>NO</th>
                                    <th nowrap>TANGGAL</th>
                                    <th nowrap>JUMLAH SETORAN</th>
                                    <th nowrap>GUNA MEMBAYAR</th>
                                    <th nowrap>PETUGAS</th>
                                    <th width="15%" nowrap>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $no = 1; 
                            foreach($data->result() as $r): 
                                $id_tahunpelajaran = id_tahunpelajaran_pemb($r->id_tagihan_tahunan);
                                $tahun = tahun($id_tahunpelajaran);
                                $kelas = kelas_lap($r->id_siswa,$id_tahunpelajaran);
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
                                    $keterangan = $status.' '.$r->tagihan.' '.$semester.' ( TP '.$tahun.' Kelas '.$tingkat;
                                }elseif($id_jenistagihan == 4)
                                {
                                    $keterangan = $status.' '.$r->tagihan.' '.$bulan.' ( TP '.$tahun.' Kelas '.$tingkat;
                                }else
                                {
                                    $keterangan = $status.' '.$r->tagihan.' ( TP '.$tahun.' Kelas '.$tingkat;
                                }
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?>.</td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($r->tgl)); ?></td>
                                    <td class="text-right"><?= number_format($r->bayar, 0, ',', '.'); ?></td>
                                    <td><?= $keterangan; ?></td>
                                    <td><?= $r->nama_petugas; ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url(); ?>backend/cetak-slip/<?= $r->id_pembayaran; ?>" target="_blank" class="btn btn-dark btn-sm btn-flat border-white text-bold"><i class="fa fa-print"></i> CETAK SLIP</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</section>
</div>