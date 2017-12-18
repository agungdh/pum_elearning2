<?php
class M_kelas_siswa extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function  isi_jawaban($id_ujian_soal, $id_jawaban){
		$sql = "CALL sp_pilih_jawaban(?,?)";
		$query = $this->db->query($sql, array($id_ujian_soal, $id_jawaban));
	}	

	function  kumpul_ujian($id_ujian){
		$sql = "CALL sp_kumpul_ujian(?)";
		$query = $this->db->query($sql, array($id_ujian));
	}	

	function ambil_id_kelas_dari_id_ujian($id_ujian){
		$sql = "SELECT f_ambil_id_kelas_dari_id_ujian(?) hasil";
		$query = $this->db->query($sql, array($id_ujian));
		$row = $query->row();

		return $row->hasil;
	}

	function ambil_jawaban($id_ujian_soal){
		$sql = "SELECT f_ambil_jawaban(?) hasil";
		$query = $this->db->query($sql, array($id_ujian_soal));
		$row = $query->row();

		return $row->hasil;
	}

	function cek_ujian_aktif($id_kelas, $id_siswa){
		$sql = "SELECT f_cek_ujian_aktif(?,?) hasil";
		$query = $this->db->query($sql, array($id_kelas, $id_siswa));
		$row = $query->row();

		return $row->hasil;
	}

	function ambil_data_kelas($id_kelas){
		$sql = "SELECT *
		FROM v_tabel_kelas
		WHERE id_kelas = ?";
		$query = $this->db->query($sql, array($id_kelas));
		$row = $query->row();

		return $row;
	}

	function ambil_jawaban_dari_soal($id_banksoal){
		$sql = "SELECT *
		FROM `jawaban_banksoal`
		WHERE id_banksoal = ?
		ORDER BY rand()";
		$query = $this->db->query($sql, array($id_banksoal));
		$row = $query->result();

		return $row;
	}

	function ambil_data_ujian($id_ujian){
		$sql = "SELECT *
		FROM v_tabel_ujian
		WHERE id_ujian = ?";
		$query = $this->db->query($sql, array($id_ujian));
		$row = $query->row();

		return $row;
	}

	function ambil_data_soal($id_ujian){
		$sql = "SELECT *
		FROM v_tabel_ujian_banksoal
		WHERE id_ujian = ?";
		$query = $this->db->query($sql, array($id_ujian));
		$row = $query->result();

		return $row;
	}

	function ambil_tabel_ujian($id_kelas, $id_siswa){
		$sql = "SELECT *
		FROM v_tabel_ujian
		WHERE id_kelas = ?
		AND id_siswa = ?
		AND nilai IS NOT NULL";
		$query = $this->db->query($sql, array($id_kelas, $id_siswa));
		$row = $query->result();

		return $row;
	}

	function  cek_jumlah_ujian_siswa($id_kelas, $id_siswa){
		$sql = "SELECT f_cek_jumlah_ujian_siswa(?,?) hasil";
		$query = $this->db->query($sql, array($id_kelas, $id_siswa));
		$row = $query->row();

		return $row->hasil;
	}

	function ambil_id_siswa($id_user){
		$sql = "SELECT f_ambil_id_siswa_dari_id_user(?) hasil";
		$query = $this->db->query($sql, array($id_user));
		$row = $query->row();

		return $row->hasil;
	}

	function ambil_tabel_kelas_blm_selesai($id_siswa){
		$sql = "SELECT *
		FROM v_tabel_detil_kelas_siswa
		WHERE id_siswa = ?
		AND status = 0
		ORDER BY id_kelas DESC";
		$query = $this->db->query($sql, array($id_siswa));
		$row = $query->result();

		return $row;
	}

	function ambil_tabel_kelas_sdh_selesai($id_siswa){
		$sql = "SELECT *
		FROM v_tabel_detil_kelas_siswa
		WHERE id_siswa = ?
		AND status = 1
		ORDER BY id_kelas DESC";
		$query = $this->db->query($sql, array($id_siswa));
		$row = $query->result();

		return $row;
	}

	function aksi_ujian($id_kelas, $id_siswa){
		$sql = "call sp_siswa_mulai_ujian(?,?)";
		$query = $this->db->query($sql, array($id_kelas, $id_siswa));
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


}
?>