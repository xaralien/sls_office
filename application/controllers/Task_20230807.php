<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {
	
	public function __construct()
  {
    parent::__construct();
    
    //$this->load->model('m_login');
	$this->load->model('m_task');
    $this->load->library(array('form_validation','session', 'user_agent','Api_Whatsapp'));
	$this->load->library('pagination');
    $this->load->database();
    $this->load->helper('url','form','download');
  } 

public function task()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
	$a = $this->session->userdata('level');
	if (strpos($a, '601')!== false) {
		//pagination settings
		$config['base_url'] = site_url('task/task');
		$config['total_rows'] = $this->m_task->task_count($this->session->userdata('nip'));
		$config['per_page'] = "10";
		$config["uri_segment"] = 3;
		$choice = $config["total_rows"]/$config["per_page"];
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
		$data['users_data'] = $this->m_task->task_get($config["per_page"], $data['page'], $this->session->userdata('nip'));
		$data['pagination'] = $this->pagination->create_links();
		
		//inbox notif
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];
		$data['count_inbox'] = $result;

		$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		$query3 = $this->db->query($sql3);
		$res3 = $query3->result_array();
		$result3 = $res3[0]['COUNT(id)'];
		$data['count_inbox2'] = $result3;
		
		$this->load->view('task_list', $data);
	}
	}
}
function card_edit()
{
		$card_id = $this->uri->segment(3);
		$get_task = $this->db->query("SELECT * FROM task where id='$card_id'")->row_array();
		$data['task'] = $get_task['member'];
		$nip_task = explode(';',$get_task['member']);
		$this->db->where_in('nip',$nip_task);
		$data['ss'] = $this->db->get('users')->result();
		
		$data['row_edit'] = $this->db->get_where('task_detail',['id_detail' => $this->uri->segment(4)])->result();
		//inbox notif
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];
		$data['count_inbox'] = $result;

		$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		$query3 = $this->db->query($sql3);
		$res3 = $query3->result_array();
		$result3 = $res3[0]['COUNT(id)'];
		$data['count_inbox2'] = $result3;
		
		$this->load->view('create_detail_task', $data);
}
public function task_cari()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
	$a = $this->session->userdata('level');
	if (strpos($a, '401')!== false) {
		// get search string
		$search = ($this->input->post("search"))? $this->input->post("search") : "NIL";
		if ($search<>'NIL'){
			$this->session->set_userdata('keyword',$search);
		}
		$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
		$stringLink = str_replace(' ', '_', $search);
		// pagination settings
		$config = array();
		$config['base_url'] = site_url("task/task_cari/$stringLink");
		$config['total_rows'] = $this->m_task->task_cari_count($search,$this->session->userdata('nip'));
		$config['per_page'] = "10";
		$config["uri_segment"] = 4;
		$choice = $config["total_rows"]/$config["per_page"];
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
		$data['users_data'] = $this->m_task->task_cari_pagination($config["per_page"], $data['page'], $search,$this->session->userdata('nip'));
		$data['pagination'] = $this->pagination->create_links();
		
		//inbox notif
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];
		$data['count_inbox'] = $result;
		
		$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		$query3 = $this->db->query($sql3);
		$res3 = $query3->result_array();
		$result3 = $res3[0]['COUNT(id)'];
		$data['count_inbox2'] = $result3;

		$this->load->view('task_list', $data);
	}
	}
}
public function task_view()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
	$a = $this->session->userdata('level');
	if (strpos($a, '601')!== false) {
		if($this->uri->segment(3)){
			$data['task'] = $this->m_task->task_get_detail($this->uri->segment(3));
			if (empty($data['task'])){
				echo "<script>alert('Unauthorize Privilage!');window.history.back();</script>";
			}else{
				$uri = $this->uri->segment(3);
				$cek_detail = $this->db->get_where('task_detail',['id_task' => $uri])->num_rows();
				if ($cek_detail == true) {
					//inbox notif
					$nip = $this->session->userdata('nip');
					$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
					$query = $this->db->query($sql);
					$res2 = $query->result_array();
					$result = $res2[0]['COUNT(Id)'];
					$data['count_inbox'] = $result;

					$this->db->where('b.id_task',$this->uri->segment(3));
					$this->db->from('users as a');
					$this->db->join('task_detail as b','a.nip=b.responsible');
					$data['task_detail'] = $this->db->get()->result();

					$this->db->select('*,c.activity as status_task,b.activity,b.comment as comment,b.date_created');
					$this->db->where('b.id_detail',$this->uri->segment(4));
					$this->db->from('users as a');
					$this->db->join('task_detail as b','a.nip=b.responsible');
					$this->db->join('task as c','b.id_task=c.id');
					$data['task_comment'] = $this->db->get()->row_array();
					
					$this->db->where('b.id_task_detail',$this->uri->segment(4));
					$this->db->from('users as a');
					$this->db->join('task_detail_comment as b','a.nip=b.member');
					$this->db->order_by('date_created','desc');
					$data['task_comment_member'] = $this->db->get()->result();

					$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
					$query3 = $this->db->query($sql3);
					$res3 = $query3->result_array();
					$result3 = $res3[0]['COUNT(id)'];
					$data['count_inbox2'] = $result3;
					//update read warna merah
					if ($this->uri->segment(4)) {
						$nip = $this->session->userdata('nip');
						$id_detail = $this->uri->segment(4);
						$sqlx = "SELECT task_detail.read FROM task_detail WHERE id_detail ='$id_detail'";
						$queryxx = $this->db->query($sqlx);
						$resultx = $queryxx->row();
						$kalimat = $resultx->read;
						if (preg_match("/$nip/i", $kalimat)){}else{
							$kalimat1 = $kalimat . ' ' . $nip;
							$data_update11	= array(
								'read'	=> $kalimat1
							);
							$this->db->where('id_detail', $id_detail);
							$this->db->update('task_detail', $data_update11);
						}
					}	
					if ($this->uri->segment(3)) {
						$nip = $this->session->userdata('nip');
						$id_detail = $this->uri->segment(3);
						$sqlx = "SELECT task.read FROM task WHERE id ='$id_detail'";
						$queryxx = $this->db->query($sqlx);
						$resultx = $queryxx->row();
						$kalimat = $resultx->read;
						if (preg_match("/$nip/i", $kalimat)){}else{
							$kalimat1 = $kalimat . ' ' . $nip;
							$data_update11	= array(
								'read'	=> $kalimat1
							);
							$this->db->where('id', $id_detail);
							$this->db->update('task', $data_update11);
						}
					}

					$this->load->view('task_view',$data);
				}else{
					redirect('task/detail_task/'.$uri);
				}
			}
		}else{
			redirect('task/task');
		}
	}
	}
}
function close_task()
{
	$id = $this->uri->segment(3);
	$this->db->where('id',$id);
	$this->db->set('activity','3');
	$this->db->update('task');
	redirect('task/task_view/'.$id);
}
function status_activity()
{
	$id_task = $this->input->post('id_task');
	$data = [
		"activity" => $this->input->post('activity')
	];
	$this->db->where('id_detail',$this->input->post('id_detail'));
	$this->db->update('task_detail',$data);
	$status = $this->input->post('activity');
	//
	$id_detail = $this->input->post('id_detail');
	$get_task_detail = $this->db->query("SELECT * FROM task as a left join task_detail as b on(a.id=b.id_task) where b.id_detail='$id_detail'")->row_array();
	$phone_x = explode(';',$get_task_detail['member']);
	if ($status == '1') {
		$statusx = 'Open';
	}elseif ($status == '2') {
		$statusx = 'Pending';
	}else if($status == '3'){
		$statusx = 'Close';
	}
	foreach ($phone_x as $k) {//member card kirim ke wa
		$get_user = $this->db->get_where('users',['nip' => $k])->row_array();
		$task_name = $get_task_detail['task_name'];
		$nama_member = $get_user["nama"];
		$comment = $this->input->post("commentt");
		$nama_session = $this->session->userdata('nama');
		$msg = "There's a new comment\nCard Name : *$task_name*\nStatus : *$statusx*\n\nChange from :  *$nama_session*";
		$this->api_whatsapp->wa_notif($msg,$get_user['phone']);
	}


	$cek_activity_detail = $this->db->query("SELECT count(id_detail) as closed FROM task_detail where id_task='$id_task' and activity='3'")->row_array();
	$cek_activity_detail_total = $this->db->query("SELECT count(id_detail) as total FROM task_detail where id_task='$id_task'")->row_array();
	
	if ($cek_activity_detail['closed'] == $cek_activity_detail_total['total']) {
		$this->db->where('id',$id_task);
		$this->db->set('activity','3');
		$this->db->update('task');
	}
	redirect('task/task_view/'.$id_task.'/'.$this->input->post('id_detail'));
}
function activity_comment()
{

			
	// Looping all files
	if (isset($_FILES['file'])) {

        $files = $_FILES;
        $cpt = count($_FILES ['file'] ['name']);

        for ($i = 0; $i < $cpt; $i ++) {

            $name = time().$files ['file'] ['name'] [$i];
            $name_xx = $files['file']['name'][$i];

            $ext = end((explode(".", $name_xx)));
            $att_name = time().'.'.$ext;
            
            $_FILES ['file'] ['name'] = $name;
            $_FILES ['file'] ['type'] = $files['file']['type'] [$i];
            $_FILES ['file'] ['tmp_name'] = $files['file']['tmp_name'] [$i];
            $_FILES ['file'] ['error'] = $files['file']['error'] [$i];
            $_FILES ['file'] ['size'] = $files['file']['size'] [$i];
			$this->load->library('upload');
			$this->upload->initialize($this->set_upload_options('upload/task_comment'));
            if(!($this->upload->do_upload('file')) || $files['file']['error'] [$i] !=0)
            {
                // print_r($this->upload->display_errors());
            }
            else
            {
                $arr_att[] = $att_name;
                $arr_name[] = $name;

            }
        }
        // var_dump(array($arr_att));
        // var_dump($this->upload->data()['file_size']);
        if ($this->upload->data()['file_size'] < 10000) {
			$id_detail = $this->input->post('id_detail');
            $get_task_detail = $this->db->query("SELECT * FROM task as a left join task_detail as b on(a.id=b.id_task) where b.id_detail='$id_detail'")->row_array();
			$phone_x = explode(';',$get_task_detail['member']);
			foreach ($phone_x as $k) {//member card kirim ke wa
				$get_user = $this->db->get_where('users',['nip' => $k])->row_array();
				$task_name = $get_task_detail['task_name'];
				$nama_member = $get_user["nama"];
				$comment = $this->input->post("commentt");
				$nama_session = $this->session->userdata('nama');
				$msg = "There's a new comment\nCard Name : *$task_name*\nComment : *$comment*\n\nComment from :  *$nama_session*";
				$this->api_whatsapp->wa_notif($msg,$get_user['phone']);
			}

            $data = [
                "id_task_detail" => $this->input->post('id_detail'),
                "comment_member" => $this->input->post('commentt'),
                "attachment" => implode(';',$arr_att),
                "attachment_name" => implode(';',str_replace(' ', '_', $arr_name)),
                "member" => $this->session->userdata('nip')
        
            ];
            $this->db->insert('task_detail_comment',$data);

			$this->db->set('read','0');
			$this->db->where('id_detail',$id_detail);
			$this->db->update('task_detail');
            redirect('task/task_view/'.$this->input->post('id_task').'/'.$this->input->post('id_detail'));
        }else{
				echo "<script>alert('File Tidak boleh lebih dari 10Mb !');window.history.back();</script>";

            // $this->session->set_flashdata('msg','<div class="alert alert-danger">File Tidak boleh lebih dari 10Mb</div>');
            // redirect('task/task_view/'.$this->input->post('id_task').'/'.$this->input->post('id_detail'));
        }
        
    } else {
        redirect('task/task_view/'.$this->input->post('id_task').'/'.$this->input->post('id_detail'));
    }
    }
    public function set_upload_options($file_path) {
        // upload an image options
        $config = array();
        $config ['upload_path'] = $file_path;
        $config ['allowed_types'] = '*';
        $config['max_size'] = 10000;
        // $config ['encrypt_name'] = true;
        return $config;
    }
    function create_task()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
	$a = $this->session->userdata('level');
	$data['task_edit'] = $this->db->get_where('task',['id'=> $this->uri->segment(3)])->row_array();

	if (strpos($a, '601')!== false || $data['task_edit']['pic'] == $this->session->userdata('nip')) {
		$data['sendto'] = $this->m_task->sendto($this->session->userdata('level_jabatan'),$this->session->userdata('bagian'));
		
	
		//inbox notif
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];
		$data['count_inbox'] = $result;
		
		$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		$query3 = $this->db->query($sql3);
		$res3 = $query3->result_array();
		$result3 = $res3[0]['COUNT(id)'];
		$data['count_inbox2'] = $result3;
		$this->load->view('create_task', $data);
	}
	}
}
public function save_task()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
	$a = $this->session->userdata('level');
	if (strpos($a, '601')!== false) {
		$this->form_validation->set_rules('project_name', 'project_name', 'required');
		$this->form_validation->set_rules('member_task[]', 'member_task', 'required');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run()==FALSE)
		{
			$this->session->set_userdata('msg','error2');
			redirect('task/create_task');
			// echo "<script>alert('error input!');window.location.href = '" . base_url() . "task/create_memo';</script>";
		} else {
			//send notif ke create task
			$get_user = $this->db->get_where('users',['nip' => $this->session->userdata('nip')])->row_array();
			$nama_session = $this->session->userdata('nama');
			$project = $this->input->post('project_name');
			$msg = "There's a new task\nProject Name : *$project*\n\nCreated By :  *$nama_session*";
			$this->api_whatsapp->wa_notif($msg,$get_user['phone']);
			date_default_timezone_set('Asia/Jakarta');
			//simpan memo
				$member_task=''; 
				$nip_cc='';
			// foreach ($this->input->post('project_name[]') as $value) 
			// {
			// $nip_kpd .= $value.';';
			// }
			if (!empty($this->input->post('member_task[]'))){
				foreach ($this->input->post('member_task[]') as $value1) 
				{
					$member_task .= $value1.';';
					$get_user = $this->db->get_where('users',['nip' => $value1])->row_array();
					$nama_session = $this->session->userdata('nama');
					$project = $this->input->post('project_name');
					$msg = "There's a new task\nProject Name : *$project*\n\nCreated By :  *$nama_session*";
					$this->api_whatsapp->wa_notif($msg,$get_user['phone']);
				}
			}
			
			$data_update1 	= array (
				'name'		=> $this->input->post('project_name'),
				'member'		=> $member_task,
				'activity'		=> '1',
				'comment' => $this->input->post('comment'),
                'pic' => $this->session->userdata('nip')
			);
			$this->session->set_userdata('member_task',$member_task);
			$this->db->insert('task', $data_update1);
			$last_id = $this->db->insert_id();
			$xx = $last_id;
			$this->session->set_userdata('msg_memo',$xx);
			$countfiles = count(array_filter($_FILES['file']['name']));
		
			$this->session->set_userdata('id_task',$xx);
			redirect('task/detail_task/'.$xx);
		}
		
		//reload Send Memo
		$data['sendto'] = $this->m_task->sendto($this->session->userdata('level_jabatan'),$this->session->userdata('bagian'));
		
		//inbox notif
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];
		$data['count_inbox'] = $result;
		
		$this->load->view('create_task', $data);
	}
	}
} 
function update_task()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
	$a = $this->session->userdata('level');
	if (strpos($a, '601')!== false) {
		$this->form_validation->set_rules('project_name', 'project_name', 'required');
		$this->form_validation->set_rules('member_task[]', 'member_task', 'required');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run()==FALSE)
		{
			$this->session->set_userdata('msg','error2');
			redirect('task/create_task');
			// echo "<script>alert('error input!');window.location.href = '" . base_url() . "task/create_memo';</script>";
		} else {
			date_default_timezone_set('Asia/Jakarta');
			//simpan memo
				$member_task=''; 
				$nip_cc='';
			// foreach ($this->input->post('project_name[]') as $value) 
			// {
			// $nip_kpd .= $value.';';
			// }
			if (!empty($this->input->post('member_task[]'))){
				foreach ($this->input->post('member_task[]') as $value1) 
				{
					$member_task .= $value1.';';
				}
			}
			
			$data_update1 	= array (
				'name'		=> $this->input->post('project_name'),
				'member'		=> $member_task,
				'activity'		=> $this->input->post('activity'),
                'pic' => $this->session->userdata('nip')
			);
			$id_edit = $this->input->post('id_edit');
			$this->session->set_userdata('member_task',$member_task);
			$this->db->where('id',$id_edit);
			$this->db->update('task', $data_update1);
			$last_id = $this->db->insert_id();
			$xx = $last_id;
			$this->session->set_userdata('msg_memo',$xx);
			$countfiles = count(array_filter($_FILES['file']['name']));
		
			$this->session->set_userdata('id_task',$xx);
			redirect('task/task');
		}
		
		//reload Send Memo
		$data['sendto'] = $this->m_task->sendto($this->session->userdata('level_jabatan'),$this->session->userdata('bagian'));
		
		//inbox notif
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];
		$data['count_inbox'] = $result;
		
		$this->load->view('create_task', $data);
}  
	}
}
    function get_detail_task()
    {
        $this->db->where('username !=',null,false);
        $this->db->where_in('nip',explode(';',$this->session->userdata('member_task')));
        $data = $this->db->get_where('users')->result();
        echo json_encode($data);
    }

    public function detail_task()
    {
        $id_task = $this->uri->segment(3);
        if ($id_task != null) {
            if($this->session->userdata('isLogin') == FALSE)
            {redirect('home');}
            else{
            $a = $this->session->userdata('level');
            if (strpos($a, '601')!== false) {
                $get_task = $this->db->query("SELECT * FROM task where id='$id_task'")->row_array();
                $data['task'] = $get_task['member'];
                $nip_task = explode(';',$get_task['member']);
                $this->db->where_in('nip',$nip_task);
                $data['ss'] = $this->db->get('users')->result();
                // $data['detail_task'] = $this->db->query("SELECT * FROM users where nip in $nip_task ")->result();
                $this->session->set_userdata('member_task',$get_task['member']);
                //inbox notif
                $nip = $this->session->userdata('nip');
                $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
                $query = $this->db->query($sql);
                $res2 = $query->result_array();
                $result = $res2[0]['COUNT(Id)'];
                $data['count_inbox'] = $result;

				$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
				$query3 = $this->db->query($sql3);
				$res3 = $query3->result_array();
				$result3 = $res3[0]['COUNT(id)'];
				$data['count_inbox2'] = $result3;
				
                
                $this->load->view('create_detail_task', $data);
            }
            }
        }else{
            redirect('task/create_task');
        }
    }
    public function save_detail_task()
    {
		$id_task = $this->input->post('id_task');
		$id_card = $this->input->post('id_card');
        $total_row = count($this->input->post('row'));
		// echo $total_row;
		if ($this->input->post('status') == 'edit') {
			for ($i=1; $i <=$total_row ; $i++) { 
				$target_file = './upload/card_task/';
				$target_file2 = './upload/task_comment/';
		
				if ($_FILES['att'.$i]['name'][0] != "") {
					$nama_filee = array();
					for ($xx=0; $xx <count($_FILES['att'.$i]['name']) ; $xx++) { 
						$newfilename = str_replace(' ', '', time().'_'.$_FILES['att'.$i]['name'][$xx]);
						move_uploaded_file($_FILES['att'.$i]["tmp_name"][$xx],$target_file2 . $newfilename);
						$nama_filee[] = str_replace(' ', '',time().'_'. $_FILES['att'.$i]['name'][$xx]) ;
					}
				}else{
					$nama_filee = null;
				}
				if ($this->input->post('project_name'.$i) != '') {
					// if (count($_FILES['att'.$i]['name']) >= 0) {
					$file_i = implode(';',$nama_filee);
					// }else{
						// $file_i = null;
					// }
					$data = [
						"id_task" => $this->input->post('id_task'),
						"task_name" => $this->input->post('project_name'.$i),
						"responsible" => $this->input->post('member_task'.$i),
						"description" => $this->input->post('description'.$i),
						"start_date" => $this->input->post('start'.$i),
						"due_date" => $this->input->post('end'.$i),
						"activity" => $this->input->post('activity'.$i),
						"attachment" => $file_i,
						// "comment" => $this->input->post('comment'.$i),
					]; 
					$this->db->where('id_detail',$id_card);
					$this->db->update('task_detail',$data);
					//detail comment
					$this->db->select_max('id_detail');
					$id_task_detail = $this->db->get('task_detail')->row();
						$comment_detail = [
							"id_task_detail" => $id_task_detail->id_detail,
							"comment_member" => $this->input->post('comment'.$i),
							"attachment" => $file_i,
							"attachment_name" => $file_i,
							"member" => $this->session->userdata('nip')
						];
						$this->db->where('id_task_detail',$id_card);
						$this->db->update('task_detail_comment',$comment_detail);
				}
			}
            $this->session->set_flashdata('msg','success_edit');
			redirect('task/card_edit/'.$id_task.'/'.$id_card);
		}else{
			for ($i=1; $i <=$total_row ; $i++) { 
				$target_file = './upload/card_task/';
				$target_file2 = './upload/task_comment/';
		
				if ($_FILES['att'.$i]['name'][0] != "") {
					$nama_filee = array();
					for ($xx=0; $xx <count($_FILES['att'.$i]['name']) ; $xx++) { 
						$newfilename = str_replace(' ', '', time().'_'.$_FILES['att'.$i]['name'][$xx]);
						move_uploaded_file($_FILES['att'.$i]["tmp_name"][$xx],$target_file2 . $newfilename);
						$nama_filee[] = str_replace(' ', '',time().'_'. $_FILES['att'.$i]['name'][$xx]) ;
					}
				}else{
					$nama_filee = null;
				}
				if ($this->input->post('project_name'.$i) != '') {
					// if (count($_FILES['att'.$i]['name']) >= 0) {
					$file_i = implode(';',$nama_filee);
					// }else{
						// $file_i = null;
					// }
					$data = [
						"id_task" => $this->input->post('id_task'),
						"task_name" => $this->input->post('project_name'.$i),
						"responsible" => $this->input->post('member_task'.$i),
						"description" => $this->input->post('description'.$i),
						"start_date" => $this->input->post('start'.$i),
						"due_date" => $this->input->post('end'.$i),
						"activity" => $this->input->post('activity'.$i),
						"attachment" => $file_i,
						// "comment" => $this->input->post('comment'.$i),
					]; 
					$this->db->insert('task_detail',$data);
					$this->db->select_max('id_detail');
					$id_task_detail = $this->db->get('task_detail')->row();
						$comment_detail = [
							"id_task_detail" => $id_task_detail->id_detail,
							"comment_member" => $this->input->post('comment'.$i),
							"attachment" => $file_i,
							"attachment_name" => $file_i,
							"member" => $this->session->userdata('nip')
						];
						$this->db->insert('task_detail_comment',$comment_detail);
				}
			}
			redirect('task/task_view/'.$id_card);
		}
    }
}