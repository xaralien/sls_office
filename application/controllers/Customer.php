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
		$keyword = trim($this->input->post('keyword', true) ?? '');

		$config = [
			'base_url' => site_url('financial/fe_pending'),
			'total_rows' => $this->M_Customer->customer_count($keyword),
			'per_page' => 20,
			'uri_segment' => 3,
			'num_links' => 10,
			'full_tag_open' => '<ul class="pagination" style="margin: 0 0">',
			'full_tag_close' => '</ul>',
			'first_link' => false,
			'last_link' => false,
			'first_tag_open' => '<li>',
			'first_tag_close' => '</li>',
			'prev_link' => '«',
			'prev_tag_open' => '<li class="prev">',
			'prev_tag_close' => '</li>',
			'next_link' => '»',
			'next_tag_open' => '<li>',
			'next_tag_close' => '</li>',
			'last_tag_open' => '<li>',
			'last_tag_close' => '</li>',
			'cur_tag_open' => '<li class="active"><a href="#">',
			'cur_tag_close' => '</a></li>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>'
		];

		$this->pagination->initialize($config);

		$page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
		$customers = $this->M_Customer->list_customers($config["per_page"], $page, $keyword);

		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$result = $query->row_array()['COUNT(Id)'];

		$sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		$query2 = $this->db->query($sql2);
		$result2 = $query2->row_array()['COUNT(id)'];

		$data = [
			'page' => $page,
			'customers' => $customers,
			'count_inbox' => $result,
			'count_inbox2' => $result2,
			'keyword' => $keyword,
			'title' => "Customer",
			'pages' => "pages/customer/v_customer"
		];
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
