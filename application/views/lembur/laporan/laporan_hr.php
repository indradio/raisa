<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Data Lembur</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                        <form action="<?= base_url('lembur/laporan_hr'); ?>" method="post">
                        <input type="hidden" class="form-control" id="awal" name="awal" value="<?= date("Y-m-d 00:00:00", strtotime($periode['tglawal'])); ?>">
                        <input type="hidden" class="form-control" id="akhir" name="akhir" value="<?= date("Y-m-d 23:59:00", strtotime($periode['tglakhir'])); ?>">
                                <div class="row">
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
                                        <button type="submit" class="btn btn-rose">Cari</a>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="#" id="section" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#sectionModal">LAPORAN SECTION</a>
                                    </div>
                                </div>
                            </form>
                            <table id="dtlembur" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Kategori</th>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Jam Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th>Tul</th>
                                        <th>Dept</th>
                                        <th>Sect</th>
                                        <th>Catatan</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody> </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Kategori</th>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Jam Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th>Tul</th>
                                        <th>Dept</th>
                                        <th>Sect</th>
                                        <th>Catatan</th>
                                        <th class="text-right">Actions</th>
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
<!-- Modal Cari Section-->
<div class="modal fade" id="sectionModal" tabindex="-1" role="dialog" aria-labelledby="sectionModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Laporan Lembur Section</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('lembur/report_lembur_sect'); ?>" target="_blank"> 
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-4 col-form-label">Dari Tanggal</label>
                                <div class="col-md-7">
                                    <div class="form-group has-default" id="tglawal">
                                        <input type="text" class="form-control datepicker" id="tglawal" name="tglawal" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Sampai tanggal</label>
                                <div class="col-md-7">
                                    <div class="form-group has-default" id="tglakhir">
                                        <input type="text" class="form-control datepicker" id="tglakhir" name="tglakhir" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Section</label>
                                <div class="col-md-7">
                                        <select class="selectpicker" name="sect_id" id="sect_id" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true">
                                        <?php
                                            $querySection = "SELECT * FROM karyawan_sect ORDER BY id ASC";
                                            $section = $this->db->query($querySection)->result_array();
                                            foreach ($section as $s) : ?>
                                                <option data-subtext="<?= $s['inisial']; ?>" value="<?= $s['id']; ?>"><?= $s['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-success">BUAT LAPORAN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dtlembur').DataTable( {
            "pagingType": "full_numbers",
            scrollX: true,
            scrollCollapse: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'LAPORAN LEMBUR',
                    text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i>',
                    messageTop: 'Periode <?= date("d M Y", strtotime($periode['tglawal'])).' - '.date("d M Y", strtotime($periode['tglakhir'])); ?>',
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
                    "url"   : "<?= site_url('lembur/get_data/hr') ?>",
                    "type"  : "POST",
                    "data"  : {awal:$('#awal').val(), akhir:$('#akhir').val()}
                },
            columns: [
                { "data":"id"},
                { "data":"kategori"},
                { "data":"npk"},
                { "data":"nama"},
                { "data":"tanggal_mulai"},
                { "data":"jam_mulai"},
                { "data":"tanggal_selesai"},
                { "data":"jam_selesai"},
                { "data":"durasi"},
                { "data":"tul"},
                { "data":"dept"},
                { "data":"sect"},
                { "data":"catatan"},
                { "data":"actions"}
            ],
        });
    });
</script>