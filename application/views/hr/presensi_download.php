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
              <form class="form" method="post" action="<?= base_url('hr/download/presensi'); ?>">
                <div class="form-group">
                  <!-- <label for="copro">Project*</label> -->
                  <select class="selectpicker" name="year" id="year" data-style="select-with-transition" title="Pilih Tahun" data-size="7" onchange='this.form.submit()' required>
                  <?php for ($y = date('Y')-2; $y <= date('Y'); $y++) { ?>
                      <option value="<?= $y; ?>" <?php echo ($tahun == $y) ? 'selected' : ''; ?>><?= $y; ?></option>
                  <?php };?>
                  </select>
                </div>
                <div class="form-group">
                  <!-- <label for="copro">Project*</label> -->
                  <select class="selectpicker" name="month" id="month" data-style="select-with-transition" title="Pilih Bulan" data-size="7" onchange='this.form.submit()' required>
                                            <option value="01" <?= ($bulan == '01') ? 'selected' : ''; ?>>Januari</option>
                                            <option value="02" <?= ($bulan == '02') ? 'selected' : ''; ?>>Febuari</option>
                                            <option value="03" <?= ($bulan == '03') ? 'selected' : ''; ?>>Maret</option>
                                            <option value="04" <?= ($bulan == '04') ? 'selected' : ''; ?>>April</option>
                                            <option value="05" <?= ($bulan == '05') ? 'selected' : ''; ?>>Mei</option>
                                            <option value="06" <?= ($bulan == '06') ? 'selected' : ''; ?>>Juni</option>
                                            <option value="07" <?= ($bulan == '07') ? 'selected' : ''; ?>>Juli</option>
                                            <option value="08" <?= ($bulan == '08') ? 'selected' : ''; ?>>Agustus</option>
                                            <option value="09" <?= ($bulan == '09') ? 'selected' : ''; ?>>September</option>
                                            <option value="10" <?= ($bulan == '10') ? 'selected' : ''; ?>>Oktober</option>
                                            <option value="11" <?= ($bulan == '11') ? 'selected' : ''; ?>>November</option>
                                            <option value="12" <?= ($bulan == '12') ? 'selected' : ''; ?>>Desember</option>
                                        </select>
                </div>
              </form>
            </div>
            <div class="material-datatables">
              <div class="table-responsive">
                <table id="dt-presensi" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Jam</th>
                      <th>NPK</th>
                      <th>Nama</th>
                      <th>Shift</th>
                      <th>Status</th>
                      <th>Keterangan</th>
                      <th>Lokasi</th>
                      <th>Atasan</th>
                      <th>HR</th>
                    </tr>
                  </thead>
                  <tbody>
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


    $('#dt-presensi').DataTable({
        "pagingType": "full_numbers",
          scrollX: true,
          dom: 'Bfrtip',
          buttons: [
              {
                  extend: 'excelHtml5',
                  title: 'LAPORAN PRESENSI',
                  text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i>',
                  footer: true
              },
              'copy',
              'csv', 
              'print'
          ],
          "lengthMenu": [
              [25, 50, 100, -1],
              [25, 50, 100, "All"]
          ],
          serverSide: false,
          processing: true,
          ajax: {
                  "url"   : "<?= site_url('hr/get_presensi_by_raw') ?>",
                  "type"  : "POST",
                  "data"  : function(d) {
                            d.year = $('#year').val(), // Ambil nilai terbaru setiap reload
                            d.month = $('#month').val() // Ambil nilai terbaru setiap reload
                      }
              },
          columns: [
              { "data": "date", className: "text-center" },
              { "data": "time", className: "text-center" },
              { "data": "npk" },
              { "data": "nama" },
              { "data": "work_state" },
              { "data": "direct_state" },
              { "data": "description" },
              { "data": "location" },
              { "data": "approved" },
              { "data": "hr" }
          ],
          language: {
              search: "_INPUT_",
              searchPlaceholder: "Search records",
          }
      });
  });
</script>