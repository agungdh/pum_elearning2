<?php
class M_kelas extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_tabel_kelas_blm_selesai($id_guru){
		$sql = "SELECT *
		FROM v_tabel_kelas
		WHERE id_guru = ?
		AND status_selesai = 0
		ORDER BY id_kelas DESC";
		$query = $this->db->query($sql, array($id_guru));
		$row = $query->result();

		return $row;
	}

	function  kumpul_ujian($id_ujian){
		$sql = "CALL sp_kumpul_ujian(?)";
		$query = $this->db->query($sql, array($id_ujian));
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

	function ambil_tabel_kelas_sdh_selesai($id_guru){
		$sql = "SELECT *
		FROM v_tabel_kelas
		WHERE id_guru = ?
		AND status_selesai = 1
		ORDER BY id_kelas DESC";
		$query = $this->db->query($sql, array($id_guru));
		$row = $query->result();

		return $row;
	}

	function ambil_nilai_siswa($id_kelas){
		$sql = "SELECT *
		FROM v_tabel_ujian
		WHERE id_kelas = ?";
		$query = $this->db->query($sql, array($id_kelas));
		$row = $query->result();

		return $row;
	}

	function ambil_data_angkatan(){
		$sql = "SELECT *
		FROM angkatan
		ORDER BY id DESC";
		$query = $this->db->query($sql);
		$row = $query->result();

		return $row;
	}

	function ambil_data_mapel($id_guru){
		$sql = "SELECT *
		FROM mapel
		WHERE id_guru = ?
		ORDER BY id DESC";
		$query = $this->db->query($sql, array($id_guru));
		$row = $query->result();

		return $row;
	}

	function cek_jumlah_siswa($id_kelas){
		$sql = "SELECT f_cek_jumlah_siswa_dalam_kelas(?) total";
		$query = $this->db->query($sql, array($id_kelas));
		$row = $query->row();

		return $row->total;
	}

	function ubah_status($id){
		$sql = "call sp_ubah_status_kelas(?)";
		$this->db->query($sql, array($id));
	}

	function ambil_id_guru($id_user){
		$sql = "SELECT f_ambil_id_guru_dari_id_user(?) hasil";
		$query = $this->db->query($sql, array($id_user));
		$row = $query->row();

		return $row->hasil;
	}

	function ambil_data_kelas($id){
		$sql = "SELECT *
		FROM v_tabel_kelas
		WHERE id_mapel = ?";
		$query = $this->db->query($sql, array($id));
		$row = $query->row();

		return $row;
	}

	function ambil_data_kelas_dari_id($id){
		$sql = "SELECT *
		FROM v_tabel_kelas
		WHERE id_kelas = ?";
		$query = $this->db->query($sql, array($id));
		$row = $query->row();

		return $row;
	}

	function ambil_data_siswa($id_kelas){
		$sql = "call sp_kelas_lihat_siswa(?)";
		$query = $this->db->query($sql, array($id_kelas));
		$row = $query->result();

		return $row;
	}

	function tambah_kelas($id_guru, $angkatan, $materi, $kelas){
		$sql = "call sp_tambah_kelas(?,?,?,?);";
		$this->db->query($sql, array($angkatan, $id_guru, $materi, $kelas));
	}

	function hapus_siswa($id_detil_kelas){
		$sql = "call sp_hapus_detil_kelas(?);";
		$this->db->query($sql, array($id_detil_kelas));
	}

	function ambil_data_siswa_perangkatan($id_kelas, $id_angkatan){
		$sql = "call sp_lihat_kelas_tambah_siswa(?,?)";
		$query = $this->db->query($sql, array($id_kelas, $id_angkatan));
		$row = $query->result();

		return $row;
	}

	function ambil_data_angkatan_dari_kelas($id_angkatan){
		$sql = "select f_ambil_data_angkatan_dari_kelas(?) data";
		$query = $this->db->query($sql, array($id_angkatan));
		$row = $query->row();

		return $row->data;
	}

	function tambah_detil_kelas($id_kelas, $id_siswa){
		$sql = "call sp_tambah_detil_kelas(?,?)";
		$this->db->query($sql, array($id_kelas, $id_siswa));
	}

	function hapus_kelas($id_kelas){
		$sql = "call sp_hapus_kelas(?)";
		$this->db->query($sql, array($id_kelas));
	}

	function hapus_kelas_ambil_data_kelas_dari_ujian($id_kelas){
		$sql = "SELECT *
				FROM ujian
				WHERE id_kelas = ?";

		foreach ($this->db->query($sql, array($id_kelas))->result() as $item) {
			$sql2 = "DELETE FROM ujian_soal
					WHERE id_ujian = ?";
			$this->db->query($sql2, array($item->id));	
		}

		$sql2 = "DELETE FROM ujian
				WHERE id_kelas = ?";
		$this->db->query($sql2, array($id_kelas));	
	}

}
?>