<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Laporan Perjalanan Dinas</h4>
                            <p class="card-category">Berdasarkan periode <?= date("d-m-Y", strtotime($tglawal)).' s/d '.date("d-m-Y", strtotime($tglakhir)); ?></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <form action="<?= base_url('perjalanandl/laporan_payment_fa'); ?>" method="post">
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
                            </form>
                        </div>
                        <div class="material-datatables">
                            <table id="dt-report" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Jenis</th>
                                        <th>Keberangkatan</th>
                                        <th>Peserta</th>
                                        <th>e-Wallet</th>
                                        <th>uangsaku</th>
                                        <th>insentif</th>
                                        <th>pagi</th>
                                        <th>siang</th>
                                        <th>malam</th>
                                        <th>Total Tunjangan</th>
                                        <th>Taksi/Pribadi</th>
                                        <th>BBM</th>
                                        <th>TOL</th>
                                        <th>Lainnya</th>
                                        <th>Total Perjalanan</th>
                                        <th>Total Dibayarkan</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Npk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $p) : ?>
                                        <tr>
                                            <td><?= $p['perjalanan_id']; ?></td>
                                            <td><?= $p['jenis_perjalanan']; ?></td>
                                            <td><?= date("d-m-Y", strtotime($p['tglberangkat'])); ?></td>
                                            <td><?= $p['karyawan_nama']; ?></td>
                                            <td><?= $p['ewallet']; ?></td>
                                            <td><?= number_format($p['uang_saku'], 0, '.', ','); ?></td>
                                            <td><?= number_format($p['insentif_pagi'], 0, '.', ','); ?></td>
                                            <td><?= number_format($p['um_pagi'], 0, '.', ','); ?></td>
                                            <td><?= number_format($p['um_siang'], 0, '.', ','); ?></td>
                                            <td><?= number_format($p['um_malam'], 0, '.', ','); ?></td>
                                            <td><?= number_format($p['tunjangan_perjalanan'], 0, '.', ','); ?></td>
                                            <td><?= number_format($p['taksi'], 0, '.', ','); ?></td>
                                            <td><?= number_format($p['bbm'], 0, '.', ','); ?></td>
                                            <td><?= number_format($p['tol'], 0, '.', ','); ?></td>
                                            <td><?= number_format($p['lainnya'], 0, '.', ','); ?></td>
                                            <td><?= number_format($p['biaya_perjalanan'], 0, '.', ','); ?></td>
                                            <td><?= number_format($p['total_yg_dibayarkan'], 0, '.', ','); ?></td>
                                            <?php if ($p['payment_by']){
                                                echo '<td>'.$p['payment_by'].' - '.date("d-m-Y H:i", strtotime($p['payment_at'])).'</td>';
                                            } else {
                                                echo '<td>-</td>';
                                            }?>
                                            <td><?= $p['status_pembayaran']; ?></td>
                                            <td><?= $p['npk']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total Biaya</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <!-- <tr>
                                        <th colspan="9" style="text-align:right">Total:</th>
                                        <th></th>
                                    </tr> -->
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
                    messageTop: '<?= date("d.m.Y", strtotime($tglawal)).' - '.date("d.m.Y", strtotime($tglakhir)); ?>',
                    footer: true
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Data RAISA - Payment Perjalanan Dinas',
                    text:'<i class="fa fa-file-pdf-o" aria-hidden="true" ></i>',
                    messageTop: 'REKAP KLAIM BIAYA DINAS LUAR PERIODE <?= date("d M Y", strtotime($tglawal)).' - '.date("d M Y", strtotime($tglakhir)); ?>',
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
            paging: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            rowGroup: {
                startRender: null,
                endRender: function ( rows, group ) {
                    var avg = rows
                        .data()
                        .pluck(16)
                        .reduce( function (a, b) {
                            return a + b.replace(/[^\d]/g, '')*1;
                        }, 0);
    
                    return 'Total in '+group+' : '+
                        $.fn.dataTable.render.number(',', '.', 0, 'Rp ').display( avg );
                },
                dataSrc: 0
            },
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // Total over all pages
                total = api
                    .column( 16 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                //Format currency rupiah	
                var	number_string = total.toString(),
                    sisa 	= number_string.length % 3,
                    rupiah 	= number_string.substr(0, sisa),
                    ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                        
                if (ribuan) {
                    separator = sisa ? ',' : '';
                    rupiah += separator + ribuan.join(',');
                }

                // Update footer
                $( api.column( 16 ).footer() ).html(
                    'Rp '+ rupiah
                );
            }
        });
    } );
</script>