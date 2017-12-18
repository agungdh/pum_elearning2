<?php
class M_profil extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_data_profil() {
		$sql = "CALL sp_ambil_data_profil(?)";
		$query = $this->db->query($sql, array($this->session->id));
		$row = $query->row();
		
		$data_user = array('nama' => $row->nama);

		return $data_user;
	}

	function ganti_password() {
		$id = $this->input->post('id');
		$password = $this->input->post('password');

		$sql = "CALL sp_ganti_password(?,?)";
		$query = $this->db->query($sql, array($password, $id));
	}

	function ubah_profil(){
		$id = $this->input->post('id');
		$nama = $this->input->post('nama');

		$sql = "CALL sp_ubah_user(?,?)";
		$query = $this->db->query($sql, array($nama, $id));	

		return $nama;
	}
}
?>