<?php
class M_lihat_nilai extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function lihat_deadline_belum_dikumpul(){
		$sql = "SELECT *
				FROM v_tabel_ujian
				WHERE nilai IS NULL
				AND sekarang >= deadline";
		$query = $this->db->query($sql, array());
		$row = $query->result();

		return $row;
	}

	function ambil_data_siswa($nis){
		$sql = "SELECT *
				FROM v_tabel_siswa
				WHERE nis = ?";
		$query = $this->db->query($sql, array($nis));
		$row = $query->row();

		return $row;
	}

	function  kumpul_ujian($id_ujian){
		$sql = "CALL sp_kumpul_ujian(?)";
		$query = $this->db->query($sql, array($id_ujian));
	}	

	function ambil_tabel_nilai($nis){
		$sql = "SELECT *
		FROM v_tabel_ujian
		WHERE nis = ?
		AND nilai IS NOT NULL";
		$query = $this->db->query($sql, array($nis));
		$row = $query->result();

		return $row;
	}
}
?>