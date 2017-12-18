<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lihat_nilai extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_lihat_nilai');		
	}

	function index() {
		// var_dump($this->m_kelas->lihat_deadline_belum_dikumpul());
		foreach ($this->m_lihat_nilai->lihat_deadline_belum_dikumpul() as $item) {
		 	$this->m_lihat_nilai->kumpul_ujian($item->id_ujian);
		 	// echo $item->id_ujian;
		 } 

		if ($this->input->post('nis') != null) {
			$this->load->view("lihat_nilai/index");
			$data_nilai = $this->m_lihat_nilai->ambil_tabel_nilai($this->input->post('nis'));	
			$data_siswa = $this->m_lihat_nilai->ambil_data_siswa($this->input->post('nis'));
			if ($data_siswa == null) {
				redirect(base_url("lihat_nilai"));
			}	
			$this->load->view("lihat_nilai/lihat", array("data_nilai" => $data_nilai, "data_siswa" => $data_siswa));
		} else {
			$this->load->view("lihat_nilai/index");
		}
	}

	public function export($nis) {	
		$data_nilai = $this->m_lihat_nilai->ambil_tabel_nilai($nis);	
		$data_siswa = $this->m_lihat_nilai->ambil_data_siswa($nis);
		
		// Load all views as normal
		$this->load->view("lihat_nilai/export", array("data_nilai" => $data_nilai, "data_siswa" => $data_siswa));
		// Get output html
		$html = $this->output->get_output();
		
		// Load library
		$this->load->library('dompdf_gen');
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("welcome.pdf");		
	}

}
