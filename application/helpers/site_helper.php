<?php 
   function pesan_sukses($str)
   {
      return "<script type='text/javascript'>
                  setTimeout(function () { 
                     swal({
                        position: 'top-end',
                        icon: 'success',
                        title: '$str',
                        showConfirmButton: false,
                        timer: 1500
                     });
                  },2000); 
                  window.setTimeout(function(){ 
                  } ,5000); 
               </script>";
   }

   function pesan_gagal($str)
   {
      return "<script type='text/javascript'>
                  setTimeout(function () { 
                     swal({
                        position: 'top-end',
                        icon: 'error',
                        title: '$str',
                        showConfirmButton: false,
                        timer: 5000
                     });
                  },2000); 
                  window.setTimeout(function(){ 
                  } ,5000); 
               </script>";
   }

   function tgl_simpan_sekarang()
   {
      date_default_timezone_set('Asia/Jakarta');
      return date('Y-m-d');
   }

   function tgl_jam_simpan_sekarang()
   {
      date_default_timezone_set('Asia/Jakarta');
      return date('Y-m-d H:i:s');
   }

   function is_email($str)
   {
      return filter_var($str, FILTER_VALIDATE_EMAIL);
   }

   function is_url($str)
   {
      return preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$str);
   }
    
   function cetak($str)
   {
      return strip_tags(htmlentities($str, ENT_QUOTES, 'UTF-8'));
   }

   function semester_trans($id_kelas)
   {
      $ci = & get_instance();
      $q = $ci->db->get_where('tb_kelas', ['id_kelas' => $id_kelas])->row_array();
      if($q['tingkat'] == 'X')
      {
         return 1;
      }elseif($q['tingkat'] == 'XI')
      {
         return 3;
      }elseif($q['tingkat'] == 'XII')
      {
         return 5;
      }
   }
    
   function nama_user($id_user)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_user,nama')->from('tb_user')->where('id_user',$id_user)->get()->row_array();
      return $q['nama'];
   }

   function level($id_user)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_user,level')->from('tb_user')->where('id_user',$id_user)->get()->row_array();
      return $q['level'];
   }

   function nip($id_user)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_user,nip')->from('tb_user')->where('id_user',$id_user)->get()->row_array();
      return $q['nip'];
   }

   function img_user($id_user)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_user,gambar')->from('tb_user')->where('id_user',$id_user)->get()->row_array();
      return $q['gambar'];
   }

   function ttd($id_user)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_user,ttd')->from('tb_user')->where('id_user',$id_user)->get()->row_array();
      return $q['ttd'];
   }

   function nama_ks()
   {
      $ci = & get_instance();
      $q = $ci->db->select('nama,level,is_active')->from('tb_user')->where('level','ks')->where('is_active',1)->get()->row_array();
      return $q['nama'];
   }

   function nip_ks()
   {
      $ci = & get_instance();
      $q = $ci->db->select('nip,level,is_active')->from('tb_user')->where('level','ks')->where('is_active',1)->get()->row_array();
      return $q['nip'];
   }

   function id_kelas_wali($id_tahunpelajaran,$id_kelas)
   {
      $ci = & get_instance();
      $q = $ci->db->select('*')->from('tb_kelas_wali')->where('id_tahunpelajaran',$id_tahunpelajaran)->where('id_kelas',$id_kelas)->get()->row_array();
      return $q['id_kelas_wali'];
   }

   function id_siswa_ks($id_kelas_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_kelas_siswa,id_siswa')->from('tb_kelas_siswa')->where('id_kelas_siswa',$id_kelas_siswa)->get()->row_array();
      return $q['id_siswa'];
   }

   function id_kelas_from_ks($id_kelas_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_kelas_siswa,id_kelas')->from('tb_kelas_siswa')->where('id_kelas_siswa',$id_kelas_siswa)->get()->row_array();
      return $q['id_kelas'];
   }

   function id_siswa($id_kelas_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('*')->from('tb_kelas_siswa')->where('id_kelas_siswa',$id_kelas_siswa)->get()->row_array();
      return $q['id_siswa'];
   }

   function id_semester($id_kelas_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('*')->from('tb_kelas_siswa')->where('id_kelas_siswa',$id_kelas_siswa)->get()->row_array();
      return $q['id_semester'];
   }

   function smt_pemb($id_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_siswa,id_semester')->from('tb_pembayaran')->where('id_siswa',$id_siswa)->order_by('id_semester','desc')->get()->row_array();
      return $q['id_semester'];
   }

   function id_jenistagihan($id_tagihan)
   {
      $ci = & get_instance();
      $q = $ci->db->select('*')->from('tb_tagihan')->where('id_tagihan',$id_tagihan)->get()->row_array();
      return $q['id_jenistagihan'];
   }

   function bulan($id_bulan)
   {
      $ci = & get_instance();
      $q = $ci->db->select('*')->from('tb_bulan')->where('id_bulan',$id_bulan)->get()->row_array();
      return $q['bulan'];
   }

   function semester($id_semester)
   {
      $ci = & get_instance();
      $q = $ci->db->select('*')->from('tb_semester')->where('id_semester',$id_semester)->get()->row_array();
      return $q['semester'];
   }

   function tahun($id_tahunpelajaran)
   {
      $ci = & get_instance();
      $q = $ci->db->select('*')->from('tb_tahunpelajaran')->where('id_tahunpelajaran',$id_tahunpelajaran)->get()->row_array();
      return $q['tahunpelajaran'];
   }

   function tahun_pemb($id_tagihan_tahunan)
   {
      $ci = & get_instance();
      $q = $ci->db->select('d.id_tagihan_tahunan,d.id_tahunpelajaran,t.tahunpelajaran')->from('tb_tagihan_tahunan d')->join('tb_tahunpelajaran t','d.id_tahunpelajaran=t.id_tahunpelajaran')->where('d.id_tagihan_tahunan',$id_tagihan_tahunan)->get()->row_array();
      return $q['tahunpelajaran'];
   }

   function kelas($id_kelas)
   {
      $ci = & get_instance();
      $q = $ci->db->select('*')->from('tb_kelas')->where('id_kelas',$id_kelas)->get()->row_array();
      return $q['kelas'];
   }

   function tingkat_kelas($id_kelas)
   {
      $ci = & get_instance();
      $q = $ci->db->select('*')->from('tb_kelas')->where('id_kelas',$id_kelas)->get()->row_array();
      return $q['tingkat'];
   }
   
   function nis_to_id($nis)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_siswa,nis')->from('tb_siswa')->where('nis',$nis)->get()->row_array();
      return $q['id_siswa'];
   }

   function siswa_sekarang($id_siswa)
   {
      $ci = & get_instance();
      return $ci->db->select('d.id_kelas_siswa,d.id_siswa,d.id_kelas_wali,d.id_semester,d.bsm,s.nis,s.nama,kw.id_kelas,kw.id_tahunpelajaran,k.kelas,k.id_jurusan,k.tingkat,m.semester,m.smt,t.tahunpelajaran,j.jurusan')
         ->from('tb_kelas_siswa d')
         ->join('tb_siswa s','d.id_siswa=s.id_siswa')
         ->join('tb_kelas_wali kw','d.id_kelas_wali=kw.id_kelas_wali')
         ->join('tb_kelas k','kw.id_kelas=k.id_kelas')
         ->join('tb_semester m','d.id_semester=m.id_semester')
         ->join('tb_tahunpelajaran t','kw.id_tahunpelajaran=t.id_tahunpelajaran')
         ->join('tb_jurusan j','k.id_jurusan=j.id_jurusan')
         ->where('d.id_siswa',$id_siswa)
         ->order_by('d.id_semester','desc')
         ->get()->row();
   }

   function id_tagihan($id_tagihan_tahunan)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_tagihan_tahunan,id_tagihan')->from('tb_tagihan_tahunan')->where('id_tagihan_tahunan',$id_tagihan_tahunan)->get()->row_array();
      return $q['id_tagihan'];
   }

   function tagihan($id_tagihan)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_tagihan,tagihan')->from('tb_tagihan')->where('id_tagihan',$id_tagihan)->get()->row_array();
      return $q['tagihan'];
   }

   function status_skrg($id_tagihan_tahunan,$id_bulan,$id_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_tagihan_tahunan,id_bulan,status,id_siswa')->from('tb_pembayaran')->where('id_tagihan_tahunan',$id_tagihan_tahunan)->where('status','l')->where('id_bulan',$id_bulan)->where('id_siswa',$id_siswa)->get()->row_array();
      return $q['status'];
   }

   function id_kelas_siswa($id_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_kelas_siswa,id_siswa,id_semester')->from('tb_kelas_siswa')->where('id_siswa',$id_siswa)->order_by('id_semester','desc')->get()->row_array();
      return $q['id_kelas_siswa'];
   }

   function kelas_siswa($id_siswa)
   {
      $ci = & get_instance();
      $id_siswa = $ci->db->escape_str($id_siswa);
      return $ci->db->query("SELECT ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,ks.bsm,kw.id_tahunpelajaran,kw.id_kelas,kw.id_guru,k.tingkat FROM tb_kelas_siswa ks JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali JOIN tb_kelas k ON kw.id_kelas=k.id_kelas WHERE ks.id_siswa=$id_siswa GROUP BY kw.id_tahunpelajaran")->result();
   }
   
   function id_siswa_tabungan($id_tabungan)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_tabungan,id_siswa')->from('tb_tabungan')->where('id_tabungan',$id_tabungan)->get()->row_array();
      return $q['id_siswa'];
   }

   function tgl_tabungan($id_tabungan)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_tabungan,tgl')->from('tb_tabungan')->where('id_tabungan',$id_tabungan)->get()->row_array();
      return substr($q['tgl'],0,10);
   }
   
   function tabungan($id_siswa)
   {
      $ci = & get_instance();
      $id_siswa = $ci->db->escape_str($id_siswa);
      $q = $ci->db->query("SELECT id_siswa,SUM(nabung) AS tabungan FROM tb_tabungan WHERE id_siswa=$id_siswa")->row_array();
      return $q['tabungan'];
   }

   function kelas_lap($id_siswa,$id_tahunpelajaran)
   {
      $ci = & get_instance();
      $q = $ci->db->select('ks.id_siswa,ks.id_kelas_wali,ks.id_semester,kw.id_kelas,kw.id_tahunpelajaran,k.kelas')->from('tb_kelas_siswa ks')->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')->join('tb_kelas k','kw.id_kelas=k.id_kelas')->where('ks.id_siswa',$id_siswa)->where('kw.id_tahunpelajaran',$id_tahunpelajaran)->order_by('ks.id_semester','asc')->get()->row_array();
      return $q['kelas'];
   }

   function tingkat_lap($id_siswa,$id_tahunpelajaran)
   {
      $ci = & get_instance();
      $q = $ci->db->select('ks.id_siswa,ks.id_kelas_wali,ks.id_semester,kw.id_kelas,kw.id_tahunpelajaran,k.tingkat')->from('tb_kelas_siswa ks')->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')->join('tb_kelas k','kw.id_kelas=k.id_kelas')->where('ks.id_siswa',$id_siswa)->where('kw.id_tahunpelajaran',$id_tahunpelajaran)->order_by('ks.id_semester','asc')->get()->row_array();
      return $q['tingkat'];
   }

   function tahun_ks($id_siswa)
   {
      $ci = & get_instance();
      $id_siswa = $ci->db->escape_str($id_siswa);
      return $ci->db->query("SELECT ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran,t.tahunpelajaran FROM tb_kelas_siswa ks JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali JOIN tb_tahunpelajaran t ON kw.id_tahunpelajaran=t.id_tahunpelajaran WHERE ks.id_siswa=$id_siswa ORDER BY t.tahunpelajaran ASC")->result(); 
   }

   function id_tahunpelajaran_pemb($id_tagihan_tahunan)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_tagihan_tahunan,id_tahunpelajaran')->from('tb_tagihan_tahunan')->where('id_tagihan_tahunan',$id_tagihan_tahunan)->get()->row_array();
      return $q['id_tahunpelajaran'];
   }

   function id_tahun_ks($id_kelas_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('ks.id_kelas_siswa,ks.id_kelas_wali,kw.id_tahunpelajaran')->from('tb_kelas_siswa ks')->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')->where('ks.id_kelas_siswa',$id_kelas_siswa)->get()->row_array();
      return $q['id_tahunpelajaran'];
   }

   function id_tahun_kelas10($id_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('ks.id_siswa,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran')->from('tb_kelas_siswa ks')->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')->where('ks.id_siswa',$id_siswa)->where('ks.id_semester',1)->get()->row_array();
      return $q['id_tahunpelajaran'];
   }

   function id_tahun_kelas11($id_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('ks.id_siswa,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran')->from('tb_kelas_siswa ks')->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')->where('ks.id_siswa',$id_siswa)->where('ks.id_semester',3)->get()->row_array();
      return $q['id_tahunpelajaran'];
   }

   function id_tahun_kelas12($id_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('ks.id_siswa,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran')->from('tb_kelas_siswa ks')->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')->where('ks.id_siswa',$id_siswa)->where('ks.id_semester',5)->get()->row_array();
      return $q['id_tahunpelajaran'];
   }

   function id_kelas_wali_from_ks($id_kelas_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_kelas_siswa,id_kelas_wali')->from('tb_kelas_siswa')->where('id_kelas_siswa',$id_kelas_siswa)->get()->row_array();
      return $q['id_kelas_wali'];
   }

   function id_tahun_from_kw($id_kelas_wali)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_kelas_wali,id_tahunpelajaran')->from('tb_kelas_wali')->where('id_kelas_wali',$id_kelas_wali)->get()->row_array();
      return $q['id_tahunpelajaran'];
   }

   function bsm($id_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_siswa,bsm')->from('tb_kelas_siswa')->where('id_siswa',$id_siswa)->get()->row_array();
      return $q['bsm'];
   }

   function id_tabungan_terakhir($id_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_tabungan,id_siswa')->from('tb_tabungan')->where('id_siswa',$id_siswa)->order_by('id_tabungan','desc')->get()->row_array();
      return $q['id_tabungan'];
   }

   function cek_status_tabungan($id_tabungan)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_tabungan,keterangan')->from('tb_tabungan')->where('id_tabungan',$id_tabungan)->get()->row_array();
      return $q['keterangan'];
   }

   function id_siswa_pemb($id_pembayaran)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_pembayaran,id_siswa')->from('tb_pembayaran')->where('id_pembayaran',$id_pembayaran)->get()->row_array();
      return $q['id_siswa'];
   }

   function tgl_pemb($id_pembayaran)
   {
      $ci = & get_instance();
      $q = $ci->db->select('id_pembayaran,tgl')->from('tb_pembayaran')->where('id_pembayaran',$id_pembayaran)->get()->row_array();
      return substr($q['tgl'],0,10);
   }

   function tingkat($tingkatan)
   {
      switch($tingkatan)
      {
         case 'X':
            $tingkat = 1;
            break;
         case 'XI':
            $tingkat = 2;
            break;
         case 'XII':
            $tingkat = 3;
            break;
      }
      return $tingkat;
   }

   function siswa_kelas($id_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('ks.id_siswa,ks.id_kelas_wali,ks.id_semester,kw.id_kelas,k.kelas')->from('tb_kelas_siswa ks')->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')->join('tb_kelas k','kw.id_kelas=k.id_kelas')->where('ks.id_siswa',$id_siswa)->order_by('ks.id_semester','desc')->get()->row_array();
      return $q['kelas'];
   }
   
   function biaya($id_tahunpelajaran,$id_tagihan,$tingkat,$bsm)
   {
      $ci = & get_instance();
      $q = $ci->db->select('*')->from('tb_tagihan_tahunan')->where('id_tahunpelajaran',$id_tahunpelajaran)->where('id_tagihan',$id_tagihan)->get()->row_array();
      if($bsm == 1)
      {
         if($q['perangkatan_bsm'] != 0)
         {
            return $q['perangkatan_bsm'];
         }else
         {
            if($tingkat == 1)
            {
               return $q['kelas10_bsm'];
            }elseif($tingkat == 2)
            {
               return $q['kelas11_bsm'];
            }elseif($tingkat == 3)
            {
               return $q['kelas12_bsm'];
            }
         }
      }else
      {
         if($q['perangkatan'] != 0)
         {
            return $q['perangkatan'];
         }else
         {
            if($tingkat == 1)
            {
               return $q['kelas10'];
            }elseif($tingkat == 2)
            {
               return $q['kelas11'];
            }elseif($tingkat == 3)
            {
               return $q['kelas12'];
            }
         }
      }
   }

   function biaya_semester($id_tahunpelajaran,$id_tagihan,$id_semester,$tingkat,$bsm)
   {
      $ci = & get_instance();
      $q = $ci->db->select('*')->from('tb_tagihan_tahunan')->where('id_tahunpelajaran',$id_tahunpelajaran)->where('id_tagihan',$id_tagihan)->where('id_tahunpelajaran',$id_tahunpelajaran)->where('id_semester',$id_semester)->get()->row_array();
      if($bsm == 1)
      {
         if($q['perangkatan_bsm'] != 0)
         {
            return $q['perangkatan_bsm'];
         }else
         {
            if($tingkat == 1)
            {
               return $q['kelas10_bsm'];
            }elseif($tingkat == 2)
            {
               return $q['kelas11_bsm'];
            }elseif($tingkat == 3)
            {
               return $q['kelas12_bsm'];
            }
         }
      }else
      {
         if($q['perangkatan'] != 0)
         {
            return $q['perangkatan'];
         }else
         {
            if($tingkat == 1)
            {
               return $q['kelas10'];
            }elseif($tingkat == 2)
            {
               return $q['kelas11'];
            }elseif($tingkat == 3)
            {
               return $q['kelas12'];
            }
         }
      }
   }

   function romawi($angka)
   {
      switch($angka)
      {
         case 1:
            $hasil = 'I';
            break;
         case 2:
            $hasil = 'II';
            break;
         case 3:
            $hasil = 'III';
            break;
         case 4:
            $hasil = 'IV';
            break;
         case 5:
            $hasil = 'V';
            break;
         case 6:
            $hasil = 'VI';
            break;
         default:
            $hasil = "Undefined";		
         break;
      }
      return $hasil;
   }

   function romawi_ke_angka($romawi)
   {
      switch($romawi)
      {
         case 'I':
            $hasil = 1;
            break;
         case 'II':
            $hasil = 2;
            break;
         case 'III':
            $hasil = 3;
            break;
         case 'IV':
            $hasil = 4;
            break;
         case 'V':
            $hasil = 5;
            break;
         case 'VI':
            $hasil = 6;
            break;
         default:
            $hasil = "Undefined";		
         break;
      }
      return $hasil;
   }

   function id_tagihan_tahunan($id_tahunpelajaran,$id_tagihan,$id_semester)
   {
      $ci = & get_instance(); 
      $q = $ci->db->select('id_tagihan_tahunan,id_tagihan,id_tahunpelajaran,id_semester')->from('tb_tagihan_tahunan')->where('id_tahunpelajaran',$id_tahunpelajaran)->where('id_tagihan',$id_tagihan)->where('id_semester',$id_semester)->get()->row_array();
      return $q['id_tagihan_tahunan'];      
   }

   function id_tagihan_pemb($id_tagihan_tahunan)
   {
      $ci = & get_instance(); 
      $q = $ci->db->select('id_tagihan_tahunan,id_tagihan')->from('tb_tagihan_tahunan')->where('id_tagihan_tahunan',$id_tagihan_tahunan)->get()->row_array();
      return $q['id_tagihan'];      
   }

   function sudah_dibayar($id_tagihan_tahunan,$id_siswa)
   {
      $ci = & get_instance();
      $id_tagihan_tahunan = $ci->db->escape_str($id_tagihan_tahunan);
      $id_siswa = $ci->db->escape_str($id_siswa);
      $q = $ci->db->query("SELECT id_tagihan_tahunan,id_siswa,SUM(bayar) AS sudah_dibayar FROM tb_pembayaran WHERE id_tagihan_tahunan=$id_tagihan_tahunan AND id_siswa=$id_siswa")->row_array();
      return $q['sudah_dibayar'];
   }

   function sudah_dibayar_bulanan($id_tagihan_tahunan,$id_bulan,$id_siswa)
   {
      $ci = & get_instance();
      $id_tagihan_tahunan = $ci->db->escape_str($id_tagihan_tahunan);
      $id_bulan = $ci->db->escape_str($id_bulan);
      $id_siswa = $ci->db->escape_str($id_siswa);
      $q = $ci->db->query("SELECT d.id_siswa,d.id_tagihan_tahunan,t.id_tagihan,p.id_tagihan,d.id_bulan,SUM(d.bayar) AS sudah_dibayar 
                           FROM tb_pembayaran d 
                           JOIN tb_tagihan_tahunan t ON d.id_tagihan_tahunan=t.id_tagihan_tahunan
                           JOIN tb_tagihan p ON t.id_tagihan=p.id_tagihan 
                           WHERE d.id_siswa=$id_siswa AND d.id_tagihan_tahunan=$id_tagihan_tahunan AND d.id_bulan=$id_bulan")->row_array();
      return $q['sudah_dibayar'];
   }

   function siswa_smt($id_siswa)
   {
      $ci = & get_instance();
      return $ci->db->select('ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,ks.bsm,kw.id_tahunpelajaran,kw.id_kelas,kw.id_guru,k.tingkat,t.tahunpelajaran,s.smt')->from('tb_kelas_siswa ks')->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')->join('tb_kelas k','kw.id_kelas=k.id_kelas')->join('tb_tahunpelajaran t','kw.id_tahunpelajaran=t.id_tahunpelajaran')->join('tb_semester s','ks.id_semester=s.id_semester')->where('ks.id_siswa',$id_siswa)->get()->result();
   }

   function id_tahunpelajaran_siswa($id_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran')->from('tb_kelas_siswa ks')->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')->where('ks.id_siswa',$id_siswa)->order_by('ks.id_semester','desc')->get()->row_array();
      return $q['id_tahunpelajaran'];
   }

   function id_semester_siswa($id_siswa)
   {
      $ci = & get_instance();
      $q = $ci->db->select('ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran')->from('tb_kelas_siswa ks')->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')->where('ks.id_siswa',$id_siswa)->order_by('ks.id_semester','desc')->get()->row_array();
      return $q['id_semester'];
   }

   function tgl_indo($tgl)
   {
      $tanggal = substr($tgl,8,2);
      $bulan = getBulan(substr($tgl,5,2));
      $tahun = substr($tgl,0,4);
      return $tanggal.' '.$bulan.' '.$tahun;       
   } 

   function tgl_simpan($tgl)
   {  
      $tanggal = substr($tgl,0,2);
      $bulan = substr($tgl,3,2);
      $tahun = substr($tgl,6,4);
      return $tahun.'-'.$bulan.'-'.$tanggal;     
   }

   function tgl_view($tgl)
   {
      $tanggal = substr($tgl,8,2);
      $bulan = substr($tgl,5,2);
      $tahun = substr($tgl,0,4);
      return $tanggal.'-'.$bulan.'-'.$tahun;       
   }

   function tgl_view_excel($tgl)
   {
      $tanggal = substr($tgl,3,2);
      $bulan = substr($tgl,0,2);
      $tahun = substr($tgl,6,4);
      return $tanggal.'-'.$bulan.'-'.$tahun;       
   }

   function getTanggal($tgl)
   {
      switch ($tgl)
      {
         case '01':
            $tanggal = 'Satu';
            break;
         case '02':
            $tanggal = 'Dua';
            break;
         case '03':
            $tanggal = 'Tiga';
            break;
         case '04':
            $tanggal = 'Empat';
            break;
         case '05':
            $tanggal = 'Lima';
            break;
         case '06':
            $tanggal = 'Enam';
            break;
         case '07':
            $tanggal = 'Tujuh';
            break;
         case '08':
            $tanggal = 'Delapan';
            break;
         case '09':
            $tanggal = 'Sembilan';
            break;
         case '10':
            $tanggal = 'Sepuluh';
            break;
         case '11':
            $tanggal = 'Sebelas';
            break;
         case '12':
            $tanggal = 'Dua Belas';
            break;
         case '13':
            $tanggal = 'Tiga Belas';
            break;
         case '14':
            $tanggal = 'Empat Belas';
            break;
         case '15':
            $tanggal = 'Lima Belas';
            break;
         case '16':
            $tanggal = 'Enam Belas';
            break;
         case '17':
            $tanggal = 'Tujuh Belas';
            break;
         case '18':
            $tanggal = 'Delapan Belas';
            break;
         case '19':
            $tanggal = 'Sembilan Belas';
            break;
         case '20':
            $tanggal = 'Dua Puluh';
            break;
         case '21':
            $tanggal = 'Dua Puluh Satu';
            break;
         case '22':
            $tanggal = 'Dua Puluh Dua';
            break;
         case '23':
            $tanggal = 'Dua Puluh Tiga';
            break;
         case '24':
            $tanggal = 'Dua Puluh Empat';
            break;
         case '25':
            $tanggal = 'Dua Puluh Lima';
            break;
         case '26':
            $tanggal = 'Dua Puluh Enam';
            break;
         case '27':
            $tanggal = 'Dua Puluh Tujuh';
            break;
         case '28':
            $tanggal = 'Dua Puluh Delapan';
            break;
         case '29':
            $tanggal = 'Dua Puluh Sembilan';
            break;
         case '30':
            $tanggal = 'Tiga Puluh';
            break;
         case '31':
            $tanggal = 'Tiga Puluh Satu';
            break;
         } 
         return $tanggal;
   }

   function getBulan($bln)
   {
      switch ($bln) 
      {
         case '01':
            $bulan = 'Januari';
            break;
         case '02':
            $bulan = 'Februari';
            break;
         case '03':
            $bulan = 'Maret';
            break;
         case '04':
            $bulan = 'April';
            break;
         case '05':
            $bulan = 'Mei';
            break;
         case '06':
            $bulan = 'Juni';
            break;
         case '07':
            $bulan = 'Juli';
            break;
         case '08':
            $bulan = 'Agustus';
            break;
         case '09':
            $bulan = 'September';
            break;
         case '10':
            $bulan = 'Oktober';
            break;
         case '11':
            $bulan = 'November';
            break;
         case '12':
            $bulan = 'Desember';
            break;
      } 
      return $bulan;
   }
    
   function getTahun($thn)
   {
      switch ($thn) 
      {
         case '2018':
            $tahun = 'Dua Ribu Delapan Belas';
            break;
         case '2019':
            $tahun = 'Dua Ribu Sembilan Belas';
            break;
         case '2020':
            $tahun = 'Dua Ribu Dua Puluh';
            break;
         case '2021':
            $tahun = 'Dua Ribu Dua Puluh Satu';
            break;
         case '2022':
            $tahun = 'Dua Ribu Dua Puluh Dua';
            break;
         case '2023':
            $tahun = 'Dua Ribu Dua Puluh Tiga';
            break;
         case '2024':
            $tahun = 'Dua Ribu Dua Puluh Empat';
            break;
         case '2025':
            $tahun = 'Dua Ribu Dua Puluh Lima';
            break;
      }
      return $tahun;
   }