<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Absensi extends CI_Model
{
    public function cek_presensi($tanggal, $jenis)
    {
        $this->db->like('created_at', $tanggal, 'after');
        $this->db->where('jenis', $jenis);
        $query = $this->db->get('absensi')->row_array();

        return $query;
    }

    public function simpan_presensi($data)
    {
        $this->db->insert('absensi', $data);

        $this->session->set_flashdata('message_name', 'Anda telah berhasil absen ' . $data['jenis']);

        redirect('home');
    }
}
