<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assessment</i>
            </div>
            <h4 class="card-title">Status Jam Kerja</h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" action="<?= base_url('jamkerja/status'); ?>" method="post">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group has-default">
                    <select class="selectpicker" name="tahun" id="tahun" data-style="select-with-transition" title="Pilih tahun" data-size="3" required>
                      <?php for ($y = date('Y')-3; $y <= date('Y'); $y++) { ?>
                          <option value="<?= $y; ?>" <?php echo ($tahun == $y) ? 'selected' : ''; ?>><?= $y; ?></option>
                      <?php };?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group has-default">
                    <select class="selectpicker" name="bulan" id="bulan" data-style="select-with-transition" title="Pilih Bulan" data-size="7" required>
                      <option value="01"<?php echo ($bulan == '01') ? 'selected' : ''; ?>>Januari</option>
                      <option value="02"<?php echo ($bulan == '02') ? 'selected' : ''; ?>>Februari</option>
                      <option value="03"<?php echo ($bulan == '03') ? 'selected' : ''; ?>>Maret</option>
                      <option value="04"<?php echo ($bulan == '04') ? 'selected' : ''; ?>>April</option>
                      <option value="05"<?php echo ($bulan == '05') ? 'selected' : ''; ?>>Mei</option>
                      <option value="06"<?php echo ($bulan == '06') ? 'selected' : ''; ?>>Juni</option>
                      <option value="07"<?php echo ($bulan == '07') ? 'selected' : ''; ?>>Juli</option>
                      <option value="08"<?php echo ($bulan == '08') ? 'selected' : ''; ?>>Agustus</option>
                      <option value="09"<?php echo ($bulan == '09') ? 'selected' : ''; ?>>September</option>
                      <option value="10"<?php echo ($bulan == '10') ? 'selected' : ''; ?>>Oktober</option>
                      <option value="11"<?php echo ($bulan == '11') ? 'selected' : ''; ?>>November</option>
                      <option value="12"<?php echo ($bulan == '12') ? 'selected' : ''; ?>>Desember</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group has-default">
                    <select class="selectpicker" name="tgl1" id="tgl1" data-style="select-with-transition" title="Pilih tanggal" data-size="7" required>
                    <?php 
                      for ($i=1; $i <= cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); $i++) {
                        echo '<option value="' . $i . '"';
                          if ($i == $tgl1) {
                              echo 'selected';
                          }
                          echo '>' . $i . '</option>' . "\n";
                      }
                    ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group has-default">
                    <select class="selectpicker" name="tgl2" id="tgl2" data-style="select-with-transition" title="Pilih tanggal" data-size="7" required>
                    <?php 
                      for ($i=1; $i <= cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); $i++) {
                        echo '<option value="' . $i . '"';
                          if ($i == $tgl2) {
                              echo 'selected';
                          }
                          echo '>' . $i . '</option>' . "\n";
                      }
                    ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group has-default">
                    <select class="selectpicker" name="section" id="section" data-style="select-with-transition" title="Pilih Cell" data-size="7" required>
                    <?php 
                      $this->db->where('dept_id', '11');
                      $this->db->where('DL_STAT', '1');
                      $this->db->or_where('dept_id', '13');
                      $this->db->where('DL_STAT', '1');
                      $sect = $this->db->get('karyawan_sect')->result();
                      foreach ($sect as $row) :
                          echo '<option value="' . $row->id . '"';
                          if ($section == $row->id) {
                              echo 'selected';
                          }
                          echo '>' . $row->nama . '</option>' . "\n";
                      endforeach; 
                    ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <button type="submit" class="btn btn-rose">SUBMIT</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Status Jam Kerja Periode <?= date('F Y', strtotime("$tahun-$bulan-01")); ?></h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="dt-status2" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Shift</th>
                    <th>Nama</th>
                    <!-- <th>Cell</th>
                    <th>Tgl Submit</th> -->
                    <th>Status Lembur</th>
                    <th>Status Jam Kerja</th>
                    <th>Terlambat</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Tanggal</th>
                    <th>Shift</th>
                    <th>Nama</th>
                    <!-- <th>Cell</th>
                    <th>Tgl Submit</th> -->
                    <th>Status Lembur</th>
                    <th>Status Jam Kerja</th>
                    <th>Terlambat</th>
                  </tr>
                </tfoot>
                <tbody>

                  <?php
                  date_default_timezone_set('asia/jakarta');
                
                  $this->db->select('npk, nama');
                  $this->db->where('status', '1');
                  $this->db->where('is_active', '1');
                  $this->db->where('sect_id', $section);
                  $kry = $this->db->get_where('karyawan', ['work_contract' => 'Direct Labor'])->result_array();
                  foreach ($kry as $k) :

                    // for ($i = 1; $i < cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun) + 1; $i++) {
                    for ($i = $tgl1; $i <= $tgl2; $i++) {

                      $this->db->select('id, npk, nama, shift, atasan1, respon_create, status');
                      $this->db->where('npk', $k['npk']);
                      $this->db->where('year(tglmulai)', $tahun);
                      $this->db->where('month(tglmulai)', $bulan);
                      $this->db->where('day(tglmulai)', $i);
                      $this->db->where('status >', 0);
                      $jamkerja = $this->db->get_where('jamkerja')->row_array();

                      $this->db->where('npk', $k['npk']);
                      $this->db->where('year(tglmulai)', $tahun);
                      $this->db->where('month(tglmulai)', $bulan);
                      $this->db->where('day(tglmulai)', $i);
                      $this->db->where('status >', 0);
                      $lembur = $this->db->get_where('lembur')->row_array();

                      if (!empty($jamkerja)) {

                        $respon = floor($jamkerja['respon_create'] / (60 * 60 * 24));
                        if ($respon == 0) {
                          $respon = 'Tepat Waktu';
                        } else {
                          $respon = $respon;
                        }

                        // $now = time();
                        // // $due = strtotime($jamkerja['create']);
                        // $due = strtotime(date('Y-m-d 23:59:00', strtotime($jamkerja['create'])));
                        // $approve = $due - $now;
                        // $approve = floor($approve / (60 * 60 * 24));
                        // if ($approve < 0) {
                        //   $approve = '( ' . $approve . ' Hari )';
                        // } else {
                        //   $approve = null;
                        // }

                        if ($jamkerja['status'] == 2) { ?>
                          <tr onclick="window.location='<?= base_url('jamkerja/detail/' . $jamkerja['id']); ?>'">
                          <?php } else {
                          echo '<tr>';
                        } ?>
                          <td><?= date('m-d-Y', strtotime($tahun . '-' . $bulan . '-' . $i)); ?></td>
                          <td><?= $jamkerja['shift']; ?></td>
                          <td><?= $jamkerja['nama']; ?></td>
                          <?php if (!empty($lembur)) {
                              $otstat = $this->db->get_where('lembur_status', ['id' =>  $lembur['status']])->row_array(); ?>
                              <td><?= $otstat['nama']; ?></td>
                            <?php  } else { ?>
                              <td class="text-danger">Tidak ada Laporan Lembur</td>
                            <?php  } ?>
                          <td>
                            <?php if ($jamkerja['status'] == 1) {
                              echo 'Menunggu Persetujuan ' . $jamkerja['atasan1'];
                            } elseif ($jamkerja['status'] == 2) {
                              echo 'Menunggu Persetujuan PPIC';
                            } elseif ($jamkerja['status'] == 9) {
                              echo 'Selesai';
                            } ?>
                          </td>
                          <td><?= $respon; ?></td>
                          </tr>
                        <?php } else { ?>
                          <tr>
                            <td><?= date('m-d-Y', strtotime($tahun . '-' . $bulan . '-' . $i)); ?></td>
                            <td></td>
                            <td><?= $k['nama']; ?></td>
                            <?php if (!empty($lembur)) {
                              $otstat = $this->db->get_where('lembur_status', ['id' =>  $lembur['status']])->row_array(); ?>
                              <td><?= $otstat['nama']; ?></td>
                            <?php  } else { ?>
                              <td class="text-danger">Tidak ada Laporan Lembur</td>
                            <?php  } ?>
                            <td class="text-danger">Tidak ada Laporan Jam Kerja</td>
                            <td></td>
                          </tr>
                          <?php } 
                        }
                      endforeach;
                    ?>

                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-md-12">
                <i class="fa fa-circle text-danger"></i> Tidak ada laporan jam kerja (Belum melaporkan, Hari libur, Cuti atau Tidak masuk kerja).
              </div>
            </div>
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#dt-status1').DataTable({
      order: [
        [1, 'asc']
      ],
      rowGroup: {
        dataSrc: 2
      },
      "scrollY": "1000px",
      "scrollCollapse": true,
      "paging": false
    });

    $('#dt-status2').DataTable({
      order: [
        [2, 'asc']
      ],
      rowGroup: {
        dataSrc: 2
      },
      dom: 'Bfrtip',
      buttons: [
        'csv', 'print'
      ],
      "scrollY": "500px",
      "scrollCollapse": true,
      "paging": false
    });
  });
</script>