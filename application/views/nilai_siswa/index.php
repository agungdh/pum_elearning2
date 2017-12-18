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
    <h4><strong><font color=blue>NILAI SISWA</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>KELAS</th>
                    <th>MATERI</th>
                    <th>SEMESTER</th>
                    <th>WAKTU UJIAN</th>
                    <th>NILAI</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data['data_nilai'] as $item) {
          ?>
          <tr>
            <th><?php echo $i; ?></th>
            <th><?php echo $item->kelas; ?></th>
            <th><?php echo $item->mata_pelajaran; ?></th>
            <th><?php echo $item->semester; ?></th>
            <th><?php echo $item->waktu_ujian; ?></th>
            <th><?php echo $item->nilai; ?></th>
          </tr>
          <?php
          $i++;
        }
        ?>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->