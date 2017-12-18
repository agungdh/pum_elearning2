<script type="text/javascript" language="javascript" >
  var dTable;
  $(document).ready(function() {
    dTable = $('#lookup').DataTable({
      responsive: true
    });
  });
</script>

<script type="text/javascript" language="javascript" >
  var dTable;
  $(document).ready(function() {
    dTable = $('#lookup2').DataTable({
      responsive: true
    });
  });
</script>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>DATA KELAS (AKTIF)</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
      <a href='<?php echo base_url("kelas/tambah"); ?>'><button class="btn btn-success">+ Tambah Kelas</button></a>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>ANGKATAN</th>
                    <th>SEMESTER</th>
                    <th>MATA PELAJARAN</th>
                    <th>KELAS</th>
                    <th>JUMLAH SISWA</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data['data_kelas_aktif'] as $item) {
          ?>
          <tr>
            <th><?php echo $i; ?></th>
            <th><?php echo $item->angkatan ?></th>
            <th><?php echo $item->semester; ?></th>
            <th><a target="_blank" href="<?php echo base_url('materi/lihat/'.$item->id_mapel); ?>"><?php echo $item->mata_pelajaran; ?></a></th>
            <th><?php echo $item->nama_kelas; ?></th>
            <th><?php echo $this->m_kelas->cek_jumlah_siswa($item->id_kelas); ?></th>
              <th><a href="<?php echo base_url('kelas/lihat_siswa/'.$item->id_kelas) ?>">Lihat Siswa</a> <a href="<?php echo base_url('kelas/lihat_nilai_siswa/'.$item->id_kelas) ?>">Lihat Nilai Siswa</a> <a href="<?php echo base_url('kelas/ubah_status/'.$item->id_kelas) ?>">Ubah Status</a> <a onclick="konfirmasi(<?php echo $item->id_kelas; ?>)">Hapus</a> </th>
          </tr>
          <?php
          $i++;
        }
        ?>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->


<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>DATA KELAS (SELESAI)</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <table id="lookup2" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>ANGKATAN</th>
                    <th>SEMESTER</th>
                    <th>MATA PELAJARAN</th>
                    <th>KELAS</th>
                    <th>JUMLAH SISWA</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data['data_kelas_selesai'] as $item) {
          ?>
          <tr>
            <th><?php echo $i; ?></th>
            <th><?php echo $item->angkatan ?></th>
            <th><?php echo $item->semester; ?></th>
            <th><a target="_blank" href="<?php echo base_url('materi/lihat/'.$item->id_mapel); ?>"><?php echo $item->mata_pelajaran; ?></a></th>
            <th><?php echo $item->nama_kelas; ?></th>
            <th><?php echo $this->m_kelas->cek_jumlah_siswa($item->id_kelas); ?></th>
              <th><a href="<?php echo base_url('kelas/lihat_siswa/'.$item->id_kelas) ?>">Lihat Siswa</a> <a href="<?php echo base_url('kelas/lihat_nilai_siswa/'.$item->id_kelas) ?>">Lihat Nilai Siswa</a> <a href="<?php echo base_url('kelas/ubah_status/'.$item->id_kelas) ?>">Ubah Status</a> <a onclick="konfirmasi(<?php echo $item->id_kelas; ?>)">Hapus</a></th>
          </tr>
          <?php
          $i++;
        }
        ?>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->

<script type="text/javascript">
function konfirmasi(id) {
  if (confirm("Yakin hapus ?")) {
    window.location = "<?php echo base_url('kelas/hapus_kelas/'); ?>" + id;
  }
}
</script>
