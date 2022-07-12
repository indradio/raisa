<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
    <div class="row">
            <div class="col-md-4">
                <div class="card ">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">access_time</i>
                        </div>
                        <h4 class="card-title">Laporan Lembur </br> (Under Development and Testing)</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('laporan/lembur/top'); ?>" method="post">
                            <div class="row">
                                <label class="col-md-2 col-form-label">Dari</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control datepicker" id="from" name="from" value="<?= date('d-m-Y', strtotime($from)); ?>" required="true"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Sampai</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control datepicker" id="to" name="to" value="<?= date('d-m-Y', strtotime($to)); ?>" required="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label"></label>
                                <div class="col-md-5">
                                    <button type="submit" class="btn btn-success">Cari</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
              $this->db->select('SUM(durasi) as total');
              $this->db->where('tglmulai >=',$from);
              $this->db->where('tglselesai <=', $to);
              $this->db->where('kategori', 'OT');
              $this->db->where('status', '9');
              $this->db->from('lembur');
              $totalDurasi = $this->db->get()->row()->total;

              $this->db->select('SUM(tul) as total');
              $this->db->where('tglmulai >=',$from);
              $this->db->where('tglselesai <=', $to);
              $this->db->where('kategori', 'OT');
              $this->db->where('status', '9');
              $this->db->from('lembur');
              $totalTul = $this->db->get()->row()->total;
            ?>
            <div class="col-md-3">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">more_time</i>
                    </div>
                    <p class="card-category">Total</p>
                    <h3 class="card-title"><?= $totalDurasi; ?> <small>JAM</small></h3>
                    </div>
                    <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">announcement</i> Total durasi LEMBUR belum dikurangi Istirahat.
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">price_check</i>
                    </div>
                    <p class="card-category">Total</p>
                    <h3 class="card-title"><?= $totalTul; ?> <small>TUL</small></h3>
                    </div>
                    <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">announcement</i> Total Upah Lembur.
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Laporan Lembur</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <!-- <form action="<?= base_url('laporan/lembur/top'); ?>" method="post">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Dari Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="from" name="from" value="<?= date('d-m-Y', strtotime($from)); ?>" required="true"/>
                                        </div>
                                    </div>
                                    <label class="col-md-2 col-form-label">Sampai Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="to" name="to" value="<?= date('d-m-Y', strtotime($to)); ?>" required="true" />
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
                                        <th>Nama</th>
                                        <th>Jam</th>
                                        <th>Tul</th>
                                        <th>Dept</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Jam</th>
                                        <th>Tul</th>
                                        <th>Dept</th>
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
                [1, 'desc']
            ],
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            ajax: {
                    "url": "<?= site_url('lembur/get_top/'. $from.'/'. $to) ?>",
                    "type": "POST"
                },
            columns: [
                { "data": "nama" },
                { "data": "jam" },
                { "data": "tul" },
                { "data": "dept" }
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
                [1, 'desc']
            ],
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            ajax: {
                    "url": "<?= site_url('perjalanan/leadtime/byatasan') ?>",
                    "type": "POST"
                },
            columns: [
                { "data": "nama" },
                { "data": "durasi_atasan" },
                { "data": "jumlah_atasan" },
                { "data": "average_atasan" }
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