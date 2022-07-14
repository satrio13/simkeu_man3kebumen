<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tagihan_tahunan_model extends CI_Model
{
    private $table = 'tb_tagihan_tahunan d'; //nama tabel dari database
    private $column_order = array(null,'t.tahunpelajaran','g.tagihan','d.perangkatan','d.perangkatan_bsm','d.kelas10','d.kelas10_bsm','d.kelas11','d.kelas11_bsm','d.kelas12','d.kelas12_bsm','d.id_tagihan_tahunan');
    private $column_search = array('t.tahunpelajaran','g.tagihan');
    private $order = array('d.id_tagihan_tahunan' => 'desc'); // default order 
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {   
        $this->db->select('d.*,t.*,g.*');
        $this->db->from($this->table);
        $this->db->join('tb_tahunpelajaran t','d.id_tahunpelajaran=t.id_tahunpelajaran','left');
        $this->db->join('tb_tagihan g','d.id_tagihan=g.id_tagihan','left');
        $this->db->join('tb_semester s','d.id_semester=s.id_semester','left');
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

    function tambah_tagihan_tahunan()
    {
        $id_tahunpelajaran = strip_tags($this->input->post('id_tahunpelajaran',TRUE));
        $id_tagihan = strip_tags($this->input->post('id_tagihan',TRUE));
        $id_jenistagihan = id_jenistagihan($id_tagihan);
        if($id_jenistagihan == 3)
        {
            $id_semester = strip_tags($this->input->post('id_semester',TRUE));
        }else
        {
            $id_semester = 0;
        }
        
        $cek = $this->db->get_where('tb_tagihan_tahunan',['id_tahunpelajaran'=>$id_tahunpelajaran,'id_tagihan'=>$id_tagihan,'id_semester'=>$id_semester])->num_rows();
        if($cek > 0)
        {
            $this->session->set_flashdata('msg-gagal-tagihan-tahunan', 'DATA GAGAL DITAMBAHKAN KARENA SUDAH ADA!');
        }else
        {
            $data = [
                'id_tahunpelajaran' => $id_tahunpelajaran,
                'id_tagihan' => $id_tagihan,
                'id_semester' => $id_semester,
                'perangkatan' => strip_tags($this->input->post('perangkatan',TRUE)),
                'perangkatan_bsm' => strip_tags($this->input->post('perangkatan_bsm',TRUE)),
                'kelas10' => strip_tags($this->input->post('kelas10',TRUE)),
                'kelas10_bsm' => strip_tags($this->input->post('kelas10_bsm',TRUE)),
                'kelas11' => strip_tags($this->input->post('kelas11',TRUE)),
                'kelas11_bsm' => strip_tags($this->input->post('kelas11_bsm',TRUE)),
                'kelas12' => strip_tags($this->input->post('kelas12',TRUE)),
                'kelas12_bsm' => strip_tags($this->input->post('kelas12_bsm',TRUE))
            ];

            $this->db->insert('tb_tagihan_tahunan',$data);
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-tagihan-tahunan', 'DATA BERHASIL DITAMBAHKAN');
                redirect('backend/tagihan-tahunan');
            }else
            {
                $this->session->set_flashdata('msg-gagal-tagihan-tahunan', 'DATA GAGAL DITAMBAHKAN!');
            }
        }           
    }

    function cek_tagihan_semester($id_tagihan)
    {
        return $this->db->select('*')->from('tb_tagihan')->where('id_tagihan',$id_tagihan)->where('id_jenistagihan',3)->get()->result();
    }

    function cek_tagihan_tahunan($id_tagihan_tahunan)
    {
        return $this->db->select('id_tagihan_tahunan')->from('tb_tagihan_tahunan')->where('id_tagihan_tahunan',$id_tagihan_tahunan)->get()->row();
    }

    function edit_tagihan_tahunan($id_tagihan_tahunan)
    {
        $id_tahunpelajaran = strip_tags($this->input->post('id_tahunpelajaran',TRUE));
        $id_tagihan = strip_tags($this->input->post('id_tagihan',TRUE));
        $id_jenistagihan = id_jenistagihan($id_tagihan);
        if($id_jenistagihan == 3)
        {
            $id_semester = strip_tags($this->input->post('id_semester',TRUE));
        }else
        {
            $id_semester = 0;
        }
        
        $cek = $this->db->get_where('tb_tagihan_tahunan',['id_tahunpelajaran'=>$id_tahunpelajaran,'id_tagihan'=>$id_tagihan,'id_semester'=>$id_semester,'id_tagihan_tahunan != '=>$id_tagihan_tahunan])->num_rows();
        if($cek > 0)
        {
            $this->session->set_flashdata('msg-gagal-tagihan-tahunan', 'DATA GAGAL DITAMBAHKAN KARENA SUDAH ADA!');
        }else
        {
            $data = [
                'id_tahunpelajaran' => $id_tahunpelajaran,
                'id_tagihan' => $id_tagihan,
                'id_semester' => $id_semester,
                'perangkatan' => strip_tags($this->input->post('perangkatan',TRUE)),
                'perangkatan_bsm' => strip_tags($this->input->post('perangkatan_bsm',TRUE)),
                'kelas10' => strip_tags($this->input->post('kelas10',TRUE)),
                'kelas10_bsm' => strip_tags($this->input->post('kelas10_bsm',TRUE)),
                'kelas11' => strip_tags($this->input->post('kelas11',TRUE)),
                'kelas11_bsm' => strip_tags($this->input->post('kelas11_bsm',TRUE)),
                'kelas12' => strip_tags($this->input->post('kelas12',TRUE)),
                'kelas12_bsm' => strip_tags($this->input->post('kelas12_bsm',TRUE))
            ];

            $this->db->update('tb_tagihan_tahunan',$data,['id_tagihan_tahunan'=>$id_tagihan_tahunan]);
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-tagihan-tahunan', 'DATA BERHASIL DIEDIT');
                redirect('backend/tagihan-tahunan');
            }else
            {
                $this->session->set_flashdata('msg-gagal-tagihan-tahunan', 'DATA GAGAL DIEDIT!');
            }
        }           
    }

    function hapus_tagihan_tahunan($id_tagihan_tahunan)
    {   
        $cek = $this->db->select('id_tagihan_tahunan')->from('tb_pembayaran')->where('id_tagihan_tahunan',$id_tagihan_tahunan)->get()->num_rows();
        if($cek > 0)
        {
            $this->session->set_flashdata('msg-gagal-tagihan-tahunan', 'DATA GAGAL DIHAPUS!');
        }else
        {
            $this->db->where('id_tagihan_tahunan',$id_tagihan_tahunan)->delete('tb_tagihan_tahunan');
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-tagihan-tahunan', 'DATA BERHASIL DIHAPUS');
            }
            else
            {
                $this->session->set_flashdata('msg-gagal-tagihan-tahunan', 'DATA GAGAL DIHAPUS!');
            }
        }
        redirect('backend/tagihan-tahunan');            
    }
    
}