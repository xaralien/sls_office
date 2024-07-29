<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_pengajuan extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_pengajuan($limit, $start, $search, $nip)
  {
    $this->cb->limit($limit, $start);
    $this->cb->like('no_pengajuan', $search, 'both');
    $this->cb->where('user', $nip);
    $this->cb->order_by('no_pengajuan', 'DESC');
    return $this->cb->get('t_pengajuan')->result_array();
  }

  public function countPengajuanSpv($search)
  {
    $nip = $this->session->userdata('nip');
    if (!$search) {
      $sql = "SELECT * FROM t_pengajuan WHERE spv = '$nip'";
      return $this->cb->query($sql)->num_rows();
    } else {
      $sql = "SELECT * FROM t_pengajuan WHERE spv = '$nip' AND t_pengajuan.no_pengajuan LIKE '%$search%'";
      return $this->cb->query($sql)->num_rows();
    }
  }

  public function countListPengajuan($search)
  {
    $nip = $this->session->userdata('nip');
    if (!$search) {
      $sql = "SELECT * FROM t_pengajuan WHERE user = '$nip'";
      return $this->cb->query($sql)->num_rows();
    } else {
      $sql = "SELECT * FROM t_pengajuan WHERE user = '$nip' AND t_pengajuan.no_pengajuan LIKE '%$search%'";
      return $this->cb->query($sql)->num_rows();
    }
  }

  public function get_detail($id)
  {
    $this->cb->where('Id', $id);
    return $this->cb->get('t_pengajuan')->row_array();
  }

  public function count_spv($nip)
  {
    $this->cb->where(['spv' => $nip, 'status_spv' => 0]);
    return $this->cb->get('t_pengajuan');
  }

  public function count_keuangan()
  {
    $this->cb->where(['status_spv' => 1, 'status_keuangan' => 0]);
    return $this->cb->get('t_pengajuan');
  }

  public function approval_spv($limit, $start, $search, $nip)
  {
    $this->cb->limit($limit, $start);
    $this->cb->like('no_pengajuan', $search, 'both');
    $this->cb->where(['spv' => $nip]);
    $this->cb->order_by('no_pengajuan', 'DESC');
    $this->cb->order_by('status_spv', 'ASC');
    return $this->cb->get('t_pengajuan');
  }

  public function approval_keuangan($filter)
  {
    if ($filter == 1) {
      $this->cb->where('posisi', "Diarahkan ke pembayaran");
    }
    if ($filter == 2) {
      $this->cb->where('posisi', "Sudah Dibayar");
    }
    if ($filter == 3) {
      $this->cb->order_by('created_at', 'DESC');
    }
    if ($filter == 4) {
      $this->cb->where('status_keuangan', 0);
    }

    $this->cb->where(['status_spv' => 1]);
    $this->cb->order_by('no_pengajuan', 'DESC');
    return $this->cb->get('t_pengajuan');
  }

  public function approval_direksi()
  {
    $this->cb->where(['status_keuangan' => 1, 'jenis_pengajuan' => 1, 'direksi' => $this->session->userdata('nip')]);
    return $this->cb->get('t_pengajuan');
  }

  public function count_direksi()
  {
    $this->cb->where(['status_keuangan' => 1, 'jenis_pengajuan' => 1, 'direksi' => $this->session->userdata('nip')]);
    return $this->cb->get('t_pengajuan');
  }
}
