<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH BANK SOAL (<?php echo $data['data_mapel']->mapel; ?>)</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('banksoal/aksi_tambah_soal'); ?>" >
    <div class="box-body">

      <input type="hidden" name="id_mapel" value="<?php echo $data['id_mapel']; ?>">

    <div class="form-group">
      <label for="soal">Soal</label>
          <input type="text" class="form-control" id="soal" placeholder="Isi Soal" name="soal">          
    </div>

    <div class="form-group">
      <label for="jawaban1">Jawaban 1 (Benar)</label>
          <input type="text" class="form-control" id="jawaban1" placeholder="Isi Jawaban 1 (Benar)" name="jawaban1">          
    </div>

    <div class="form-group">
      <label for="jawaban2">Jawaban 2 (Salah)</label>
          <input type="text" class="form-control" id="jawaban2" placeholder="Isi Jawaban 2 (Salah)" name="jawaban2">          
    </div>

    <div class="form-group">
      <label for="jawaban3">Jawaban 3 (Salah)</label>
          <input type="text" class="form-control" id="jawaban3" placeholder="Isi Jawaban 3 (Salah)" name="jawaban3">          
    </div>

    <div class="form-group">
      <label for="jawaban4">Jawaban 4 (Salah)</label>
          <input type="text" class="form-control" id="jawaban4" placeholder="Isi Jawaban 4 (Salah)" name="jawaban4">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('banksoal/mapel/'.$data['id_mapel']); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">

$('#form').submit(function() 
{
    if ($.trim($("#soal").val()) === "" || $.trim($("#jawaban1").val()) === "" || $.trim($("#jawaban2").val()) === "" || $.trim($("#jawaban3").val()) === "" || $.trim($("#jawaban4").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

</script>