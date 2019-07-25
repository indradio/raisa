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
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No. Reservasi</th>
                                            <th>Tgl Reservasi</th>
                                            <th>Tujuan</th>
                                            <th>Keperluan</th>
                                            <th>Anggota</th>
                                            <th>Kendaraan</th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No. Reservasi</th>
                                            <th>Tgl Reservasi</th>
                                            <th>Tujuan</th>
                                            <th>Keperluan</th>
                                            <th>Anggota</th>
                                            <th>Kendaraan</th>
                                            <th class="text-right">Actions</th>
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
                                                <td><?= $rsv['tglreservasi']; ?></td>
                                                <td><?= $rsv['tujuan']; ?></td>
                                                <td><?= $rsv['keperluan']; ?></td>
                                                <td><?= $rsv['anggota']; ?></td>
                                                <td><?= $rsv['kepemilikan']; ?></td>
                                                <td class="text-right">
                                                    <a href="#" class="btn btn-link btn-warning btn-just-icon edit" data-toggle="modal" data-target="#rsvDetail" data-rsv_id="<?= $rsv['id']; ?>" data-rsv_nama="<?= $rsv['nama']; ?>" data-rsv_tujuan="<?= $rsv['tujuan']; ?>"><i class="material-icons">dvr</i></a>
                                                    <a href="<?= base_url('persetujuandl/setujudl/') . $rsv['id']; ?>" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">done</i></a>
                                                    <a href="<?= base_url('persetujuandl/bataldl/') . $rsv['id']; ?>" class="btn btn-link btn-danger btn-just-icon remove btn-bataldl"><i class="material-icons">close</i></a>
                                                </td>
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
    <div class="modal fade" id="rsvDetail" tabindex="-1" role="dialog" aria-labelledby="rsvDetailTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rsvDetailTitle">#</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>