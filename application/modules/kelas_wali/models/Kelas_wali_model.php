<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kelas_wali_model extends CI_Model
{
    private $table = 'tb_kelas_wali w'; //nama tabel dari database
    private $column_order = array(null,'g.nama','t.tahunpelajaran','k.kelas','w.id_kelas_wali');
    private $column_search = array('g.nama','t.tahunpelajaran','k.kelas');
    private $order = array('w.id_kelas_wali' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {   
        $this->db->select('w.*,t.tahunpelajaran,k.kelas,g.nama');
        $this->db->from($this->table);
        $this->db->join('tb_tahunpelajaran t','w.id_tahunpelajaran=t.id_tahunpelajaran','left');
        $this->db->join('tb_kelas k','w.id_kelas=k.id_kelas','left');
        $this->db->join('tb_guru g','w.id_guru=g.id_guru','left');
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

    function tambah_kelas_wali()
    {
        $data = [
            'id_tahunpelajaran' => strip_tags($this->input->post('id_tahunpelajaran',TRUE)),
            'id_kelas' => strip_tags($this->input->post('id_kelas',TRUE)),
            'id_guru' => strip_tags($this->input->post('id_guru',TRUE))
        ];

        $this->db->insert('tb_kelas_wali',$data);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-kelas-wali', 'DATA BERHASIL DITAMBAHKAN');
            redirect('backend/kelas-wali');
        }else
        {
            $this->session->set_flashdata('msg-gagal-kelas-wali', 'DATA GAGAL DITAMBAHKAN!');
        }
    }

    function cek_kelas_wali($id_kelas_wali)
    {
        return $this->db->select('id_kelas_wali')->from('tb_kelas_wali')->where('id_kelas_wali',$id_kelas_wali)->get()->row();
    }

    function edit_kelas_wali($id_kelas_wali)
    {
        $data = [
            'id_tahunpelajaran' => strip_tags($this->input->post('id_tahunpelajaran',TRUE)),
            'id_kelas' => strip_tags($this->input->post('id_kelas',TRUE)),
            'id_guru' => strip_tags($this->input->post('id_guru',TRUE))
        ];

        $this->db->update('tb_kelas_wali',$data,['id_kelas_wali'=>$id_kelas_wali]);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-kelas-wali', 'DATA BERHASIL DIEDIT');
            redirect('backend/kelas-wali');
        }else
        {
            $this->session->set_flashdata('msg-gagal-kelas-wali', 'DATA GAGAL DIEDIT!');
        }
    }

    function hapus_kelas_wali($id_kelas_wali)
    {   
        $cek = $this->db->select('id_kelas_wali')->from('tb_kelas_siswa')->where('id_kelas_wali',$id_kelas_wali)->get()->num_rows();
        if($cek > 0)
        {
            $this->session->set_flashdata('msg-gagal-kelas-wali', 'DATA GAGAL DIHAPUS!');
        }else
        {
            $this->db->where('id_kelas_wali',$id_kelas_wali)->delete('tb_kelas_wali');
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-kelas-wali', 'DATA BERHASIL DIHAPUS');
            }
            else
            {
                $this->session->set_flashdata('msg-gagal-kelas-wali', 'DATA GAGAL DIHAPUS!');
            }
        }
        redirect('backend/kelas-wali');            
    }

}