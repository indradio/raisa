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
                            <a href="<?= base_url('reservasi/dl'); ?>" class="btn btn-facebook mb-2" role="button" aria-disabled="false">Buat Pejalanan Dinas</a>
                        </div>
                        <div class="material-datatables">
                            <table id="dtdesc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Jenis</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Berangkat</th>
                                        <th>Kembali</th>
                                        <th>Kendaraan</th>
                                        <th>Nopol</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Jenis</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Berangkat</th>
                                        <th>Kembali</th>
                                        <th>Kendaraan</th>
                                        <th>Nopol</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                                  $this->db->where('status >=' , '1');
                                                  $this->db->where('status <' , '9');
                                    $perjalanan = $this->db->get_where('perjalanan', ['npk' => $this->session->userdata('npk')])->result_array();
                                    foreach ($perjalanan as $row) : ?>
                                            <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td><?= $row['jenis_perjalanan']; ?></td>
                                                <td><?= $row['tujuan']; ?></td>
                                                <td><?= $row['keperluan']; ?></td>
                                                <td><?= $row['anggota']; ?></td>
                                                <td><?= date('d M - ', strtotime($row['tglberangkat'])); ?> <?= date('H:i', strtotime($row['jamberangkat'])); ?></td>
                                                <td><?= date('d M - ', strtotime($row['tglkembali'])); ?> <?= date('H:i', strtotime($row['jamkembali'])); ?></td>
                                                <td><?= $row['kepemilikan']; ?></td>
                                                <td><?= $row['nopol']; ?></td>
                                                <?php $status = $this->db->get_where('perjalanan_status', ['id' => $row['status']])->row_array(); ?>
                                                <td><?= $status['nama']; ?></td>
                                                <td class="text-right">
                                                    <?php if ($row['status'] == 1) { ?>
                                                        <a href="<?= base_url('perjalanandl/tambahwaktudl/') . $row['id']; ?>" class="btn btn-sm btn-warning">+1 JAM</a>
                                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#batalDl" data-id="<?= $row['id']; ?>">BATALKAN</a>
                                                    <?php } elseif ($row['status'] == 3) { ?>
                                                        <a href="<?= base_url('perjalanan/penyelesaian/' . $row['id']); ?>" class="btn btn-sm btn-success">Penyelesaian</a>
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
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Jenis DL</th>
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Nama <small>(<i>Pemohon</i>)</small></th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Keberangkatan</th>
                                        <th>Kembali</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Jenis DL</th>
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Keberangkatan</th>
                                        <th>Kembali</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $perjalanan = $this->db->get_where('perjalanan_anggota', ['npk' => $this->session->userdata('npk')])->result_array();
                                    foreach ($perjalanan as $pdl) :
                                        $rsvid = $pdl['perjalanan_id'];
                                        if ($rsvid != null) {
                                            $pdetail = $this->db->get_where('perjalanan', ['id' => $rsvid])->row_array(); ?>
                                            <tr>
                                                <td><?= $pdetail['id']; ?></td>
                                                <td><?= $pdetail['jenis_perjalanan']; ?></td>
                                                <td><?= $pdetail['nopol']; ?></td>
                                                <td><?= $pdetail['kepemilikan']; ?></td>
                                                <td><?= $pdetail['nama']; ?></td>
                                                <td><?= $pdetail['tujuan']; ?></td>
                                                <td><?= $pdetail['keperluan']; ?></td>
                                                <td><?= $pdetail['anggota']; ?></td>
                                                <td><?= date('d/m/Y', strtotime($pdetail['tglberangkat'])); ?> <?= date('H:i', strtotime($pdetail['jamberangkat'])); ?></td>
                                                <td><?= date('d/m/Y', strtotime($pdetail['tglkembali'])); ?> <?= date('H:i', strtotime($pdetail['jamkembali'])); ?></td>
                                                <td><?= $pdetail['catatan']; ?></td>
                                                <?php $status = $this->db->get_where('perjalanan_status', ['id' => $pdetail['status']])->row_array(); ?>
                                                <td><?= $status['nama']; ?></td>
                                                <td class="text-right">
                                                    <?php if ($pdetail['status'] == 9) { ?>
                                                        <a href="<?= base_url('perjalanandl/suratjalan/') . $pdetail['id']; ?>" class="btn btn-link btn-info btn-just-icon" target="_blank"><i class="material-icons">print</i></a>
                                                    <?php } else { ?>
                                                        <a href="#" class="btn btn-link btn-info btn-just-icon disabled"><i class="material-icons">print</i></a>
                                                    <?php }; ?>
                                                </td>
                                            </tr>
                                        <?php }; ?>
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
<div class="modal fade" id="batalDl" tabindex="-1" role="dialog" aria-labelledby="batalDlTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">ALASAN PEMBATALAN</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('perjalanandl/bataldl'); ?>">
                    <div class="modal-body">
                        <input type="text" class="form-control disabled" name="id" hidden>
                        <textarea rows="3" class="form-control" name="catatan" placeholder="Contoh : Tidak jadi berangkat" required></textarea>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-danger">BATALKAN!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>