<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>IMPORT BANKSOAL (<?php echo $data['data_mapel']->mapel; ?>)</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" enctype="multipart/form-data" id="form" role="form" method="post" action="<?php echo base_url('banksoal/aksi_impor'); ?>" >
    <div class="box-body">

    <div class="form-group">
          <a href="<?php echo base_url('berkas/template/banksoal.xls'); ?>" class="btn btn-info">Download template</a>
    </div>

    <input type="hidden" name="id_mapel" value="<?php echo $data['data_mapel']->id_mapel; ?>">

    <div class="form-group">
      <label for="excel">Excel (.xls)</label>
          <input type="file" class="form-control" id="excel" name="excel">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('banksoal/mapel/'.$data['id_mapel']); ?>" class="btn btn-info">Batal</a>
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
