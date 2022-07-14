<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Guru_model extends CI_Model
{
    private $table = 'tb_guru'; //nama tabel dari database
    private $column_order = array(null,'nama','id_guru');
    private $column_search = array('nama');
    private $order = array('id_guru' => 'desc'); // default order 
 
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
 
    function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function tambah_guru()
    {
        $data = [
            'nama' => strip_tags($this->input->post('nama',TRUE))
        ];

        $this->db->insert('tb_guru',$data);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-guru', 'DATA BERHASIL DITAMBAHKAN');
            redirect('backend/guru');
        }else
        {
            $this->session->set_flashdata('msg-gagal-guru', 'DATA GAGAL DITAMBAHKAN!');
        }
    }

    function cek_guru($id_guru)
    {
        return $this->db->select('id_guru')->from('tb_guru')->where('id_guru',$id_guru)->get()->row();
    }

    function edit_guru($id_guru)
    {
        $data = [
            'nama' => strip_tags($this->input->post('nama',TRUE))
        ];

        $this->db->update('tb_guru',$data,['id_guru'=>$id_guru]);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-guru', 'DATA BERHASIL DIEDIT');
            redirect('backend/guru');
        }else
        {
            $this->session->set_flashdata('msg-gagal-guru', 'DATA GAGAL DIEDIT!');
        }
    }

    function hapus_guru($id_guru)
    {   
        $cek = $this->db->select('id_guru')->from('tb_kelas_wali')->where('id_guru',$id_guru)->get()->num_rows();
        if($cek > 0)
        {
            $this->session->set_flashdata('msg-gagal-guru', 'DATA GAGAL DIHAPUS!');
        }else
        {
            $this->db->where('id_guru',$id_guru)->delete('tb_guru');
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-guru', 'DATA BERHASIL DIHAPUS');
            }
            else
            {
                $this->session->set_flashdata('msg-gagal-guru', 'DATA GAGAL DIHAPUS!');
            }
        }
        redirect('backend/guru');            
    }

}