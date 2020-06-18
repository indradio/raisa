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
                                        <th>Nama <small>(<i>Pemohon</i>)</small></th>
                                        <th>Waktu Berangkat</th>
                                        <th>Kendaraan</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Total</th>
                                        <th>Kasbon /<small> Bayar*</small></th>
                                        <th>Selisih</th>
                                        <th class="disabled-sorting text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No Perjalanan</th>
                                        <th>Nama <small>(<i>Pemohon</i>)</small></th>
                                        <th>Waktu Berangkat</th>
                                        <th>Kendaraan</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Total</th>
                                        <th>Kasbon /<small> Bayar*</small></th>
                                        <th>Selisih</th>
                                        <th class="disabled-sorting text-center">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $p) : ?>
                                    <tr>
                                        <td><?= $p['id'].' - '.$p['jenis_perjalanan']; ?></td>
                                        <td><?= $p['nama']; ?></td>
                                        <td><?= date('d M', strtotime($p['tglberangkat'])) . ' - ' . date('H:i', strtotime($p['jamberangkat'])); ?></td>
                                        <td><?= $p['kepemilikan']; ?></td>
                                        <td><?= $p['anggota']; ?></td>
                                        <td><?= $p['tujuan']; ?></td>
                                        <td><?= number_format($p['total'], 0, ',', '.'); ?></td>
                                        <td><?= number_format($p['kasbon'], 0, ',', '.'); ?></td>
                                        <td><?= number_format($p['total']-$p['kasbon'], 0, ',', '.'); ?></td>
                                        <td class="text-right">
                                            <a href="<?= base_url('perjalanandl/payment/') . $p['id']; ?>" class="btn btn-sm btn-round btn-success">Proses</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
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