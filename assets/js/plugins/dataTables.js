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

    // Edit record
    table.on('click', '.edit', function () {
        $tr = $(this).closest('tr');
        var data = table.row($tr).data();
        alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
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