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
                        <h4 class="card-title">WBS Project</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dtwbs" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No WBS</th>
                                        <th>Milestone</th>
                                        <th>Aktivitas</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Durasi</th>
                                        <th>Aktual Mulai</th>
                                        <th>Aktual Selesai</th>
                                        <th>Aktual Durasi</th>
                                        <th>Man Power</th>
                                        <th>Progres</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($wbs as $wbs) : ?>
                                        <tr>
                                            <td><?= $wbs['id']; ?></td>
                                            <td><?= $wbs['milestone']; ?></td>
                                            <td><?= $wbs['aktivitas']; ?></td>
                                            <td><?= date('d/m/Y', strtotime($wbs['tglmulai_wbs'])); ?></td>
                                            <td><?= date('d/m/Y', strtotime($wbs['tglselesai_wbs'])); ?></td>
                                            <td><?= $wbs['durasi_wbs']; ?></td>
                                            <td><?= date('d/m/Y', strtotime($wbs['tglmulai_aktual'])); ?></td>
                                            <td><?= date('d/m/Y', strtotime($wbs['tglselesai_aktual'])); ?></td>
                                            <td><?= $wbs['durasi_aktual']; ?></td>
                                            <td><?= $wbs['manpower']; ?></td>
                                            <td><?= $wbs['progres']; ?></td>
                                            <td><?= $wbs['status']; ?></td>
                                            <td class="text-right">
                                                <?php if ($wbs['tglselesai_wbs'] < date('Y-m-d')) { ?>
                                                    <a href="#" class="btn btn-round btn-danger btn-sm disabled">LATE</a>
                                                <?php } elseif ($wbs['tglselesai_wbs'] == date('Y-m-d')) { ?>
                                                    <a href="#" class="btn btn-round btn-warning btn-sm disabled">LAST MINUTE</a>
                                                <?php } else if ($wbs['tglselesai_wbs'] > date('Y-m-d')) { ?>
                                                    <a href="#" class="btn btn-round btn-success btn-sm disabled">ON GOING</a>
                                                <?php }; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No WBS</th>
                                        <th>Milestone</th>
                                        <th>Aktivitas</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Durasi</th>
                                        <th>Aktual Tanggal Mulai</th>
                                        <th>Aktual Tanggal Selesai</th>
                                        <th>Aktual Durasi</th>
                                        <th>Man Power</th>
                                        <th>Progres</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- end card-body-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end content -->