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
    <h4><strong><font color=blue>DATA MATERI</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
      <a href='<?php echo base_url("materi/tambah"); ?>'><button class="btn btn-success">+ Tambah Materi</button></a>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>MATERI</th>
                    <th>SEMESTER</th>
                    <th>GURU</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data['data_materi'] as $item) {
          ?>
          <tr>
            <th><?php echo $i; ?></th>
            <th><?php echo $item->mapel; ?></th>
            <th><?php echo $item->semester; ?></th>
            <th><?php echo $item->nama_guru; ?></th>
              <th><a href="<?php echo base_url('materi/lihat/'.$item->id_mapel) ?>">Lihat</a> <a href="<?php echo base_url('banksoal/mapel/'.$item->id_mapel) ?>">Bank Soal</a></th>
          </tr>
          <?php
          $i++;
        }
        ?>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->