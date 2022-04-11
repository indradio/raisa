<div class="content">
    <?php date_default_timezone_set('asia/jakarta'); ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Laporan Perjalanan Dinas</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('perjalanandl/laporan'); ?>" method="post">
                        <div class="row">
                                <label class="col-md-2 col-form-label">Laporan Berdasarkan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="laporan" id="laporan" data-style="select-with-transition" title="Pilih Laporan" data-size="7" required>
                                            <option value="1">Kategori</option>
                                            <option value="2">Perjalanan</option>
                                            <option value="3">Kendaraan</option>
                                            <option value="4">Peserta</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                                <label class="col-md-2 col-form-label">Tahun</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="tahun" id="tahun" data-style="select-with-transition" title="Pilih Tahun" data-size="7" required>
                                        <?php for ($y = date('Y')-2; $y <= date('Y'); $y++) { ?>
                                            <option value="<?= $y; ?>" <?php echo ($tahun == $y) ? 'selected' : ''; ?>><?= $y; ?></option>
                                        <?php };?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                                <label class="col-md-2 col-form-label">Bulan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="bulan" id="bulan" data-style="select-with-transition" title="Pilih Bulan" data-size="7" required>
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
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <button type="submit" class="btn btn-fill btn-success">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Leadtime</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar"> 
                            <div id="kategoriBarsChart" class="ct-chart"></div>
                        </div>
                        <div class="material-datatables">
                            <table id="dt-report-leadtime" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Avg <sup><small>Jam</small></sup></th>
                                        <th>Total Durasi</th>
                                        <th>Total Perjalanan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Avg</th>
                                        <th>Total Durasi</th>
                                        <th>Total Perjalanan</th>
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
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var tahun = $('#tahun').val();
        var bulan = $('#bulan').val();
        $('#dt-report-leadtime').DataTable({
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
                    "type": "POST",
                    "data" : {tahun:$('#tahun').val(),
                                bulan:$('#bulan').val()}
                },
            columns: [
                { "data": "nama" },
                { "data": "average_atasan" },
                { "data": "durasi_atasan" },
                { "data": "jumlah_atasan" }
            ],
        });

        new Chartist.Bar('.ct-chart', {
  labels: ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'],
  series: [20, 60, 120, 200, 180, 200, 100]
}, {
    distributeSeries: true,
  // Default mobile configuration
  stackBars: true,
  axisX: {
    labelInterpolationFnc: function(value) {
      return value.split(/\s+/).map(function(word) {
        return word[0];
      }).join('');
    }
  },
  axisY: {
    offset: 20
  }
}, [
  // Options override for media > 400px
  ['screen and (min-width: 400px)', {
    reverseData: true,
    horizontalBars: true,
    axisX: {
      labelInterpolationFnc: Chartist.noop
    },
    axisY: {
      offset: 60
    }
  }],
  // Options override for media > 800px
  ['screen and (min-width: 800px)', {
    stackBars: false,
    seriesBarDistance: 10
  }],
  // Options override for media > 1000px
  ['screen and (min-width: 1000px)', {
    reverseData: false,
    horizontalBars: false,
    seriesBarDistance: 15
  }]
]);
   
    } );
</script>