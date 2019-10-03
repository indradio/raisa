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
                        <h4 class="card-title">Hasil Vote</h4>
                    </div>
                    <div class="card-body">
                        <!-- <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-icon card-header-rose">
                                        <div class="card-icon">
                                            <i class="material-icons">insert_chart</i>
                                        </div>
                                        <h4 class="card-title">Multiple Bars Chart
                                            <small>- Bar Chart</small>
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="multipleBarsChart" class="ct-chart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header card-header-icon card-header-danger">
                                        <div class="card-icon">
                                            <i class="material-icons">pie_chart</i>
                                        </div>
                                        <h4 class="card-title">Pie Chart</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="chartPreferences" class="ct-chart"></div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="card-category">Legend</h6>
                                            </div>
                                            <div class="col-md-12">
                                                <i class="fa fa-circle text-info"></i> Apple
                                                <i class="fa fa-circle text-warning"></i> Samsung
                                                <i class="fa fa-circle text-danger"></i> Windows Phone
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-12"></div>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->

                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Ocean Dream Samudra</th>
                                        <th>Taman Safari Indonesia</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ODS</th>
                                        <th>TSI</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <?php
                                        $vote1 = $this->db->query('SELECT * FROM famday_vote WHERE `ocean` =  1');
                                        $vote2 = $this->db->query('SELECT * FROM famday_vote WHERE `safari` =  1');
                                        $osd = $vote1->num_rows();
                                        $tsi = $vote2->num_rows();
                                        ?>
                                        <td><?= $osd; ?></td>
                                        <td><?= $tsi; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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