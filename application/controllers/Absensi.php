<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/userguide3/general/urls.html
     */

    public function __construct()
    {
        parent::__construct();

        //$this->load->model('M_cuti');
        $this->load->model(['M_Absensi']);
        $this->load->library(['form_validation', 'session', 'user_agent', 'Api_Whatsapp', 'pagination', 'pdfgenerator']);
        $this->load->database();
        $this->load->helper(['url', 'form', 'download', 'date', 'number']);

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

        $data['title'] = "Absensi";

        $this->load->view('absensi2', $data);
    }

    public function simpan_presensi()
    {
        echo '<pre>';
        print_r($_POST);
        print_r($_FILES);
        echo '</pre>';
        exit;
        // Proses penyimpanan data presensi ke database
        $now = date('Y-m-d H:i:s');

        $tanggal = date('Y-m-d');

        $jenis = $this->input->post('jenis');

        $cek = $this->M_Absensi->cek_presensi($tanggal, $jenis);

        if ($cek) {
            $this->session->set_flashdata('message_name', 'Anda sudah absen ' . $jenis);

            redirect($_SERVER['HTTP_REFERER']);
        } else {

            $data = array(
                'gambar' => $this->input->post('image'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'alamat' => $this->input->post('alamat'),
                'user' => $this->session->userdata('username'),
                'created_at' => $now,
                'jenis' => $jenis
            );

            echo '<pre>';
            print_r($data);
            echo '</pre>';
            exit;

            $this->M_Absensi->simpan_presensi($data);
        }
    }
}
