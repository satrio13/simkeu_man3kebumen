<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tabungan extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model('tabungan_model');
    } 

    function index()
	{	
		$submit = $this->input->post('submit', TRUE);
		$nis = trim($this->input->post('nis', TRUE));
		$cek = $this->cek_nis($submit,$nis);
		if($cek == true)
		{
			$this->session->set_flashdata('msg-nabung', 'HASIL PENCARIAN DENGAN NIS: '.$nis.'');
			redirect('backend/nabung/'.$nis);
		}
		$data['title'] = 'Riwayat Tabungan';
        $this->template->admin('backend/dashboard','tabungan/tabungan',$data);
    }

	function get_data_tabungan()
	{	
		$list = $this->tabungan_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{
			if( $this->session->userdata('id_user') == $r->id_user AND $r->keterangan == 'Menabung' )
			{ 
				$id_tabungan_terakhir = id_tabungan_terakhir($r->id_siswa);
				if($id_tabungan_terakhir == $r->id_tabungan)
				{
					$cek_status_tabungan = cek_status_tabungan($r->id_tabungan);
					if($cek_status_tabungan == 'Menabung')
					{
						$hapus = '<a href="javascript:void(0)" class="btn btn-danger btn-sm 
						btn-flat text-white" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="'.base_url("backend/hapus-tabungan/$r->id_tabungan").'" title="HAPUS DATA"><i class="fa fa-trash"></i></a>'
						;
					}else
					{
						$hapus = '';
					}
				}else
				{
					$hapus = '';
				}
			}else
			{
				$hapus = '';
			} 

			$cetak = '<a href="'.base_url("backend/cetak-slip-tabungan/$r->id_tabungan").'" target="_blank" class="btn btn-primary btn-sm btn-flat border-white text-bold"><i class="fa fa-print"></i></a>';

			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = date('d-m-Y H:i:s', strtotime($r->tgl));
			$row[] = '<div class="text-right">'.number_format($r->nabung, 0, ',', '.').'</div>';
			$row[] = $r->nis;
			$row[] = $r->nama;
			$row[] = $r->nama_petugas;
			$action = '<div class="text-center">'.$cetak.' '.$hapus.'</div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->tabungan_model->count_all(),
			"recordsFiltered" => $this->tabungan_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    }

	private function cek_nis($submit,$nis)
	{	
        if(isset($submit) AND !empty($nis))
        {
            $id_siswa = nis_to_id($nis);
			$cek_nis = $this->cek_nis_ks($id_siswa);
            if(!$cek_nis)
            {
				$hasil = $this->session->set_flashdata('msg-gagal-tabungan', 'NIS TIDAK DITEMUKAN!');
            }else
            {
				$hasil = true;
			}										   
        }elseif(isset($submit) AND empty($nis))
        {
			$hasil = $this->session->set_flashdata('msg-gagal-tabungan', 'NIS WAJIB DIISI!');
        }else
        {
			$hasil = false;
		}
		return $hasil;
	}
	
	function cek_nis_ks($id_siswa)
    {
        return $this->db->select('id_siswa')->from('tb_kelas_siswa')->where('id_siswa',$id_siswa)->get()->row();
    }

	function nabung($nis)
	{	
		$id_siswa = nis_to_id($nis);
		$cek = $this->cek_nis_ks($id_siswa);
		if(!$cek)
		{ 
			$this->session->set_flashdata('msg-gagal-tabungan', 'NIS TIDAK DITEMUKAN!');
			redirect('backend/tabungan');
		}else
		{
			$data['siswa'] = siswa_sekarang($id_siswa);
			if(!$data['siswa'])
			{
				$this->session->set_flashdata('msg-gagal-tabungan', 'SISWA BELUM MASUK SEMESTER');
				redirect('backend/tabungan');
			}
            $submit = $this->input->post('submit', TRUE);
			$nabung = $this->input->post('nabung', TRUE);
			if( isset($submit) AND is_numeric($nabung) AND $nabung > 0 )
			{
				$this->tabungan_model->nabung($nis);
			}elseif( isset($submit) AND !is_numeric($nabung) )
			{
				$this->session->set_flashdata('msg-gagal-nabung', 'MASUKAN ANGKA!');
			}elseif( isset($submit) AND ($nabung <= 0) )
			{
				$this->session->set_flashdata('msg-gagal-nabung', 'JUMLAH SETORAN TIDAK BOLEH NOL!');
			}
		}
		$data['title'] = 'Tabungan';
		$data['data'] = $this->tabungan_model->riwayat_tabungan($id_siswa);
        $this->template->admin('backend/dashboard','tabungan/nabung',$data);
	}
	
	function hapus_tabungan($id_tabungan,$nis)
	{
		$cek = $this->tabungan_model->cek_tabungan($id_tabungan); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$this->tabungan_model->hapus_tabungan($id_tabungan,$nis);
		}
	}

	function cetak_riwayat_tabungan($nis)
	{
		$cek = $this->tabungan_model->cek_nis($nis);
		if(!$cek)
		{
			show_404();
		}else
		{
			$this->load->library('pdfgenerator');
			$id_siswa = nis_to_id($nis);
			$data['siswa'] = siswa_sekarang($id_siswa);
			$data['data'] = $this->tabungan_model->riwayat_tabungan($id_siswa);
			$this->load->library('pdfgenerator');
			$html = $this->load->view('tabungan/cetak_riwayat', $data, true);
			$filename = 'cetak-riwayat-tabungan';
			$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'portrait');
		}	
	}

	function cetak_slip_tabungan($id)
	{
		$cek = $this->tabungan_model->cek_tabungan($id);
		if(!$cek)
		{
			show_404();
		}else
		{
			$this->load->library('pdfgenerator');
			$id_siswa = id_siswa_tabungan($id);
			$tgl = tgl_tabungan($id);
			$data['siswa'] = siswa_sekarang($id_siswa);
			$data['tgl'] = $tgl;
			$data['data'] = $this->tabungan_model->slip_tabungan($id_siswa,$tgl);
			$html = $this->load->view('tabungan/cetak_slip', $data, true);
			$filename = 'cetak-slip-tabungan';
			$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'portrait');	
		}
	}

}