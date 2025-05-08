<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-text">
              <h4 class="card-title">Presensi</h4>
              <p class="card-category">Periode <?= date('d M Y', strtotime("$tahun-$bulan-$tanggal")); ?></p>
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <form class="form" id="formDate" method="post" action="<?= base_url('hr/presensi/tanggal'); ?>">
                <div class="row">
                  <div class="col-md-3">
                    <label for="prdate" class="bmd-label-floating">Select Date *</label>
                    <input type="text" class="form-control datepicker" id="prdate" name="prdate" required="true" />
                    <button type="button" class="btn btn-twitter" id="selectDateBtn"><i class="material-icons">search</i> Search by Date</button>
                  </div>
                  <div class="col-md-6"></div>
                </div>
              </form>
             
              <a href="<?= base_url('hr/download/presensi'); ?>" class="btn btn-linkedin" target="_blank">
                <span class="btn-label">
                  <i class="material-icons">cloud_download</i>
                </span>
                RAW DATA FOR DOWNLOAD
              </a>
            </div>
            <div class="material-datatables">
              <div class="table-responsive">
                <table id="dt-presensi" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Nama</th>
                      <th>Shift</th>
                      <th>Masuk</th>
                      <th>Pulang</th>
                      <th>Lokasi Masuk</th>
                      <th>Lokasi Pulang</th>
                    </tr>
                  </thead>
                  <tbody>
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

    $('#selectDateBtn').on('click', function () {
       
      $('#dt-presensi').DataTable().ajax.reload();
      $.notify({
          icon: "add_alert",
          message: "<b>LOADING!</b> Data sedang diproses."
      }, {
          type: "success",
          timer: 2000,
          placement: {
          from: "top",
          align: "center"
          }
      });

    });

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
                  "url"   : "<?= site_url('hr/get_presensi_by_date') ?>",
                  "type"  : "POST",
                  "data"  : function(d) {
                            d.date = $('#prdate').val(); // Ambil nilai terbaru setiap reload
                      }
              },
          columns: [
              { "data": "tanggal", className: "text-center" },
              { "data": "nama" },
              { "data": "work_state" },
              { "data": "in_time" },
              { "data": "out_time" },
              { "data": "in_location" },
              { "data": "out_location" }
          ],
          language: {
              search: "_INPUT_",
              searchPlaceholder: "Search records",
          }
      });
  });
</script>