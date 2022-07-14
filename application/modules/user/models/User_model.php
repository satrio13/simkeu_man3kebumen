<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function tampil_user()
    {
        return $this->db->select('*')->from('tb_user')->order_by('id_user','desc')->get();
    }

    function tambah_user()
    {
        $config['upload_path'] = 'assets/img/user/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['encrypt_name'] = TRUE; //nama yang terupload nantinya
        $config['max_size'] = '1024'; // kb
        $this->load->library('upload', $config);
        if(!empty($_FILES['gambar']['name']))
        {
            if($this->upload->do_upload('gambar'))
            {
                $gbr = $this->upload->data();
                $data = [
                    'nama' => strip_tags($this->input->post('nama',TRUE)),
                    'nip' => strip_tags($this->input->post('nip',TRUE)),
                    'username' => strip_tags($this->input->post('username',TRUE)),
                    'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                    'email' => strip_tags($this->input->post('email',TRUE)),
                    'level' => strip_tags($this->input->post('level',TRUE)),
                    'gambar'=> $gbr['file_name'],
                    'is_active' => strip_tags($this->input->post('is_active',TRUE))
                ];
                $this->db->insert('tb_user',$data);
                $this->session->set_flashdata('msg-user', 'DATA BERHASIL DITAMBAHKAN');
                redirect('backend/users');
            }else
            {
                $this->session->set_flashdata('msg-gagal-user', 'FOTO GAGAL DIUPLOAD! PERIKSA KEMBALI FORMAT DAN UKURAN FILE ANDA!');
            }
        }else
        {
            $data = [
                'nama' => strip_tags($this->input->post('nama',TRUE)),
                'nip' => strip_tags($this->input->post('nip',TRUE)),
                'username' => strip_tags($this->input->post('username',TRUE)),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'email' => strip_tags($this->input->post('email',TRUE)),
                'level' => strip_tags($this->input->post('level',TRUE)),
                'is_active' => strip_tags($this->input->post('is_active',TRUE))
            ];
            $this->db->insert('tb_user',$data);
            $this->session->set_flashdata('msg-user', 'DATA BERHASIL DITAMBAHKAN');
            redirect('backend/users');
        }
    }

    function cek_user($id_user)
    {   
        return $this->db->select('id_user')->from('tb_user')->where('id_user',$id_user)->get()->row();
    }

    function edit_user($id_user)
    {
        $get = $this->db->select('id_user,gambar')->from('tb_user')->where('id_user',$id_user)->get()->row();
        $target = "assets/img/user/$get->gambar";

        $config['upload_path'] = 'assets/img/user/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['encrypt_name'] = TRUE; //nama yang terupload nantinya
        $config['max_size'] = '1024'; // kb
        $this->load->library('upload', $config);

        if(level($id_user) == 'superadmin')
        {
            $is_active = 1;
        }else
        {
            $is_active = strip_tags($this->input->post('is_active',TRUE));
        }

        if(!empty($this->input->post('password')))
        {
            if(!empty($_FILES['gambar']['name']))
            {
                if($this->upload->do_upload('gambar'))
                {
                    unlink($target);
                    $gbr = $this->upload->data();
                    $data = [
                        'nama' => strip_tags($this->input->post('nama',TRUE)),
                        'nip' => strip_tags($this->input->post('nip',TRUE)),
                        'username' => strip_tags($this->input->post('username',TRUE)),
                        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                        'email' => strip_tags($this->input->post('email',TRUE)),
                        'level' => strip_tags($this->input->post('level',TRUE)),
                        'gambar'=>$gbr['file_name'],
                        'is_active' => $is_active
                    ];
                    $this->db->update('tb_user',$data, ['id_user'=>$id_user]);
                    $this->session->set_flashdata('msg-user', 'DATA BERHASIL DIUPDATE');
                    redirect('backend/users');
                }else
                {
                    $this->session->set_flashdata('msg-gagal-user', 'FOTO GAGAL DIUPLOAD! PERIKSA KEMBALI FORMAT DAN UKURAN FILE ANDA!');
                }
            }else
            {
                $data = [
                    'nama' => strip_tags($this->input->post('nama',TRUE)),
                    'nip' => strip_tags($this->input->post('nip',TRUE)),
                    'username' => strip_tags($this->input->post('username',TRUE)),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'email' => strip_tags($this->input->post('email',TRUE)),
                    'level' => strip_tags($this->input->post('level',TRUE)),
                    'is_active' => $is_active
                ];
                $this->db->update('tb_user',$data, ['id_user'=>$id_user]);
                $this->session->set_flashdata('msg-user', 'DATA BERHASIL DIUPDATE');
                redirect('backend/users');
            }
        }else
        {
            if(!empty($_FILES['gambar']['name']))
            {
                if($this->upload->do_upload('gambar'))
                {
                    unlink($target);
                    $gbr = $this->upload->data();
                    $data = [
                        'nama' => strip_tags($this->input->post('nama',TRUE)),
                        'nip' => strip_tags($this->input->post('nip',TRUE)),
                        'username' => strip_tags($this->input->post('username',TRUE)),
                        'email' => strip_tags($this->input->post('email',TRUE)),
                        'level' => strip_tags($this->input->post('level',TRUE)),
                        'gambar'=>$gbr['file_name'],
                        'is_active' => $is_active
                    ];
                    $this->db->update('tb_user',$data, ['id_user'=>$id_user]);
                    $this->session->set_flashdata('msg-user', 'DATA BERHASIL DIUPDATE');
                    redirect('backend/users');
                }else
                {
                    $this->session->set_flashdata('msg-gagal-user', 'FOTO GAGAL DIUPLOAD! PERIKSA KEMBALI FORMAT DAN UKURAN FILE ANDA!');
                }
            }else
            {
                $data = [
                    'nama' => strip_tags($this->input->post('nama',TRUE)),
                    'nip' => strip_tags($this->input->post('nip',TRUE)),
                    'username' => strip_tags($this->input->post('username',TRUE)),
                    'email' => strip_tags($this->input->post('email',TRUE)),
                    'level' => strip_tags($this->input->post('level',TRUE)),
                    'is_active' => $is_active
                ];
                $this->db->update('tb_user',$data, ['id_user'=>$id_user]);
                $this->session->set_flashdata('msg-user', 'DATA BERHASIL DIUPDATE');
                redirect('backend/users');
            }
        }
    }

    function hapus_user($id_user)
	{ 
        $cek_pemb = $this->db->select('id_user')->from('tb_pembayaran')->where('id_user',$id_user)->get()->num_rows();
        if($cek_pemb > 0)
        {
            $this->session->set_flashdata('msg-gagal-user', 'DATA GAGAL DIHAPUS!');
        }else
        {
            $get = $this->db->select('id_user,gambar')->from('tb_user')->where('id_user',$id_user)->get()->row();
            $target = "assets/img/user/$get->gambar";
            if(!empty($get->gambar) AND file_exists($target))
            {
                unlink($target);
            }

            $this->db->delete('tb_user', ['id_user'=>$id_user]);
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-user', 'DATA BERHASIL DIHAPUS');
            }else
            {
                $this->session->set_flashdata('msg-gagal-user', 'DATA GAGAL DIHAPUS!');
            }
        }
        redirect('backend/users');
    }

    function ttd($id_user)
	{
        $get = $this->db->select('id_user,ttd')->from('tb_user')->where('id_user',$id_user)->get()->row();
        $target = "assets/img/ttd/$get->ttd";
        $config['upload_path'] = 'assets/img/ttd/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        //$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
        $config['max_size'] = '1024'; // kb
        $this->load->library('upload', $config);

        if(!empty($_FILES['ttd']['name']))
        {
            if($this->upload->do_upload('ttd'))
            { 
                unlink($target);
                $gbr = $this->upload->data();
                $data = [
                    'ttd' => $gbr['file_name']
                ];
                $this->db->update('tb_user', $data, ['id_user'=>$id_user]);
                $this->session->set_flashdata('msg-user', 'FILE BERHASIL DIUPDATE');
                redirect('backend/users');
            }else
            {
                $this->session->set_flashdata('msg-gagal-ttd', 'File gagal diupload! periksa kembali format dan ukuran file anda!');
            }
        }else
        {
            $this->session->set_flashdata('msg-gagal-ttd', 'Anda belum memilih file yang akan diupload!');
        }
    }

    function edit_profil($id_user)
	{ 
        $get = $this->db->select('id_user,gambar')->from('tb_user')->where('id_user',$id_user)->get()->row();
        $target = "assets/img/user/$get->gambar";

        $config['upload_path'] = 'assets/img/user/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['encrypt_name'] = TRUE; //nama yang terupload nantinya
        $config['max_size'] = '1024'; // kb
        $this->load->library('upload', $config);

        if(!empty($_FILES['gambar']['name']))
        {
            if($this->upload->do_upload('gambar'))
            {
                unlink($target);
                $gbr = $this->upload->data();
                $data = [
                    'nama' => strip_tags($this->input->post('nama',TRUE)),
                    'nip' => strip_tags($this->input->post('nip',TRUE)),
                    'username' => strip_tags($this->input->post('username',TRUE)),
                    'email' => strip_tags($this->input->post('email',TRUE)),
                    'gambar'=>$gbr['file_name']
                ];
                $this->db->update('tb_user',$data, ['id_user'=>$id_user]);
                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('msg-user', 'PROFIL BERHASIL DIUPDATE');
                    redirect('backend');
                }else
                {
                    $this->session->set_flashdata('msg-gagal-user', 'DATA GAGAL DIEDIT!');
                }
            }else
            {
                $this->session->set_flashdata('msg-gagal-user', 'FOTO GAGAL DIUPLOAD! PERIKSA KEMBALI FORMAT DAN UKURAN FILE ANDA!');
            }
        }else
        {
            $data = [
                'nama' => strip_tags($this->input->post('nama',TRUE)),
                'nip' => strip_tags($this->input->post('nip',TRUE)),
                'username' => strip_tags($this->input->post('username',TRUE)),
                'email' => strip_tags($this->input->post('email',TRUE))
            ];
            $this->db->update('tb_user',$data, ['id_user'=>$id_user]);
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('msg-user', 'PROFIL BERHASIL DIUPDATE');
                redirect('backend');
            }else
            {
                $this->session->set_flashdata('msg-gagal-user', 'DATA GAGAL DIEDIT!');
            }
        }
    }

    function ganti_password($id_user)
    {
        $data = [
            'password' => password_hash($this->input->post('pass1'), PASSWORD_DEFAULT)
        ];
        $this->db->update('tb_user',$data,['id_user'=>$id_user]);
        if($this->db->affected_rows() > 0)
        {
            echo '<script type="text/javascript">alert("Password berhasil dirubah");window.location.replace("'.base_url().'auth/logout")</script>';
        }else
        {
            $this->session->set_flashdata('msg-gagal-user', 'PASSWORD GAGAL DIGANTI!');
        }
    }

}