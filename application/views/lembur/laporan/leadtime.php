<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Laporan Leadtime Approval Lembur</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                        <form class="form-horizontal" action="<?= base_url('laporan/leadtime/lembur'); ?>" method="post">
                            <div class="row">
                                <label class="col-md-1 col-form-label">Tahun</label>
                                <div class="col-md-11">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="tahun" id="tahun" data-style="select-with-transition" title="Pilih Tahun" data-size="7" onchange='this.form.submit()' required>
                                        <?php for ($y = date('Y')-2; $y <= date('Y'); $y++) { ?>
                                            <option value="<?= $y; ?>" <?php echo ($tahun == $y) ? 'selected' : ''; ?>><?= $y; ?></option>
                                        <?php };?>
                                        </select>
                                    </div>
                                </div>

                                <label class="col-md-1 col-form-label">Bulan</label>
                                <div class="col-md-11">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="bulan" id="bulan" data-style="select-with-transition" title="Pilih Bulan" data-size="7" onchange='this.form.submit()' required>
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
                                </div>
                            </div>
                        </form>
                        </div>
                        <div class="material-datatables">
                            <table id="dt-report" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th><small>Rencana</small>
                                        <th>Atasan1 at</th>
                                        <th>Atasan1 leadtime</th>
                                        <th>Atasan1 by</th>
                                        <th>Atasan2 at</th>
                                        <th>Atasan2 leadtime</th>
                                        <th>Atasan2 by</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th><small>Rencana</small>
                                        <th>Atasan1 at</th>
                                        <th>Atasan1 leadtime</th>
                                        <th>Atasan1 by</th>
                                        <th>Atasan2 at</th>
                                        <th>Atasan2 leadtime</th>
                                        <th>Atasan2 by</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Laporan Leadtime by Atasan</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar"> </div>
                        <div class="material-datatables">
                            <table id="dt-report-atasan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Durasi</th>
                                        <th>Jumlah</th>
                                        <th>Rata2</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Durasi</th>
                                        <th>Jumlah</th>
                                        <th>Rata2</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<script type="text/javascript">
    $(document).ready(function() {
        // $('#dt-report').DataTable({
        //     "pagingType": "full_numbers",
        //     scrollX: true,
        //     // scrollY: '512px',
        //     dom: 'Bfrtip',
        //     buttons: [
        //         'copy',
        //         {
        //             extend: 'excelHtml5',
        //             text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i>',
                    
        //             footer: true
        //         },
        //         {
        //             extend: 'pdfHtml5',
        //             text:'<i class="fa fa-file-pdf-o" aria-hidden="true" ></i>',
                    
        //             orientation: 'landscape',
        //             pageSize: 'A3',
        //             download: 'open',
        //             footer: true
        //         }
        //     ],
        //     order: [
        //         [0, 'asc']
        //     ],
        //     scrollCollapse: true,
        //     language: {
        //         search: "_INPUT_",
        //         searchPlaceholder: "Search records",
        //     },
        //     serverSide: false,
        //     processing: true,
        //     ajax: {
        //             "url": "<?= site_url('lembur/leadtime/get') ?>",
        //             "type": "POST",
        //             "data" : {tahun:$('#tahun').val(), bulan:$('#bulan').val()},
        //         },
        //     columns: [
        //         { "data": "id" },
        //         { "data": "nama" },
        //         { "data": "rencana_at" },
        //         { "data": "atasan1_rencana_at" },
        //         { "data": "atasan1_rencana_time" },
        //         { "data": "atasan1_rencana_by" },
        //         { "data": "atasan2_rencana_at" },
        //         { "data": "atasan2_rencana_time" },
        //         { "data": "atasan2_rencana_by" },
        //     ],
            // initComplete: function () {
            //     this.api().columns().every( function () {
            //         var column = this;
            //         var select = $('<select><option value=""></option></select>')
            //             .appendTo( $(column.footer()).empty() )
            //             .on( 'change', function () {
            //                 var val = $.fn.dataTable.util.escapeRegex(
            //                     $(this).val()
            //                 );
    
            //                 column
            //                     .search( val ? '^'+val+'$' : '', true, false )
            //                     .draw();
            //             } );
    
            //         column.data().unique().sort().each( function ( d, j ) {
            //             select.append( '<option value="'+d+'">'+d+'</option>' )
            //         } );
            //     } );
            // }
        // });
        $('#dt-report-atasan').DataTable({
            "pagingType": "full_numbers",
            scrollX: true,
            // scrollY: '512px',
            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'excelHtml5',
                    text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i>',
                    
                    footer: true
                },
                {
                    extend: 'pdfHtml5',
                    text:'<i class="fa fa-file-pdf-o" aria-hidden="true" ></i>',
                    
                    orientation: 'landscape',
                    pageSize: 'A3',
                    download: 'open',
                    footer: true
                }
            ],
            order: [
                [3, 'desc']
            ],
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            ajax: {
                    "url": "<?= site_url('lembur/leadtime/getbyLead') ?>",
                    "type": "POST",
                    "data" : {tahun:$('#tahun').val(), bulan:$('#bulan').val()},
                },
            columns: [
                { "data": "nama" },
                { "data": "durasi" },
                { "data": "jumlah" },
                { "data": "average" }
            ],
            // initComplete: function () {
            //     this.api().columns().every( function () {
            //         var column = this;
            //         var select = $('<select><option value=""></option></select>')
            //             .appendTo( $(column.footer()).empty() )
            //             .on( 'change', function () {
            //                 var val = $.fn.dataTable.util.escapeRegex(
            //                     $(this).val()
            //                 );
    
            //                 column
            //                     .search( val ? '^'+val+'$' : '', true, false )
            //                     .draw();
            //             } );
    
            //         column.data().unique().sort().each( function ( d, j ) {
            //             select.append( '<option value="'+d+'">'+d+'</option>' )
            //         } );
            //     } );
            // }
        });
    } );
</script>