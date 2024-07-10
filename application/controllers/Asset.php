<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Asset extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_asset');
		$this->load->library(array('form_validation', 'session', 'user_agent', 'Api_Whatsapp', 'pdfgenerator'));
		$this->load->library('pagination');
		$this->cb = $this->load->database('corebank', TRUE);
		$this->load->helper('url', 'form', 'download');
		date_default_timezone_set('Asia/Jakarta');
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
			$query = $this->db->query($sql);
			$res2 = $query->result_array();
			$result = $res2[0]['COUNT(Id)'];
			$data['count_inbox'] = $result;

			// Tello
			$sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
			$query4 = $this->db->query($sql4);
			$res4 = $query4->result_array();
			$result4 = $res4[0]['COUNT(Id)'];
			$data['count_inbox2'] = $result4;

			$data['jenis_item'] = $this->db->get('item_jenis');
			$data['title'] = "Asset item list";
			$data['pages'] = "pages/aset/v_item_list";
			$this->load->view('index', $data);
		}
	}

	function ubah_item($id)
	{
		//inbox notif
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];
		$data['count_inbox'] = $result;

		// Tello
		$sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		$query4 = $this->db->query($sql4);
		$res4 = $query4->result_array();
		$result4 = $res4[0]['COUNT(Id)'];
		$data['count_inbox2'] = $result4;

		$data['jenis_item'] = $this->db->get('item_jenis');
		$data['item'] = $this->db->get_where('item_list', ['Id' => $id])->row_array();
		$data['title'] = "Ubah data item";
		$data['pages'] = "pages/aset/v_ubah_item";
		$this->load->view('index', $data);
	}

	function update_item($id)
	{
		$nama_item = $this->input->post('nama');
		$jenis = $this->input->post('jenis');

		$this->form_validation->set_rules('nama', 'nama item', 'required|trim', array('required' => '%s wajib diisi!'));
		$this->form_validation->set_rules('jenis', 'jenis item', 'required|trim', array('required' => '%s wajib diisi!'));

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'success' => false,
				'status' => '401',
				'msg' => array_values($this->form_validation->error_array())[0],
			];
		} else {
			$update = [
				'nama' => $nama_item,
				'jenis_item' => $jenis
			];

			$this->db->where('Id', $id);
			$this->db->update('item_list', $update);

			$response = [
				'success' => true,
				'status' => '200',
				'msg' => 'Data item berhasil diubah!'
			];
		}

		echo json_encode($response, http_response_code($response['status']));
	}

	public function detail($id)
	{
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];
		$data['count_inbox'] = $result;

		$sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		$query4 = $this->db->query($sql4);
		$res4 = $query4->result_array();
		$result4 = $res4[0]['COUNT(Id)'];
		$data['count_inbox2'] = $result4;

		$data['title'] = "Detail item";
		$data['pages'] = "pages/aset/v_item_detail";
		$data['item'] = $this->db->get_where('item_list', ['Id' => $id])->row_array();
		$data['detail'] = $this->db->get_where('item_detail', ['kode_item' => $id]);
		$this->load->view('index', $data);
	}

	function add_detail_item()
	{
		$id_item = $this->input->post('id_item');
		$serial = $this->input->post('serial');
		$tgl = $this->input->post('tanggal');

		$this->form_validation->set_rules('serial', 'serial number', 'required|trim', array('required' => '%s wajib diisi!'));
		$this->form_validation->set_rules('tanggal', 'tanggal masuk', 'required|trim', array('required' => '%s wajib diisi!'));

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'success' => false,
				'status' => '401',
				'msg' => array_values($this->form_validation->error_array())[0],
			];
		} else {
			$item = $this->db->get_where('item_list', ['Id' => $id_item])->row_array();
			$detail = $this->db->get_where('item_detail', ['kode_item' => $id_item, 'status' => 'A'])->num_rows();

			if ($detail >= $item['stok']) {
				$response = [
					'success' => false,
					'status' => '401',
					'msg' => 'Detail melebihi stok tersedia',
				];

				echo json_encode($response);
				return false;
			}

			$insert = [
				'kode_item' => $id_item,
				'serial_number' => $serial,
				'tanggal_masuk' => $tgl,
				'user' => $this->session->userdata('nip')
			];

			$this->db->insert('item_detail', $insert);

			$response = [
				'success' => true,
				'status' => '200',
				'msg' => 'Detail item berhasil ditambahkan!'
			];
		}

		echo json_encode($response);
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

	public function add_item_in()
	{
		$id = $this->input->post('id_po');
		$po = $this->cb->get_where('t_po', ['Id' => $id])->row_array();
		$detail = $this->cb->get_where('t_po_detail', ['no_po' => $po['no_po']])->result_array();

		$i = 0;
		foreach ($detail as $d) {
			$item[] = $this->db->get_where('item_list', ['Id' => $d['item']])->row_array();
			$item_list_jumlah[] = $item[$i]['stok'];
			$item_list_hargasat[] = $item[$i]['harga_sat'];

			$total[] = $d['qty'] + $item_list_jumlah[$i];

			$harga[] = ($d['qty'] * $d['price']) + ($item_list_jumlah[$i] * $item_list_hargasat[$i]);
			$harga_baru[] = $harga[$i] / $total[$i];

			$update = [
				'stok' => $total[$i],
				'harga_sat' => $harga_baru[$i]
			];

			$this->db->where('Id', $item[$i]['Id']);
			$this->db->update('item_list', $update);

			$this->cb->where('Id', $item[$i]['Id']);
			$this->cb->update('t_po_detail', ['status_add' => 1]);

			$i++;
		}

		$this->cb->where('Id', $id);
		$this->cb->update('t_po', ['posisi' => 'Item PO sudah ditambahkan']);

		$response = [
			'success' => true,
			'status' => '200',
			'msg' => 'Data item berhasil ditambahkan!'
		];

		echo json_encode($response, http_response_code($response['status']));
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

	public function purchaseorder()
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
				$data['title'] = "Create PO";
				$data['pages'] = "pages/aset/v_po";
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
			$count = $this->cb->get('t_po')->num_rows();
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

			$this->cb->insert('t_po', $insert);

			for ($i = 0; $i < count($rows); $i++) {
				$detail = [
					'no_po' => $no_po,
					'item' => $item[$i],
					'qty' => preg_replace('/[^a-zA-Z0-9\']/', '', $qty[$i]),
					'price' => preg_replace('/[^a-zA-Z0-9\']/', '', $price[$i]),
					'total' => preg_replace('/[^a-zA-Z0-9\']/', '', $subtotal[$i]),
				];

				$this->cb->insert('t_po_detail', $detail);
			}

			$response = [
				'success' => true,
				'msg' => 'PO berhasil dibuat!'
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
		$data['count_direksi'] = $this->m_asset->count_po(['status_sarlog' => 1, 'direksi' => $this->session->userdata('nip'), 'status_direksi' => 0]);
		$data['po'] = $this->m_asset->get_poList(['user' => $this->session->userdata('nip')]);
		$data['title'] = "Purchase Order List";
		$data['pages'] = "pages/aset/v_po_list";
		$this->load->view('index', $data);
	}

	public function sarlog()
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

		$data['po'] = $this->m_asset->get_poList(['user !=' => $this->session->userdata('nip')]);
		$data['direksi'] = $this->db->get_where('users', ['level_jabatan >' => 4])->result_array();
		$data['title'] = "PO List Sarlog";
		$data['pages'] = "pages/aset/v_sarlog";
		$this->load->view('index', $data);
	}

	public function update_sarlog()
	{
		$id = $this->input->post('id_po');
		$tgl = $this->input->post('tanggal');
		$status = $this->input->post('status');
		$direksi = $this->input->post('direksi');
		$catatan = $this->input->post('catatan');

		$now = date('Y-m-d');
		if (strtotime($tgl) != strtotime($now)) {
			$tgl = $tgl;
		} else {
			$tgl = date('Y-m-d H:i:s');
		}

		$this->form_validation->set_rules('tanggal', 'tanggal', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('status', 'status', 'required|in_list[1,2]', ['required' => '%s wajib diisi!']);
		if ($status == 1) {
			$this->form_validation->set_rules('direksi', 'direksi', 'required', ['required' => '%s wajib diisi!']);
		}

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'success' => false,
				'msg' => array_values($this->form_validation->error_array())[0]
			];
		} else {
			if ($status == 1) {
				$posisi = 'diajukan kepada direksi';
				$direksi = $direksi;
			} else {
				$posisi = 'ditolak sarlog';
				$direksi = null;
			}
			$update = [
				'status_sarlog' => $status,
				'sarlog' => $this->session->userdata('nip'),
				'posisi' => $posisi,
				'date_sarlog' => $tgl,
				'catatan_sarlog' => $catatan,
				'direksi' => $direksi
			];

			$this->cb->where('Id', $id);
			$this->cb->update('t_po', $update);

			$response = [
				'success' => true,
				'msg' => 'Status PO berhasil diubah!'
			];
		}

		echo json_encode($response);
	}

	public function direksi()
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

		$data['po'] = $this->m_asset->get_poList(['status_sarlog' => 1, 'direksi' => $this->session->userdata('nip')]);
		$data['direksi'] = $this->db->get_where('users', ['level_jabatan >' => 4])->result_array();
		$data['title'] = "PO List Direksi";
		$data['pages'] = "pages/aset/v_direksi";
		$this->load->view('index', $data);
	}

	public function update_direksi()
	{
		$id = $this->input->post('id_po');
		$tgl = $this->input->post('tanggal');
		$status = $this->input->post('status');
		$catatan = $this->input->post('catatan');

		$now = date('Y-m-d');
		if (strtotime($tgl) != strtotime($now)) {
			$tgl = $tgl;
		} else {
			$tgl = date('Y-m-d H:i:s');
		}

		$this->form_validation->set_rules('tanggal', 'tanggal', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('status', 'status', 'required|in_list[1,2]', ['required' => '%s wajib diisi!']);

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'success' => false,
				'msg' => array_values($this->form_validation->error_array())[0]
			];
		} else {
			if ($status == 1) {
				$posisi = 'diarahkan ke pembayaran';
			} else {
				$posisi = 'ditolak direksi';
			}
			$update = [
				'status_direksi' => $status,
				'posisi' => $posisi,
				'date_direksi' => $tgl,
				'catatan_direksi' => $catatan,
			];

			$this->cb->where('Id', $id);
			$this->cb->update('t_po', $update);

			$response = [
				'success' => true,
				'msg' => 'Status PO berhasil diubah!'
			];
		}

		echo json_encode($response);
	}

	public function process($id)
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

		$data['coa'] = $this->cb->get('v_coa_all');
		$data['po'] = $this->m_asset->get_poList(['a.Id' => $id])->row_array();
		$data['title'] = "Proses PO";
		$data['pages'] = "pages/aset/v_process";
		$this->load->view('index', $data);
	}

	public function update_process()
	{
		$id = $this->input->post('id_po');
		$coa_debit = $this->input->post('coa_debit[]');
		$coa_kredit = $this->input->post('coa-kredit');
		$id_item = $this->input->post('id_item[]');
		$rows = $this->input->post('row_item[]');
		$tgl = $this->input->post('tanggal');
		$now = date('Y-m-d');
		$jenis_pembayaran = $this->input->post('jenis-pembayaran');

		if (strtotime($tgl) != strtotime($now)) {
			$date_bayar = $tgl;
		} else {
			$date_bayar = date('Y-m-d H:i:s');
		}

		$this->form_validation->set_rules('coa_debit[]', 'coa persediaan', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('tanggal', 'tanggal', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('jenis-pembayaran', 'jenis pembayaran', 'required|in_list[kas,hutang]', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('coa-kredit', 'coa kredit', 'required', ['required' => '%s wajib diisi!']);

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'success' => false,
				'msg' => array_values($this->form_validation->error_array())[0]
			];
		} else {
			$config['upload_path']          = './upload/po';
			$config['allowed_types']        = 'jpg|jpeg|png|pdf';
			$config['encrypt_name']         = TRUE;
			$this->load->library('upload', $config);

			if ($jenis_pembayaran == 'kas') {
				if (!$this->upload->do_upload('bukti-bayar')) {
					$response = [
						'success' => false,
						'msg' => $this->upload->display_errors()
					];
				} else {
					$upload = $this->upload->data();
					for ($i = 0; $i < count($rows); $i++) {
						$item[] = $this->cb->get_where('t_po_detail', ['Id' => $id_item[$i]])->row_array();
						// Update coa debit
						$detail_coa_debit[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $coa_debit[$i]])->row_array();
						$anggaran_debit[] = $detail_coa_debit[$i]['anggaran'];
						$posisi_debit[] = $detail_coa_debit[$i]['posisi'];
						$nominal_debit[] = $detail_coa_debit[$i]['nominal'];
						$substr_coa_debit[] = substr($coa_debit[$i], 0, 1);
						$nominal_debit_baru[] = 0;

						if ($posisi_debit[$i] == "AKTIVA") {
							$nominal_debit_baru[$i] = $nominal_debit[$i] + $item[$i]['total'];
						}

						if ($posisi_debit[$i] == "PASIVA") {
							$nominal_debit_baru[$i] = $nominal_debit[$i] - $item[$i]['total'];
						}

						if ($substr_coa_debit[$i] == "1" || $substr_coa_debit[$i] == "2" || $substr_coa_debit[$i] == "3") {
							$table_debit[] = "t_coa_sbb";
							$kolom_debit[] = "no_sbb";
						}
						if ($substr_coa_debit[$i] == "4" || $substr_coa_debit[$i] == "5" || $substr_coa_debit[$i] == "6" || $substr_coa_debit[$i] == "7" || $substr_coa_debit[$i] == "8" || $substr_coa_debit[$i] == "9") {
							$table_debit[] = "t_coalr_sbb";
							$kolom_debit[] = "no_lr_sbb";
						}

						$this->cb->where([$kolom_debit[$i] => $coa_debit[$i]]);
						$this->cb->update($table_debit[$i], ['nominal' => $nominal_debit_baru[$i]]);


						// update coa credit
						$detail_coa_credit[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $coa_kredit])->row_array();
						$posisi_credit[] = $detail_coa_credit[$i]['posisi'];
						$anggaran_credit[] = $detail_coa_credit[$i]['anggaran'];
						$nominal_credit[] = $detail_coa_credit[$i]['nominal'];
						$substr_coa_credit[] = substr($coa_kredit, 0, 1);
						$saldo_credit_baru[] = 0;
						$nominal_credit_baru[] = 0;

						if ($posisi_credit[$i] == "AKTIVA") {
							$nominal_credit_baru[$i] = $nominal_credit[$i] - $item[$i]['total'];
						}
						if ($posisi_credit[$i] == "PASIVA") {
							$nominal_credit_baru[$i] = $nominal_credit[$i] + $item[$i]['total'];
						}

						if ($substr_coa_credit[$i] == "1" || $substr_coa_credit[$i] == "2" || $substr_coa_credit[$i] == "3") {
							$table_credit[] = "t_coa_sbb";
							$kolom_credit[] = "no_sbb";
						}
						if ($substr_coa_credit[$i] == "4" || $substr_coa_credit[$i] == "5" || $substr_coa_credit[$i] == "6" || $substr_coa_credit[$i] == "7" || $substr_coa_credit[$i] = "8" || $substr_coa_credit[$i] = "9") {
							$table_credit[] = "t_coalr_sbb";
							$kolom_credit[] = "no_lr_sbb";
						}

						$this->cb->where([$kolom_credit[$i] => $coa_kredit]);
						$this->cb->update($table_credit[$i], ['nominal' => $nominal_credit_baru[$i]]);


						// update table pengajuan detail
						$this->cb->where('Id', $id_item[$i]);
						$this->cb->update('t_po_detail', [
							'kredit' => $coa_kredit,
							'debit' => $coa_debit[$i]
						]);

						// create jurnal
						$jurnal = [
							'tanggal' => $date_bayar,
							'akun_debit' => $coa_debit[$i],
							'jumlah_debit' => $item[$i]['total'],
							'akun_kredit' => $coa_kredit,
							'jumlah_kredit' => $item[$i]['total'],
							'saldo_debit' => $nominal_debit_baru[$i],
							'saldo_kredit' => $nominal_credit_baru[$i],
							'keterangan' => $item[$i]['item'],
							'created_by' => $this->session->userdata('nip'),
						];
						$this->cb->insert('jurnal_neraca', $jurnal);
					}

					// Update table pengajuan
					$update = [
						'user_bayar' => $this->session->userdata('nip'),
						'posisi' => 'Sudah Dibayar',
						'date_bayar' => $date_bayar,
						'bukti_bayar' => $upload['file_name'],
						'jenis_pembayaran' => $jenis_pembayaran,
						'status_pembayaran' => 1
					];

					$this->cb->where(['Id' => $id]);
					$this->cb->update('t_po', $update);

					$response = [
						'success' => true,
						'msg' => 'PO berhasil diproses!'
					];
				}
			} else {
				for ($i = 0; $i < count($rows); $i++) {
					$item[] = $this->cb->get_where('t_po_detail', ['Id' => $id_item[$i]])->row_array();
					// Update coa debit
					$detail_coa_debit[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $coa_debit[$i]])->row_array();
					$anggaran_debit[] = $detail_coa_debit[$i]['anggaran'];
					$posisi_debit[] = $detail_coa_debit[$i]['posisi'];
					$nominal_debit[] = $detail_coa_debit[$i]['nominal'];
					$substr_coa_debit[] = substr($coa_debit[$i], 0, 1);
					$nominal_debit_baru[] = 0;

					if ($posisi_debit[$i] == "AKTIVA") {
						$nominal_debit_baru[$i] = $nominal_debit[$i] + $item[$i]['total'];
					}

					if ($posisi_debit[$i] == "PASIVA") {
						$nominal_debit_baru[$i] = $nominal_debit[$i] - $item[$i]['total'];
					}

					if ($substr_coa_debit[$i] == "1" || $substr_coa_debit[$i] == "2" || $substr_coa_debit[$i] == "3") {
						$table_debit[] = "t_coa_sbb";
						$kolom_debit[] = "no_sbb";
					}
					if ($substr_coa_debit[$i] == "4" || $substr_coa_debit[$i] == "5" || $substr_coa_debit[$i] == "6" || $substr_coa_debit[$i] == "7" || $substr_coa_debit[$i] == "8" || $substr_coa_debit[$i] == "9") {
						$table_debit[] = "t_coalr_sbb";
						$kolom_debit[] = "no_lr_sbb";
					}

					$this->cb->where([$kolom_debit[$i] => $coa_debit[$i]]);
					$this->cb->update($table_debit[$i], ['nominal' => $nominal_debit_baru[$i]]);


					// update coa credit
					$detail_coa_credit[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $coa_kredit])->row_array();
					$posisi_credit[] = $detail_coa_credit[$i]['posisi'];
					$anggaran_credit[] = $detail_coa_credit[$i]['anggaran'];
					$nominal_credit[] = $detail_coa_credit[$i]['nominal'];
					$substr_coa_credit[] = substr($coa_kredit, 0, 1);
					$saldo_credit_baru[] = 0;
					$nominal_credit_baru[] = 0;

					if ($posisi_credit[$i] == "AKTIVA") {
						$nominal_credit_baru[$i] = $nominal_credit[$i] - $item[$i]['total'];
					}
					if ($posisi_credit[$i] == "PASIVA") {
						$nominal_credit_baru[$i] = $nominal_credit[$i] + $item[$i]['total'];
					}

					if ($substr_coa_credit[$i] == "1" || $substr_coa_credit[$i] == "2" || $substr_coa_credit[$i] == "3") {
						$table_credit[] = "t_coa_sbb";
						$kolom_credit[] = "no_sbb";
					}
					if ($substr_coa_credit[$i] == "4" || $substr_coa_credit[$i] == "5" || $substr_coa_credit[$i] == "6" || $substr_coa_credit[$i] == "7" || $substr_coa_credit[$i] = "8" || $substr_coa_credit[$i] = "9") {
						$table_credit[] = "t_coalr_sbb";
						$kolom_credit[] = "no_lr_sbb";
					}

					$this->cb->where([$kolom_credit[$i] => $coa_kredit]);
					$this->cb->update($table_credit[$i], ['nominal' => $nominal_credit_baru[$i]]);


					// update table pengajuan detail
					$this->cb->where('Id', $id_item[$i]);
					$this->cb->update('t_po_detail', [
						'kredit' => $coa_kredit,
						'debit' => $coa_debit[$i]
					]);

					// create jurnal
					$jurnal = [
						'tanggal' => $date_bayar,
						'akun_debit' => $coa_debit[$i],
						'jumlah_debit' => $item[$i]['total'],
						'akun_kredit' => $coa_kredit,
						'jumlah_kredit' => $item[$i]['total'],
						'saldo_debit' => $nominal_debit_baru[$i],
						'saldo_kredit' => $nominal_credit_baru[$i],
						'keterangan' => $item[$i]['item'],
						'created_by' => $this->session->userdata('nip'),
					];
					$this->cb->insert('jurnal_neraca', $jurnal);
				}

				// Update table pengajuan
				$update = [
					'user_bayar' => $this->session->userdata('nip'),
					'posisi' => 'Hutang',
					'jenis_pembayaran' => $jenis_pembayaran,
					'date_bayar' => $date_bayar
				];

				$this->cb->where(['Id' => $id]);
				$this->cb->update('t_po', $update);

				$response = [
					'success' => true,
					'msg' => 'PO berhasil diproses!'
				];
			}
			// if (!$this->upload->do_upload('bukti-bayar')) {
			// 	$response = [
			// 		'success' => false,
			// 		'msg' => $this->upload->display_errors()
			// 	];
			// } else {
			// 	$upload = $this->upload->data();
			// 	for ($i = 0; $i < count($rows); $i++) {
			// 		$item[] = $this->cb->get_where('t_po_detail', ['Id' => $id_item[$i]])->row_array();
			// 		// Update coa debit
			// 		$detail_coa_debit[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $coa_debit[$i]])->row_array();
			// 		$anggaran_debit[] = $detail_coa_debit[$i]['anggaran'];
			// 		$posisi_debit[] = $detail_coa_debit[$i]['posisi'];
			// 		$nominal_debit[] = $detail_coa_debit[$i]['nominal'];
			// 		$substr_coa_debit[] = substr($coa_debit[$i], 0, 1);
			// 		$nominal_debit_baru[] = 0;

			// 		if ($posisi_debit[$i] == "AKTIVA") {
			// 			$nominal_debit_baru[$i] = $nominal_debit[$i] + $item[$i]['total'];
			// 		}

			// 		if ($posisi_debit[$i] == "PASIVA") {
			// 			$nominal_debit_baru[$i] = $nominal_debit[$i] - $item[$i]['total'];
			// 		}

			// 		if ($substr_coa_debit[$i] == "1" || $substr_coa_debit[$i] == "2" || $substr_coa_debit[$i] == "3") {
			// 			$table_debit[] = "t_coa_sbb";
			// 			$kolom_debit[] = "no_sbb";
			// 		}
			// 		if ($substr_coa_debit[$i] == "4" || $substr_coa_debit[$i] == "5" || $substr_coa_debit[$i] == "6" || $substr_coa_debit[$i] == "7" || $substr_coa_debit[$i] == "8" || $substr_coa_debit[$i] == "9") {
			// 			$table_debit[] = "t_coalr_sbb";
			// 			$kolom_debit[] = "no_lr_sbb";
			// 		}

			// 		$this->cb->where([$kolom_debit[$i] => $coa_debit[$i]]);
			// 		$this->cb->update($table_debit[$i], ['nominal' => $nominal_debit_baru[$i]]);


			// 		// update coa credit
			// 		$detail_coa_credit[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $coa_kredit[$i]])->row_array();
			// 		$posisi_credit[] = $detail_coa_credit[$i]['posisi'];
			// 		$anggaran_credit[] = $detail_coa_credit[$i]['anggaran'];
			// 		$nominal_credit[] = $detail_coa_credit[$i]['nominal'];
			// 		$substr_coa_credit[] = substr($coa_kredit[$i], 0, 1);
			// 		$saldo_credit_baru[] = 0;
			// 		$nominal_credit_baru[] = 0;

			// 		if ($posisi_credit[$i] == "AKTIVA") {
			// 			$nominal_credit_baru[$i] = $nominal_credit[$i] - $item[$i]['total'];
			// 		}
			// 		if ($posisi_credit[$i] == "PASIVA") {
			// 			$nominal_credit_baru[$i] = $nominal_credit[$i] + $item[$i]['total'];
			// 		}

			// 		if ($substr_coa_credit[$i] == "1" || $substr_coa_credit[$i] == "2" || $substr_coa_credit[$i] == "3") {
			// 			$table_credit[] = "t_coa_sbb";
			// 			$kolom_credit[] = "no_sbb";
			// 		}
			// 		if ($substr_coa_credit[$i] == "4" || $substr_coa_credit[$i] == "5" || $substr_coa_credit[$i] == "6" || $substr_coa_credit[$i] == "7" || $substr_coa_credit[$i] = "8" || $substr_coa_credit[$i] = "9") {
			// 			$table_credit[] = "t_coalr_sbb";
			// 			$kolom_credit[] = "no_lr_sbb";
			// 		}

			// 		$this->cb->where([$kolom_credit[$i] => $coa_kredit[$i]]);
			// 		$this->cb->update($table_credit[$i], ['nominal' => $nominal_credit_baru[$i]]);


			// 		// update table pengajuan detail
			// 		$this->cb->where('Id', $id_item[$i]);
			// 		$this->cb->update('t_po_detail', [
			// 			'kredit' => $coa_kredit[$i],
			// 			'debit' => $coa_debit[$i]
			// 		]);

			// 		// create jurnal
			// 		$jurnal = [
			// 			'tanggal' => $date_bayar,
			// 			'akun_debit' => $coa_debit[$i],
			// 			'jumlah_debit' => $item[$i]['total'],
			// 			'akun_kredit' => $coa_kredit[$i],
			// 			'jumlah_kredit' => $item[$i]['total'],
			// 			'saldo_debit' => $nominal_debit_baru[$i],
			// 			'saldo_kredit' => $nominal_credit_baru[$i],
			// 			'keterangan' => $item[$i]['item'],
			// 			'created_by' => $this->session->userdata('nip'),
			// 		];
			// 		$this->cb->insert('jurnal_neraca', $jurnal);
			// 	}

			// 	// Update table pengajuan
			// 	$update = [
			// 		'user_bayar' => $this->session->userdata('nip'),
			// 		'posisi' => 'Sudah Dibayar',
			// 		'date_bayar' => $date_bayar,
			// 		'bukti_bayar' => $upload['file_name'],
			// 	];

			// 	$this->cb->where(['Id' => $id]);
			// 	$this->cb->update('t_po', $update);

			// 	$response = [
			// 		'success' => true,
			// 		'msg' => 'Pengajuan berhasil dibayar!'
			// 	];
			// }
		}

		echo json_encode($response);
	}

	public function getDataCoa($id)
	{
		$data_coa = $this->cb->get_where('v_coa_all', ['no_sbb' => $id])->row_array();
		echo json_encode($data_coa);
	}

	public function po_out()
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

				$this->db->where('stok >', 0);
				$data['item_list'] = $this->db->get('item_list');
				$data['vendors'] = $this->cb->get('t_vendors');
				$data['title'] = "Create PO Out";
				$data['pages'] = "pages/aset/v_po_out";
				$this->load->view('index', $data);
			}
		}
	}

	public function getItemById()
	{
		$id = $this->input->post('id');
		$item = $this->db->get_where('item_list', ['Id' => $id])->row_array();
		$this->db->order_by('tanggal_masuk', 'DESC');
		$data = $this->db->get_where('item_detail', ['kode_item' => $id, 'status' => 'A'])->result();
		$option = "";
		if ($data) {
			foreach ($data as $row) {
				$option .= "<option value='$row->Id'>$row->serial_number</option>";
			}
		} else {
			$option .= "<option value='' selected>Tidak ada data detail</option>";
		}



		$response = [
			'option' => $option,
			'harga' => $item['harga_sat']
		];
		echo json_encode($response);
	}

	public function save_po_out()
	{
		$tanggal = $this->input->post('tanggal');
		$keterangan = $this->input->post('keterangan');
		$asset = $this->input->post('asset');
		$rows = $this->input->post('row[]');
		$item = $this->input->post('item[]');
		$qty = $this->input->post('qty[]');
		$price = $this->input->post('harga[]');
		// $detail_item = $this->input->post('detail_item[]');
		$sub_total = $this->input->post('total[]');
		$total = $this->input->post('nominal');
		$now = date('Y-m-d');
		$teknisi = $this->input->post('teknisi');
		if (strtotime($tanggal) != strtotime($now)) {
			$tgl = $tanggal;
		} else {
			$tgl = date('Y-m-d H:i:s');
		}

		$this->form_validation->set_rules('tanggal', 'tanggal', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('teknisi', 'nama teknisi', 'required|trim', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('asset', 'asset', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('item[]', 'item', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('qty[]', 'qty', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('harga[]', 'harga', 'required', ['required' => '%s wajib diisi!']);
		// for ($i = 0; $i < count($rows); $i++) {
		// 	$detail[] = $this->db->get_where('item_detail', ['kode_item' => $item[$i], 'status' => 'A']);
		// 	if ($detail[$i]->num_rows() > 0) {
		// 		$this->form_validation->set_rules('detail_item[]', 'detail item', 'required', ['required' => '%s wajib diisi!']);
		// 	}
		// }

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'success' => false,
				'msg' => array_values($this->form_validation->error_array())[0]
			];
		} else {
			$count = $this->cb->get('t_po_out')->num_rows();
			$count = $count + 1;
			$no_po = sprintf("%06d", $count);

			for ($i = 0; $i < count($rows); $i++) {
				// $this->db->select('Id, kode_item, serial_number');
				// $item_detail[] = $this->db->get_where('item_detail', ['kode_item' => $item[$i]])->result_array();
				$item_list[] = $this->db->get_where('item_list', ['Id' => $item[$i]])->row_array();

				if ($qty[$i] < 1) {
					$response = [
						'success' => false,
						'msg' => 'Stok item ' . $item_list[$i]['nama'] . ' tidak boleh kosong'
					];

					echo json_encode($response);
					return false;
				}

				if ($qty[$i] > $item_list[$i]['stok']) {
					$response = [
						'success' => false,
						'msg' => 'Stok item ' . $item_list[$i]['nama'] . ' kurang'
					];

					echo json_encode($response);
					return false;
				}


				$insert_detail = [
					'no_po' => $no_po,
					'item' => $item[$i],
					'qty' => $qty[$i],
					'price' => str_replace('.', '', $price[$i]),
					'total' => str_replace('.', '', $sub_total[$i]),
					// 'detail' => json_encode($detail_item[$i])
				];

				$this->cb->insert('t_po_out_detail', $insert_detail);
			}

			$insert = [
				'tgl_pengajuan' => $tgl,
				'keterangan' => $keterangan,
				'user' => $this->session->userdata('nip'),
				'asset' => $asset,
				'no_po' => $no_po,
				'total' => str_replace('.', '', $total),
				'posisi' => 'Diajukan kepada sarlog',
				'teknisi' => $teknisi
			];

			$this->cb->insert('t_po_out', $insert);

			$response = [
				'success' => true,
				'msg' => 'PO berhasil diajukan!'
			];
		}
		echo json_encode($response);
	}

	public function po_list_out()
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

		$data['count_sarlog'] = $this->m_asset->count_po_out(['status_sarlog' => 0]);
		$data['count_direksi'] = $this->m_asset->count_po_out(['status_sarlog' => 1, 'direksi' => $this->session->userdata('nip'), 'status_direksi' => 0]);
		$data['po'] = $this->m_asset->get_poOutList(['user' => $this->session->userdata('nip')]);
		$data['title'] = "PO List Out";
		$data['pages'] = "pages/aset/v_po_list_out";
		$this->load->view('index', $data);
	}

	public function sarlog_out()
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

		$data['po'] = $this->m_asset->get_poOutList(['user !=' => $this->session->userdata('nip')]);
		$data['direksi'] = $this->db->get_where('users', ['level_jabatan >' => 4])->result_array();
		$data['title'] = "List PO Item Out Sarlog";
		$data['pages'] = "pages/aset/v_sarlog_out";
		$this->load->view('index', $data);
	}

	public function update_sarlog_out()
	{
		$id = $this->input->post('id_po');
		$tgl = $this->input->post('tanggal');
		$status = $this->input->post('status');
		$direksi = $this->input->post('direksi');
		$catatan = $this->input->post('catatan');

		$now = date('Y-m-d');
		if (strtotime($tgl) != strtotime($now)) {
			$tgl = $tgl;
		} else {
			$tgl = date('Y-m-d H:i:s');
		}

		$this->form_validation->set_rules('tanggal', 'tanggal', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('status', 'status', 'required|in_list[1,2]', ['required' => '%s wajib diisi!']);
		if ($status == 1) {
			$this->form_validation->set_rules('direksi', 'direksi', 'required', ['required' => '%s wajib diisi!']);
		}

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'success' => false,
				'msg' => array_values($this->form_validation->error_array())[0]
			];
		} else {
			if ($status == 1) {
				$posisi = 'diajukan kepada direksi';
				$direksi = $direksi;
			} else {
				$posisi = 'ditolak sarlog';
				$direksi = null;
			}

			$update = [
				'status_sarlog' => $status,
				'sarlog' => $this->session->userdata('nip'),
				'posisi' => $posisi,
				'date_sarlog' => $tgl,
				'catatan_sarlog' => $catatan,
				'direksi' => $direksi
			];

			$this->cb->where('Id', $id);
			$this->cb->update('t_po_out', $update);

			$response = [
				'success' => true,
				'msg' => 'Status PO berhasil diubah!'
			];
		}

		echo json_encode($response);
	}

	public function direksi_out()
	{
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

		$data['po'] = $this->m_asset->get_poOutList(['status_sarlog' => 1, 'direksi' => $this->session->userdata('nip')]);
		$data['direksi'] = $this->db->get_where('users', ['level_jabatan >' => 4])->result_array();
		$data['title'] = "List PO Item Out Direksi";
		$data['pages'] = "pages/aset/v_direksi_out";
		$this->load->view('index', $data);
	}

	public function update_direksi_out()
	{
		$id = $this->input->post('id_po');
		$tgl = $this->input->post('tanggal');
		$status = $this->input->post('status');
		$catatan = $this->input->post('catatan');

		$now = date('Y-m-d');
		if (strtotime($tgl) != strtotime($now)) {
			$tgl = $tgl;
		} else {
			$tgl = date('Y-m-d H:i:s');
		}

		$this->form_validation->set_rules('tanggal', 'tanggal', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('status', 'status', 'required|in_list[1,2]', ['required' => '%s wajib diisi!']);

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'success' => false,
				'msg' => array_values($this->form_validation->error_array())[0]
			];
		} else {
			if ($status == 1) {
				$posisi = 'Disetujui Direksi';
			} else {
				$posisi = 'ditolak direksi';
			}
			$update = [
				'status_direksi' => $status,
				'posisi' => $posisi,
				'date_direksi' => $tgl,
				'catatan_direksi' => $catatan,
			];

			$this->cb->where('Id', $id);
			$this->cb->update('t_po_out', $update);

			$response = [
				'success' => true,
				'msg' => 'Status PO berhasil diubah!'
			];
		}

		echo json_encode($response);
	}

	public function serah_item($id)
	{
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

		$data['coa'] = $this->cb->get('v_coa_all');
		$data['po'] = $this->m_asset->get_poOutList(['a.Id' => $id])->row_array();
		$data['title'] = "Serahkan Item";
		$data['pages'] = "pages/aset/v_serah_item";
		$this->load->view('index', $data);
	}

	public function update_serahItem()
	{
		$id = $this->input->post('id_po');
		$coa_beban = $this->input->post('coa_beban[]');
		$coa_persediaan = $this->input->post('coa_persediaan[]');
		$detail_item = $this->input->post('detail_item[]');
		$id_item = $this->input->post('id_item[]');
		$rows = $this->input->post('row_item[]');
		$tgl = $this->input->post('tanggal');
		$now = date('Y-m-d');

		if (strtotime($tgl) != strtotime($now)) {
			$date_serah = $tgl;
		} else {
			$date_serah = date('Y-m-d H:i:s');
		}

		$po = $this->cb->get_where('t_po_out', ['Id' => $id])->row_array();

		for ($i = 0; $i < count($rows); $i++) {
			$this->form_validation->set_rules('detail_item[' . $i . ']', 'detail item', 'required', ['required' => '%s wajib diisi!']);
		}
		// $this->form_validation->set_rules('detail_item[]', 'detail item', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('coa_persediaan[]', 'coa persediaan', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('coa_beban[]', 'coa beban', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('tanggal', 'tanggal', 'required', ['required' => '%s wajib diisi!']);

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'success' => false,
				'msg' => array_values($this->form_validation->error_array())[0]
			];
		} else {
			$config['upload_path']          = './upload/po';
			$config['allowed_types']        = 'jpg|jpeg|png|pdf';
			$config['encrypt_name']         = TRUE;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('bukti-serah')) {
				$response = [
					'success' => false,
					'msg' => $this->upload->display_errors()
				];
			} else {
				$upload = $this->upload->data();
				for ($i = 0; $i < count($rows); $i++) {
					$item[] = $this->cb->get_where('t_po_out_detail', ['Id' => $id_item[$i]])->row_array();
					$item_list[] = $this->db->get_where('item_list', ['Id' => $item[$i]['item']])->row_array();
					$stok[] = $item_list[$i]['stok'] - $item[$i]['qty'];

					// update stok item list
					$this->db->where('Id', $item[$i]['item']);
					$this->db->update('item_list', ['stok' => $stok[$i]]);

					// update statu item detail 
					$this->db->where_in('Id', $detail_item[$i]);
					$this->db->update('item_detail', ['status' => 'O']);

					// debit
					$detail_coa_beban[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $coa_beban[$i]])->row_array();
					$anggaran_beban[] = $detail_coa_beban[$i]['anggaran'];
					$posisi_beban[] = $detail_coa_beban[$i]['posisi'];
					$nominal_beban[] = $detail_coa_beban[$i]['nominal'];
					$substr_coa_beban[] = substr($coa_beban[$i], 0, 1);
					$nominal_beban_baru[] = 0;

					if ($posisi_beban[$i] == "AKTIVA") {
						$nominal_beban_baru[$i] = $nominal_beban[$i] + $item[$i]['total'];
					}

					if ($posisi_beban[$i] == "PASIVA") {
						$nominal_beban_baru[$i] = $nominal_beban[$i] - $item[$i]['total'];
					}

					if ($substr_coa_beban[$i] == "1" || $substr_coa_beban[$i] == "2" || $substr_coa_beban[$i] == "3") {
						$table_beban[] = "t_coa_sbb";
						$kolom_beban[] = "no_sbb";
					}
					if ($substr_coa_beban[$i] == "4" || $substr_coa_beban[$i] == "5" || $substr_coa_beban[$i] == "6" || $substr_coa_beban[$i] == "7" || $substr_coa_beban[$i] == "8" || $substr_coa_beban[$i] == "9") {
						$table_beban[] = "t_coalr_sbb";
						$kolom_beban[] = "no_lr_sbb";
					}

					$this->cb->where([$kolom_beban[$i] => $coa_beban[$i]]);
					$this->cb->update($table_beban[$i], ['nominal' => $nominal_beban_baru[$i]]);


					// update coa credit
					$detail_coa_persediaan[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $coa_persediaan[$i]])->row_array();
					$posisi_persediaan[] = $detail_coa_persediaan[$i]['posisi'];
					$anggaran_persediaan[] = $detail_coa_persediaan[$i]['anggaran'];
					$nominal_persediaan[] = $detail_coa_persediaan[$i]['nominal'];
					$substr_coa_persediaan[] = substr($coa_persediaan[$i], 0, 1);
					$saldo_persediaan_baru[] = 0;
					$nominal_persediaan_baru[] = 0;

					if ($posisi_persediaan[$i] == "AKTIVA") {
						$nominal_persediaan_baru[$i] = $nominal_persediaan[$i] - $item[$i]['total'];
					}
					if ($posisi_persediaan[$i] == "PASIVA") {
						$nominal_persediaan_baru[$i] = $nominal_persediaan[$i] + $item[$i]['total'];
					}

					if ($substr_coa_persediaan[$i] == "1" || $substr_coa_persediaan[$i] == "2" || $substr_coa_persediaan[$i] == "3") {
						$table_persediaan[] = "t_coa_sbb";
						$kolom_persediaan[] = "no_sbb";
					}
					if ($substr_coa_persediaan[$i] == "4" || $substr_coa_persediaan[$i] == "5" || $substr_coa_persediaan[$i] == "6" || $substr_coa_persediaan[$i] == "7" || $substr_coa_persediaan[$i] = "8" || $substr_coa_persediaan[$i] = "9") {
						$table_persediaan[] = "t_coalr_sbb";
						$kolom_persediaan[] = "no_lr_sbb";
					}

					$this->cb->where([$kolom_persediaan[$i] => $coa_persediaan[$i]]);
					$this->cb->update($table_persediaan[$i], ['nominal' => $nominal_persediaan_baru[$i]]);


					// update table pengajuan detail
					$this->cb->where('Id', $id_item[$i]);
					$this->cb->update('t_po_out_detail', [
						'persediaan' => $coa_persediaan[$i],
						'beban' => $coa_beban[$i]
					]);

					// create jurnal
					$jurnal = [
						'tanggal' => $date_serah,
						'akun_debit' => $coa_beban[$i],
						'jumlah_debit' => $item[$i]['total'],
						'akun_kredit' => $coa_persediaan[$i],
						'jumlah_kredit' => $item[$i]['total'],
						'saldo_debit' => $nominal_beban_baru[$i],
						'saldo_kredit' => $nominal_persediaan_baru[$i],
						'keterangan' => $item[$i]['item'],
						'created_by' => $this->session->userdata('nip'),
					];

					$this->cb->insert('jurnal_neraca', $jurnal);

					// create item out
					$item_out = [
						'no_po' => $po['no_po'],
						'item_id' => $id_item[$i],
						'asset_id' => $po['asset'],
						'harga' => $item[$i]['price'],
						'jml' => $item[$i]['qty'],
						'status' => 1,
						'user' => $po['user'],
						'user_serah' => $this->session->userdata('nip'),
						'penerima' => $po['teknisi'],
						'image' => $upload['file_name'],
						'date_serah' => $date_serah
					];
					$this->db->insert('item_out', $item_out);
				}

				// Update table pengajuan
				$update = [
					'posisi' => 'Barang sudah diserahkan!',
				];

				$this->cb->where(['Id' => $id]);
				$this->cb->update('t_po_out', $update);

				$response = [
					'success' => true,
					'msg' => 'Barang berhasil diserahkan!'
				];
			}
		}
		echo json_encode($response);
	}

	public function bayar($id)
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

		$data['coa'] = $this->cb->get('v_coa_all');
		$data['po'] = $this->m_asset->get_poList(['a.Id' => $id])->row_array();
		$data['title'] = "Form Bayar";
		$data['pages'] = "pages/aset/v_bayar";
		$this->load->view('index', $data);
	}

	public function update_bayar()
	{
		$id = $this->input->post('id_po');
		$coa_kas = $this->input->post('coa-kas');
		$id_item = $this->input->post('id_item[]');
		$rows = $this->input->post('row_item[]');
		$tgl = $this->input->post('tanggal');
		$now = date('Y-m-d');
		$jenis_pembayaran = $this->input->post('jenis-pembayaran');

		if (strtotime($tgl) != strtotime($now)) {
			$date_bayar = $tgl;
		} else {
			$date_bayar = date('Y-m-d H:i:s');
		}

		$this->form_validation->set_rules('tanggal', 'tanggal', 'required', ['required' => '%s wajib diisi!']);
		$this->form_validation->set_rules('coa-kas', 'coa kas', 'required', ['required' => '%s wajib diisi!']);

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'success' => false,
				'msg' => array_values($this->form_validation->error_array())[0]
			];
		} else {
			$config['upload_path']          = './upload/po';
			$config['allowed_types']        = 'jpg|jpeg|png|pdf';
			$config['encrypt_name']         = TRUE;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('bukti-bayar')) {
				$response = [
					'success' => false,
					'msg' => $this->upload->display_errors()
				];
			} else {
				$upload = $this->upload->data();
				for ($i = 0; $i < count($rows); $i++) {
					$item[] = $this->cb->get_where('t_po_detail', ['Id' => $id_item[$i]])->row_array();

					// Update coa debit
					$detail_coa_hutang[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $item[$i]['kredit']])->row_array();
					$anggaran_hutang[] = $detail_coa_hutang[$i]['anggaran'];
					$posisi_hutang[] = $detail_coa_hutang[$i]['posisi'];
					$nominal_hutang[] = $detail_coa_hutang[$i]['nominal'];
					$substr_coa_hutang[] = substr($item[$i]['kredit'], 0, 1);
					$nominal_hutang_baru[] = 0;

					if ($posisi_hutang[$i] == "AKTIVA") {
						$nominal_hutang_baru[$i] = $nominal_hutang[$i] + $item[$i]['total'];
					}

					if ($posisi_hutang[$i] == "PASIVA") {
						$nominal_hutang_baru[$i] = $nominal_hutang[$i] - $item[$i]['total'];
					}

					if ($substr_coa_hutang[$i] == "1" || $substr_coa_hutang[$i] == "2" || $substr_coa_hutang[$i] == "3") {
						$table_hutang[] = "t_coa_sbb";
						$kolom_hutang[] = "no_sbb";
					}
					if ($substr_coa_hutang[$i] == "4" || $substr_coa_hutang[$i] == "5" || $substr_coa_hutang[$i] == "6" || $substr_coa_hutang[$i] == "7" || $substr_coa_hutang[$i] == "8" || $substr_coa_hutang[$i] == "9") {
						$table_hutang[] = "t_coalr_sbb";
						$kolom_hutang[] = "no_lr_sbb";
					}

					$this->cb->where([$kolom_hutang[$i] => $item[$i]['kredit']]);
					$this->cb->update($table_hutang[$i], ['nominal' => $nominal_hutang_baru[$i]]);


					// update coa credit
					$detail_coa_kas[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $coa_kas])->row_array();
					$posisi_kas[] = $detail_coa_kas[$i]['posisi'];
					$anggaran_kas[] = $detail_coa_kas[$i]['anggaran'];
					$nominal_kas[] = $detail_coa_kas[$i]['nominal'];
					$substr_coa_kas[] = substr($coa_kas, 0, 1);
					$saldo_kas_baru[] = 0;
					$nominal_kas_baru[] = 0;

					if ($posisi_kas[$i] == "AKTIVA") {
						$nominal_kas_baru[$i] = $nominal_kas[$i] - $item[$i]['total'];
					}
					if ($posisi_kas[$i] == "PASIVA") {
						$nominal_kas_baru[$i] = $nominal_kas[$i] + $item[$i]['total'];
					}

					if ($substr_coa_kas[$i] == "1" || $substr_coa_kas[$i] == "2" || $substr_coa_kas[$i] == "3") {
						$table_kas[] = "t_coa_sbb";
						$kolom_kas[] = "no_sbb";
					}
					if ($substr_coa_kas[$i] == "4" || $substr_coa_kas[$i] == "5" || $substr_coa_kas[$i] == "6" || $substr_coa_kas[$i] == "7" || $substr_coa_kas[$i] = "8" || $substr_coa_kas[$i] = "9") {
						$table_kas[] = "t_coalr_sbb";
						$kolom_kas[] = "no_lr_sbb";
					}

					$this->cb->where([$kolom_kas[$i] => $coa_kas]);
					$this->cb->update($table_kas[$i], ['nominal' => $nominal_kas_baru[$i]]);


					// update table pengajuan detail
					$this->cb->where('Id', $id_item[$i]);
					$this->cb->update('t_po_detail', [
						'kas' => $coa_kas,
					]);

					// create jurnal
					$jurnal = [
						'tanggal' => $date_bayar,
						'akun_debit' => $item[$i]['kredit'],
						'jumlah_debit' => $item[$i]['total'],
						'akun_kredit' => $coa_kas,
						'jumlah_kredit' => $item[$i]['total'],
						'saldo_debit' => $nominal_hutang_baru[$i],
						'saldo_kredit' => $nominal_kas_baru[$i],
						'keterangan' => $item[$i]['item'],
						'created_by' => $this->session->userdata('nip'),
					];
					$this->cb->insert('jurnal_neraca', $jurnal);
				}

				// Update table pengajuan
				$update = [
					'user_bayar' => $this->session->userdata('nip'),
					'posisi' => 'Sudah Dibayar',
					'date_bayar' => $date_bayar,
					'bukti_bayar' => $upload['file_name'],
					'status_pembayaran' => 1
				];

				$this->cb->where(['Id' => $id]);
				$this->cb->update('t_po', $update);

				$response = [
					'success' => true,
					'msg' => 'PO berhasil dibayar!'
				];
			}
		}
		echo json_encode($response);
	}

	public function item_out()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '501') !== false) {
				//pagination settings
				$config['base_url'] = site_url('asset/item_out');
				$config['total_rows'] = $this->m_asset->itemOut_count();
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
				$data['users_data'] = $this->m_asset->itemOut_get($config["per_page"], $data['page']);
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

				$data['title'] = "Item Out";
				$data['pages'] = 'pages/aset/v_item_out';
				$this->load->view('index', $data);
			}
		}
	}

	public function close_item_out()
	{
		$id = $this->input->post('id_item_out');
		$config = [
			'upload_path' => './upload/po',
			'allowed_types' => 'jpg|jpeg|png',
		];

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('image_close')) {
			$response = [
				'success' => FALSE,
				'msg' => $this->upload->display_errors()
			];
		} else {
			$image = $this->upload->data();
			$config2 = [
				'image_library' => 'gd2',
				'source_image' => './upload/po/' . $image['file_name'],
				'create_thumb' => false,
				'maintain_ratio' => false,
				'quality' => '85%',
				'width' => 675,
				'height' => 450,
			];

			$this->load->library('image_lib', $config2);
			$this->image_lib->resize();

			$update = [
				'image_close' => $image['file_name'],
				'status' => 2,
				'user_close' => $this->session->userdata('nip'),
				'date_close' => date('Y-m-d H:i:s')
			];

			$this->db->where('Id', $id);
			$this->db->update('item_out', $update);

			$response = [
				'success' => true,
				'msg' => 'Data berhasil diubah!'
			];
		}
		echo json_encode($response);
	}

	public function report_asset()
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

		$data['title'] = "Report asset";
		$data['asset'] = $this->db->get('asset_list');
		$data['pages'] = 'pages/aset/v_report_asset';
		$this->load->view('index', $data);
	}

	public function export_report()
	{
		$asset = $this->input->post('asset');
		$dari = $this->input->post('dari');
		$sampai = $this->input->post('sampai');

		$sql = "SELECT * FROM item_out WHERE asset_id = '$asset' and (tanggal >= '$dari' OR tanggal <= '$sampai')";
		$data['report'] = $this->db->query($sql)->result_array();
		$data['asset'] = $this->db->get_where('asset_list', ['Id' => $asset])->row_array();
		$file_pdf = 'Penggunaan Item Asset . ' . $data['asset']['nama_asset'] . ' | ' . $data['asset']['kode'];
		// setting paper
		$paper = 'A4';

		//orientasi paper potrait / landscape
		$orientation = "portrait";

		$html = $this->load->view('pages/aset/v_report_asset_pdf', $data, true);

		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
	}

	public function print($id)
	{
		$data['po'] = $this->cb->get_where('t_po', ['Id' => $id])->row_array();
		// $this->load->view('pages/aset/v_print_po', $data);
		// filename dari pdf ketika didownload
		$file_pdf = 'Purchase Order Item In. ' . $data['po']['no_po'];

		// setting paper
		$paper = 'A4';

		//orientasi paper potrait / landscape
		$orientation = "portrait";

		$html = $this->load->view('pages/aset/v_print_po', $data, true);

		// run dompdf
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
	}

	public function print_po_out($id)
	{
		$data['po'] = $this->cb->get_where('t_po_out', ['Id' => $id])->row_array();
		// $this->load->view('pages/aset/v_print_po', $data);
		// filename dari pdf ketika didownload
		$file_pdf = 'Purchase Order Item In. ' . $data['po']['no_po'];

		// setting paper
		$paper = 'A4';

		//orientasi paper potrait / landscape
		$orientation = "portrait";

		$html = $this->load->view('pages/aset/v_print_po_out', $data, true);

		// run dompdf
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
	}
}
