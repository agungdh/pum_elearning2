<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>UBAH ANGKATAN</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="form" id="form" action="<?php echo base_url('angkatan/aksi_ubah'); ?>">
    <div class="box-body">

      <input type="hidden" name="id" value="<?php echo $data->id; ?>">

    <div class="form-group">
      <label for="angkatan">Angkatan</label>
          <input type="text" class="form-control" id="angkatan" placeholder="Isi Angkatan" name="angkatan" value="<?php echo $data->angkatan; ?>">          
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