<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH ANGKATAN</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('angkatan/aksi_tambah'); ?>" >
    <div class="box-body">

    <div class="form-group">
      <label for="angkatan">Angkatan</label>
          <input type="text" class="form-control" id="angkatan" placeholder="Isi Angkatan" name="angkatan">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('angkatan'); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">

$('#form').submit(function() 
{
    if ($.trim($("#angkatan").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

</script>