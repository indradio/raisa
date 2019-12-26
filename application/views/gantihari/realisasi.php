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
                        <h4 class="card-title">Realisasi Ganti Hari</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <!-- <a href="#" class="btn btn-rose mb-2" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahLembur">Rencana Lembur Baru</a>
                        </div> -->
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
                                        <th class="disabled-sorting"></th>
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
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($gantihari as $l) : ?>
                                        <tr>
                                            <td><?= $l['id']; ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($l['tglpengajuan'])); ?></td>
                                                <?php if($l['status']== '4') {?>
                                            <td><?= date('d/m/Y H:i', strtotime($l['tglmulai'])); ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($l['tglselesai'])); ?></td>
                                            <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                                                <?php } else { ?>
                                            <td><?= date('d/m/Y H:i', strtotime($l['tglmulai_aktual'])); ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($l['tglselesai_aktual'])); ?></td>
                                            <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                                                <?php }; ?>
                                            <?php $status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array(); ?>
                                            <td><?= $status['nama']; ?></td>
                                            <td>
                                                <a href="<?= base_url('gantihari/realisasi_aktivitas/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                                            </td>
                                            <td class="text-right">
                                                <?php if ($l['status'] == 1 or $l['status'] == 2 or $l['status'] == 3) { ?>
                                                    <a href="#" class="btn btn-link btn-danger btn-just-icon remove" data-toggle="modal" data-target="#batalRsv" data-id="<?= $l['id']; ?>"><i class="material-icons">close</i></a>
                                                <?php } else { ?>
                                                    <a href="#" class="btn btn-link btn-danger btn-just-icon remove disabled"><i class="material-icons">close</i></a>
                                                <?php }; ?>
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
<!-- Modal -->
