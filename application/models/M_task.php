<?php if (!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');

class M_task extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    function sendto($level_jabatan, $bagian)
    {
        if ($level_jabatan == 2) {
            $sql = "SELECT * FROM users WHERE ((level_jabatan <= '$level_jabatan' AND bagian = '$bagian') OR (level_jabatan >= 1)) ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 3) {
            $sql = "SELECT * FROM users WHERE ((level_jabatan <= '$level_jabatan' AND bagian = '$bagian') OR (level_jabatan >= 1)) AND level like '%601%' ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 4) {
            $sql = "SELECT * FROM users WHERE ((level_jabatan <= '$level_jabatan' AND bagian = '$bagian') OR (level_jabatan >= 1)) ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 5 and $bagian <> 11) {
            $sql = "SELECT * FROM users WHERE level_jabatan >= 1 ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 5 and $bagian == 11) {
            $sql = "SELECT * FROM users WHERE (level_jabatan >= 1 OR bagian = 4) ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 6) {
            $sql = "SELECT * FROM users WHERE level_jabatan >= 1 ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 1) {
            $sql = "SELECT * FROM users WHERE bagian = '$bagian' ORDER BY level_jabatan DESC";
        }
        $query = $this->db->query($sql);
        return $query->result();
    }
    function task_get($limit, $start, $nip)
    {
        // $xx = explode(';',$nip);
        //  $this->db->where('memnber',$x);
        // // }
        // // $this->db->limit($limit);
        // // $this->db->order_by($start);
        // $sql = $this->db->get('task');
        // $sql = "SELECT * FROM task limit ".$start. ", ".$limit." ";
        $pic = $this->session->userdata('nip');
        $sql = "SELECT * from task where member like '%$nip%' or pic like '%$pic%' ORDER BY activity asc , date_created desc limit " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
    function task_count($nip)
    {
        $sql = "SELECT id FROM task where member like '%$nip%' or pic like '%$nip%'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function task_cari_count($st = NULL, $nip)
    {
        if ($st == "NIL") $st = "";
        $sql = "SELECT id FROM task WHERE (name LIKE '%$st%' AND pic LIKE '%$nip%')";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function task_cari_pagination($limit, $start, $st = NULL, $nip = NULL)
    {
        if ($st == "NIL") $st = "";
        // $sql = "select a.id,a.nomor_memo,a.nip_kpd,a.judul,a.tanggal,a.read,a.nip_dari,b.nama
        // FROM memo a LEFT JOIN users b ON a.nip_dari = b.nip
        // WHERE (a.judul LIKE '%$st%' AND a.nip_kpd LIKE '%$nip%') ORDER BY a.tanggal DESC limit " . $start . ", " . $limit;
        // $query = $this->db->query($sql);
        // return $query->result();

        $sql = "SELECT * from task where name like '%$st%' and (member like '%$nip%' OR pic like '%$nip%') ORDER BY activity asc limit " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
    function task_get_detail($id)
    {
        $nip = $this->session->userdata('nip');
        $sql = "select task.read FROM task WHERE id=$id";
        $query = $this->db->query($sql);
        $result = $query->row();
        $kalimat = $result->read;
        if (preg_match("/$nip/i", $kalimat)) {
        } else {
            $kalimat1 = $kalimat . ' ' . $nip;
            $data_update1    = array(
                'read'    => $kalimat1
            );
            $this->db->where('id', $id);
            $this->db->update('task', $data_update1);
        }
        $sql = "
            SELECT * FROM task where id='$id'";
        //$query = $this->db->query($sql);
        //return $query->result();
        $query = $this->db->query($sql);
        return $query->row();
    }
}
