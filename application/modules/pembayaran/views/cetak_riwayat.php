<html>
<head>
<title>Cetak Riwayat Pembayaran</title>
<style>
    @page {
        margin-top: 40px; 
        margin-bottom: 70px; 
    }

    * { 
        font-size: 11pt; 
        font-family: arial; 
    }
</style>
</head>
<body>
<div class="header">
    <table width="100%" cellspacing="0" cellpadding="2"> 
        <tr>
            <td width="10%"><img src="<?= base_url('assets/img/logo_komite.png'); ?>" width="90"></td>
            <td align="center" width="80%"><b>KOMITE MADRASAH<br>MADRASAH ALIYAH NEGERI 3 KEBUMEN</b><br>
                Jalan Pencil No. 47 Kutowinangun Telp. 0287-661119 Kode Pos 54313             
            </td>
            <td width="10%"></td>
        </tr>
    </table>
</div>
<table width="100%">
    <tr>
        <td>
            <div style="border-bottom:3px solid black;"></div>
        </td>
    </tr>
</table>
<br><center><b>RIWAYAT PEMBAYARAN</b></center>
<br>
<table width="100%" cellspacing="0" cellpadding="2">
    <tr>
        <td width="10%">
            NAMA
        </td>
        <td width="45%">
            : <?= $siswa->nama; ?>
        </td>
        <td width="25%">
            TAHUN PELAJARAN
        </td>
        <td width="20%">
            : <?= $siswa->tahunpelajaran; ?>
        </td>
    </tr>
    <tr>
        <td>
            NIS
        </td>
        <td>
            : <?= $siswa->nis; ?>
        </td>
        <td>
            KELAS
        </td>
        <td>
            : <?= $siswa->kelas; ?>
        </td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="3" width="100%" border="1">
    <thead style="background-color: #ccc">
        <tr>
            <th align="center" nowrap>NO</th>
            <th align="center" nowrap>TANGGAL</th>
            <th align="center" nowrap>JUMLAH</th>
            <th align="center" nowrap>GUNA MEMBAYAR</th>
            <th align="center" nowrap>KETERANGAN</th>
            <th align="center" nowrap>PETUGAS</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    if($data->num_rows() > 0)
    {
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
                <td align="center"><?= $no++; ?></td>
                <td><?= date('d-m-Y H:i:s', strtotime($r->tgl)); ?></td>
                <td align="right"><?= number_format($r->bayar, 0, ',', '.'); ?></td>
                <td><?= $keterangan; ?></td>
                <td><?= $r->catatan; ?></td>
                <td><?= $r->nama_petugas; ?></td>
            </tr>
            <?php endforeach;
    }else
    {
        echo'<tr>
                <td align="center" colspan="6">DATA KOSONG</td>
            </tr>';
    }
    ?>
    </tbody>
</table>
<table style="width:800px; margin-top:5px; margin-bottom:20px;">
    <tr>
        <td></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="3" width="100%" style="margin-top:5px; margin-bottom:20px;">
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
<script>
    window.print();
</script>