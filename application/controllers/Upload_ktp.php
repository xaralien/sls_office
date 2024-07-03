<?php

class Upload_ktp extends CI_Controller {

	function __construct()
	{
    parent::__construct();     
	$this->load->model('m_app');
	$this->load->model('m_app_umrah');
    $this->load->library(array('form_validation','session'));    
	$this->load->database();    
    $this->load->helper('url','form');
    $this->load->helper('string'); 
	}

	function index()
	{
		$session = $this->session->userdata('isLogin');
    
		if($session == FALSE)
		{
			redirect('login/login_form');
		}else
		{
			$this->load->view('input_customer_view', array('error' => ' ' ));
		}
	}
	
	function do_upload_umrah()
	{
		if($this->session->userdata('isLogin') == FALSE)
		{ 
			redirect('login'); 
		}else{
			$this->form_validation->set_rules('package_name', 'package_name', 'required');
			$this->form_validation->set_rules('date_depart', 'date_depart', 'required');
			$this->form_validation->set_rules('duration', 'duration', 'required');
			$this->form_validation->set_rules('price4', 'price4', 'required|trim');
			$this->form_validation->set_rules('price3', 'price3', 'required|trim');
			$this->form_validation->set_rules('price2', 'price2', 'required|trim');
			$this->form_validation->set_rules('quota_awal', 'quota_awal', 'required|trim');
			$this->form_validation->set_rules('quota_sisa', 'quota_sisa', 'required|trim');
			$this->form_validation->set_rules('hotel_mekah_nama', 'hotel_mekah_nama', 'required');
			$this->form_validation->set_rules('hotel_madinah_nama', 'hotel_madinah_nama', 'required');
			$this->form_validation->set_rules('hotel_mekah', 'hotel_mekah', 'required|trim');
			$this->form_validation->set_rules('hotel_madinah', 'hotel_madinah', 'required|trim');
			$this->form_validation->set_rules('dateline_payment', 'dateline_payment', 'required');
			$this->form_validation->set_rules('dateline_document', 'dateline_document', 'required');
			$this->form_validation->set_rules('dateline_visa', 'dateline_visa', 'required');
			$this->form_validation->set_rules('manasik_date', 'manasik_date', 'required');
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if($this->form_validation->run()==FALSE)
			{
				echo '<script>alert("Have an error Input!");</script>';
				$this->load->view('input_umrah_view');
			}else {
				
				$image				= random_string('alnum',8);
				//upload image umrah
				$config['upload_path'] = './img/umrah/';
				$config['allowed_types'] = 'jpg|jpeg';
				$config['file_name'] = $image;
				$config['overwrite']= TRUE;
				$config['max_size']	= '1024';
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload())
				{
					$error = array('error' => $this->upload->display_errors());
					$this->load->view('input_umrah_view', $error);
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());

					$this->m_app_umrah->simpan_umrah($image);
					echo '<script>alert("new product successfully saved!");</script>';
					$this->load->view('input_umrah_view');
				}
			}
		}
		
	}
	
	function do_upload()
	{
		if($this->session->userdata('isLogin') == FALSE)
		{ 
			redirect('login'); 
		}else{
			
			$this->form_validation->set_rules('customer_name', 'customer_name', 'required');
			$this->form_validation->set_rules('identity_number', 'identity_number', 'required|trim');
			$this->form_validation->set_rules('Address', 'Address', 'required');
			$this->form_validation->set_rules('gender', 'gender', 'required');
			$this->form_validation->set_rules('marital', 'marital', 'required');
			$this->form_validation->set_rules('date_pic', 'date_pic', 'required');
			$this->form_validation->set_rules('salary', 'salary', 'required|trim');
			$this->form_validation->set_rules('Dependents', 'Dependents', 'required|trim');
			$this->form_validation->set_rules('customer_info', 'customer_info');
			$this->form_validation->set_rules('pekerjaan', 'pekerjaan');
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if($this->form_validation->run()==FALSE)
			{
				echo '<script>alert("Have an error Input!");</script>';
				$this->load->view('input_customer_view');
			}else {
				
				$config['upload_path'] = './ktp/';
				$config['allowed_types'] = 'jpg|jpeg';
				$config['file_name'] = $this->input->post('identity_number');
				$config['overwrite']= TRUE;
				$config['max_size']	= '4096';
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload())
				{
					$error = array('error' => $this->upload->display_errors());
					$this->load->view('input_customer_view', $error);
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());
					//start save customer
					$customer_identity	= $this->input->post('identity_number');
					$query 				= $this->m_app->get_cust_id($customer_identity);
					if(!empty($query)){
						echo '<script>alert("Error! Customer Identity number existing");</script>';
						$this->load->view('input_customer_view');
					}else{
						$this->m_app->insert_customer();
						echo '<script>alert("new customers successfully saved!");</script>';
						$this->load->view('input_customer_view');
					}
					//finish save customer	
					
					//$this->load->view('input_customer_view');
					//echo '<script>alert("Upload Laporan Keuangan sukses!");</script>';
				}
			}
		}
		
	}
	
}
?>