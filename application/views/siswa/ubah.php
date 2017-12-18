<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>UBAH SISWA</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('siswa/aksi_ubah'); ?>" >
    <div class="box-body">

      <input type="hidden" name="id" value="<?php echo $data['siswa']->id_siswa; ?>">

    <div class="form-group">
      <label for="nis">NIS</label>
          <input readonly value="<?php echo $data['siswa']->nis; ?>" type="text" class="form-control" id="nis" placeholder="Isi NIS" name="nis">          
    </div>

    <div class="form-group">
      <label for="nama">Nama</label>
          <input value="<?php echo $data['siswa']->nama; ?>" type="text" class="form-control" id="nama" placeholder="Isi Nama" name="nama">          
    </div>

    <div class="form-group">
      <label for="angkatan">Angkatan</label>
          <select name="angkatan" class="form-control select2">
                  <?php
                  foreach ($data['angkatan'] as $item) {
                    ?>
                    <?php
                    if ($data['siswa']->id_angkatan == $item->id) {
                      ?>
                      <option value="<?php echo $item->id; ?>" selected><?php echo $item->angkatan; ?></option>
                      <?php
                    } else {
                    ?>
                      <option value="<?php echo $item->id; ?>" ><?php echo $item->angkatan; ?></option>
                    <?php
                    }
                  }
                  ?>
          </select>
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('siswa'); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">

$('#form').submit(function() 
{
    if ($.trim($("#nis").val()) === "" || $.trim($("#nama").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

$('.select2').select2();

</script>