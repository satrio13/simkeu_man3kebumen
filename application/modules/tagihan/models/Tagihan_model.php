<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tagihan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function tampil_tagihan()
    {
        return $this->db->select('t.*,j.*')->from('tb_tagihan t')->join('tb_jenistagihan j','t.id_jenistagihan=j.id_jenistagihan','left')->order_by('t.id_tagihan','desc')->get()->result();
    }

    function tambah_tagihan()
    {
        $data = [
            'tagihan' => strip_tags($this->input->post('tagihan',TRUE)),
            'id_jenistagihan' => strip_tags($this->input->post('id_jenistagihan',TRUE))
        ];

        $this->db->insert('tb_tagihan',$data);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-tagihan', 'DATA BERHASIL DITAMBAHKAN');
            redirect('backend/tagihan');
        }else
        {
            $this->session->set_flashdata('msg-gagal-tagihan', 'DATA GAGAL DITAMBAHKAN!');
        }
    }

    function cek_tagihan($id_tagihan)
    {
        return $this->db->select('id_tagihan')->from('tb_tagihan')->where('id_tagihan',$id_tagihan)->get()->row();
    }

    function edit_tagihan($id_tagihan)
    {
        $data = [
            'tagihan' => strip_tags($this->input->post('tagihan',TRUE)),
            'id_jenistagihan' => strip_tags($this->input->post('id_jenistagihan',TRUE))
        ];

        $this->db->update('tb_tagihan',$data,['id_tagihan'=>$id_tagihan]);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-tagihan', 'DATA BERHASIL DIEDIT');
            redirect('backend/tagihan');
        }else
        {
            $this->session->set_flashdata('msg-gagal-tagihan', 'DATA GAGAL DIEDIT!');
        }
    }

    function hapus_tagihan($id_tagihan)
    {   
        $cek = $this->db->select('id_tagihan')->from('tb_tagihan_tahunan')->where('id_tagihan',$id_tagihan)->get()->num_rows();
        if($cek > 0)
        {
            $this->session->set_flashdata('msg-gagal-tagihan', 'DATA GAGAL DIHAPUS!');
        }else
        {
            $this->db->where('id_tagihan',$id_tagihan)->delete('tb_tagihan');
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-tagihan', 'DATA BERHASIL DIHAPUS');
            }
            else
            {
                $this->session->set_flashdata('msg-gagal-tagihan', 'DATA GAGAL DIHAPUS!');
            }
        }
        redirect('backend/tagihan');            
    }

}