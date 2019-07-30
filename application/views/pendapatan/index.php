<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon card-header-info">
                        <div class="card-icon">
                            <i class="material-icons">timeline</i>
                        </div>
                        <h4 class="card-title">Laporan Pendapatan
                            <small> - Revenue</small>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="revenueChart" class="ct-chart"></div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="card-category"></h6>
                            </div>
                            <div class="col-md-12">
                                <i class="fa fa-circle text-info"></i> Aktual
                                <!-- <i class="fa fa-circle text-warning"></i> Samsung -->
                                <i class="fa fa-circle text-danger"></i> Target
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Laporan Pendapatan
                            <small> - Revenue</small>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="revenueTables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Januari</th>
                                        <th>Februari</th>
                                        <th>Maret</th>
                                        <th>April</th>
                                        <th>Mei</th>
                                        <th>Juni</th>
                                        <th>Juli</th>
                                        <th>Agustus</th>
                                        <th>September</th>
                                        <th>Oktober</th>
                                        <th>November</th>
                                        <th>Desember</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Januari</th>
                                        <th>Februari</th>
                                        <th>Maret</th>
                                        <th>April</th>
                                        <th>Mei</th>
                                        <th>Juni</th>
                                        <th>Juli</th>
                                        <th>Agustus</th>
                                        <th>September</th>
                                        <th>Oktober</th>
                                        <th>November</th>
                                        <th>Desember</th>
                                        <th>Total</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($pendapatan as $revenue) : ?>
                                        <tr>
                                            <td><?= $revenue['nama']; ?></td>
                                            <td><?= $revenue['januari']; ?></td>
                                            <td><?= $revenue['februari']; ?></td>
                                            <td><?= $revenue['maret']; ?></td>
                                            <td><?= $revenue['april']; ?></td>
                                            <td><?= $revenue['mei']; ?></td>
                                            <td><?= $revenue['juni']; ?></td>
                                            <td><?= $revenue['juli']; ?></td>
                                            <td><?= $revenue['agustus']; ?></td>
                                            <td><?= $revenue['september']; ?></td>
                                            <td><?= $revenue['oktober']; ?></td>
                                            <td><?= $revenue['november']; ?></td>
                                            <td><?= $revenue['desember']; ?></td>
                                            <td><?= $revenue['total']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
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
<!-- Modal -->