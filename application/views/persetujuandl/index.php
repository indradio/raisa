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
                            <h4 class="card-title">Data Reservasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="material-datatables">
                                <table id="dtatasan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No. Reservasi</th>
                                            <th>Tujuan</th>
                                            <th>Keperluan</th>
                                            <th>Peserta</th>
                                            <!-- <th class="disabled-sorting text-right">Actions</th> -->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No. Reservasi</th>
                                            <th>Tujuan</th>
                                            <th>Keperluan</th>
                                            <th>Peserta</th>
                                            <!-- <th class="text-right">Actions</th> -->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $queryRsv = "SELECT *
                                            FROM `reservasi`
                                            WHERE `atasan1` = '{$karyawan['inisial']}' or `atasan2` = '{$karyawan['inisial']}' and (`status` = 1 or `status` = 2)
                                            ORDER BY `id` DESC
                                            ";
                                        $reservasi = $this->db->query($queryRsv)->result_array();
                                        foreach ($reservasi as $rsv) : ?>
                                            <tr>
                                                <td><?= $rsv['id']; ?></td>
                                                <td><?= $rsv['tujuan']; ?></td>
                                                <td><?= $rsv['keperluan']; ?></td>
                                                <td><?= $rsv['anggota']; ?></td>
                                                <!-- <td class="text-right">
                                                                    <a href="#" class="btn btn-link btn-warning btn-just-icon edit" data-toggle="modal" data-target="#rsvDetail" data-rsv_id="<?= $rsv['id']; ?>" data-rsv_nama="<?= $rsv['nama']; ?>" data-rsv_tujuan="<?= $rsv['tujuan']; ?>"><i class="material-icons">dvr</i></a>
                                                                    <a href="<?= base_url('persetujuandl/setujudl/') . $rsv['id']; ?>" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">done</i></a>
                                                                    <a href="<?= base_url('persetujuandl/bataldl/') . $rsv['id']; ?>" class="btn btn-link btn-danger btn-just-icon remove btn-bataldl"><i class="material-icons">close</i></a>
                                                                </td> -->
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
    <div class="modal fade" id="rsvDetail" tabindex="-1" role="">
        <div class="modal-dialog modal-login" role="document">
            <div class="modal-content">
                <div class="card card-signup card-plain">
                    <div class="modal-header">
                        <div class="card-header card-header-primary text-center">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <i class="material-icons">clear</i>
                            </button>

                            <h4 class="card-title">Log in</h4>
                            <div class="social-line">
                                <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                    <i class="fa fa-facebook-square"></i>
                                </a>
                                <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                    <i class="fa fa-twitter"></i>
                                    <div class="ripple-container"></div>
                                </a>
                                <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form" method="" action="">
                            <p class="description text-center">Or Be Classical</p>
                            <div class="card-body">

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">face</i></div>
                                        </div>
                                        <input type="text" class="form-control" id="id" name="id">
                                    </div>
                                </div>

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">email</i></div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Email...">
                                    </div>
                                </div>

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">lock_outline</i></div>
                                        </div>
                                        <input type="password" placeholder="Password..." class="form-control">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a href="#pablo" class="btn btn-primary btn-link btn-wd btn-lg">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </div>