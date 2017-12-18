<script>
// Set the date we're counting down to
// var countDownDate = new Date("<?php echo date('M j, Y H:i:s', $data['data_ujian']->unix_waktu_ujian); ?>").getTime();
var countDownDate = new Date("<?php echo date('M j, Y H:i:s', $data['data_ujian']->unix_deadline); ?>").getTime();
// var countDownDate = new Date("<?php echo date('l'); ?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date();

    // Find the distance between now an the count down date
    var distance =  countDownDate - now;
    // var distance =  now - countDownDate;
    
    // Time calculations for days, hours, minutes and seconds
    //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    // document.getElementById("demo").innerHTML =  hours + " Jam "
    // + minutes + " Menit " + seconds + " Detik ";
    
    document.getElementById("demo").innerHTML = hours + " Jam "
    + minutes + " Menit " + seconds + " Detik ";
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        window.location = "<?php echo base_url('kelas_siswa/kumpul_ujian/'.$data['status_ujian']."?time=up"); ?>";
    }
}, 1000);
</script>
<center><p id="demo">.</p></center>
<?php
 if ($this->input->get('selesai') == 1) {
 	// $this->load->view("kelas_siswa/selesai");
 	?>
 	Ujian akan dikumpulkan dan tidak dapat diubah lagi.
 	<br>
	<a href="<?php echo base_url("kelas_siswa/ujian/".$id_kelas) ?>">Kembali</a> 
	<a onclick="kumpul()">Kumpulkan</a>
	<script type="text/javascript">
	function kumpul() {
	  if (confirm("Koreksi kembali soal yang telah dikerjakan !!!\nApakah anda yakin untuk mengumpulkan ?")) {
	    window.location = "<?php echo base_url('kelas_siswa/kumpul_ujian/'.$data['status_ujian']); ?>";
	  }
	}
	</script>

	<?php
 	return;
 } elseif ($this->input->get('no') == null) {
 	redirect(base_url("kelas_siswa/ujian/".$id_kelas."?no=1"));
 }
?>
<form method="post" action="<?php echo base_url("kelas_siswa/aksi_input_jawaban"); ?>">
	<input type="hidden" name="id_kelas" value="<?php echo $id_kelas; ?>">
	<input type="hidden" name="no" value="<?php echo $this->input->get('no'); ?>">
	<input type="hidden" name="id_soal" value="<?php echo $data['soal_ujian'][$this->input->get('no')-1]->id_ujian_banksoal; ?>">
<?php

	echo $this->input->get('no') . ".) " . $data['soal_ujian'][$this->input->get('no')-1]->soal;
	foreach ($this->m_kelas_siswa->ambil_jawaban_dari_soal($data['soal_ujian'][$this->input->get('no')-1]->id_banksoal) as $item) {
	?>
	<br>
	<?php
	if ($this->m_kelas_siswa->ambil_jawaban($data['soal_ujian'][$this->input->get('no')-1]->id_ujian_banksoal) == $item->id ) {
		?>
			<input type="radio" name="<?php echo $data['soal_ujian'][$this->input->get('no')-1]->id_ujian_banksoal ?>" value="<?php echo $item->id; ?>" checked> <?php echo  $item->jawaban; ?> 
		<?php
	} else {
		?>
			<input type="radio" name="<?php echo $data['soal_ujian'][$this->input->get('no')-1]->id_ujian_banksoal ?>" value="<?php echo $item->id; ?>"> <?php echo  $item->jawaban; ?> 
		<?php
	}
	?>
	<?php
	}
	?>
<br>
<input type="submit" name="simpan" value="Simpan">
</form>

<br>
<?php
for ($i=1; $i <= 10; $i++) { 
	if ($this->m_kelas_siswa->ambil_jawaban($data['soal_ujian'][$i-1]->id_ujian_banksoal) == null) {
		$no[$i] = '<a style="color: black" href="' . base_url("kelas_siswa/ujian/".$data['id_kelas']."?no=".$i) . '">'.$i.'</a>';		
	} else {
		$no[$i] = '<a style="color: green" href="' . base_url("kelas_siswa/ujian/".$data['id_kelas']."?no=".$i) . '">'.$i.'</a>';
	}
	if ($this->input->get('no') == 1) {
		$kembali = $this->input->get('no');	
	} else {
		$kembali = $this->input->get('no') - 1;	
	}
	$kembali = '<a style="color: black" href="' . base_url("kelas_siswa/ujian/".$data['id_kelas']."?no=".$kembali) . '"><</a>';
	$lanjut = $this->input->get('no') + 1;
	if ($this->input->get('no') == 10) {
		$lanjut = '<a style="color: black" onclick="konfirmasi()">></a>';
	} else {
		$lanjut = '<a style="color: black" href="' . base_url("kelas_siswa/ujian/".$data['id_kelas']."?no=".$lanjut) . '">></a>';
	}
}
echo $no['1'] . ' | ' . $no['2'] . ' | ' . $no['3'];
echo "<br>";
echo $no['4'] . ' | ' . $no['5'] . ' | ' . $no['6'];
echo "<br>";
echo $no['7'] . ' | ' . $no['8'] . ' | ' . $no['9'];
echo "<br>";
echo $kembali . ' | ' . $no['10'] . ' | ' . $lanjut;
echo "<br>";
echo '<a style="color: black" onclick="konfirmasi()">Selesai</a>';
?>

<script type="text/javascript">
function konfirmasi(id_kelas, id_siswa) {
  if (confirm("Koreksi kembali soal yang telah dikerjakan !!!\nApakah anda yakin untuk mengumpulkan ?")) {
    window.location = "<?php echo base_url('kelas_siswa/ujian/'.$data['id_kelas'].'?selesai=1'); ?>";
  }
}
</script>


