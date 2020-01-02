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

    $('#datatables2').DataTable({
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

    $('#dtdesc').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        order: [
            [0, 'desc']
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    $('#dtasc').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        order: [
            [0, 'asc']
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    $('#dtreportkr').DataTable({
        "pagingType": "full_numbers",
        order: [
            [1, 'desc']
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });
    $('#dtreportps').DataTable({
        "pagingType": "full_numbers",
        order: [
            [1, 'desc']
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    $('#famday').DataTable({
        "pagingType": "full_numbers",
        scrollX: true,
        dom: 'Bfrtip',
        buttons: [
            'csv', 'print'
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(10)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(10, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(10).footer()).html(
                '( ' + total + ' orang)'
            );
        },
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }

    });

    //datatables perjalananan

    $('#dtperjalanan').DataTable({
        "pagingType": "full_numbers",
        scrollX: true,
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
    });

    var tablePerjalanan = $('#dtperjalanan').DataTable();

    //datatables persetujuan DL

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

    var tableAtasan = $('#dtatasan').DataTable();

    // Select record
    tableAtasan.on('select', function (e, dt, type, indexes) {
        if (type === 'row') {
            $('#rsvDetail').on('show.bs.modal', function () {
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-body input[name="id"]').val(tableAtasan.rows(indexes).data().pluck(0).toArray())
                modal.find('.modal-body input[name="nama"]').val(tableAtasan.rows(indexes).data().pluck(1).toArray())
                modal.find('.modal-body input[name="tujuan"]').val(tableAtasan.rows(indexes).data().pluck(2).toArray())
                modal.find('.modal-body textarea[name="keperluan"]').val(tableAtasan.rows(indexes).data().pluck(3).toArray())
                modal.find('.modal-body input[name="anggota"]').val(tableAtasan.rows(indexes).data().pluck(4).toArray())
                modal.find('.modal-body input[name="nopol"]').val(tableAtasan.rows(indexes).data().pluck(5).toArray())
                modal.find('.modal-body input[name="kepemilikan"]').val(tableAtasan.rows(indexes).data().pluck(6).toArray())
                modal.find('.modal-body input[name="tglberangkat"]').val(tableAtasan.rows(indexes).data().pluck(7).toArray())
                modal.find('.modal-body input[name="jamberangkat"]').val(tableAtasan.rows(indexes).data().pluck(8).toArray())
                modal.find('.modal-body input[name="tglkembali"]').val(tableAtasan.rows(indexes).data().pluck(9).toArray())
                modal.find('.modal-body input[name="jamkembali"]').val(tableAtasan.rows(indexes).data().pluck(10).toArray())
            })
            $('#rsvBatal').on('show.bs.modal', function () {
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-body input[name="id"]').val(tableAtasan.rows(indexes).data().pluck(0).toArray())
            })
            $('#rsvDetail').modal("show");
        }
    });

    //datatables persetujuan TA

    $('#tableTa').DataTable({
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
            { "visible": false, "targets": 10 },
            { "visible": false, "targets": 11 }
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    var tableApprovalta = $('#tableTa').DataTable();

    // Select record
    tableApprovalta.on('select', function (e, dt, type, indexes) {
        if (type === 'row') {
            $('#modalTa').on('show.bs.modal', function () {
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-body input[name="id"]').val(tableApprovalta.rows(indexes).data().pluck(0).toArray())
                modal.find('.modal-body input[name="nama"]').val(tableApprovalta.rows(indexes).data().pluck(1).toArray())
                modal.find('.modal-body input[name="tujuan"]').val(tableApprovalta.rows(indexes).data().pluck(2).toArray())
                modal.find('.modal-body textarea[name="keperluan"]').val(tableApprovalta.rows(indexes).data().pluck(3).toArray())
                modal.find('.modal-body input[name="anggota"]').val(tableApprovalta.rows(indexes).data().pluck(4).toArray())
                modal.find('.modal-body input[name="nopol"]').val(tableApprovalta.rows(indexes).data().pluck(5).toArray())
                modal.find('.modal-body input[name="kepemilikan"]').val(tableApprovalta.rows(indexes).data().pluck(6).toArray())
                modal.find('.modal-body input[name="tglberangkat"]').val(tableApprovalta.rows(indexes).data().pluck(7).toArray())
                modal.find('.modal-body input[name="jamberangkat"]').val(tableApprovalta.rows(indexes).data().pluck(8).toArray())
                modal.find('.modal-body input[name="tglkembali"]').val(tableApprovalta.rows(indexes).data().pluck(9).toArray())
                modal.find('.modal-body input[name="jamkembali"]').val(tableApprovalta.rows(indexes).data().pluck(10).toArray())
                modal.find('.modal-body input[name="jenis"]').val(tableApprovalta.rows(indexes).data().pluck(11).toArray())
            })
            $('#batalTa').on('show.bs.modal', function () {
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-body input[name="id"]').val(tableApprovalta.rows(indexes).data().pluck(0).toArray())
            })
            $('#modalTa').modal("show");
        }
    });

    //datatables pendapatan

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
        order: [
            [0, 'asc']
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    var tableRevenue = $('#revenueTables').DataTable();
    var jan = tableRevenue.row(0).column(1).data();
    var feb = tableRevenue.row(0).column(2).data();
    var mar = tableRevenue.row(0).column(3).data();
    var apr = tableRevenue.row(0).column(4).data();
    var mei = tableRevenue.row(0).column(5).data();
    var jun = tableRevenue.row(0).column(6).data();
    var jul = tableRevenue.row(0).column(7).data();
    var ags = tableRevenue.row(0).column(8).data();
    var sep = tableRevenue.row(0).column(9).data();
    var okt = tableRevenue.row(0).column(10).data();
    var nov = tableRevenue.row(0).column(11).data();
    var des = tableRevenue.row(0).column(12).data();

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