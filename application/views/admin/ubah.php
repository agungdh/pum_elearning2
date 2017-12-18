<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>UBAH ADMIN</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('admin/aksi_ubah'); ?>" >
    <div class="box-body">

      <input type="hidden" name="id" value="<?php echo $data->id_admin; ?>">

    <div class="form-group">
      <label for="username">Username</label>
          <input readonly value="<?php echo $data->username; ?>" type="text" class="form-control" id="username" placeholder="Isi Username" name="username">          
    </div>

    <div class="form-group">
      <label for="nama">Nama</label>
          <input value="<?php echo $data->nama; ?>" type="text" class="form-control" id="nama" placeholder="Isi Nama" name="nama">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('admin'); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">

$('#form').submit(function() 
{
    if ($.trim($("#username").val()) === "" || $.trim($("#nama").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

</script>