<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jurusan extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model('jurusan_model');
    } 

	function index()
	{	
		$data['title'] = 'Jurusan';
		$data['data'] = $this->jurusan_model->tampil_jurusan();
        $this->template->admin('backend/dashboard','jurusan/jurusan', $data);
    }

    function tambah_jurusan()
	{ 
		if($this->input->post('submit', TRUE)=='Submit')
        {  
        	$this->_validation();
            if($this->form_validation->run() == TRUE)
            { 
				$this->jurusan_model->tambah_jurusan();
			}
		}
		$data['title'] = 'Tambah Jurusan';
		$this->template->admin('backend/dashboard','jurusan/form_tambah_jurusan', $data);
    }
    
    function edit_jurusan($id_jurusan)
	{ 	
		$cek = $this->jurusan_model->cek_jurusan($id_jurusan); 
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
					$this->jurusan_model->edit_jurusan($id_jurusan);
				}
			}
			$data['title'] = 'Edit Jurusan';
			$data['data'] = $this->db->get_where('tb_jurusan',['id_jurusan'=>$id_jurusan])->row();
			$this->template->admin('backend/dashboard','jurusan/form_edit_jurusan', $data);
		}
	}

	function hapus_jurusan($id_jurusan)
	{ 	
		$cek = $this->jurusan_model->cek_jurusan($id_jurusan); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$this->jurusan_model->hapus_jurusan($id_jurusan);
		}
	}

	private function _validation()
	{
		$this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
		$this->form_validation->set_rules('jurusan', 'Jurusan', 'required|max_length[50]');
    }
    
}