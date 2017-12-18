<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_siswa extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_nilai_siswa');		
	}

	function index() {
		// var_dump($this->m_kelas->lihat_deadline_belum_dikumpul());
		foreach ($this->m_nilai_siswa->lihat_deadline_belum_dikumpul() as $item) {
		 	$this->m_nilai_siswa->kumpul_ujian($item->id_ujian);
		 	// echo $item->id_ujian;
		 } 

		$id_siswa = $this->m_nilai_siswa->ambil_id_siswa($this->session->id);
		$data_nilai = $this->m_nilai_siswa->ambil_tabel_nilai($id_siswa);
		// var_dump($data_nilai);
		$this->load->view("template/template", array("isi"=>"nilai_siswa/index", "data"=>array("data_nilai"=>$data_nilai, "id_siswa"=>$id_siswa)));
	}

}
