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
                            <a href="#" class="btn btn-rose mb-2" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahLembur">Rencana Lembur Baru</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Jenis Lembur</th>
                                        <th>Tgl Mengajukan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Jam Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th>Atasan 1</th>
                                        <th>Atasan 2</th>
                                        <th>Admin GA</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                        <th class="disabled-sorting"></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Reservasi</th>
                                        <th>Jenis Lembur</th>
                                        <th>Tgl Mengajukan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Jam Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th>Atasan 1</th>
                                        <th>Atasan 2</th>
                                        <th>Admin GA</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                        <th class="disabled-sorting"></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($lembur as $l) : ?>
                                    <tr>
                                        <td><?= $l['id']; ?></td>
                                        <td><?= $l['jenis_lembur']; ?></td>
                                        <td><?= $l['tglpengajuan']; ?></td>
                                        <td><?= date('d/m/Y', strtotime($l['tglmulai'])); ?></td>
                                        <td><?= date('H:i', strtotime($l['tglmulai'])); ?></td>
                                        <td><?= date('d/m/Y', strtotime($l['tglselesai'])); ?></td>
                                        <td><?= date('H:i', strtotime($l['tglselesai'])); ?></td>
                                        <td><?= $l['durasi']; ?></td>
                                        <td><?= $l['atasan1']; ?></td>
                                        <td><?= $l['atasan2']; ?></td>
                                        <td><?= $l['admin_ga']; ?></td>
                                        <td><?= $l['catatan']; ?></td>
                                        <?php $status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array(); ?>
                                        <td><?= $status['nama']; ?></td>
                                        <td>
                                            <a href="<?= base_url('lembur/detail/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
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
                <form class="form" method="post" action="<?= base_url('lembur/tambah'); ?>">
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-md-4 col-form-label">Jenis Lembur</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="jenis" data-style="select-with-transition" title="Pilih" data-size="3" required>
                                        <?php
                                        $queryJenis = "SELECT *
                                                                    FROM `lembur_jenis`
                                                                    ORDER BY `id` ASC
                                                                    ";
                                        $jenis = $this->db->query($queryJenis)->result_array();
                                        foreach ($jenis as $j) : ?>
                                        <option value="<?= $j['id']; ?>"><?= $j['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Tanggal Mulai</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datetimepicker" id="tglmulai" name="tglmulai" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Tanggal Selesai</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datetimepicker" id="tglselesai" name="tglselesai" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary">SELANJUTNYA</button>
                            <a href="<?= base_url('lembur/rencana'); ?>" class="btn btn-fill btn-default">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>