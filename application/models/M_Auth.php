<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Auth extends CI_Model
{

    public function registration($data)
    {
        $this->db->insert('user', $data);
        $this->session->set_flashdata('success', 'You have successfully registered. Please login!');
        redirect('auth');
    }

    public function cek_user($id)
    {
        if (empty($id)) {
            redirect('auth');
        }
        return $this->db->get_where('user', ['username' => $id])->row_array();
    }

    public function cek_role($id)
    {
        return $this->db->get_where('user_role', ['id' => $id])->row_array();
    }

    public function cek_user_id($id)
    {
        if (empty($id)) {
            redirect('auth');
        }
        return $this->db->get_where('user', ['Id' => $id])->row_array();
    }

    public function update_user($data, $id)
    {
        $this->db->where('Id', $id);
        $this->db->update('user', $data);
        return $this->db->affected_rows();
    }

    public function role($id)
    {
        return $this->db->get_where('user_role', ['Id' => $id])->row_array();
    }

    public function users_list()
    {
        return $this->db->get('user')->result();
    }

    public function add_member($data)
    {
        $this->db->insert('user', $data);
        $this->session->set_flashdata('message_name', 'Member successfully added');
        redirect('dashboard/user');
    }
}
