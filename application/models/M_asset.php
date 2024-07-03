<?php if (!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');

class M_asset extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function __destruct()
	{
		$this->db->close();
	}

	function item_get($limit, $start, $search)
	{
		if ($search) {
			// $sql = "SELECT * FROM item_list WHERE nama LIKE '%$search%' OR nomor LIKE '%$search%' ORDER BY Id DESC limit " . $start . ", " . $limit;
			$sql = "SELECT item_list.*, item_jenis.nama_jenis FROM item_list JOIN item_jenis ON item_list.jenis_item = item_jenis.Id WHERE item_list.nama LIKE '%$search%' OR item_list.nomor LIKE '%$search%' ORDER BY Id DESC limit " . $start . ", " . $limit;
		} else {
			$sql = "SELECT item_list.*, item_jenis.nama_jenis FROM item_list JOIN item_jenis ON item_list.jenis_item = item_jenis.Id ORDER BY Id DESC limit " . $start . ", " . $limit;
		}
		$query = $this->db->query($sql);
		return $query->result();
	}

	function itemIn_get($limit, $start)
	{
		$sql = "SELECT item_in.jumlah, item_in.no_nota, item_in.harga_sat, item_in.date, item_list.nama, item_list.nomor FROM item_in JOIN item_list ON item_in.item_list_id = item_list.Id ORDER BY item_in.Id DESC LIMIT " . $start . ", " . $limit;
		$query = $this->db->query($sql);
		return $query->result();
	}


	function itemOut_get($limit, $start)
	{
		$sql = "SELECT users.nama as nama_penerima, users.nip, item_list.nama, asset_list.nama_asset, asset_list.kode, item_out.Id, item_out.harga, item_out.jml, item_out.tanggal, item_out.penerima, item_out.status FROM item_out JOIN item_list ON item_out.item_id = item_list.Id JOIN asset_list ON asset_list.Id = item_out.asset_id LEFT JOIN users ON users.nip = item_out.penerima ORDER BY item_out.Id DESC LIMIT " . $start . ", " . $limit;
		$query = $this->db->query($sql);
		return $query->result();
	}

	function item_count($search)
	{
		if ($search) {
			$sql = "SELECT * FROM item_list WHERE nama LIKE '%$search%' OR nomor LIKE '%$search%'";
		} else {
			$sql = "SELECT * FROM item_list";
		}
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function itemIn_count()
	{
		$sql = "select * FROM item_in";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function itemOut_count()
	{
		$sql = "select * FROM item_out";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function item_cari_pagination($limit, $start, $st = NULL)
	{
		if ($st == "NIL") $st = "";
		// $sql = "SELECT * FROM asset_list WHERE (kode LIKE '%$st%' OR spesifikasi LIKE '%$st%' OR nama_asset LIKE '%$st%') ORDER BY kode ASC limit " . $start . ", " . $limit;
		$sql = "SELECT a.* FROM item_list as a left join item_in as b on(a.Id=b.item_list_id) WHERE (a.nomor LIKE '%$st%' OR a.nama LIKE '%$st%') ORDER BY a.Id ASC limit " . $start . ", " . $limit;
		$query = $this->db->query($sql);
		return $query->result();
	}

	function item_cari_count($st = NULL)
	{
		if ($st == "NIL") $st = "";
		// $sql = "select Id FROM asset_list WHERE (kode LIKE '%$st%' OR spesifikasi LIKE '%$st%' OR nama_asset LIKE '%$st%')";
		$sql = "SELECT a.* FROM item_list as a left join item_in as b on(a.Id=b.item_list_id) WHERE (a.nomor LIKE '%$st%' OR a.nama LIKE '%$st%')";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function get_poList($where)
	{
		$this->cb->select('a.no_po, a.tgl_pengajuan, a.posisi, a.total, b.nama, a.status_sarlog, a.status_direksi, a.Id, a.catatan_sarlog, a.catatan_direksi, a.keterangan, a.bukti_bayar, a.user');
		$this->cb->from('t_preorder as a');
		$this->cb->join('t_vendors as b', 'a.vendor = b.Id', 'left');
		$this->cb->where($where);

		return $this->cb->get();
	}

	function count_po($where)
	{
		return $this->cb->get_where('t_preorder', $where)->num_rows();
	}
}
