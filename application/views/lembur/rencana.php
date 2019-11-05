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
                        <div class="toolbar text-right mb-2">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="<?= base_url('lembur/tambah'); ?>" class="btn btn-rose" role="button" aria-disabled="false">Rencana Lembur Hari ini</a>
                            <a href="#" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahLembur">Rencana Lembur Hari Lain</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Tgl Mengajukan</th>
                                        <th>Tanggal/Jam Mulai</th>
                                        <th>Tanggal/Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Tgl Mengajukan</th>
                                        <th>Tanggal/Jam Mulai</th>
                                        <th>Tanggal/Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($lembur as $l) : ?>
                                        <tr>
                                            <td><?= $l['id']; ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($l['tglpengajuan'])); ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($l['tglmulai'])); ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($l['tglselesai'])); ?></td>
                                            <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
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
                        <button type="submit" class="btn btn-sm btn-danger">BATALKAN LEMBUR INI!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Lembur Hari Lain Aktivitas-->
<div class="modal fade" id="tambahLembur" tabindex="-1" role="dialog" aria-labelledby="tambahLemburTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">RENCANA LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/tambah_harilain'); ?>">
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-md-4 col-form-label">Tanggal Mulai</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datetimepicker" id="tglmulai" name="tglmulai" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-primary">SELANJUTNYA</button>
                            <a href="<?= base_url('lembur/rencana'); ?>" class="btn btn-sm btn-fill btn-default">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>