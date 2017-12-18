<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Angkatan extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_angkatan');	
	}

	function index() {
		$data_angkatan = $this->m_angkatan->ambil_tabel_angkatan();

		$this->load->view("template/template", array("isi"=>"angkatan/index", "data"=>$data_angkatan));
	}

	function tambah(){
		$this->load->view('template/template',array("isi" => "angkatan/tambah"));
	}

	function aksi_tambah(){
		$angkatan = $this->input->post('angkatan');
		
		$this->m_angkatan->tambah_angkatan($angkatan);
		
		redirect(base_url('angkatan'));	
	}

	function impor(){
		$this->load->view('template/template',array("isi" => "angkatan/impor"));
	}

	function aksi_impor(){
		$this->load->library('excelreader/Excel_reader');
		if ($_FILES['excel']['size']==0) {
			redirect(base_url('angkatan/impor?file_kosong=1'));	
		}

		$id_admin = $this->m_angkatan->ambil_id_admin($this->session->id);

			$ekstensi_diperbolehkan	= array('xls');
			$nama = $_FILES['excel']['name'];
			$x = explode('.', $nama);
			$ekstensi = strtolower(end($x));
			//awal
			//tengah
			//akhir
			//end() -> akhir
			$ukuran	= $_FILES['excel']['size'];
			$file_tmp = $_FILES['excel']['tmp_name'];	
 
			if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
				if($ukuran < 5242880){			
					if(move_uploaded_file($file_tmp, 'berkas/temp/'.$id_admin.'.xls')){
						// echo 'FILE BERHASIL DI UPLOAD';
					}else{
						// echo 'GAGAL MENGUPLOAD FILE';
						redirect(base_url('angkatan/impor?upload_gagal=1'));
					}
				}else{
					redirect(base_url('angkatan/impor?file_kebesaran=1'));	
					// echo 'UKURAN FILE TERLALU BESAR';
				}
			}else{
				redirect(base_url('angkatan/impor?ekstensi_salah=1'));	
				// echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
			}
		
		$this->excel_reader->setOutputEncoding('230787');
		$this->excel_reader->read('berkas/temp/'.$id_admin.'.xls');

		$data = $this->excel_reader->sheets[0];
		// echo $data['cells'][3][1]; //['cells'][bawah][samping]
		// echo "<br>";
		// echo $data['numRows']; //jumah baris (bawah)

		for ($i=4; $i <= $data['numRows']; $i++) { 
			// echo $data['cells'][$i][1] . "<br>";
			$this->m_angkatan->tambah_angkatan($data['cells'][$i][1]);
		}

		redirect(base_url('angkatan'));	


	}

	function ubah($id){
		$data_angkatan = $this->m_angkatan->ambil_data_angkatan($id);

		$this->load->view('template/template',array("isi" => "angkatan/ubah", "data" => $data_angkatan));
	}

	function aksi_ubah(){
		$angkatan = $this->input->post('angkatan');
		$id = $this->input->post('id');
		
		$this->m_angkatan->ubah_angkatan($angkatan, $id);
		
		redirect(base_url('angkatan'));	
	}

	function hapus($id){
		$data_angkatan = $this->m_angkatan->ambil_data_angkatan($id);

		$this->load->view('template/template',array("isi" => "angkatan/hapus", "data" => $data_angkatan));
	}

	function aksi_hapus($id){
		$this->m_angkatan->hapus_angkatan($id);
		
		redirect(base_url('angkatan'));	
	}

}
