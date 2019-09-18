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
                            <?php
                            $queryOpname1 = $this->db->query('SELECT * FROM asset WHERE `status_opname` =  1');
                            $queryOpname2 = $this->db->query('SELECT * FROM asset WHERE `status_opname` =  2');

                            ?>
                            <a href="<?= base_url('asset/asset'); ?>" class="btn btn-lg btn-primary mb-2" role="button" aria-disabled="false">TAMPILKAN SEMUA</a>
                            <a href="<?= base_url('asset/opname1'); ?>" class="btn btn-lg btn-danger mb-2" role="button" aria-disabled="false">BELUM DIOPNAME : <?= $queryOpname1->num_rows(); ?></a>
                            <a href="<?= base_url('asset/opname2'); ?>" class="btn btn-lg btn-success mb-2" role="button" aria-disabled="false">SUDAH DIOPNAME : <?= $queryOpname2->num_rows(); ?></a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="disabled-sorting text-center"></th>
                                        <th>Asset</th>
                                        <th>Kategori</th>
                                        <th>PIC</th>
                                        <th>Lokasi</th>
                                        <th>First Acq</th>
                                        <th>Value Acq</th>
                                        <th>Cost Center</th>
                                        <th>Status</th>
                                        <th>Tgl Opname</th>
                                        <th>Catatan</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Asset</th>
                                        <th>Kategori</th>
                                        <th>PIC</th>
                                        <th>Lokasi</th>
                                        <th>First Acq</th>
                                        <th>Value Acq</th>
                                        <th>Cost Center</th>
                                        <th>Status</th>
                                        <th>Tgl Opname</th>
                                        <th>Catatan</th>

                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($asset as $a) :
                                        if ($a['status_opname'] == 1) {
                                            $status = "BELUM DIOPNAME";
                                        } elseif ($a['status_opname'] == 2) {
                                            $status = "SEDANG DIVERIFIKASI";
                                        }; ?>
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
                                            <td><?= $a['npk']; ?></td>
                                            <td><?= $a['lokasi']; ?></td>
                                            <td><?= $a['first_acq']; ?></td>
                                            <td><?= $a['value_acq']; ?></td>
                                            <td><?= $a['cost_center']; ?></td>
                                            <td><?= $status; ?></td>
                                            <td><?= $a['tglopname']; ?></td>
                                            <td><?= $a['catatan']; ?></td>
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