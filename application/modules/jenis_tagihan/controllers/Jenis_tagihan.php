<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jenis_tagihan extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model('jenis_tagihan_model');
    } 

    function index()
	{	
		$data['title'] = 'Jenis Tagihan';
		$data['data'] = $this->jenis_tagihan_model->tampil_jenis_tagihan();
        $this->template->admin('backend/dashboard','jenis_tagihan/jenis_tagihan', $data);
	}
	
	function tambah_jenis_tagihan()
	{ 	
		$this->session->set_flashdata('msg-gagal-jenis-tagihan', 'FITUR SEMENTARA DITUTUP');
		redirect('backend/jenis-tagihan');
		/*
		if($this->input->post('submit', TRUE)=='Submit')
		{ 
			$this->_validation();
			if($this->form_validation->run() == TRUE)
			{ 
				$this->jenis_biaya_model->tambah_jenis_biaya();
			}
		}
		$data['title'] = 'Tambah Jenis Biaya';
		$this->template->admin('backend/dashboard','jenis_biaya/form_tambah_jenis_biaya', $data);
		*/
	}

	function edit_jenis_tagihan($id_jenis_tagihan)
	{ 	
		$this->session->set_flashdata('msg-gagal-jenis-tagihan', 'FITUR SEMENTARA DITUTUP');
		redirect('backend/jenis-tagihan');
		/*
		$cek = $this->jenis_biaya_model->cek_jenis_biaya($id_jenis_biaya); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			if($this->input->post('submit', TRUE)=='Submit')
        	{ 
				$this->_validation();
				if($this->form_validation->run() == TRUE)
				{
					$this->jenis_biaya_model->edit_jenis_biaya($id_jenis_biaya);
				}
			}
			$data['title'] = 'Edit Jenis Biaya';
			$data['data'] = $this->db->get_where('tb_jenisbiaya',['id_jenisbiaya'=>$id_jenis_biaya])->row();
			$this->template->admin('backend/dashboard','jenis_biaya/form_edit_jenis_biaya', $data);
		}
		*/
	}

	function hapus_jenis_tagihan()
	{
		$this->session->set_flashdata('msg-gagal-jenis-tagihan', 'FITUR SEMENTARA DITUTUP');
		redirect('backend/jenis-tagihan');
		/*
		$id = $this->uri->segment('3');
		$cek = $this->app->cekJenisBiaya($id); if(!$cek){ show_404(); }
		$jml_pem = $this->app->selectWhere('id_jenisbiaya','tb_pembiayaan', ['id_jenisbiaya'=>$id])->num_rows();
		$paten = ['1','2','3'];
		if(in_array($id,$paten)){
			$this->session->set_flashdata('msg-gagal-jenisbiaya', 'KHUSUS 3 DATA JENIS BIAYA PERTAMA TIDAK BISA DIEDIT DAN DIHAPUS!!');
		}elseif($jml_pem > 0){
			$this->session->set_flashdata('msg-gagal-jenisbiaya', 'JENIS BIAYA GAGAL DIHAPUS!');
		}else{
			$this->app->deleteData('tb_jenisbiaya', array('id_jenisbiaya'=>$id));
			if($this->db->affected_rows() > 0){
				$this->session->set_flashdata('msg-jenisbiaya', 'JENIS BIAYA BERHASIL DIHAPUS');
			}else{
				$this->session->set_flashdata('msg-gagal-jenisbiaya', 'JENIS BIAYA GAGAL DIHAPUS!');
			}
		}
		redirect('backend/jenis-biaya');
		*/
    }

	private function _validation()
	{
		$this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
		$this->form_validation->set_rules('jenistagihan', 'Jenis Tagihan', 'required');
	}
        
}