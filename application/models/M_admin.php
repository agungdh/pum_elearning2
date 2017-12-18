<?php
class M_admin extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_tabel_admin(){
		$sql = "SELECT *
		FROM v_tabel_admin
		ORDER BY id_admin DESC";
		$query = $this->db->query($sql);
		$row = $query->result();

		return $row;
	}

	function ambil_data_admin($id){
		$sql = "SELECT *
		FROM v_tabel_admin
		WHERE id_admin = ?";
		$query = $this->db->query($sql, array($id));
		$row = $query->row();

		return $row;
	}

	function tambah_admin($username, $nama){
		$sql = "call sp_tambah_admin(?,?);";
		$query = $this->db->query($sql, array($username, $nama));
	}

	function ubah_admin($nama, $id){
		$sql = "call sp_ubah_admin(?,?);";
		$query = $this->db->query($sql, array($nama, $id));
	}

	function hapus_admin($id){
		$sql = "call sp_hapus_admin(?);";
		$query = $this->db->query($sql, array($id));
	}

}
?>