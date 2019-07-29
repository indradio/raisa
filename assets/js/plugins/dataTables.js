$(document).ready(function () {
    $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    var table = $('#datatable').DataTable();

    //datatables persetujuan

    $('#revenueTables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        scrollX: true,

        "language": {
            "decimal": ","
        },
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    var table = $('#revenueTables').DataTable();
    var jan = table.row(0).column(1).data();
    var feb = table.row(0).column(2).data();
    var mar = table.row(0).column(3).data();
    var apr = table.row(0).column(4).data();
    var mei = table.row(0).column(5).data();
    var jun = table.row(0).column(6).data();
    var jul = table.row(0).column(7).data();
    var ags = table.row(0).column(8).data();
    var sep = table.row(0).column(9).data();
    var okt = table.row(0).column(10).data();
    var nov = table.row(0).column(11).data();
    var des = table.row(0).column(12).data();
    console.log(jan);

    dataColouredBarsChart = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'november', 'Desember'],
        series: [
            [jan[0], feb[0], mar[0], apr[0], mei[0], jun[0], jul[0], ags[0], sep[0], okt[0], nov[0], des[0]],
            [jan[1], feb[1], mar[1], apr[1], mei[1], jun[1], jul[1], ags[1], sep[1], okt[1], nov[1], des[1]],
            [jan[2], feb[2], mar[2], apr[2], mei[2], jun[2], jul[2], ags[2], sep[2], okt[2], nov[2], des[2]],
            [jan[3], feb[3], mar[3], apr[3], mei[3], jun[3], jul[3], ags[3], sep[3], okt[3], nov[3], des[3]]
        ]
    };

    optionsColouredBarsChart = {
        lineSmooth: Chartist.Interpolation.cardinal({
            tension: 10
        }),
        axisY: {
            showGrid: true,
            offset: 40
        },
        axisX: {
            showGrid: false,
        },
        low: 0,
        high: 25,
        showPoint: true,
        height: '300px'
    };

    var colouredBarsChart = new Chartist.Line('#revenueChart', dataColouredBarsChart, optionsColouredBarsChart);

    md.startAnimationForLineChart(colouredBarsChart);

    //datatables persetujuan

    $('#dtatasan').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        select: {
            style: 'single'
        },
        "columnDefs": [
            { "visible": false, "targets": 5 },
            { "visible": false, "targets": 6 },
            { "visible": false, "targets": 8 },
            { "visible": false, "targets": 9 },
            { "visible": false, "targets": 10 }
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    var table = $('#dtatasan').DataTable();

    // Select record
    table.on('select', function (e, dt, type, indexes) {
        if (type === 'row') {
            $('#rsvDetail').on('show.bs.modal', function () {
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-body input[name="id"]').val(table.rows(indexes).data().pluck(0).toArray())
                modal.find('.modal-body input[name="nama"]').val(table.rows(indexes).data().pluck(1).toArray())
                modal.find('.modal-body input[name="tujuan"]').val(table.rows(indexes).data().pluck(2).toArray())
                modal.find('.modal-body textarea[name="keperluan"]').val(table.rows(indexes).data().pluck(3).toArray())
                modal.find('.modal-body input[name="anggota"]').val(table.rows(indexes).data().pluck(4).toArray())
                modal.find('.modal-body input[name="nopol"]').val(table.rows(indexes).data().pluck(5).toArray())
                modal.find('.modal-body input[name="kepemilikan"]').val(table.rows(indexes).data().pluck(6).toArray())
                modal.find('.modal-body input[name="tglberangkat"]').val(table.rows(indexes).data().pluck(7).toArray())
                modal.find('.modal-body input[name="jamberangkat"]').val(table.rows(indexes).data().pluck(8).toArray())
                modal.find('.modal-body input[name="tglkembali"]').val(table.rows(indexes).data().pluck(9).toArray())
                modal.find('.modal-body input[name="jamkembali"]').val(table.rows(indexes).data().pluck(10).toArray())
            })
            $('#rsvBatal').on('show.bs.modal', function () {
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-body input[name="id"]').val(table.rows(indexes).data().pluck(0).toArray())
            })
            $('#rsvDetail').modal("show");
        }
    });

    // Delete a record
    table.on('click', '.remove', function (e) {
        $tr = $(this).closest('tr');
        table.row($tr).remove().draw();
        e.preventDefault();
    });

    //Like record
    table.on('click', '.like', function () {
        alert('You clicked on Like button');
    });
});