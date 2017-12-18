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
    <h4><strong><font color=blue>DATA NILAI SISWA (<?php echo $data['data_kelas']->nama_kelas; ?> : <?php echo $data['data_kelas']->mata_pelajaran; ?>)</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
      <a href='<?php echo base_url("kelas"); ?>'><button class="btn btn-success">Kembali</button></a>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>NAMA</th>
                    <th>NIS</th>
                    <th>WAKTU UJIAN</th>
                    <th>NILAI</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data['data_nilai_siswa'] as $item) {
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $item->nama ?></td>
            <td><?php echo $item->nis ?></td>
            <td><?php echo $item->waktu_ujian ?></td>
            <td><?php echo $item->nilai ?></td>
          </tr>
          <?php
          $i++;
        }
        ?>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->

<script type="text/javascript">
function konfirmasi(id) {
  if (confirm("Yakin hapus ?")) {
    window.location = "<?php echo base_url('kelas/hapus_kelas/'); ?>" + id;
  }
}
</script>
