<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH KELAS</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('kelas/aksi_tambah_siswa'); ?>">
    <div class="box-body">

    <input type="hidden" name="id_kelas" value="<?php echo $data['id_kelas']; ?>">

    <div class="form-group">
      <label for="siswa">Siswa</label>
          <select multiple class="form-control" id="siswa" name="siswa[]">
            <?php
              foreach ($data['data_siswa'] as $item) {
                ?>
                <!-- <option value="<?php echo $item->id; ?>"><?php echo $item->nama; ?></option> -->
                <option value="<?php echo $item->id; ?>"><?php echo $item->nama; ?></option>
                <?php
              }
            ?>
          </select>
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('kelas/lihat_siswa/'.$data['id_kelas']); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">

$('#form').submit(function() 
{
    if ($.trim($("#siswa").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

$('.select2').select2();

</script>

