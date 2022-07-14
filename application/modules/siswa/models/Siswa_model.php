<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Siswa_model extends CI_Model {
 
    private $table = 'tb_siswa'; //nama tabel dari database
    private $column_order = array(null,'nis','nama','id_siswa');
    private $column_search = array('nis','nama');
    private $order = array('id_siswa' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        $this->db->from($this->table);
        $i = 0;	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // cek kalo ada search data
			{				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open group like or like
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close group like or like
			}
			$i++;
		}		
		if(isset($_POST['order'])) // cek kalo click order
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
        
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function tambah_siswa()
    {
        $data = [
            'nama' => strip_tags($this->input->post('nama',TRUE)),
            'nis' => strip_tags($this->input->post('nis',TRUE))
        ];

        $this->db->insert('tb_siswa',$data);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-siswa', 'DATA BERHASIL DITAMBAHKAN');
            redirect('backend/siswa');
        }else
        {
            $this->session->set_flashdata('msg-gagal-siswa', 'DATA GAGAL DITAMBAHKAN!');
        }
    }

    function cek_siswa($id_siswa)
    {
        return $this->db->select('id_siswa')->from('tb_siswa')->where('id_siswa',$id_siswa)->get()->row();
    }

    function cek_nis($nis)
    {
        return $this->db->select('nis')->from('tb_siswa')->where('nis',$nis)->get()->row();
    }

    function edit_siswa($id_siswa)
    {
        $data = [
            'nama' => strip_tags($this->input->post('nama',TRUE)),
            'nis' => strip_tags($this->input->post('nis',TRUE))
        ];

        $this->db->update('tb_siswa',$data,['id_siswa'=>$id_siswa]);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-siswa', 'DATA BERHASIL DIEDIT');
            redirect('backend/siswa');
        }else
        {
            $this->session->set_flashdata('msg-gagal-siswa', 'DATA GAGAL DIEDIT!');
        }
    }

    function hapus_siswa($id_siswa)
    {   
        $cek = $this->db->select('id_siswa')->from('tb_kelas_siswa')->where('id_siswa',$id_siswa)->get()->num_rows();
        if($cek > 0)
        {
            $this->session->set_flashdata('msg-gagal-siswa', 'DATA GAGAL DIHAPUS!');
        }else
        {
            $this->db->where('id_siswa',$id_siswa)->delete('tb_siswa');
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-siswa', 'DATA BERHASIL DIHAPUS');
            }
            else
            {
                $this->session->set_flashdata('msg-gagal-siswa', 'DATA GAGAL DIHAPUS!');
            }
        }
        redirect('backend/siswa');            
    }
 
}