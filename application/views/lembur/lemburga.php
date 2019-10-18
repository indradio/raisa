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
                        <h4 class="card-title">Data Lembur</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <form action="<?= base_url('lembur/cari_lembur_ga'); ?>" method="post">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Dari Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglmulai" name="tglmulai">
                                        </div>
                                    </div>
                                    <label class="col-md-2 col-form-label">Sampai Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglselesai" name="tglselesai">
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-rose">Cari</a>
                                    </div>
                                </div>
                            </form>
                            <table id="dtperjalanan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th>No. Lembur</th>
                                    <th>NPK</th>
                                    <th>Nama</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Jam Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Jam Selesai</th>
                                    <th>Durasi/Jam</th>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                    <th class="disabled-sorting"></th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>No. Lembur</th>
                                    <th>NPK</th>
                                    <th>Nama</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Jam Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Jam Selesai</th>
                                    <th>Durasi/Jam</th>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                    <th class="text-right">Actions</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php foreach ($lembur as $l) : ?>
                                    <tr>
                                    <td><?= $l['id']; ?></td>
                                    <td><?= $l['npk']; ?></td>
                                    <td><?= $l['nama']; ?></td>
                                    <td><?= date('d/m/Y', strtotime($l['tglmulai'])); ?></td>
                                    <td><?= date('H:i', strtotime($l['tglmulai'])); ?></td>
                                    <td><?= date('d/m/Y', strtotime($l['tglselesai'])); ?></td>
                                    <td><?= date('H:i', strtotime($l['tglselesai'])); ?></td>
                                    <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                                    <td><?= $l['catatan']; ?></td>
                                    <?php $status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array(); ?>
                                    <td><?= $status['nama']; ?></td>
                                    <td>
                                        <?php if ($l['status'] == 4 or $l['status'] == 5 or $l['status'] == 6) { ?>
                                            <a href="<?= base_url('lembur/realisasi_aktivitas/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                                        <?php }else if ($l['status'] == 7 or $l['status'] == 9 ) { ?>
                                            <a href="<?= base_url('lembur/realisasi_aktivitas/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                                        <?php } else { ?>
                                            <a href="<?= base_url('lembur/rencana_aktivitas/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                                        <?php }; ?>
                                        
                                    </td>
                                    <td class="text-right">
                                        <?php if ($l['status'] == 9 ) { ?>
                                            <a href="<?= base_url('lembur/laporan_lembur/') . $l['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit" target="_blank"><i class="material-icons">dvr</i></a>
                                        <?php } else { ?>
                                            <a href="<?= base_url('lembur/laporan_lembur/') . $l['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit disabled"><i class="material-icons">dvr</i></a>
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
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->