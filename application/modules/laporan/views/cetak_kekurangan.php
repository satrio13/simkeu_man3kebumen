<html>
<head>
<title>Cetak Laporan Kekurangan Pembayaran</title>
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
<br><center><b>LAPORAN KEKURANGAN PEMBAYARAN</b></center>
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
        <td>
            <b>Tagihan</b>
        </td>
        <td>
            : <?= tagihan($id_tagihan); ?>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="3" width="100%" border="1">
    <thead style="background-color: #ccc">
        <tr>
            <th width="5%" align="center">NO</th>
            <th align="center">NIS</th>
            <th align="center">NAMA</th>
            <th align="center">TP SEKARANG</th>
            <th align="center">KELAS SEKARANG</th>
            <th align="center">TAGIHAN</th>
            <th align="center">BIAYA</th>
            <th align="center">DIBAYAR</th>
            <th align="center">KURANG</th>
            <th align="center">STATUS</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $no = 1; 
    $biaya_akhir = 0;
    $sudah_dibayar_akhir = 0;
    $kurang_akhir = 0;
    foreach($data->result() as $r):
        if(id_jenistagihan($id_tagihan) == 1)
        { 
            include('lapkurangselamanya.php');
        }elseif(id_jenistagihan($id_tagihan) == 2)
        { 
            include('lapkurangtahunan.php');
        }elseif(id_jenistagihan($id_tagihan) == 3)
        { 
            include('lapkurangsemester.php');
        }elseif(id_jenistagihan($id_tagihan) == 4)
        { 
            include('lapkurangbulanan.php');
        }elseif(id_jenistagihan($id_tagihan) == 6)
        { 
            if($r->tingkat == 'XII')
            {
                include('lapkurangkelulusan.php');
            }
        }
    endforeach; 
    echo'<tr>
            <td colspan="7" align="right"></td>
            <td align="right"><b>'.number_format($biaya_akhir, 0, ',', '.').'</b></td>
            <td align="right"><b>'.number_format($sudah_dibayar_akhir, 0, ',', '.').'</b></td>
            <td align="right"><b>'.number_format($kurang_akhir, 0, ',', '.').'</b></td>
        </tr>'; ?>
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