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
    <h4><strong><font color=blue>DATA JAWABAN BANK SOAL</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
      <a href='<?php echo base_url("banksoal/tambah_jawaban/".$data['id_banksoal']); ?>'><button class="btn btn-success">+ Tambah Bank Soal</button></a>
      <br>
      <a href="<?php echo base_url('banksoal/mapel/'.$data['id_mapel']); ?>" class="btn btn-info">Kembali</a>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>JAWABAN</th>
                    <th>STATUS</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data['data_jawaban_banksoal'] as $item) {
          ?>
          <tr>
            <th><?php echo $i; ?></th>
            <th><?php echo $item->jawaban; ?></th>
            <th><?php echo $item->status == 1 ? "Benar" : "Salah"; ?></th>
              <th><a href="<?php echo base_url('banksoal/ubah_jawaban/'.$item->id_jawaban_banksoal) ?>">Ubah</a> <a href="<?php echo base_url('banksoal/hapus_jawaban/'.$item->id_jawaban_banksoal) ?>">Hapus</a></th>
          </tr>
          <?php
          $i++;
        }
        ?>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->