<?php
class M_guru extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_tabel_guru(){
		$sql = "SELECT *
		FROM v_tabel_guru
		ORDER BY id_guru DESC";
		$query = $this->db->query($sql);
		$row = $query->result();

		return $row;
	}

	function ambil_data_guru($id){
		$sql = "SELECT *
		FROM v_tabel_guru
		WHERE id_guru = ?";
		$query = $this->db->query($sql, array($id));
		$row = $query->row();

		return $row;
	}

	function tambah_guru($nip, $nama){
		$sql = "call sp_tambah_guru(?,?);";
		$query = $this->db->query($sql, array($nip, $nama));
	}

	function ubah_guru($nama, $id){
		$sql = "call sp_ubah_guru(?,?);";
		$query = $this->db->query($sql, array($nama, $id));
	}

	function hapus_guru($id){
		$sql = "call sp_hapus_guru(?);";
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