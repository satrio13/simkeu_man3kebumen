<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tahun extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model('tahun_model');
    } 

    function index()
	{	
		$data['title'] = 'Tahun';
		$data['data'] = $this->tahun_model->tampil_tahun();
        $this->template->admin('backend/dashboard','tahun/tahun', $data);
	}
	
	function tambah_tahun()
	{ 
		if($this->input->post('submit', TRUE)=='Submit')
        {  
        	$this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
        	$this->form_validation->set_rules('tahunpelajaran', 'Tahun Pelajaran', 'required|max_length[10]');
            if($this->form_validation->run() == TRUE)
            { 
				$this->tahun_model->tambah_tahun();
			}
		}
		$data['title'] = 'Tambah Tahun Pelajaran';
		$this->template->admin('backend/dashboard','tahun/form_tambah_tahun', $data);
	}

	function cek_tahun($tahunpelajaran = '', $id_tahunpelajaran = '')
    {
	    $cek = $this->db->select('id_tahunpelajaran,tahunpelajaran')->from('tb_tahunpelajaran')->where('tahunpelajaran',$tahunpelajaran)->where('id_tahunpelajaran != ',$id_tahunpelajaran)->get()->num_rows();
        if($cek > 0)
        {
			$this->form_validation->set_message('cek_tahun', 'Tahun Pelajaran sudah ada');
			return FALSE;
        }else
        {
			return TRUE;
		}
	}

	function edit_tahun($id_tahunpelajaran)
	{ 	
		$cek = $this->tahun_model->cek_tahun($id_tahunpelajaran); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			if($this->input->post('submit', TRUE)=='Submit')
        	{ 
				$this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
       			$this->form_validation->set_rules('tahunpelajaran', 'Tahun Pelajaran', 'required|max_length[10]|callback_cek_tahun['.$id_tahunpelajaran.']');
				if($this->form_validation->run() == TRUE)
				{
					$this->tahun_model->edit_tahun($id_tahunpelajaran);
				}
			}
			$data['title'] = 'Edit Tahun Pelajaran';
			$data['data'] = $this->db->get_where('tb_tahunpelajaran',['id_tahunpelajaran'=>$id_tahunpelajaran])->row();
			$this->template->admin('backend/dashboard','tahun/form_edit_tahun', $data);
		}
	}

	function hapus_tahun($id_tahunpelajaran)
	{ 	
		$cek = $this->tahun_model->cek_tahun($id_tahunpelajaran); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$this->tahun_model->hapus_tahun($id_tahunpelajaran);
		}
	}

}