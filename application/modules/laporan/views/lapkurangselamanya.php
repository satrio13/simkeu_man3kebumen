<?php
$cek = 0;
$tahun = tahun_ks($r->id_siswa);
foreach($tahun as $k):
    $id_tahun_kelas10 = id_tahun_kelas10($r->id_siswa);
    $id_tahun_kelas11 = id_tahun_kelas11($r->id_siswa);
    $id_tahun_kelas12 = id_tahun_kelas12($r->id_siswa);

    $cek_1 = biaya($id_tahun_kelas10,$id_tagihan,1,$r->bsm);
    $cek_2 = biaya($id_tahun_kelas11,$id_tagihan,2,$r->bsm);
    $cek_3 = biaya($id_tahun_kelas12,$id_tagihan,3,$r->bsm);

    if($cek_1)
    { 
        $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas10,$id_tagihan,0);
        $biaya = biaya($id_tahun_kelas10,$id_tagihan,1,$r->bsm);
        $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
        $kurang = $biaya - $sudah_dibayar;
        $cek++;

        $biaya_akhir = $biaya_akhir + $biaya;
        $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar;
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
                <td align="right">'.number_format($biaya, 0, ',', '.').'</td>
                <td align="right">'.number_format($sudah_dibayar, 0, ',', '.').'</td>
                <td align="right">'.number_format($kurang, 0, ',', '.').'</td>
                <td align="center">'.$status.'</td>
            </tr>';
        break;
    }elseif($cek_2)
    { 
        $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas11,$id_tagihan,0);
        $biaya = biaya($id_tahun_kelas11,$id_tagihan,2,$r->bsm);
        $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
        $kurang = $biaya - $sudah_dibayar;
        $cek++;

        $biaya_akhir = $biaya_akhir + $biaya;
        $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar;
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
                <td align="right">'.number_format($biaya, 0, ',', '.').'</td>
                <td align="right">'.number_format($sudah_dibayar, 0, ',', '.').'</td>
                <td align="right">'.number_format($kurang, 0, ',', '.').'</td>
                <td align="center">'.$status.'</td>
            </tr>';
        break;
    }elseif($cek_3)
    { 
        $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas12,$id_tagihan,0);
        $biaya = biaya($id_tahun_kelas12,$id_tagihan,3,$r->bsm);
        $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
        $kurang = $biaya - $sudah_dibayar;
        $cek++;

        $biaya_akhir = $biaya_akhir + $biaya;
        $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar;
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
                <td align="right">'.number_format($biaya, 0, ',', '.').'</td>
                <td align="right">'.number_format($sudah_dibayar, 0, ',', '.').'</td>
                <td align="right">'.number_format($kurang, 0, ',', '.').'</td>
                <td align="center">'.$status.'</td>
            </tr>';
        break;
    }    
endforeach;
?>