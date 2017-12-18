<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH MATERI</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('materi/aksi_tambah'); ?>" enctype="multipart/form-data">
    <div class="box-body">

      <input type="hidden" name="id_guru" value="<?php echo $data; ?>">

    <div class="form-group">
      <label for="materi">Materi</label>
          <input type="text" class="form-control" id="materi" placeholder="Isi Materi" name="materi">          
    </div>

    <div class="form-group">
      <label for="semester">Semester</label>
          <!-- <input type="number" min="1" max="6" class="form-control" id="semester" placeholder="Isi Semester" name="semester">           -->
          <select name="semester" class="form-control" id="semester">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
    </div>

    <div class="form-group">
      <label for="file">File PDF</label>
          <input type="file" class="form-control" id="file" placeholder="Isi File" name="file">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('materi'); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">

$('#form').submit(function() 
{
    if ($.trim($("#semester").val()) === "" || $.trim($("#materi").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

</script>

<?php 
if ($this->input->get('file_kosong') == 1) {
  ?>
  <script type="text/javascript">
    alert('File kosong !!!');
  </script>
  <?php
}
?>

<?php 
if ($this->input->get('upload_gagal') == 1) {
  ?>
  <script type="text/javascript">
    alert('Upload gagal !!!');
  </script>
  <?php
}
?>

<?php 
if ($this->input->get('file_kebesaran') == 1) {
  ?>
  <script type="text/javascript">
    alert('Ukuran file terlalu besar !!!');
  </script>
  <?php
}
?>

<?php 
if ($this->input->get('ekstensi_salah') == 1) {
  ?>
  <script type="text/javascript">
    alert('Ekstensi file salah !!!');
  </script>
  <?php
}
?>
