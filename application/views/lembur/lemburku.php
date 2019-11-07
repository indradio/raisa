<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
                        <h4 class="card-title">Data Lembur</h4>
                    </div>
                    <form class="form" method="post" action="<?= base_url('lembur/ajukan_realisasi'); ?>">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="row col-md-6">
                                    <div class="row" hidden>
                                        <label class="col-md-5 col-form-label">Lembur ID</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <input type="text" class="form-control disabled" id="id" name="id" value="<?= $lembur['id']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <label class="col-ml-5 col-form-label">Tanggal Mulai</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <input type="text" class="form-control datetimepicker disabled" id="tglmulai_aktual" name="tglmulai_aktual" value="<?= $lembur['tglmulai_aktual']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <label class="col-ml-5 col-form-label">Tanggal Selesai</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <input type="text" class="form-control datetimepicker disabled" id="tglselesai_aktual" name="tglselesai_aktual" value="<?= $lembur['tglselesai_aktual']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <label class="col-ml-5 col-form-label">Total Aktivitas</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <?php
                                                $lid = $lembur['id'];
                                                $queryLembur = "SELECT COUNT(*)
                                                    FROM `aktivitas`
                                                    WHERE `link_aktivitas` = '$lid' ";
                                                $totalLembur = $this->db->query($queryLembur)->row_array();
                                                $totalAktivitas = $totalLembur['COUNT(*)'];; ?>
                                                <input type="text" class="form-control disabled" id="total_aktivitas" name="total_aktivitas" value="<?= $totalAktivitas; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="row col-md-6">
                                <div class="row col-md-12">
                                    <label class="col-ml-5 col-form-label">Lokasi Lembur</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <?php $lokasi = $this->db->get_where('lembur_lokasi', ['id' => $lembur['lokasi_id']])->row_array(); ?>
                                                <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="<?= $lokasi['nama']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <label class="col-ml-5 col-form-label">Durasi Lembur</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= $lembur['durasi_aktual']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <label class="col-ml-5 col-form-label">Status</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <?php $status = $this->db->get_where('lembur_status', ['id' => $lembur['status']])->row_array(); ?>
                                                <input type="text" class="form-control disabled" id="status" name="status" value="<?= $status['nama']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <!-- <th>No. Aktivitas</th> -->
                                            <th>jenis Aktivitas</th>
                                            <th>Kategori</th>
                                            <th>COPRO</th>
                                            <!-- <th>WBS</th> -->
                                            <th>Rencana Aktivitas</th>
                                            <th>Durasi/Jam</th>
                                            <th>Deskripsi Aktual</th>
                                            <th>Hasil</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <!-- <th>No. Aktivitas</th> -->
                                            <th>jenis Aktivitas</th>
                                            <th>Kategori</th>
                                            <th>COPRO</th>
                                            <!-- <th>WBS</th> -->
                                            <th>Rencana Aktivitas</th>
                                            <th>Durasi/Jam</th>
                                            <th>Deskripsi Aktual</th>
                                            <th>Hasil</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($aktivitas as $a) : ?>
                                            <tr>
                                                <!-- <td><?= $a['id']; ?></td> -->
                                                <td><?= $a['jenis_aktivitas']; ?></td>
                                                <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                                <td><?= $k['nama']; ?></td>
                                                <td><?= $a['copro']; ?></td>
                                                <!-- <td><?= $a['wbs']; ?></td> -->
                                                <td><?= $a['aktivitas']; ?></td>
                                                <td><?= $a['durasi']; ?> jam</td>
                                                <td><?= $a['deskripsi_hasil']; ?></td>
                                                <td><?= $a['progres_hasil']; ?> %</td>
                                                <?php $status = $this->db->get_where('aktivitas_status', ['id' => $a['status']])->row_array(); ?>
                                                <td><?= $status['nama']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <a href="<?= base_url('lembur/index/') ?>" class="btn btn-default" role="button">Kembali</a>
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
</form>