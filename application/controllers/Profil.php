<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_profil');		
	}

	function index() {
		$data_user = $this->m_profil->ambil_data_profil();
		
		$this->load->view("template/template", array("isi"=>"template/profil", "data"=>$data_user));
	}

	function aksi_ubah_profil(){
		$nama = $this->m_profil->ubah_profil();

		$this->session->set_userdata('nama', $nama);

		redirect(base_url());
	}

	function ganti_password() {
		$this->load->view("template/template", array("isi"=>"template/ganti_password"));
	}

	function aksi_ganti_password() {
		$this->m_profil->ganti_password();

		redirect(base_url());
	}

}
