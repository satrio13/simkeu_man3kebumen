<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Backend extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
	} 

	public function index()
	{	
		/*
		$data = $this->db->select('ks.*,kw.id_kelas,k.tingkat')->from('tb_kelas_siswa ks')->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali')->join('tb_kelas k','kw.id_kelas=k.id_kelas')->order_by('ks.id_kelas_siswa','asc')->get()->result();

		foreach($data as $r)
		{
			if($r->tingkat == 'X')
			{
				$this->db->update('tb_kelas_siswa', ['id_semester' => 1], ['id_kelas_siswa' => $r->id_kelas_siswa]);
			}elseif($r->tingkat == 'XI')
			{
				$this->db->update('tb_kelas_siswa', ['id_semester' => 3], ['id_kelas_siswa' => $r->id_kelas_siswa]);
			}elseif($r->tingkat == 'XII')
			{
				$this->db->update('tb_kelas_siswa', ['id_semester' => 5], ['id_kelas_siswa' => $r->id_kelas_siswa]);
			}
		}
		*/
		$data['title'] = 'Dashboard';
		$this->template->admin('backend/dashboard','backend/home', $data);
	} 
	
}