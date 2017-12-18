<?php
class M_banksoal extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_data_materi($id){
		$sql = "SELECT *
		FROM v_tabel_materi
		WHERE id_mapel = ?";
		$query = $this->db->query($sql, array($id));
		$row = $query->row();

		return $row;
	}

	function ambil_data_banksoal_untuk_ubah($id_banksoal) {
		$sql = "SELECT *
		FROM v_detil_banksoal
		WHERE id_banksoal = ?";
		$query = $this->db->query($sql, array($id_banksoal));
		$row = $query->row();

		return $row;		
	}

	function ambil_data_banksoal($id_mapel){
		$sql = "SELECT *
		FROM v_detil_banksoal
		WHERE id_mapel = ?";
		$query = $this->db->query($sql, array($id_mapel));
		$row = $query->result();

		return $row;
	}

	function ambil_data_jawaban_banksoal($id_banksoal){
		$sql = "SELECT *
		FROM v_detil_jawaban_banksoal
		WHERE id_banksoal = ?";
		$query = $this->db->query($sql, array($id_banksoal));
		$row = $query->result();

		return $row;
	}

	function ambil_id_guru($id_user){
		$sql = "SELECT f_ambil_id_guru_dari_id_user(?) hasil";
		$query = $this->db->query($sql, array($id_user));
		$row = $query->row();

		return $row->hasil;
	}

	function ambil_id_mapel_dari_banksoal($id_banksoal){
		$sql = "SELECT f_ambil_id_mapel_dari_banksoal(?) hasil";
		$query = $this->db->query($sql, array($id_banksoal));
		$row = $query->row();

		return $row->hasil;
	}

	function lihat_jumlah_jawaban($id_banksoal) {
		$sql = "SELECT f_lihat_jumlah_jawaban(?) hasil";
		$query = $this->db->query($sql, array($id_banksoal));
		$row = $query->row();

		return $row->hasil;
	}

	function tambah_soal($id_mapel, $soal, $jawaban1, $jawaban2, $jawaban3, $jawaban4) {
		// $this->db->reconnect();
		$sql = "CALL sp_tambah_banksoal(?,?,?,?,?,?)";
		$this->db->query($sql, array($id_mapel, $soal, $jawaban1, $jawaban2, $jawaban3, $jawaban4));
		// $this->db->close();
	}

	function tambah_jawaban($id_mapel, $jawaban) {
		$sql = "CALL sp_tambah_jawaban_banksoal(?,?,?)";
		$this->db->query($sql, array($id_mapel, $jawaban, 0));
	}

	function ubah_soal($id_banksoal, $soal, $id_jawaban1, $jawaban1, $id_jawaban2, $jawaban2, $id_jawaban3, $jawaban3, $id_jawaban4, $jawaban4) {
		$sql = "CALL sp_ubah_banksoal(?,?,?,?,?,?,?,?,?,?)";
		$this->db->query($sql, array($id_banksoal, $soal, $id_jawaban1, $jawaban1, $id_jawaban2, $jawaban2, $id_jawaban3, $jawaban3, $id_jawaban4, $jawaban4));
	}

	function hapus_soal($id_banksoal) {
		$sql = "CALL sp_hapus_banksoal(?)";
		$this->db->query($sql, array($id_banksoal));
	}

}
?>