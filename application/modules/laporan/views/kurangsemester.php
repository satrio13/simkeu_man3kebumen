<?php
$ada = 0;
$siswa_smt = siswa_smt($r->id_siswa);
foreach($siswa_smt as $k): 
    $cek = biaya_semester($k->id_tahunpelajaran,$id_tagihan,$k->id_semester,tingkat($k->tingkat),$r->bsm);
    if($cek)
    { 
        $ada++;
        $id_tagihan_tahunan = id_tagihan_tahunan($k->id_tahunpelajaran,$id_tagihan,tingkat($k->tingkat));
        $biaya = biaya_semester($k->id_tahunpelajaran,$id_tagihan,$k->id_semester,tingkat($k->tingkat),$r->bsm);
        $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
        $kurang = $biaya - $sudah_dibayar;

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
                <td class="text-center">'.$no++.'</td>
                <td>'.$r->nis.'</td>
                <td>'.$r->nama.'</td>
                <td class="text-center">'.tahun(id_tahunpelajaran_siswa($r->id_siswa)).'</td>
                <td class="text-center">'.siswa_kelas($r->id_siswa).'</td>
                <td>'.strtoupper(tagihan($id_tagihan)).' ( TP '.$k->tahunpelajaran.' KELAS '.$k->tingkat.'  SEMESTER '.semester($k->id_semester).' / '.strtoupper($k->smt).' )</td>
                <td class="text-right">'.number_format($biaya, 0, ',', '.').'</td>
                <td class="text-right">'.number_format($sudah_dibayar, 0, ',', '.').'</td>
                <td class="text-right">'.number_format($kurang, 0, ',', '.').'</td>
                <td class="text-center">'.$status.'</td>       
            </tr>';
    }
endforeach;
?>