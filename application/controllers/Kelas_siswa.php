<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_siswa extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_kelas_siswa');		
	}

	function index() {
		$id_siswa = $this->m_kelas_siswa->ambil_id_siswa($this->session->id);
		$data_kelas_aktif = $this->m_kelas_siswa->ambil_tabel_kelas_blm_selesai($id_siswa);
		$data_kelas_selesai = $this->m_kelas_siswa->ambil_tabel_kelas_sdh_selesai($id_siswa);

		$this->load->view("template/template", array("isi"=>"kelas_siswa/index", "data"=>array("data_kelas_aktif"=>$data_kelas_aktif, "data_kelas_selesai"=>$data_kelas_selesai, "id_siswa"=>$id_siswa)));

		// echo $id_siswa;
	}

	function ujian($id_kelas) {
		// var_dump($this->m_kelas->lihat_deadline_belum_dikumpul());
		foreach ($this->m_kelas_siswa->lihat_deadline_belum_dikumpul() as $item) {
		 	$this->m_kelas_siswa->kumpul_ujian($item->id_ujian);
		 	// echo $item->id_ujian;
		 } 

		$id_siswa = $this->m_kelas_siswa->ambil_id_siswa($this->session->id);
		$jumlah_ujian = $this->m_kelas_siswa->cek_jumlah_ujian_siswa($id_kelas, $id_siswa);
		$data_kelas = $this->m_kelas_siswa->ambil_data_kelas($id_kelas);
		$tabel_ujian = $this->m_kelas_siswa->ambil_tabel_ujian($id_kelas, $id_siswa);
		$status_ujian = $this->m_kelas_siswa->cek_ujian_aktif($id_kelas, $id_siswa);
		$soal_ujian = $this->m_kelas_siswa->ambil_data_soal($status_ujian);
		
		$data_ujian = $this->m_kelas_siswa->ambil_data_ujian($status_ujian);


		// var_dump($data_ujian);

		if ($status_ujian == null) {
			$this->load->view("template/template", array("isi"=>"kelas_siswa/ujian", "data"=>array("id_kelas"=>$id_kelas, "id_siswa"=>$id_siswa, "jumlah_ujian"=>$jumlah_ujian , "data_kelas"=>$data_kelas , "tabel_ujian"=>$tabel_ujian, "soal_ujian"=>$soal_ujian, "status_ujian"=>$status_ujian, "data_ujian"=>$data_ujian)));	
		} else {
			$this->load->view("template/template", array("isi"=>"kelas_siswa/kerjakan_ujian", "data"=>array("id_kelas"=>$id_kelas, "id_siswa"=>$id_siswa, "jumlah_ujian"=>$jumlah_ujian , "data_kelas"=>$data_kelas , "tabel_ujian"=>$tabel_ujian, "soal_ujian"=>$soal_ujian, "status_ujian"=>$status_ujian, "data_ujian"=>$data_ujian)));
		}

		
	}

	function aksi_ujian($id_kelas, $id_siswa) {
		$this->m_kelas_siswa->aksi_ujian($id_kelas, $id_siswa);

		redirect(base_url("kelas_siswa/ujian/".$id_kelas));
	}

	function aksi_input_jawaban() {
		$id_kelas = $this->input->post('id_kelas');
		$id_soal = $this->input->post('id_soal');
		$no = $this->input->post('no');
		$id_jawaban = $this->input->post($id_soal);
		$next = $no+1;

		// echo "ID Kelas = " . $id_kelas . "<br>";
		// echo "ID Soal = " . $id_soal . "<br>";
		// echo "ID Jawaban = " . $id_jawaban . "<br>";
		// echo "No = " . $no . "<br>";

		$this->m_kelas_siswa->isi_jawaban($id_soal, $id_jawaban);
		// echo base_url("kelas_siswa/ujian/".$id_kelas."?no=".$next);
		if ($no == 10) {
			redirect(base_url("kelas_siswa/ujian/".$id_kelas."?no=".$no));
		} else {
			redirect(base_url("kelas_siswa/ujian/".$id_kelas."?no=".$next));
		}
	}

	function test($id_ujian) {
		$data_ujian = $this->m_kelas_siswa->ambil_data_ujian($id_ujian);

		// echo $data_ujian->deadline;
		// var_dump($data_ujian);
		echo date('Y-m-d H:i:s',$data_ujian->unix_waktu_ujian);
		echo "<br>";
		echo date('Y-m-d H:i:s',$data_ujian->unix_deadline);
	}

	function kumpul_ujian($id_ujian) {
		$this->m_kelas_siswa->kumpul_ujian($id_ujian);
		$id_kelas = $this->m_kelas_siswa->ambil_id_kelas_dari_id_ujian($id_ujian);
 
		if ($this->input->get("time") == "up") {
			redirect(base_url("kelas_siswa/ujian/" . $id_kelas. "?time=up"));
		} else {
			redirect(base_url("kelas_siswa/ujian/" . $id_kelas));
		}
	}

}
