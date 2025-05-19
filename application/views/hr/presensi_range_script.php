<script>
  function loadPresensiPivot(start_date, end_date) {
    $.post("<?= site_url('hr/get_presensi_by_pivot') ?>", {
        start_date: start_date,
        end_date: end_date
    }, function(response) {
        const dates = response.dates;
        const data = response.data;

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

        // Destroy and reinit DataTable
        if ($.fn.DataTable.isDataTable('#presensiTable')) {
            $('#presensiTable').DataTable().clear().destroy();
        }

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
