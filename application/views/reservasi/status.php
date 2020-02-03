<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 ml-auto mr-auto">
                <ul class="timeline timeline-simple">
                    <a href="<?= base_url('reservasi')?>" class="btn btn-sm ">Kembali</a>
                    <?php if ($reservasi['status'] == 9) { ?>
                       <li class="timeline-inverted">
                            <div class="timeline-badge info">
                                <i class="material-icons">card_travel</i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <span class="badge badge-pill badge-info">Reservasi Perjalanan telah SELESAI</span>
                                </div>
                                <div class="timeline-body">
                                    <p>Terimakasih telah melakukan perjalanan menggunakan RAISA.</p>
                                </div>
                                <h6>
                                    <i class="ti-time"></i>
                                </h6>
                            </div>
                        </li>
                    <?php }; ?>
                    <?php if ($reservasi['status'] == 7) { ?>
                        <li class="timeline-inverted">
                            <div class="timeline-badge primary">
                                <i class="material-icons">card_travel</i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <span class="badge badge-pill badge-primary">Sedang Dalam Perjalanan</span>
                                </div>
                                <div class="timeline-body">
                                    <p>Sedang dalam perjalanan.</p>
                                </div>
                                <h6>
                                    <i class="ti-time"></i>
                                </h6>
                            </div>
                        </li>
                    <?php }; ?>
                    <?php if ($reservasi['status'] == 6) { ?>
                        <li class="timeline-inverted">
                            <div class="timeline-badge primary">
                                <i class="material-icons">card_travel</i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <span class="badge badge-pill badge-primary">Perjalanan Kamu Telah Siap</span>
                                </div>
                                <div class="timeline-body">
                                    <p>Yeay!! Reservasi kamu telah berhasil dan perjalanan kamu sudah siap untuk berangkat.</p>
                                </div>
                                <h6>
                                    <i class="ti-time"></i>
                                </h6>
                            </div>
                        </li>
                    <?php }; ?>
                    <?php if ($reservasi['status'] <= 5 and $reservasi['status'] != 0) { ?>
                        <li class="timeline-inverted">
                            <div class="timeline-badge warning">
                                <i class="material-icons">fingerprint</i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <span class="badge badge-pill badge-default">Menunggu Persetujuan GA</span>
                                </div>
                                <div class="timeline-body">
                                    Perjalanan kamu belum disetujui nih! bantuin RAISA colek bagian GA yuk!
                                </div>
                                <h6>
                                    <i class="ti-time"></i>
                                </h6>
                            </div>
                        </li>
                    <?php } else if ($reservasi['status'] > 5) { ?>
                        <li class="timeline-inverted">
                            <div class="timeline-badge success">
                                <i class="material-icons">fingerprint</i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <span class="badge badge-pill badge-success">Telah disetujui GA
                                </div>
                                <div class="timeline-body">
                                    Yeay!! Reservasi perjalanan kamu telah diproses oleh <?= $reservasi['admin_ga']; ?>
                                </div>
                                <h6>
                                    <i class="ti-time"></i>
                                </h6>
                            </div>
                        </li>
                    <?php }; ?>
                    <?php if ($reservasi['jenis_perjalanan'] == 'TA' or $reservasi['jenis_perjalanan'] == 'TAPP') { ?>
                        <?php if ($reservasi['status'] <= 3 and $reservasi['status'] != 0) { ?>
                            <li class="timeline-inverted">
                                <div class="timeline-badge warning">
                                    <i class="material-icons">fingerprint</i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="badge badge-pill badge-default">Menunggu Persetujuan FINANCE</span>
                                    </div>
                                    <div class="timeline-body">
                                        Perjalanan kamu belum disetujui nih! bantuin RAISA colek atasan kamu yuk!
                                    </div>
                                    <h6>
                                        <i class="ti-time"></i>
                                    </h6>
                                </div>
                            </li>
                        <?php } else if ($reservasi['status'] > 3) { ?>
                            <li class="timeline-inverted">
                                <div class="timeline-badge success">
                                    <i class="material-icons">fingerprint</i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="badge badge-pill badge-success">Telah disetujui FINANCE
                                    </div>
                                    <div class="timeline-body">
                                        Yeay!! Reservasi perjalanan kamu telah <?= $reservasi['fin_ttd']; ?>
                                    </div>
                                    <h6>
                                        <i class="ti-time"> <?= $reservasi['tgl_fin']; ?></i>
                                    </h6>
                                </div>
                            </li>
                        <?php }; ?>
                        <?php if ($reservasi['status'] <= 4 and $reservasi['status'] != 0) { ?>
                            <li class="timeline-inverted">
                                <div class="timeline-badge warning">
                                    <i class="material-icons">fingerprint</i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="badge badge-pill badge-default">Menunggu Persetujuan DIV HEAD</span>
                                    </div>
                                    <div class="timeline-body">
                                        Perjalanan kamu belum disetujui nih! bantuin RAISA colek atasan kamu yuk!
                                    </div>
                                    <h6>
                                        <i class="ti-time"></i>
                                    </h6>
                                </div>
                            </li>
                        <?php } else if ($reservasi['status'] > 4) { ?>
                            <li class="timeline-inverted">
                                <div class="timeline-badge success">
                                    <i class="material-icons">fingerprint</i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="badge badge-pill badge-success">Telah disetujui DIV HEAD
                                    </div>
                                    <div class="timeline-body">
                                        Yeay!! Reservasi perjalanan kamu telah <?= $reservasi['div_ttd']; ?>
                                    </div>
                                    <h6>
                                        <i class="ti-time"> <?= $reservasi['tgl_div']; ?></i>
                                    </h6>
                                </div>
                            </li>
                        <?php }; ?>
                    <?php }; ?>
                    <?php if (
                        $this->session->userdata['posisi_id'] == '7' or
                        $this->session->userdata['posisi_id'] == '10'
                    ) { ?>
                        <?php if ($reservasi['status'] <= 2 and $reservasi['status'] != 0) { ?>
                            <li class="timeline-inverted">
                                <div class="timeline-badge warning">
                                    <i class="material-icons">fingerprint</i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="badge badge-pill badge-default">Menunggu Persetujuan ATASAN 2 (<?= $reservasi['atasan2']; ?>)</span>
                                    </div>
                                    <div class="timeline-body">
                                        Perjalanan kamu belum disetujui nih! bantuin RAISA colek atasan kamu yuk!
                                    </div>
                                    <h6>
                                        <i class="ti-time"></i>
                                    </h6>
                                </div>
                            </li>
                        <?php } else if ($reservasi['status'] > 2) { ?>
                            <li class="timeline-inverted">
                                <div class="timeline-badge success">
                                    <i class="material-icons">fingerprint</i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="badge badge-pill badge-success">Telah disetujui ATASAN 2
                                    </div>
                                    <div class="timeline-body">
                                        Yeay!! Reservasi perjalanan kamu telah <?= $reservasi['atasan2']; ?>
                                    </div>
                                    <h6>
                                        <i class="ti-time"> <?= $reservasi['tgl_atasan2']; ?></i>
                                    </h6>
                                </div>
                            </li>
                        <?php }; ?>
                        <?php if ($reservasi['status'] == 1) { ?>
                            <li class="timeline-inverted">
                                <div class="timeline-badge warning">
                                    <i class="material-icons">fingerprint</i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="badge badge-pill badge-default">Menunggu Persetujuan ATASAN 1 (<?= $reservasi['atasan1']; ?>)</span>
                                    </div>
                                    <div class="timeline-body">
                                        Perjalanan kamu belum disetujui nih! bantuin RAISA colek atasan kamu yuk!
                                    </div>
                                    <h6>
                                        <i class="ti-time"></i>
                                    </h6>
                                </div>
                            </li>
                        <?php } elseif ($reservasi['status'] > 1) { ?>
                            <li class="timeline-inverted">
                                <div class="timeline-badge success">
                                    <i class="material-icons">fingerprint</i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="badge badge-pill badge-success">Telah disetujui ATASAN 1
                                    </div>
                                    <div class="timeline-body">
                                        Yeay!! Reservasi perjalanan kamu telah <?= $reservasi['atasan1']; ?>
                                    </div>
                                    <h6>
                                        <i class="ti-time"> <?= $reservasi['tgl_atasan1']; ?></i>
                                    </h6>
                                </div>
                            </li>
                        <?php }; ?>
                    <?php } else { ?>
                        <?php if ($reservasi['status'] <= 2 and $reservasi['status'] != 0) { ?>
                            <li class="timeline-inverted">
                                <div class="timeline-badge warning">
                                    <i class="material-icons">fingerprint</i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="badge badge-pill badge-default">Menunggu Persetujuan ATASAN 1 (<?= $reservasi['atasan1']; ?>)</span>
                                    </div>
                                    <div class="timeline-body">
                                        Perjalanan kamu belum disetujui nih! bantuin RAISA colek atasan kamu yuk!
                                    </div>
                                    <h6>
                                        <i class="ti-time"></i>
                                    </h6>
                                </div>
                            </li>
                        <?php } else if ($reservasi['status'] > 2) { ?>
                            <li class="timeline-inverted">
                                <div class="timeline-badge success">
                                    <i class="material-icons">fingerprint</i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="badge badge-pill badge-success">Telah disetujui ATASAN 1
                                    </div>
                                    <div class="timeline-body">
                                        Yeay!! Reservasi perjalanan kamu telah <?= $reservasi['atasan1']; ?>
                                    </div>
                                    <h6>
                                        <i class="ti-time"> <?= $reservasi['tgl_atasan1']; ?></i>
                                    </h6>
                                </div>
                            </li>
                        <?php }; ?>
                    <?php }; ?>
                    <?php if ($reservasi['status'] == 0) { ?>
                        <li class="timeline-inverted">
                            <div class="timeline-badge danger">
                                <i class="material-icons">card_travel</i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <span class="badge badge-pill badge-danger">Reservasi Perjalanan DIBATALKAN</span>
                                </div>
                                <div class="timeline-body">
                                    <p>Yaaahh, Perjalanan kamu dibatalkan.</p>
                                    <p><?= $reservasi['catatan']; ?></p>
                                </div>
                                <h6>
                                    <i class="ti-time"></i>
                                </h6>
                            </div>
                        </li>
                    <?php }; ?>
                    <li class="timeline-inverted">
                        <div class="timeline-badge primary">
                            <i class="material-icons">card_travel</i>
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <span class="badge badge-pill badge-primary">Pengajuan Perjalanan Dinas</span>
                            </div>
                            <div class="timeline-body">
                                <p>Jenis Perjalanan : <strong><?= $reservasi['jenis_perjalanan']; ?></strong></p>
                                <p>Kendaraan : <strong><?= $reservasi['nopol'] . ' (' . $reservasi['kepemilikan'] . ')'; ?></strong></p>
                                <p>Tujuan : <strong><?= $reservasi['tujuan']; ?></strong></p>
                                <p>Keperluan : <strong><?= $reservasi['keperluan']; ?></strong></p>
                                <p>Estimasi Waktu Keberangkatan : <strong><?= date('d/m/Y', strtotime($reservasi['tglberangkat'])); ?> <?= date('H:i', strtotime($reservasi['jamberangkat'])); ?></strong></p>
                                <p>Estimasi Waktu Kembali : <strong><?= date('d/m/Y', strtotime($reservasi['tglkembali'])); ?> <?= date('H:i', strtotime($reservasi['jamkembali'])); ?></strong></p>
                            </div>
                            <h6>
                                <i class="ti-time"></i> <?= date('d/m/Y H:i', strtotime($reservasi['tglreservasi'])); ?>
                            </h6>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>