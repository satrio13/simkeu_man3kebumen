<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tagihan extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model('tagihan_model');
    } 

    function index()
	{	
		$data['title'] = 'Tagihan';
		$data['data'] = $this->tagihan_model->tampil_tagihan();
        $this->template->admin('backend/dashboard','tagihan/tagihan', $data);
	}

	function tambah_tagihan()
	{ 
		if($this->input->post('submit', TRUE)=='Submit')
        {  
        	$this->_validation();
            if($this->form_validation->run() == TRUE)
            { 
				$this->tagihan_model->tambah_tagihan();
			}
		}
		$data['title'] = 'Tambah Tagihan';
		$data['jenistagihan'] = $this->db->select('*')->from('tb_jenistagihan')->order_by('id_jenistagihan','asc')->get()->result();
		$this->template->admin('backend/dashboard','tagihan/form_tambah_tagihan', $data);
	}

	function edit_tagihan($id_tagihan)
	{ 	
		$cek = $this->tagihan_model->cek_tagihan($id_tagihan); 
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
					$this->tagihan_model->edit_tagihan($id_tagihan);
				}
			}
			$data['title'] = 'Edit Tagihan';
			$data['data'] = $this->db->get_where('tb_tagihan',['id_tagihan'=>$id_tagihan])->row();
			$data['jenistagihan'] = $this->db->select('*')->from('tb_jenistagihan')->order_by('id_jenistagihan','asc')->get()->result();
			$this->template->admin('backend/dashboard','tagihan/form_edit_tagihan', $data);
		}
	}

	function hapus_tagihan($id_tagihan)
	{ 	
		$cek = $this->tagihan_model->cek_tagihan($id_tagihan); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$this->tagihan_model->hapus_tagihan($id_tagihan);
		}
	}

	private function _validation()
	{
		$this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
		$this->form_validation->set_rules('tagihan', 'Tagihan', 'required|max_length[30]');
		$this->form_validation->set_rules('id_jenistagihan', 'Jenis Tagihan', 'required');
	}
    
}