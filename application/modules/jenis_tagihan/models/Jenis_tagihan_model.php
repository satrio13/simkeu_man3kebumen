<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jenis_tagihan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function tampil_jenis_tagihan()
    {
        return $this->db->select('*')->from('tb_jenistagihan')->order_by('id_jenistagihan','desc')->get()->result();
    }

    function tambah_jenis_tagihan()
    {
        $data = [
            'jenistagihan' => strip_tags($this->input->post('jenistagihan',TRUE))
        ];

        $this->db->insert('tb_jenistagihan',$data);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-jenis-tagihan', 'DATA BERHASIL DITAMBAHKAN');
            redirect('backend/jenis-tagihan');
        }else
        {
            $this->session->set_flashdata('msg-gagal-jenis-tagihan', 'DATA GAGAL DITAMBAHKAN!');
        }
    }

    function cek_jenis_tagihan($id_jenis_tagihan)
    {
        return $this->db->select('id_jenistagihan')->from('tb_jenistagihan')->where('id_jenistagihan',$id_jenis_tagihan)->get()->row();
    }

    function edit_jenis_tagihan($id_jenis_tagihan)
    {
        $data = [
            'jenistagihan' => strip_tags($this->input->post('jenistagihan',TRUE))
        ];

        $this->db->update('tb_jenistagihan',$data,['id_jenistagihan'=>$id_jenis_biaya]);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-jenis-tagihan', 'DATA BERHASIL DIEDIT');
            redirect('backend/jenis-tagihan');
        }else
        {
            $this->session->set_flashdata('msg-gagal-jenis-tagihan', 'DATA GAGAL DIEDIT!');
        }
    }

}