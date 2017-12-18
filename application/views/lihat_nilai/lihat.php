<a href="<?php echo base_url("lihat_nilai/export/".$this->input->post('nis')); ?>">Export PDF</a>
<br>
<br>

NIS : <?php echo $data_siswa->nis; ?><br>
Nama : <?php echo $data_siswa->nama; ?><br>

<table id="lookup" border="1" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NO</th>
                    <th>KELAS</th>
                    <th>MATERI</th>
                    <th>SEMESTER</th>
                    <th>WAKTU UJIAN</th>
                    <th>NILAI</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i=1;
        foreach ($data_nilai as $item) {
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $item->kelas; ?></td>
            <td><?php echo $item->mata_pelajaran; ?></td>
            <td><?php echo $item->semester; ?></td>
            <td><?php echo $item->waktu_ujian; ?></td>
            <td><?php echo $item->nilai; ?></td>
          </tr>
          <?php
          $i++;
        }
        ?>
      </tbody>
</table>