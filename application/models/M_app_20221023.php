<?php if(!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');

class M_app extends CI_Model
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
	$sql = "select * FROM asset_list ORDER BY Id DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}
function asset_count()
{
	$sql = "select Id FROM asset_list";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function memo_count_send($nip)
{
	$sql = "select Id FROM memo WHERE nip_dari LIKE '%$nip%'";
	$query = $this->db->query($sql);
	return $query->num_rows();
}
function memo_get_send($limit, $start, $nip)
{
	$sql = "select a.id,a.nomor_memo,a.nip_kpd,a.judul,a.tanggal,a.read,a.nip_dari,a.persetujuan,b.nama FROM memo a 
	LEFT JOIN users b ON a.nip_dari = b.nip
	WHERE nip_dari LIKE '%$nip%' ORDER BY tanggal DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}
function memo_get($limit, $start, $nip)
{
	$sql = "select a.id,a.nomor_memo,a.nip_kpd,a.judul,a.tanggal,a.read,a.nip_dari,a.persetujuan,b.nama FROM memo a 
	LEFT JOIN users b ON a.nip_dari = b.nip
	WHERE nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%' ORDER BY tanggal DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}
	
function memo_count($nip)
{
	$sql = "select Id FROM memo WHERE nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%'";
	$query = $this->db->query($sql);
	return $query->num_rows();
}
function memo_get_detail($id)
{
	$nip = $this->session->userdata('nip');
	$sql = "select memo.read FROM memo WHERE Id =$id";
	$query = $this->db->query($sql);
	$result = $query->row();
	$kalimat = $result->read;
	if (preg_match("/$nip/i", $kalimat)){}else{
		$kalimat1 = $kalimat . ' ' . $nip;
		$data_update1	= array(
			'read'	=> $kalimat1
		);
		$this->db->where('Id', $id);
		$this->db->update('memo', $data_update1);
	}
	$sql="
		SELECT a.*,b.nama_jabatan,b.nama,b.supervisi,c.kode_nama,b.level_jabatan 
		FROM memo a
		LEFT JOIN users b ON a.nip_dari = b.nip
		LEFT JOIN bagian c ON b.bagian = c.kode
		WHERE (a.id = '$id' AND (a.nip_dari LIKE '%$nip%' OR a.nip_kpd LIKE '%$nip%' OR a.nip_cc LIKE '%$nip%'))
	";
	//$query = $this->db->query($sql);
	//return $query->result();
	$query = $this->db->query($sql);
	return $query->row();
}

function asset_cari_count($st = NULL)
{
	if ($st == "NIL") $st = "";
	$sql = "select Id FROM asset_list WHERE (kode LIKE '%$st%' OR spesifikasi LIKE '%$st%' OR nama_asset LIKE '%$st%')";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function inbox_cari_count($st = NULL,$nip)
{
	if ($st == "NIL") $st = "";
	$sql = "select id FROM memo WHERE (judul LIKE '%$st%' AND nip_kpd LIKE '%$nip%')";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function send_cari_count($st = NULL,$nip)
{
	if ($st == "NIL") $st = "";
	$sql = "select id FROM memo WHERE (judul LIKE '%$st%' AND nip_dari LIKE '%$nip%')";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function asset_cari_pagination($limit, $start, $st = NULL)
{
	if ($st == "NIL") $st = "";
	$sql = "select *
	FROM asset_list
	WHERE (kode LIKE '%$st%' OR spesifikasi LIKE '%$st%' OR nama_asset LIKE '%$st%') ORDER BY kode ASC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function inbox_cari_pagination($limit, $start, $st = NULL,$nip)
{
	if ($st == "NIL") $st = "";
	$sql = "select a.id,a.nomor_memo,a.nip_kpd,a.judul,a.tanggal,a.read,a.nip_dari,b.nama
	FROM memo a LEFT JOIN users b ON a.nip_dari = b.nip
	WHERE (a.judul LIKE '%$st%' AND a.nip_kpd LIKE '%$nip%') ORDER BY a.tanggal DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function send_cari_pagination($limit, $start, $st = NULL,$nip)
{
	if ($st == "NIL") $st = "";
	$sql = "select a.id,a.nomor_memo,a.nip_kpd,a.judul,a.tanggal,a.read,a.nip_dari,b.nama
	FROM memo a LEFT JOIN users b ON a.nip_dari = b.nip
	WHERE (a.judul LIKE '%$st%' AND a.nip_dari LIKE '%$nip%') ORDER BY a.tanggal DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function sendto($level_jabatan,$bagian)
{
	if ($level_jabatan==2){
		$sql="SELECT * FROM users WHERE ((level_jabatan <= '$level_jabatan' AND bagian = '$bagian') OR (level_jabatan >= '$level_jabatan')) ORDER BY level_jabatan DESC";
	}elseif ($level_jabatan==3){
		$sql="SELECT * FROM users WHERE ((level_jabatan <= '$level_jabatan' AND bagian = '$bagian') OR (level_jabatan >= 2)) ORDER BY level_jabatan DESC";
	}elseif ($level_jabatan==4){
		$sql="SELECT * FROM users WHERE ((level_jabatan <= '$level_jabatan' AND bagian = '$bagian') OR (level_jabatan >= 2)) ORDER BY level_jabatan DESC";
	}elseif ($level_jabatan==5 AND $bagian<>11){
		$sql="SELECT * FROM users WHERE level_jabatan >= 2 ORDER BY level_jabatan DESC";
	}elseif ($level_jabatan==5 AND $bagian==11){
		$sql="SELECT * FROM users WHERE (level_jabatan >= 2 OR bagian = 4) ORDER BY level_jabatan DESC";
	}elseif ($level_jabatan==6){
		$sql="SELECT * FROM users WHERE level_jabatan >= 2 ORDER BY level_jabatan DESC";
	}elseif ($level_jabatan==1){
		$sql="SELECT * FROM users WHERE bagian = '$bagian' ORDER BY level_jabatan DESC";
	}
	$query = $this->db->query($sql);
	return $query->result();
}
	
function cari_gaji($nip)
{
	$bulan = $this->input->post('date_pic');
	$sql="SELECT * FROM gaji WHERE (nip = '$nip') AND (DATE_FORMAT(bulan_gaji, '%Y-%m') = '$bulan')";
	$query = $this->db->query($sql);
	return $query->result();
	
	/* $this->db->select('*');
	$this->db->from('gaji');
	$this->db->where('nip', $nip);
	$query = $this->db->get();
	return $query->row(); */
}	
function slip_gaji($id)
{
	$bulan	= $this->input->post('date_pic');
	$nip 	= $this->session->userdata('nip');
	//$sql="SELECT * FROM gaji WHERE (nip = '$nip') AND (DATE_FORMAT(bulan_gaji, '%Y-%m') = '$bulan')";
	$sql="SELECT * FROM gaji WHERE Id=$id AND nip='$nip';";
	$query = $this->db->query($sql);
	return $query->row();
	
	/* $this->db->select('*');
	$this->db->from('gaji');
	$this->db->where('nip', $nip);
	$query = $this->db->get();
	return $query->row(); */
}
function get_agent_id($id){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('agent');
    $this->db->where('Id', $id);
    $query = $this->db->get();
    return $query->row();
}
function get_user_username($username){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('users');
    $this->db->where('username', $username);
    $query = $this->db->get();
    return $query->row();
}
function list_antrian_count($tgl_antrian,$st = NULL)
{
	if ($st == "NIL") $st = "";
	//$sql="SELECT * FROM antrian WHERE (date_pic = '$tgl_antrian' AND status = 1)";
	$sql="SELECT * FROM antrian WHERE (date_pic >= '$tgl_antrian')";
	$query = $this->db->query($sql);
	return $query->num_rows();
}
function list_antrian_pagination($limit, $start, $st = NULL)
{
	$utility = $this->m_app->get_utility();	
	$tgl_antrian = $utility->tgl_antrian; 
	if ($st == "NIL") $st = "";
	//$sql="SELECT * FROM antrian WHERE (date_pic = '$tgl_antrian' AND status = 1) ORDER BY jam_terpilih ASC, nomor_antrian ASC limit " . $start . ", " . $limit;
	$sql="SELECT * FROM antrian WHERE (date_pic >= '$tgl_antrian') ORDER BY status ASC, jam_terpilih ASC  limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}	
function get_antrian_smu_id($id){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('antrian_smu');
    $this->db->where('nomor_smu', $id);
    $query = $this->db->get();
    return $query->row();
}
function update_antrian_id($status,$id,$remark,$jam = NULL, $jam_old = NULL){
	if (empty($jam)){
		$sql = "UPDATE antrian SET status = $status, remark = '$remark' WHERE Id=$id";
		$query = $this->db->query($sql);
		//update 0 jadwal_slot20
		$sql = "SELECT jam_terpilih FROM antrian WHERE Id=$id";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['jam_terpilih'];
		
		$data_update1	= array(
			'status'	=> 0
		);
		$this->db->where('status', 1);
		$this->db->where('name', $result);
		$this->db->limit(1, 1);
		$this->db->update('jadwal_slot20', $data_update1);
	}else{
		$sql = "UPDATE antrian SET status = $status, remark = '$remark', jam_terpilih = '$jam' WHERE Id=$id";
		$query = $this->db->query($sql);
		
		//update 1 jadwal_slot20
		$data_update2	= array(
			'status'	=> 1
		);
		$this->db->where('status', 0);
		$this->db->where('name', $jam);
		$this->db->limit(1, 1);
		$this->db->update('jadwal_slot20', $data_update2);
		
		//update 0 jadwal_slot20
		$data_update1	= array(
			'status'	=> 0
		);
		$this->db->where('status', 1);
		$this->db->where('name', $jam_old);
		$this->db->limit(1, 1);
		$this->db->update('jadwal_slot20', $data_update1);
	}
}
function delete_smu_id($id){
	$sql = "delete FROM antrian_smu WHERE Id = $id";
	$query = $this->db->query($sql);
}
function get_antrian_smu_nomor_antrian($id){
	$sql = "select * FROM antrian_smu WHERE id_antrian = $id";
	$query = $this->db->query($sql);
	return $query->result();
}
function insert_smu($no_antrian){
		$nomor_smu	= $this->input->post('nomor_smu');
		$info		= $this->input->post('info');
		$data_insert = array (
			'nomor_antrian' 	=> $no_antrian,
			'id_antrian'		=> $this->uri->segment(3),
			'nomor_smu'			=> $nomor_smu,
			'status'			=> 0,
			'info'				=> $info
			);
		$this->db->insert('antrian_smu',$data_insert);
}
function quotation_count($st = NULL)
{
	if ($st == "NIL") $st = "";
	$sql = "select *
	FROM quotation p
	WHERE (p.Id LIKE '%$st%')";
	$query = $this->db->query($sql);
	return $query->num_rows();
}
function list_quotation($limit, $start, $st = NULL)
{
	if ($st == "NIL") $st = "";
	$sql = "select *
	FROM quotation p
	WHERE (p.Id LIKE '%$st%') ORDER BY p.Id DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function ambil_tujuan()
{
	$sql = "select * FROM rate";
	$query = $this->db->query($sql);
	return $query->result();
}
	
function ambil_jadwal($tanggal,$time_flight,$tgl_flight){
	date_default_timezone_set('Asia/Jakarta');
	$now 		= date('Y-m-d');
	$time		= date('H:i');
	$time1		= date('H:i',strtotime($time_flight . "-8 hours"));
	$time2		= date('H:i',strtotime($time_flight));
	$date_flight = date('Y-m-d',strtotime($tgl_flight));
	//if ($time1<$time){$time2=$time;}
	//else{$time2=$time1;}
	//if ($tanggal==$now){	
		if (($date_flight <> $tanggal) AND ($time2 >= '08:00')){
			$data = [
				'0'=>['Id'=>1,'name'=>'Void Time'],
			];
			$hasil_query[] = $data;
			return $hasil_query;
		}else{
		
			$this->db->select('*');
			$this->db->where('status',0);
			//$this->db->where('name > ', $time2);
			if ($tanggal==$now){
				$this->db->where('name > ', $time1);
			}else{
				if(($time2 >= '08:00')){
					$this->db->where('name > ', $time1);
					$this->db->where('name < ', $time2);
				}else{
					$this->db->where('name < ', $time2);
				}
			}
			$this->db->group_by('name'); 
			$this->db->order_by('name', 'asc'); 
			$query = $this->db->get('jadwal_slot20');
			if ($query->num_rows() > 0 ){
			foreach ($query->result() as $data){
			$hasil_query[] = $data;
			}
			return $hasil_query;
			}   
		}
	/**}else{
		$sql1 = "select a.Id,a.slot,a.name from jadwal_slot20 a LEFT JOIN antrian_book b ON a.name = b.name AND a.slot = b.slot WHERE ((b.name IS NULL) AND (b.tanggal = $tanggal OR b.tanggal IS NULL)) GROUP BY a.name";
		$sql2 = "select a.Id,a.slot,a.name from jadwal_slot20 a LEFT JOIN antrian_book b ON a.name = b.name AND a.slot = b.slot WHERE b.name IS NULL AND a.name > '$time1' GROUP BY a.name";
		$query = $this->db->query($sql2);
		return $query->result();
	}**/
}
  
function simpan_antrian(){
	date_default_timezone_set('Asia/Jakarta');
	$now 		= date('Y-m-d H:i:s');
	$tgl_antrian	= $this->input->post('date_pic');
	$this->db->select_max('nomor_antrian');
    $this->db->where('date_pic', $tgl_antrian);
    $res1 = $this->db->get('antrian');
	if ($res1->num_rows() > 0)
    {
        $res2 = $res1->result_array();
        $result = $res2[0]['nomor_antrian']+1;
	}else{$result = 1;}
	
	$data_insert 	= array (
		'username'		=> $this->session->userdata('username'),
		'nomor_mobil'	=> $this->input->post('nomor_mobil'),
		'nomor_segel'	=> $this->input->post('nomor_segel'),
		'csd'			=> $this->input->post('nomor_csd'),
		'nama_driver'	=> $this->input->post('nama_driver'),
		'phone'			=> $this->input->post('phone'),
		'date_flight'	=> $this->input->post('date_flight'),
		//'tujuan'		=> $this->input->post('tujuan'),
		'date_pic'		=> $this->input->post('date_pic'),
		'informasi'		=> $this->input->post('informasi'),
		'jam_terpilih'	=> $this->input->post('jam_terpilih'),
		'date_input'	=> date('Y-m-d H:i:s'),
		'status'		=> 0,
		'nomor_antrian'	=> $result
		);
	$this->db->insert('antrian',$data_insert);
	
	//update tabel jadwal_slot20
	$dnow 		= date('Y-m-d');
	//if ($this->input->post('date_pic')==$dnow){   //aktifkan ini jika kembali model lama
		$this->db->select('*');
		$this->db->where('name', $this->input->post('jam_terpilih'));
		$this->db->where('status', 0);
		$res2 = $this->db->get('jadwal_slot20');
		if ($res2->num_rows() <= 8){
			$this->db->select_min('slot');
			$this->db->where('name', $this->input->post('jam_terpilih'));
			$this->db->where('status', 0);
			$res1 	= $this->db->get('jadwal_slot20');
			$res2 	= $res1->result_array();
			$result = $res2[0]['slot'];
			$stat 	= $result; 
		}
			
		$data_update 	= array (
			'status' 	=> 1
			);
		$this->db->where('name',$this->input->post('jam_terpilih'));
		$this->db->where('slot',$stat);
		$this->db->update('jadwal_slot20',$data_update);
	/**}else{
		$this->db->select('*');
		$this->db->where('name', $this->input->post('jam_terpilih'));
		$this->db->where('tanggal', $this->input->post('date_pic'));
		$res2 = $this->db->get('antrian_book');
		if ($res2->num_rows() == 0){$stat = 1;}
		elseif($res2->num_rows() == 1){$stat = 2;}
		elseif($res2->num_rows() == 2){$stat = 3;}
		elseif($res2->num_rows() == 3){$stat = 4;}
		elseif($res2->num_rows() == 4){$stat = 5;}
		elseif($res2->num_rows() == 5){$stat = 6;}
		elseif($res2->num_rows() == 6){$stat = 7;}
		elseif($res2->num_rows() == 7){$stat = 8;}
		
		$data_ins 	= array (
			'slot' 		 => $stat,
			'name' 		 => $this->input->post('jam_terpilih'),
			'tanggal'	 => $this->input->post('date_pic'),
			'input_date' => date('Y-m-d H:i:s'),
			'input_user' => $this->session->userdata('username')
			);
		$this->db->insert('antrian_book',$data_ins);
	}**/ //aktifkan ini jika kembali model lama
}
function get_utility(){
	$this->db->select('*');
	$this->db->from('utility');
	$query = $this->db->get();
	return $query->row();
}
function get_antrian($id){
	$this->db->select('*');
	$this->db->from('antrian');
	$this->db->where('Id', $id);
	$query = $this->db->get();
	return $query->row();
}
function get_antrian_user($username){
	date_default_timezone_set('Asia/Jakarta');
	$now 		= date('Y-m-d');
	$first_date = date('Y-m-d', strtotime($now. ' - 1 days'));
	$this->db->select('*');
	$this->db->from('antrian');
	$this->db->where('username', $username);
	$this->db->where('date_pic >=',$first_date); 
	//$this->db->where('date_pic', $now);
	$query = $this->db->get();
	if ($query->num_rows() > 0 ){
	foreach ($query->result() as $data){
	$hasil_query[] = $data;
	}
	return $hasil_query;
	}

}
function get_antrian_status($status, $tgl = NULL){
	//$tgl_antrian	= date("Y/m/d");
	if (empty($tgl)){
		$this->db->select('Id');
		$this->db->where('status', $status);
		$query = $this->db->get('antrian');
		return $query->num_rows();
	}else{
		$this->db->select('Id');
		$this->db->where('status', $status);
		$this->db->where('date_pic', $tgl);
		$query = $this->db->get('antrian');
		return $query->num_rows();
	}
}
function sisa_antrian($tgl_antrian){
	//$tgl_antrian	= date("Y/m/d");
	$this->db->select('Id');
	$this->db->where('date_pic', $tgl_antrian);
	$this->db->where('status', 2);
	$query = $this->db->get('antrian');
	return $query->num_rows();
}
function antrian_besok($tgl_besok){
	//$tgl_besok 		= date("Y-m-d"); //date H+1
	$this->db->select('Id');
	$this->db->where('date_pic', date('Y-m-d', strtotime($tgl_besok. ' + 1 days')));
	$query = $this->db->get('antrian');
	return $query->num_rows();
}
function slot($tgl_antrian, $slot, $nom_antrian=NULL){
	date_default_timezone_set('Asia/Jakarta');
	$this->db->select('current_antrian');
    $current_antrian = $this->db->get('utility');
	$res2 = $current_antrian->result_array();
    $result = $res2[0]['current_antrian']+1;
	
	if ($nom_antrian==""){
		//$this->db->select('Id');
		//$this->db->where('date_pic', $tgl_antrian);
		//$this->db->where('nomor_antrian', $result);
		//$res = $this->db->get('antrian');
		
		$sql="SELECT Id,nomor_antrian,nomor_mobil FROM antrian WHERE (date_pic = '$tgl_antrian' AND status = 2) ORDER BY jam_terpilih ASC, nomor_antrian ASC LIMIT 1";
		$query = $this->db->query($sql);
		
		$res3 = $query->result_array();
		$id_antrian = $res3[0]['Id'];
		$nomor_antrian = $res3[0]['nomor_antrian'];
		$nopol = $res3[0]['nomor_mobil'];
		//update utility
		$data_update 	= array (
			'slot'.$slot		=> $nomor_antrian,
			'slot'.$slot.'_id'	=> $id_antrian,
			'nopol'.$slot		=> $nopol,
			'current_antrian' 	=> $nomor_antrian
			);
		$this->db->update('utility',$data_update);
		
		//update antrian
		$data_update1	= array(
			'status'	=> 3,
			'slot'		=> $slot,
			'start_time'=> date("H:i:s") 
		);
		$this->db->where('date_pic', $tgl_antrian);
		$this->db->where('Id', $id_antrian);
		$this->db->where('status', 2);
		$this->db->update('antrian', $data_update1);
	}else{
		$this->db->select('Id,nomor_mobil');
		$this->db->where('date_pic', $tgl_antrian);
		$this->db->where('nomor_antrian', $nom_antrian);
		$res = $this->db->get('antrian');
		$res3 = $res->result_array();
		$id_antrian = $res3[0]['Id'];
		$nopol = $res3[0]['nomor_mobil'];
		//update utility
		$data_update 	= array (
			'slot'.$slot		=> $nom_antrian,
			'slot'.$slot.'_id'	=> $id_antrian,
			'nopol'.$slot		=> $nopol
			);
		$this->db->update('utility',$data_update);
		
		//update antrian
		$data_update1	= array(
			'status'	=> 3,
			'slot'		=> $slot,
			'start_time'=> date("H:i:s") 
		);
		$this->db->where('date_pic', $tgl_antrian);
		$this->db->where('nomor_antrian', $nom_antrian);
		$this->db->update('antrian', $data_update1);
	}
	
}
function slot_e($id, $slot){
	//update tabel antrian
	date_default_timezone_set('Asia/Jakarta');
	$data_update1	= array(
		'status'		=> 4,
		'remark'		=> $this->input->post('remark'),
		'finish_time'	=> date("H:i:s") 
	);
	$this->db->where('Id', $id);
	$this->db->update('antrian', $data_update1);
	$antrian = $this->get_antrian($id);
	//update utility
	$data_update 	= array (
		'slot'.$slot		=> 0,
		'slot'.$slot.'_id'	=> 0,
		'nopol'.$slot		=> 0
		);
	$this->db->update('utility',$data_update);
	//update jadwal slot
	$data_update2	= array(
		'status'	=> 0
	);
	$this->db->where('status', 1);
	$this->db->where('name', $antrian->jam_terpilih);
	$this->db->limit(1, 1);
	$this->db->update('jadwal_slot20', $data_update2);
}
function set_date($tanggal){
	//update utility
	$data_update 	= array (
		'tgl_antrian'		=> $tanggal,
		'current_antrian'	=> 0
		);
	$this->db->update('utility',$data_update);
	
	//update tabel antrian
	$sql1 = "UPDATE jadwal_slot20 SET status = 0;";
	$sql2 = "UPDATE jadwal_slot20 LEFT JOIN antrian_book ON (jadwal_slot20.slot = antrian_book.slot AND jadwal_slot20.name = antrian_book.name) SET jadwal_slot20.status = 1 WHERE antrian_book.name IS NOT NULL;;";
	$this->db->query($sql1);
	$this->db->query($sql2);
	
	//update delete antrian_book
	$this->db->empty_table('antrian_book'); 
}

function ambil_data_agent($kd_agent){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('agent');
    $this->db->where('Id', $kd_agent);
    $query = $this->db->get();
    return $query->row();
}

function ambil_asset_list($kd_asset){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('asset_list');
    $this->db->where('Id', $kd_asset);
    $query = $this->db->get();
    return $query->row();
}

function ambil_asset_history($kd_asset){
	$this->db->select('kode');
	$this->db->where('Id', $kd_asset);
	$res = $this->db->get('asset_list');
	$res3 = $res->result_array();
	$kode = $res3[0]['kode'];
	
	$this->db->select('*');
    $this->db->from('asset_history');
    $this->db->where('kode', $kode);
	$this->db->order_by('tanggal', 'desc');
    $query = $this->db->get();
    return $query->result();
}



}

?>
