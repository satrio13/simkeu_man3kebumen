<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting_bsm extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model('setting_bsm_model');
    } 

    function index()
	{	
        if($this->input->post('submit', TRUE)=='Submit')
        {  
            $this->_validation();
            if($this->form_validation->run() == TRUE)
			{
                $id_tahunpelajaran = $this->input->post('id_tahunpelajaran',TRUE);
                $id_kelas = $this->input->post('id_kelas',TRUE);
                $data['data'] = $this->setting_bsm_model->hasil_cari($id_tahunpelajaran,$id_kelas);
            }
        }elseif($this->input->post('submit', TRUE)=='Trans')
        {   
            $this->_validation();
            if($this->form_validation->run() == TRUE)
			{
                $this->setting_bsm_model->update_bsm();  
                $id_tahunpelajaran = $this->input->post('id_tahunpelajaran',TRUE);
                $id_kelas = $this->input->post('id_kelas',TRUE);
                $data['data'] = $this->setting_bsm_model->hasil_cari($id_tahunpelajaran,$id_kelas);  
            }
        }
        $data['title'] = 'Setting BSM';
        $data['submit'] = $this->input->post('submit',TRUE);
        $data['tahun'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get()->result();
        $data['kelas'] = $this->db->select('*')->from('tb_kelas')->order_by('kelas','asc')->get()->result();
        $this->template->admin('backend/dashboard','setting_bsm/setting_bsm',$data);
    }

    private function _validation()
	{
		$this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
        $this->form_validation->set_rules('id_tahunpelajaran', 'Tahun Pelajaran', 'required');
        $this->form_validation->set_rules('id_kelas', 'Kelas', 'required');
    }

}