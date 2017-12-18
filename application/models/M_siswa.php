<?php
class M_siswa extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_tabel_siswa(){
		$sql = "SELECT *
		FROM v_tabel_siswa
		ORDER BY id_siswa DESC";
		$query = $this->db->query($sql);
		$row = $query->result();

		return $row;
	}

	function ambil_data_siswa($id){
		$sql = "SELECT *
		FROM v_tabel_siswa
		WHERE id_siswa = ?";
		$query = $this->db->query($sql, array($id));
		$row = $query->row();

		return $row;
	}

	function tambah_siswa($nis, $nama, $angkatan){
		$sql = "call sp_tambah_siswa(?,?,?);";
		$query = $this->db->query($sql, array($nis, $nama, $angkatan));
	}

	function ubah_siswa($nama, $angkatan, $id){
		$sql = "call sp_ubah_siswa(?,?,?);";
		$query = $this->db->query($sql, array($nama, $angkatan, $id));
	}

	function hapus_siswa($id){
		$sql = "call sp_hapus_siswa(?);";
		$query = $this->db->query($sql, array($id));
	}

	function ambil_id_angkatan($angkatan){
		$sql = "SELECT f_ambil_id_angkatan_dari_angkatan(?) hasil";
		$query = $this->db->query($sql, array($angkatan));
		$row = $query->row();

		return $row->hasil;
	}

	function ambil_id_admin($id_user){
		$sql = "SELECT f_ambil_id_admin_dari_id_user(?) hasil";
		$query = $this->db->query($sql, array($id_user));
		$row = $query->row();

		return $row->hasil;
	}


}
?>