<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue><?php echo $data['materi']->mapel; ?></font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
          <?php
          if ($this->session->level == 1) {
          ?>
          <a href="<?php echo base_url('kelas_siswa'); ?>" class="btn btn-info">Kembali</a>
          <?php
          } elseif ($this->session->level == 2) {
          ?>
          <a href="<?php echo base_url('materi'); ?>" class="btn btn-info">Kembali</a>
          <?php
          }
          ?>
          <?php
          if ($data['materi']->id_guru == $data['id_guru']) {
          ?>
          <a href="<?php echo base_url('materi/ubah/'.$data["materi"]->id_mapel) ?>" class="btn btn-info">Update</a>
          <!-- <a href="<?php echo base_url('materi/hapus/'.$data["materi"]->id_mapel) ?>" class="btn btn-info" >Hapus</a> -->
          <button onclick="konfirmasi()" class="btn btn-info">Hapus</button>
          <?php
          }
          ?>
          <br>
          <object data="<?php echo base_url('berkas/materi/'.$data["id"].'.pdf'); ?>" type="application/pdf" width="100%" height="500">  
    </div>

    </div><!-- /.box-body -->

</div><!-- /.box -->

<script type="text/javascript">
function konfirmasi() {
  if (confirm("Yakin hapus ?")) {
    window.location = "<?php echo base_url('materi/aksi_hapus/'.$data['id']); ?>";
  }
}
</script>
