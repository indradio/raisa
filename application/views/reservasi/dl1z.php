    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">directions_car</i>
                            </div>
                            <h4 class="card-title">Jadwal keberangkatan</h4>
                        </div>
                        <div class="card-body ">
                            <form class="form-horizontal" action="<?= base_url('reservasi/dl1z_proses'); ?>" method="post">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Jenis Perjalanan</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="jperj" value="<?= $reservasi_temp['jenis_perjalanan']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Nomor Polisi</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="nopol" value="<?= $reservasi_temp['nopol'] . ' (' . $reservasi_temp['kepemilikan'] . ')'; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Tanggal Keberangkatan</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="tglberangkat" name="tglberangkat" value="<?= date("d / m / Y", strtotime($reservasi_temp['tglberangkat'])); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Jam Keberangkatan</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <input type="time" class="form-control disabled" id="jamberangkat" name="jamberangkat" value="<?= $reservasi_temp['jamberangkat']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Tanggal Kembali</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="tglkembali" name="tglkembali" value="<?= date("d / m / Y", strtotime($reservasi_temp['tglkembali'])); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Jam Kembali</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <input type="time" class="form-control disabled" id="jamkembali" name="jamkembali" value="<?= $reservasi_temp['jamkembali']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Tujuan</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="tujuan" value="<?= $reservasi_temp['tujuan']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Keperluan</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <textarea rows="2" class="form-control disabled" name="keperluan"><?= $reservasi_temp['keperluan']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Peserta</label>
                                    <div class="col-md-5">
                                        <div class="material-datatables">
                                            <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Inisial</th>
                                                        <th>Nama</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $queryAnggota = "SELECT *
                                                        FROM `perjalanan_anggota`
                                                        WHERE `reservasi_id` = '{$reservasi_temp['id']}'
                                                        ";
                                                    $anggota = $this->db->query($queryAnggota)->result_array();
                                                    foreach ($anggota as $ang) : ?>
                                                        <tr>
                                                            <td><?= $ang['karyawan_inisial']; ?></td>
                                                            <td><?= $ang['karyawan_nama']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <button type="submit" class="btn btn-fill btn-rose">Selesai</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>