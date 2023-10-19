<html>
<head>
<title>Cetak Laporan Persiswa</title>
<style type="text/css">
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
<br><center><b>LAPORAN PEMBAYARAN</b></center><br>
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
<?php
/* start pembayaran sekali selamanya */
echo'<table cellspacing="0" cellpadding="3" width="100%" border="1">
        <thead style="background-color: #ccc">
            <tr>
                <th colspan="5">TAGIHAN SEKALI SELAMANYA</th>
            </tr>
            <tr>
                <th align="center" width="5%">NO</th>
                <th align="center">TAGIHAN</th>
                <th align="center">BIAYA</th>
                <th align="center">SUDAH DIBAYAR</th>
                <th align="center">KEKURANGAN</th>
            </tr>
        </thead>
        <tbody>';
$jumlah_pemb_selamanya = 0;
$jumlah_biaya_selamanya = 0;
$jumlah_dibayar_selamanya = 0;
$cek = 0;
$nomor_selamanya = 1;
foreach($pemb_sekaliselamanya->result() as $r): 
    $tahun = tahun_ks($siswa->id_siswa);
    foreach($tahun as $k):
        $id_tahun_kelas10 = id_tahun_kelas10($siswa->id_siswa);
        $id_tahun_kelas11 = id_tahun_kelas11($siswa->id_siswa);
        $id_tahun_kelas12 = id_tahun_kelas12($siswa->id_siswa);
        
        $cek_1 = biaya($id_tahun_kelas10,$r->id_tagihan,1,$siswa->bsm);
        $cek_2 = biaya($id_tahun_kelas11,$r->id_tagihan,2,$siswa->bsm);
        $cek_3 = biaya($id_tahun_kelas12,$r->id_tagihan,3,$siswa->bsm);

        if($cek_1)
        { 
            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas10,$r->id_tagihan,0);
            $biaya = biaya($id_tahun_kelas10,$r->id_tagihan,1,$siswa->bsm);
            $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $siswa->id_siswa);
            $kurang = $biaya - $sudah_dibayar;
            $cek++;
            $jumlah_pemb_selamanya++;
            $jumlah_biaya_selamanya = $jumlah_biaya_selamanya + $biaya;
            $jumlah_dibayar_selamanya = $jumlah_dibayar_selamanya + $sudah_dibayar;
            ?>
            <tr>
                <td class="a" align="center"><?= $nomor_selamanya++; ?></td>
                <td class="a"><?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahun_kelas10); ?> KELAS X )</td>
                <td class="a" align="right"><?= number_format($biaya, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($sudah_dibayar, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($kurang, 0, ',', '.'); ?></td>
            </tr>
            <?php
            break; 
        }elseif($cek_2)
        {
            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas11,$r->id_tagihan,0);
            $biaya = biaya($id_tahun_kelas11,$r->id_tagihan,2,$siswa->bsm);
            $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $siswa->id_siswa);
            $kurang = $biaya - $sudah_dibayar;
            $cek++; 
            $jumlah_pemb_selamanya++;
            $jumlah_biaya_selamanya = $jumlah_biaya_selamanya + $biaya;
            $jumlah_dibayar_selamanya = $jumlah_dibayar_selamanya + $sudah_dibayar;
            ?>
            <tr>
                <td class="a" align="center"><?= $nomor_selamanya++; ?></td>
                <td class="a"><?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahun_kelas11); ?> KELAS XI )</td>
                <td class="a" align="right"><?= number_format($biaya, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($sudah_dibayar, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($kurang, 0, ',', '.'); ?></td>
            </tr>
            <?php
            break; 
        }elseif($cek_3)
        {
            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas12,$r->id_tagihan,0);
            $biaya = biaya($id_tahun_kelas12,$r->id_tagihan,3,$siswa->bsm);
            $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $siswa->id_siswa);
            $kurang = $biaya - $sudah_dibayar;
            $cek++; 
            $jumlah_pemb_selamanya++;
            $jumlah_biaya_selamanya = $jumlah_biaya_selamanya + $biaya;
            $jumlah_dibayar_selamanya = $jumlah_dibayar_selamanya + $sudah_dibayar;
            ?>
            <tr>
                <td class="a" align="center"><?= $nomor_selamanya++; ?></td>
                <td class="a"><?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahun_kelas12); ?> KELAS XII )</td>
                <td class="a" align="right"><?= number_format($biaya, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($sudah_dibayar, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($kurang, 0, ',', '.'); ?></td>
            </tr>
            <?php
            break; 
        }
    endforeach;
endforeach; 
if( ( $cek == 0 ) OR ( $pemb_sekaliselamanya->num_rows() == 0 ) )
{
    echo'<tr>
            <td colspan="5" align="center">TIDAK ADA TAGIHAN</td>
        </tr>';  
}
echo'<tbody>
</table>
<br>';
/* end pembayaran sekali selamanya */

/* start pembayaran tahunan */
echo'<table cellspacing="0" cellpadding="3" width="100%" border="1">
        <thead style="background-color: #ccc">
            <tr>
                <th colspan="5">TAGIHAN SETIAP TAHUN</th>
            </tr>
            <tr>
                <th align="center" width="5%">NO</th>
                <th align="center">TAGIHAN</th>
                <th align="center">BIAYA</th>
                <th align="center">SUDAH DIBAYAR</th>
                <th align="center">KEKURANGAN</th>
            </tr>
        </thead>
        <tbody>';
$jumlah_pemb_tahunan = 0;
$jumlah_biaya_tahunan = 0;
$jumlah_dibayar_tahunan = 0;
$ada = 0;
$nomor_tahunan = 1;
$kelas_siswa = kelas_siswa($siswa->id_siswa);
foreach($kelas_siswa as $k):
    foreach($pemb_tiaptahun->result() as $r): 
        $cek = biaya($k->id_tahunpelajaran,$r->id_tagihan,tingkat($k->tingkat),$siswa->bsm);
        if($cek)
        { 
            $ada++; 
            $jumlah_pemb_tahunan++;
            $biaya = biaya($k->id_tahunpelajaran,$r->id_tagihan,tingkat($k->tingkat),$siswa->bsm);
            $id_tagihan_tahunan = id_tagihan_tahunan($k->id_tahunpelajaran,$r->id_tagihan,0);
            $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $siswa->id_siswa);
            $kurang = $biaya - $sudah_dibayar;
            $jumlah_biaya_tahunan = $jumlah_biaya_tahunan + $biaya;
            $jumlah_dibayar_tahunan = $jumlah_dibayar_tahunan + $sudah_dibayar;
            ?>
            <tr>
                <td class="a" align="center"><?= $nomor_tahunan++; ?></td>
                <td class="a"><?= strtoupper($r->tagihan); ?> ( TP <?= tahun($k->id_tahunpelajaran); ?> KELAS <?= $k->tingkat; ?> )</td>
                <td class="a" align="right"><?= number_format($biaya, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($sudah_dibayar, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($kurang, 0, ',', '.'); ?></td>
            </tr>
        <?php 
        }
    endforeach;
endforeach;
if( ( $ada == 0 ) OR ( $pemb_tiaptahun->num_rows() == 0 ) )
{
    echo'<tr>
            <td colspan="5" align="center">TIDAK ADA TAGIHAN</td>
        </tr>';  
}
echo'<tbody>
</table>
<br>';
/* end pembayaran tahunan */

/* start pembayaran semester */
$jumlah_pemb_semester = 0;
$jumlah_biaya_semester = 0;
$jumlah_dibayar_semester = 0;
/*
echo'<table cellspacing="0" cellpadding="3" width="100%" border="1">
        <thead style="background-color: #ccc">
            <tr>
                <th colspan="5">TAGIHAN SETIAP SEMESTER</th>
            </tr>
            <tr>
                <th align="center" width="5%">NO</th>
                <th align="center">TAGIHAN</th>
                <th align="center">BIAYA</th>
                <th align="center">SUDAH DIBAYAR</th>
                <th align="center">KEKURANGAN</th>
            </tr>
        </thead>
        <tbody>';
$ada = 0;
$nomor_semester = 1;
$siswa_smt = siswa_smt($siswa->id_siswa);
foreach($siswa_smt as $k): 
    foreach($pemb_semester->result() as $r): 
        $cek = biaya_semester($k->id_tahunpelajaran,$r->id_tagihan,$k->id_semester,tingkat($k->tingkat),$siswa->bsm);
        if($cek)
        { 
            $ada++; 
            $jumlah_pemb_semester++;
            $id_tagihan_tahunan = id_tagihan_tahunan($k->id_tahunpelajaran,$r->id_tagihan,$k->id_semester);
            $biaya = biaya_semester($k->id_tahunpelajaran,$r->id_tagihan,$k->id_semester,tingkat($k->tingkat),$siswa->bsm);
            $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $siswa->id_siswa);
            $kurang = $biaya - $sudah_dibayar;
            $jumlah_biaya_semester = $jumlah_biaya_semester + $biaya;
            $jumlah_dibayar_semester = $jumlah_dibayar_semester + $sudah_dibayar;
            ?>
            <tr>
                <td class="a" align="center"><?= $nomor_semester++; ?></td>
                <td class="a"><?= strtoupper($r->tagihan); ?> ( TP <?= $k->tahunpelajaran; ?> KELAS <?= $k->tingkat; ?> SEMESTER <?= semester($k->id_semester); ?> / <?= strtoupper($k->smt); ?> )</td>
                <td class="a" align="right"><?= number_format($biaya, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($sudah_dibayar, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($kurang, 0, ',', '.'); ?></td>
            </tr>
        <?php 
        }
    endforeach;
endforeach;
if( ( $ada == 0 ) OR ( $pemb_semester->num_rows() == 0 ) )
{
    echo'<tr>
            <td colspan="5" align="center">TIDAK ADA TAGIHAN</td>
        </tr>';  
}
echo'<tbody>
</table>
<br>';
/* end pembayaran semester */  

/* start pembayaran bulanan */
echo'<table cellspacing="0" cellpadding="3" width="100%" border="1">
        <thead style="background-color: #ccc">
            <tr>
                <th colspan="5">TAGIHAN SETIAP BULAN</th>
            </tr>
            <tr>
                <th align="center" width="5%">NO</th>
                <th align="center">TAGIHAN</th>
                <th align="center">BIAYA</th>
                <th align="center">SUDAH DIBAYAR</th>
                <th align="center">KEKURANGAN</th>
            </tr>
        </thead>
        <tbody>';
$jumlah_pemb_bulanan = 0;
$jumlah_biaya_bulanan = 0;
$jumlah_dibayar_bulanan = 0;
$nomor_bulanan = 1;
$cek = 0;
foreach($pemb_bulanan->result() as $r): 
    $id_tahun_kelas10 = id_tahun_kelas10($siswa->id_siswa);
    $id_tahun_kelas11 = id_tahun_kelas11($siswa->id_siswa);
    $id_tahun_kelas12 = id_tahun_kelas12($siswa->id_siswa);
    
    $cek_1 = biaya($id_tahun_kelas10,$r->id_tagihan,1,$siswa->bsm);
    $cek_2 = biaya($id_tahun_kelas11,$r->id_tagihan,2,$siswa->bsm);
    $cek_3 = biaya($id_tahun_kelas12,$r->id_tagihan,3,$siswa->bsm);

    if($cek_1)
    {
        if($r->id_tagihan == 1 AND $id_tahun_kelas10 == 19)
        {

        }else
        {
            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas10,$r->id_tagihan,0);
            $biaya = biaya($id_tahun_kelas10,$r->id_tagihan,1,$siswa->bsm);
            $biaya_akhir = $biaya * 12;
            $sudah_dibayar_akhir = 0;
            $cek++; 
            $jumlah_pemb_bulanan++;
            $jumlah_biaya_bulanan = $jumlah_biaya_bulanan + $biaya_akhir;
            foreach($bulan->result() as $b):
                $sudah_dibayar = sudah_dibayar_bulanan($id_tagihan_tahunan,$b->id_bulan,$siswa->id_siswa);
                $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar;
            endforeach;
            $kurang = $biaya_akhir - $sudah_dibayar_akhir;
            $jumlah_dibayar_bulanan = $jumlah_dibayar_bulanan + $sudah_dibayar_akhir;
            ?>
            <tr>
                <td class="a" align="center"><?= $nomor_bulanan++; ?></td>
                <td class="a"><?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahun_kelas10); ?> KELAS X )</td>
                <td class="a" align="right"><?= number_format($biaya_akhir, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($sudah_dibayar_akhir, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($kurang, 0, ',', '.'); ?></td>
            </tr>
        <?php
        }
    }
    
    if($cek_2)
    {
        if($r->id_tagihan == 1 AND $id_tahun_kelas11 == 19)
        {

        }else
        {
            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas11,$r->id_tagihan,0);
            $biaya = biaya($id_tahun_kelas11,$r->id_tagihan,2,$siswa->bsm);
            $biaya_akhir = $biaya * 12;
            $sudah_dibayar_akhir = 0;
            $cek++; 
            $jumlah_pemb_bulanan++;
            $jumlah_biaya_bulanan = $jumlah_biaya_bulanan + $biaya_akhir;
            foreach($bulan->result() as $b):
                $sudah_dibayar = sudah_dibayar_bulanan($id_tagihan_tahunan,$b->id_bulan,$siswa->id_siswa);
                $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar;
            endforeach;
            $kurang = $biaya_akhir - $sudah_dibayar_akhir;
            $jumlah_dibayar_bulanan = $jumlah_dibayar_bulanan + $sudah_dibayar_akhir;
            ?>
            <tr>
                <td class="a" align="center"><?= $nomor_bulanan++; ?></td>
                <td class="a"><?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahun_kelas11); ?> KELAS XI )</td>
                <td class="a" align="right"><?= number_format($biaya_akhir, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($sudah_dibayar_akhir, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($kurang, 0, ',', '.'); ?></td>
            </tr>
        <?php
        }
    }

    if($cek_3)
    {
        if($r->id_tagihan == 1 AND $id_tahun_kelas12 == 19)
        {

        }else
        {
            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas12,$r->id_tagihan,0);
            $biaya = biaya($id_tahun_kelas12,$r->id_tagihan,3,$siswa->bsm);
            $biaya_akhir = $biaya * 12;
            $sudah_dibayar_akhir = 0;
            $cek++; 
            $jumlah_pemb_bulanan++;
            $jumlah_biaya_bulanan = $jumlah_biaya_bulanan + $biaya_akhir;
            foreach($bulan->result() as $b):
                $sudah_dibayar = sudah_dibayar_bulanan($id_tagihan_tahunan,$b->id_bulan,$siswa->id_siswa);
                $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar;
            endforeach;
            $kurang = $biaya_akhir - $sudah_dibayar_akhir;
            $jumlah_dibayar_bulanan = $jumlah_dibayar_bulanan + $sudah_dibayar_akhir;
            ?>
            <tr>
                <td class="a" align="center"><?= $nomor_bulanan++; ?></td>
                <td class="a"><?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahun_kelas12); ?> KELAS XII )</td>
                <td class="a" align="right"><?= number_format($biaya_akhir, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($sudah_dibayar_akhir, 0, ',', '.'); ?></td>
                <td class="a" align="right"><?= number_format($kurang, 0, ',', '.'); ?></td>
            </tr>
        <?php
        }
    }
