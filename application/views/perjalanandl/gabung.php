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
                                        <th>Nomor Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tanggal Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Jam kembali</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Reservasi</th>
                                        <th>Jenis Perjalanan</th>
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>Tgl Kembali</th>
                                        <th>Jam kembali</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($reservasi as $r) : ?>
                                        <?php if ($r['tglberangkat'] < date('Y-m-d')) { ?>
                                            <tr class="text-dark bg-danger">
                                            <?php } else { ?>
                                            <tr>
                                            <?php }; ?>
                                            <td><?= $r['id']; ?></td>
                                            <td><?= $r['jenis_perjalanan']; ?></td>
                                            <td><?= $r['nopol']; ?></td>
                                            <td><?= $r['kepemilikan']; ?></td>
                                            <td><?= $r['nama']; ?></td>
                                            <td><?= $r['tujuan']; ?></td>
                                            <td><?= $r['keperluan']; ?></td>
                                            <td><?= $r['anggota']; ?></td>
                                            <td><?= $r['tglberangkat']; ?></td>
                                            <td><?= $r['jamberangkat']; ?></td>
                                            <td><?= $r['tglkembali']; ?></td>
                                            <td><?= $r['jamkembali']; ?></td>
                                            <td><?= $r['catatan']; ?></td>
                                            <?php $rstatus = $this->db->get_where('reservasi_status', ['id' => $r['status']])->row_array(); ?>
                                            <td><?= $rstatus['nama']; ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('perjalanandl/gabungrsv/') . $rsvid . '/' . $r['id']; ?>" class="btn btn-sm btn-round btn-success">PILIH</a>
                                            </td>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $p) : ?>
                                        <?php if ($p['tglberangkat'] < date('Y-m-d')) { ?>
                                            <tr class="text-dark bg-danger">
                                            <?php } else { ?>
                                            <tr>
                                            <?php }; ?>
                                            <td><?= $p['id']; ?></td>
                                            <td><?= $p['jenis_perjalanan']; ?></td>
                                            <td><?= $p['nopol']; ?></td>
                                            <td><?= $p['kepemilikan']; ?></td>
                                            <td><?= $p['nama']; ?></td>
                                            <td><?= $p['tujuan']; ?></td>
                                            <td><?= $p['keperluan']; ?></td>
                                            <td><?= $p['anggota']; ?></td>
                                            <td><?= $p['tglberangkat']; ?></td>
                                            <td><?= $p['jamberangkat']; ?></td>
                                            <td><?= $p['tglkembali']; ?></td>
                                            <td><?= $p['jamkembali']; ?></td>
                                            <td><?= $p['catatan_security']; ?></td>
                                            <?php $pstatus = $this->db->get_where('perjalanan_status', ['id' => $p['status']])->row_array(); ?>
                                            <td><?= $pstatus['nama']; ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('perjalanandl/gabungdl/') . $rsvid . '/' . $p['id']; ?>" class="btn btn-sm btn-round btn-success">PILIH</a>
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