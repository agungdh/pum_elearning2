<script type="text/javascript" language="javascript" >
  var dTable;
  $(document).ready(function() {
    dTable = $('#lookup').DataTable({
      responsive: true
    });
  });
</script>

<script type="text/javascript" language="javascript" >
  var dTable;
  $(document).ready(function() {
    dTable = $('#lookup2').DataTable({
      responsive: true
    });
  });
</script>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>DATA KELAS (AKTIF)</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

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
              <th><a href="<?php echo base_url('kelas_siswa/ujian/'.$item->id_kelas) ?>">Ujian</a></th>
          </tr>
          <?php
          $i++;
        }
        ?>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->


<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>DATA KELAS (SELESAI)</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <table id="lookup2" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>SEMESTER</th>
                    <th>MATA PELAJARAN</th>
                    <th>KELAS</th>
                    <th>GURU</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data['data_kelas_selesai'] as $item) {
          ?>
          <tr>
            <th><?php echo $i; ?></th>
            <th><?php echo $item->semester; ?></th>
            <th><a target="_blank" href="<?php echo base_url('materi/lihat/'.$item->id_mapel); ?>"><?php echo $item->mata_pelajaran; ?></a></th>
            <th><?php echo $item->kelas; ?></th>
            <th><?php echo $item->nama_guru; ?></th>
          </tr>
          <?php
          $i++;
        }
        ?>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->