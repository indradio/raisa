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
                        <h4 class="card-title">Realisasi Aktivitas Lembur</h4>
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
                                    <?php if ($lembur['durasi_aktual']== NULL) { ?>
                                        <div class="row col-md-12">
                                            <label class="col-ml-5 col-form-label"></label>
                                            <div class="col-md-7">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <a href="#" class="badge badge-pill badge-info" data-toggle="modal" data-target="#ubhTanggal" data-id="<?= $lembur['id']; ?>">GANTI JAM</a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }; ?>
                                    <div class="row col-md-12">
                                        <label class="col-ml-5 col-form-label">Tanggal Selesai</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <input type="text" class="form-control datetimepicker disabled" id="tglselesai_aktual" name="tglselesai_aktual" value="<?= $lembur['tglselesai_aktual']; ?>">
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
                                        <label class="col-ml-5 col-form-label">Total Aktivitas</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <?php
                                                $lid = $lembur['id'];
                                                $queryLembur = "SELECT COUNT(*)
                                                    FROM `aktivitas`
                                                    WHERE `link_aktivitas` = '$lid' ";
                                                $totalLembur = $this->db->query($queryLembur)->row_array();
                                                $totalAktivitas = $totalLembur['COUNT(*)']; ?>
                                                <input type="text" class="form-control disabled" id="total_aktivitas" name="total_aktivitas" value="<?= $totalAktivitas; ?>">
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
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                                <?php if ($lembur['status'] == '13' or $lembur['status'] == '12' or $lembur['status'] == '7' or $lembur['status'] == '6' or $lembur['status'] == '5') { ?>
                                    <!-- <a href="#" class="btn btn-rose mb disabled" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">Tambah Aktivitas</a> -->
                                <?php } else { ?>
                                    <a href="#" class="btn btn-rose mb" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">Tambah Aktivitas</a>
                                <?php }; ?>
                            </div>
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
                                            <th class="text-right">Actions</th>
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
                                            <th class="text-right">Actions</th>
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
                                                <td class="text-right">
                                                    <?php if ($lembur['status'] == '9' OR $lembur['status'] == '7' OR $lembur['status'] == '6' OR $lembur['status'] == '5' OR $a['status'] == '0') { ?>
                                                        <!-- <a href="#" data-toggle="modal" data-target="#realisasiAktivitas" data-id="<?= $a['id']; ?>" data-aktivitas="<?= $a['aktivitas']; ?>" class="badge badge-pill badge-success disabled">Ralisasi</a>
                                                        <a href="<?= base_url('lembur/batal_aktivitas/') . $a['id']; ?>" class="badge badge-pill badge-danger disabled">Batal dikerjakan</a> -->
                                                    <?php } else if ($a['status'] == '9' OR $a['status'] == '3' OR $a['status'] == '2') { ?>
                                                        <!-- <a href="#" data-toggle="modal" data-target="#realisasiAktivitas" data-id="<?= $a['id']; ?>" data-aktivitas="<?= $a['aktivitas']; ?>" class="badge badge-pill badge-success disabled">Ralisasi</a>
                                                        <a href="<?= base_url('lembur/batal_aktivitas/') . $a['id']; ?>" class="badge badge-pill badge-danger disabled">Batal dikerjakan</a> -->
                                                    <?php } else { ?>
                                                        <a href="#" data-toggle="modal" data-target="#realisasiAktivitas" data-id="<?= $a['id']; ?>" data-aktivitas="<?= $a['aktivitas']; ?>" class="badge badge-pill badge-success">Realisasi</a>
                                                        <a href="<?= base_url('lembur/batal_aktivitas/') . $a['id']; ?>" class="badge badge-pill badge-danger">Batal dikerjakan</a>
                                                    <?php }; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php if ($lembur['status'] == '4' and $a['status'] == '1') { ?>
                                    <button type="submit" id="ajukan" class="btn btn-sm btn-success disabled">LAPORKAN</button>
                                <?php } else if ($lembur['status'] == '5' OR $lembur['status'] == '6' OR $lembur['status'] == '7' OR $lembur['status'] == '9' OR $lembur['status'] == '12' OR $lembur['status'] == '13') { ?>
                                    <!-- <button type="submit"  id="ajukan" class="btn btn-success disabled">LAPORKAN</button> -->
                                <?php } else { ?>
                                    <button type="submit" id="ajukan" class="btn btn-sm btn-success">LAPORKAN</button>
                                <?php }; ?>
                                <a href="<?= base_url('lembur/realisasi/') ?>" class="btn btn-sm btn-default" role="button">Kembali</a>
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
<!-- Modal -->

