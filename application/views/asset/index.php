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
                        <h4 class="card-title">Data Asset</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Asset</th>
                                        <th class="th-description">Kategori</th>
                                        <th class="th-description">Lokasi</th>
                                        <th class="th-description">First Acq</th>
                                        <th class="th-description">Cost Center</th>
                                        <th class="th-description">Status</th>
                                        <th class="th-description">Tgl Opname</th>
                                        <th class="th-description">Catatan</th>
                                        <th class="disabled-sorting th-description">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Asset</th>
                                        <th class="th-description">Kategori</th>
                                        <th class="th-description">Lokasi</th>
                                        <th class="th-description">First Acq</th>
                                        <th class="th-description">Cost Center</th>
                                        <th class="th-description">Status</th>
                                        <th class="th-description">Tgl Opname</th>
                                        <th class="th-description">Catatan</th>
                                        <th class="th-description">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($asset as $a) : ?>
                                        <tr>
                                            <td>
                                                <div class="img-container">
                                                    <img src="<?= base_url(); ?>assets/img/asset/<?= $a['asset_foto']; ?>" alt="...">
                                                </div>
                                            </td>
                                            <td class="td-name">
                                                <a><?= $a['asset_deskripsi']; ?></a>
                                                <br />
                                                <small><?= $a['asset_no'] . '-' . $a['asset_sub_no']; ?></small>
                                            </td>
                                            <td><?= $a['kategori']; ?></td>
                                            <td><?= $a['lokasi']; ?></td>
                                            <td><?= $a['first_acq']; ?></td>
                                            <td><?= $a['cost_center']; ?></td>
                                            <?php if ($a['status'] == null) { ?>
                                                <td></td>
                                            <?php } elseif ($a['status'] == 1) { ?>
                                                <td>OK</td>
                                            <?php } elseif ($a['status'] == 2) { ?>
                                                <td>Sedang Diverifikasi</td>
                                            <?php }; ?>
                                            <td><?= $a['tglopname']; ?></td>
                                            <td><?= $a['catatan']; ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('asset/do_opname/') . $a['asset_no'] . '/' . $a['asset_sub_no']; ?>" class="badge badge-pill badge-primary">OPNAME</a>
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