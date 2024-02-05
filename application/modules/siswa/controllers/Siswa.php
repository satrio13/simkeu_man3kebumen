<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Siswa extends CI_Controller {
	private $filename = "import_data";
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model(array('siswa_model','import_siswa_model'));
    } 

    function index()
	{	
		$data['title'] = 'Siswa';
        $this->template->admin('backend/dashboard','siswa/siswa',$data);
    }

    function get_data_siswa()
	{
		$list = $this->siswa_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{	
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $r->nis;
			$row[] = $r->nama;
			$action = '<div class="text-center">
						<a href="'.base_url("backend/edit-siswa/$r->id_siswa").'" class="btn btn-dark btn-xs btn-flat" title="EDIT DATA">EDIT</a>
						<a href="javascript:void(0)" class="btn btn-danger btn-xs btn-flat text-white" data-toggle="modal" data-target="#konfirmasi_hapus" 
						data-href="'.base_url("backend/hapus-siswa/$r->id_siswa").'" title="HAPUS DATA">HAPUS</a>
					  </div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->siswa_model->count_all(),
			"recordsFiltered" => $this->siswa_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    } 
    
    function tambah_siswa()
	{ 
		if($this->input->post('submit', TRUE)=='Submit')
        {  
        	$this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
			$this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
			$this->form_validation->set_rules('nis', 'NIS', 'required|is_unique[tb_siswa.nis]', [
				'is_unique' => 'NIS sudah ada!'
			]);
		    if($this->form_validation->run() == TRUE)
            { 
				$this->siswa_model->tambah_siswa();
			}
		}
        $data['title'] = 'Tambah Siswa';
		$this->template->admin('backend/dashboard','siswa/form_tambah_siswa', $data);
    }

    function edit_siswa($id_siswa)
	{ 	
		$cek = $this->siswa_model->cek_siswa($id_siswa); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			if($this->input->post('submit', TRUE)=='Submit')
        	{ 
				$this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
                $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
                $this->form_validation->set_rules('nis', 'NIS', 'required|callback_cek_nis['.$id_siswa.']');
                if($this->form_validation->run() == TRUE)
				{
					$this->siswa_model->edit_siswa($id_siswa);
				}
			}
			$data['title'] = 'Edit Siswa';
            $data['data'] = $this->db->get_where('tb_siswa',['id_siswa'=>$id_siswa])->row();
        	$this->template->admin('backend/dashboard','siswa/form_edit_siswa', $data);
		}
    }

    function cek_nis($nis = '', $id_siswa = '')
    {	
        $cek = $this->db->select('*')->from('tb_siswa')->where('nis',$nis)->where('id_siswa != ',$id_siswa)->get()->num_rows();
        if($cek)
        {
			$this->form_validation->set_message('cek_nis', 'NIS sudah ada');
			return FALSE;
        }else
        {
			return TRUE;
		}
	}

	function cek_siswa_batch()
	{
		$jml = $this->input->post('brp',TRUE);
		if(!isset($jml))
		{
			redirect('backend/siswa');
		}else
		{
			redirect("backend/siswa-batch/$jml");
		}
	}

	function siswa_batch($jml)
	{	
		if(!isset($jml))
		{
			redirect('backend/siswa');
		}
        if($jml > 0 AND $jml < 50 AND $jml != '')
        {
            if($this->input->post('submit', TRUE)=='Submit')
		    {   
                $this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
                for($i=1; $i<=$jml; $i++)
                {
					$this->form_validation->set_rules("nama[$i]", 'Nama Lengkap', 'required');
					$this->form_validation->set_rules("nis[$i]", 'NIS', 'required|is_unique[tb_siswa.nis]', [
						'is_unique' => 'NIS sudah ada!'
					]);
                }

                if($this->form_validation->run() == TRUE)
                {                 
                    $sukses = 0;
			        $gagal = 0;
                    for($i=1; $i<=$jml; $i++)
                    {
                        $data_insert = [           
							'nama' => strip_tags($this->input->post("nama[$i]", TRUE)),
							'nis' => strip_tags($this->input->post("nis[$i]", TRUE))
                        ]; 
                        
                        $this->db->insert('tb_siswa',$data_insert);
                        $sukses ++;
                    }

					if($this->db->affected_rows() > 0)
					{ 
                        $msg = '<div class="alert alert-light border border-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <div class="text-success text-bold">'.$sukses.' DATA BERHASIL DITAMBAHKAN</div>
                                    <div class="text-danger text-bold">'.$gagal.' DATA GAGAL DITAMBAHKAN</div>
                                </div>';
                        $this->session->set_flashdata('msg-tr-siswa', "$msg");
					}else
					{
                        $this->session->set_flashdata('msg-gagal-siswa', 'DATA GAGAL DITAMBAHKAN!');
                    }
                    redirect('backend/siswa');
                }
            }
		}else
		{
            redirect('backend/siswa');
        }
        $data['jml'] = $jml;
		$data['title'] = 'Tambah Siswa';
  		$this->template->admin('backend/dashboard','siswa/form_siswa_batch', $data);
	}

	function form_siswa()
	{ 
		$data = array(); // Buat variabel $data sebagai array
		if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
		// lakukan upload file dengan memanggil function upload yang ada di import_model.php
			$upload = $this->import_siswa_model->upload_file($this->filename.'-'.$this->session->userdata('id_user'));
			if($upload['result'] == "success"){ // Jika proses upload sukses
				// Load plugin PHPExcel nya
				include APPPATH.'third_party/PHPExcel/PHPExcel.php';
				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('excel/siswa/'.$this->filename.'-'.$this->session->userdata('id_user').'.xlsx'); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
				// Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
				// Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
				$data['sheet'] = $sheet; 
			}else{ // Jika proses upload gagal
				$data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
			}
		}
		$data['title']='Import Data Siswa';
		$this->template->admin('backend/dashboard','siswa/form_siswa',$data);
	}

	function import_siswa()
	{
		if($this->input->post('import') == 'Import')
		{	
			// Load plugin PHPExcel nya
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			date_default_timezone_set('Asia/Jakarta');
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('excel/siswa/'.$this->filename.'-'.$this->session->userdata('id_user').'.xlsx'); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			// Array baru untuk menyimpan data unik berdasarkan 'nis'
			$uniqueData = [];
			// Loop melalui data yang diberikan
			foreach($sheet as $item)
			{
				// Gunakan 'nis' sebagai kunci array
				$nis = $item['B'];
				// Jika 'nis' belum ada dalam array $uniqueData, tambahkan data tersebut
				if(!isset($uniqueData[$nis]))
				{
					$uniqueData[$nis] = $item;
				}
			}

			// Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
			$data = array();
			$numrow = 1;
			foreach($uniqueData as $row){
			  // Cek $numrow apakah lebih dari 1
			  // Artinya karena baris pertama adalah nama-nama kolom
			  // Jadi dilewat saja, tidak usah diimport
			  if($numrow > 1){
				// Kita push (add) array data ke variabel data
				if( empty($row['A']) AND empty($row['B']) )
                {
                    break;
                }else
                {
					array_push($data, array(
					'nama'=>$row['A'],
					'nis'=>$row['B']
					));
				}
			  }
			  $numrow++; // Tambah 1 setiap kali looping
			}
	  
			// Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
			$this->import_siswa_model->insert_multiple($data);
			$this->session->set_flashdata('msg-siswa', 'DATA BERHASIL DIIMPORT');
			redirect("backend/siswa"); // Redirect ke halaman awal (ke controller siswa fungsi index)
		  }else{
			redirect("backend/siswa");
		  }
	}
    
    function hapus_siswa($id_siswa)
	{ 	
		$cek = $this->siswa_model->cek_siswa($id_siswa); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$this->siswa_model->hapus_siswa($id_siswa);
		}
	}    

}
