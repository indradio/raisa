<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 align-content-start">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">update</i>
                        </div>
                        <h4 class="card-title">Rencana Aktivitas Lembur</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <label class="col-md-1 col-form-label">Lembur ID</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id" value="<?= $lembur['id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Tanggal Mulai</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datetimepicker disabled" id="tglmulai" name="tglmulai" value="<?= $lembur['tglmulai']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Tanggal Selesai</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datetimepicker disabled" id="tglselesai" name="tglselesai" value="<?= $lembur['tglselesai']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="#" class="btn btn-rose mb-2" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">Tambah Aktivitas</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Aktivitas</th>
                                        <th>Tanggal</th>
                                        <th>Kategori</th>
                                        <th>COPRO</th>
                                        <th>WBS</th>
                                        <th>Rencana Aktivitas</th>
                                        <th>Realisasi Aktivitas</th>
                                        <th>Durasi/Jam</th>
                                        <th>Hasil</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                        <th class="disabled-sorting"></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Aktivitas</th>
                                        <th>Tanggal</th>
                                        <th>Kategori</th>
                                        <th>COPRO</th>
                                        <th>WBS</th>
                                        <th>Rencana Aktivitas</th>
                                        <th>Realisasi Aktivitas</th>
                                        <th>Durasi/Jam</th>
                                        <th>Hasil</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                        <th class="disabled-sorting"></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($aktivitas as $a) : ?>
                                        <tr>
                                            <td><?= $a['id']; ?></td>
                                            <td><?= date('d/m/Y', strtotime($a['tanggal'])); ?></td>
                                            <td><?= $a['kategori']; ?></td>
                                            <td><?= $a['copro']; ?></td>
                                            <td><?= $a['wbs']; ?></td>
                                            <td><?= $a['rencana_aktivitas']; ?></td>
                                            <td><?= $a['realisasi_aktivitas']; ?></td>
                                            <td><?= $a['durasi']; ?></td>
                                            <td><?= $a['hasil']; ?></td>
                                            <td><?= $a['status']; ?></td>
                                            <td></td>
                                            <td></td>
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
<div class="modal fade" id="tambahAktivitas" tabindex="-1" role="dialog" aria-labelledby="tambahAktivitasTitle" aria-hidden="true">
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
                            <label class="col-md-4 col-form-label">Kategori</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="kategori" data-style="select-with-transition" title="Pilih" data-size="3" required>
                                        <?php foreach ($kategori as $k) : ?>
                                            <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">COPRO</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="copro" data-style="select-with-transition" title="Pilih" data-size="7" required>
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
                            <label class="col-md-4 col-form-label">WBS</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="wbs" data-style="select-with-transition" title="Pilih" data-size="10" required>
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
                            <label class="col-md-4 col-form-label">Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="wbs" data-style="select-with-transition" title="Pilih" data-size="10" required>
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
                            <label class="col-md-4 col-form-label">Aktivitas Lain</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control disabled" name="aktivitas"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary">SELANJUTNYA</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">KEMBALI</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>