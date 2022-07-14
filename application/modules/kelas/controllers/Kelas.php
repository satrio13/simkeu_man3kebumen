<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kelas extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model('kelas_model');
    } 

    function index()
	{	
		$data['title'] = 'Kelas';
        $this->template->admin('backend/dashboard','kelas/kelas',$data);
    }

    function get_data_kelas()
	{
		$list = $this->kelas_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{	
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'.</div>';
			$row[] = $r->kelas;
            $row[] = '<div class="text-center">'.$r->tingkat.'.</div>';
            $row[] = $r->jurusan;
            $action = '<div class="text-center">
                        <a href="'.base_url("backend/edit-kelas/$r->id_kelas").'" 
                        class="btn btn-dark btn-xs btn-flat" title="EDIT DATA">EDIT</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-xs btn-flat text-white" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="'.base_url("backend/hapus-kelas/$r->id_kelas").'" title="HAPUS DATA">HAPUS</a>
                        </div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->kelas_model->count_all(),
			"recordsFiltered" => $this->kelas_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    } 

    function tambah_kelas()
	{ 
		if($this->input->post('submit', TRUE)=='Submit')
        {  
        	$this->_validation();
            if($this->form_validation->run() == TRUE)
            { 
				$this->kelas_model->tambah_kelas();
			}
		}
        $data['title'] = 'Tambah Kelas';
        $data['jurusan'] = $this->db->select('*')->from('tb_jurusan')->order_by('jurusan','asc')->get()->result();
		$this->template->admin('backend/dashboard','kelas/form_tambah_kelas', $data);
    }

    function edit_kelas($id_kelas)
	{ 	
		$cek = $this->kelas_model->cek_kelas($id_kelas); 
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
					$this->kelas_model->edit_kelas($id_kelas);
				}
			}
			$data['title'] = 'Edit Kelas';
            $data['data'] = $this->db->get_where('tb_kelas',['id_kelas'=>$id_kelas])->row();
            $data['jurusan'] = $this->db->select('*')->from('tb_jurusan')->order_by('jurusan','asc')->get()->result();
			$this->template->admin('backend/dashboard','kelas/form_edit_kelas', $data);
		}
    }

    function hapus_kelas($id_kelas)
	{ 	
		$cek = $this->kelas_model->cek_kelas($id_kelas); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$this->kelas_model->hapus_kelas($id_kelas);
		}
	}
    
    private function _validation()
	{
		$this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('tingkat', 'Tingkat', 'required');
        $this->form_validation->set_rules('id_jurusan', 'Jurusan', 'required');
    }

}