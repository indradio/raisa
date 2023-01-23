<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <!-- end row -->
        <div class="row">
        <div class="col-md-6">
            <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
            <form class="form-horizontal" action="<?= base_url('laporan/jamkerja/monthly/summary'); ?>" method="post">
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tahun</label>
                                <div class="col-md-10">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="tahun" id="tahun" data-style="select-with-transition" title="Pilih Tahun" data-size="7" onchange='this.form.submit()' required>
                                        <?php for ($y = date('Y')-2; $y <= date('Y'); $y++) { ?>
                                            <option value="<?= $y; ?>" <?php echo ($tahun == $y) ? 'selected' : ''; ?>><?= $y; ?></option>
                                        <?php };?>
                                        </select>
                                    </div>
                                </div>

                                <label class="col-md-2 col-form-label">Bulan</label>
                                <div class="col-md-10">
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

                                <label class="col-md-2 col-form-label">Dept</label>
                                <div class="col-md-10">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="dept" id="dept" data-style="select-with-transition" title="Pilih Dept" data-size="7" onchange='this.form.submit()' required>
                                            <option value="" <?= ($dept == '') ? 'selected' : ''; ?>>Semua</option>
                                            <option value="11" <?= ($dept == '11') ? 'selected' : ''; ?>>Engineering</option>
                                            <option value="13" <?= ($dept == '13') ? 'selected' : ''; ?>>Machinery</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
            </div>
            </div>
        </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose"></div>
                    <div class="card-body">
                        <div class="toolbar"></div>
                        <div class="material-datatables">
                            <table id="dt-report" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Dept</th>
                                        <th>Total Harian</th>
                                        <th>Projek Harian</th>
                                        <th>Non Projek Harian</th>
                                        <th>Okupansi Projek</th>
                                        <th>Total Lembur</th>
                                        <th>Projek Lembur</th>
                                        <th>Non Projek Lembur</th>
                                        <th>Okupansi Projek</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Dept</th>
                                        <th>Total Harian</th>
                                        <th>Projek Harian</th>
                                        <th>Non Projek Harian</th>
                                        <th>Okupansi Projek</th>
                                        <th>Total Lembur</th>
                                        <th>Projek Lembur</th>
                                        <th>Non Projek Lembur</th>
                                        <th>Okupansi Projek</th>
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
                [5, 'desc']
            ],
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            ajax: {
                    "url": "<?= site_url('jamkerja/laporan/getbyMonthly_Sum') ?>",
                    "type": "POST",
                    "data" : {tahun:$('#tahun').val(), bulan:$('#bulan').val(), dept:$('#dept').val()},
                },
            columns: [
                { "data": "nama" },
                { "data": "dept" },
                { "data": "jamkerja_harian" },
                { "data": "projek_harian" },
                { "data": "non_projek_harian" },
                { "data": "okupansi_harian" },
                { "data": "jamkerja_lembur" },
                { "data": "projek_lembur" },
                { "data": "non_projek_lembur" },
                { "data": "okupansi_lembur" }
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