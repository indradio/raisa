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
                        <h4 class="card-title">Daftar Perjalanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No Perjalanan</th>
                                        <th>Tanggal</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                        <th>Biaya</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Reservasi</th>
                                        <th>Tanggal</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                        <th>Biaya</th>
                                        <th>Catatan</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $p) : ?>
                                        <tr onclick="window.location='<?= base_url('perjalanan/penyelesaian/' . $p['id']); ?>'">
                                            <td><?= $p['id'] . ' - ' . $p['jenis_perjalanan']; ?></td>
                                            <td><?= date('d / m / Y', strtotime($p['tglberangkat'])); ?></td>
                                            <td><?= $p['anggota']; ?></td>
                                            <td><?= $p['tujuan']; ?></>
                                            <td><?= $p['keperluan']; ?></td>
                                            <td><?= $p['kepemilikan']; ?></td>
                                            <td><?= $p['total']; ?></td>
                                            <td><?= $p['catatan_security']; ?></td>
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