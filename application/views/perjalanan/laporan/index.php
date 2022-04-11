<div class="content">
    <?php date_default_timezone_set('asia/jakarta'); ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 mr-auto">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Laporan Perjalanan Dinas </br> (Under Development and Testing)</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('laporan/perjalanan'); ?>" method="post">
                        <!-- <div class="row">
                                <label class="col-md-2 col-form-label">Laporan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="laporan" id="laporan" data-style="select-with-transition" title="Pilih Laporan" data-size="7">
                                            <option value="1">Kategori</option>
                                            <option value="2">Perjalanan</option>
                                            <option value="3">Kendaraan</option>
                                            <option value="4">Peserta</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Jenis Perjalanan</h4>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                    <div id="kategoriBarsChart" class="ct-chart"></div>
                  </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="kategoriTable" class="table table-striped table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                    <th>KATEGORI</th>
                                    <?php
                                    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                    
                                    for ($i=1; $i < $tanggal+1; $i++) { 
                                        echo '<th>'. $i . '</th>';
                                    }
                                    ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>DLPP</td>
                                        <?php
                                         for ($i=1; $i < $tanggal+1; $i++) {      
                                            $this->db->where('jenis_perjalanan', 'DLPP');
                                            $this->db->where('year(tglberangkat)',$tahun);
                                            $this->db->where('month(tglberangkat)',$bulan);
                                            $this->db->where('day(tglberangkat) <=',$i);
                                            $this->db->where('day(tglkembali) >=',$i);
                                            $this->db->where('status','9');
                                            $queryTrip = $this->db->get('perjalanan');
                                            if ($queryTrip->num_rows()==0){
                                                echo '<td>-</td>';
                                            }else{
                                                echo '<td>'. $queryTrip->num_rows().'</td>';
                                            }
                                          } 
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>TAPP</td>
                                        <?php
                                         for ($i=1; $i < $tanggal+1; $i++) {      
                                            $this->db->where('jenis_perjalanan', 'TAPP');
                                            $this->db->where('year(tglberangkat)',$tahun);
                                            $this->db->where('month(tglberangkat)',$bulan);
                                            $this->db->where('day(tglberangkat) <=',$i);
                                            $this->db->where('day(tglkembali) >=',$i);
                                            $this->db->where('status','9');
                                            $queryTrip = $this->db->get('perjalanan');
                                            if ($queryTrip->num_rows()==0){
                                                echo '<td>-</td>';
                                            }else{
                                                echo '<td>'. $queryTrip->num_rows().'</td>';
                                            }
                                          } 
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>TA</td>
                                        <?php
                                         for ($i=1; $i < $tanggal+1; $i++) {      
                                            $this->db->where('jenis_perjalanan', 'TA');
                                            $this->db->where('year(tglberangkat)',$tahun);
                                            $this->db->where('month(tglberangkat)',$bulan);
                                            $this->db->where('day(tglberangkat) <=',$i);
                                            $this->db->where('day(tglkembali) >=',$i);
                                            $this->db->where('status','9');
                                            $queryTrip = $this->db->get('perjalanan');
                                            if ($queryTrip->num_rows()==0){
                                                echo '<td>-</td>';
                                            }else{
                                                echo '<td>'. $queryTrip->num_rows().'</td>';
                                            }
                                          } 
                                        ?>
                                    </tr>
                                    <tr>
                                        <td><b>TOTAL</b></td>
                                        <?php
                                         for ($i=1; $i < $tanggal+1; $i++) {      
                                            $this->db->where('year(tglberangkat)',$tahun);
                                            $this->db->where('month(tglberangkat)',$bulan);
                                            $this->db->where('day(tglberangkat) <=',$i);
                                            $this->db->where('day(tglkembali) >=',$i);
                                            $this->db->where('status','9');
                                            $queryTotalTrip = $this->db->get('perjalanan');
                                            if ($queryTotalTrip->num_rows()==0){
                                                echo '<td>-</td>';
                                            }else{
                                                echo '<td><b>'. $queryTotalTrip->num_rows().'</b></td>';
                                            }
                                          } 
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Kendaraan</h4>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                    <div id="kategoriBarsChart2" class="ct-chart"></div>
                  </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="kategoriTable" class="table table-striped table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                    <th>KATEGORI</th>
                                    <?php
                                    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                    
                                    for ($i=1; $i < $tanggal+1; $i++) { 
                                        echo '<th>'. $i . '</th>';
                                    }
                                    ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Operasional</td>
                                        <?php
                                         for ($i=1; $i < $tanggal+1; $i++) {      
                                            $this->db->where('kepemilikan', 'Operasional');
                                            $this->db->where('year(tglberangkat)',$tahun);
                                            $this->db->where('month(tglberangkat)',$bulan);
                                            $this->db->where('day(tglberangkat) <=',$i);
                                            $this->db->where('day(tglkembali) >=',$i);
                                            $this->db->where('status','9');
                                            $queryTrip = $this->db->get('perjalanan');
                                            if ($queryTrip->num_rows()==0){
                                                echo '<td>-</td>';
                                            }else{
                                                echo '<td>'. $queryTrip->num_rows().'</td>';
                                            }
                                          } 
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Taksi</td>
                                        <?php
                                         for ($i=1; $i < $tanggal+1; $i++) {      
                                            $this->db->where('kendaraan', 'Taksi');
                                            $this->db->where('year(tglberangkat)',$tahun);
                                            $this->db->where('month(tglberangkat)',$bulan);
                                            $this->db->where('day(tglberangkat) <=',$i);
                                            $this->db->where('day(tglkembali) >=',$i);
                                            $this->db->where('status','9');
                                            $queryTrip = $this->db->get('perjalanan');
                                            if ($queryTrip->num_rows()==0){
                                                echo '<td>-</td>';
                                            }else{
                                                echo '<td>'. $queryTrip->num_rows().'</td>';
                                            }
                                          } 
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Pribadi</td>
                                        <?php
                                         for ($i=1; $i < $tanggal+1; $i++) {      
                                            $this->db->where('kendaraan', 'Pribadi');
                                            $this->db->where('year(tglberangkat)',$tahun);
                                            $this->db->where('month(tglberangkat)',$bulan);
                                            $this->db->where('day(tglberangkat) <=',$i);
                                            $this->db->where('day(tglkembali) >=',$i);
                                            $this->db->where('status','9');
                                            $queryTrip = $this->db->get('perjalanan');
                                            if ($queryTrip->num_rows()==0){
                                                echo '<td>-</td>';
                                            }else{
                                                echo '<td>'. $queryTrip->num_rows().'</td>';
                                            }
                                          } 
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Sewa</td>
                                        <?php
                                         for ($i=1; $i < $tanggal+1; $i++) {      
                                            $this->db->where('kendaraan', 'Sewa');
                                            $this->db->where('year(tglberangkat)',$tahun);
                                            $this->db->where('month(tglberangkat)',$bulan);
                                            $this->db->where('day(tglberangkat) <=',$i);
                                            $this->db->where('day(tglkembali) >=',$i);
                                            $this->db->where('status','9');
                                            $queryTrip = $this->db->get('perjalanan');
                                            if ($queryTrip->num_rows()==0){
                                                echo '<td>-</td>';
                                            }else{
                                                echo '<td>'. $queryTrip->num_rows().'</td>';
                                            }
                                          } 
                                        ?>
                                    </tr>
                                    <tr>
                                        <td><b>TOTAL</b></td>
                                        <?php
                                         for ($i=1; $i < $tanggal+1; $i++) {      
                                            $this->db->where('year(tglberangkat)',$tahun);
                                            $this->db->where('month(tglberangkat)',$bulan);
                                            $this->db->where('day(tglberangkat) <=',$i);
                                            $this->db->where('day(tglkembali) >=',$i);
                                            $this->db->where('status','9');
                                            $queryTotalTrip = $this->db->get('perjalanan');
                                            if ($queryTotalTrip->num_rows()==0){
                                                echo '<td>-</td>';
                                            }else{
                                                echo '<td><b>'. $queryTotalTrip->num_rows().'</b></td>';
                                            }
                                          } 
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
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

      var dataStackedBarsChart = {
        // labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        labels: [
            <?php
               for ($i=1; $i < $tanggal+1; $i++) { 
                    echo $i . ',';
                    }
            ?>
            ],
        series: [
          [
          <?php
            for ($i=1; $i < $tanggal+1; $i++) {      
              $this->db->where('jenis_perjalanan', 'DLPP');
            $this->db->where('year(tglberangkat)',$tahun);
            $this->db->where('month(tglberangkat)',$bulan);
            $this->db->where('day(tglberangkat) <=',$i);
            $this->db->where('day(tglkembali) >=',$i);
            $this->db->where('status','9');
            $queryTrip = $this->db->get('perjalanan');
          
            echo $queryTrip->num_rows() .',';
          
            } 
          ?>
          ],
          [
          <?php
            for ($i=1; $i < $tanggal+1; $i++) {      
              $this->db->where('jenis_perjalanan', 'TAPP');
            $this->db->where('year(tglberangkat)',$tahun);
            $this->db->where('month(tglberangkat)',$bulan);
            $this->db->where('day(tglberangkat) <=',$i);
            $this->db->where('day(tglkembali) >=',$i);
            $this->db->where('status','9');
            $queryTrip = $this->db->get('perjalanan');
          
            echo $queryTrip->num_rows() .',';
          
            } 
          ?>
          ],
          [
          <?php
            for ($i=1; $i < $tanggal+1; $i++) {      
              $this->db->where('jenis_perjalanan', 'TA');
            $this->db->where('year(tglberangkat)',$tahun);
            $this->db->where('month(tglberangkat)',$bulan);
            $this->db->where('day(tglberangkat) <=',$i);
            $this->db->where('day(tglkembali) >=',$i);
            $this->db->where('status','9');
            $queryTrip = $this->db->get('perjalanan');
          
            echo $queryTrip->num_rows() .',';
          
            } 
          ?>
          ]
        ]
      };

      var optionsStackedBarsChart = {
        seriesBarDistance: 10,
        stackBars: true,
        axisX: {
          showGrid: false
        },
        height: '320px'
      };

      var responsiveOptionsStackedBarsChart = [
        ['screen and (max-width: 640px)', {
          seriesBarDistance: 5,
          axisX: {
            labelInterpolationFnc: function (value) {
              return value[0];
            }
          }
        }]
      ];

      var StackedBarsChart = Chartist.Bar('#kategoriBarsChart', dataStackedBarsChart, optionsStackedBarsChart, responsiveOptionsStackedBarsChart);

      //start animation for the Emails Subscription Chart
      md.startAnimationForBarChart(StackedBarsChart);

      var dataStackedBarsChart = {
        // labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        labels: [
            <?php
               for ($i=1; $i < $tanggal+1; $i++) { 
                    echo $i . ',';
                    }
            ?>
            ],
        series: [
          [
          <?php
            for ($i=1; $i < $tanggal+1; $i++) {      
            $this->db->where('kepemilikan', 'Operasional');
            $this->db->where('year(tglberangkat)',$tahun);
            $this->db->where('month(tglberangkat)',$bulan);
            $this->db->where('day(tglberangkat) <=',$i);
            $this->db->where('day(tglkembali) >=',$i);
            $this->db->where('status','9');
            $queryTrip = $this->db->get('perjalanan');
          
            echo $queryTrip->num_rows() .',';
          
            } 
          ?>
          ],
          [
          <?php
            for ($i=1; $i < $tanggal+1; $i++) {      
            $this->db->where('kendaraan', 'Taksi');
            $this->db->where('year(tglberangkat)',$tahun);
            $this->db->where('month(tglberangkat)',$bulan);
            $this->db->where('day(tglberangkat) <=',$i);
            $this->db->where('day(tglkembali) >=',$i);
            $this->db->where('status','9');
            $queryTrip = $this->db->get('perjalanan');
          
            echo $queryTrip->num_rows() .',';
          
            } 
          ?>
          ],
          [
          <?php
            for ($i=1; $i < $tanggal+1; $i++) {      
            $this->db->where('kendaraan', 'Pribadi');
            $this->db->where('year(tglberangkat)',$tahun);
            $this->db->where('month(tglberangkat)',$bulan);
            $this->db->where('day(tglberangkat) <=',$i);
            $this->db->where('day(tglkembali) >=',$i);
            $this->db->where('status','9');
            $queryTrip = $this->db->get('perjalanan');
          
            echo $queryTrip->num_rows() .',';
          
            } 
          ?>
          ],
          [
          <?php
            for ($i=1; $i < $tanggal+1; $i++) {      
            $this->db->where('kendaraan', 'Sewa');
            $this->db->where('year(tglberangkat)',$tahun);
            $this->db->where('month(tglberangkat)',$bulan);
            $this->db->where('day(tglberangkat) <=',$i);
            $this->db->where('day(tglkembali) >=',$i);
            $this->db->where('status','9');
            $queryTrip = $this->db->get('perjalanan');
          
            echo $queryTrip->num_rows() .',';
          
            } 
          ?>
          ]
       
        ]
      };

      var optionsStackedBarsChart = {
        seriesBarDistance: 10,
        stackBars: true,
        axisX: {
          showGrid: false
        },
        height: '320px'
      };

      var responsiveOptionsStackedBarsChart = [
        ['screen and (max-width: 640px)', {
          seriesBarDistance: 5,
          axisX: {
            labelInterpolationFnc: function (value) {
              return value[0];
            }
          }
        }]
      ];

      var StackedBarsChart2 = Chartist.Bar('#kategoriBarsChart2', dataStackedBarsChart, optionsStackedBarsChart, responsiveOptionsStackedBarsChart);

      //start animation for the Emails Subscription Chart
      md.startAnimationForBarChart(StackedBarsChart2);

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
                    "url"   : "<?= site_url('perjalanan/leadtime/byatasan') ?>",
                    "type"  : "POST",
                    "data"  : 
                            {
                                tahun:$('#tahun').selectpicker('val'),
                                bulan:$('#bulan').selectpicker('val')
                            }
                },
            columns: [
                { "data": "nama" },
                { "data": "average_atasan" },
                { "data": "durasi_atasan" },
                { "data": "jumlah_atasan" }
            ],
        });
    } );
</script>