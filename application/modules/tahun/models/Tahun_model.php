<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tahun_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function tampil_tahun()
    {
        return $this->db->select('*')->from('tb_tahunpelajaran')->order_by('id_tahunpelajaran','desc')->get()->result();
    }

    function tambah_tahun()
    {
        $data = [
            'tahunpelajaran' => strip_tags($this->input->post('tahunpelajaran',TRUE))
        ];

        $this->db->insert('tb_tahunpelajaran',$data);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-tahun', 'DATA BERHASIL DITAMBAHKAN');
            redirect('backend/tahun');
        }else
        {
            $this->session->set_flashdata('msg-gagal-tahun', 'DATA GAGAL DITAMBAHKAN!');
        }
    }

    function cek_tahun($id_tahunpelajaran)
    {
        return $this->db->select('id_tahunpelajaran')->from('tb_tahunpelajaran')->where('id_tahunpelajaran',$id_tahunpelajaran)->get()->row();
    }

    function edit_tahun($id_tahunpelajaran)
    {
        $data = [
            'tahunpelajaran' => strip_tags($this->input->post('tahunpelajaran',TRUE))
        ];

        $this->db->update('tb_tahunpelajaran',$data,['id_tahunpelajaran'=>$id_tahunpelajaran]);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-tahun', 'DATA BERHASIL DIEDIT');
            redirect('backend/tahun');
        }else
        {
            $this->session->set_flashdata('msg-gagal-tahun', 'DATA GAGAL DIEDIT!');
        }
    }

    function hapus_tahun($id_tahunpelajaran)
    {   
        $cek_1 = $this->db->select('id_tahunpelajaran')->from('tb_kelas_wali')->where('id_tahunpelajaran',$id_tahunpelajaran)->get()->num_rows();
        $cek_2 = $this->db->select('id_tahunpelajaran')->from('tb_tagihan_tahunan')->where('id_tahunpelajaran',$id_tahunpelajaran)->get()->num_rows();
        if( ($cek_1 > 0) OR ($cek_2 > 0) )
        {
            $this->session->set_flashdata('msg-gagal-tahun', 'DATA GAGAL DIHAPUS!');
        }else
        {
            $this->db->where('id_tahunpelajaran',$id_tahunpelajaran)->delete('tb_tahunpelajaran');
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-tahun', 'DATA BERHASIL DIHAPUS');
            }
            else
            {
                $this->session->set_flashdata('msg-gagal-tahun', 'DATA GAGAL DIHAPUS!');
            }
        }
        redirect('backend/tahun');
    }

}