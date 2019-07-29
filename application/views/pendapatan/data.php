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
                        <h4 class="card-title">Laporan Pendapatan
                            <small> - Revenue</small>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <a href="#" class="btn btn-primary btn-sm mb-2 " role="button" aria-disabled="false" data-toggle="modal" data-target="#revTambah">Tambah Menu</a>
                            <a href="#" class="btn btn-danger btn-sm mb-2 " role="button" aria-disabled="false" data-toggle="modal" data-target="#revHapus">Hapus Menu</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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
                                        <th class="disabled-sorting text-right">Actions</th>
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
                                        <th class="text-right">Actions</th>
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
                                            <td class="text-right">
                                                <a href="#" class="btn btn-link btn-warning btn-just-icon edit" data-toggle="modal" data-target="#revEdit" data-nama="<?= $revenue['nama']; ?>" data-nama="<?= $revenue['nama']; ?>" data-januari="<?= $revenue['januari']; ?>" data-februari="<?= $revenue['februari']; ?>" data-maret="<?= $revenue['maret']; ?>" data-april="<?= $revenue['april']; ?>" data-mei="<?= $revenue['mei']; ?>" data-juni="<?= $revenue['juni']; ?>" data-juli="<?= $revenue['juli']; ?>" data-agustus="<?= $revenue['agustus']; ?>" data-september="<?= $revenue['september']; ?>" data-oktober="<?= $revenue['oktober']; ?>" data-november="<?= $revenue['november']; ?>" data-desember="<?= $revenue['desember']; ?>"><i class="material-icons">dvr</i></a>
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