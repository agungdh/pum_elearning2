<?php
class M_angkatan extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_tabel_angkatan(){
		$sql = "SELECT *
		FROM angkatan
		ORDER BY id DESC";
		$query = $this->db->query($sql);
		$row = $query->result();

		return $row;
	}

	function ambil_data_angkatan($id){
		$sql = "SELECT *
		FROM angkatan
		WHERE id = ?";
		$query = $this->db->query($sql, array($id));
		$row = $query->row();

		return $row;
	}

	function tambah_angkatan($angkatan){
		$sql = "call sp_tambah_angkatan(?);";
		$query = $this->db->query($sql, array($angkatan));
	}

	function ubah_angkatan($angkatan, $id){
		$sql = "call sp_ubah_angkatan(?,?);";
		$query = $this->db->query($sql, array($angkatan, $id));
	}

	function hapus_angkatan($id){
		$sql = "call sp_hapus_angkatan(?);";
		$query = $this->db->query($sql, array($id));
	}

	function ambil_id_admin($id_user){
		$sql = "SELECT f_ambil_id_admin_dari_id_user(?) hasil";
		$query = $this->db->query($sql, array($id_user));
		$row = $query->row();

		return $row->hasil;
	}

}
?>