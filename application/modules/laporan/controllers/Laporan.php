<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporan extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model('laporan_model');
    }

    function index()
    {
        show_404();
    }

    function laporan_riwayat()
	{ 
        if($this->input->post('submit', TRUE) == 'Submit')
		{
            $this->_validation_riwayat();
			if($this->form_validation->run() == TRUE)
			{ 
                $id_tahunpelajaran = $this->db->escape_str($this->input->post('id_tahunpelajaran', TRUE));
                $tingkatan = $this->db->escape_str($this->input->post('tingkatan', TRUE));
				$id_tagihan = $this->db->escape_str($this->input->post('id_tagihan', TRUE));
				$tgl_awal = $this->db->escape_str($this->input->post('tgl_awal', TRUE));
                $tgl_akhir = $this->db->escape_str($this->input->post('tgl_akhir', TRUE));
                
                if($tingkatan != '0')
                {
					$kondisi_tingkatan = '=';
					$tingkatan = $tingkatan;
                }else
                {
					$kondisi_tingkatan = '!=';
					$tingkatan = 0;
				}

                if($id_tagihan != '0')
                {
					$kondisi_tagihan = '=';
					$id_tagihan = $id_tagihan;
                }else
                {
					$kondisi_tagihan = '!=';
					$id_tagihan = 0;
                }
                
                $data['riwayat'] = $this->db->query("SELECT p.*,s.*,tb.keterangan,t.*,th.id_tagihan,th.id_semester,th.id_tahunpelajaran,u.nama AS nama_petugas,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran,kw.id_kelas,k.kelas,k.tingkat
                FROM tb_pembayaran p 
                LEFT JOIN tb_siswa s ON p.id_siswa=s.id_siswa 
                LEFT JOIN tb_tagihan_tahunan th ON p.id_tagihan_tahunan=th.id_tagihan_tahunan 
                LEFT JOIN tb_tagihan t ON th.id_tagihan=t.id_tagihan 
                LEFT JOIN tb_tabungan tb ON p.id_pembayaran=tb.id_pembayaran 
                LEFT JOIN tb_user u ON p.id_user=u.id_user 
                LEFT JOIN tb_kelas_siswa ks ON p.id_siswa=ks.id_siswa
                LEFT JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali
                LEFT JOIN tb_kelas k ON kw.id_kelas=k.id_kelas
                WHERE kw.id_tahunpelajaran = $id_tahunpelajaran AND k.tingkat $kondisi_tingkatan '$tingkatan' AND t.id_tagihan $kondisi_tagihan $id_tagihan AND DATE(p.tgl) BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.id_pembayaran DESC");
            }
        }
        $data['title'] = 'Laporan Riwayat';
        $data['tahun'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get();
        $data['tagihan'] = $this->db->select('*')->from('tb_tagihan')->order_by('tagihan','asc')->get();
        $data['submit'] = $this->input->post('submit', TRUE);
        $data['id_tahunpelajaran'] = $this->input->post('id_tahunpelajaran', TRUE);
        $data['tingkatan'] = $this->input->post('tingkatan', TRUE);
		$data['id_tagihan'] = $this->input->post('id_tagihan', TRUE);
		$data['tgl_awal'] = $this->input->post('tgl_awal', TRUE);
		$data['tgl_akhir'] = $this->input->post('tgl_akhir', TRUE);
        $this->template->admin('backend/dashboard','laporan/laporan_riwayat',$data);
    }

    function cetak_laporan_riwayat_pdf()
	{	
        $id_tahunpelajaran = $this->uri->segment('3');
		$tingkatan = $this->uri->segment('4');
		$id_tagihan = $this->uri->segment('5');
		$tgl_awal = $this->uri->segment('6');
        $tgl_akhir = $this->uri->segment('7');

        if($tingkatan != '0')
        {
            $kondisi_tingkatan = '=';
            $tingkatan = $tingkatan;
        }else
        {
            $kondisi_tingkatan = '!=';
            $tingkatan = 0;
        }

        if($id_tagihan != '0')
        {
            $kondisi_tagihan = '=';
            $id_tagihan = $id_tagihan;
        }else
        {
            $kondisi_tagihan = '!=';
            $id_tagihan = 0;
        }
        
        $data['riwayat'] = $this->db->query("SELECT p.*,s.*,tb.keterangan,t.*,th.id_tagihan,th.id_semester,th.id_tahunpelajaran,u.nama AS nama_petugas,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran,kw.id_kelas,k.kelas,k.tingkat
        FROM tb_pembayaran p 
        LEFT JOIN tb_siswa s ON p.id_siswa=s.id_siswa 
        LEFT JOIN tb_tagihan_tahunan th ON p.id_tagihan_tahunan=th.id_tagihan_tahunan 
        LEFT JOIN tb_tagihan t ON th.id_tagihan=t.id_tagihan 
        LEFT JOIN tb_tabungan tb ON p.id_pembayaran=tb.id_pembayaran 
        LEFT JOIN tb_user u ON p.id_user=u.id_user 
        LEFT JOIN tb_kelas_siswa ks ON p.id_siswa=ks.id_siswa
        LEFT JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali
        LEFT JOIN tb_kelas k ON kw.id_kelas=k.id_kelas
        WHERE kw.id_tahunpelajaran = $id_tahunpelajaran AND k.tingkat $kondisi_tingkatan '$tingkatan' AND t.id_tagihan $kondisi_tagihan $id_tagihan AND DATE(p.tgl) BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.id_pembayaran DESC");

        $this->load->library('pdfgenerator');
        $data['id_tahunpelajaran'] = $id_tahunpelajaran;
        $data['tingkatan'] = $tingkatan;
		$data['id_tagihan'] = $id_tagihan;
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;
        $html = $this->load->view('laporan/cetak_riwayat_pdf', $data, true);
		$filename = 'cetak-laporan-riwayat-pembayaran';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
    }

    function cetak_laporan_riwayat()
	{
        $id_tahunpelajaran = $this->uri->segment('3');
		$tingkatan = $this->uri->segment('4');
		$id_tagihan = $this->uri->segment('5');
		$tgl_awal = $this->uri->segment('6');
        $tgl_akhir = $this->uri->segment('7');

        if($tingkatan != '0')
        {
            $kondisi_tingkatan = '=';
            $tingkatan = $tingkatan;
        }else
        {
            $kondisi_tingkatan = '!=';
            $tingkatan = 0;
        }

        if($id_tagihan != '0')
        {
            $kondisi_tagihan = '=';
            $id_tagihan = $id_tagihan;
        }else
        {
            $kondisi_tagihan = '!=';
            $id_tagihan = 0;
        }
        
        $data['riwayat'] = $this->db->query("SELECT p.*,s.*,tb.keterangan,t.*,th.id_tagihan,th.id_semester,th.id_tahunpelajaran,u.nama AS nama_petugas,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran,kw.id_kelas,k.kelas,k.tingkat
        FROM tb_pembayaran p 
        LEFT JOIN tb_siswa s ON p.id_siswa=s.id_siswa 
        LEFT JOIN tb_tagihan_tahunan th ON p.id_tagihan_tahunan=th.id_tagihan_tahunan 
        LEFT JOIN tb_tagihan t ON th.id_tagihan=t.id_tagihan 
        LEFT JOIN tb_tabungan tb ON p.id_pembayaran=tb.id_pembayaran 
        LEFT JOIN tb_user u ON p.id_user=u.id_user 
        LEFT JOIN tb_kelas_siswa ks ON p.id_siswa=ks.id_siswa
        LEFT JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali
        LEFT JOIN tb_kelas k ON kw.id_kelas=k.id_kelas
        WHERE kw.id_tahunpelajaran = $id_tahunpelajaran AND k.tingkat $kondisi_tingkatan '$tingkatan' AND t.id_tagihan $kondisi_tagihan $id_tagihan AND DATE(p.tgl) BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.id_pembayaran DESC");

        $data['id_tahunpelajaran'] = $id_tahunpelajaran;
        $data['tingkatan'] = $tingkatan;
		$data['id_tagihan'] = $id_tagihan;
		$data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $this->load->view('laporan/cetak_riwayat',$data);
    }

    function cetak_laporan_riwayat_excel()
	{
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator('MAN 3 KEBUMEN')
            ->setLastModifiedBy('MAN 3 KEBUMEN')
            ->setTitle("DATA LAPORAN RIWAYAT PEMBAYARAN")
            ->setSubject("DATA LAPORAN RIWAYAT PEMBAYARAN")
            ->setDescription("DATA LAPORAN RIWAYAT PEMBAYARAN")
            ->setKeywords("DATA LAPORAN RIWAYAT PEMBAYARAN");

		$style_col = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FFFFFF')
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '1F497D')
			)
		);

        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
            )
        );

		$style_isi_tengah = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
            )
		);

		$style_isi_kiri = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
            )
		);

        $id_tahunpelajaran = $this->uri->segment('3');
		$tingkatan = $this->uri->segment('4');
		$id_tagihan = $this->uri->segment('5');
		$tgl_awal = $this->uri->segment('6');
        $tgl_akhir = $this->uri->segment('7');

        if($tingkatan != '0')
        {
            $kondisi_tingkatan = '=';
            $tingkatan = $tingkatan;
            $jenis_tingkatan = $tingkatan;
        }else
        {
            $kondisi_tingkatan = '!=';
            $tingkatan = 0;
            $jenis_tingkatan = 'SEMUA TINGKATAN';
        }

        if($id_tagihan != '0')
        {
            $kondisi_tagihan = '=';
            $id_tagihan = $id_tagihan;
            $jenis_tagihan = tagihan($id_tagihan);
        }else
        {
            $kondisi_tagihan = '!=';
            $id_tagihan = 0;
            $jenis_tagihan = 'SEMUA TAGIHAN';
        }

        if($tgl_awal != $tgl_akhir)
        { 
            $tgl_cari = date('d-m-Y', strtotime($tgl_awal)).' s.d. '.date('d-m-Y', strtotime($tgl_akhir));
        }else
        {
            $tgl_cari = date('d-m-Y', strtotime($tgl_awal));
        }
        
        $data = $this->db->query("SELECT p.*,s.*,tb.keterangan,t.*,th.id_tagihan,th.id_semester,th.id_tahunpelajaran,u.nama AS nama_petugas,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran,kw.id_kelas,k.kelas,k.tingkat
        FROM tb_pembayaran p 
        LEFT JOIN tb_siswa s ON p.id_siswa=s.id_siswa 
        LEFT JOIN tb_tagihan_tahunan th ON p.id_tagihan_tahunan=th.id_tagihan_tahunan 
        LEFT JOIN tb_tagihan t ON th.id_tagihan=t.id_tagihan 
        LEFT JOIN tb_tabungan tb ON p.id_pembayaran=tb.id_pembayaran 
        LEFT JOIN tb_user u ON p.id_user=u.id_user 
        LEFT JOIN tb_kelas_siswa ks ON p.id_siswa=ks.id_siswa
        LEFT JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali
        LEFT JOIN tb_kelas k ON kw.id_kelas=k.id_kelas
        WHERE kw.id_tahunpelajaran = $id_tahunpelajaran AND k.tingkat $kondisi_tingkatan '$tingkatan' AND t.id_tagihan $kondisi_tagihan $id_tagihan AND DATE(p.tgl) BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.id_pembayaran DESC");
     
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('assets/img/logo_komite.png');
        $objDrawing->setOffsetY(9);
        //$objDrawing->setOffsetX(4.1);
        $objDrawing->setCoordinates('D1');
        $objDrawing->setHeight(60);
        $objDrawing->setWorksheet($excel->getActiveSheet());

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "KOMITE MADRASAH");
		$excel->getActiveSheet()->mergeCells('A2:H2');
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "MADRASAH ALIYAH NEGERI 3 KEBUMEN");
		$excel->getActiveSheet()->mergeCells('A3:H3');
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A4', "Jalan Pencil No. 47 Kutowinangun Telp. 0287-661119 Kode Pos 54313");
		$excel->getActiveSheet()->mergeCells('A4:H4');
		$excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->getActiveSheet()->getStyle('C5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

		$excel->setActiveSheetIndex(0)->setCellValue('A6', "LAPORAN RIWAYAT PEMBAYARAN");
        $excel->getActiveSheet()->mergeCells('A6:H6');
        $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

        $excel->setActiveSheetIndex(0)->setCellValue('A8', "Tahun Pelajaran");
        $excel->getActiveSheet()->mergeCells('A8:B8');
        $excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE); 
    
        $excel->setActiveSheetIndex(0)->setCellValue('C8', ": ".tahun($id_tahunpelajaran));
        
        $excel->setActiveSheetIndex(0)->setCellValue('A9', "Tingkatan");
        $excel->getActiveSheet()->mergeCells('A9:B9');
        $excel->getActiveSheet()->getStyle('A9')->getFont()->setBold(TRUE); 
    
        $excel->setActiveSheetIndex(0)->setCellValue('C9', ": $jenis_tingkatan");

        $excel->setActiveSheetIndex(0)->setCellValue('A10', "Tagihan");
        $excel->getActiveSheet()->mergeCells('A10:B10');
        $excel->getActiveSheet()->getStyle('A10')->getFont()->setBold(TRUE); 
    
        $excel->setActiveSheetIndex(0)->setCellValue('C10', ": $jenis_tagihan");

        $excel->setActiveSheetIndex(0)->setCellValue('A11', "Tanggal");
        $excel->getActiveSheet()->mergeCells('A11:B11');
        $excel->getActiveSheet()->getStyle('A11')->getFont()->setBold(TRUE); 
    
        $excel->setActiveSheetIndex(0)->setCellValue('C11', ": $tgl_cari");



		$excel->setActiveSheetIndex(0)->setCellValue('A13', "No"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B13', "Tanggal"); 
        $excel->setActiveSheetIndex(0)->setCellValue('C13', "Jumlah Setoran"); 
        $excel->setActiveSheetIndex(0)->setCellValue('D13', "NIS"); 
        $excel->setActiveSheetIndex(0)->setCellValue('E13', "Nama");
        $excel->setActiveSheetIndex(0)->setCellValue('F13', "Kelas"); 
		$excel->setActiveSheetIndex(0)->setCellValue('G13', "Keterangan");
        $excel->setActiveSheetIndex(0)->setCellValue('H13', "Petugas");

        $excel->getActiveSheet()->getStyle('A13')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B13')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C13')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D13')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E13')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F13')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G13')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H13')->applyFromArray($style_col);

        $no = 1; 
        $numrow = 14; 
        $jml_setoran = 0;
        foreach($data->result() as $r):
            $id_tahunpelajaran = id_tahunpelajaran_pemb($r->id_tagihan_tahunan);
            $tahun = tahun($id_tahunpelajaran);
            //$kelas = kelas_lap($r->id_siswa,$id_tahunpelajaran);
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

            $jml_setoran = $jml_setoran + $r->bayar;

            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, date('d-m-Y H:i:s', strtotime($r->tgl)));
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $r->bayar);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $r->nis);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $r->nama);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $r->kelas);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $keterangan);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $r->nama_petugas);

            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_isi_tengah);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_isi_kiri);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_isi_kiri);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_isi_kiri);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_isi_kiri);
            $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_isi_kiri);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_isi_kiri);
            $no++;
            $numrow++;
        endforeach;

        $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, "JUMLAH SETORAN");
        $excel->getActiveSheet()->mergeCells('A'.$numrow.':B'.$numrow);
        $excel->getActiveSheet()->getStyle('A'.$numrow)->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('A'.$numrow.':B'.$numrow)->applyFromArray($style_isi_tengah);

        $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $jml_setoran);
        $excel->getActiveSheet()->getStyle('C'.$numrow)->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('C'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);

        $excel->getActiveSheet()->mergeCells('D'.$numrow.':H'.$numrow);
        $excel->getActiveSheet()->getStyle('D'.$numrow.':H'.$numrow)->applyFromArray($style_isi_tengah);

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); 
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); 
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(50);  
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(40); 
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getActiveSheet(0)->setTitle("Laporan Riwayat Pembayaran");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Laporan Riwayat Pembayaran.xlsx"'); 
		header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');  
	}

    function laporan_persiswa()
	{	
		if($this->input->post('submit', TRUE) == 'Submit')
		{	
			$this->_validation_persiswa();
			if($this->form_validation->run() == TRUE)
			{ 
				$id_tahunpelajaran =  $this->db->escape_str($this->input->post('id_tahunpelajaran', TRUE));
				$id_kelas =  $this->db->escape_str($this->input->post('id_kelas', TRUE));
				$data['data'] = $this->db->query("SELECT ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,kw.id_tahunpelajaran,kw.id_kelas,k.kelas,s.nis,s.nama FROM tb_kelas_siswa ks JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali JOIN tb_kelas k ON kw.id_kelas=k.id_kelas JOIN tb_siswa s ON ks.id_siswa=s.id_siswa WHERE kw.id_tahunpelajaran=$id_tahunpelajaran AND kw.id_kelas=$id_kelas GROUP BY s.nis ORDER BY s.nis ASC");
			}
		}
		$data['title'] = 'Laporan Persiswa';
		$data['submit'] = $this->input->post('submit', TRUE);
		$data['tahun'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get();
        $data['kelas'] = $this->db->select('*')->from('tb_kelas')->order_by('kelas','asc')->get();
		$this->template->admin('backend/dashboard','laporan/laporan_persiswa',$data);
    }

    function cetak_laporan_persiswa($id_siswa)
	{
        $cek = $this->laporan_model->cek_siswa($id_siswa); 
		if(!$cek)
		{ 
			show_404(); 
        }else
        {   
            $data['siswa'] = siswa_sekarang($id_siswa);
            $data['pemb_sekaliselamanya'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>1]);
            $data['pemb_tiaptahun'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>2]);
            $data['pemb_bulanan'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>4]);
            $data['pemb_persiswa'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>5]);
            $data['pemb_kelulusan'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>6]);
            $data['bulan'] = $this->db->select('*')->from('tb_bulan')->order_by('id_bulan','asc')->get();
            $this->load->library('pdfgenerator');
            $html = $this->load->view('laporan/cetak_persiswa', $data, true);
            $filename = 'cetak-laporan-persiswa';
            $this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'potrait');	
        }
    }

    function laporan_kekurangan()
	{	
		if($this->input->post('submit', TRUE) == 'Submit')
		{
			$this->_validation_kekurangan();
			if($this->form_validation->run() == TRUE)
			{ 	
					
				$id_tahunpelajaran = $this->db->escape_str($this->input->post('id_tahunpelajaran', TRUE));
				$id_kelas = $this->db->escape_str($this->input->post('id_kelas', TRUE));
                $id_tagihan = $this->db->escape_str($this->input->post('id_tagihan', TRUE));
                $data['data'] = $this->db->query("SELECT ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,
					ks.id_semester,ks.bsm,kw.id_tahunpelajaran,kw.id_kelas,k.id_jurusan,k.kelas,k.tingkat,s.nis,s.nama FROM tb_kelas_siswa ks JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali JOIN tb_kelas k ON kw.id_kelas=k.id_kelas JOIN tb_siswa s ON ks.id_siswa=s.id_siswa WHERE kw.id_tahunpelajaran=$id_tahunpelajaran AND kw.id_kelas=$id_kelas GROUP BY s.nis ORDER BY s.nis ASC");
			}
		}
        $data['title'] = 'Laporan Kekurangan Per Tagihan';
        $data['submit'] = $this->input->post('submit', TRUE);
		$data['id_tahunpelajaran'] = $this->input->post('id_tahunpelajaran', TRUE);
		$data['id_kelas'] = $this->input->post('id_kelas', TRUE);
		$data['id_tagihan'] = $this->input->post('id_tagihan', TRUE);
        $data['tahun'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get();
        $data['kelas'] = $this->db->select('*')->from('tb_kelas')->order_by('kelas','asc')->get();
        $data['tagihan'] = $this->db->select('*')->from('tb_tagihan')->order_by('tagihan','asc')->get();
        $data['bulan'] = $this->db->select('*')->from('tb_bulan')->order_by('id_bulan','asc')->get();
		$this->template->admin('backend/dashboard','laporan/laporan_kekurangan',$data);
    }

    function cetak_laporan_kekurangan_pdf()
	{
        $id_tahunpelajaran = $this->uri->segment('3');
		$id_kelas = $this->uri->segment('4');
		$id_tagihan = $this->uri->segment('5');
		$cek = $this->laporan_model->cek_kekurangan($id_tahunpelajaran,$id_kelas,$id_tagihan); 
		if(!$cek)
		{ 
			show_404(); 
        }
        $data['pemb_bulanan'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>4]);
        $data['data'] = $this->db->query("SELECT ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,
        ks.id_semester,ks.bsm,kw.id_tahunpelajaran,kw.id_kelas,k.id_jurusan,k.kelas,k.tingkat,s.nis,s.nama FROM tb_kelas_siswa ks JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali JOIN tb_kelas k ON kw.id_kelas=k.id_kelas JOIN tb_siswa s ON ks.id_siswa=s.id_siswa WHERE kw.id_tahunpelajaran=$id_tahunpelajaran AND kw.id_kelas=$id_kelas GROUP BY s.nis ORDER BY s.nis ASC");
        $data['id_tahunpelajaran'] = $id_tahunpelajaran;
		$data['id_kelas'] = $id_kelas;
		$data['id_tagihan'] = $id_tagihan;
        $data['tahun'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get();
        $data['kelas'] = $this->db->select('*')->from('tb_kelas')->order_by('kelas','asc')->get();
        $data['tagihan'] = $this->db->select('*')->from('tb_tagihan')->order_by('tagihan','asc')->get();
        $data['bulan'] = $this->db->select('*')->from('tb_bulan')->order_by('id_bulan','asc')->get();
        $this->load->library('pdfgenerator');
		$html = $this->load->view('laporan/cetak_kekurangan_pdf', $data, true);
		$filename = 'cetak-laporan-kekurangan';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
    }

    /*
    function cetak_laporan_kekurangan_excel()
	{
        $id_tahunpelajaran = $this->uri->segment('3');
		$id_kelas = $this->uri->segment('4');
		$id_tagihan = $this->uri->segment('5');
		$cek = $this->laporan_model->cek_kekurangan($id_tahunpelajaran,$id_kelas,$id_tagihan); 
		if(!$cek)
		{ 
			show_404(); 
        }else
        {
            include APPPATH.'third_party/PHPExcel/PHPExcel.php';
            $excel = new PHPExcel();

            $excel->getProperties()->setCreator('MAN 3 KEBUMEN')
                ->setLastModifiedBy('MAN 3 KEBUMEN')
                ->setTitle("DATA LAPORAN KEKURANGAN PEMBAYARAN PER TAGIHAN")
                ->setSubject("DATA LAPORAN KEKURANGAN PEMBAYARAN PER TAGIHAN")
                ->setDescription("DATA LAPORAN KEKURANGAN PEMBAYARAN PER TAGIHAN")
                ->setKeywords("DATA LAPORAN KEKURANGAN PEMBAYARAN PER TAGIHAN");

            $style_col = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => 'FFFFFF')
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
                ),
                'borders' => array(
                    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '1F497D')
                )
            );

            $style_row = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
                ),
                'borders' => array(
                    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
                )
            );

            $style_isi_tengah = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                'borders' => array(
                    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
                )
            );

            $style_isi_kiri = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
                ),
                'borders' => array(
                    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
                )
            );

            $tahun = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get();
            $kelas = $this->db->select('*')->from('tb_kelas')->order_by('kelas','asc')->get();
            $tagihan = $this->db->select('*')->from('tb_tagihan')->order_by('tagihan','asc')->get();
            $bulan = $this->db->select('*')->from('tb_bulan')->order_by('id_bulan','asc')->get();
            
            $data = $this->db->query("SELECT ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,
            ks.id_semester,ks.bsm,kw.id_tahunpelajaran,kw.id_kelas,k.id_jurusan,k.kelas,k.tingkat,s.nis,s.nama FROM tb_kelas_siswa ks JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali JOIN tb_kelas k ON kw.id_kelas=k.id_kelas JOIN tb_siswa s ON ks.id_siswa=s.id_siswa WHERE kw.id_tahunpelajaran=$id_tahunpelajaran AND kw.id_kelas=$id_kelas GROUP BY s.nis ORDER BY s.nis ASC");

            $excel->setActiveSheetIndex(0)->setCellValue('A2', "KOMITE MADRASAH");
            $excel->getActiveSheet()->mergeCells('A2:H2');
            $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

            $excel->setActiveSheetIndex(0)->setCellValue('A3', "MADRASAH ALIYAH NEGERI 3 KEBUMEN");
            $excel->getActiveSheet()->mergeCells('A3:H3');
            $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $excel->setActiveSheetIndex(0)->setCellValue('A4', "Jalan Pencil No. 47 Kutowinangun Telp. 0287-661119 Kode Pos 54313");
            $excel->getActiveSheet()->mergeCells('A4:H4');
            $excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $excel->setActiveSheetIndex(0)->setCellValue('A6', "DATA LAPORAN KEKURANGAN PEMBAYARAN");
            $excel->getActiveSheet()->mergeCells('A6:H6');
            $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

            $excel->setActiveSheetIndex(0)->setCellValue('A8', "TAHUN PELAJARAN : ".tahun($id_tahunpelajaran).'          KELAS : '.kelas($id_kelas).'           TAGIHAN : '.tagihan($id_tagihan)); 
            $excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE);

            $excel->setActiveSheetIndex(0)->setCellValue('A9', "No"); 
            $excel->setActiveSheetIndex(0)->setCellValue('B9', "NIS"); 
            $excel->setActiveSheetIndex(0)->setCellValue('C9', "Nama"); 
            $excel->setActiveSheetIndex(0)->setCellValue('D9', "TP Sekarang"); 
            $excel->setActiveSheetIndex(0)->setCellValue('E9', "Kelas Sekarang"); 
            $excel->setActiveSheetIndex(0)->setCellValue('F9', "Tagihan");
            $excel->setActiveSheetIndex(0)->setCellValue('G9', "Biaya"); 
            $excel->setActiveSheetIndex(0)->setCellValue('H9', "Dibayar");
            $excel->setActiveSheetIndex(0)->setCellValue('I9', "Kurang");
            $excel->setActiveSheetIndex(0)->setCellValue('J9', "Status");

            $excel->getActiveSheet()->getStyle('A9')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B9')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C9')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D9')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E9')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F9')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('G9')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('H9')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('I9')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('J9')->applyFromArray($style_col);

            $no = 1; 
            $numrow = 10; 
            $biaya_akhir = 0;
            $sudah_dibayar_akhir = 0;
            $kurang_akhir = 0;
            foreach($data->result() as $r):
                
                if(id_jenistagihan($id_tagihan) == 1)
                { 
                    $cek = 0;
                    $tahun = tahun_ks($r->id_siswa);
                    foreach($tahun as $k):
                        $id_tahun_kelas10 = id_tahun_kelas10($r->id_siswa);
                        $id_tahun_kelas11 = id_tahun_kelas11($r->id_siswa);
                        $id_tahun_kelas12 = id_tahun_kelas12($r->id_siswa);

                        $cek_1 = biaya($id_tahun_kelas10,$id_tagihan,1,$r->bsm);
                        $cek_2 = biaya($id_tahun_kelas11,$id_tagihan,2,$r->bsm);
                        $cek_3 = biaya($id_tahun_kelas12,$id_tagihan,3,$r->bsm);

                        if($cek_1)
                        { 
                            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas10,$id_tagihan,0);
                            $biaya = biaya($id_tahun_kelas10,$id_tagihan,1,$r->bsm);
                            $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
                            $kurang = $biaya - $sudah_dibayar;
                            $cek++;

                            $biaya_akhir = $biaya_akhir + $biaya;
                            $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar;
                            $kurang_akhir = $kurang_akhir + $kurang;

                            if($kurang > 0)
                            {
                                $status = 'Belum Lunas';
                            }else
                            {
                                $status = 'Lunas';
                            }

                            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
                            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $r->nis);
                            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $r->nama);
                            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, tahun(id_tahunpelajaran_siswa($r->id_siswa)));
                            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, siswa_kelas($r->id_siswa));
                            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, strtoupper(tagihan($id_tagihan)).' ( TP '.tahun($id_tahun_kelas10).' KELAS X )');
                            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $biaya);
                            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sudah_dibayar);
                            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $kurang);
                            $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $status);
                            break;
                        }elseif($cek_2)
                        { 
                            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas11,$id_tagihan,0);
                            $biaya = biaya($id_tahun_kelas11,$id_tagihan,2,$r->bsm);
                            $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
                            $kurang = $biaya - $sudah_dibayar;
                            $cek++;
                    
                            $biaya_akhir = $biaya_akhir + $biaya;
                            $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar;
                            $kurang_akhir = $kurang_akhir + $kurang;
                    
                            if($kurang > 0)
                            {
                                $status = 'Belum Lunas';
                            }else
                            {
                                $status = 'Lunas';
                            }

                            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
                            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $r->nis);
                            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $r->nama);
                            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, tahun(id_tahunpelajaran_siswa($r->id_siswa)));
                            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, siswa_kelas($r->id_siswa));
                            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, strtoupper(tagihan($id_tagihan)).' ( TP '.tahun($id_tahun_kelas11).' KELAS XI )');
                            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $biaya);
                            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sudah_dibayar);
                            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $kurang);
                            $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $status);
                            break;
                        }elseif($cek_3)
                        { 
                            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahun_kelas12,$id_tagihan,0);
                            $biaya = biaya($id_tahun_kelas12,$id_tagihan,3,$r->bsm);
                            $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
                            $kurang = $biaya - $sudah_dibayar;
                            $cek++;
                    
                            $biaya_akhir = $biaya_akhir + $biaya;
                            $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar;
                            $kurang_akhir = $kurang_akhir + $kurang;
                    
                            if($kurang > 0)
                            {
                                $status = 'Belum Lunas';
                            }else
                            {
                                $status = 'Lunas';
                            }

                            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
                            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $r->nis);
                            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $r->nama);
                            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, tahun(id_tahunpelajaran_siswa($r->id_siswa)));
                            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, siswa_kelas($r->id_siswa));
                            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, strtoupper(tagihan($id_tagihan)).' ( TP '.tahun($id_tahun_kelas12).' KELAS XII )');
                            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $biaya);
                            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $sudah_dibayar);
                            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $kurang);
                            $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $status);
                            break;
                        }
                    endforeach;
                }elseif(id_jenistagihan($id_tagihan) == 2)
                { 
                    $ada = 0;
                    $kelas_siswa = kelas_siswa($r->id_siswa);
                    $lastRow = $numrow;
                    foreach($kelas_siswa as $k):
                        $cek = biaya($k->id_tahunpelajaran,$id_tagihan,tingkat($k->tingkat),$r->bsm);
                        if($cek)
                        {   
                            $ada++; 
                            $biaya = biaya($k->id_tahunpelajaran,$id_tagihan,tingkat($k->tingkat),$r->bsm);
                            $id_tagihan_tahunan = id_tagihan_tahunan($k->id_tahunpelajaran,$id_tagihan,0);
                            $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
                            $kurang = $biaya - $sudah_dibayar;

                            if($kurang > 0)
                            {
                                $status = 'Belum Lunas';
                            }else
                            {
                                $status = 'Lunas';
                            }

                            $lastRow = $lastRow + $excel->getActiveSheet()->getHighestRow();
                            
                            $excel->setActiveSheetIndex(0)->setCellValue('A'.$lastRow, $no);
                            $excel->setActiveSheetIndex(0)->setCellValue('B'.$lastRow, $r->nis);
                            $excel->setActiveSheetIndex(0)->setCellValue('C'.$lastRow, $r->nama);
                            $excel->setActiveSheetIndex(0)->setCellValue('D'.$lastRow, tahun(id_tahunpelajaran_siswa($r->id_siswa)));
                            $excel->setActiveSheetIndex(0)->setCellValue('E'.$lastRow, siswa_kelas($r->id_siswa));
                            $excel->setActiveSheetIndex(0)->setCellValue('F'.$lastRow, strtoupper(tagihan($id_tagihan)).' ( TP '.tahun($k->id_tahunpelajaran).' KELAS '.$k->tingkat.' )');
                            $excel->setActiveSheetIndex(0)->setCellValue('G'.$lastRow, $biaya);
                            $excel->setActiveSheetIndex(0)->setCellValue('H'.$lastRow, $sudah_dibayar);
                            $excel->setActiveSheetIndex(0)->setCellValue('I'.$lastRow, $kurang);
                            $excel->setActiveSheetIndex(0)->setCellValue('J'.$lastRow, $status);

                            $biaya_akhir = $biaya_akhir + $biaya;
                            $sudah_dibayar_akhir = $sudah_dibayar_akhir + $sudah_dibayar;
                            $kurang_akhir = $kurang_akhir + $kurang;
                        } 
                    endforeach;
                }elseif(id_jenistagihan($id_tagihan) == 3)
                { 
                    
                }elseif(id_jenistagihan($id_tagihan) == 4)
                { 
                    
                }elseif(id_jenistagihan($id_tagihan) == 6)
                { 
                    if($r->tingkat == 'XII')
                    {
                        
                    }
                }

                $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_isi_tengah);
                $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_isi_kiri);
                $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_isi_tengah);
                $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
                $no++;
                $numrow++;
            endforeach;

            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); 
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(50); 
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);  
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('J')->setWidth(15); 
            $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getActiveSheet(0)->setTitle("Laporan Kekurangan Pembayaran");
            $excel->setActiveSheetIndex(0);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Data Laporan Kekurangan Pembayaran Per Tagihan.xlsx"'); 
            header('Cache-Control: max-age=0');
            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
        }  
	}
*/
    function cetak_laporan_kekurangan()
	{
        $id_tahunpelajaran = $this->uri->segment('3');
		$id_kelas = $this->uri->segment('4');
		$id_tagihan = $this->uri->segment('5');
		$cek = $this->laporan_model->cek_kekurangan($id_tahunpelajaran,$id_kelas,$id_tagihan); 
		if(!$cek)
		{ 
			show_404(); 
        }
        $data['pemb_bulanan'] = $this->db->get_where('tb_tagihan',['id_jenistagihan'=>4]);
        $data['data'] = $this->db->query("SELECT ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,
        ks.id_semester,ks.bsm,kw.id_tahunpelajaran,kw.id_kelas,k.id_jurusan,k.kelas,k.tingkat,s.nis,s.nama FROM tb_kelas_siswa ks JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali JOIN tb_kelas k ON kw.id_kelas=k.id_kelas JOIN tb_siswa s ON ks.id_siswa=s.id_siswa WHERE kw.id_tahunpelajaran=$id_tahunpelajaran AND kw.id_kelas=$id_kelas GROUP BY s.nis ORDER BY s.nis ASC");
        $data['id_tahunpelajaran'] = $id_tahunpelajaran;
		$data['id_kelas'] = $id_kelas;
		$data['id_tagihan'] = $id_tagihan;
        $data['tahun'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get();
        $data['kelas'] = $this->db->select('*')->from('tb_kelas')->order_by('kelas','asc')->get();
        $data['tagihan'] = $this->db->select('*')->from('tb_tagihan')->order_by('tagihan','asc')->get();
        $data['bulan'] = $this->db->select('*')->from('tb_bulan')->order_by('id_bulan','asc')->get();
        $this->load->view('laporan/cetak_kekurangan',$data);
    }

    function laporan_semua_kekurangan()
	{	
        $id_tahunpelajaran = $this->db->escape_str($this->input->post('id_tahunpelajaran', TRUE));
        $id_kelas = $this->db->escape_str($this->input->post('id_kelas', TRUE));
		if($this->input->post('submit', TRUE) == 'Submit')
		{
			$this->_validation_semua_kekurangan();
			if($this->form_validation->run() == TRUE)
			{ 	
                $data['data'] = $this->db->query("SELECT ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,ks.bsm,kw.id_tahunpelajaran,kw.id_kelas,k.id_jurusan,k.kelas,k.tingkat,s.nis,s.nama FROM tb_kelas_siswa ks JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali JOIN tb_kelas k ON kw.id_kelas=k.id_kelas JOIN tb_siswa s ON ks.id_siswa=s.id_siswa WHERE kw.id_tahunpelajaran=$id_tahunpelajaran AND kw.id_kelas=$id_kelas GROUP BY s.nis ORDER BY s.nis ASC");
			}
		}
        $data['title'] = 'Laporan Kekurangan Semua Tagihan';
        $data['pemb_sekaliselamanya'] = $this->laporan_model->pemb_sekaliselamanya($id_tahunpelajaran, $id_kelas);
        $data['pemb_tiaptahun'] = $this->laporan_model->pemb_tiaptahun($id_tahunpelajaran, $id_kelas);
        $data['pemb_bulanan'] = $this->laporan_model->pemb_bulanan($id_tahunpelajaran, $id_kelas);
        $data['pemb_kelulusan'] = $this->laporan_model->pemb_kelulusan($id_tahunpelajaran, $id_kelas);
        $data['submit'] = $this->input->post('submit', TRUE);
	  	$data['id_tahunpelajaran'] = $this->input->post('id_tahunpelajaran', TRUE);
		$data['id_kelas'] = $this->input->post('id_kelas', TRUE);
		$data['tahun'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get();
        $data['kelas'] = $this->db->select('*')->from('tb_kelas')->order_by('kelas','asc')->get();
        $data['bulan'] = $this->db->select('*')->from('tb_bulan')->order_by('id_bulan','asc')->get();
        $this->template->admin('backend/dashboard','laporan/laporan_semua_kekurangan',$data);
    }

    function cetak_laporan_semua_kekurangan_pdf()
	{
        $id_tahunpelajaran = $this->uri->segment('3');
		$id_kelas = $this->uri->segment('4');
		$cek = $this->laporan_model->cek_semua_kekurangan($id_tahunpelajaran,$id_kelas); 
		if(!$cek)
		{ 
			show_404(); 
        }else
        {
            $data['data'] = $this->db->query("SELECT ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,ks.bsm,kw.id_tahunpelajaran,kw.id_kelas,k.id_jurusan,k.kelas,k.tingkat,s.nis,s.nama FROM tb_kelas_siswa ks JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali JOIN tb_kelas k ON kw.id_kelas=k.id_kelas JOIN tb_siswa s ON ks.id_siswa=s.id_siswa WHERE kw.id_tahunpelajaran=$id_tahunpelajaran AND kw.id_kelas=$id_kelas GROUP BY s.nis ORDER BY s.nis ASC");    
        }
        $data['pemb_sekaliselamanya'] = $this->laporan_model->pemb_sekaliselamanya($id_tahunpelajaran, $id_kelas);
        $data['pemb_tiaptahun'] = $this->laporan_model->pemb_tiaptahun($id_tahunpelajaran, $id_kelas);
        $data['pemb_bulanan'] = $this->laporan_model->pemb_bulanan($id_tahunpelajaran, $id_kelas);
        $data['pemb_kelulusan'] = $this->laporan_model->pemb_kelulusan($id_tahunpelajaran, $id_kelas);
        $data['id_tahunpelajaran'] = $id_tahunpelajaran;
		$data['id_kelas'] = $id_kelas;
		$data['tahun'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get();
        $data['kelas'] = $this->db->select('*')->from('tb_kelas')->order_by('kelas','asc')->get();
        $data['bulan'] = $this->db->select('*')->from('tb_bulan')->order_by('id_bulan','asc')->get();
        $this->load->library('pdfgenerator');
		$html = $this->load->view('laporan/cetak_semua_kekurangan_pdf', $data, true);
		$filename = 'cetak-laporan-semua-kekurangan';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
    }

    function cetak_laporan_semua_kekurangan_excel()
	{
        $id_tahunpelajaran = $this->uri->segment('3');
        $id_kelas = $this->uri->segment('4');
        $cek = $this->laporan_model->cek_semua_kekurangan($id_tahunpelajaran,$id_kelas); 
		if(!$cek)
		{ 
			show_404(); 
        }else
        {
            include APPPATH.'third_party/PHPExcel/PHPExcel.php';
            $excel = new PHPExcel();

            $excel->getProperties()->setCreator('MAN 3 KEBUMEN')
                ->setLastModifiedBy('MAN 3 KEBUMEN')
                ->setTitle("DATA LAPORAN KEKURANGAN PEMBAYARAN")
                ->setSubject("DATA LAPORAN KEKURANGAN PEMBAYARAN")
                ->setDescription("DATA LAPORAN KEKURANGAN PEMBAYARAN")
                ->setKeywords("DATA LAPORAN KEKURANGAN PEMBAYARAN");

            $style_col = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => 'FFFFFF')
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
                ),
                'borders' => array(
                    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '1F497D')
                )
            );

            $style_row = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
                ),
                'borders' => array(
                    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
                )
            );

            $style_isi_tengah = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                'borders' => array(
                    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
                )
            );

            $style_isi_kiri = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
                ),
                'borders' => array(
                    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
                )
            );

            $data = $this->db->query("SELECT ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,ks.bsm,kw.id_tahunpelajaran,kw.id_kelas,k.id_jurusan,k.kelas,k.tingkat,s.nis,s.nama FROM tb_kelas_siswa ks JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali JOIN tb_kelas k ON kw.id_kelas=k.id_kelas JOIN tb_siswa s ON ks.id_siswa=s.id_siswa WHERE kw.id_tahunpelajaran=$id_tahunpelajaran AND kw.id_kelas=$id_kelas GROUP BY s.nis ORDER BY s.nis ASC");  
            $pemb_sekaliselamanya = $this->laporan_model->pemb_sekaliselamanya($id_tahunpelajaran, $id_kelas);
            $pemb_tiaptahun = $this->laporan_model->pemb_tiaptahun($id_tahunpelajaran, $id_kelas);
            $pemb_bulanan = $this->laporan_model->pemb_bulanan($id_tahunpelajaran, $id_kelas);
            $pemb_kelulusan = $this->laporan_model->pemb_kelulusan($id_tahunpelajaran, $id_kelas);

            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath('assets/img/logo_komite.png');
            $objDrawing->setOffsetY(9);
            //$objDrawing->setOffsetX(4.1);
            $objDrawing->setCoordinates('C1');
            $objDrawing->setHeight(60);
            $objDrawing->setWorksheet($excel->getActiveSheet());

            $excel->setActiveSheetIndex(0)->setCellValue('A2', "KOMITE MADRASAH");
            $excel->getActiveSheet()->mergeCells('A2:H2');
            $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

            $excel->setActiveSheetIndex(0)->setCellValue('A3', "MADRASAH ALIYAH NEGERI 3 KEBUMEN");
            $excel->getActiveSheet()->mergeCells('A3:H3');
            $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $excel->setActiveSheetIndex(0)->setCellValue('A4', "Jalan Pencil No. 47 Kutowinangun Telp. 0287-661119 Kode Pos 54313");
            $excel->getActiveSheet()->mergeCells('A4:H4');
            $excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $excel->getActiveSheet()->getStyle('C5:F5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

            $excel->setActiveSheetIndex(0)->setCellValue('A6', "DATA LAPORAN KEKURANGAN PEMBAYARAN");
            $excel->getActiveSheet()->mergeCells('A6:H6');
            $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

            $excel->setActiveSheetIndex(0)->setCellValue('A8', "TAHUN PELAJARAN : ".tahun($id_tahunpelajaran).'          KELAS : '.kelas($id_kelas)); 
            $excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE);

            $excel->setActiveSheetIndex(0)->setCellValue('A9', "No"); 
            $excel->setActiveSheetIndex(0)->setCellValue('B9', "NIS"); 
            $excel->setActiveSheetIndex(0)->setCellValue('C9', "Nama"); 

            $huruf = 'D';
            $huruf_ada = [];
            foreach($pemb_sekaliselamanya as $p):
                $excel->setActiveSheetIndex(0)->setCellValue($huruf.'9', $p->tagihan);
                $huruf_ada[] = $huruf;
                $huruf++;
            endforeach;

            foreach($pemb_tiaptahun as $p):
                $excel->setActiveSheetIndex(0)->setCellValue($huruf.'9', $p->tagihan);
                $huruf_ada[] = $huruf;
                $huruf++;
            endforeach;

            foreach($pemb_bulanan as $p):
                if($p->id_tagihan == 1 AND $id_tahunpelajaran == 19)
                {
                    
                }else
                {
                    $excel->setActiveSheetIndex(0)->setCellValue($huruf.'9', $p->tagihan);
                    $huruf_ada[] = $huruf;
                    $huruf++;
                }
            endforeach;

            foreach($pemb_kelulusan as $p):
                $excel->setActiveSheetIndex(0)->setCellValue($huruf.'9', $p->tagihan);
                $huruf_ada[] = $huruf;
                $huruf++;
            endforeach;

            $excel->setActiveSheetIndex(0)->setCellValue($huruf.'9', 'Jumlah');

            $excel->getActiveSheet()->getStyle('A9')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B9')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C9')->applyFromArray($style_col);
            foreach($huruf_ada as $r)
            {
                $excel->getActiveSheet()->getStyle($r.'9')->applyFromArray($style_col);
            }

            $excel->getActiveSheet()->getStyle($huruf.'9')->applyFromArray($style_col);

            $no = 1; 
            $numrow = 10; 
            foreach($data->result() as $r):
                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $r->nis);
                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $r->nama);

                $huruf_isi = 'D';
                $jml_kurang = 0;

                foreach($pemb_sekaliselamanya as $p):
                    $cek = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                    if($cek)
                    {   
                        $id_tagihan_tahunan = id_tagihan_tahunan($id_tahunpelajaran,$p->id_tagihan,0);
                        $biaya = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                        $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
                        $kurang = $biaya - $sudah_dibayar;
                        $jml_kurang = $jml_kurang + $kurang;
                        $excel->setActiveSheetIndex(0)->setCellValue($huruf_isi.$numrow, $kurang);
                        $huruf_isi++;
                    }
                endforeach;

                foreach($pemb_tiaptahun as $p):
                    $cek = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                    if($cek)
                    {   
                        $id_tagihan_tahunan = id_tagihan_tahunan($id_tahunpelajaran,$p->id_tagihan,0);
                        $biaya = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                        $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
                        $kurang = $biaya - $sudah_dibayar;
                        $jml_kurang = $jml_kurang + $kurang;
                        $excel->setActiveSheetIndex(0)->setCellValue($huruf_isi.$numrow, $kurang);
                        $huruf_isi++;
                    }
                endforeach;

                foreach($pemb_bulanan as $p):
                    $cek = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                    if($cek)
                    {   
                        if($p->id_tagihan AND $id_tahunpelajaran == 19)
                        {

                        }else
                        {
                            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahunpelajaran,$p->id_tagihan,0);
                            $biaya = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                            $biaya_hasil = $biaya * 12;
                            $sudah_dibayar_hasil = 0;
                            foreach($bulan->result() as $b):
                                $sudah_dibayar = sudah_dibayar_bulanan($id_tagihan_tahunan,$b->id_bulan,$r->id_siswa);
                                $sudah_dibayar_hasil = $sudah_dibayar_hasil + $sudah_dibayar;
                            endforeach;
                            $kurang = $biaya_hasil - $sudah_dibayar_hasil;
                            $jml_kurang = $jml_kurang + $kurang;
                            $excel->setActiveSheetIndex(0)->setCellValue($huruf_isi.$numrow, $kurang); 
                            $huruf_isi++;
                        }
                    }
                endforeach;

                if(tingkat_kelas($id_kelas) == 'XII')
                {
                    foreach($pemb_kelulusan as $p):
                        $cek = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                        if($cek)
                        {   
                            $id_tagihan_tahunan = id_tagihan_tahunan($id_tahunpelajaran,$p->id_tagihan,0);
                            $biaya = biaya($id_tahunpelajaran,$p->id_tagihan,tingkat(tingkat_kelas($id_kelas)),$r->bsm);
                            $sudah_dibayar = sudah_dibayar($id_tagihan_tahunan, $r->id_siswa);
                            $kurang = $biaya - $sudah_dibayar;
                            $jml_kurang = $jml_kurang + $kurang;
                            $excel->setActiveSheetIndex(0)->setCellValue($huruf_isi.$numrow, $kurang);
                            $huruf_isi++;
                        }
                    endforeach;
                }

                $excel->setActiveSheetIndex(0)->setCellValue($huruf_isi.$numrow, $jml_kurang);

                $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_isi_tengah);
                $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_isi_kiri);
                $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                foreach($huruf_ada as $r)
                {
                    $excel->getActiveSheet()->getStyle($r.$numrow)->applyFromArray($style_row);
                }

                $excel->getActiveSheet()->getStyle($huruf.$numrow)->applyFromArray($style_row);
            
                $no++;
                $numrow++;
            endforeach;

            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
            foreach($huruf_ada as $r)
            {
                $excel->getActiveSheet()->getColumnDimension($r)->setWidth(25); 
            }
            $excel->getActiveSheet()->getColumnDimension($huruf)->setWidth(25); 
            
            $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getActiveSheet(0)->setTitle("Laporan Kekurangan Pembayaran");
            $excel->setActiveSheetIndex(0);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Data Laporan Kekurangan Pembayaran.xlsx"'); 
            header('Cache-Control: max-age=0');
            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');  
        }
	}

    function cetak_laporan_semua_kekurangan()
	{
        $id_tahunpelajaran = $this->uri->segment('3');
		$id_kelas = $this->uri->segment('4');
		$cek = $this->laporan_model->cek_semua_kekurangan($id_tahunpelajaran,$id_kelas); 
		if(!$cek)
		{ 
			show_404(); 
        }else
        {
            $data['data'] = $this->db->query("SELECT ks.id_kelas_siswa,ks.id_siswa,ks.id_kelas_wali,ks.id_semester,ks.bsm,kw.id_tahunpelajaran,kw.id_kelas,k.id_jurusan,k.kelas,k.tingkat,s.nis,s.nama FROM tb_kelas_siswa ks JOIN tb_kelas_wali kw ON ks.id_kelas_wali=kw.id_kelas_wali JOIN tb_kelas k ON kw.id_kelas=k.id_kelas JOIN tb_siswa s ON ks.id_siswa=s.id_siswa WHERE kw.id_tahunpelajaran=$id_tahunpelajaran AND kw.id_kelas=$id_kelas GROUP BY s.nis ORDER BY s.nis ASC");    
        }
        $data['pemb_sekaliselamanya'] = $this->laporan_model->pemb_sekaliselamanya($id_tahunpelajaran, $id_kelas);
        $data['pemb_tiaptahun'] = $this->laporan_model->pemb_tiaptahun($id_tahunpelajaran, $id_kelas);
        $data['pemb_bulanan'] = $this->laporan_model->pemb_bulanan($id_tahunpelajaran, $id_kelas);
        $data['pemb_kelulusan'] = $this->laporan_model->pemb_kelulusan($id_tahunpelajaran, $id_kelas);
        $data['id_tahunpelajaran'] = $id_tahunpelajaran;
		$data['id_kelas'] = $id_kelas;
		$data['tahun'] = $this->db->select('*')->from('tb_tahunpelajaran')->order_by('tahunpelajaran','desc')->get();
        $data['kelas'] = $this->db->select('*')->from('tb_kelas')->order_by('kelas','asc')->get();
        $data['bulan'] = $this->db->select('*')->from('tb_bulan')->order_by('id_bulan','asc')->get();
        $this->load->view('laporan/cetak_semua_kekurangan',$data);
    }

    private function _validation_riwayat()
    {
        $this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
        $this->form_validation->set_rules('tingkatan', ' Tingkatan', 'required');
        $this->form_validation->set_rules('id_tagihan', ' Tagihan', 'required');
        $this->form_validation->set_rules('tgl_awal', '	Tanggal Awal', 'required');
        $this->form_validation->set_rules('tgl_akhir', 'Tanggal Akhir', 'required');
    }
    
    private function _validation_persiswa()
    {
        $this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
        $this->form_validation->set_rules('id_tahunpelajaran', 'Tahun Pelajaran', 'required|numeric');
        $this->form_validation->set_rules('id_kelas', ' Kelas', 'required|numeric');
	}
	
	private function _validation_kekurangan()
    {
        $this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
		$this->form_validation->set_rules('id_tahunpelajaran', 'Tahun Pelajaran', 'required|numeric');
		$this->form_validation->set_rules('id_kelas', 'Kelas', 'required|numeric');
		$this->form_validation->set_rules('id_tagihan', 'Tagihan', 'required|numeric');
    }

    private function _validation_semua_kekurangan()
    {
        $this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
		$this->form_validation->set_rules('id_tahunpelajaran', 'Tahun Pelajaran', 'required|numeric');
		$this->form_validation->set_rules('id_kelas', 'Kelas', 'required|numeric');
    }

}