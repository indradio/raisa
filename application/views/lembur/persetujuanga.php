<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="content">
<?php date_default_timezone_set('asia/jakarta'); ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <?php 
                    $today = date('d');
                    $bulan = date('m');
                    $tahun = date('Y');
                    $this->db->where('year(tglmulai)',$tahun);
                    $this->db->where('month(tglmulai)',$bulan);
                    $this->db->where('day(tglmulai)',$today);
                    $this->db->where('lokasi !=','WTQ');
                    $this->db->where('status >', '2');
                    $lembur_cus = $this->db->get('lembur');
                ?>
                <div class="card card-stats">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <p class="card-category">Total</p>
                        <h3 class="card-title"><?= $lembur_cus->num_rows(); ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Lembur HARI INI di LUAR KANTOR
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <?php 
                    $this->db->where('year(tglmulai)',$tahun);
                    $this->db->where('month(tglmulai)',$bulan);
                    $this->db->where('day(tglmulai)',$today);
                    $this->db->where('lokasi','WTQ');
                    $this->db->where('status >', '2');
                    $lembur_wtq = $this->db->get('lembur');
                ?>
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">store</i>
                        </div>
                        <p class="card-category">Total</p>
                        <h3 class="card-title"><?= $lembur_wtq->num_rows(); ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Lembur HARI INI di WTQ
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <?php 
                    $besok = date('d', strtotime("+1 day", strtotime(date("Y-m-d"))));
                    $this->db->where('status >', '2');
                    $this->db->where('year(tglmulai)',$tahun);
                    $this->db->where('month(tglmulai)',$bulan);
                    $this->db->where('day(tglmulai)',$besok);
                    $this->db->where('lokasi','WTQ');
                    $lembur_wtq_besok = $this->db->get('lembur');
                ?>
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">weekend</i>
                        </div>
                        <p class="card-category">Total</p>
                        <h3 class="card-title"><?= $lembur_wtq_besok->num_rows(); ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Lembur BESOK di WTQ
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <?php 
                    $lusa = date('d', strtotime("+2 day", strtotime(date("Y-m-d"))));
                    $this->db->where('status >', '2');
                    $this->db->where('year(tglmulai)',$tahun);
                    $this->db->where('month(tglmulai)',$bulan);
                    $this->db->where('day(tglmulai)',$lusa);
                    $this->db->where('lokasi','WTQ');
                    $lembur_wtq_lusa = $this->db->get('lembur');
                ?>
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">weekend</i>
                        </div>
                        <p class="card-category">Total</p>
                        <h3 class="card-title"><?= $lembur_wtq_lusa->num_rows(); ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Lembur LUSA di WTQ
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div>
        <div class="row"> -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Konfirmasi Lembur</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="#" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal Mengajukan</th>
                                        <th>Tanggal Atasan 1</th>
                                        <th>Tanggal Lembur</th>
                                        <th>Durasi</th>
                                        <th>Lokasi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal Mengajukan</th>
                                        <th>Tanggal Atasan 1</th>
                                        <th>Tanggal Lembur</th>
                                        <th>Durasi</th>
                                        <th>Lokasi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($lembur as $l) : ?>
                                        <tr data-toggle="modal" data-target="#submitLembur" data-id="<?= $l['id']; ?>" data-tglpengajuan="<?= date('d M H:i', strtotime($l['tglpengajuan_rencana'])); ?>" data-nama="<?= $l['nama']; ?>" data-tglmulai="<?= date('d M H:i', strtotime($l['tglmulai_rencana'])).date(' - H:i', strtotime($l['tglselesai_rencana'])); ?>" data-durasi="<?= $l['durasi_rencana']; ?>" data-lokasi="<?= $l['lokasi']; ?>" >
                                            <td><?= $l['nama']; ?> <small>(<?= $l['id']; ?>)</small></td>
                                            <td><?= date('d M H:i', strtotime($l['tglpengajuan_rencana'])); ?></td>
                                            <td><?= date('d M H:i', strtotime($l['tgl_atasan1_rencana'])); ?></td>
                                            <td><?= date('d M H:i', strtotime($l['tglmulai_rencana'])).date(' - H:i', strtotime($l['tglselesai_rencana'])); ?></td>
                                            <td><?= $l['durasi']; ?> Jam </td>
                                            <td><?= $l['lokasi']; ?></td>
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
        <!-- </div>
        <div class="row"> -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Lembur HARI INI yg sudah DIKONFIRMASI</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal Mengajukan</th>
                                        <th>Tanggal Lembur</th>
                                        <th>Durasi</th>
                                        <th>Lokasi</th>
                                        <th>Konsumsi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal Mengajukan</th>
                                        <th>Tanggal Lembur</th>
                                        <th>Durasi</th>
                                        <th>Lokasi</th>
                                        <th>Konsumsi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($lembur_konfirmasi as $l) : ?>
                                        <tr>
                                            <td><?= $l['nama']; ?> <small>(<?= $l['id']; ?>)</small></td>
                                            <td><?= date('d M H:i', strtotime($l['tglpengajuan_rencana'])); ?></td>
                                            <td><?= date('d M H:i', strtotime($l['tglmulai_rencana'])).date(' - H:i', strtotime($l['tglselesai_rencana'])); ?></td>
                                            <td><?= $l['durasi_rencana']; ?> Jam </td>
                                            <td><?= $l['lokasi']; ?></td>
                                            <?php $konsumsi = $this->db->get_where('lembur_konsumsi',['id'=>$l['konsumsi']])->row_array(); ?>
                                            <td><?= $konsumsi['nama']; ?></td>
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

