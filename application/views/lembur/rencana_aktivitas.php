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
                        <h4 class="card-title">Rencana Aktivitas Lembur</h4>
                    </div>
                    <form class="form" method="post" action="<?= base_url('lembur/ajukan_rencana'); ?>">
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
                                    <?php
                                        $lid = $lembur['id'];
                                        $queryLembur = "SELECT COUNT(*)
                                                    FROM `aktivitas`
                                                    WHERE `link_aktivitas` = '$lid' ";
                                        $totalLembur = $this->db->query($queryLembur)->row_array();
                                        $totalAktivitas = $totalLembur['COUNT(*)']; ?>
                                    <label class="col-ml-5 col-form-label">Tanggal Mulai</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datetimepicker disabled" placeholder="With Material Icons" id="tglmulai" name="tglmulai" value="<?= $lembur['tglmulai']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php if ($totalAktivitas == '0' AND $lembur['status']== '1') { ?>
                                <div class="row col-md-12">
                                    <label class="col-ml-5 col-form-label"></label>
                                    <div class="col-md-5">
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
                                            <input type="text" class="form-control datetimepicker disabled" id="tglselesai" name="tglselesai" value="<?= $lembur['tglselesai']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label class="col-ml-5 col-form-label">Durasi Lembur</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= $lembur['durasi']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            
                        <div class="row col-md-6">
                        <?php if($lembur['status']=='1'){ ?>
                            <div class="row col-md-12">
                                <label class="col-ml-5 col-form-label">Lokasi Lembur</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" name="lokasi" id="lokasi" data-style="select-with-transition" title="Pilih" data-size="2" required>
                                                <?php foreach ($lembur_lokasi as $li) : ?>
                                                    <option value="<?= $li['id']; ?>"><?= $li['nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="row col-md-12" hidden>
                            <label class="col-ml-5 col-form-label">Customer</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="customer" id="customer" data-style="select-with-transition" title="Pilih" data-size="3" data-live-search="true" required>
                                        <?php
                                        $queyCustomer = "SELECT * FROM customer";
                                        $customer = $this->db->query($queyCustomer)->result_array();
                                        foreach ($customer as $c) : ?>
                                            <option data-subtext="<?= $c['nama']; ?>" value="<?= $c['inisial']; ?>"><?= $c['inisial']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        
                        <!-- <script>
                            $(document).ready(function() {
                                $('#lokasi').change(function() {
                                    var lokasi = $('#lokasi').val();
                                    if (lokasi == 1) {
                                        $('#customer').prop('disabled', true);
                                    } else {
                                        $('#customer').prop('disabled', false);
                                    }
                                });
                            });
                        </script> -->
                            <?php } else {?>
                        </div>
                            <div class="row col-md-12">
                            <label class="col-ml-5 col-form-label">Lokasi Lembur</label>
                                <div class="col-md-7">
                                    <div class="form-group has-default">
                                        <?php $lokasi = $this->db->get_where('lembur_lokasi', ['id' => $lembur['lokasi_id']])->row_array(); ?>
                                        <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="<?= $lokasi['nama']; ?>">
                                    </div>
                                </div>
                            </div>
                            <?php }; ?>
                            <div class="row col-md-12">
                            <label class="col-ml-5 col-form-label">Total Aktivitas</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
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
                    </form>
                    <br>
                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                        <?php if ($this->session->userdata['posisi_id'] == '7' and $totalAktivitas == '0' and $lembur['status'] == '0' or $lembur['status'] >= '2') { ?>
                            
                        <?php } else { ?>
                            <a href="#" id="tambah_aktifvitas" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">Tambah Aktivitas</a>
                        <?php }; ?>
                    </div>
                    <div class="material-datatables">
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>COPRO</th>
                                    <th>Rencana Aktivitas</th>
                                    <th>Durasi/Jam</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Kategori</th>
                                    <th>COPRO</th>
                                    <th>Rencana Aktivitas</th>
                                    <th>Durasi/Jam</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach ($aktivitas as $a) : ?>
                                    <tr>
                                        <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                        <td><?= $k['nama']; ?></td>
                                        <td><?= $a['copro']; ?></td>
                                        <td><?= $a['aktivitas']; ?></td>
                                        <td><?= $a['durasi']; ?> Jam</td>
                                        <td class="text-right">
                                            <?php if ($lembur['status'] == '0' or $lembur['status'] >= '2') { ?>
                        
                                            <?php } else { ?>
                                                <a href="<?= base_url('lembur/hapus/') . $a['id']; ?>" class="btn btn-round btn-danger btn-sm btn-bataldl">HAPUS</a>
                                            <?php }; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- Sederhanakan koding -->
                        <?php if ($totalAktivitas == '0') { ?>
                            <a href="#" id="batalAktivitas" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                        <?php } else if ($totalAktivitas >= '1' and $lembur['status'] == '1') { ?>
                            <button type="submit" id="ajukan" class="btn btn-sm btn-success">SUBMIT</button>
                            <a href="#" id="batalAktivitas" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                        <?php } else if ($totalAktivitas >= '1' and $lembur['status'] == '0' or $lembur['status'] >= '2') { ?>

                        <?php }; ?>
                            <a href="<?= base_url('lembur/rencana/') ?>" class="btn btn-sm btn-default" role="button">KEMBALI</a>
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
                <form class="form" method="post" action="<?= base_url('lembur/tambah_aktivitas'); ?>">
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
                            <label class="col-md-4 col-form-label">Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="aktivitas" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <option value="+30 minute">30:00 Menit</option>
                                        <option value="+60 minute">01:00 Jam</option>
                                        <option value="+90 minute">01:30 Jam</option>
                                        <option value="+120 minute">02:00 Jam</option>
                                        <option value="+150 minute">02:30 Jam</option>
                                        <option value="+180 minute">03:00 Jam</option>
                                        <option value="+210 minute">03:30 Jam</option>
                                        <option value="+240 minute">04:00 Jam</option>
                                        <option value="+270 minute">04:30 Jam</option>
                                        <option value="+300 minute">05:00 Jam</option>
                                        <option value="+330 minute">05:30 Jam</option>
                                        <option value="+360 minute">06:00 Jam</option>
                                        <option value="+390 minute">06:30 Jam</option>
                                        <option value="+420 minute">07:00 Jam</option>
                                        <option value="+450 minute">07:30 Jam</option>
                                        <option value="+480 minute">08:00 Jam</option>
                                        <option value="+510 minute">08:30 Jam</option>
                                        <option value="+540 minute">09:00 Jam</option>
                                        <option value="+570 minute">09:30 Jam</option>
                                        <option value="+600 minute">10:00 Jam</option>
                                        <option value="+630 minute">10:30 Jam</option>
                                        <option value="+660 minute">11:00 Jam</option>
                                        <option value="+690 minute">11:30 Jam</option>
                                        <option value="+620 minute">12:00 Jam</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
                <form class="form" method="post" action="<?= base_url('lembur/gtJamRencana'); ?>">
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
