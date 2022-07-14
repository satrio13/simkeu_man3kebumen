<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid bg-dark p-2">
      <div class="row mb-2">
        <div class="col-md-12">
        <?php echo form_open('backend/tabungan'); ?>
            <div class="row">
              <div class="col-md-3">
                  <input type="text" name="nis" value="<?= set_value('nis'); ?>" placeholder="NIS" class="form-control" required>
              </div>
              <div class="col-md-3">
                  <button type="submit" name="submit" value="Cari" class="btn bg-info btn-flat text-white border border-white text-bold"><i class="fa fa-search"></i> CARI SISWA</button>
              </div>
        <?php echo form_close(); ?>
              <div class="col-md-6 text-right">
                <a href="" target="_self" class="btn bg-info btn-flat text-white border border-white"><i class="fas fa-sync-alt"></i> REFRESH</a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <section class="content">
  <div class="row">
    <div class="col-12"> 
    <?php 
    if($this->session->flashdata('msg-tabungan'))
    {
        echo pesan_sukses($this->session->flashdata('msg-tabungan'));
    }elseif($this->session->flashdata('msg-gagal-tabungan'))
    {
        echo pesan_gagal($this->session->flashdata('msg-gagal-tabungan'));
    }
    ?>
    <div class="card">
        <div class="p-2 text-white bg-info text-bold">
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
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12">
        <div class="row">
            <div class="col-md-3" style="border: 5px solid white">
                <div class="row">
                    <div class="col-md-12 bg-maroon">
                        <label class="mt-2">SETORKAN TABUNGAN</label>
                        <label class="mt-2 float-right"><i class="fa fa-coins"></i></label>
                    </div>
                    <div class="col-md-12 mt-2">
                        <?php echo form_open('backend/nabung/'.$this->uri->segment('3'), 'id="form"'); ?>
                            <input type="number" name="nabung" min="1" class="form-control" placeholder="Masukan Nominal" required>
                            <button type="submit" name="submit" value="Submit" class="btn btn-info btn-flat mt-2 text-bold border border-white btn-block">SETORKAN</button> 
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>        

            <div class="col-md-9 bg-purple" style="border: 5px solid white">
                <label class="mt-2">HISTORI TABUNGAN</label>
                <label class="mt-2 float-right"><i class="fa fa-book"></i></label>
                <div class="row">
                    <div class="col-md-12 bg-light">
                        <a href="<?= base_url("backend/cetak-riwayat-tabungan/$siswa->nis"); ?>" class="btn bg-olive btn-flat float-right m-1 text-bold" target="_blank"><span class="text-white"><i class="fa fa-print"></i> CETAK RIWAYAT TABUNGAN</span></a>
                        <div class="table table-responsive mt-2">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-dark text-center">
                                    <tr>
                                        <th width="5%">NO</th>
                                        <th>TANGGAL</th>
                                        <th>JUMLAH</th>
                                        <th>KETERANGAN</th>
                                        <th>PETUGAS</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                if($data->num_rows() > 0)
                                {   
                                    $total = 0;
                                    $no = 1; 
                                    foreach($data->result() as $r): 
                                        $total = $total + $r->nabung; 
                                        $id_tabungan_terakhir = $this->tabungan_model->id_tabungan_terakhir($r->id_siswa);
                                        echo'
                                        <tr>
                                            <td class="text-center">'.$no++.'</td>
                                            <td>'.date('d-m-Y H:i:s', strtotime($r->tgl)).'</td>
                                            <td class="text-right">'.number_format($r->nabung, 0, ',', '.').'</td>
                                            <td>'.$r->keterangan.'</td>
                                            <td>'.$r->nama_petugas.'</td>
                                            <td class="text-center" nowrap>
                                                <a href="'.base_url("backend/cetak-slip-tabungan/$r->id_tabungan").'" target="_blank" class="btn btn-primary btn-sm btn-flat border-white text-bold"><i class="fa fa-print"></i></a> ';
                                                if( ($this->session->userdata('id_user') == $r->id_user) AND ($r->keterangan == 'Menabung') AND ($id_tabungan_terakhir == $r->id_tabungan) AND ($r->hapus == 'Y') )
                                                { 
                                                    echo'<a href="javascript:void(0)" class="btn btn-danger btn-sm btn-flat text-white" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="'.base_url("backend/hapus-tabungan/$r->id_tabungan/$siswa->nis").'" title="HAPUS DATA"><i class="fa fa-trash"></i></a>';  
                                                } 
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; 
                                    echo'<tr>
                                            <td colspan="2" class="text-bold">TABUNGAN</td>
                                            <td class="text-right text-bold">'.number_format($total, 0, ',', '.').'</td>
                                            <td colspan="3"></td>
                                        </tr>';
                                }else
                                { 
                                    echo'<tr>
                                            <td class="text-center" colspan="6">BELUM ADA RIWAYAT</td>
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
    </div>
    </section>
</div>

<div class="modal fade" id="konfirmasi_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
               <b>Anda yakin ingin menghapus data ini ?</b><br><br>
               <a class="btn btn-danger btn-ok"> Hapus</a>
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
            </div>
        </div>
    </div>
</div>