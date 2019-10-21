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
                        <h4 class="card-title">Rencana Lembur</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="<?= base_url('lembur/tambah'); ?>" class="btn btn-rose" role="button" aria-disabled="false">Rencana Lembur Baru</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Tgl Mengajukan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Jam Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th>Atasan 1</th>
                                        <th>Atasan 2</th>
                                        <th>Admin GA</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Tgl Mengajukan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Jam Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th>Atasan 1</th>
                                        <th>Atasan 2</th>
                                        <th>Admin GA</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($lembur as $l) : ?>
                                        <tr>
                                            <td><?= $l['id']; ?></td>
                                            <td><?= $l['tglpengajuan']; ?></td>
                                            <td><?= date('d/m/Y', strtotime($l['tglmulai'])); ?></td>
                                            <td><?= date('H:i', strtotime($l['tglmulai'])); ?></td>
                                            <td><?= date('d/m/Y', strtotime($l['tglselesai'])); ?></td>
                                            <td><?= date('H:i', strtotime($l['tglselesai'])); ?></td>
                                            <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                                            <td><?= $l['atasan1_rencana']; ?></td>
                                            <td><?= $l['atasan2_rencana']; ?></td>
                                            <td><?= $l['admin_ga']; ?></td>
                                            <?php $status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array(); ?>
                                            <td><?= $status['nama']; ?></td>
                                            <td>
                                                <a href="<?= base_url('lembur/rencana_aktivitas/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
</div>
<!-- Modal Batal Aktivitas-->
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">ALASAN PEMBATALAN</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/batal_lembur'); ?>">
                    <div class="modal-body">
                        <input type="text" class="form-control disabled" name="id">
                        <textarea rows="2" class="form-control" name="catatan" id="catatan" placeholder="Keterangan Pembatalan Lembur" required></textarea>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-danger">BATALKAN LEMBUR INI!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>