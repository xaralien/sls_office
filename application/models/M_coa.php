<?php if (!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');

class M_coa extends CI_Model
{
    // $this->cb untuk koneksi ke database corebank

    public function list_coa()
    {
        return $this->cb->order_by('no_sbb', 'ASC')->get('v_coa_all')->result();
    }

    public function cek_coa($no_coa)
    {
        return $this->cb->where('no_sbb', $no_coa)->get('v_coa_all')->row_array();
    }

    public function update_nominal_coa($no_coa, $data, $kolom, $tabel)
    {
        return $this->cb->where($kolom, $no_coa)->update($tabel, $data);
    }

    public function add_transaksi($data)
    {
        return $this->cb->insert('t_log_transaksi', $data);
    }

    public function addJurnal($data)
    {
        return $this->cb->insert('jurnal_neraca', $data);
    }

    public function getNeraca($table, $posisi)
    {
        return $this->cb->where('nominal !=', '0')->where('posisi', $posisi)->get($table)->result();
    }

    public function getSumNeraca($table, $posisi)
    {
        return $this->cb->select_sum('nominal')->where('posisi', $posisi)->get($table)->row_array();
    }

    public function getPasivaWithLaba($table)
    {
        $pasiva = $this->cb->where('posisi', 'PASIVA')->where('nominal !=', '0')->or_where('no_sbb', '3201001')->get($table)->result();

        return $pasiva;
    }

    public function getCoaReport($no_coa, $from, $to)
    {
        return $this->cb->where('tanggal >=', $from)->where('tanggal <=', $to)->where('akun_debit', $no_coa)->or_where('akun_kredit', $no_coa)
            ->order_by('id', 'DESC')
            ->get('jurnal_neraca')->result();
    }

    public function getCoa($no_coa)
    {
        return $this->cb->where('no_sbb', $no_coa)->get('v_coa_all')->row_array();
    }

    public function getCoaByCode($code)
    {
        return $this->cb->like('no_sbb', $code, 'after')->get('v_coa_all')->result();
    }

    public function simpanLaporan($data)
    {
        return $this->cb->insert('t_log_neraca', $data);
    }

    public function count_laporan($jenis)
    {
        return $this->cb->from('t_log_neraca')->where('jenis', $jenis)->count_all_results();
    }

    public function list_laporan($jenis, $limit, $from)
    {
        $laporan = $this->cb->where('jenis', $jenis)->order_by('tanggal_simpan', 'DESC')->limit($limit, $from)->get('t_log_neraca')->result_array();

        // Ambil semua user dari database bdl_core
        $users = $this->db->select('id, nip, nama')->get('users')->result_array();
        $user_map = array_column($users, 'nama', 'nip');  // Menggunakan nama pengguna sebagai nama kolom

        // Gabungkan hasil query
        foreach ($laporan as &$lp) {
            $lp['created_by_name'] = isset($user_map[$lp['created_by']]) ? $user_map[$lp['created_by']] : null;
        }

        return $laporan;
    }

    public function showNeraca($slug)
    {
        return $this->cb->where('slug', $slug)->get('t_log_neraca')->row_array();
    }

    public function select_max($jenis)
    {
        return $this->cb->select('max(no_urut) as max')->where('jenis', $jenis)->get('t_log_neraca')->row_array();
    }

    public function count($keyword, $tabel)
    {
        if ($keyword) {
            $this->cb->like('no_sbb', $keyword);
            $this->cb->or_like('no_bb', $keyword);
            $this->cb->or_like('nama_perkiraan', $keyword);
        }
        return $this->cb->from($tabel)->count_all_results();
    }

    public function list_coa_paginate($limit, $from, $keyword)
    {
        if ($keyword) {
            $this->cb->like('no_sbb', $keyword);
            $this->cb->or_like('no_bb', $keyword);
            $this->cb->or_like('nama_perkiraan', $keyword);
        }
        $laporan = $this->cb->order_by('no_sbb', 'ASC')->limit($limit, $from)->get('v_coa_all')->result_array();

        return $laporan;
    }

    public function isAvailable($kolom, $key)
    {
        return $this->cb->from('v_coa_all')->where($kolom, $key)->count_all_results();
    }
}
