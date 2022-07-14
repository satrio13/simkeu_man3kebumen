<?php 
$id_tahun_kelas10 = id_tahun_kelas10($r->id_siswa);
$id_tahun_kelas11 = id_tahun_kelas11($r->id_siswa);
$id_tahun_kelas12 = id_tahun_kelas12($r->id_siswa);

$cek_1 = biaya($id_tahun_kelas10,$id_tagihan,1,$r->bsm);
$cek_2 = biaya($id_tahun_kelas11,$id_tagihan,2,$r->bsm);
$cek_3 = biaya($id_tahun_kelas12,$id_tagihan,3,$r->bsm);

if($cek_1)
{   
    if($id_tagihan == 1 AND $id_tahun_kelas10 == 19)
    {

    }else
    {
        $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas10,$id_tagihan,0);
        $biaya = biaya($id_tahun_kelas10,$id_tagihan,1,$r->bsm);
        $biaya_hasil = $biaya * 12;
        $biaya_akhir = $biaya_akhir + $biaya_hasil;
        $sudah_dibayar_hasil = 0;
        foreach($bulan->result() as $b):
            $sudah_dibayar = sudah_dibayar_bulanan($id_tagihan_tahunan,$b->id_bulan,$r->id_siswa);
            $sudah_dibayar_hasil = $sudah_dibayar_hasil + $sudah_dibayar;
        endforeach;
        $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar_hasil;
        $kurang = $biaya_hasil - $sudah_dibayar_hasil;
        $kurang_akhir = $kurang_akhir + $kurang;
        if($kurang > 0)
        {
            $status = '<label class="badge badge-danger">BELUM LUNAS</label>';
        }else
        {
            $status = '<label class="badge badge-primary">LUNAS</label>';
        }
        echo'<tr>
                <td align="center">'.$no++.'.</td>
                <td>'.$r->nis.'</td>
                <td>'.$r->nama.'</td>
                <td align="center">'.tahun(id_tahunpelajaran_siswa($r->id_siswa)).'</td>
                <td align="center">'.siswa_kelas($r->id_siswa).'</td>
                <td>'.strtoupper(tagihan($id_tagihan)).' ( TP '.tahun($id_tahun_kelas10).' KELAS X )</td>
                <td align="right">'.number_format($biaya_hasil, 0, ',', '.').'</td>
                <td align="right">'.number_format($sudah_dibayar_hasil, 0, ',', '.').'</td>
                <td align="right">'.number_format($kurang, 0, ',', '.').'</td>
                <td align="center">'.$status.'</td>
            </tr>';
    }
} 

if($cek_2)
{   
    if($id_tagihan == 1 AND $id_tahun_kelas11 == 19)
    {

    }else
    {
        $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas11,$id_tagihan,0);
        $biaya = biaya($id_tahun_kelas11,$id_tagihan,2,$r->bsm);
        $biaya_hasil = $biaya * 12;
        $biaya_akhir = $biaya_akhir + $biaya_hasil;
        $sudah_dibayar_hasil = 0;
        foreach($bulan->result() as $b):
            $sudah_dibayar = sudah_dibayar_bulanan($id_tagihan_tahunan,$b->id_bulan,$r->id_siswa);
            $sudah_dibayar_hasil = $sudah_dibayar_hasil + $sudah_dibayar;
        endforeach;
        $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar_hasil;
        $kurang = $biaya_hasil - $sudah_dibayar_hasil;
        $kurang_akhir = $kurang_akhir + $kurang;
        if($kurang > 0)
        {
            $status = '<label class="badge badge-danger">BELUM LUNAS</label>';
        }else
        {
            $status = '<label class="badge badge-primary">LUNAS</label>';
        }
        echo'<tr>
                <td align="center">'.$no++.'.</td>
                <td>'.$r->nis.'</td>
                <td>'.$r->nama.'</td>
                <td align="center">'.tahun(id_tahunpelajaran_siswa($r->id_siswa)).'</td>
                <td align="center">'.siswa_kelas($r->id_siswa).'</td>
                <td>'.strtoupper(tagihan($id_tagihan)).' ( TP '.tahun($id_tahun_kelas11).' KELAS XI )</td>
                <td align="right">'.number_format($biaya_hasil, 0, ',', '.').'</td>
                <td align="right">'.number_format($sudah_dibayar_hasil, 0, ',', '.').'</td>
                <td align="right">'.number_format($kurang, 0, ',', '.').'</td>
                <td align="center">'.$status.'</td>
            </tr>';
    }
}

if($cek_3)
{   
    if($id_tagihan == 1 AND $id_tahun_kelas12 == 19)
    {

    }else
    {
        $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas12,$id_tagihan,0);
        $biaya = biaya($id_tahun_kelas12,$id_tagihan,3,$r->bsm);
        $biaya_hasil = $biaya * 12;
        $biaya_akhir = $biaya_akhir + $biaya_hasil;
        $sudah_dibayar_hasil = 0;
        foreach($bulan->result() as $b):
            $sudah_dibayar = sudah_dibayar_bulanan($id_tagihan_tahunan,$b->id_bulan,$r->id_siswa);
            $sudah_dibayar_hasil = $sudah_dibayar_hasil + $sudah_dibayar;
        endforeach;
        $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar_hasil;
        $kurang = $biaya_hasil - $sudah_dibayar_hasil;
        $kurang_akhir = $kurang_akhir + $kurang;
        if($kurang > 0)
        {
            $status = '<label class="badge badge-danger">BELUM LUNAS</label>';
        }else
        {
            $status = '<label class="badge badge-primary">LUNAS</label>';
        }
        echo'<tr>
                <td align="center">'.$no++.'.</td>
                <td>'.$r->nis.'</td>
                <td>'.$r->nama.'</td>
                <td align="center">'.tahun(id_tahunpelajaran_siswa($r->id_siswa)).'</td>
                <td align="center">'.siswa_kelas($r->id_siswa).'</td>
                <td>'.strtoupper(tagihan($id_tagihan)).' ( TP '.tahun($id_tahun_kelas12).' KELAS XII )</td>
                <td align="right">'.number_format($biaya_hasil, 0, ',', '.').'</td>
                <td align="right">'.number_format($sudah_dibayar_hasil, 0, ',', '.').'</td>
                <td align="right">'.number_format($kurang, 0, ',', '.').'</td>
                <td align="center">'.$status.'</td>
            </tr>';
    }
}
?>  