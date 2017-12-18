<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>UBAH BANK SOAL</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('banksoal/aksi_ubah_soal'); ?>" >
    <div class="box-body">

      <?php 
      $i=1;
        foreach ($data['jawaban'] as $jawaban) { 
          $array_jawaban[$i] = $jawaban->jawaban;
          ?>
            <input type="hidden" name="id_jawaban<?php echo $i; ?>" value="<?php echo $jawaban->id_jawaban_banksoal; ?>">
          <?php
          $i++;
        }
      ?>

      <input type="hidden" name="id_banksoal" value="<?php echo $data['id_banksoal']; ?>">
      <input type="hidden" name="id_mapel" value="<?php echo $data['id_mapel']; ?>">

    <div class="form-group">
      <label for="soal">Soal</label>
          <input type="text" class="form-control" id="soal" placeholder="Isi Soal" name="soal" value="<?php echo $data['soal']->soal; ?>">          
    </div>

    <div class="form-group">
      <label for="jawaban1">Jawaban 1 (Benar)</label>
          <input type="text" class="form-control" id="jawaban1" placeholder="Isi Jawaban 1 (Benar)" name="jawaban1" value="<?php echo $array_jawaban[1]; ?>">          
    </div>

    <div class="form-group">
      <label for="jawaban2">Jawaban 2 (Salah)</label>
          <input type="text" class="form-control" id="jawaban2" placeholder="Isi Jawaban 2 (Salah)" name="jawaban2" value="<?php echo $array_jawaban[2]; ?>">          
    </div>

    <div class="form-group">
      <label for="jawaban3">Jawaban 3 (Salah)</label>
          <input type="text" class="form-control" id="jawaban3" placeholder="Isi Jawaban 3 (Salah)" name="jawaban3" value="<?php echo $array_jawaban[3]; ?>">          
    </div>

    <div class="form-group">
      <label for="jawaban4">Jawaban 4 (Salah)</label>
          <input type="text" class="form-control" id="jawaban4" placeholder="Isi Jawaban 4 (Salah)" name="jawaban4" value="<?php echo $array_jawaban[4]; ?>">          
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
    if ($.trim($("#soal").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

</script>