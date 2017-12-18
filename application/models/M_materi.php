<?php
class M_materi extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_tabel_banksoal($id_mapel){
		$sql = "SELECT *
		FROM banksoal
		WHERE id_mapel = ?";
		$query = $this->db->query($sql, array($id_mapel));
		$row = $query->result();

		return $row;
	}

	function ambil_tabel_materi($id_guru){
		$sql = "SELECT *
		FROM v_tabel_materi
		WHERE id_guru = ?
		ORDER BY id_mapel DESC";
		$query = $this->db->query($sql, array($id_guru));
		$row = $query->result();

		return $row;
	}

	function ambil_id_guru($id_user){
		$sql = "SELECT f_ambil_id_guru_dari_id_user(?) hasil";
		$query = $this->db->query($sql, array($id_user));
		$row = $query->row();

		return $row->hasil;
	}

	function ambil_data_materi($id){
		$sql = "SELECT *
		FROM v_tabel_materi
		WHERE id_mapel = ?";
		$query = $this->db->query($sql, array($id));
		$row = $query->row();

		return $row;
	}

	function tambah_materi($id_guru, $semester, $mapel){
		$sql = "call sp_tambah_mapel(?,?,?);";
		$query = $this->db->query($sql, array($id_guru, $semester, $mapel));
		$row = $query->row();

		return $row->last_id;
	}

	function ubah_materi($nama, $id){
		$sql = "call sp_ubah_materi(?,?);";
		$query = $this->db->query($sql, array($nama, $id));
	}

	function hapus_materi($id){
		$sql = "call sp_hapus_materi(?);";
		$query = $this->db->query($sql, array($id));
	}

	function hapus_soal($id_banksoal) {
		$sql = "CALL sp_hapus_banksoal(?)";
		$this->db->query($sql, array($id_banksoal));
	}

}
?>