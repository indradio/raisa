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
                                                    <?php if ($pdetail['status'] == 1) { ?>
                                                        <a href="<?= base_url('perjalanandl/tambahwaktudl/') . $pdetail['id']; ?>" class="badge badge-warning">+2 JAM</a>
                                                        <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#batalDl" data-id="<?= $pdetail['id']; ?>">BATALKAN</a>
                                                    <?php } elseif ($pdetail['status'] == 9) { ?>
                                                        <a href="<?= base_url('perjalanandl/suratjalan/') . $pdetail['id']; ?>" class="btn btn-link btn-info btn-just-icon" target="_blank"><i class="material-icons">print</i></a>
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