endforeach;
if( ( $cek == 0 ) OR ( $pemb_bulanan->num_rows() == 0 ) )
{
    echo'<tr>
            <td colspan="5" align="center">TIDAK ADA TAGIHAN</td>
        </tr>';  
}
echo'<tbody>
</table>
<br>';
/* end pembayaran bulanan */

/* start pembayaran kelulusan */
$jumlah_pemb_kelulusan = 0;
$jumlah_biaya_kelulusan = 0;
$jumlah_dibayar_kelulusan = 0;
if($siswa->tingkat == 'XII')
{
    $jml = $pemb_kelulusan->num_rows();
    if($jml > 0)
    {
        $cek = 0; 
        $nomor_kelulusan = 1;
        echo'<table cellspacing="0" cellpadding="3" width="100%" border="1">
                <thead style="background-color: #ccc">
                    <tr>
                        <th colspan="5">TAGIHAN KELULUSAN</th>
                    </tr>
                    <tr>
                        <th align="center" width="5%">NO</th>
                        <th align="center">TAGIHAN</th>
                        <th align="center">BIAYA</th>
                        <th align="center">SUDAH DIBAYAR</th>
                        <th align="center">KEKURANGAN</th>
                    </tr>
                </thead>
                <tbody>';
        foreach($pemb_kelulusan->result() as $r): 
            $id_tahunpelajaran = id_tahunpelajaran_siswa($siswa->id_siswa);
            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahunpelajaran,$r->id_tagihan,0);
            $biaya = biaya($id_tahunpelajaran,$r->id_tagihan,3,$siswa->bsm);
            if($biaya)
            { 
                $cek++; 
                $jumlah_pemb_kelulusan++;
                $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $siswa->id_siswa);
                $kurang = $biaya - $sudah_dibayar;
                $jumlah_biaya_kelulusan = $jumlah_biaya_kelulusan + $biaya;
                $jumlah_dibayar_kelulusan = $jumlah_dibayar_kelulusan + $sudah_dibayar;
                ?>
                <tr>
                    <td class="a" align="center"><?= $nomor_kelulusan++; ?></td>
                    <td class="a"><?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahunpelajaran); ?> KELAS XII )</td>
                    <td class="a" align="right"><?= number_format($biaya, 0, ',', '.'); ?></td>
                    <td class="a" align="right"><?= number_format($sudah_dibayar, 0, ',', '.'); ?></td>
                    <td class="a" align="right"><?= number_format($kurang, 0, ',', '.'); ?></td>
                </tr>
            <?php
            }
        endforeach;
        if( ( $cek == 0 ) OR ( $pemb_kelulusan->num_rows() == 0 ) )
        {
            echo'<tr>
                    <td colspan="5" align="center">TIDAK ADA TAGIHAN</td>
                </tr>';  
        }
        echo'<tbody>
        </table>';
    }
}
/* end pembayaran kelulusan */