<!-- Realisasi Aktivitas -->
<div class="modal fade" id="realisasiAktivitas" tabindex="-1" role="dialog" aria-labelledby="realisasiAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">REALISASI LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/tambah_realisasi'); ?>">
                    <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Lembur ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $lembur['id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">No Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Rencana aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="aktivitas" name="aktivitas">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Deskripsi Hasil</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="deskripsi_hasil" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <option value="+30 minute">00:30:00</option>
                                        <option value="+60 minute">01:00:00</option>
                                        <option value="+90 minute">01:30:00</option>
                                        <option value="+120 minute">02:00:00</option>
                                        <option value="+150 minute">02:30:00</option>
                                        <option value="+180 minute">03:00:00</option>
                                        <option value="+210 minute">03:30:00</option>
                                        <option value="+240 minute">04:00:00</option>
                                        <option value="+270 minute">04:30:00</option>
                                        <option value="+300 minute">05:00:00</option>
                                        <option value="+330 minute">05:30:00</option>
                                        <option value="+360 minute">06:00:00</option>
                                        <option value="+390 minute">06:30:00</option>
                                        <option value="+420 minute">07:00:00</option>
                                        <option value="+450 minute">07:30:00</option>
                                        <option value="+480 minute">08:00:00</option>
                                        <option value="+510 minute">08:30:00</option>
                                        <option value="+540 minute">09:00:00</option>
                                        <option value="+570 minute">09:30:00</option>
                                        <option value="+600 minute">10:00:00</option>
                                        <option value="+630 minute">10:30:00</option>
                                        <option value="+660 minute">11:00:00</option>
                                        <option value="+690 minute">11:30:00</option>
                                        <option value="+620 minute">12:00:00</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Progres</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="progres_hasil" id="progres_hasil" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <option value="10">10 %</option>
                                        <option value="15">15 %</option>
                                        <option value="20">20 %</option>
                                        <option value="25">25 %</option>
                                        <option value="30">30 %</option>
                                        <option value="35">35 %</option>
                                        <option value="40">40 %</option>
                                        <option value="45">45 %</option>
                                        <option value="50">50 %</option>
                                        <option value="55">55 %</option>
                                        <option value="60">60 %</option>
                                        <option value="65">65 %</option>
                                        <option value="70">70 %</option>
                                        <option value="75">75 %</option>
                                        <option value="80">80 %</option>
                                        <option value="85">85 %</option>
                                        <option value="90">90 %</option>
                                        <option value="100">100 %</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Status</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control disabled" id="status1" name="status1">
                                <!-- <select class="selectpicker" name="status1" id="status1" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required >
                                        <option value="9">Selesai</option>
                                        <option value="3">Belom Selesai</option>
                            </select> -->
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#progres_hasil').change(function() {
                                    var progres_hasil = $('#progres_hasil').val();
                                    if (progres_hasil == 100) {
                                        $('#status1').val('9');
                                    } else {
                                        $('#status1').val('3');
                                    }
                                });
                            });
                        </script>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                            <br>
                            <button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Aktivitas -->
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
                <form class="form" method="post" action="<?= base_url('lembur/tambah_aktivitas_realisasi'); ?>">
                    <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Lembur ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $lembur['id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Kategori</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="kategori" id="kategori" data-style="select-with-transition" title="Pilih" data-size="3" required>
                                        <?php foreach ($kategori as $k) : ?>
                                            <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#kategori').change(function() {
                                    var kategori = $('#kategori').val();
                                    if (kategori == 3) {
                                        $('#copro').prop('disabled', true);
                                    } else {
                                        $('#copro').prop('disabled', false);
                                    }
                                });
                            });
                        </script>
                        <div class="row">
                            <label class="col-md-4 col-form-label">COPRO</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="copro" id="copro" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <?php
                                        $queyCopro = "SELECT * FROM project where status='open' or status='teco' ";
                                        $copro = $this->db->query($queyCopro)->result_array();
                                        foreach ($copro as $c) : ?>
                                            <option data-subtext="<?= $c['deskripsi']; ?>" value="<?= $c['copro']; ?>"><?= $c['copro']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="aktivitas" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Deskripsi Hasil</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="deskripsi_hasil" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <option value="+30 minute">00:30:00</option>
                                        <option value="+60 minute">01:00:00</option>
                                        <option value="+90 minute">01:30:00</option>
                                        <option value="+120 minute">02:00:00</option>
                                        <option value="+150 minute">02:30:00</option>
                                        <option value="+180 minute">03:00:00</option>
                                        <option value="+210 minute">03:30:00</option>
                                        <option value="+240 minute">04:00:00</option>
                                        <option value="+270 minute">04:30:00</option>
                                        <option value="+300 minute">05:00:00</option>
                                        <option value="+330 minute">05:30:00</option>
                                        <option value="+360 minute">06:00:00</option>
                                        <option value="+390 minute">06:30:00</option>
                                        <option value="+420 minute">07:00:00</option>
                                        <option value="+450 minute">07:30:00</option>
                                        <option value="+480 minute">08:00:00</option>
                                        <option value="+510 minute">08:30:00</option>
                                        <option value="+540 minute">09:00:00</option>
                                        <option value="+570 minute">09:30:00</option>
                                        <option value="+600 minute">10:00:00</option>
                                        <option value="+630 minute">10:30:00</option>
                                        <option value="+660 minute">11:00:00</option>
                                        <option value="+690 minute">11:30:00</option>
                                        <option value="+620 minute">12:00:00</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Progres</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="progres_hasil1" id="progres_hasil1" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <option value="10">10 %</option>
                                        <option value="15">15 %</option>
                                        <option value="20">20 %</option>
                                        <option value="25">25 %</option>
                                        <option value="30">30 %</option>
                                        <option value="35">35 %</option>
                                        <option value="40">40 %</option>
                                        <option value="45">45 %</option>
                                        <option value="50">50 %</option>
                                        <option value="55">55 %</option>
                                        <option value="60">60 %</option>
                                        <option value="65">65 %</option>
                                        <option value="70">70 %</option>
                                        <option value="75">75 %</option>
                                        <option value="80">80 %</option>
                                        <option value="85">85 %</option>
                                        <option value="90">90 %</option>
                                        <option value="100">100 %</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Status</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control disabled" id="status2" name="status2">
                                <!-- <select class="selectpicker" name="status1" id="status1" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required >
                                        <option value="9">Selesai</option>
                                        <option value="3">Belom Selesai</option>
                            </select> -->
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#progres_hasil1').change(function() {
                                    var progres_hasil1 = $('#progres_hasil1').val();
                                    if (progres_hasil1 == 100) {
                                        $('#status2').val('9');
                                    } else {
                                        $('#status2').val('3');
                                    }
                                });
                            });
                        </script>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                            <br>
                            <button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubah Jam-->
<div class="modal fade" id="ubhTanggal" tabindex="-1" role="dialog" aria-labelledby="ubhTanggalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">GANTI JAM LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/gtJamRelalisai'); ?>">
                    <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Lembur ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $lembur['id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Jam Mulai</label>
                            <div class="col-md-7">
                                <div class="form-group has-default" id="jammulai">
                                    <input type="text" class="form-control timepicker" id="jammulai" name="jammulai" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary">Ganti Jam!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
