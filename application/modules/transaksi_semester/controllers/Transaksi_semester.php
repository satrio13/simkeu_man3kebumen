<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transaksi_semester extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model('transaksi_semester_model');
    } 

    function index()
	{	
		$data['title'] = 'Transaksi Kelas';
        $this->template->admin('backend/dashboard','transaksi_semester/transaksi_semester', $data);
    }

    function get_data_transaksi_semester()
	{
		$list = $this->transaksi_semester_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r) {
			
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $r->nis;
			$row[] = $r->nama;
			$row[] = '<div class="text-center">'.$r->tahunpelajaran.'</div>';
			$row[] = '<div class="text-center">'.$r->kelas.'</div>';
			$action = '<div class="text-center">
						<a href="javascript:void(0)" class="btn btn-danger btn-xs btn-flat text-white" data-toggle="modal" data-target="#konfirmasi_hapus" 
						data-href="'.base_url("backend/hapus-transaksi-semester/$r->id_kelas_siswa").'" title="HAPUS DATA">HAPUS</a>
					  </div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->transaksi_semester_model->count_all(),
			"recordsFiltered" => $this->transaksi_semester_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    } 
    
    function trans_semester()
	{	
		//dari
		$id_tahunpelajaran = $this->db->escape_str($this->input->post('id_tahunpelajaran',true));
		$id_kelas = $this->db->escape_str($this->input->post('id_kelas',true));
		//ke
		$id_tahunpelajaran2 = strip_tags($this->input->post('id_tahunpelajaran2',true));
		$id_kelas2 = strip_tags($this->input->post('id_kelas2',true));
		$id_semester2 = semester_trans($this->input->post("id_kelas2",TRUE));

		if($this->input->post('cari', TRUE)=='Cari')
		{
			if($id_tahunpelajaran == 0 AND $id_kelas == 0)
			{
				$data['data'] = $this->db->query("SELECT * FROM tb_siswa WHERE NOT EXISTS (SELECT id_siswa FROM tb_kelas_siswa WHERE tb_siswa.id_siswa=tb_kelas_siswa.id_siswa) ORDER BY nis ASC");
            }
            else
            {
				$data['data'] = $this->db->select('ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran,kw.id_kelas,kw.id_guru,t.tahunpelajaran,k.kelas,g.nama,s.nis,s.nama')
                    ->from('tb_kelas_siswa ks')
                    ->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali','left')  
                    ->join('tb_tahunpelajaran t','kw.id_tahunpelajaran=t.id_tahunpelajaran','left')  
                    ->join('tb_kelas k','kw.id_kelas=k.id_kelas','left')  
                    ->join('tb_guru g','kw.id_guru=g.id_guru','left')  
                    ->join('tb_siswa s','ks.id_siswa=s.id_siswa','left')  
                    ->where('kw.id_tahunpelajaran',$id_tahunpelajaran)
                    ->where('kw.id_kelas',$id_kelas)
                    ->order_by('s.nis','asc')->get();               
			}
		}elseif($this->input->post('trans', TRUE)=='Trans')
		{
			$i = 1;
			$no = $_POST['no'];
			$sukses = 0;
			$gagal = 0;
			while($i <= $no)
			{	
				if(isset($_POST['cek'][$i]))
				{	
					$data_insert = [
						'id_siswa' => $_POST['cek'][$i],
						'id_kelas_wali' => id_kelas_wali($id_tahunpelajaran2,$id_kelas2),
						'id_semester' => $id_semester2
					];

					$id_kelas_wali = id_kelas_wali($id_tahunpelajaran2,$id_kelas2);
                    $cek = $this->db->get_where('tb_kelas_siswa',['id_kelas_wali'=>$id_kelas_wali,'id_semester'=>$id_semester2,'id_siswa'=>$_POST['cek'][$i]])->num_rows();
					$cek_smt = $this->db->get_where('tb_kelas_siswa',['id_semester'=>$id_semester2,'id_siswa'=>$_POST['cek'][$i]]);
					
					if(!$id_kelas_wali)
					{	
						$gagal ++;
						$pesan = '( KELAS TUJUAN BELUM PUNYA WALI KELAS )';
					}elseif($cek_smt->num_rows() > 0)
					{
						$this->db->trans_start();
							$this->db->delete('tb_kelas_siswa',['id_semester'=>$id_semester2,'id_siswa'=>$_POST['cek'][$i]]);
							$this->db->insert('tb_kelas_siswa',$data_insert);
							$sukses ++;
							$pesan = '';
						$this->db->trans_complete();
					}else
                    {
						if($id_kelas == $id_kelas2 AND $id_tahunpelajaran != $id_tahunpelajaran2)
						{	
							$gagal ++;
							$pesan = '';
                        }else
                        {
							if($cek > 0)
							{
								$gagal ++;
								$pesan = '';
                            }else
                            {
								$this->db->trans_start();
									$this->db->insert('tb_kelas_siswa',$data_insert);
									$sukses ++;
									$pesan = '';
								$this->db->trans_complete();
							}
						}
					}
				}
				$i++;
			}
			$msg = '<div class="alert alert-light border border-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<div class="text-success text-bold">'.$sukses.' DATA BERHASIL DITRANSAKSIKAN</div>
						<div class="text-danger text-bold">'.$gagal.' DATA GAGAL DITRANSAKSIKAN '.$pesan.'</div>
					</div>';
			$this->session->set_flashdata("msg-transaksi-semester", "$msg");
			redirect('backend/transaksi-semester');
		}
		$data['title'] = 'Transaksi Kelas';        
        $data['tahun'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get();
        $data['kelas'] = $this->db->select('*')->from('tb_kelas')->order_by('kelas','asc')->get();
        $data['semester'] = $this->db->select('*')->from('tb_semester')->order_by('semester','asc')->get();
        $this->template->admin('backend/dashboard','transaksi_semester/transemester', $data);
	}
    
    function hapus_transaksi_semester($id)
	{
		$cek = $this->transaksi_semester_model->cek_kelas_siswa($id); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$id_siswa = id_siswa($id);
			$id_semester = id_semester($id);
			$cek_pemb = $this->db->select('id_siswa,id_semester')->from('tb_pembayaran')->where('id_siswa',$id_siswa)->where('id_semester',$id_semester)->get()->num_rows();
			if($cek_pemb == 0)
			{	
				$smt = smt_pemb($id_siswa);			
				if($smt >= $id_semester)
				{
					$this->session->set_flashdata('msg-gagal-tasemester', 'DATA GAGAL DIHAPUS!');
				}else
				{
					$this->db->delete('tb_kelas_siswa', array('id_kelas_siswa'=>$id));
					if($this->db->affected_rows() > 0)
					{
						$this->session->set_flashdata('msg-tasemester', 'DATA BERHASIL DIHAPUS');
					}else
					{
						$this->session->set_flashdata('msg-gagal-tasemester', 'DATA GAGAL DIHAPUS!');
					}
				}
			}else
			{
				$this->session->set_flashdata('msg-gagal-tasemester', 'DATA GAGAL DIHAPUS!');
			}	
			redirect('backend/transaksi-semester');
		}
	}

}