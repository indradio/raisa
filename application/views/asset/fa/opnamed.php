<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-tabs card-header-rose">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <span class="nav-tabs-title">Asset:</span>
                            <ul class="nav nav-tabs" data-tabs="tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#profile" data-toggle="tab">
                                        <i class="material-icons">info</i> OPNAMED
                                        <div class="ripple-container"></div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    </div>
                    <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <table id="dtasset" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>SUB</th>
                                        <th>DESCRIPTION</th>
                                        <th>CATEGORY</th>
                                        <th>CHANGE PIC</th>
                                        <th>PIC</th>
                                        <th>PIC NAME</th>
                                        <th>NEW PIC</th>
                                        <th>NEW NAME</th>
                                        <th>CHANGE ROOM</th>
                                        <th>ROOM</th>
                                        <th>NEW ROOM</th>
                                        <th>STATUS</th>
                                        <th>CATATAN</th>
                                        <th>OPNAME BY</th>
                                        <th>OPNAME AT</th>
                                        <th>VERIFY BY</th>
                                        <th>VERIFY AT</th>
                                        <th>REMARK</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Sub</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Change PIC</th>
                                        <th>PIC</th>
                                        <th>PIC Name</th>
                                        <th>New PIC</th>
                                        <th>Pew Name</th>
                                        <th>Change Room</th>
                                        <th>Room</th>
                                        <th>New Room</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                        <th>Opname By</th>
                                        <th>Opname At</th>
                                        <th>Verify By</th>
                                        <th>Verify At</th>
                                        <th>Remark</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->

<script>
    $(document).ready(function() {

        $('#dtasset').DataTable({
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
    
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });
    
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                            });
                    });
            },
            "pagingType": "full_numbers",
            scrollX: true,
            scrollCollapse: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'LAPORAN OPNAME ASSET',
                    text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i>',
                    footer: true
                },
                'copy',
                'csv', 
                'print'
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            ajax: {
                    "url"   : "<?= site_url('asset/get/opname_opnamed') ?>",
                    "type"  : "POST",
                },
            columns: [
                { "data": "no" },
                { "data": "sub" },
                { "data": "description" },
                { "data": "category" },
                { "data": "change_pic" },
                { "data": "user" },
                { "data": "user_nama" },
                { "data": "new_user" },
                { "data": "new_user_nama" },
                { "data": "change_room" },
                { "data": "room" },
                { "data": "new_room" },
                { "data": "status" },
                { "data": "catatan" },
                { "data": "opnamed_by" },
                { "data": "opnamed_at" },
                { "data": "verify_by" },
                { "data": "verify_at" },
                { "data": "catatan" }
            ],
        });
        
    });
</script>