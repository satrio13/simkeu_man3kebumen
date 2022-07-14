<html>
<head>
<title>Cetak Laporan Semua Kekurangan Pembayaran</title>
<style type="text/css">
   @page {
        margin-top: 40px; 
        margin-bottom: 70px; 
    }

    * { 
        font-size: 11pt; 
        font-family: arial; 
    }

    footer {
        height: 50px;
        margin-bottom: -50px;
    }
</style>
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="2"> 
    <tr>
        <td width="10%"><img src="<?= base_url('assets/img/logo_komite.png'); ?>" width="70"></td>
        <td align="center" width="80%"><b>KOMITE MADRASAH<br>MADRASAH ALIYAH NEGERI 3 KEBUMEN</b><br>
            Jalan Pencil No. 47 Kutowinangun Telp. 0287-661119 Kode Pos 54313             
        </td>
        <td width="10%"></td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td>
            <div style="border-bottom:3px solid black;"></div>
        </td>
    </tr>
</table>
<br><center><b>LAPORAN SEMUA KEKURANGAN PEMBAYARAN</b></center>
<br>
<table cellspacing="0" cellpadding="2">
    <tr>
        <td>
            <b>Tahun Pelajaran</b>
        </td>
        <td>
            : <?= tahun($id_tahunpelajaran); ?>
        </td>
        <td>
            <b>Kelas</b>
        </td>
        <td>
            : <?= kelas($id_kelas); ?>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="3" width="100%" border="1">
    <thead style="background-color: #ccc" align="center">
        <tr>
            <th width="5%">NO</th>
            <th>NIS</th>
            <th>Nama</th>
            <?php
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
            echo'<th>Jumlah</th>';
            ?>
        </tr>
    </thead>
    <tbody>
    <?php 
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
                <td colspan="10" align="right">DATA KOSONG</td>
            </tr>';
    }
    ?>
    </tbody>
</table>
<br>
<footer>
    <table cellspacing="0" cellpadding="3" width="100%">
        <tr>
            <td width="40%"><br></td>
            <td width="20%"></td>
            <td width="40%">Kutowinangun, <?php
                        $tanggal = date('d');
                        $bulan = date('m');
                        $tahun = date('Y');
                        echo $tanggal.' '.getBulan($bulan).' '.$tahun;
                        ?><br>Bagian Administrasi
            </td>
        </tr>
        <tr>
            <td width="40%"></td>
            <td width="20%"></td>
            <td width="40%">
                <?php
                if($this->session->userdata('level') != 'ks')
                {
                    $ttd = ttd($this->session->userdata('id_user'));
                    if( !empty($ttd) AND file_exists("assets/img/ttd/$ttd") )
                    { 
                        echo'<img src="'.base_url("assets/img/ttd/$ttd").'" width="70">
                            <br><b><u>'.nama_user($this->session->userdata('id_user')).'</u></b>';
                    }else
                    {
                        echo'<br><br><br><b><u>'.nama_user($this->session->userdata('id_user')).'</u></b>';
                    }
                    
                    if( !empty(nip($this->session->userdata('id_user'))) )
                    {
                        echo '<br>NIP. '.nip($this->session->userdata('id_user'));
                    }
                }  
                ?>
            </td>
        </tr>
    </table>
</footer>
<script>
    window.print();
</script>