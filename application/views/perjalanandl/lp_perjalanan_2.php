<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <!-- Start - Card summary kategory -->
        <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
                                <?php 
                                    // $totaltanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

                                    $this->db->where('year(tglberangkat)',$tahun);
                                    $this->db->where('month(tglberangkat)',$bulan);
                                    $this->db->where('status','9');
                                    $total = $this->db->get('perjalanan');

                                    // $this->db->select_sum('kmtotal');
                                    // $this->db->where('month(tglberangkat)','11');
                                    // $this->db->where('status','9');
                                    // $querykm = $this->db->get('perjalanan');
                                    // $km = $querykm->row()->kmtotal;
                                ?>
                            <div class="card card-stats">
                              <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">directions_car</i>
                                </div>
                                <p class="card-category">TOTAL</p>
                                <h3 class="card-title"><?= $total->num_rows(); ?> <small>PERJALANAN</small></h3>
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                                <i class="material-icons">date_range</i> TOTAL PERJALANAN BULAN INI
                                </div>
                              </div>
                            </div>
                          </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                                <?php 
                                    $this->db->where('jenis_perjalanan', 'DLPP');
                                    $this->db->where('year(tglberangkat)',$tahun);
                                    $this->db->where('month(tglberangkat)',$bulan);
                                    $this->db->where('status','9');
                                    $totaldlpp = $this->db->get('perjalanan');

                                    // $this->db->select_sum('kmtotal');
                                    // $this->db->where('jenis_perjalanan', 'DLPP');
                                    // $this->db->where('year(tglberangkat)',$tahun);
                                    // $this->db->where('month(tglberangkat)',$bulan);
                                    // $this->db->where('status','9');
                                    // $querydlpp = $this->db->get('perjalanan');
                                    // $kmdlpp = $querydlpp->row()->kmtotal;
                                ?>
                            <div class="card card-stats">
                              <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">directions_car</i>
                                </div>
                                <p class="card-category">DLPP</p>
                                <h3 class="card-title"><?= $totaldlpp->num_rows(); ?> <small>PERJALANAN</small></h3>
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                                <i class="material-icons">date_range</i> TOTAL PERJALANAN DLPP BULAN INI
                                </div>
                              </div>
                            </div>
                          </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
                                <?php 
                                   $this->db->where('jenis_perjalanan', 'TAPP');
                                    $this->db->where('year(tglberangkat)',$tahun);
                                    $this->db->where('month(tglberangkat)',$bulan);
                                    $this->db->where('status','9');
                                    $totaltapp = $this->db->get('perjalanan');
                                    
                                    // $this->db->select_sum('kmtotal');
                                    // $this->db->where('kepemilikan', 'tapp');
                                    // $this->db->where('month(tglberangkat)','11');
                                    // $this->db->where('status','9');
                                    // $querykmtapp = $this->db->get('perjalanan');
                                    // $kmtapp = $querykmtapp->row()->kmtotal;
                                ?>
                            <div class="card card-stats">
                              <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">directions_car</i>
                                </div>
                                <p class="card-category">TAPP</p>
                                <h3 class="card-title"><?= $totaltapp->num_rows(); ?> <small>PERJALANAN</small></h3>
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                                <i class="material-icons">date_range</i> TOTAL PERJALANAN TAPP BULAN INI
                                </div>
                              </div>
                            </div>
                          </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
                                <?php 
                                    $this->db->where('jenis_perjalanan', 'TA');
                                    $this->db->where('year(tglberangkat)',$tahun);
                                    $this->db->where('month(tglberangkat)',$bulan);
                                    $this->db->where('status','9');
                                    $totalta = $this->db->get('perjalanan');
                                    
                                    // $this->db->select_sum('kmtotal');
                                    // $this->db->where('kepemilikan', 'ta');
                                    // $this->db->where('month(tglberangkat)','11');
                                    // $this->db->where('status','9');
                                    // $querykmta = $this->db->get('perjalanan');
                                    // $kmta = $querykmta->row()->kmtotal;
                                ?>
                            <div class="card card-stats">
                              <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">directions_car</i>
                                </div>
                                <p class="card-category">TA</p>
                                <h3 class="card-title"><?= $totalta->num_rows(); ?> <small>PERJALANAN</small></h3>
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                                <i class="material-icons">date_range</i> TOTAL PERJALANAN TA BULAN INI
                                </div>
                              </div>
                            </div>
                          </div>

</div>
      <!-- End - Card summary kategory -->
    <!-- Start - Card summary kendaraan -->
    <div class="row">
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Laporan Perjalanan Dinas <?= $bulan.'-'.$tahun; ?> </h4>
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
        </div>
            <!-- end col-md-6 -->
        <!-- End - Card summary kendaraan -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<script>
    $(document).ready(function(){
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
    });
</script>