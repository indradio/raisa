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
                                    <label class="col-ml-5 col-form-label">Tanggal Mulai</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datetimepicker disabled" placeholder="With Material Icons" id="tglmulai" name="tglmulai" value="<?= $lembur['tglmulai']; ?>">
                                            <?php if ($lembur['aktivitas_rencana'] == '0' AND $lembur['status'] == '1') { ?>
                                                <a href="#" class="badge badge-pill badge-warning" data-toggle="modal" data-target="#ubhTanggal" data-id="<?= $lembur['id']; ?>">UBAH JAM</a>
                                            <?php }; ?>
                                        </div>
                                    </div>
                                </div>
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
                                            <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= date('H:i', strtotime($lembur['durasi'])).' Jam / '. $lembur['aktivitas_rencana']; ?> Aktivitas">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            
                            <div class="row col-md-6">
                                <div class="row col-md-12">
                                <label class="col-ml-5 col-form-label">Status</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <?php $status = $this->db->get_where('lembur_status', ['id' => $lembur['status']])->row_array(); ?>
                                            <input type="text" class="form-control disabled" id="status" name="status" value="<?= $status['nama']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php if($lembur['status']=='1'){ ?>
                                    <div class="row col-md-12">
                                        <label class="col-ml-5 col-form-label">Lokasi Lembur</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <select class="selectpicker" name="lokasi" id="lokasi" data-style="select-with-transition" title="Pilih" data-size="5" data-live-search="true" onchange="admSelectCheck(this);" required>
                                                <option data-subtext="WORKSHOP FOR INDUSTRIAL EQUIPMENT" value="WTQ">WTQ</option>
                                                    <?php 
                                                    $queyCustomer = "SELECT * FROM customer ";
                                                    $customer = $this->db->query($queyCustomer)->result_array();
                                                    foreach ($customer as $c) : ?>
                                                        <option data-subtext="<?= $c['nama']; ?>" value="<?= $c['inisial']; ?>"><?= $c['inisial']; ?></option>
                                                    <?php endforeach; ?>
                                                 <option data-subtext="Lokasi Lainnya" value="lainnya">LAINNYA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12" id="admDivCheck" style="display:none;">
                                        <label class="col-ml-5 col-form-label">Lokasi Lainnya</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <input type="text" class="form-control" id="lokasi_lain" name="lokasi_lain" required>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                       function admSelectCheck(nameSelect)
                                        {
                                            var val = nameSelect.options[nameSelect.selectedIndex].value;
                                            document.getElementById("admDivCheck").style.display = val == 'lainnya' ? "block" : 'none';
                                        }

                                        $(document).ready(function() {
                                                $('#lokasi').change(function() {
                                                    var lokasi = $('#lokasi').val();
                                                    if (lokasi == 'lainnya') {
                                                        $('#lokasi_lain').prop('disabled', false);
                                                    } else {
                                                        $('#lokasi_lain').prop('disabled', true);
                                                    }
                                                });
                                            });
                                    </script>
                                <?php } else {?>
                                    <div class="row col-md-12">
                                        <label class="col-ml-5 col-form-label">Lokasi Lembur</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="<?= $lembur['lokasi']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                <?php }; ?>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                        <?php if ($lembur['status'] == '1'){
                            echo '<a href="#" id="tambah_aktifvitas" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">Tambah Aktivitas</a>';
                        }; ?>
                    </div>
                    <div class="material-datatables">
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Rencana Aktivitas</th>
                                    <th>Durasi/Jam</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Rencana Aktivitas</th>
                                    <th>Durasi/Jam</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach ($aktivitas as $a) : ?>
                                    <tr>
                                        <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                        <td><?= $k['nama']; ?>  <small>(<?= $a['copro']; ?>)</small></td>
                                        <td><?= $a['aktivitas']; ?></td>
                                        <td><?= $a['durasi']; ?> Jam</td>
                                        <td class="text-right">
                                            <?php if ($lembur['status'] == '0' or $lembur['status'] >= '2') { ?>
                        
                                            <?php } else { ?>
                                                <a href="<?= base_url('lembur/hapus_aktivitas/') . $a['id']; ?>" class="btn btn-round btn-danger btn-sm btn-bataldl">HAPUS</a>
                                            <?php }; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </p>
                        Lemburan kamu belum termasuk <mark>JAM ISTIRAHAT</mark> dan <mark>PERJALANAN</mark> pada saat lembur. 
                        <br>Silahkan tambahkan istirahat dan perjalanan sebagai aktivitas.
                        </p>
                        <!-- Button SUBMIT -->
                        <?php if ($lembur['status'] == 1 AND $lembur['aktivitas_rencana'] == 0) { ?>
                            <button type="submit" id="ajukan" class="btn btn-sm btn-success disabled">SUBMIT</button>
                        <?php } elseif ($lembur['status'] == 1 AND $lembur['aktivitas_rencana'] >= 1) { ?>
                            <button type="submit" id="ajukan" class="btn btn-sm btn-success">SUBMIT</button>
                        <?php }; ?>
                        <!-- Button BATALKAN & KEMBALI -->
                            <a href="#" id="batalAktivitas" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
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
                                    <select class="selectpicker" name="kategori" id="kategori" data-style="select-with-transition" title="Pilih" data-size="4" required>
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
                                    if (kategori >= 3) {
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
                                        <option value="+30 minute">00:30 Jam</option>
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
                            <button type="submit" class="btn btn-success">SIMPAN</button>
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
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">UBAH JAM LEMBUR</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('lembur/gtJamRencana'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" hidden>
                                <label class="col-md-5 col-form-label">Lembur ID</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="id" name="id" value="<?= $lembur['id']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-5 col-form-label">Jam Mulai</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default" id="jammulai">
                                        <input type="text" class="form-control timepicker" id="jammulai" name="jammulai" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-success">UBAH JAM</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
