<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Laporan Perjalanan Dinas</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <!-- <form action="<?= base_url('perjalanandl/laporan_payment_fa'); ?>" method="post">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Dari Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglawal" name="tglawal" required="true" />
                                        </div>
                                    </div>
                                    <label class="col-md-2 col-form-label">Sampai Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglakhir" name="tglakhir" required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-success">Cari</a>
                                    </div>
                                </div>
                            </form> -->
                        </div>
                        <div class="material-datatables">
                            <table id="dt-report" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th><small>Rencana</small> <br> Berangkat</th>
                                        <th>Reservasi</th>
                                        <th>Atasan1 by</th>
                                        <th>Atasan1 at</th>
                                        <th>Atasan1 leadtime</th>
                                        <th>Atasan1 leadtime</th>
                                        <th>Atasan2 by</th>
                                        <th>Atasan2 at</th>
                                        <th>Atasan2 leadtime</th>
                                        <th>Atasan2 leadtime</th>
                                        <th>GA by</th>
                                        <th>GA at</th>
                                        <th>GA leadtime</th>
                                        <th>GA leadtime</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Berangkat</th>
                                        <th>Reservasi</th>
                                        <th>Atasan1 by</th>
                                        <th>Atasan1 at</th>
                                        <th>Atasan1 leadtime</th>
                                        <th>Atasan1 leadtime</th>
                                        <th>Atasan2 by</th>
                                        <th>Atasan2 at</th>
                                        <th>Atasan2 leadtime</th>
                                        <th>Atasan2 leadtime</th>
                                        <th>GA by</th>
                                        <th>GA at</th>
                                        <th>GA leadtime</th>
                                        <th>GA leadtime</th>
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
        $('#dt-report').DataTable({
            "pagingType": "full_numbers",
            scrollX: true,
            scrollY: '512px',
            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'excelHtml5',
                    title: 'REKAP KLAIM BIAYA DINAS LUAR',
                    text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i>',
                    
                    footer: true
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Data RAISA - Payment Perjalanan Dinas',
                    text:'<i class="fa fa-file-pdf-o" aria-hidden="true" ></i>',
                    
                    orientation: 'landscape',
                    pageSize: 'A3',
                    download: 'open',
                    footer: true
                }
            ],
            order: [
                [0, 'asc']
            ],
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            ajax: {
                    "url": "<?= site_url('perjalanan/leadtime/get') ?>",
                    "type": "POST"
                },
            columns: [
                { "data": "id" },
                { "data": "nama" },
                { "data": "tgl_berangkat" },
                { "data": "tgl_reservasi" },
                { "data": "atasan1_by" },
                { "data": "atasan1_at" },
                { "data": "atasan1_time" },
                { "data": "atasan1_int" },
                { "data": "atasan2_by" },
                { "data": "atasan2_at" },
                { "data": "atasan2_time" },
                { "data": "atasan2_int" },
                { "data": "ga_by" },
                { "data": "ga_at" },
                { "data": "ga_time" },
                { "data": "ga_int" }
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