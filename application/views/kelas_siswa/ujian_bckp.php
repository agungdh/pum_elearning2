<script type="text/javascript" language="javascript" >
  var dTable;
  $(document).ready(function() {
    dTable = $('#lookup').DataTable({
      responsive: true
    });
  });
</script>

<p id="demo"></p>

<?php 
// echo $data['jumlah_ujian'];
// echo date('M j, Y H:i:s', "+ 1 days");


$date = new DateTime(date('Y-m-d H:i:s',$data['data_ujian']->unix_deadline));
// echo "test = " . date('Y-m-d H:i:s','1512320282331');
 // test = 1985-08-02 04:20:08
echo "<br>";
// echo date('Y-m-d H:i:s',$data['data_ujian']->unix_deadline);
echo date('M j, Y H:i:s', $data['data_ujian']->unix_waktu_ujian);
echo "<br>";
echo date('M j, Y H:i:s', $data['data_ujian']->unix_deadline);
// echo "Dec 3, 2017 14:44:25";
// echo $date->format('Y-m-d H:i:s') . "<br>";
// $date->modify('+2 hour');
// echo $date->format('Y-m-d H:i:s') . "<br>";

?>
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
        document.getElementById("demo").innerHTML = "End!!!";
    }
}, 1000);
</script>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>UJIAN (<?php echo $data['data_kelas']->nama_kelas; ?> : <?php echo $data['data_kelas']->mata_pelajaran; ?>)</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

      <?php
        if ($data['jumlah_ujian'] == 0) {
          ?>

        <h3>Anda belum mengikuti ujian sama sekali</h3>
        <h3><a onclick="konfirmasi(<?php echo $data['id_kelas']; ?>)">Ujian</a></h3>

          <?php
        } else {
      ?>
    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>SEMESTER</th>
                    <th>MATA PELAJARAN</th>
                    <th>KELAS</th>
                    <th>GURU</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data['data_kelas_aktif'] as $item) {
          ?>
          <tr>
            <th><?php echo $i; ?></th>
            <th><?php echo $item->semester; ?></th>
            <th><a target="_blank" href="<?php echo base_url('materi/lihat/'.$item->id_mapel); ?>"><?php echo $item->mata_pelajaran; ?></a></th>
            <th><?php echo $item->kelas; ?></th>
            <th><?php echo $item->nama_guru; ?></th>
              <th>blm</th>
          </tr>
          <?php
          $i++;
        }
        ?>
      </tbody>
      
    </table>
    <?php 
    } 
    ?>
  </div><!-- /.boxbody -->
</div><!-- /.box -->

<script type="text/javascript">
function konfirmasi(id_kelas) {
  if (confirm("Yakin hapus ?")) {
    window.location = "<?php echo base_url('kelas_siswa/ujian/') ?>" + id_kelas;
  }
}
</script>
