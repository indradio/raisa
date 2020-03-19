<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Rencana Lembur</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar text-right mb-2">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <?php $this->session->all_userdata(); ?>

                        </div>
                        <div class="material-datatables">
                            <table id="dtdesc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php $dt = get_instance();
                                    $sess = $this->session->all_userdata();
                                    foreach ($sess as $u) : ?>
                                        <tr>
                                            <td><?= $u['npk']; ?></td>
                                            <td><?= $u['nama']; ?></td>
                                            <td>Active</td>
                                        </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
</div>