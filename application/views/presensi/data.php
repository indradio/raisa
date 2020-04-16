<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-text">
              <h4 class="card-title">Presensi</h4>
              <p class="card-category">Periode <?= date('F Y', strtotime("$tahun-$bulan-01")); ?></p>
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <form class="form" method="post" action="<?= base_url('presensi/data'); ?>">
                <div class="form-group">
                  <!-- <label for="copro">Project*</label> -->
                  <select class="selectpicker" data-style="btn btn-link" id="month" name="month" title="Pilih Bulan" onchange='this.form.submit()' data-size="7" data-live-search="true" required>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                  </select>
                </div>
              </form>
            </div>
            <div class="material-datatables">
              <div class="table-responsive">
                <table id="dt-status" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Masuk</th>
                      <th>Istirahat</th>
                      <th>Pulang</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                    for ($i = 1; $i < $tanggal + 1; $i++) {

                      //clock in
                      $this->db->where('npk', $this->session->userdata('npk'));
                      $this->db->where('year(time)', $tahun);
                      $this->db->where('month(time)', $bulan);
                      $this->db->where('day(time)', $i);
                      $this->db->where('state', 'C/In');
                      $in = $this->db->get('presensi')->row_array();

                      //clock rest
                      $this->db->where('npk', $this->session->userdata('npk'));
                      $this->db->where('year(time)', $tahun);
                      $this->db->where('month(time)', $bulan);
                      $this->db->where('day(time)', $i);
                      $this->db->where('state', 'C/Rest');
                      $rest = $this->db->get('presensi')->row_array();

                      //clock out
                      $this->db->where('npk', $this->session->userdata('npk'));
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
                      } else {
                        echo '<th></th>';
                      }
                      if (!empty($rest)) {
                        echo '<th>' . date('H:i', strtotime($rest['time'])) . '</th>';
                      } else {
                        echo '<th></th>';
                      }
                      if (!empty($out)) {
                        echo '<th>' . date('H:i', strtotime($out['time'])) . '</th>';
                      } else {
                        echo '<th></th>';
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
      "scrollY": "512px",
      "scrollX": true,
      "scrollCollapse": true,
      "ordering": false,
      "paging": false
    });
  });
</script>