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
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor Asset</th>
                                        <th>Deskripsi</th>
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                        <th>First Acq</th>
                                        <th>Value Acq</th>
                                        <th>Cost Center</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nomor Asset</th>
                                        <th>Deskripsi</th>
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                        <th>First Acq</th>
                                        <th>Value Acq</th>
                                        <th>Cost Center</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($asset as $ast) : ?>
                                        <tr>
                                            <td><?= $ast['asset_no'] . '-' . $ast['asset_sub_no']; ?></td>
                                            <td><?= $ast['asset_deskripsi']; ?></td>
                                            <td><?= $ast['kategori']; ?></td>
                                            <td><?= $ast['lokasi']; ?></td>
                                            <td><?= $ast['first_acq']; ?></td>
                                            <td><?= $ast['value_acq']; ?></td>
                                            <td><?= $ast['cost_center']; ?></td>
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