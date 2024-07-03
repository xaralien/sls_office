<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_invoice extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function list_invoice()
    {
        // Query dari database corebank
        $this->cb->select('a.*, c.nama_customer');
        $this->cb->from('invoice a');
        $this->cb->join('customer c', 'a.id_customer = c.id', 'left');
        $invoices = $this->cb->order_by('no_invoice', 'DESC')->get()->result_array();

        // Ambil semua user dari database bdl_core
        $users = $this->db->select('id, nip, nama')->get('users')->result_array();
        $user_map = array_column($users, 'nama', 'nip');  // Menggunakan nama pengguna sebagai nama kolom

        // Gabungkan hasil query
        foreach ($invoices as &$invoice) {
            $invoice['created_by_name'] = isset($user_map[$invoice['created_by']]) ? $user_map[$invoice['created_by']] : null;
            $invoice['updated_by_name'] = isset($user_map[$invoice['updated_by']]) ? $user_map[$invoice['updated_by']] : null;
        }

        return $invoices;
    }

    public function select_max()
    {
        return $this->cb->select('max(no_invoice) as max')->get('invoice')->row_array();
    }

    public function insert($invoice_data)
    {
        $this->cb->insert('invoice', $invoice_data);

        // Dapatkan ID invoice yang baru saja di-generate
        return $this->cb->insert_id();
    }

    public function insert_batch($detail_data)
    {
        return $this->cb->insert_batch('invoice_details', $detail_data);
    }

    public function show($no_inv)
    {
        return $this->cb->select('*, a.created_by as user_create')->from('invoice a')->join('customer b', 'a.id_customer = b.id', 'left')->where('no_invoice', $no_inv)->get()->row_array();
    }

    public function item_list($id)
    {
        return $this->cb->where('id_invoice', $id)->get('invoice_details')->result();
    }

    public function report($from, $to)
    {
        return $this->cb->from('invoice a')->join('customer b', 'a.id_customer = b.id', 'left')->where('tanggal_invoice >=', $from)->where('tanggal_invoice <=', $to)->get()->result();
    }

    public function delete_detail($id)
    {
        return $this->cb->where('Id', $id)->delete('invoice_details');
    }

    public function update_item($id, $data)
    {
        return $this->cb->where('Id', $id)->update('invoice_details', $data);
    }

    public function update_invoice($id_invoice, $data)
    {
        return $this->cb->where('Id', $id_invoice)->update('invoice', $data);
    }

    public function get_discount($id)
    {
        return $this->cb->select('diskon')->where('Id', $id)->get('invoice')->row_array();
    }

    public function sum_total($id_invoice)
    {
        return $this->cb->select_sum('total')->where('id_invoice', $id_invoice)->get('invoice_details')->row_array();
    }

    public function get_item_names($searchTerm)
    {
        $this->cb->like('nama_item', $searchTerm);
        $query = $this->cb->get('item_invoice');
        return $query->result_array();
    }



    public function addLogPayment($data)
    {
        return $this->cb->insert('t_log_pembayaran', $data);
    }

    public function cek_user($id)
    {
        return $this->db->get_where('users', ['nip' => $id])->row_array();
    }
}
