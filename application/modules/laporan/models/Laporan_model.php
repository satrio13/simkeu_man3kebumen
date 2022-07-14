<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporan_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function cek_siswa($id_siswa)
    {
        return $this->db->select('id_siswa')->from('tb_siswa')->where('id_siswa',$id_siswa)->get()->row();
    }

    function cek_kekurangan($id_tahunpelajaran,$id_kelas,$id_tagihan)
    {
        return $this->db->select('ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,
                kw.id_tahunpelajaran,kw.id_kelas,k.id_jurusan,k.kelas,s.nis,s.nama')
                ->from('tb_kelas_siswa ks')
                ->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')
                ->join('tb_kelas k','kw.id_kelas=k.id_kelas')
                ->join('tb_siswa s','ks.id_siswa=s.id_siswa')
                ->where('kw.id_tahunpelajaran',$id_tahunpelajaran)
                ->where('kw.id_kelas',$id_kelas)
                ->group_by('s.nis')
                ->order_by('s.nis','asc')
                ->get()->row();
    }

    function cek_semua_kekurangan($id_tahunpelajaran,$id_kelas)
    {
        return $this->db->select('ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,
                kw.id_tahunpelajaran,kw.id_kelas,k.id_jurusan,k.kelas,s.nis,s.nama')
                ->from('tb_kelas_siswa ks')
                ->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')
                ->join('tb_kelas k','kw.id_kelas=k.id_kelas')
                ->join('tb_siswa s','ks.id_siswa=s.id_siswa')
                ->where('kw.id_tahunpelajaran',$id_tahunpelajaran)
                ->where('kw.id_kelas',$id_kelas)
                ->group_by('s.nis')
                ->order_by('s.nis','asc')
                ->get()->row();
    }

    function pemb_sekaliselamanya($id_tahunpelajaran, $id_kelas)
    {
        $tingkat = tingkat_kelas($id_kelas);
        if($tingkat == 'X')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 1 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas10 != 0 OR d.kelas10_bsm != 0)")->result();
        }elseif($tingkat == 'XI')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 1 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas11 != 0 OR d.kelas11_bsm != 0)")->result();
        }elseif($tingkat == 'XII')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 1 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas12 != 0 OR d.kelas12_bsm != 0)")->result();
        }
    }

    function pemb_tiaptahun($id_tahunpelajaran, $id_kelas)
    {
        $tingkat = tingkat_kelas($id_kelas);
        if($tingkat == 'X')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 2 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas10 != 0 OR d.kelas10_bsm != 0)")->result();
        }elseif($tingkat == 'XI')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 2 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas11 != 0 OR d.kelas11_bsm != 0)")->result();
        }elseif($tingkat == 'XII')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 2 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas12 != 0 OR d.kelas12_bsm != 0)")->result();
        }
    }

    function pemb_semester($id_tahunpelajaran, $id_kelas)
    {
        $tingkat = tingkat_kelas($id_kelas);
        if($tingkat == 'X')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 3 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas10 != 0 OR d.kelas10_bsm != 0)")->result();
        }elseif($tingkat == 'XI')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 3 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas11 != 0 OR d.kelas11_bsm != 0)")->result();
        }elseif($tingkat == 'XII')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 3 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas12 != 0 OR d.kelas12_bsm != 0)")->result();
        }
    }

    
    function pemb_bulanan($id_tahunpelajaran, $id_kelas)
    {
        $tingkat = tingkat_kelas($id_kelas);
        if($tingkat == 'X')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 4 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas10 != 0 OR d.kelas10_bsm != 0)")->result();
        }elseif($tingkat == 'XI')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 4 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas11 != 0 OR d.kelas11_bsm != 0)")->result();
        }elseif($tingkat == 'XII')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 4 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas12 != 0 OR d.kelas12_bsm != 0)")->result();
        }
    }

    function pemb_kelulusan($id_tahunpelajaran, $id_kelas)
    {
        $tingkat = tingkat_kelas($id_kelas);
        if($tingkat == 'X')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 6 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas10 != 0 OR d.kelas10_bsm != 0)")->result();
        }elseif($tingkat == 'XI')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 6 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas11 != 0 OR d.kelas11_bsm != 0)")->result();
        }elseif($tingkat == 'XII')
        {
            return $this->db->query("SELECT d.*,t.* FROM tb_tagihan_tahunan d JOIN tb_tagihan t ON d.id_tagihan=t.id_tagihan WHERE d.id_tahunpelajaran = $id_tahunpelajaran AND t.id_jenistagihan = 6 AND (d.perangkatan != 0 OR d.perangkatan_bsm != 0 OR d.kelas12 != 0 OR d.kelas12_bsm != 0)")->result();
        }
    }

}