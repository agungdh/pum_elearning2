<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_kelas');		
	}

	function index() {
		$id_guru = $this->m_kelas->ambil_id_guru($this->session->id);
		$data_kelas_aktif = $this->m_kelas->ambil_tabel_kelas_blm_selesai($id_guru);
		$data_kelas_selesai = $this->m_kelas->ambil_tabel_kelas_sdh_selesai($id_guru);

		$this->load->view("template/template", array("isi"=>"kelas/index", "data"=>array("data_kelas_aktif"=>$data_kelas_aktif, "data_kelas_selesai"=>$data_kelas_selesai, "id_guru"=>$id_guru)));
	}

	function lihat_nilai_siswa($id_kelas) {
		// sleep(1);
		// if ($this->input->get("refresh") != 1) {
		// 	redirect("kelas/lihat_nilai_siswa/".$id_kelas."?refresh=1");
		// } 

		$id_guru = $this->m_kelas->ambil_id_guru($this->session->id);
		$data_kelas = $this->m_kelas->ambil_data_kelas_dari_id($id_kelas);

		// var_dump($this->m_kelas->lihat_deadline_belum_dikumpul());
		foreach ($this->m_kelas->lihat_deadline_belum_dikumpul() as $item) {
		 	$this->m_kelas->kumpul_ujian($item->id_ujian);
		 	// echo $item->id_ujian;
		 } 

		$data_nilai_siswa = $this->m_kelas->ambil_nilai_siswa($id_kelas);
		 // sleep(1);

		// var_dump($data_kelas);
		$this->load->view("template/template", array("isi"=>"kelas/lihat_nilai_siswa", "data"=>array("id_guru"=>$id_guru, "data_nilai_siswa"=>$data_nilai_siswa, "data_kelas"=>$data_kelas)));
	}

	function ubah_status($id) {
		$this->m_kelas->ubah_status($id);

		redirect(base_url('kelas'));
	}

	function tambah(){
		$id_guru = $this->m_kelas->ambil_id_guru($this->session->id);
		$data_angkatan = $this->m_kelas->ambil_data_angkatan();
		$data_mapel = $this->m_kelas->ambil_data_mapel($id_guru);

		$this->load->view('template/template',array("isi" => "kelas/tambah", "data" => array("id_guru" => $id_guru, "data_angkatan" => $data_angkatan, "data_mapel" => $data_mapel)));
	}

	function aksi_tambah(){
		$id_guru = $this->input->post('id_guru');		
		$angkatan = $this->input->post('angkatan');		
		$materi = $this->input->post('materi');		
		$kelas = $this->input->post('kelas');		

		$this->m_kelas->tambah_kelas($id_guru, $angkatan, $materi, $kelas);

		redirect(base_url('kelas'));
	}

	function lihat_siswa($id_kelas){
		$data_siswa = $this->m_kelas->ambil_data_siswa($id_kelas);

		$this->load->view('template/template',array("isi" => "kelas/lihat_siswa", "data" => array("data_siswa" => $data_siswa, "id_kelas" => $id_kelas)));
	}

	function hapus_siswa($id_kelas, $id_detil_kelas){
		$data_siswa = $this->m_kelas->hapus_siswa($id_detil_kelas);

		redirect(base_url('kelas/lihat_siswa/'.$id_kelas));
	}

	function tambah_siswa($id_kelas){
		$id_angkatan = $this->m_kelas->ambil_data_angkatan_dari_kelas($id_kelas);
		$data_siswa = $this->m_kelas->ambil_data_siswa_perangkatan($id_kelas, $id_angkatan);

		$this->load->view('template/template',array("isi" => "kelas/tambah_siswa", "data" => array("data_siswa" => $data_siswa, "id_kelas" => $id_kelas)));
	}

	function aksi_tambah_siswa() {
		$id_kelas = $this->input->post('id_kelas');
		foreach ($this->input->post('siswa') as $id_siswa) {
			$this->m_kelas->tambah_detil_kelas($id_kelas, $id_siswa);
		}

		redirect(base_url('kelas/lihat_siswa/'.$id_kelas));
	}

	function hapus_kelas($id_kelas) {
		$this->m_kelas->hapus_kelas_ambil_data_kelas_dari_ujian($id_kelas);
		$this->m_kelas->hapus_kelas($id_kelas);
		
		redirect(base_url('kelas'));
	}

}