$jumlah_cek = ( $jumlah_pemb_selamanya 
                + $jumlah_pemb_tahunan 
                + $jumlah_pemb_semester 
                + $jumlah_pemb_bulanan 
                + $jumlah_pemb_kelulusan );
                
$total_biaya = ( $jumlah_biaya_selamanya 
                + $jumlah_biaya_tahunan 
                + $jumlah_biaya_semester 
                + $jumlah_biaya_bulanan 
                + $jumlah_biaya_kelulusan );

$total_dibayar = ( $jumlah_dibayar_selamanya 
                + $jumlah_dibayar_tahunan
                + $jumlah_dibayar_semester
                + $jumlah_dibayar_bulanan
                + $jumlah_dibayar_kelulusan );

$total_kurang = $total_biaya - $total_dibayar;
if($jumlah_cek == 0)
{
    echo'<tr>
            <td colspan="5" align="center">BELUM ADA TAGIHAN</td>
        </tr>';
} ?>
</tbody>
</table>
<br>
<?php if($jumlah_cek > 0){ ?>
<table cellspacing="0" cellpadding="3" width="100%">
    <tr>
        <td width="30%"><b>JUMLAH BIAYA</b></td>
        <td width="2%"><b>:</b></td>
        <td><b><?= number_format($total_biaya, 0, ',', '.'); ?></b></td>
    </tr>
    <tr>
        <td width="30%"><b>JUMLAH DIBAYAR</b></td>
        <td width="2%"><b>:</b></td>
        <td><b><?= number_format($total_dibayar, 0, ',', '.'); ?></b></td>
    </tr>
    <tr>
        <td width="30%"><b>JUMLAH KEKURANGAN</b></td>
        <td width="2%"><b>:</b></td>
        <td><b><?= number_format($total_kurang, 0, ',', '.'); ?></b></td>
    </tr>
</table>
<?php } ?>
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