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
                        <h4 class="card-title">Persetujuan HR</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Nama</th>
                                        <th>Tanggal/Jam Mulai</th>
                                        <th>Tanggal/Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                        <th class="disabled-sorting"></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Nama</th>
                                        <th>Tanggal/Jam Mulai</th>
                                        <th>Tanggal/Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th class="text-right">Actions</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($lembur as $l) : ?>
                                        <tr>
                                            <td><?= $l['id']; ?></td>
                                            <td><?= $l['nama']; ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($l['tglmulai_aktual'])); ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($l['tglselesai_aktual'])); ?></td>
                                            <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                                            <td class="text-right">
                                                <a href="<?= base_url('lembur/setujui_hr/'). $l['id']; ?>" class="badge badge-pill badge-success">Setujui</i></a> 
                                            </td>
                                            <td>
                                                <a href="<?= base_url('lembur/detailAktivitasHR/'). $l['id']; ?>" class="badge badge-pill badge-info">Detail</i></a> 
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
