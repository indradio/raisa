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
                                        <th>Nomor Reservasi</th>
                                        <th>Jenis Perjalanan</th>
                                        <th>Kendaraan</th>
                                        <th>Nama <small>(<i>Pemohon</i>)</small></th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Waktu Keberangkatan</th>
                                        <th>Waktu Kembali</th>
                                        <th>Catatan</th>
                                        <th class="disabled-sorting text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Reservasi</th>
                                        <th>Jenis Perjalanan</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Waktu Keberangkatan</th>
                                        <th>Waktu Kembali</th>
                                        <th>Catatan</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($reservasi as $rsv) : ?>
                                        <?php if ($rsv['tglberangkat'] < date('Y-m-d')) { ?>
                                            <tr class="text-dark bg-danger">
                                            <?php } else { ?>
                                            <tr>
                                            <?php }; ?>
                                            <td><?= $rsv['id']; ?></td>
                                            <td><?= $rsv['jenis_perjalanan']; ?></td>
                                            <td><?= $rsv['nopol']; ?>
                                                <?php if ($rsv['kepemilikan'] == 'Operasional') { ?>
                                                    <br /><span class="badge badge-success"><?= $rsv['kepemilikan']; ?></span></td>
                                        <?php } elseif ($rsv['kepemilikan'] == 'Taksi') { ?>
                                            <br /><span class="badge badge-warning"><?= $rsv['kepemilikan']; ?></span></td>
                                        <?php } elseif ($rsv['kepemilikan'] == 'Sewa') { ?>
                                            <br /><span class="badge badge-danger"><?= $rsv['kepemilikan']; ?></span></td>
                                        <?php } else { ?>
                                            <br /><span class="badge badge-info"><?= $rsv['kepemilikan']; ?></span></td>
                                        <?php }; ?>
                                        <td><?= $rsv['nama']; ?></td>
                                        <td><?= $rsv['tujuan']; ?></td>
                                        <td><?= $rsv['keperluan']; ?></td>
                                        <td><?= $rsv['anggota']; ?></td>
                                        <td><?= date('d/m/Y', strtotime($rsv['tglberangkat'])) . ' ' . date('H:i', strtotime($rsv['jamberangkat'])); ?></td>
                                        <td><?= date('d/m/Y', strtotime($rsv['tglkembali'])) . ' ' . date('H:i', strtotime($rsv['jamkembali'])); ?></td>
                                        <td><?= $rsv['catatan']; ?></td>
                                        <td class="text-right">
                                            <a href="<?= base_url('perjalanandl/prosesdl1/') . $rsv['id']; ?>" class="btn btn-sm btn-round btn-success">Proses</a>
                                            <br />
                                            <a href="<?= base_url('perjalanandl/gabung/') . $rsv['id']; ?>" class="btn btn-sm btn-round btn-warning">Gabungkan</a>
                                            <br />
                                            <a href="" class="btn btn-sm btn-round btn-danger" data-toggle="modal" data-target="#batalRsv" data-id="<?= $rsv['id']; ?>">Batalkan</a>
                                        </td>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-circle text-danger"></i> Perjalanan yang tanggal keberangkatan sudah lewat
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
<!-- Modal -->
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalRsvTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Pembatalan Perjalanan Dinas</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('perjalanandl/batalrsv/'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-4 col-form-label">No. Reservasi</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id" id="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Alasan Pembatalan</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control" name="catatan" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-danger btn-round btn-wd btn-sm">BATALKAN PERJALANAN INI!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>