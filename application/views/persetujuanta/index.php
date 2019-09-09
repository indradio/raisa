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
                            <table id="tableTa" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Reservasi</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Nomor Polisi</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>Tgl Kembali</th>
                                        <th>Jam Kembali</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Reservasi</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Nomor Polisi</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>Tgl Kembali</th>
                                        <th>Jam Kembali</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    if ($karyawan['posisi_id'] == '2') {
                                        $queryRsv = "SELECT *
                                            FROM `reservasi`
                                            WHERE (`jenis_perjalanan` = 'TAPP' or `jenis_perjalanan` = 'TA') and (`status` = 5 or `status` = 6)
                                            ORDER BY `id` DESC
                                            ";
                                    } elseif ($karyawan['posisi_id'] == '3') {
                                        $queryRsv = "SELECT *
                                            FROM `reservasi`
                                            WHERE (`jenis_perjalanan` = 'TAPP' or `jenis_perjalanan` = 'TA') and `status` = 5
                                            ORDER BY `id` DESC
                                            ";
                                    }
                                    $reservasi = $this->db->query($queryRsv)->result_array();
                                    foreach ($reservasi as $rsv) : ?>
                                        <tr>
                                            <td><?= $rsv['id']; ?></td>
                                            <td><?= $rsv['nama']; ?></td>
                                            <td><?= $rsv['tujuan']; ?></td>
                                            <td><?= $rsv['keperluan']; ?></td>
                                            <td><?= $rsv['anggota']; ?></td>
                                            <td><?= $rsv['nopol']; ?></td>
                                            <td><?= $rsv['kepemilikan']; ?></td>
                                            <td><?= $rsv['tglberangkat']; ?></td>
                                            <td><?= $rsv['jamberangkat']; ?></td>
                                            <td><?= $rsv['tglkembali']; ?></td>
                                            <td><?= $rsv['jamkembali']; ?></td>
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
<div class="modal fade" id="modalTa" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-rose text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Persetujuan Perjalanan Dinas TA</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form" method="post" action="<?= base_url('persetujuanta/setujuta'); ?>">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-4 col-form-label">Nomor Reservasi</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Nama</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nama">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Tujuan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tujuan">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Keperluan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control disabled" name="keperluan"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Peserta</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="anggota">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Nomor Polisi</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nopol">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Jenis Kendaraan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="kepemilikan">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Tanggal Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tglberangkat">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Jam Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="jamberangkat">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Tanggal Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tglkembali">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Jam Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="jamkembali">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn btn-link btn-danger" data-toggle="modal" data-target="#rsvBatal">BATALKAN!</a>
                                <button type="submit" class="btn btn-fill btn-success">SETUJUI</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>