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
                                        <th>Tanggal Reservasi</th>
                                        <th>Nomor Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Anggota</th>
                                        <th>Tanggal Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Jam kembali</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Reservasi</th>
                                        <th>Tgl Reservasi</th>
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Anggota</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>Tgl Kembali</th>
                                        <th>Jam kembali</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($reservasi as $rsv) : ?>
                                        <tr>
                                            <td><?= $rsv['id']; ?></td>
                                            <td><?= $rsv['tglreservasi']; ?></td>
                                            <td><?= $rsv['nopol']; ?></td>
                                            <td><?= $rsv['kepemilikan']; ?></td>
                                            <td><?= $rsv['nama']; ?></td>
                                            <td><?= $rsv['tujuan']; ?></td>
                                            <td><?= $rsv['keperluan']; ?></td>
                                            <td><?= $rsv['anggota']; ?></td>
                                            <td><?= $rsv['tglberangkat']; ?></td>
                                            <td><?= $rsv['jamberangkat']; ?></td>
                                            <td><?= $rsv['tglkembali']; ?></td>
                                            <td><?= $rsv['jamkembali']; ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('perjalanandl/prosesdl1/') . $rsv['id']; ?>" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">done</i></a>
                                                <a href="<?= base_url('perjalanandl/bataldl/') . $rsv['id']; ?>" class="btn btn-link btn-danger btn-just-icon remove" data-toggle="modal" data-target="#rsvBataldl" data-rsv_id="<?= $rsv['id']; ?>"><i class="material-icons">close</i></a>
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
<!-- Modal -->
<div class="modal fade" id="rsvBataldl" tabindex="-1" role="dialog" aria-labelledby="rsvBataldlTitle" aria-hidden="true">
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
                <form class="form" method="post" action="<?= base_url('perjalanandl/bataldl/'); ?>">
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