<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tabungan_model extends CI_Model {
 
    private $table = 'tb_tabungan d'; //nama tabel dari database
    private $column_order = array(null,'d.tgl','d.nabung','s.nis','s.nama','u.nama','d.id_tabungan');
    private $column_search = array('d.tgl','d.nabung','s.nis','s.nama','u.nama');
    private $order = array('d.id_tabungan' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->select('d.id_tabungan,d.id_siswa,d.nabung,d.tgl,d.id_user,d.keterangan,s.nis,s.nama,u.nama AS nama_petugas');
        $this->db->from($this->table);
        $this->db->join('tb_siswa s', 'd.id_siswa=s.id_siswa','left');
        $this->db->join('tb_user u', 'd.id_user=u.id_user','left');

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

    function nabung($nis)
    {
        $data = [
            'id_siswa' => nis_to_id($nis),
            'nabung' => strip_tags($this->input->post('nabung',TRUE)),
            'tgl' => tgl_jam_simpan_sekarang(),
            'id_user' => $this->session->userdata('id_user'),
            'keterangan' => 'Menabung',
            'hapus' => 'Y'
        ];

        $this->db->insert('tb_tabungan',$data);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('msg-tabungan', 'BERHASIL DISETORKAN!');
        }else
        {
            $this->session->set_flashdata('msg-gagal-tabungan', 'GAGAL DISETORKAN!');
        }
    }

    function riwayat_tabungan($id_siswa)
    {
        return $this->db->select('d.*,s.nis,s.nama,u.nama AS nama_petugas')->from('tb_tabungan d')->join('tb_siswa s','d.id_siswa=s.id_siswa','left')->join('tb_user u','d.id_user=u.id_user','left')->where('d.id_siswa',$id_siswa)->order_by('d.id_tabungan','desc')->get();
    }

    function slip_tabungan($id_siswa,$tgl)
    {
        return $this->db->select('d.id_tabungan,d.id_siswa,d.nabung,d.tgl,d.id_user,d.keterangan,s.nis,s.nama,u.nama AS nama_petugas')->from('tb_tabungan d')->join('tb_siswa s','d.id_siswa=s.id_siswa','left')->join('tb_user u','d.id_user=u.id_user','left')->where('d.id_siswa',$id_siswa)->like('d.tgl',$tgl)->order_by('d.id_tabungan','desc')->get();
    }

    function cek_tabungan($id_tabungan)
    {
        return $this->db->select('id_tabungan')->from('tb_tabungan')->where('id_tabungan',$id_tabungan)->get()->row();
    }

    function cek_nis($nis)
    {
        return $this->db->select('nis')->from('tb_siswa')->where('nis',$nis)->get()->row();
    }

    function id_tabungan_terakhir($id_siswa)
    {
       $ci = & get_instance();
       $q = $ci->db->select('id_tabungan,id_siswa')->from('tb_tabungan')->where('id_siswa',$id_siswa)->order_by('id_tabungan','desc')->get()->row_array();
       return $q['id_tabungan'];
    }

    function hapus_tabungan($id_tabungan,$nis)
    {   
        $cek = $this->db->select('id_tabungan,id_user,hapus')->from('tb_tabungan')->where('id_tabungan',$id_tabungan)->where('id_user',$this->session->userdata('id_user'))->where('hapus','Y')->get()->num_rows();
        if($cek > 0)
        {            
            $this->db->delete('tb_detail_tabungan', ['id_tabungan'=>$id_tabungan]);
            $this->db->delete('tb_tabungan', ['id_tabungan'=>$id_tabungan]);
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-tabungan', 'DATA BERHASIL DIHAPUS');
            }else
            {
                $this->session->set_flashdata('msg-gagal-tabungan', 'DATA GAGAL DIHAPUS!');
            }
        }else
        {
            $this->session->set_flashdata('msg-gagal-tabungan', 'DATA GAGAL DIHAPUS! HANYA ADMIN YANG MENGINPUT YANG BISA MENGHAPUS!');
        }
        redirect("backend/nabung/$nis");        
    }

}