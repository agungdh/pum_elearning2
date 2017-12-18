<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_admin');		
	}

	function index() {
		$data_admin = $this->m_admin->ambil_tabel_admin();

		$this->load->view("template/template", array("isi"=>"admin/index", "data"=>$data_admin));
	}

	function tambah(){
		$this->load->view('template/template',array("isi" => "admin/tambah"));
	}

	function aksi_tambah(){
		$username = $this->input->post('username');
		$nama = $this->input->post('nama');
		
		$this->m_admin->tambah_admin($username, $nama);
		
		redirect(base_url('admin'));	
	}

	function ubah($id){
		$data_admin = $this->m_admin->ambil_data_admin($id);

		$this->load->view('template/template',array("isi" => "admin/ubah", "data" => $data_admin));
	}

	function aksi_ubah(){
		$nama = $this->input->post('nama');
		$id = $this->input->post('id');

		$this->m_admin->ubah_admin($nama, $id);
		
		redirect(base_url('admin'));	
	}

	function hapus($id){
		$data_admin = $this->m_admin->ambil_data_admin($id);

		$this->load->view('template/template',array("isi" => "admin/hapus", "data" => $data_admin));
	}

	function aksi_hapus(){
		$id = $this->input->post('id');

		$this->m_admin->hapus_admin($id);
		
		redirect(base_url('admin'));	
	}


}
