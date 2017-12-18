<?php
?>

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
    <h4><strong><font color=blue>DATA ANGKATAN</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
      <a href='<?php echo base_url("angkatan/tambah"); ?>'><button class="btn btn-success">+ Tambah Angkatan</button></a>
      <br>
      <a href='<?php echo base_url("angkatan/impor"); ?>'><button class="btn btn-success">+ Impor Angkatan</button></a>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>ANGKATAN</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data as $item) {
          ?>
          <tr>
            <th><?php echo $i; ?></th>
            <th><?php echo $item->angkatan; ?></th>
            <th><a href="<?php echo base_url('angkatan/ubah/'.$item->id) ?>">Ubah</a> <a onclick="konfirmasi(<?php echo $item->id; ?>)">Hapus</a></th>
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
function konfirmasi(id_angkatan) {
  if (confirm("Yakin hapus ?")) {
    window.location = "<?php echo base_url('angkatan/aksi_hapus/'); ?>" + id_angkatan;
  }
}
</script>
