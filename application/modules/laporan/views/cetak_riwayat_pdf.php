<html>
<head>
<title>Cetak Laporan Riwayat Pembayaran</title>
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
        <td width="10%"><img src="assets/img/logo_komite.png" width="90"></td>
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
<br><center><b>LAPORAN RIWAYAT PEMBAYARAN</b></center><br>
<table width="100%" cellspacing="0" cellpadding="2">
    <tr>
        <td>
            Tahun Pelajaran
            : <?php echo tahun($id_tahunpelajaran); ?>
        </td>
        <td>
            Tingkatan
            : <?php 
            if($tingkatan == '0')
            {
                echo'Semua Tingkatan';
            }else
            {
                echo $tingkatan;
            }
            ?>
        </td>
        <td>
            Tagihan
            : <?php 
            if($id_tagihan == '0')
            {
                echo'Semua Tagihan';
            }else
            {
                echo tagihan($id_tagihan);
            }
            ?>
        </td>
        <td>
            Tanggal
            : <?php 
            if($tgl_awal != $tgl_akhir)
            { 
                echo date('d-m-Y', strtotime($tgl_awal)).' s.d. '.date('d-m-Y', strtotime($tgl_akhir));
            }else
            {
                echo date('d-m-Y', strtotime($tgl_awal));
            } 
            ?>  
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="3" width="100%" border="1">
    <thead style="background-color: #ccc">
        <tr>
            <th align="center" nowrap>NO</th>
            <th align="center" nowrap>TANGGAL</th>
            <th align="center" nowrap>JML SETORAN</th>
            <th align="center" nowrap>NIS</th>
            <th align="center" nowrap>NAMA</th>
            <th align="center" nowrap>KELAS</th>
            <th align="center" nowrap>KETERANGAN</th>
            <th align="center" nowrap>PETUGAS</th>
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
        <td align="center" class="a"><?= $no++; ?></td>
        <td class="a"><?= date('d-m-Y H:i:s', strtotime($r->tgl)); ?></td>
        <td align="right" class="a"><?= number_format($r->bayar, 0, ',', '.'); ?></td>
        <td class="a"><?= $r->nis; ?></td>
        <td class="a"><?= $r->nama; ?></td>
        <td class="a"><?= $r->kelas; ?></td>
        <td class="a"><?= $keterangan; ?></td>
        <td class="a"><?= $r->nama_petugas; ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="2" class="a"><b>JUMLAH SETORAN</b></td>
        <td class="a" align="right"><b><?= number_format($jml_setoran, 0, ',', '.'); ?></b></td>
        <td class="a"></td>
        <td class="a"></td>
        <td class="a"></td>
        <td class="a"></td>
        <td class="a"></td>
    </tr>
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
                        echo'<img src="assets/img/ttd/'.$ttd.'" width="70">
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