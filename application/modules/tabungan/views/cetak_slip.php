<html>
<head>
<title>Cetak Slip Tabungan</title>
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
<br><center><b>SLIP TABUNGAN <br>Tanggal <?php  $tanggal = substr($tgl,8,2);
                                                $bulan = substr($tgl,5,2);
                                                $tahun = substr($tgl,0,4);
                                                echo $tanggal.' '.getBulan($bulan).' '.$tahun;
                                          ?>
</b></center>
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
            <th align="center" nowrap>KETERANGAN</th>
            <th align="center" nowrap>PETUGAS</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if($data->num_rows() > 0)
        {
            $total = 0;
            $no = 1; foreach($data->result() as $r): 
            $total = ( ($total) + ($r->nabung) ); ?>
            <tr>
                <td align="center"><?= $no++; ?></td>
                <td><?= date('d-m-Y H:i:s', strtotime($r->tgl)); ?></td>
                <td align="right"><?= number_format($r->nabung, 0, ',', '.'); ?></td>
                <td><?= $r->keterangan; ?></td>
                <td><?= $r->nama_petugas; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2"><b>TABUNGAN</b></td>
                <td align="right"><b><?= number_format($total, 0, ',', '.'); ?></b></td>
                <td></td>
                <td></td>
            </tr>
        <?php }else{ ?> 
            <tr>
                <td align="center" colspan="5">BELUM ADA RIWAYAT</td>
            </tr>
        <?php } ?>
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