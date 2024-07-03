<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Customer extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function customer()
    {
        return $this->cb->order_by('nama_customer', 'ASC')->get('customer')->result();
    }

    public function list_customer($status)
    {
        return $this->cb->where('status_customer', $status)->order_by('nama_customer', 'ASC')->get('customer')->result();
    }

    public function insert($data)
    {
        return $this->cb->insert('customer', $data);
    }

    public function update($data, $old_slug)
    {
        $this->cb->where('slug', $old_slug);
        return $this->cb->update('customer', $data);
    }

    public function show($id)
    {
        return $this->cb->where('slug', $id)->get('customer')->row_array();
    }

    public function is_available($id)
    {
        return $this->cb->where('slug', $id)->get('customer')->num_rows();
    }
}
