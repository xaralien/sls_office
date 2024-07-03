<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Rest extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data kontak
    // function index_get() {
        // $id = $this->get('id');
        // if ($id == '') {
			// $kontak = $this->db->get('telepon')->result();
        // } else {
            // $this->db->where('id', $id);
            // $kontak = $this->db->get('telepon')->result();
        // }
        // $this->response($kontak, 200);
    // }
	
	public function index_get($id = 0)
	{
        if(!empty($id)){
            $data = $this->db->get_where("telepon", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("telepon")->result();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
	}
	
	public function index_post()
    {
        $input = $this->input->post();
        $this->db->insert('items',$input);
     
        $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
    } 
	
	public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('items', $input, array('id'=>$id));
     
        $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    }
	
	public function index_delete($id)
    {
        $this->db->delete('items', array('id'=>$id));
       
        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    }

    //Masukan function selanjutnya disini
}
?>