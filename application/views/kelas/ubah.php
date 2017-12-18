<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>UPDATE MATERI</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('materi/aksi_ubah'); ?>" enctype="multipart/form-data">
    <div class="box-body">

      <input type="hidden" name="id_mapel" value="<?php echo $data['id']; ?>">

    <div class="form-group">
      <label for="file">File PDF</label>
          <input type="file" class="form-control" id="file" placeholder="Isi File" name="file">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('materi/lihat/'.$data['id']); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

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
