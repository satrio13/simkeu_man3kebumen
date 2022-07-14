<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting_bsm_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    function hasil_cari($id_tahunpelajaran,$id_kelas)
    {
        return $this->db->select('ks.*,s.nis,s.nama,kw.*')->from('tb_kelas_siswa ks')->join('tb_siswa s','ks.id_siswa=s.id_siswa','left')->join('tb_kelas_wali kw','ks.id_kelas_wali=kw.id_kelas_wali','left')->where('kw.id_tahunpelajaran',$id_tahunpelajaran)->where('kw.id_kelas',$id_kelas)->where('ks.id_siswa != ',0)->group_by('s.nis')->order_by('s.nis','asc')->get();
    }

    function update_bsm()
    {   
        $i = 1;
        $no = $this->input->post('no', TRUE);
        while($i <= $no)
        {
            if(isset($_POST['cek'][$i]))
            {	
                $data_update = [
                    'bsm' => 1
                ];
                $this->db->update('tb_kelas_siswa',$data_update,['id_siswa'=>$this->input->post("id_siswa[$i]", TRUE)]);
            }else
            {
                $data_update = [
                    'bsm' => 0
                ];
                $this->db->update('tb_kelas_siswa',$data_update,['id_siswa'=>$this->input->post("id_siswa[$i]", TRUE)]);
            }
            $i++;
        }
        $this->session->set_flashdata('msg-bsm', 'DATA BERHASIL DIUPDATE');
    }

}