<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH KELAS</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('kelas/aksi_tambah'); ?>">
    <div class="box-body">

      <input type="hidden" name="id_guru" value="<?php echo $data['id_guru']; ?>">

    <div class="form-group">
      <label for="angkatan">Angkatan</label>
          <select name="angkatan" class="form-control select2">
            <?php 
            foreach ($data['data_angkatan'] as $item) {
              ?>
            <option value="<?php echo $item->id; ?>"><?php echo $item->angkatan; ?></option>
              <?php
            }
            ?>
          </select>          
    </div>

    <div class="form-group">
      <label for="materi">Materi</label>
          <select name="materi" class="form-control select2">
            <?php 
            foreach ($data['data_mapel'] as $item) {
              ?>
            <option value="<?php echo $item->id; ?>"><?php echo "Semester " . $item->semester . " - " . $item->mata_pelajaran; ?></option>
              <?php
            }
            ?>
          </select>          
    </div>

    <div class="form-group">
      <label for="kelas">Kelas</label>
          <input type="text" class="form-control" id="kelas" placeholder="Isi Kelas" name="kelas">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('kelas'); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">

$('#form').submit(function() 
{
    if ($.trim($("#kelas").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});


$('.select2').select2();

</script>

