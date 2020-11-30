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
                        <h4 class="card-title">Perjalanan Dinas</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="<?= base_url('cekdl/berangkat'); ?>" class="btn btn-lg btn-block btn-info mb-2" role="button" aria-disabled="false">KLIK UNTUK REFRESH</a>
                        </div>
                        </p>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="#" class="btn btn-sm btn-block btn-success mb-2 disabled" role="button" aria-disabled="false">PERJALANAN SIAP BERANGKAT</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Nomor Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tanggal Keberangkatan (Estimasi)</th>
                                        <th>Jam Keberangkatan (Estimasi)</th>
                                        <th class="disabled-sorting"></th>
                                        <th class="disabled-sorting">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tgl Keberangkatan (Estimasi)</th>
                                        <th>Jam Keberangkatan (Estimasi)</th>
                                        <th></th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $pdl) : ?>
                                        <?php if ($pdl['tglberangkat'] < date('Y-m-d') and $pdl['status'] == 1) { ?>
                                            <tr class="text-dark bg-danger">
                                            <?php } elseif ($pdl['tglberangkat'] < date('Y-m-d') and $pdl['status'] == 11) { ?>
                                            <tr class="text-dark bg-warning">
                                            <?php } else { ?>
                                            <tr>
                                            <?php }; ?>
                                            <td><?= $pdl['id']; ?></td>
                                            <td><?= $pdl['nopol']; ?></td>
                                            <td><?= $pdl['kepemilikan']; ?></td>
                                            <td><?= $pdl['nama']; ?></td>
                                            <td><?= $pdl['tujuan']; ?></td>
                                            <td><?= $pdl['keperluan']; ?></td>
                                            <td><?= $pdl['anggota']; ?></td>
                                            <td><?= date('d/m/Y', strtotime($pdl['tglberangkat'])); ?></td>
                                            <td><?= $pdl['jamberangkat']; ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('cekdl/cekberangkat/') . $pdl['id']; ?>" class="btn btn-round btn-success btn-sm">Berangkat</a>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-round btn-warning btn-sm" data-toggle="modal" data-target="#revisiPerjalanan" data-id="<?= $pdl['id']; ?>">Revisi</a>
                                            </td>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        </p>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="#" class="btn btn-sm btn-block btn-danger mb-2 disabled" role="button" aria-disabled="false">RESERVASI MENUNGGU GA</a>
                        </div>
                        <div class="material-datatables">
                            <table id="dtasc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor RSV</th>
                                        <th>Tanggal (Estimasi)</th>
                                        <th>Kendaraan</th>
                                        <th>NOPOL</th>
                                        <th>Nama</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($reservasi as $row) : ?>
                                            <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td><?= date('d-m-Y', strtotime($row['tglberangkat'])).' '.date('H:i', strtotime($row['jamberangkat'])); ?></td>
                                                <td><?= $row['kepemilikan']; ?></td>
                                                <td><?= $row['nopol']; ?></td>
                                                <td><?= $row['nama']; ?></td>
                                                <td><?= $row['anggota']; ?></td>
                                                <td><?= $row['tujuan']; ?></td>
                                                <td><?= $row['keperluan']; ?></td>
                                                <td class="text-right">
                                                    <a href="<?= base_url('cekdl/corsv/') . $row['id']; ?>" class="btn btn-round btn-success btn-sm">Berangkat</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nomor RSV</th>
                                        <th>Tanggal (Estimasi)</th>
                                        <th>Kendaraan</th>
                                        <th>NOPOL</th>
                                        <th>Nama</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-circle text-danger"></i> Perjalanan yang tanggal keberangkatan sudah lewat
                            </div>
                            <div class="col-md-12">
                                <i class="fa fa-circle text-warning"></i> Perjalanan yang Konfirmasi Keterlambatan
                            </div>
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