<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library(['session', 'pagination']);
		$this->load->helper(['string', 'url', 'date']);
		$this->load->model('M_Customer');

		$this->cb = $this->load->database('corebank', TRUE);

		if (!$this->session->userdata('nip')) {
			redirect('login');
		}
	}

	public function index()
	{

		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];

		$sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		$query2 = $this->db->query($sql2);
		$res2 = $query2->result_array();
		$result2 = $res2[0]['COUNT(id)'];

		$data['count_inbox'] = $result;
		$data['count_inbox2'] = $result2;

		$data['title'] = "Customer";

		$data['customers'] = $this->M_Customer->customer();

		// $this->load->view('customer', $data);
		$data['title'] = "Customer";
		$data['pages'] = "pages/customer/v_customer";

		$this->load->view('index', $data);
	}

	public function store()
	{
		$nama_customer = $this->input->post('nama_customer');
		$slug = url_title($nama_customer, 'dash', true);

		$data = [
			'nama_customer' => $nama_customer,
			'alamat_customer' => $this->input->post('alamat_customer'),
			'telepon_customer' => $this->input->post('telepon_customer'),
			'status_customer' => $this->input->post('status_customer'),
			'no_npwp' => $this->input->post('no_npwp'),
			'slug' => $slug,
		];

		$old_slug = $this->uri->segment(3);
		// echo '<pre>';
		// print_r($old_slug);
		// echo '</pre>';
		// exit;

		if ($old_slug) {
			$this->M_Customer->update($data, $old_slug);

			$this->session->set_flashdata('message_name', 'The customer has been successfully updated.');
		} else {
			if ($this->M_Customer->is_available($slug)) {
				$this->session->set_flashdata('message_error', 'Customer ' . $nama_customer . ' sudah ada.');
			} else {
				$this->M_Customer->insert($data);

				$this->session->set_flashdata('message_name', 'The customer has been successfully added.');
			}
		}

		redirect("customer");
	}
}
