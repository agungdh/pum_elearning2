<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_guru');		
	}

	function index() {
		$data_guru = $this->m_guru->ambil_tabel_guru();

		$this->load->view("template/template", array("isi"=>"guru/index", "data"=>$data_guru));
	}

	function tambah(){
		$this->load->view('template/template',array("isi" => "guru/tambah"));
	}

	function aksi_tambah(){
		$nip = $this->input->post('nip');
		$nama = $this->input->post('nama');
		
		$this->m_guru->tambah_guru($nip, $nama);
		
		redirect(base_url('guru'));	
	}

	function ubah($id){
		$data_guru = $this->m_guru->ambil_data_guru($id);

		$this->load->view('template/template',array("isi" => "guru/ubah", "data" => $data_guru));
	}

	function aksi_ubah(){
		$nama = $this->input->post('nama');
		$id = $this->input->post('id');

		$this->m_guru->ubah_guru($nama, $id);
		
		redirect(base_url('guru'));	
	}

	function hapus($id){
		$data_guru = $this->m_guru->ambil_data_guru($id);

		$this->load->view('template/template',array("isi" => "guru/hapus", "data" => $data_guru));
	}

	function aksi_hapus($id){
		$this->m_guru->hapus_guru($id);
		
		redirect(base_url('guru'));	
	}

	function impor(){
		$this->load->view('template/template',array("isi" => "guru/impor"));
	}

	function aksi_impor(){
		$this->load->library('excelreader/Excel_reader');
		if ($_FILES['excel']['size']==0) {
			redirect(base_url('guru/impor?file_kosong=1'));	
		}

		$id_admin = $this->m_guru->ambil_id_admin($this->session->id);

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
						redirect(base_url('guru/impor?upload_gagal=1'));
					}
				}else{
					redirect(base_url('guru/impor?file_kebesaran=1'));	
					// echo 'UKURAN FILE TERLALU BESAR';
				}
			}else{
				redirect(base_url('guru/impor?ekstensi_salah=1'));	
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
			$this->m_guru->tambah_guru($data['cells'][$i][1],$data['cells'][$i][2]);
		}

		redirect(base_url('guru'));	


	}


}
