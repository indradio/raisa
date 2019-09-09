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
                        <h4 class="card-title">Data Perjalanan Dinas Luar</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="<?= base_url('cekdl/berangkat'); ?>" class="btn btn-rose mb-2" role="button" aria-disabled="false">REFRESH / KLIK DAHULU UNTUK MENDAPATKAN DATA TERBARU</a>
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
                                        <th class="disabled-sorting text-center"></th>
                                        <th>Actions</th>
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
                                        <th class="text-center"></th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $pdl) : ?>
                                        <tr>
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
                                                <?php
                                                    if ($this->session->userdata('npk') == '1111') { ?>
                                                    <a href="<?= base_url('perjalanandl/bataldladmin/') . $pdl['id']; ?>" class="btn btn-round btn-danger btn-sm">Batalkan</a>
                                                <?php }; ?>
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