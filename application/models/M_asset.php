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

	function asset_get($limit, $start)
	{
		$jenis = $this->session->userdata('filterJenis');
		if ($jenis == true) {
			$sql = "SELECT * FROM item_list where jenis_item='$jenis' ORDER BY Id DESC limit " . $start . ", " . $limit;
		} else {
			$sql = "select * FROM item_list ORDER BY Id DESC limit " . $start . ", " . $limit;
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	function asset_count()
	{
		$jenis = $this->session->userdata('filterJenis');
		if ($jenis == true) {
			$sql = "SELECT * FROM item_list where jenis_item='$jenis' ORDER BY Id";
		} else {
			$sql = "select * FROM item_list";
		}
		// $sql = "select Id FROM asset_list";
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
	
}
?>