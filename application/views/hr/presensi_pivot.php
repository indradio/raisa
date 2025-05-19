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
                    <label for="prdate" class="bmd-label-floating">Start Date</label>
                    <input type="text" class="form-control datepicker" id="start_date" name="start_date" />
                  </div>
                  <div class="col-md-3">
                    <label for="prdate" class="bmd-label-floating">End Date</label>
                    <input type="text" class="form-control datepicker" id="end_date" name="end_date" />
                  </div>
                  <div class="col-md-6 d-flex justify-content-between align-items-end">
                    <div>
                      <button type="button" class="btn btn-twitter" id="selectDateBtn">
                        <i class="material-icons">search</i> Search
                      </button>
                    </div>
                    <div>
                      <a href="<?= base_url('hr/presensi/tanggal'); ?>" class="btn btn-default">
                        <span class="btn-label">
                          <i class="material-icons">reply</i>
                        </span>
                        KEMBALI
                      </a>
                    </div>
                  </div>
                </div>
              </form>
             
            </div>
            <div class="material-datatables">
              <div class="table-responsive">
                <table id="presensiTable" class="table table-bordered table-striped" style="width:100%">
                  <thead id="presensiHead"></thead>
                  <tbody id="presensiBody"></tbody>
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
  function loadPresensiPivot(start_date, end_date) {
    $.post("<?= site_url('hr/get_presensi_by_pivot') ?>", {
        start_date: start_date,
        end_date: end_date
    }, function(response) {
        const dates = response.dates;
        const data = response.data;

        // Destroy and reinit DataTable
        if ($.fn.DataTable.isDataTable('#presensiTable')) {
          $('#presensiTable').DataTable().clear().destroy();
          $('#presensiHead').html('');  // Bersihkan header lama
          $('#presensiBody').html('');  // Bersihkan body lama
        }

        // Build header
        let headRow = '<tr><th>Nama</th>';
        dates.forEach(d => {
            const label = d.slice(8,10) + '-' + d.slice(5,7); // dd-mm
            headRow += `<th>${label}</th>`;
        });
        headRow += '</tr>';
        $('#presensiHead').html(headRow);

        // Build body
        let bodyHtml = '';
        data.forEach(row => {
            bodyHtml += `<tr><td>${row.nama}</td>`;
            dates.forEach(d => {
                bodyHtml += `<td>${row[d] ?? '-'}</td>`; // tampilkan '-' jika kosong
            });
            bodyHtml += '</tr>';
        });
        $('#presensiBody').html(bodyHtml);

        $('#presensiTable').DataTable({
            scrollX: true,
            dom: 'Bfrtip',
            buttons: ['excel', 'copy', 'csv', 'print'],
            paging: false
        });

    }, 'json');
  }

  // Tombol filter diklik
  $('#selectDateBtn').on('click', function() {
      const start = $('#start_date').val();
      const end = $('#end_date').val();

      if (!start || !end) {
          alert('Silakan isi tanggal mulai dan selesai.');
          return;
      }

      loadPresensiPivot(start, end);
  });

// Auto-load data awal hari ini
// $(document).ready(function() {
//     const today = new Date().toISOString().slice(0, 10);
//     $('#start_date').val(today);
//     $('#end_date').val(today);
//     loadPresensiPivot(today, today);
// });
</script>
