<?php 
$ada = 0;
$kelas_siswa = kelas_siswa($r->id_siswa);
foreach($kelas_siswa as $k):
    $cek = biaya($k->id_tahunpelajaran,$id_tagihan,tingkat($k->tingkat),$r->bsm);
    if($cek)
    {   
        $ada++; 
        $biaya = biaya($k->id_tahunpelajaran,$id_tagihan,tingkat($k->tingkat),$r->bsm);
        $id_tagihan_tahunan = id_tagihan_tahunan($k->id_tahunpelajaran,$id_tagihan,0);
        $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
        $kurang = $biaya - $sudah_dibayar;
        if($kurang > 0)
        {
            $status = '<label class="badge badge-danger">BELUM LUNAS</label>';
        }else
        {
            $status = '<label class="badge badge-primary">LUNAS</label>';
        }
        echo'<tr>
                <td class="text-center">'.$no++.'</td>
                <td>'.$r->nis.'</td>
                <td>'.$r->nama.'</td>
                <td class="text-center">'.tahun(id_tahunpelajaran_siswa($r->id_siswa)).'</td>
                <td class="text-center">'.siswa_kelas($r->id_siswa).'</td>
                <td>'.strtoupper(tagihan($id_tagihan)).' ( TP '.tahun($k->id_tahunpelajaran).' KELAS '.$k->tingkat.' )</td>
                <td class="text-right">'.number_format($biaya, 0, ',', '.').'</td>
                <td class="text-right">'.number_format($sudah_dibayar, 0, ',', '.').'</td>
                <td class="text-right">'.number_format($kurang, 0, ',', '.').'</td>
                <td class="text-center">'.$status.'</td>       
            </tr>';
        $biaya_akhir = $biaya_akhir + $biaya;
        $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar;
        $kurang_akhir = $kurang_akhir + $kurang;
    }
endforeach;
?>