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
                        <h4 class="card-title">Data Perjalanan Dinas Luar</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                           
                        <form class="form-horizontal" action="<?= base_url('laporan/perjalanan/biaya'); ?>" method="post">
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
                                        <th>Nomor DL</th>
                                        <th>Jenis DL</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tanggal Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>KM Keberangkatan</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Jam Kembali</th>
                                        <th>KM Kembali</th>
                                        <th>KM Total</th>
                                        <th>Nomor Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Uang Saku</th>
                                        <th>Insentif Pagi</th>
                                        <th>UM Pagi</th>
                                        <th>UM Siang</th>
                                        <th>UM Malam</th>
                                        <th>Total</th>
                                        <th>Catatan GA</th>
                                        <th>Catatan Security</th>
                                        <!-- <th class="disabled-sorting text-right">Actions</th> -->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Jenis DL</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>KM Keberangkatan</th>
                                        <th>Tgl Kembali</th>
                                        <th>Jam Kembali</th>
                                        <th>KM Kembali</th>
                                        <th>KM Total</th>
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Uang Saku</th>
                                        <th>Insentif Pagi</th>
                                        <th>UM Pagi</th>
                                        <th>UM Siang</th>
                                        <th>UM Malam</th>
                                        <th>Total</th>
                                        <th>Catatan GA</th>
                                        <th>Catatan Security</th>
                                        <!-- <th class="text-right">Actions</th> -->
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
            pagingType: "full_numbers",
            scrollX: true,
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
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
            serverSide: false,
            processing: true,
            ajax: {
                    "url": "<?= site_url('perjalanan/get_data/travelcost') ?>",
                    "type": "POST",
                    "data" : { tahun:$('#tahun').val(), bulan:$('#bulan').val() }
                },
            // order: [],
            columns: [
                { "data": "id" },
                { "data": "jenis_perjalanan" },
                { "data": "nama" },
                { "data": "anggota" },
                { "data": "tujuan" },
                { "data": "keperluan" },
                { "data": "tglberangkat" },
                { "data": "jamberangkat" },
                { "data": "kmberangkat" },
                { "data": "tglkembali" },
                { "data": "jamkembali" },
                { "data": "kmkembali" },
                { "data": "kmtotal" },
                { "data": "nopol" },
                { "data": "kepemilikan" },
                { "data": "uangsaku"},
                { "data": "insentif_pagi" },
                { "data": "um_pagi" },
                { "data": "um_siang" },
                { "data": "um_malam" },
                { "data": "total" },
                { "data": "catatan" },
                { "data": "catatan_security" }
            ],
        });
    });
</script>