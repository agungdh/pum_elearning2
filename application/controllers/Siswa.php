<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_siswa');		
		$this->load->model('m_angkatan');		
	}

	function index() {
		$data_siswa = $this->m_siswa->ambil_tabel_siswa();

		$this->load->view("template/template", array("isi"=>"siswa/index", "data"=>$data_siswa));
	}

	function tambah(){
		$angkatan = $this->m_angkatan->ambil_tabel_angkatan();

		$this->load->view('template/template',array("isi" => "siswa/tambah", "data" => $angkatan));
	}

	function aksi_tambah(){
		$nis = $this->input->post('nis');
		$nama = $this->input->post('nama');
		$angkatan = $this->input->post('angkatan');
		
		$this->m_siswa->tambah_siswa($nis, $nama, $angkatan);
		
		redirect(base_url('siswa'));	
	}

	function ubah($id){
		$angkatan = $this->m_angkatan->ambil_tabel_angkatan();
		$data_siswa = $this->m_siswa->ambil_data_siswa($id);

		$this->load->view('template/template',array("isi" => "siswa/ubah", "data" => array("siswa" => $data_siswa, "angkatan" => $angkatan)));
	}

	function aksi_ubah(){
		$nama = $this->input->post('nama');
		$angkatan = $this->input->post('angkatan');
		$id = $this->input->post('id');

		$this->m_siswa->ubah_siswa($nama, $angkatan, $id);
		
		redirect(base_url('siswa'));	
	}

	function hapus($id){
		$angkatan = $this->m_angkatan->ambil_tabel_angkatan();
		$data_siswa = $this->m_siswa->ambil_data_siswa($id);

		$this->load->view('template/template',array("isi" => "siswa/hapus", "data" => array("siswa" => $data_siswa, "angkatan" => $angkatan)));
	}

	function aksi_hapus($id){
		$this->m_siswa->hapus_siswa($id);
		
		redirect(base_url('siswa'));	
	}

	function impor(){
		$this->load->view('template/template',array("isi" => "siswa/impor"));
	}

	function aksi_impor(){
		$this->load->library('excelreader/Excel_reader');
		if ($_FILES['excel']['size']==0) {
			redirect(base_url('siswa/impor?file_kosong=1'));	
		}

		$id_admin = $this->m_siswa->ambil_id_admin($this->session->id);

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
						redirect(base_url('siswa/impor?upload_gagal=1'));
					}
				}else{
					redirect(base_url('siswa/impor?file_kebesaran=1'));	
					// echo 'UKURAN FILE TERLALU BESAR';
				}
			}else{
				redirect(base_url('siswa/impor?ekstensi_salah=1'));	
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
			$this->m_siswa->tambah_siswa($data['cells'][$i][2],$data['cells'][$i][3],$this->m_siswa->ambil_id_angkatan($data['cells'][$i][1]));
		}

		redirect(base_url('siswa'));	


	}



}
