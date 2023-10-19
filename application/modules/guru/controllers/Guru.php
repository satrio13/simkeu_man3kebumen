<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Guru extends CI_Controller {
	private $filename = "import_data";
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		$this->load->library('template');
		$this->load->model(array('guru_model','import_guru_model'));
    } 

    function index()
	{	
		$data['title'] = 'Guru';
        $this->template->admin('backend/dashboard','guru/guru',$data);
    }

    function get_data_guru()
	{
		$list = $this->guru_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{	
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'.</div>';
			$row[] = $r->nama;
            $action = '<div class="text-center">
                        <a href="'.base_url("backend/edit-guru/$r->id_guru").'" 
                        class="btn btn-dark btn-xs btn-flat" title="EDIT DATA">EDIT</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-xs btn-flat text-white" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="'.base_url('backend/hapus-guru/'.$r->id_guru.'').'" title="HAPUS DATA">HAPUS</a>
                        </div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->guru_model->count_all(),
			"recordsFiltered" => $this->guru_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    } 

    function tambah_guru()
	{ 
		if($this->input->post('submit', TRUE)=='Submit')
        {  
        	$this->_validation();
            if($this->form_validation->run() == TRUE)
            { 
				$this->guru_model->tambah_guru();
			}
		}
        $data['title'] = 'Tambah Guru';
		$this->template->admin('backend/dashboard','guru/form_tambah_guru', $data);
    }

    function edit_guru($id_guru)
	{ 	
		$cek = $this->guru_model->cek_guru($id_guru); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			if($this->input->post('submit', TRUE)=='Submit')
        	{ 
				$this->_validation();
				if($this->form_validation->run() == TRUE)
				{
					$this->guru_model->edit_guru($id_guru);
				}
			}
			$data['title'] = 'Edit Guru';
            $data['data'] = $this->db->get_where('tb_guru',['id_guru'=>$id_guru])->row();
        	$this->template->admin('backend/dashboard','guru/form_edit_guru', $data);
		}
    }

    function hapus_guru($id_guru)
	{ 	
		$cek = $this->guru_model->cek_guru($id_guru); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$this->guru_model->hapus_guru($id_guru);
		}
	}

    private function _validation()
	{
		$this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
    }

	function cek_guru_batch()
	{
		$jml = $this->input->post('brp',TRUE);
		if(!isset($jml))
		{
			redirect('backend/guru');
		}else
		{
			redirect("backend/guru-batch/$jml");
		}
	}

	function guru_batch($jml)
	{	
		if(!isset($jml))
		{
			redirect('backend/guru');
		}
        if($jml > 0 AND $jml < 50 AND $jml != '')
        {
            if($this->input->post('submit', TRUE) == 'Submit')
		    {   
                $this->form_validation->set_error_delimiters('<div style="color:#fff; background-color:#DC143C; padding:2px;"><i class="fa fa-times-circle"></i> ', '</div>');
                for($i=1; $i<=$jml; $i++)
                {
					$this->form_validation->set_rules("nama[$i]", 'Nama Lengkap', 'required');
                }

                if($this->form_validation->run() == TRUE)
                {                 
                    $sukses = 0;
			        $gagal = 0;
                    for($i=1; $i<=$jml; $i++)
                    {
                        $data_insert = [           
                            'nama' => strip_tags($this->input->post("nama[$i]", TRUE))
                        ]; 
                        
                        $this->db->insert('tb_guru',$data_insert);
                        $sukses ++;
                    }

					if($this->db->affected_rows() > 0)
					{ 
                        $msg = '<div class="alert alert-light border border-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <div class="text-success text-bold">'.$sukses.' DATA BERHASIL DITAMBAHKAN</div>
                                    <div class="text-danger text-bold">'.$gagal.' DATA GAGAL DITAMBAHKAN</div>
                                </div>';
                        $this->session->set_flashdata('msg-tr-guru', "$msg");
					}else
					{
                        $this->session->set_flashdata('msg-gagal-guru', 'DATA GAGAL DITAMBAHKAN!');
                    }
                    redirect('backend/guru');
                }
            }
		}else
		{
            redirect('backend/guru');
        }
        $data['jml'] = $jml;
		$data['title'] = 'Tambah Guru';
		$this->template->admin('backend/dashboard','guru/form_guru_batch', $data);
	}

	function form_guru()
	{ 
		$data = array(); // Buat variabel $data sebagai array
		if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
		// lakukan upload file dengan memanggil function upload yang ada di import_model.php
			$upload = $this->import_guru_model->upload_file($this->filename.'-'.$this->session->userdata('id_user'));
			if($upload['result'] == "success"){ // Jika proses upload sukses
				// Load plugin PHPExcel nya
				include APPPATH.'third_party/PHPExcel/PHPExcel.php';
				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('excel/guru/'.$this->filename.'-'.$this->session->userdata('id_user').'.xlsx'); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
				// Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
				// Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
				$data['sheet'] = $sheet; 
			}else{ // Jika proses upload gagal
				$data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
			}
		}
		$data['title']='Import Data Guru';
		$this->template->admin('backend/dashboard','guru/form_guru', $data);
	}

	function import_guru()
	{
		if($this->input->post('import') == 'Import')
		{	
			// Load plugin PHPExcel nya
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			date_default_timezone_set('Asia/Jakarta');
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('excel/guru/'.$this->filename.'-'.$this->session->userdata('id_user').'.xlsx'); // Load file yang telah diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			// Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
			$data = array();
			
			$numrow = 1;
			foreach($sheet as $row){
			  // Cek $numrow apakah lebih dari 1
			  // Artinya karena baris pertama adalah nama-nama kolom
			  // Jadi dilewat saja, tidak usah diimport
			  if($numrow > 1){
				// Kita push (add) array data ke variabel data
				
				if( empty($row['A']) )
                {
                    break;
                }else
                {
					array_push($data, array(
						'nama'=>$row['A']
					));
				}
			  }
			  $numrow++; 
			}
	  
			$this->import_guru_model->insert_multiple($data);
			$this->session->set_flashdata('msg-guru', 'DATA BERHASIL DIIMPORT');
			redirect("backend/guru"); 
		  }else{
			redirect("backend/guru");
		  }
	}

}