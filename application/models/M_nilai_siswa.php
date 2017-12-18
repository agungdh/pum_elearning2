<?php
class M_nilai_siswa extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_tabel_nilai($id_siswa){
		$sql = "SELECT *
		FROM v_tabel_ujian
		WHERE id_siswa = ?
		AND nilai IS NOT NULL";
		$query = $this->db->query($sql, array($id_siswa));
		$row = $query->result();

		return $row;
	}

	function ambil_id_siswa($id_user){
		$sql = "SELECT f_ambil_id_siswa_dari_id_user(?) hasil";
		$query = $this->db->query($sql, array($id_user));
		$row = $query->row();

		return $row->hasil;
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

	function  kumpul_ujian($id_ujian){
		$sql = "CALL sp_kumpul_ujian(?)";
		$query = $this->db->query($sql, array($id_ujian));
	}	


}
?>