<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banksoal extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_banksoal');		
	}

	function aksi_impor(){
		$this->load->library('excelreader/Excel_reader');
		if ($_FILES['excel']['size']==0) {
			redirect(base_url('banksoal/impor?file_kosong=1'));	
		}

		$id_mapel = $this->input->post('id_mapel');
		$id_guru = $this->m_banksoal->ambil_id_guru($this->session->id);

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
					if(move_uploaded_file($file_tmp, 'berkas/temp/guru/'.$id_guru.'.xls')){
						// echo 'FILE BERHASIL DI UPLOAD';
					}else{
						// echo 'GAGAL MENGUPLOAD FILE';
						redirect(base_url('banksoal/impor?upload_gagal=1'));
					}
				}else{
					redirect(base_url('banksoal/impor?file_kebesaran=1'));	
					// echo 'UKURAN FILE TERLALU BESAR';
				}
			}else{
				redirect(base_url('banksoal/impor?ekstensi_salah=1'));	
				// echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
			}
		
		$this->excel_reader->setOutputEncoding('230787');
		$this->excel_reader->read('berkas/temp/guru/'.$id_guru.'.xls');

		$data = $this->excel_reader->sheets[0];
		// echo $data['cells'][3][1]; //['cells'][bawah][samping]
		// echo "<br>";
		// echo $data['numRows']; //jumah baris (bawah)

		for ($i=4; $i <= $data['numRows']; $i++) { 
			// echo $data['cells'][$i][1] . "<br>";
			// echo $data['cells'][$i][2] . "<br>";
			// echo $data['cells'][$i][3] . "<br>";
			// echo $data['cells'][$i][4] . "<br>";
			// echo $data['cells'][$i][5] . "<br>";
			// echo "<hr>";
			$this->m_banksoal->tambah_soal($id_mapel, $data['cells'][$i][1], $data['cells'][$i][2], $data['cells'][$i][3], $data['cells'][$i][4], $data['cells'][$i][5]);
		}

		redirect(base_url('banksoal/mapel/'.$id_mapel));	
	}


	function impor($id_mapel) {
		$data_mapel = $this->m_banksoal->ambil_data_materi($id_mapel);

		$this->load->view('template/template',array("isi" => "banksoal/impor", "data"=>array("data_mapel"=>$data_mapel, "id_mapel"=>$id_mapel)));
	}

	function mapel($id_mapel) {
		$id_guru = $this->m_banksoal->ambil_id_guru($this->session->id);
		$data_banksoal = $this->m_banksoal->ambil_data_banksoal($id_mapel);
		$data_mapel = $this->m_banksoal->ambil_data_materi($id_mapel);


		$this->load->view("template/template", array("isi"=>"banksoal/index", "data"=>array("data_banksoal"=>$data_banksoal, "data_mapel"=>$data_mapel, "id_guru"=>$id_guru, "id_mapel"=>$id_mapel)));
	}

	function jawaban($id_banksoal) {
		$id_guru = $this->m_banksoal->ambil_id_guru($this->session->id);
		$id_mapel = $this->m_banksoal->ambil_id_mapel_dari_banksoal($id_banksoal);
		$data_jawaban_banksoal = $this->m_banksoal->ambil_data_jawaban_banksoal($id_banksoal);

		$this->load->view("template/template", array("isi"=>"banksoal/jawaban", "data"=>array("data_jawaban_banksoal"=>$data_jawaban_banksoal, "id_guru"=>$id_guru, "id_mapel"=>$id_mapel, "id_banksoal"=>$id_banksoal)));
	}

	function tambah_soal($id_mapel) {
		$data_mapel = $this->m_banksoal->ambil_data_materi($id_mapel);

		$this->load->view("template/template", array("isi"=>"banksoal/tambah_soal", "data"=>array("id_mapel"=>$id_mapel, "data_mapel"=>$data_mapel)));
	}

	function tambah_jawaban($id_banksoal) {
		$this->load->view("template/template", array("isi"=>"banksoal/tambah_jawaban", "data"=>array("id_banksoal"=>$id_banksoal)));
	}

	function aksi_tambah_soal() {
		$id_mapel = $this->input->post('id_mapel');
		$soal = $this->input->post('soal');
		$jawaban1 = $this->input->post('jawaban1');
		$jawaban2 = $this->input->post('jawaban2');
		$jawaban3 = $this->input->post('jawaban3');
		$jawaban4 = $this->input->post('jawaban4');

		$this->m_banksoal->tambah_soal($id_mapel, $soal, $jawaban1, $jawaban2, $jawaban3, $jawaban4);

		sleep(1);

		redirect(base_url('banksoal/mapel/'.$id_mapel));
	}

	function aksi_tambah_jawaban() {
		$id_banksoal = $this->input->post('id_banksoal');
		$jawaban = $this->input->post('jawaban');

		$this->m_banksoal->tambah_jawaban($id_banksoal, $jawaban);

		redirect(base_url('banksoal/jawaban/'.$id_banksoal));
	}

	function ubah_soal($id_banksoal) {
		$id_guru = $this->m_banksoal->ambil_id_guru($this->session->id);
		$id_mapel = $this->m_banksoal->ambil_id_mapel_dari_banksoal($id_banksoal);
		$soal = $this->m_banksoal->ambil_data_banksoal_untuk_ubah($id_banksoal);
		$jawaban = $this->m_banksoal->ambil_data_jawaban_banksoal($id_banksoal);

		$this->load->view("template/template", array("isi"=>"banksoal/ubah_soal", "data"=>array("id_guru"=>$id_guru, "id_banksoal"=>$id_banksoal, "id_mapel"=>$id_mapel, "soal"=>$soal, "jawaban"=>$jawaban)));
	}

	function aksi_ubah_soal() {
		$soal = $this->input->post('soal');
		$id_mapel = $this->input->post('id_mapel');
		$id_banksoal = $this->input->post('id_banksoal');
		$jawaban1 = $this->input->post('jawaban1');
		$jawaban2 = $this->input->post('jawaban2');
		$jawaban3 = $this->input->post('jawaban3');
		$jawaban4 = $this->input->post('jawaban4');
		$id_jawaban1 = $this->input->post('id_jawaban1');
		$id_jawaban2 = $this->input->post('id_jawaban2');
		$id_jawaban3 = $this->input->post('id_jawaban3');
		$id_jawaban4 = $this->input->post('id_jawaban4');

		$this->m_banksoal->ubah_soal($id_banksoal, $soal, $id_jawaban1, $jawaban1, $id_jawaban2, $jawaban2, $id_jawaban3, $jawaban3, $id_jawaban4, $jawaban4);

		sleep(1);

		redirect(base_url('banksoal/mapel/'.$id_mapel));
	}

	function aksi_hapus_soal($id_mapel, $id_banksoal) {
		$this->m_banksoal->hapus_soal($id_banksoal);

		redirect(base_url('banksoal/mapel/'.$id_mapel));
	}

}
