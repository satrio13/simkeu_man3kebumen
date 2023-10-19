<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Import_siswa_model extends CI_Model 
{
	public function view()
	{
		return $this->db->get('tb_siswa')->result(); 
	}
	
	public function upload_file($filename)
	{
		$this->load->library('upload'); 
		
		$config['upload_path'] = './excel/siswa/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '5048';
		$config['overwrite'] = true;
		$config['file_name'] = $filename;
	
		$this->upload->initialize($config);
		if($this->upload->do_upload('file'))
		{
			return array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
		}else
		{
			return array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
		}
	}
	
	public function insert_multiple($data)
	{
		$this->db->insert_batch('tb_siswa', $data);
	}
	
}