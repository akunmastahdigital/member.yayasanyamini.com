<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
	function __construct() {
        parent::__construct();
        
	}
		
	function index() {
		show_404();
	}

	function login() {
		$this->session->set_userdata('nm_user', "John");
        $d['page']      = 'login';
        
		$this->load->view('layout', $d);
	}


	function submitLogin(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$cekUser = $this->M_login->getUser($username)->result();

		foreach ($cekUser as $cu) {
			$passwordDecrypt = $this->encrypt->decode($cu->sandi_user);
		}

		if ($password == $passwordDecrypt) {
			
			$cek = $this->M_login->getUser($username)->result();
				$sess_data 	= [];
			$flagging = 0;
				foreach ($cek as $c) {
					$sess_data['id_user'] 		= $c->id_user;
					$sess_data['flagging'] 		= $c->flagging;
					$sess_data['username'] 		= $c->username;
					$sess_data['sandi_user']	= $c->sandi_user;
					$sess_data['nm_user'] 		= $c->nm_user;
					$sess_data['id_role'] 		= $c->id_role;
					$sess_data['img'] 		= $c->img;
					$flagging = $c->flagging;
				}

				$this->session->set_userdata($sess_data);
				if (!$this->session->userdata('url')) {
					// redirect('dashboard');
					if($this->session->userdata('id_role') == 3){
						if($flagging == 0){
							$this->session->set_flashdata('psn','Silahkan isi data diri terlebih dahulu');
							redirect('user/changeProfil');
						}else{
							redirect('dashboard/relawan');
						}
					}else{
						if($this->session->userdata('id_role') == 1){
							redirect('dashboard/admin');
						}elseif($this->session->userdata('id_role') == 2){
							redirect('dashboard');
						}else{
							redirect('dashboard');
						}
					}
				}else{
					$url = $this->session->userdata('url');
					$this->session->unset_userdata('url');
					redirect($url);
				}
				
		} else{
			$this->session->set_flashdata('psn','Username atau Password Salah');
			redirect('user/login');
		}
	}

	function logout() {
		$this->session->sess_destroy();
		redirect();
	}

	function changeProfil() {
		$d['id_user']  = $this->session->userdata('id_user');
		$condition 		= [];
		$condition[] 	= ['id_user', $d['id_user'], 'where'];
		
		$d['dPer'] 		= $this->M_admin->get_master_spec('v_user', '*' , $condition)->row_array();
		$d['page']     = 'change_profil';

		$this->load->view('layout', $d);
	}

	function submit_data_diri(){
		$nama_relawan = $this->input->post('nm_user');
		$id_user = $this->input->post('id_user');
		$no_wa = $this->input->post('no_wa');
		$email = $this->input->post('email');
		$url_website = $this->input->post('url_website');

		$condition = [];
		$condition[] = ['id_user', $id_user, 'where'];

		if(isset($_FILES['foto'])){
			// $filename  = $_FILES['foto']['tmp_name'];
			// $handle    = fopen($filename, "r");
			// $data_file = fread($handle, filesize($filename));
			// $POST_DATA = array(
			// 	'file' => base64_encode($data_file),
			// 	'file_hash' => uniqid().time(),
			// 	'file_name' => $_FILES["foto"]['name'],
			// 	'extension' => pathinfo($_FILES["foto"]['name'], PATHINFO_EXTENSION)
			// );

			// $curl = curl_init();
			// /* ganti http://example.com dengan external server Anda. */
			// curl_setopt($curl, CURLOPT_URL, 'http://contohweb.xyz/file-upload/index.php');
			// curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			// curl_setopt($curl, CURLOPT_POST, 1);
			// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			// curl_setopt($curl, CURLOPT_POSTFIELDS, $POST_DATA);
			// $response = curl_exec($curl);
			// curl_close ($curl);

			// $result = json_decode($response, true);

			// if($result['last_id'] != 0) {
			// 	$dS['img']		= $result['file_locate'].$result['file_hash'];
			// 	$ins_dS = $this->M_core->update_tbl("m_user", $dS, $condition);
			// }

			$nama_input = $_FILES['foto']['tmp_name'];

			$path 	= '/berkas/berkas_foto';
			$config = [
				'upload_path' 	=> '.'.$path,
				'allowed_types' => 'png|jpg|jpeg',
				// 'max_size' 		=> '6000',
				'max_size' 		=> '8000',
				'file_name' 	=> $_FILES['foto']['name'],
				'encrypt_name' 	=> TRUE
			];
			$this->upload->initialize($config);

			if($this->upload->do_upload("foto")) {
				$dS['img']		= base_url().substr($path, 1).'/'.$this->upload->data('file_name');
				$ins_dS = $this->M_core->update_tbl("m_user", $dS, $condition);
			}

			$sess_data['img'] 		= $dS['img'];
			$this->session->set_userdata($sess_data);
		}
	
		$dS['nm_user']	= $nama_relawan;
		$dS['no_wa']		= $no_wa;
		$dS['email']		= $email;
		$dS['url_website']		= $url_website;
		$dS['flagging']		= 1;
		$ins_dS = $this->M_core->update_tbl("m_user", $dS, $condition);

		// response
		$this->session->set_flashdata("tipe-alert", "success");
		$this->session->set_flashdata("teks-alert", "Data Diri Berhasil Disimpan");
		$this->session->set_flashdata("icon-alert", "fa fa-check-circle");


		redirect('dashboard/relawan');
	}

	function changePassword() {
		$d['id_user']  = $this->session->userdata('id_user');

		$d['page']     = 'change_password';

		$this->load->view('layout', $d);
	}

	function submitChangePassword(){
		$id_user 			= $this->input->post('id_user');
		$password_lama  	= $this->input->post('password_lama');
		$password_baru		= $this->input->post('password_baru');
		$konfirm_password 	= $this->input->post('konfirm_password');
		$where 				= ['id_user'	=>	$id_user];

		/*$condition 		= ['id_user' => $id_user];*/
		$getUserById	= $this->M_userbo->get_from('m_user',$where)->result();

		/*var_dump($getUserById);
		exit(0);*/

		foreach ($getUserById as $key) {
			$passwordLama = $this->encrypt->decode($key->sandi_user);
			
		}

		if ($password_lama != $passwordLama) {
			$this->session->set_flashdata("psn", "Password Tidak sama");
			
			redirect('user/changePassword/'.$id_user);

		} else {

			$data  = ['sandi_user' => $this->encrypt->encode($password_baru)];
			$where = ['id_user' => $id_user];
			$ubahPassword = $this->M_userbo->update_from('m_user', $data, $where);

			if (!$ubahPassword) {
				
				redirect('user/login');

			}

			else{
				$this->session->set_flashdata("psn", "password Gagal Diubah");
				redirect('user/changePassword/'.$id_user);
			}
		}


	}	

}