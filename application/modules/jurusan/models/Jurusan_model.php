<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jurusan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function tampil_jurusan()
    {
        return $this->db->select('*')->from('tb_jurusan')->order_by('id_jurusan','desc')->get()->result();
    }

    function tambah_jurusan()
    {
        $data = [
            'jurusan' => strip_tags($this->input->post('jurusan',TRUE))
        ];

        $this->db->insert('tb_jurusan',$data);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-jurusan', 'DATA BERHASIL DITAMBAHKAN');
            redirect('backend/jurusan');
        }else
        {
            $this->session->set_flashdata('msg-gagal-jurusan', 'DATA GAGAL DITAMBAHKAN!');
        }
    }

    function cek_jurusan($id_jurusan)
    {
        return $this->db->select('id_jurusan')->from('tb_jurusan')->where('id_jurusan',$id_jurusan)->get()->row();
    }

    function edit_jurusan($id_jurusan)
    {
        $data = [
            'jurusan' => strip_tags($this->input->post('jurusan',TRUE))
        ];

        $this->db->update('tb_jurusan',$data,['id_jurusan'=>$id_jurusan]);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-jurusan', 'DATA BERHASIL DIEDIT');
            redirect('backend/jurusan');
        }else
        {
            $this->session->set_flashdata('msg-gagal-jurusan', 'DATA GAGAL DIEDIT!');
        }
    }

    function hapus_jurusan($id_jurusan)
    {   
        $cek = $this->db->select('id_jurusan')->from('tb_kelas')->where('id_jurusan',$id_jurusan)->get()->num_rows();
        if($cek > 0)
        {
            $this->session->set_flashdata('msg-gagal-jurusan', 'DATA GAGAL DIHAPUS!');
        }else
        {
            $this->db->where('id_jurusan',$id_jurusan)->delete('tb_jurusan');
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-jurusan', 'DATA BERHASIL DIHAPUS');
            }
            else
            {
                $this->session->set_flashdata('msg-gagal-jurusan', 'DATA GAGAL DIHAPUS!');
            }
        }
        redirect('backend/jurusan');            
    }

}