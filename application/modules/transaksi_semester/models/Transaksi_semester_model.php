<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transaksi_semester_model extends CI_Model {
 
    private $table = 'tb_kelas_siswa ks'; //nama tabel dari database
    private $column_order = array(null,'s.nis','s.nama','t.tahunpelajaran','k.kelas','ks.id_kelas_siswa');
    private $column_search = array('s.nis','s.nama','t.tahunpelajaran','k.kelas');
    private $order = array('ks.id_kelas_siswa' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        $this->db->select('ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran,kw.id_kelas,kw.id_guru,t.tahunpelajaran,k.kelas,g.nama,s.nis,s.nama');
		$this->db->from($this->table);
        $this->db->join('tb_kelas_wali kw', 'ks.id_kelas_wali=kw.id_kelas_wali','left');
        $this->db->join('tb_tahunpelajaran t', 'kw.id_tahunpelajaran=t.id_tahunpelajaran','left');
        $this->db->join('tb_kelas k', 'kw.id_kelas=k.id_kelas','left');
        $this->db->join('tb_guru g', 'kw.id_guru=g.id_guru','left');
        $this->db->join('tb_siswa s', 'ks.id_siswa=s.id_siswa','left');
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

    function cek_kelas_siswa($id_kelas_siswa)
    {
        return $this->db->select('id_kelas_siswa')->from('tb_kelas_siswa')->where('id_kelas_siswa',$id_kelas_siswa)->get()->row();
    }

    function hapus_transaksi_semester($id_kelas_siswa)
    {   
        $cek = $this->db->select('id_kelas_siswa')->from('tb_pembayaran')->where('id_kelas_siswa',$id_kelas_siswa)->get()->num_rows();
        if($cek > 0)
        {
            $this->session->set_flashdata('msg-gagal-tasemester', 'DATA GAGAL DIHAPUS!');
        }else
        {
            $this->db->where('id_kelas_siswa',$id_kelas_siswa)->delete('tb_kelas_siswa');
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-tasemester', 'DATA BERHASIL DIHAPUS');
            }
            else
            {
                $this->session->set_flashdata('msg-gagal-tasemester', 'DATA GAGAL DIHAPUS!');
            }
        }
        redirect('backend/transaksi-semester');            
    }

}