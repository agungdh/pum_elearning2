<script type="text/javascript" language="javascript" >
  var dTable;
  $(document).ready(function() {
    dTable = $('#lookup').DataTable({
      responsive: true
    });
  });
</script>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>UJIAN (<?php echo $data['data_kelas']->nama_kelas; ?> : <?php echo $data['data_kelas']->mata_pelajaran; ?>)</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
      <?php
        if ($data['jumlah_ujian'] == 0) {
          ?>

        <h3>Anda belum mengikuti ujian sama sekali</h3>
        <h3><a onclick="konfirmasi(<?php echo $data['id_kelas']; ?>, <?php echo $data['id_siswa']; ?>)">Ujian</a></h3>
      <a href='<?php echo base_url("kelas_siswa"); ?>'><button class="btn btn-success">Kembali</button></a>
    </div>

          <?php
        } else {
      ?>
  <div class="form-group">
      <a href='<?php echo base_url("kelas_siswa"); ?>'><button class="btn btn-success">Kembali</button></a>
  </div>
    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>WAKTU</th>
                    <th>NILAI</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data['tabel_ujian'] as $item) {
          ?>
          <tr>
            <th><?php echo $i; ?></th>
            <th><?php echo $item->waktu_ujian; ?></th>
            <th><?php echo $item->nilai; ?></th>
          </tr>
          <?php
          $i++;
        }
        ?>
      </tbody>
      
    </table>
    <?php 
    if ($this->input->get("time") == "up") {
            ?>
            <script type="text/javascript">
              alert("Waktu habis !!!");
            </script>
            <?php
          }
    } 
    ?>
  </div><!-- /.boxbody -->
</div><!-- /.box -->

<script type="text/javascript">
function konfirmasi(id_kelas, id_siswa) {
  if (confirm("Apakah anda yakin ?")) {
    window.location = "<?php echo base_url('kelas_siswa/aksi_ujian/') ?>" + id_kelas + "/" + id_siswa;
  }
}
</script>
