<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pembayaran extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model('pembayaran_model');
    } 
    
    function index()
	{	
		
		/*
		$q = $this->db->select('id_pembayaran,id_kelas_siswa,id_tagihan,id_semester,id_siswa')->from('tb_pembayaran')->order_by('id_pembayaran','desc')->where('id_pembayaran >',28082)->get()->result();
		foreach($q as $r):
			$id_tahunpelajaran = id_tahun_ks($r->id_kelas_siswa);
			$id_tagihan_tahunan = id_tagihan_tahunan($id_tahunpelajaran,$r->id_tagihan,$r->id_semester);	
			$data_update = [
				'id_tagihan_tahunan' => $id_tagihan_tahunan 
			];
			$this->db->update('tb_pembayaran',$data_update,['id_pembayaran'=>$r->id_pembayaran]);
		endforeach;	
		
		
		$q = $this->db->select('id_kelas_siswa')->from('tb_pembayaran')->where('id_pembayaran >',28082)->get()->result();
		foreach($q as $r):
			$id_siswa = id_siswa_ks($r->id_kelas_siswa);
			$data_update = [
				'id_siswa' => $id_siswa 
			];
			$this->db->update('tb_pembayaran',$data_update,['id_kelas_siswa'=>$r->id_kelas_siswa]);
		endforeach;
		*/
        $submit = $this->input->post('submit', TRUE);
		$nis = trim($this->input->post('nis', TRUE));
		$cek = $this->cek_nis($submit,$nis);
        if($cek == true)
        {
			$this->session->set_flashdata('msg-bayar', 'HASIL PENCARIAN DENGAN NIS: '.$nis.'');
			redirect('backend/bayar/'.$nis);
		}
		
		$data['title'] = 'Riwayat Pembayaran';
		$this->template->admin('backend/dashboard','pembayaran/pembayaran',$data);
	}
	
	function get_data_pembayaran()
	{	
		$list = $this->pembayaran_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{
			$id_tahunpelajaran = id_tahunpelajaran_pemb($r->id_tagihan_tahunan);
			$tahun = tahun($id_tahunpelajaran);
			$kelas = kelas_lap($r->id_siswa,$id_tahunpelajaran);
			$tingkat = tingkat_lap($r->id_siswa,$id_tahunpelajaran);
			$id_tagihan = id_tagihan($r->id_tagihan_tahunan);
			$id_jenistagihan = id_jenistagihan($id_tagihan);
				
			if($r->status == 'l')
			{
				$status = 'Pelunasan ';
			}elseif($r->status == 'a')
			{
				$status = 'Angsuran ';
			}else
			{
				$status = '';
			}

			if($r->id_semester != 0)
			{
				$semester = ' Semester '.semester($r->id_semester);
			}else
			{
				$semester = '';
			}

			if($r->id_bulan != 0)
			{
				$bulan = ' Bulan '.bulan($r->id_bulan);
			}else
			{
				$bulan = '';
			}

			if($id_jenistagihan == 3)
			{
				$keterangan = $status.' '.$r->tagihan.' '.$semester.' ( TP '.$tahun.' Kelas '.$tingkat.' )';
			}elseif($id_jenistagihan == 4)
			{
				$keterangan = $status.' '.$r->tagihan.' '.$bulan.' ( TP '.$tahun.' Kelas '.$tingkat.' )';
			}else
			{
				$keterangan = $status.' '.$r->tagihan.' ( TP '.$tahun.' Kelas '.$tingkat.' )';
			}

			if($r->id_user == $this->session->userdata('id_user'))
			{
				$aksi = '<a href="'.base_url("backend/cetak-slip/$r->id_pembayaran").'" target="_blank" class="btn btn-primary btn-xs btn-flat" title="CETAK PDF"><i class="fa fa-print"></i> CETAK</a>
				<a href="javascript:void(0)" class="btn btn-danger btn-xs btn-flat text-white" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="'.base_url("backend/hapus-pembayaran/$r->id_pembayaran").'" title="HAPUS DATA"><i class="fa fa-trash"></i> HAPUS</a>';
			}else
			{
				$aksi = '<a href="'.base_url("backend/cetak-slip/$r->id_pembayaran").'" target="_blank" class="btn btn-primary btn-xs btn-flat" title="CETAK PDF"><i class="fa fa-print"></i> CETAK</a><button class="btn btn-danger btn-xs btn-flat disabled"><i class="fa fa-trash"></i> HAPUS</button>';
			}

			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = date('d-m-Y H:i:s', strtotime($r->tgl));
			$row[] = '<div class="text-right">'.number_format($r->bayar, 0, ',', '.').'</div>';
			$row[] = $r->nis;
			$row[] = $r->nama;
			$row[] = $kelas;
			$row[] = $keterangan;
			$row[] = $r->catatan;
			$row[] = $r->nama_petugas;
			$action = '<div class="text-center">'.$aksi.'</div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pembayaran_model->count_all(),
			"recordsFiltered" => $this->pembayaran_model->count_filtered(),
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
				$hasil = $this->session->set_flashdata('msg-gagal-pembayaran', 'NIS TIDAK DITEMUKAN!');
            }else
            {
				$hasil = true;
			}										   
        }elseif(isset($submit) AND empty($nis))
        {
			$hasil = $this->session->set_flashdata('msg-gagal-pembayaran', 'NIS WAJIB DIISI!');
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

    function bayar($nis)
	{	
        $id_siswa = nis_to_id($nis);
		$cek = $this->cek_nis_ks($id_siswa);
		if(!$cek)
		{ 
			$this->session->set_flashdata('msg-gagal-pembayaran', 'NIS TIDAK DITEMUKAN!');
			redirect('backend/pembayaran');
        }else
        {
			$data['siswa'] = siswa_sekarang($id_siswa);
			if(!$data['siswa'])
			{
				$this->session->set_flashdata('msg-gagal-pembayaran', 'SISWA BELUM MASUK SEMESTER');
				redirect('backend/pembayaran');
			}
			$data['pemb_sekaliselamanya'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>1]);
			$data['pemb_tiaptahun'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>2]);
			$data['pemb_semester'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>3]);
			$data['pemb_bulanan'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>4]);
			$data['pemb_persiswa'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>5]);
			$data['pemb_kelulusan'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>6]);
			
			$submit = $this->input->post('submit', TRUE);
			$kurang = $this->input->post('kurang', TRUE);
			$bayar = $this->input->post('bayar', TRUE) + $this->input->post('daritabungan', TRUE);
			$catatan = $this->input->post('keterangan', TRUE);
			if( isset($submit) AND is_numeric($bayar) )
			{   
				$id_tagihan_tahunan = strip_tags($this->input->post('id_tagihan_tahunan',TRUE));
				$id_tagihan = id_tagihan_pemb($id_tagihan_tahunan);
				$id_jenistagihan = id_jenistagihan($id_tagihan);
                $id_kelas_siswa = id_kelas_siswa($id_siswa);
				
                if($id_jenistagihan != 4)
                {   
					$status_skrg = status_skrg($id_tagihan_tahunan,0,$id_siswa);
                }else
                {
					$status_skrg = status_skrg($id_tagihan_tahunan,$this->input->post('id_bulan',TRUE),$id_siswa);
				}
					
				if($status_skrg == 'l')
				{	
					$this->session->set_flashdata('msg-gagal-bayar', 'GAGAL DIBAYARKAN');
					redirect('backend/bayar/'.$nis);
				}else
				{
					if($bayar <= $kurang)
					{	
						$tabungan_sekarang = tabungan($this->input->post('id_siswa',TRUE));
						if($tabungan_sekarang >= $this->input->post('daritabungan', TRUE))
						{	
                            if($bayar >= $kurang)
                            {
								$status = 'l';
                            }else
                            {
								$status = 'a';
							}
							
							$id_semester = strip_tags($this->input->post('id_semester',TRUE));
							$id_bulan = strip_tags($this->input->post('id_bulan',TRUE));
							$tgl = tgl_jam_simpan_sekarang();
							$id_user = $this->session->userdata('id_user');
							$dari_tabungan = $this->input->post('daritabungan', TRUE);
							$tabungan = - $this->input->post('daritabungan', TRUE);

                            if($id_semester != 0)
                            {
								$semester = ' Semester '.semester($id_semester);
                            }else
                            {
								$semester = '';
							}
							
                            if($id_bulan != 0)
                            {
								$bulan = ' Bulan '.bulan($id_bulan);
                            }else
                            {
								$bulan = '';
							}

							$tagihan = tagihan($id_tagihan);
							$tahun = tahun($this->input->post('id_tahunpelajaran', TRUE));
							
                            if($id_jenistagihan == 3)
                            {
								$keterangan = 'Membayar '.$tagihan.' '.$semester.' ( TP '.$tahun.' )';
                            }elseif($id_jenistagihan == 4)
                            {
								$keterangan = 'Membayar '.$tagihan.' '.$bulan.' ( TP '.$tahun.' )';
                            }elseif($id_jenistagihan == 5)
                            {
								$keterangan = 'Membayar '.$tagihan.' ( TP '.$tahun.' )';
                            }else
                            {
								$keterangan = 'Membayar '.$tagihan.' ( TP '.$tahun.' )';
							}

							$this->pembayaran_model->bayar($id_siswa,$id_tagihan_tahunan,$id_semester,$id_bulan,$bayar,$tgl,$status,$id_user,$tabungan,$keterangan,$catatan);
                            if($this->db->trans_status() === TRUE)
                            {
								$this->session->set_flashdata('msg-bayar', 'BERHASIL DIBAYARKAN');
                            }else
                            {
								$this->session->set_flashdata('msg-gagal-bayar', 'GAGAL DIBAYARKAN');
							}
                        }else
                        {
							$this->session->set_flashdata('msg-gagal-bayar', 'TABUNGAN TIDAK CUKUP!');
						}
                    }else
                    {
						$this->session->set_flashdata('msg-gagal-bayar', 'NILAI TIDAK SESUAI!');
					}
				}		
            }elseif( isset($submit) AND !is_numeric($bayar) )
            {
				$this->session->set_flashdata('msg-gagal-bayar', 'MASUKAN ANGKA!');
            }else
            {
				
			}
        }
        $data['title'] = 'Pembayaran';
		$data['nis'] = $nis;
        $data['bulan'] = $this->db->select('*')->from('tb_bulan')->order_by('id_bulan','asc')->get();
        $this->template->admin('backend/dashboard','pembayaran/bayar', $data);
	}
	
	function riwayat($nis)
	{	
		$cek = $this->pembayaran_model->cek_nis($nis); 
		if(!$cek)
		{
			show_404();
		}else
		{
			$id_siswa = nis_to_id($nis);
			$data['siswa'] = siswa_sekarang($id_siswa);
			$data['data'] = $this->pembayaran_model->riwayat($id_siswa);
			$this->template->admin('backend/dashboard','pembayaran/riwayat',$data);
		}
	}

	function cetak_riwayat_pdf($nis)
	{
		$cek = $this->pembayaran_model->cek_nis($nis);
		if(!$cek)
		{
			show_404();
		}else
		{
			$this->load->library('pdfgenerator');
			$id_siswa = nis_to_id($nis);
			$data['siswa'] = siswa_sekarang($id_siswa);
			$data['data'] = $this->pembayaran_model->riwayat($id_siswa);
			$html = $this->load->view('pembayaran/cetak_riwayat_pdf', $data, true);
			$filename = 'cetak-riwayat-pembayaran';
			$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'portrait');	
		}
	}

	function cetak_riwayat($nis)
	{
		$cek = $this->pembayaran_model->cek_nis($nis);
		if(!$cek)
		{
			show_404();
		}else
		{
			$id_siswa = nis_to_id($nis);
			$data['siswa'] = siswa_sekarang($id_siswa);
			$data['data'] = $this->pembayaran_model->riwayat($id_siswa);
			$this->load->view('pembayaran/cetak_riwayat', $data);	
		}
	}

	function cetak_slip_pdf($id)
	{
		$cek = $this->pembayaran_model->cek_pembayaran($id);
		if(!$cek)
		{
			show_404();
		}else
		{
			$this->load->library('pdfgenerator');
			$id_siswa = id_siswa_pemb($id);
			$tgl = tgl_pemb($id);
			$data['siswa'] = siswa_sekarang($id_siswa);
			$data['tgl'] = $tgl;
			$data['data'] = $this->pembayaran_model->slip($id_siswa,$tgl);
			$html = $this->load->view('pembayaran/cetak_slip_pdf', $data, true);
			$filename = 'cetak-slip-pembayaran';
			$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'portrait');	
		}
	}

	function cetak_slip($id)
	{
		$cek = $this->pembayaran_model->cek_pembayaran($id);
		if(!$cek)
		{
			show_404();
		}else
		{
			$id_siswa = id_siswa_pemb($id);
			$tgl = tgl_pemb($id);
			$data['siswa'] = siswa_sekarang($id_siswa);
			$data['tgl'] = $tgl;
			$data['data'] = $this->pembayaran_model->slip($id_siswa,$tgl);
			$this->load->view('pembayaran/cetak_slip', $data);
		}
	}

	function hapus_pembayaran($id_pembayaran)
	{ 	
		$cek = $this->pembayaran_model->cek_pembayaran($id_pembayaran); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$this->pembayaran_model->hapus_pembayaran($id_pembayaran);
		}
	}

}