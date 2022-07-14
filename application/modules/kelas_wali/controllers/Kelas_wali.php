<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kelas_wali extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model('kelas_wali_model');
    } 

    function index()
	{	
		$data['title'] = 'Wali Kelas';
        $this->template->admin('backend/dashboard','kelas_wali/kelas_wali',$data);
    }

    function get_data_kelas_wali()
	{
		$list = $this->kelas_wali_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{	
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'.</div>';
            $row[] = $r->nama;
            $row[] = '<div class="text-center">'.$r->tahunpelajaran.'</div>';
            $row[] = '<div class="text-center">'.$r->kelas.'</div>';
            $action = '<div class="text-center">
                        <a href="'.base_url("backend/edit-kelas-wali/$r->id_kelas_wali").'" 
                        class="btn btn-dark btn-xs btn-flat" title="EDIT DATA">EDIT</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-xs btn-flat text-white" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="'.base_url("backend/hapus-kelas-wali/$r->id_kelas_wali").'" title="HAPUS DATA">HAPUS</a>
                        </div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->kelas_wali_model->count_all(),
			"recordsFiltered" => $this->kelas_wali_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    } 

    function tambah_kelas_wali()
	{ 
		if($this->input->post('submit', TRUE)=='Submit')
        {  
        	$this->_validation();
            if($this->form_validation->run() == TRUE)
            { 
                $id_tahunpelajaran = strip_tags($this->input->post('id_tahunpelajaran', TRUE));
                $id_kelas = strip_tags($this->input->post('id_kelas', TRUE));
                $id_guru = strip_tags($this->input->post('id_guru', TRUE));
                $cek = $this->db->select('*')->from('tb_kelas_wali')->where('id_tahunpelajaran',$id_tahunpelajaran)->where('id_kelas',$id_kelas)->where('id_guru',$id_guru)->get()->num_rows();
                if($cek > 0)
                {
                    $this->session->set_flashdata('msg-gagal-kelas-wali', 'DATA GAGAL DITAMBAHKAN KARENA SUDAH ADA!');
                }else
                {
                    $this->kelas_wali_model->tambah_kelas_wali();
                }
			}
		}
        $data['title'] = 'Tambah Kelas Wali';
        $data['tahunpelajaran'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get()->result();
		$data['kelas'] = $this->db->select('*')->from('tb_kelas')->order_by('kelas','asc')->get()->result();
		$data['guru'] = $this->db->select('*')->from('tb_guru')->order_by('nama','asc')->get()->result();
		$this->template->admin('backend/dashboard','kelas_wali/form_tambah_kelas_wali', $data);
    }

    function edit_kelas_wali($id_kelas_wali)
	{ 	
		$cek = $this->kelas_wali_model->cek_kelas_wali($id_kelas_wali); 
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
                    $id_tahunpelajaran = strip_tags($this->input->post('id_tahunpelajaran', TRUE));
                    $id_kelas = strip_tags($this->input->post('id_kelas', TRUE));
                    $id_guru = strip_tags($this->input->post('id_guru', TRUE));
                    $cek = $this->db->select('*')->from('tb_kelas_wali')->where('id_tahunpelajaran',$id_tahunpelajaran)->where('id_kelas',$id_kelas)->where('id_guru',$id_guru)->where('id_kelas_wali != ',$id_kelas_wali)->get()->num_rows();
                    if($cek > 0)
                    {
                        $this->session->set_flashdata('msg-gagal-kelas-wali', 'DATA GAGAL DIEDIT KARENA SUDAH ADA!');
                    }else
                    {
                        $this->kelas_wali_model->edit_kelas_wali($id_kelas_wali);
                    }
				}
			}
			$data['title'] = 'Edit Wali Kelas';
            $data['data'] = $this->db->get_where('tb_kelas_wali',['id_kelas_wali'=>$id_kelas_wali])->row();
            $data['tahunpelajaran'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get()->result();
            $data['kelas'] = $this->db->select('*')->from('tb_kelas')->order_by('kelas','asc')->get()->result();
            $data['guru'] = $this->db->select('*')->from('tb_guru')->order_by('nama','asc')->get()->result();
        	$this->template->admin('backend/dashboard','kelas_wali/form_edit_kelas_wali', $data);
		}
    }

    function hapus_kelas_wali($id_kelas_wali)
	{ 	
		$cek = $this->kelas_wali_model->cek_kelas_wali($id_kelas_wali); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$this->kelas_wali_model->hapus_kelas_wali($id_kelas_wali);
		}
    }
    
    private function _validation()
	{
		$this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
        $this->form_validation->set_rules('id_tahunpelajaran', 'Tahun Pelajaran', 'required');
        $this->form_validation->set_rules('id_kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('id_guru', 'Guru', 'required');
    }

}