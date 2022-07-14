<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tagihan_tahunan extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model('tagihan_tahunan_model');
    } 

    function index()
	{	
		$data['title'] = 'Tagihan Tahunan';
        $this->template->admin('backend/dashboard','tagihan_tahunan/tagihan_tahunan',$data);
    }

    function cek_tagihan()
    {
        $id_tagihan = $this->input->get('id');
        $id_jenistagihan = id_jenistagihan($id_tagihan);
        if($id_jenistagihan == 5)
        {
            $data = 'persiswa';
        }elseif($id_jenistagihan == 6)
        {
            $data = 'kelulusan';
        }else
        {
            $data = $this->tagihan_tahunan_model->cek_tagihan_semester($id_tagihan);
        }
        echo json_encode($data);
    }

    function get_data_tagihan_tahunan()
	{
		$list = $this->tagihan_tahunan_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{	
            $id_jenistagihan = id_jenistagihan($r->id_tagihan);
            if($id_jenistagihan == 3)
            {
                $tagihan = $r->tagihan.' Semester '.semester($r->id_semester);
            }else
            {
                $tagihan = $r->tagihan;
            }

			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'.</div>';
            $row[] = $r->tahunpelajaran;
            $row[] = $tagihan;
            $row[] = '<div class="text-right">'.number_format($r->perangkatan, 0, ',', '.').'</div>';
            $row[] = '<div class="text-right">'.number_format($r->perangkatan_bsm, 0, ',', '.').'</div>';
            $row[] = '<div class="text-right">'.number_format($r->kelas10, 0, ',', '.').'</div>';
            $row[] = '<div class="text-right">'.number_format($r->kelas10_bsm, 0, ',', '.').'</div>';
            $row[] = '<div class="text-right">'.number_format($r->kelas11, 0, ',', '.').'</div>';
            $row[] = '<div class="text-right">'.number_format($r->kelas11_bsm, 0, ',', '.').'</div>';
            $row[] = '<div class="text-right">'.number_format($r->kelas12, 0, ',', '.').'</div>';
            $row[] = '<div class="text-right">'.number_format($r->kelas12_bsm, 0, ',', '.').'</div>';
            $action = '<div class="text-center">
                        <a href="'.base_url('backend/edit-tagihan-tahunan/'.$r->id_tagihan_tahunan.'').'" 
                        class="btn btn-dark btn-xs btn-flat" title="EDIT DATA">EDIT</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-xs btn-flat text-white" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="'.base_url("backend/hapus-tagihan-tahunan/$r->id_tagihan_tahunan").'" title="HAPUS DATA">HAPUS</a>
                        </div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->tagihan_tahunan_model->count_all(),
			"recordsFiltered" => $this->tagihan_tahunan_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    } 

    function tambah_tagihan_tahunan()
	{ 
		if($this->input->post('submit', TRUE)=='Submit')
        {  
        	$this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
            $this->form_validation->set_rules('id_tahunpelajaran', 'Tahun Pelajaran', 'required');
            $this->form_validation->set_rules('id_tagihan', 'Tagihan', 'required');
            $this->form_validation->set_rules('id_semester', 'Semester', 'required');
            $this->form_validation->set_rules('perangkatan', 'Biaya Perangkatan', 'numeric');
            $this->form_validation->set_rules('perangkatan_bsm', 'Biaya Perangkatan BSM', 'numeric');
            $this->form_validation->set_rules('kelas10', 'Biaya Kelas 10', 'numeric');
            $this->form_validation->set_rules('kelas10_bsm', 'Biaya Kelas 10 BSM', 'numeric');
            $this->form_validation->set_rules('kelas11', 'Biaya Kelas 11', 'numeric');
            $this->form_validation->set_rules('kelas11_bsm', 'Biaya Kelas 11 BSM', 'numeric');
            $this->form_validation->set_rules('kelas12', 'Biaya Kelas 12', 'numeric');
            $this->form_validation->set_rules('kelas12_bsm', 'Biaya Kelas 12 BSM', 'numeric');
            if($this->form_validation->run() == TRUE)
            { 
                $id_tagihan = $this->input->post('id_tagihan',TRUE);
                $id_jenistagihan = id_jenistagihan($id_tagihan);
                $data['id_jenistagihan'] = $id_jenistagihan;
				$this->tagihan_tahunan_model->tambah_tagihan_tahunan();
			}
		}
        $data['title'] = 'Tambah Tagihan Tahunan';
        $data['submit'] = $this->input->post('submit',TRUE);
        $data['tahunpelajaran'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get()->result();
        $data['tagihan'] = $this->db->select('*')->from('tb_tagihan')->order_by('tagihan','asc')->get()->result();
        $data['semester'] = $this->db->select('*')->from('tb_semester')->order_by('semester','asc')->get()->result();
		$this->template->admin('backend/dashboard','tagihan_tahunan/form_tambah_tagihan_tahunan', $data);
    }

    function edit_tagihan_tahunan($id_tagihan_tahunan)
	{ 
        $cek = $this->tagihan_tahunan_model->cek_tagihan_tahunan($id_tagihan_tahunan); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
            if($this->input->post('submit', TRUE)=='Submit')
            {  
                $this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
                $this->form_validation->set_rules('id_tahunpelajaran', 'Tahun Pelajaran', 'required');
                $this->form_validation->set_rules('id_tagihan', 'Tagihan', 'required');
                $this->form_validation->set_rules('id_semester', 'Semester', 'required');
                $this->form_validation->set_rules('perangkatan', 'Biaya Perangkatan', 'numeric');
                $this->form_validation->set_rules('perangkatan_bsm', 'Biaya Perangkatan BSM', 'numeric');
                $this->form_validation->set_rules('kelas10', 'Biaya Kelas 10', 'numeric');
                $this->form_validation->set_rules('kelas10_bsm', 'Biaya Kelas 10 BSM', 'numeric');
                $this->form_validation->set_rules('kelas11', 'Biaya Kelas 11', 'numeric');
                $this->form_validation->set_rules('kelas11_bsm', 'Biaya Kelas 11 BSM', 'numeric');
                $this->form_validation->set_rules('kelas12', 'Biaya Kelas 12', 'numeric');
                $this->form_validation->set_rules('kelas12_bsm', 'Biaya Kelas 12 BSM', 'numeric');
                if($this->form_validation->run() == TRUE)
                { 
                    $id_tagihan = $this->input->post('id_tagihan',TRUE);
                    $id_jenistagihan = id_jenistagihan($id_tagihan);
                    $data['id_jenistagihan'] = $id_jenistagihan;
                    $this->tagihan_tahunan_model->edit_tagihan_tahunan($id_tagihan_tahunan);
                }
            }
            $data['title'] = 'Edit Tagihan Tahunan';
            $data['submit'] = $this->input->post('submit',TRUE);
            $data['data'] = $this->db->get_where('tb_tagihan_tahunan',['id_tagihan_tahunan'=>$id_tagihan_tahunan])->row();
            $data['tahunpelajaran'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get()->result();
            $data['tagihan'] = $this->db->select('*')->from('tb_tagihan')->order_by('tagihan','asc')->get()->result();
            $data['semester'] = $this->db->select('*')->from('tb_semester')->order_by('semester','asc')->get()->result();
            $this->template->admin('backend/dashboard','tagihan_tahunan/form_edit_tagihan_tahunan', $data);
        }
    }

    function hapus_tagihan_tahunan($id_tagihan_tahunan)
	{ 	
		$cek = $this->tagihan_tahunan_model->cek_tagihan_tahunan($id_tagihan_tahunan); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$this->tagihan_tahunan_model->hapus_tagihan_tahunan($id_tagihan_tahunan);
		}
	}

}