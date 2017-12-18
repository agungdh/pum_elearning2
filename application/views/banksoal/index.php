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
    <h4><strong><font color=blue>DATA BANK SOAL (<?php echo $data['data_mapel']->mapel; ?>)</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
      <a href='<?php echo base_url("banksoal/tambah_soal/".$data['id_mapel']); ?>'><button class="btn btn-success">+ Tambah Bank Soal</button></a>
      <br>
      <a href='<?php echo base_url("banksoal/impor/".$data['id_mapel']); ?>'><button class="btn btn-success">+ Impor Bank Soal</button></a>
      <br>
      <a href="<?php echo base_url('materi'); ?>" class="btn btn-info">Kembali</a>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>SOAL</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data['data_banksoal'] as $item) {
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td>
              <b><?php echo $item->soal; ?></b>
              <?php
              $j=1;
                foreach ($this->m_banksoal->ambil_data_jawaban_banksoal($item->id_banksoal) as $jawaban) {
                  $data_jawaban[] = $jawaban->jawaban;
                  ?>
                    <br>
                  <?php
                  if ($j == 1) {
                    ?>
                    <?php echo "<b>" . $j . ".) " . $jawaban->jawaban . "</b>"; ?>
                    <?php
                  } else {
                    ?>
                    <?php echo $j . ".) " . $jawaban->jawaban; ?>
                    <?php
                  }
                  ?>
                  <?php
                  $j++;
                }
              ?>
            </td>
              <td><a href="<?php echo base_url('banksoal/ubah_soal/'.$item->id_banksoal) ?>">Ubah</a> <a onclick="konfirmasi(<?php echo $item->id_banksoal; ?>)">Hapus</a></td>
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
function konfirmasi(id_banksoal) {
  if (confirm("Yakin hapus ?")) {
    window.location = "<?php echo base_url('banksoal/aksi_hapus_soal/'.$data['id_mapel'].'/'); ?>" + id_banksoal;
  }
}
</script>
