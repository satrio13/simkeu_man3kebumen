<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kelas_model extends CI_Model
{
    private $table = 'tb_kelas k'; //nama tabel dari database
    private $column_order = array(null,'k.kelas','k.tingkat','j.jurusan','k.id_kelas');
    private $column_search = array('k.kelas','k.tingkat','j.jurusan');
    private $order = array('k.id_kelas' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {   
        $this->db->select('k.*,j.*');
        $this->db->from($this->table);
        $this->db->join('tb_jurusan j','k.id_jurusan=j.id_jurusan','left');
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

    function tambah_kelas()
    {
        $data = [
            'kelas' => strip_tags($this->input->post('kelas',TRUE)),
            'tingkat' => strip_tags($this->input->post('tingkat',TRUE)),
            'id_jurusan' => strip_tags($this->input->post('id_jurusan',TRUE))
        ];

        $this->db->insert('tb_kelas',$data);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-kelas', 'DATA BERHASIL DITAMBAHKAN');
            redirect('backend/kelas');
        }else
        {
            $this->session->set_flashdata('msg-gagal-kelas', 'DATA GAGAL DITAMBAHKAN!');
        }
    }

    function cek_kelas($id_kelas)
    {
        return $this->db->select('id_kelas')->from('tb_kelas')->where('id_kelas',$id_kelas)->get()->row();
    }
    
    function edit_kelas($id_kelas)
    {
        $data = [
            'kelas' => strip_tags($this->input->post('kelas',TRUE)),
            'tingkat' => strip_tags($this->input->post('tingkat',TRUE)),
            'id_jurusan' => strip_tags($this->input->post('id_jurusan',TRUE))
        ];

        $this->db->update('tb_kelas',$data,['id_kelas'=>$id_kelas]);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-kelas', 'DATA BERHASIL DIEDIT');
            redirect('backend/kelas');
        }else
        {
            $this->session->set_flashdata('msg-gagal-kelas', 'DATA GAGAL DIEDIT!');
        }
    }

    function hapus_kelas($id_kelas)
    {   
        $cek = $this->db->select('id_kelas')->from('tb_kelas_wali')->where('id_kelas',$id_kelas)->get()->num_rows();
        if($cek > 0)
        {
            $this->session->set_flashdata('msg-gagal-kelas', 'DATA GAGAL DIHAPUS!');
        }else
        {
            $this->db->where('id_kelas',$id_kelas)->delete('tb_kelas');
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-kelas', 'DATA BERHASIL DIHAPUS');
            }
            else
            {
                $this->session->set_flashdata('msg-gagal-kelas', 'DATA GAGAL DIHAPUS!');
            }
        }
        redirect('backend/kelas');            
    }

}