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
                <div class="col-md-3">
                  <div class="form-group has-default">
                    <select class="selectpicker" name="tahun" id="tahun" data-style="select-with-transition" title="Pilih tahun" data-size="3" required>
                      <?php for ($y = date('Y')-3; $y <= date('Y'); $y++) { ?>
                          <option value="<?= $y; ?>" <?php echo ($tahun == $y) ? 'selected' : ''; ?>><?= $y; ?></option>
                      <?php };?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
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
                <div class="col-ml-1">
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
              <table id="dt-status1" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Cell</th>
                    <?php
                    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                    for ($i = 1; $i < $tanggal + 1; $i++) {
                      echo '<th>' . date('D, d', strtotime($tahun . '-' . $bulan . '-' . $i)) . '</th>';
                    } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $this->db->where('is_active', '1');
                  $kar = $this->db->get_where('karyawan', ['work_contract' => 'Direct Labor'])->result_array();
                  foreach ($kar as $k) :
                    $sect = $this->db->get_where('karyawan_sect', ['id' => $k['sect_id']])->row_array();
                  ?>
                    <tr>
                      <td><?= $k['nama']; ?></td>
                      <td><?= $sect['nama']; ?></td>
                      <?php
                      for ($i = 1; $i < $tanggal + 1; $i++) {
                        echo '<td>';
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
                          if ($jamkerja['status'] == 9) {
                            echo '<i class="fa fa-circle text-success"></i>';
                          } elseif ($jamkerja['status'] == 1) {
                            echo '<i class="fa fa-circle text-warning"></i>';
                          } elseif ($jamkerja['status'] == 2) {
                            echo '<i class="fa fa-circle text-info"></i>';
                          }
                        } else {
                          echo '<i class="fa fa-circle text-danger"></i>';
                        }
                        if (!empty($lembur)) {
                          if ($lembur['status'] == 9) {
                            echo '<i class="fa fa-circle text-success"></i>';
                          } elseif ($lembur['status'] > 1 and $lembur['status'] < 7) {
                            echo '<i class="fa fa-circle text-warning"></i>';
                          } elseif ($lembur['status'] == 7) {
                            echo '<i class="fa fa-circle text-info"></i>';
                          }
                        }
                        echo '</td>';
                      } ?>
                    </tr>
                  <?php endforeach; ?>

                </tbody>

              </table>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-md-12">
                <i class="fa fa-circle text-success"></i> Laporan Jam Kerja / Lembur.
                <i class="fa fa-circle text-info"></i> Jam Kerja/Lembur Sedang diproses oleh PPIC/HR.
                <i class="fa fa-circle text-warning"></i> Jam Kerja sedang diproses oleh RDA/Koordinator/Depthead.
                <i class="fa fa-circle text-danger"></i> Tidak ada Laporan Jam Kerja (Belum melaporkan, Hari libur, Cuti atau Tidak masuk kerja).
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
        dataSrc: 1
      },
      "scrollY": "1000px",
      "scrollCollapse": true,
      "paging": false
    });

    $('#dt-status2').DataTable({
      order: [
        [1, 'asc']
      ],
      rowGroup: {
        dataSrc: 1
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