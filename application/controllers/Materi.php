<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_materi');		
	}

	function index() {
		$id_guru = $this->m_materi->ambil_id_guru($this->session->id);
		$data_materi = $this->m_materi->ambil_tabel_materi($id_guru);

		$this->load->view("template/template", array("isi"=>"materi/index", "data"=>array("data_materi"=>$data_materi, "id_guru"=>$id_guru)));
	}

	function tambah(){
		$id_guru = $this->m_materi->ambil_id_guru($this->session->id);

		$this->load->view('template/template',array("isi" => "materi/tambah", "data" => $id_guru));
	}

	function lihat($id){
		$materi = $this->m_materi->ambil_data_materi($id);
		$id_guru = $this->m_materi->ambil_id_guru($this->session->id);

		$this->load->view('template/template',array("isi" => "materi/lihat", "data" => array("id" => $id, "materi" => $materi, "id_guru"=>$id_guru)));
	}

	function aksi_tambah(){
		if ($_FILES['file']['size']==0) {
			redirect(base_url('materi/tambah?file_kosong=1'));	
		}
		
		$id_guru = $this->input->post('id_guru');
		$semester = $this->input->post('semester');
		$mapel = $this->input->post('materi');

		$last_id = $this->m_materi->tambah_materi($id_guru, $semester, $mapel);
		
			$ekstensi_diperbolehkan	= array('pdf');
			$nama = $_FILES['file']['name'];
			$x = explode('.', $nama);
			$ekstensi = strtolower(end($x));
			//awal
			//tengah
			//akhir
			//end() -> akhir
			$ukuran	= $_FILES['file']['size'];
			$file_tmp = $_FILES['file']['tmp_name'];	
 
			if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
				if($ukuran < 5242880){			
					if(move_uploaded_file($file_tmp, 'berkas/materi/'.$last_id.'.pdf')){
						echo 'FILE BERHASIL DI UPLOAD';
					}else{
						// echo 'GAGAL MENGUPLOAD FILE';
						redirect(base_url('materi/tambah?upload_gagal=1'));
					}
				}else{
					redirect(base_url('materi/tambah?file_kebesaran=1'));	
					// echo 'UKURAN FILE TERLALU BESAR';
				}
			}else{
				redirect(base_url('materi/tambah?ekstensi_salah=1'));	
				// echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
			}

		redirect(base_url('materi'));	
	}

	function ubah($id){
		$materi = $this->m_materi->ambil_data_materi($id);
		$id_guru = $this->m_materi->ambil_id_guru($this->session->id);

		$this->load->view('template/template',array("isi" => "materi/ubah", "data" => array("id_guru"=>$id_guru, "materi"=>$materi, "id"=>$id)));
	}

	function aksi_ubah(){
		$id_mapel = $this->input->post('id_mapel');

		if ($_FILES['file']['size']==0) {
			redirect(base_url('materi/ubah/'.$id_mapel.'?file_kosong=1'));	
		}
		
			$ekstensi_diperbolehkan	= array('pdf');
			$nama = $_FILES['file']['name'];
			$x = explode('.', $nama);
			$ekstensi = strtolower(end($x));
			$ukuran	= $_FILES['file']['size'];
			$file_tmp = $_FILES['file']['tmp_name'];	
 
			if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
				if($ukuran < 5242880){			
					if(move_uploaded_file($file_tmp, 'berkas/materi/'.$id_mapel.'.pdf')){
						echo 'FILE BERHASIL DI UPLOAD';
					}else{
						// echo 'GAGAL MENGUPLOAD FILE';
						redirect(base_url('materi/ubah/'.$id_mapel.'?upload_gagal=1'));
					}
				}else{
					redirect(base_url('materi/ubah/'.$id_mapel.'?file_kebesaran=1'));	
					// echo 'UKURAN FILE TERLALU BESAR';
				}
			}else{
				redirect(base_url('materi/ubah/'.$id_mapel.'?ekstensi_salah=1'));	
				// echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
			}

		redirect(base_url('materi/lihat/'.$id_mapel));	
	}

	function aksi_hapus($id){

		$banksoal = $this->m_materi->ambil_tabel_banksoal($id);

		foreach ($banksoal as $item) {
			$this->m_materi->hapus_soal($item->id);			
		}

		$this->m_materi->hapus_materi($id);

		unlink("berkas/materi/".$id.".pdf");

		redirect(base_url('materi'));	
	}

}
