<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH JAWABAN BANK SOAL</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('banksoal/aksi_tambah_jawaban'); ?>" >
    <div class="box-body">

      <input type="hidden" name="id_banksoal" value="<?php echo $data['id_banksoal']; ?>">

    <div class="form-group">
      <label for="jawaban">Jawaban</label>
          <input type="text" class="form-control" id="jawaban" placeholder="Isi Jawaban" name="jawaban">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('banksoal/jawaban/'.$data['id_banksoal']); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">

$('#form').submit(function() 
{
    if ($.trim($("#jawaban").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

</script>