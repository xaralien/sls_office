<?php if(!defined('BASEPATH')) exit('Hacking Attempt. Keluar dari sistem.');

class Home extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    
     $this->load->library(array('session'));
     $this->load->helper('url');
     $this->load->model('m_login');
     $this->load->database();
     
  }
  /**function getall(){
	  $ambil_data = $this->db->get('pengajuan');//mengambil tabel pengajuan
	  //jika data lebih dari 0
	  if ($ambil_data->num_rows() > 0 ){
	   foreach ($ambil_data->result() as $data){
	    $hasil[] = $data;
	   }
	   return $hasil;
	  }
	 } **/
  
  
  public function index()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {
      redirect('login/login_form');
    }else
    {		
      $this->load->model('m_login');
      $user = $this->session->userdata('username');
      //$data['level'] = $this->session->userdata('level');        
      $data['pengguna'] = $this->m_login->dataPengguna($user);
	  //$data['utility'] = $this->m_login->utility();
	  //redirect('app/grab_project');
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];

		$sql2 = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` LIKE '%$nip%');";
		$sql3 = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%');";

    $query2 = $this->db->query($sql2);
		$res3 = $query2->result_array();
		$result2 = $res3[0]['COUNT(Id)'];

    $query3 = $this->db->query($sql3)->result_array();
    $result3 = $query3[0]['COUNT(Id)'];

	  $data['total'] = $result3;
	  $data['count_inbox'] = $result;
	  $data['read_inbox'] = $result2;
	  
	  $sql4 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
	  $query4 = $this->db->query($sql4);
	  $res4 = $query4->result_array();
	  $result4 = $res4[0]['COUNT(id)'];
	  $data['count_inbox2'] = $result4;

		// $sql4 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		// $query4 = $this->db->query($sql4);
		// $res4 = $query4->result_array();
		// $result4 = $res4[0]['COUNT(id)'];
		// $data['count_inbox2'] = $result4;
      $this->load->view('home_view', $data); 
    }
  } 
  function banner()
  {
    if ($_FILES['banner1']['name'] == true) {
      $banner = 'banner1' ;
   
    }elseif ($_FILES['banner2']['name'] == true) {
      $banner = 'banner2' ;

    }elseif ($_FILES['banner3']['name'] == true) {
      $banner = 'banner3' ;

    }
    if($this->session->userdata('isLogin') == FALSE)
    {
      redirect('login/login_form');
    }else
    {		
                // $banner1 = $_FILES['banner1']['name'];
                // $banner2 = $_FILES['banner2']['name'];
                // $banner3 = $_FILES['banner3']['name'];
                $config['upload_path']          = './upload/banner/';
                $config['allowed_types']        = 'jpg|png';
                $config['file_name']        = $banner;
                $config['encrypt_name'] = true;
                
                // $config['max_size']             = 100;
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('banner1'))
                {
                        $error = array('error' => $this->upload->display_errors());
                      var_dump($error);
                        // $this->load->view('upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        var_dump($data);
                        // $this->load->view('upload_success', $data);
                }

                if (!$this->upload->do_upload('banner2'))
                {
                        $error = array('error' => $this->upload->display_errors());
                      var_dump($error);
                        // $this->load->view('upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        var_dump($data);
                        // $this->load->view('upload_success', $data);
                }
                if (!$this->upload->do_upload('banner3'))
                {
                        $error = array('error' => $this->upload->display_errors());
                      var_dump($error);
                        // $this->load->view('upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        var_dump($data);
                        // $this->load->view('upload_success', $data);
                }
                if ($_FILES['banner1']['name'] == true) {
                  $banner = 'banner1' ;
                  $insert = [
                    "banner1" => $this->upload->data()['file_name']
                  ];
                }elseif ($_FILES['banner2']['name'] == true) {
                  $banner = 'banner2' ;
                  $insert = [
                    "banner2" => $this->upload->data()['file_name']
                  ];
                }elseif ($_FILES['banner3']['name'] == true) {
                  $banner = 'banner3' ;
                  $insert = [
                    "banner3" => $this->upload->data()['file_name']
                  ];
                }
                $this->db->where('Id',1);
                $this->db->update('utility',$insert);
                redirect('home');

    }

  }
  
}
?>