<!-- Proccess-->
<div class="modal fade" id="submitLembur" tabindex="-1" role="dialog" aria-labelledby="submitLemburTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                      <h4 class="card-title">LEMBUR</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 align-content-start">
                        <form class="form" method="post" action="<?= base_url('lembur/submit_konfirmasi_ga'); ?>">
                        </br>
                        <div class="form-group" hidden>
                            <label for="exampleID" class="bmd-label-floating">ID</label>
                            <input type="text" class="form-control" id="id" name="id" />
                        </div>
                        <div class="form-group">
                            <label for="exampleDate" class="bmd-label-floating">Tanggal & Jam</label>
                            <input type="text" class="form-control" id="tglpengajuan" name="tglpengajuan" value=" " /> 
                        </div>
                        <div class="form-group">
                            <label for="exampleNama" class="bmd-label-floating">Nama</label>
                            <input type="text" class="form-control disabled" id="nama" name="nama" value=" " />
                        </div>
                        <div class="form-group">
                            <label for="exampleDate" class="bmd-label-floating">Tanggal & Jam</label>
                            <input type="text" class="form-control disabled" id="tglmulai" name="tglmulai" value=" " /> 
                        </div>
                        <div class="form-group">
                            <label for="exampleDurasi" class="bmd-label-floating">Durasi</label>
                            <input type="text" class="form-control disabled" id="durasi" name="durasi" value=" " />
                        </div>
                        <div class="form-group">
                            <label for="exampleLokasi" class="bmd-label-floating">Lokasi</label>
                            <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value=" " />
                        </div>
                        <div class="form-group">
                            <label for="exampleKonsumsi" class="bmd-label-floating">Konsumsi</label>
                            </br>
                            <select class="selectpicker" name="konsumsi" id="konsumsi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" required>
                                <?php
                                    $konsumsi = $this->db->get('lembur_konsumsi')->result_array();
                                    foreach ($konsumsi as $k) : ?>
                                        <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="modal-footer justify-content-right">
                            <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                            <button type="submit" class="btn btn-success">PROSES</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#submitLembur').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes
            var tglpengajuan = button.data('tglpengajuan')
            var nama = button.data('nama') // Extract info from data-* attributes
            var tglmulai = button.data('tglmulai')
            var durasi = button.data('durasi')
            var lokasi = button.data('lokasi') 
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="tglpengajuan"]').val(tglpengajuan)
            modal.find('.modal-body input[name="nama"]').val(nama)
            modal.find('.modal-body input[name="tglmulai"]').val(tglmulai)
            modal.find('.modal-body input[name="durasi"]').val(durasi)
            modal.find('.modal-body input[name="lokasi"]').val(lokasi)
        });
    })
</script>