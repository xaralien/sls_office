<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Asset extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_asset');
		$this->load->library(array('form_validation', 'session', 'user_agent', 'Api_Whatsapp'));
		$this->load->library('pagination');
		$this->cb = $this->load->database('corebank', TRUE);
		$this->load->helper('url', 'form', 'download');

		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('login/login_form');
		}
	}

	public function item_list()
	{
		$a = $this->session->userdata('level');
		if (strpos($a, '501') !== false) {
			$search = htmlspecialchars($this->input->get('search') ?? '', ENT_QUOTES, 'UTF-8');

			//pagination settings
			$config['base_url'] = site_url('asset/item_list');
			$config['total_rows'] = $this->m_asset->item_count($search);
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
			$data['users_data'] = $this->m_asset->item_get($config["per_page"], $data['page'], $search);
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

	public function add_item()
	{
		$nomor = htmlspecialchars($this->input->post('kode') ?? '', ENT_QUOTES, 'UTF-8');
		$nama = htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'UTF-8');
		$jenis = $this->input->post('jenis_item');

		$this->form_validation->set_rules('kode', 'kode item', 'required|alpha_dash');
		$this->form_validation->set_rules('name', 'nama item', 'required');
		$this->form_validation->set_rules('jenis_item', 'jenis item', 'required');

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'success' => false,
				'status' => '401',
				'msg' => array_values($this->form_validation->error_array())[0],
			];
			echo json_encode($response);
		} else {
			$insert = [
				'nomor' => $nomor,
				'nama' => $nama,
				'stok' => 0,
				'harga_sat' => 0,
				'jenis_item' => $jenis,
			];

			$this->db->insert('item_list', $insert);

			$response = [
				'success' => true,
				'status' => '200',
				'msg' => 'Data item berhasil ditambahkan!'
			];

			echo json_encode($response, http_response_code($response['status']));
		}
	}

	public function preorder()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '501') !== false) {
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

				$data['item_list'] = $this->db->get('item_list');
				$data['vendors'] = $this->cb->get('t_vendors');
				$data['title'] = "Create Preorder";
				$data['pages'] = "pages/aset/v_preorder";
				$this->load->view('index', $data);
			}
		}
	}

	public function save_po()
	{
		$nip = $this->session->userdata('nip');
		$tgl = $this->input->post('tanggal');
		$vendor = $this->input->post('vendor');
		$keterangan = $this->input->post('keterangan');
		$rows = $this->input->post('row[]');
		$item = $this->input->post('item[]');
		$qty = $this->input->post('qty[]');
		$price = $this->input->post('harga[]');
		$subtotal = $this->input->post('total[]');
		$total = $this->input->post('nominal');
		$now = date('Y-m-d');
		if (strtotime($tgl) != strtotime($now)) {
			$tgl = $tgl;
		} else {
			$tgl = date('Y-m-d H:i:s');
		}

		$this->form_validation->set_rules('tanggal', 'tanggal po', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('vendor', 'vendor', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('item[]', 'nama item', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('qty[]', 'qty item', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('harga[]', 'harga item', 'required', ['required' => '%s wajib diisi']);

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'success' => false,
				'msg' => array_values($this->form_validation->error_array())[0]
			];
		} else {
			$count = $this->cb->get('t_preorder')->num_rows();
			$count = $count + 1;
			$no_po = sprintf("%06d", $count);

			$insert = [
				'no_po' => $no_po,
				'user' => $nip,
				'keterangan' => $keterangan,
				'tgl_pengajuan' => $tgl,
				'total' => preg_replace('/[^a-zA-Z0-9\']/', '', $total),
				'vendor' => $vendor,
				'posisi' => 'diajukan kepada sarlog'
			];

			$this->cb->insert('t_preorder', $insert);

			for ($i = 0; $i < count($rows); $i++) {
				$detail = [
					'no_po' => $no_po,
					'item' => $item[$i],
					'qty' => preg_replace('/[^a-zA-Z0-9\']/', '', $qty[$i]),
					'price' => preg_replace('/[^a-zA-Z0-9\']/', '', $price[$i]),
					'total' => preg_replace('/[^a-zA-Z0-9\']/', '', $subtotal[$i]),
				];

				$this->cb->insert('t_preorder_detail', $detail);
			}

			$response = [
				'success' => true,
				'msg' => 'Preorder berhasil dibuat!'
			];
		}

		echo json_encode($response);
	}

	public function po_list()
	{
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

		$data['count_sarlog'] = $this->m_asset->count_po(['status_sarlog' => 0]);
		$data['count_direksi'] = $this->m_asset->count_po(['status_sarlog' => 1, 'direksi' => $this->session->userdata('nip')]);
		$data['preorder'] = $this->m_asset->get_poList(['user' => $this->session->userdata('nip')]);
		$data['title'] = "Preorder List";
		$data['pages'] = "pages/aset/v_preorder_list";
		$this->load->view('index', $data);
	}
}
