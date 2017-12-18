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
    <h4><strong><font color=blue>DATA KELAS (SISWA)</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
      <a href='<?php echo base_url("kelas/tambah_siswa/".$id_kelas); ?>'><button class="btn btn-success">+ Tambah Siswa</button></a>
      <br>
      <a href='<?php echo base_url("kelas/"); ?>'><button class="btn btn-primary">Kembali</button></a>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>NIS</th>
                    <th>NAMA</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data['data_siswa'] as $item) {
          ?>
          <tr>
            <th><?php echo $i; ?></th>
            <th><?php echo $item->nis ?></th>
            <th><?php echo $item->nama; ?></th>
            <th><a onclick="konfirmasi(<?php echo $item->id_detil_kelas; ?>)">Hapus</a></th>
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
    window.location = "<?php echo base_url('kelas/hapus_siswa/'.$item->id_kelas.'/'); ?>" + id;
  }
}
</script>