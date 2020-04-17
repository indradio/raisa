<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-text">
              <h4 class="card-title"><?= $nama; ?></h4>
              <p class="card-category">Periode <?= date('F Y', strtotime("$tahun-$bulan-01")); ?></p>
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <form class="form" method="post" action="<?= base_url('hr/presensi/karyawan'); ?>">
                <div class="form-group">
                  <select class="selectpicker" data-style="btn btn-link" id="npk" name="npk" title="Pilih Karyawan" onchange='this.form.submit()' data-size="7" data-live-search="true" required>
                    <?php
                    $queryKaryawan = "SELECT *
                                    FROM `karyawan`
                                    WHERE `status` = '1' AND `is_active` = '1'
                                    ORDER BY `nama` ASC
                                    ";
                    $kryn = $this->db->query($queryKaryawan)->result_array();
                    foreach ($kryn as $k) : ?>
                      <option data-subtext="<?= $k['inisial']; ?>" value="<?= $k['npk']; ?>"><?= $k['nama']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </form>
              <a href="<?= base_url('hr/presensi/tanggal'); ?>" class="btn btn-facebook">
                <span class="btn-label">
                  <i class="material-icons">today</i>
                </span>
                PRESENSI PER HARI
              </a>
              <a href="<?= base_url('hr/download/presensi'); ?>" class="btn btn-linkedin" target="_blank">
                <span class="btn-label">
                  <i class="material-icons">cloud_download</i>
                </span>
                RAW DATA FOR DOWNLOAD
              </a>
            </div>
            <div class="material-datatables">
              <div class="table-responsive">
                <table id="dt-status" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th rowspan="2">Tanggal</th>
                      <th colspan="2" style="text-align: center;">MASUK</th>
                      <th colspan="2" style="text-align: center;">ISTIRAHAT</th>
                      <th colspan="2" style="text-align: center;">KELUAR</th>
                    </tr>
                    <tr>
                      <th>Waktu</th>
                      <th>Lokasi</th>
                      <th>Waktu</th>
                      <th>Lokasi</th>
                      <th>Waktu</th>
                      <th>Lokasi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                    for ($i = 1; $i < $tanggal + 1; $i++) {

                      //clock in
                      $this->db->where('npk', $npk);
                      $this->db->where('year(time)', $tahun);
                      $this->db->where('month(time)', $bulan);
                      $this->db->where('day(time)', $i);
                      $this->db->where('state', 'C/In');
                      $in = $this->db->get('presensi')->row_array();

                      //clock rest
                      $this->db->where('npk', $npk);
                      $this->db->where('year(time)', $tahun);
                      $this->db->where('month(time)', $bulan);
                      $this->db->where('day(time)', $i);
                      $this->db->where('state', 'C/Rest');
                      $rest = $this->db->get('presensi')->row_array();

                      //clock out
                      $this->db->where('npk', $npk);
                      $this->db->where('year(time)', $tahun);
                      $this->db->where('month(time)', $bulan);
                      $this->db->where('day(time)', $i);
                      $this->db->where('state', 'C/Out');
                      $out = $this->db->get('presensi')->row_array();
                      if (date('D', strtotime($tahun . '-' . $bulan . '-' . $i)) == 'Sat' or date('D', strtotime($tahun . '-' . $bulan . '-' . $i)) == 'Sun') {
                        echo '<tr class="table-danger">';
                      } else {
                        echo '<tr>';
                      }
                      echo '<th>' . date('D, d', strtotime($tahun . '-' . $bulan . '-' . $i)) . '</th>';
                      if (!empty($in)) {
                        echo '<th>' . date('H:i', strtotime($in['time'])) . '</th>';
                        echo '<th><a href="https://www.google.com/maps/search/?api=1&query=' . $in['lat'] . ',' . $in['lng'] . '" class="text-secondary" target="_blank"><u>' . $in['loc'] . '</u></a></th>';
                      } else {
                        echo '<th class="table-danger"></th>';
                        echo '<th class="table-danger"></th>';
                      }
                      if (!empty($rest)) {
                        echo '<th>' . date('H:i', strtotime($rest['time'])) . '</th>';
                        echo '<th><a href="https://www.google.com/maps/search/?api=1&query=' . $rest['lat'] . ',' . $rest['lng'] . '" class="text-secondary" target="_blank"><u>' . $rest['loc'] . '</u></a></th>';
                      } else {
                        echo '<th class="table-danger"></th>';
                        echo '<th class="table-danger"></th>';
                      }
                      if (!empty($out)) {
                        echo '<th>' . date('H:i', strtotime($out['time'])) . '</th>';
                        echo '<th><a href="https://www.google.com/maps/search/?api=1&query=' . $out['lat'] . ',' . $out['lng'] . '" class="text-secondary" target="_blank"><u>' . $out['loc'] . '</u></a></th>';
                      } else {
                        echo '<th class="table-danger"></th>';
                        echo '<th class="table-danger"></th>';
                      }
                      echo '</tr>';
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card-footer">
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
    $('#dt-status').DataTable({
      "pagingType": "full_numbers",
      scrollX: true,
      "ordering": false,
      "paging": false,
      dom: 'Bfrtip',
      buttons: [
        'csv', 'print'
      ],
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search records",
      }

      // "scrollY": "512px",
      // "scrollX": true,
      // "scrollCollapse": true,

    });
  });
</script>