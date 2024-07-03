<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {
	public function index() {
		if ($this->session->userdata('level')==1){
			$this->load->dbutil();
			$prefs = array(     
				'format'      => 'zip',             
				'filename'    => 'my_db_backup.sql'
				);
			$backup =& $this->dbutil->backup($prefs); 

			$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
			$save = 'backup/db/'.$db_name;

			$this->load->helper('file');
			write_file($save, $backup); 

			$this->load->helper('download');
			force_download($db_name, $backup);
		}else{
			//if not admin
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			//$this->load->view('home_view');
		}
		
	}
	
	public function clean_db()
	{
		if ($this->session->userdata('level')==1){
			/* generate the select query */
			$this->db->where('project_status', 9);
			$this->db->or_where('project_status', 0);			
			$query = $this->db->get('project');
		  
			foreach ($query->result() as $row) {
			$this->db->insert('project_arsip',$row);
			}
			
			//delete table project
			$this->db->where('project_status', 9);
			$this->db->or_where('project_status', 0);
			$this->db->delete('project');
			
			echo '<script>alert("Clean DB Success!");</script>';
			$this->load->model('m_login');
			$user = $this->session->userdata('username');
			$data['pengguna'] = $this->m_login->dataPengguna($user);
			$data['utility'] = $this->m_login->utility();
			$this->load->view('home_view', $data);
		}else{
			//if not admin
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			//$this->load->view('home_view');
			redirect('home');
		}
	}
}