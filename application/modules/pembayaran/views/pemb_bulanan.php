<?php 
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
            $cek++; ?>
            <div class="col-md-4 bg-white border border-info mb-2">
            <?php echo form_open('backend/bayar/'.$this->uri->segment('3')); ?>
                <div class="row">
                    <div class="col-md-12 bg-secondary text-white text-bold">
                        &raquo; <?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahun_kelas10); ?> KELAS X )
                    </div>
                    <div class="col-md-4 mt-2">
                        Bulan 
                    </div>
                    <div class="col-md-8 mt-2">
                        :   <?php 
                            $cek_januari = sudah_dibayar_bulanan($id_tagihan_tahunan,1,$siswa->id_siswa);
                            $cek_februari = sudah_dibayar_bulanan($id_tagihan_tahunan,2,$siswa->id_siswa);
                            $cek_maret = sudah_dibayar_bulanan($id_tagihan_tahunan,3,$siswa->id_siswa);
                            $cek_april = sudah_dibayar_bulanan($id_tagihan_tahunan,4,$siswa->id_siswa);
                            $cek_mei = sudah_dibayar_bulanan($id_tagihan_tahunan,5,$siswa->id_siswa);
                            $cek_juni = sudah_dibayar_bulanan($id_tagihan_tahunan,6,$siswa->id_siswa);
                            $cek_juli = sudah_dibayar_bulanan($id_tagihan_tahunan,7,$siswa->id_siswa);
                            $cek_agustus = sudah_dibayar_bulanan($id_tagihan_tahunan,8,$siswa->id_siswa);
                            $cek_september = sudah_dibayar_bulanan($id_tagihan_tahunan,9,$siswa->id_siswa);
                            $cek_oktober = sudah_dibayar_bulanan($id_tagihan_tahunan,10,$siswa->id_siswa);
                            $cek_november = sudah_dibayar_bulanan($id_tagihan_tahunan,11,$siswa->id_siswa);
                            $cek_desember = sudah_dibayar_bulanan($id_tagihan_tahunan,12,$siswa->id_siswa);
                            
                            if($cek_januari == $biaya)
                            {   
                                if($cek_februari == $biaya)
                                {    
                                    if($cek_maret == $biaya)
                                    {
                                        if($cek_april == $biaya)
                                        {
                                            if($cek_mei == $biaya)
                                            {
                                                if($cek_juni == $biaya)
                                                {
                                                    if($cek_juli == $biaya)
                                                    {
                                                        if($cek_agustus == $biaya)
                                                        {                                
                                                            if($cek_september == $biaya)
                                                            {
                                                                if($cek_oktober == $biaya)
                                                                {
                                                                    if($cek_november == $biaya)
                                                                    {
                                                                        if($cek_desember == $biaya)
                                                                        {
                                                                            $id_bulan = 12;
                                                                        }else{
                                                                            $id_bulan = 12;   
                                                                        }
                                                                    }else{
                                                                        $id_bulan = 11;
                                                                    }
                                                                }else{
                                                                    $id_bulan = 10;
                                                                }
                                                            }else{
                                                                $id_bulan = 9;
                                                            }
                                                        }else{
                                                            $id_bulan = 8;
                                                        }
                                                    }else{
                                                        $id_bulan = 7;
                                                    }
                                                }else{
                                                    $id_bulan = 6;
                                                }
                                            }else{
                                                $id_bulan = 5;
                                            }
                                        }else{
                                            $id_bulan = 4;
                                        }
                                    }else{
                                        $id_bulan = 3;
                                    }
                                }else{
                                    $id_bulan = 2;
                                }
                            }else{
                                $id_bulan = 1;
                            }
                            echo'<select name="id_bulan">
                                    <option value="'.$id_bulan.'">'.bulan($id_bulan).'</option>
                                </select>
                    </div>
                    <div class="col-md-4">
                        Biaya
                    </div>
                    <div class="col-md-8">';
                        echo ': '.number_format($biaya, 0, ',', '.').'
                    </div>';
                if($cek > 0){ ?>
                    <div class="col-md-4">
                        Sudah Dibayar
                    </div>
                    <div class="col-md-8">
                    : <?php
                        $sudah_dibayar = sudah_dibayar_bulanan($id_tagihan_tahunan,$id_bulan,$siswa->id_siswa);
                        echo number_format($sudah_dibayar, 0, ',', '.');
                    ?>
                    </div>
                    <div class="col-md-4">
                        Kurang
                    </div>
                    <div class="col-md-8">
                    : <?php
                        $kurang = $biaya - $sudah_dibayar;
                        echo number_format($kurang, 0, ',', '.');
                        ?>
                    </div>
                    <div class="col-md-4">
                        Status
                    </div>
                    <div class="col-md-8">
                    : <?php
                        if($kurang > 0 )
                        {
                            echo'<label class="badge badge-danger">BELUM LUNAS</label>';
                        }else
                        {
                            echo'<label class="badge badge-primary">LUNAS</label>';
                        }
                        ?>
                    </div>
                    <?php if($kurang > 0){ ?>
                    <div class="col-md-12 text-bold">
                        PEMBAYARAN
                    </div>
                    <div class="col-md-4">
                        Tunai
                    </div>
                    <div class="col-md-8">
                        : <input type="hidden" name="id_siswa" value="<?= $siswa->id_siswa; ?>">
                        <input type="hidden" name="id_tagihan_tahunan" value="<?= $id_tagihan_tahunan; ?>">
                        <input type="hidden" name="kurang" value="<?= $kurang; ?>" min="0" max="<?= $kurang; ?>" required>
                        <input type="number" name="bayar" min="0" max="<?= $kurang; ?>" onkeypress="return hanyaAngka(event)" class="col-md-10">
                    </div>
                    <div class="col-md-4 mt-2">
                        dari Tabungan
                    </div>
                    <div class="col-md-8 mt-2">
                        : <input type="number" name="daritabungan" min="0" max="<?= tabungan($siswa->id_siswa); ?>" onkeypress="return hanyaAngka(event)" class="col-md-10" <?php if(tabungan($siswa->id_siswa) == 0){ echo'disabled'; } ?> >
                    </div>
                    <div class="col-md-4 mb-2 mt-2">
                        
                    </div>
                    <div class="col-md-8 mb-2 mt-2">
                        <button type="submit" name="submit" value="Submit" class="btn btn-flat btn-info btn-sm text-white text-bold ml-2">BAYARKAN</button>
                    </div>
                    <?php }
                } ?>
                </div>
                <?php echo form_close(); ?>
            </div>
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
            $cek++; ?>
            <div class="col-md-4 bg-white border border-info mb-2">
            <?php echo form_open('backend/bayar/'.$this->uri->segment('3')); ?>
                <div class="row">
                    <div class="col-md-12 bg-secondary text-white text-bold">
                        &raquo; <?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahun_kelas11); ?> KELAS XI )
                    </div>
                    <div class="col-md-4 mt-2">
                        Bulan 
                    </div>
                    <div class="col-md-8 mt-2">
                        :   <?php 
                            $cek_januari = sudah_dibayar_bulanan($id_tagihan_tahunan,1,$siswa->id_siswa);
                            $cek_februari = sudah_dibayar_bulanan($id_tagihan_tahunan,2,$siswa->id_siswa);
                            $cek_maret = sudah_dibayar_bulanan($id_tagihan_tahunan,3,$siswa->id_siswa);
                            $cek_april = sudah_dibayar_bulanan($id_tagihan_tahunan,4,$siswa->id_siswa);
                            $cek_mei = sudah_dibayar_bulanan($id_tagihan_tahunan,5,$siswa->id_siswa);
                            $cek_juni = sudah_dibayar_bulanan($id_tagihan_tahunan,6,$siswa->id_siswa);
                            $cek_juli = sudah_dibayar_bulanan($id_tagihan_tahunan,7,$siswa->id_siswa);
                            $cek_agustus = sudah_dibayar_bulanan($id_tagihan_tahunan,8,$siswa->id_siswa);
                            $cek_september = sudah_dibayar_bulanan($id_tagihan_tahunan,9,$siswa->id_siswa);
                            $cek_oktober = sudah_dibayar_bulanan($id_tagihan_tahunan,10,$siswa->id_siswa);
                            $cek_november = sudah_dibayar_bulanan($id_tagihan_tahunan,11,$siswa->id_siswa);
                            $cek_desember = sudah_dibayar_bulanan($id_tagihan_tahunan,12,$siswa->id_siswa);
                            
                            if($cek_januari == $biaya)
                            {   
                                if($cek_februari == $biaya)
                                {    
                                    if($cek_maret == $biaya)
                                    {
                                        if($cek_april == $biaya)
                                        {
                                            if($cek_mei == $biaya)
                                            {
                                                if($cek_juni == $biaya)
                                                {
                                                    if($cek_juli == $biaya)
                                                    {
                                                        if($cek_agustus == $biaya)
                                                        {                                
                                                            if($cek_september == $biaya)
                                                            {
                                                                if($cek_oktober == $biaya)
                                                                {
                                                                    if($cek_november == $biaya)
                                                                    {
                                                                        if($cek_desember == $biaya)
                                                                        {
                                                                            $id_bulan = 12;
                                                                        }else{
                                                                            $id_bulan = 12;   
                                                                        }
                                                                    }else{
                                                                        $id_bulan = 11;
                                                                    }
                                                                }else{
                                                                    $id_bulan = 10;
                                                                }
                                                            }else{
                                                                $id_bulan = 9;
                                                            }
                                                        }else{
                                                            $id_bulan = 8;
                                                        }
                                                    }else{
                                                        $id_bulan = 7;
                                                    }
                                                }else{
                                                    $id_bulan = 6;
                                                }
                                            }else{
                                                $id_bulan = 5;
                                            }
                                        }else{
                                            $id_bulan = 4;
                                        }
                                    }else{
                                        $id_bulan = 3;
                                    }
                                }else{
                                    $id_bulan = 2;
                                }
                            }else{
                                $id_bulan = 1;
                            }
                            echo'<select name="id_bulan">
                                    <option value="'.$id_bulan.'">'.bulan($id_bulan).'</option>
                                </select>
                    </div>
                    <div class="col-md-4">
                        Biaya
                    </div>
                    <div class="col-md-8">';
                        echo ': '.number_format($biaya, 0, ',', '.').'
                    </div>';
                if($cek > 0){ ?>
                    <div class="col-md-4">
                        Sudah Dibayar
                    </div>
                    <div class="col-md-8">
                    : <?php
                        $sudah_dibayar = sudah_dibayar_bulanan($id_tagihan_tahunan,$id_bulan,$siswa->id_siswa);
                        echo number_format($sudah_dibayar, 0, ',', '.');
                    ?>
                    </div>
                    <div class="col-md-4">
                        Kurang
                    </div>
                    <div class="col-md-8">
                    : <?php
                        $kurang = $biaya - $sudah_dibayar;
                        echo number_format($kurang, 0, ',', '.');
                        ?>
                    </div>
                    <div class="col-md-4">
                        Status
                    </div>
                    <div class="col-md-8">
                    : <?php
                        if($kurang > 0 )
                        {
                            echo'<label class="badge badge-danger">BELUM LUNAS</label>';
                        }else
                        {
                            echo'<label class="badge badge-primary">LUNAS</label>';
                        }
                        ?>
                    </div>
                    <?php if($kurang > 0){ ?>
                    <div class="col-md-12 text-bold">
                        PEMBAYARAN
                    </div>
                    <div class="col-md-4">
                        Tunai
                    </div>
                    <div class="col-md-8">
                        : <input type="hidden" name="id_siswa" value="<?= $siswa->id_siswa; ?>">
                        <input type="hidden" name="id_tagihan_tahunan" value="<?= $id_tagihan_tahunan; ?>">
                        <input type="hidden" name="kurang" value="<?= $kurang; ?>" min="0" max="<?= $kurang; ?>" required>
                        <input type="number" name="bayar" min="0" max="<?= $kurang; ?>" onkeypress="return hanyaAngka(event)" class="col-md-10">
                    </div>
                    <div class="col-md-4 mt-2">
                        dari Tabungan
                    </div>
                    <div class="col-md-8 mt-2">
                        : <input type="number" name="daritabungan" min="0" max="<?= tabungan($siswa->id_siswa); ?>" onkeypress="return hanyaAngka(event)" class="col-md-10" <?php if(tabungan($siswa->id_siswa) == 0){ echo'disabled'; } ?> >
                    </div>
                    <div class="col-md-4 mb-2 mt-2">
                    
                    </div>
                    <div class="col-md-8 mb-2 mt-2">
                        : <button type="submit" name="submit" value="Submit" class="btn btn-flat btn-info btn-sm text-white text-bold ml-2">BAYARKAN</button>
                    </div>
                    <?php }
                } ?>
                </div>
                <?php echo form_close(); ?>
            </div>
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
            $cek++; ?>
            <div class="col-md-4 bg-white border border-info mb-2">
            <?php echo form_open('backend/bayar/'.$this->uri->segment('3')); ?>
                <div class="row">
                    <div class="col-md-12 bg-secondary text-white text-bold">
                        &raquo; <?= strtoupper(tagihan($r->id_tagihan)); ?> ( TP <?= tahun($id_tahun_kelas12); ?> KELAS XII )
                    </div>
                    <div class="col-md-4 mt-2">
                        Bulan 
                    </div>
                    <div class="col-md-8 mt-2">
                        :   <?php 
                            $cek_juli = sudah_dibayar_bulanan($id_tagihan_tahunan,1,$siswa->id_siswa);
                            $cek_agustus = sudah_dibayar_bulanan($id_tagihan_tahunan,2,$siswa->id_siswa);
                            $cek_september = sudah_dibayar_bulanan($id_tagihan_tahunan,3,$siswa->id_siswa);
                            $cek_oktober = sudah_dibayar_bulanan($id_tagihan_tahunan,4,$siswa->id_siswa);
                            $cek_november = sudah_dibayar_bulanan($id_tagihan_tahunan,5,$siswa->id_siswa);
                            $cek_desember = sudah_dibayar_bulanan($id_tagihan_tahunan,6,$siswa->id_siswa);                           
                            $cek_januari = sudah_dibayar_bulanan($id_tagihan_tahunan,7,$siswa->id_siswa);
                            $cek_februari = sudah_dibayar_bulanan($id_tagihan_tahunan,8,$siswa->id_siswa);
                            $cek_maret = sudah_dibayar_bulanan($id_tagihan_tahunan,9,$siswa->id_siswa);
                            $cek_april = sudah_dibayar_bulanan($id_tagihan_tahunan,10,$siswa->id_siswa);
                            $cek_mei = sudah_dibayar_bulanan($id_tagihan_tahunan,11,$siswa->id_siswa);
                            $cek_juni = sudah_dibayar_bulanan($id_tagihan_tahunan,12,$siswa->id_siswa);
                            
                            if($cek_juli == $biaya)
                            {   
                                if($cek_agustus == $biaya)
                                {    
                                    if($cek_september == $biaya)
                                    {
                                        if($cek_oktober == $biaya)
                                        {
                                            if($cek_november == $biaya)
                                            {
                                                if($cek_desember == $biaya)
                                                {
                                                    if($cek_januari == $biaya)
                                                    {
                                                        if($cek_februari == $biaya)
                                                        {                                
                                                            if($cek_maret == $biaya)
                                                            {
                                                                if($cek_april == $biaya)
                                                                {
                                                                    if($cek_mei == $biaya)
                                                                    {
                                                                        if($cek_juni == $biaya)
                                                                        {
                                                                            $id_bulan = 12;
                                                                        }else
                                                                        {
                                                                            $id_bulan = 12;   
                                                                        }
                                                                    }else
                                                                    {
                                                                        $id_bulan = 11;
                                                                    }
                                                                }else
                                                                {
                                                                    $id_bulan = 10;
                                                                }
                                                            }else
                                                            {
                                                                $id_bulan = 9;
                                                            }
                                                        }else
                                                        {
                                                            $id_bulan = 8;
                                                        }
                                                    }else
                                                    {
                                                        $id_bulan = 7;
                                                    }
                                                }else
                                                {
                                                    $id_bulan = 6;
                                                }
                                            }else
                                            {
                                                $id_bulan = 5;
                                            }
                                        }else
                                        {
                                            $id_bulan = 4;
                                        }
                                    }else
                                    {
                                        $id_bulan = 3;
                                    }
                                }else
                                {
                                    $id_bulan = 2;
                                }
                            }else
                            {
                                $id_bulan = 1;
                            }
                            echo'<select name="id_bulan">
                                    <option value="'.$id_bulan.'">'.bulan($id_bulan).'</option>
                                </select>
                    </div>
                    <div class="col-md-4">
                        Biaya
                    </div>
                    <div class="col-md-8">';
                        echo ': '.number_format($biaya, 0, ',', '.').'
                    </div>';
                if($cek > 0){ ?>
                    <div class="col-md-4">
                        Sudah Dibayar
                    </div>
                    <div class="col-md-8">
                    : <?php
                        $sudah_dibayar = sudah_dibayar_bulanan($id_tagihan_tahunan,$id_bulan,$siswa->id_siswa);
                        echo number_format($sudah_dibayar, 0, ',', '.');
                    ?>
                    </div>
                    <div class="col-md-4">
                        Kurang
                    </div>
                    <div class="col-md-8">
                    : <?php
                        $kurang = $biaya - $sudah_dibayar;
                        echo number_format($kurang, 0, ',', '.');
                        ?>
                    </div>
                    <div class="col-md-4">
                        Status
                    </div>
                    <div class="col-md-8">
                    : <?php
                        if($kurang > 0 )
                        {
                            echo'<label class="badge badge-danger">BELUM LUNAS</label>';
                        }else
                        {
                            echo'<label class="badge badge-primary">LUNAS</label>';
                        }
                        ?>
                    </div>
                    <?php if($kurang > 0){ ?>
                    <div class="col-md-12 text-bold">
                        PEMBAYARAN
                    </div>
                    <div class="col-md-4">
                        Tunai
                    </div>
                    <div class="col-md-8">
                        : <input type="hidden" name="id_siswa" value="<?= $siswa->id_siswa; ?>">
                        <input type="hidden" name="id_tagihan_tahunan" value="<?= $id_tagihan_tahunan; ?>">
                        <input type="hidden" name="kurang" value="<?= $kurang; ?>" min="0" max="<?= $kurang; ?>" required>
                        <input type="number" name="bayar" min="0" max="<?= $kurang; ?>" onkeypress="return hanyaAngka(event)" class="col-md-10">
                    </div>
                    <div class="col-md-4 mt-2">
                        dari Tabungan
                    </div>
                    <div class="col-md-8 mt-2">
                        : <input type="number" name="daritabungan" min="0" max="<?= tabungan($siswa->id_siswa); ?>" onkeypress="return hanyaAngka(event)" class="col-md-10" <?php if(tabungan($siswa->id_siswa) == 0){ echo'disabled'; } ?> >
                    </div>
                    <div class="col-md-4 mb-2 mt-2">
                        
                    </div>
                    <div class="col-md-8 mb-2 mt-2">
                        : <button type="submit" name="submit" value="Submit" class="btn btn-flat btn-info btn-sm text-white text-bold ml-2">BAYARKAN</button>
                    </div>
                    <?php }
                } ?>
                </div>
                <?php echo form_close(); ?>
            </div>
            <?php
        }
    } 
endforeach; 

if( ( $cek == 0 ) OR ( $pemb_bulanan->num_rows() == 0 ) ){
    include('belum_ada_tagihan.php');
} ?>