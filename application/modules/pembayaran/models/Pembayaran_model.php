<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pembayaran_model extends CI_Model {
 
    private $table = 'tb_pembayaran p'; //nama tabel dari database
    private $column_order = array(null,'p.tgl','p.bayar','s.nis','s.nama','p.id_pembayaran','p.status','u.nama','p.id_pembayaran');
    private $column_search = array('p.tgl','p.bayar','s.nis','s.nama','p.status','u.nama');
    private $order = array('p.id_pembayaran' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
      $this->db->select('p.*,s.*,tb.keterangan,t.*,th.id_tagihan,th.id_semester,u.nama AS nama_petugas');
      $this->db->from($this->table);
      $this->db->join('tb_siswa s','p.id_siswa=s.id_siswa','left');
      $this->db->join('tb_tabungan tb','p.id_pembayaran=tb.id_pembayaran','left');
      $this->db->join('tb_tagihan_tahunan th','p.id_tagihan_tahunan=th.id_tagihan_tahunan','left');
      $this->db->join('tb_tagihan t','th.id_tagihan=t.id_tagihan','left');
      $this->db->join('tb_user u','p.id_user=u.id_user','left');
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
 
    function bayar($id_siswa,$id_tagihan_tahunan,$id_semester,$id_bulan,$bayar,$tgl,$status,$id_user,$tabungan,$keterangan)
    {
      $this->db->trans_start();
        $data = [
          'id_siswa' => $id_siswa,
          'id_tagihan_tahunan' => $id_tagihan_tahunan,
          'id_semester' => $id_semester,
          'id_bulan' => $id_bulan,
          'bayar' => $bayar,
          'tgl' => $tgl,
          'status' => $status,
          'id_user' => $id_user   
        ];

        $this->db->insert('tb_pembayaran', $data);
        $id_pembayaran = $this->db->insert_id();
        
        if($tabungan != 0)
        {
          $data_tabungan = [
            'id_siswa' => $id_siswa,
            'nabung' => $tabungan,
            'tgl' => $tgl,
            'keterangan' => $keterangan,
            'id_user' => $id_user,
            'id_pembayaran' => $id_pembayaran,
            'hapus' => 'N'
          ];
          
          $this->db->insert('tb_tabungan', $data_tabungan);
          $this->db->update('tb_tabungan', ['hapus'=>'N'], ['id_siswa'=>$id_siswa]);

          $data_detail = [
            'id_pembayaran' => $id_pembayaran,
            'id_tabungan' => $this->id_tabungan_terakhir($id_siswa),
            'id_tagihan_tahunan' => $id_tagihan_tahunan
          ];

          $this->db->insert('tb_detail_tabungan', $data_detail);
        }
      $this->db->trans_complete();
  }

  function cek_pembayaran($id_pembayaran)
  {
    return $this->db->select('id_pembayaran,id_user')->from('tb_pembayaran')->where('id_pembayaran',$id_pembayaran)->where('id_user',$this->session->userdata('id_user'))->get()->row();
  }

  function cek_nis($nis)
  {
    return $this->db->select('nis')->from('tb_siswa')->where('nis',$nis)->get()->row();
  }

  function riwayat($id_siswa)
  {
    return $this->db->select('d.id_pembayaran,d.id_siswa,d.id_tagihan_tahunan,d.id_semester,d.id_bulan,d.bayar,d.tgl,d.status,d.id_user,s.nis,s.nama,t.id_tagihan,p.tagihan,u.nama AS nama_petugas')->from('tb_pembayaran d')->join('tb_siswa s','d.id_siswa=s.id_siswa','left')->join('tb_tagihan_tahunan t','d.id_tagihan_tahunan=t.id_tagihan_tahunan','left')->join('tb_tagihan p','t.id_tagihan=p.id_tagihan','left')->join('tb_user u','d.id_user=u.id_user','left')->where('d.id_siswa',$id_siswa)->order_by('d.id_pembayaran','desc')->get();
  }

  function slip($id_siswa,$tgl)
  {
    return $this->db->select('d.id_pembayaran,d.id_siswa,d.id_tagihan_tahunan,d.id_semester,d.id_bulan,d.bayar,d.tgl,d.status,d.id_user,s.nis,s.nama,t.id_tagihan,p.tagihan,u.nama AS nama_petugas')->from('tb_pembayaran d')->join('tb_siswa s','d.id_siswa=s.id_siswa','left')->join('tb_tagihan_tahunan t','d.id_tagihan_tahunan=t.id_tagihan_tahunan','left')->join('tb_tagihan p','t.id_tagihan=p.id_tagihan','left')->join('tb_user u','d.id_user=u.id_user','left')->where('d.id_siswa',$id_siswa)->like('d.tgl',$tgl)->order_by('d.id_pembayaran','desc')->get();
  }

  function id_tabungan_terakhir($id_siswa)
  {
    $ci = & get_instance();
    $q = $ci->db->select('id_tabungan,id_siswa,keterangan')->from('tb_tabungan')->where('id_siswa',$id_siswa)->where('keterangan','Menabung')->order_by('id_tabungan','desc')->get()->row_array();
    return $q['id_tabungan'];
  }

  function hapus_pembayaran($id_pembayaran)
  {
    $this->db->trans_start();
      $get = $this->db->get_where('tb_detail_tabungan', ['id_pembayaran'=>$id_pembayaran])->row();
      $cek = $this->db->select('t.*,d.*')->from('tb_tabungan t')->join('tb_detail_tabungan d','t.id_tabungan=d.id_tabungan')->where('t.id_tabungan', $get->id_tabungan)->where('t.keterangan !=', 'Menabung')->get()->num_rows();
      if($get)
      {
        if($cek == 0)
        {
          $this->db->update('tb_tabungan', ['hapus'=>'Y'], ['id_tabungan'=>$get->id_tabungan, 'keterangan'=>'Menabung']);
          $this->db->delete('tb_pembayaran', ['id_pembayaran'=>$id_pembayaran]);
          $this->db->delete('tb_tabungan', ['id_pembayaran'=>$id_pembayaran]);
          $this->db->delete('tb_detail_tabungan', ['id_pembayaran'=>$id_pembayaran]);
        }  
      }else
      {
        $this->db->delete('tb_pembayaran', ['id_pembayaran'=>$id_pembayaran]);
      }
    $this->db->trans_complete();
    if($this->db->trans_status() === TRUE)
    {
      $this->session->set_flashdata('msg-pembayaran', 'DATA BERHASIL DIHAPUS');
    }else
    {
      $this->session->set_flashdata('msg-gagal-pembayaran', 'DATA GAGAL DIHAPUS!');
    }
    redirect('backend/pembayaran');
  }

}