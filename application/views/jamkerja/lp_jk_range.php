<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Laporan Jam Kerja</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <form class="form-horizontal" action="<?= base_url('jamkerja/laporan_jk'); ?>" method="post">
                                <div class="row">
                                    <input type="hidden" class="form-control" id="awal" name="awal" value="<?= $periode['tglawal']; ?>">
                                    <input type="hidden" class="form-control" id="akhir" name="akhir" value="<?= $periode['tglakhir']; ?>">
                                    <label class="col-md-2 col-form-label">Dari Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglawal" name="tglawal" value="<?= date('d-m-Y', strtotime($periode['tglawal'])); ?>">
                                        </div>
                                    </div>
                                    <label class="col-md-2 col-form-label">Sampai Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglakhir" name="tglakhir" value="<?= date('d-m-Y', strtotime($periode['tglakhir'])); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-success">Cari</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="material-datatables mt-3">
                            <table id="dtjamkerja" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>NPK</th>
                                        <th>Kategori</th>
                                        <th>COPRO</th>
                                        <th>Aktivitas</th>
                                        <th>Deskripsi Hasil</th>
                                        <th>Durasi</th>
                                        <th>Progres Hasil</th>
                                        <th>Dept</th>
                                        <th>Cell / Section</th>
                                        <th>Posisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>NPK</th>
                                        <th>Kategori</th>
                                        <th>COPRO</th>
                                        <th>Aktivitas</th>
                                        <th>Deskripsi Hasil</th>
                                        <th>Durasi</th>
                                        <th>Progres Hasil</th>
                                        <th>Dept</th>
                                        <th>Cell / Section</th>
                                        <th>Posisi</th>
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
        $('#dtjamkerja').DataTable( {
            "pagingType": "full_numbers",
            scrollX: true,
            scrollCollapse: true,
            dom: 'Bfrtip',
            buttons: [
                'copy',
                'csv',
                {
                    extend: 'excelHtml5',
                    title: 'DATA JAM KERJA',
                    text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i>',
                    messageTop: '<?= date("d M Y", strtotime($periode['tglawal'])).' - '.date("d M Y", strtotime($periode['tglakhir'])); ?>',
                    footer: true
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            ajax: {
                    "url"   : "<?= site_url('jamkerja/get_aktivitas_jk') ?>",
                    "type"  : "POST",
                    "data"  : {awal:$('#awal').val(), akhir:$('#akhir').val()}
                },
            columns: [
                { "data": "tanggal" },
                { "data": "nama" },
                { "data": "npk" },
                { "data": "kategori" },
                { "data":"copro"},
                { "data":"aktivitas"},
                { "data":"deskripsi"},
                { "data":"durasi"},
                { "data":"progres"},
                { "data":"dept"},
                { "data":"sect"},
                { "data":"posisi"}
            ],
        });
    });
</script>