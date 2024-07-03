<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Asset extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		//$this->load->model('M_cuti');
		$this->load->model('m_asset');
		$this->load->library(array('form_validation', 'session', 'user_agent', 'Api_Whatsapp'));
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url', 'form', 'download');

		// if (!$this->session->userdata('nip')) {
		// 	redirect('login');
		// }
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('login/login_form');
		}
	}

	public function item_list()
	{
		$a = $this->session->userdata('level');
		if (strpos($a, '501') !== false) {
			//pagination settings
			$config['base_url'] = site_url('asset/item_list');
			$config['total_rows'] = $this->m_asset->asset_count();
			$config['per_page'] = "20";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"] / $config["per_page"];
			//$config["num_links"] = floor($choice);
			$config["num_links"] = 10;
			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '«';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '»';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data['users_data'] = $this->m_asset->asset_get($config["per_page"], $data['page']);
			$data['pagination'] = $this->pagination->create_links();

			//inbox notif
			$nip = $this->session->userdata('nip');
			$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
			$sql2 = "SELECT * FROM asset_ruang";
			$sql3 = "SELECT * FROM asset_lokasi";
			$query = $this->db->query($sql);
			$query2 = $this->db->query($sql2);
			$query3 = $this->db->query($sql3);
			$res2 = $query->result_array();
			$asset_ruang = $query2->result();
			$asset_lokasi = $query3->result();
			$result = $res2[0]['COUNT(Id)'];
			$data['count_inbox'] = $result;
			$data['asset_ruang'] = $asset_ruang;
			$data['asset_lokasi'] = $asset_lokasi;

			// Tello
			$sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
			$query4 = $this->db->query($sql4);
			$res4 = $query4->result_array();
			$result4 = $res4[0]['COUNT(Id)'];
			$data['count_inbox2'] = $result4;

			// $this->load->view('item_list', $data);
			$data['title'] = "Asset item list";
			$data['pages'] = "pages/aset/v_item_list";

			$this->load->view('index', $data);
		}
	}

	function filter_jenis_item()
	{
		$jenis = $this->input->post('jenis_item');
		$this->session->set_userdata('filterJenis', $jenis);
		redirect('asset/item_list');
	}
	function export_item()
	{
		$this->load->view('pages/aset/export_asset');
	}

	function reset_jenis_item()
	{
		$this->session->unset_userdata('filterJenis');
		redirect('asset/item_list');
	}

	public function item_detail()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '501') !== false) {

				$nip = $this->session->userdata('nip');
				$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
				$query = $this->db->query($sql);
				$res2 = $query->result_array();
				$result = $res2[0]['COUNT(Id)'];
				$data['count_inbox'] = $result;

				$sql2 = "SELECT * FROM asset_ruang";
				$sql3 = "SELECT * FROM asset_lokasi";
				$query2 = $this->db->query($sql2);
				$query3 = $this->db->query($sql3);
				$asset_ruang = $query2->result();
				$asset_lokasi = $query3->result();

				//ambil data asset_list
				$data['asset_list'] = $this->m_app->ambil_asset_list($this->uri->segment(3));
				$data['asset_history'] = $this->m_app->ambil_asset_history($this->uri->segment(3));
				$data['asset_ruang'] = $asset_ruang;
				$data['asset_lokasi'] = $asset_lokasi;

				$this->load->view('asset_detail', $data);
			}
		}
	}

	public function item_cari()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '501') !== false) {
				// get search string
				$search = ($this->input->post("search")) ? $this->input->post("search") : "NIL";
				if ($search <> 'NIL') {
					$this->session->set_userdata('keyword', $search);
				}
				$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
				$stringLink = str_replace(' ', '_', $search);
				// pagination settings
				$config = array();
				$config['base_url'] = site_url("asset/item_cari/$stringLink");
				$config['total_rows'] = $this->m_asset->item_cari_count($search);
				$config['per_page'] = "20";
				$config["uri_segment"] = 4;
				$choice = $config["total_rows"] / $config["per_page"];
				//$config["num_links"] = floor($choice);
				$config["num_links"] = 10;

				// integrate bootstrap pagination
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = false;
				$config['last_link'] = false;
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = 'Prev';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = 'Next';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$this->pagination->initialize($config);

				$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

				// get books list
				$data['users_data'] = $this->m_asset->item_cari_pagination($config["per_page"], $data['page'], $search);
				$data['pagination'] = $this->pagination->create_links();

				//inbox notif
				$nip = $this->session->userdata('nip');
				$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
				$query = $this->db->query($sql);
				$res1 = $query->result_array();
				$result = $res1[0]['COUNT(Id)'];
				$data['count_inbox'] = $result;

				$sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
				$query2 = $this->db->query($sql2);
				$res2 = $query2->result_array();
				$result2 = $res2[0]['COUNT(id)'];
				$data['count_inbox2'] = $result2;

				$this->load->view('item_list', $data);
			}
		}
	}
}
