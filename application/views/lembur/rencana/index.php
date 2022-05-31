<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Rencana Lembur</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar text-right mb-2">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="<?= base_url('lembur/tambah_hariini'); ?>" class="btn btn-facebook" role="button" aria-disabled="false">Rencana Lembur Hari ini</a>
                            <a href="#" class="btn btn-linkedin" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahLembur">Rencana Lembur Hari Lain</a>
                            <?php // if ($this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6){
                                //echo '<a href="#" class="btn btn-twitter" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahLemburTim">Rencana Lembur Tim</a>' ;
                              // }; 
                            ?> 
                           <!-- <a href="#" class="btn btn-facebook" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahLemburTim">Rencana Lembur Tim</a> -->
                        </div>
                        <div class="material-datatables">
                            <table id="dtdesc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Durasi <small>(Jam)</small></th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Tgl Pengajuan</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Durasi <small>(Jam)</small></th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($lembur as $l) : 
                                        if ($l['status']>=1 AND $l['status']<=3){ ?>
                                        <tr onclick="window.location='<?= base_url('lembur/rencana/aktivitas/'. $l['id']); ?>'" >
                                            <td><?= $l['id'].' - '.$l['kategori']; ?></td>
                                            <td><?= date('d M H:i', strtotime($l['tglpengajuan_rencana'])); ?></td>
                                            <td><?= date('d-M H:i', strtotime($l['tglmulai_rencana'])); ?></td>
                                            <td><?= date('d-M H:i', strtotime($l['tglselesai_rencana'])); ?></td>
                                            <td><?= $l['durasi_rencana']; ?></td>
                                            <td><?= $l['lokasi']; ?></td>
                                            <?php $status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array(); ?>
                                            <td><?= $status['nama']; ?></td>
                                        </tr>
                                        <?php }elseif ($l['status']>=4 AND $l['status']<=6){ ?>
                                        <tr onclick="window.location='<?= base_url('lembur/realisasi_aktivitas/') . $l['id']; ?>'" >
                                            <td><?= $l['id'].' - '.$l['kategori']; ?></td>
                                            <td><?= date('d M H:i', strtotime($l['tglpengajuan_realisasi'])); ?></td>
                                            <td><?= date('d-M H:i', strtotime($l['tglmulai'])); ?></td>
                                            <td><?= date('d-M H:i', strtotime($l['tglselesai'])); ?></td>
                                            <td><?= $l['durasi']; ?></td>
                                            <td><?= $l['lokasi']; ?></td>
                                            <?php $status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array(); ?>
                                            <td><?= $status['nama']; ?></td>
                                        </tr>
                                        <?php }
                                    endforeach; ?>
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
                        <button type="submit" class="btn btn-sm btn-danger">BATALKAN LEMBUR INI!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Lembur Hari Lain Aktivitas-->
<div class="modal fade" id="tambahLembur" tabindex="-1" role="dialog" aria-labelledby="tambahLemburTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">RENCANA LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/tambah_harilain'); ?>">
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-md-4 col-form-label">Tanggal Mulai</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datetimepicker" id="tglmulai" name="tglmulai" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">SELANJUTNYA</button>
                            <a href="<?= base_url('lembur/rencana'); ?>" class="btn btn-default">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Lembur Tim-->
<div class="modal fade" id="tambahLemburTim" tabindex="-1" role="dialog" aria-labelledby="tambahLemburTimTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">RENCANA LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/tambah_tim'); ?>">
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-md-4 col-form-label">Tanggal Mulai</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datetimepicker" id="tglmulai" name="tglmulai" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Nama</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                <select class="selectpicker" id="npk" name="npk" data-style="select-with-transition" title="Pilih Tim" data-size="7" data-width="fit" data-live-search="true">
                                    <?php
                                    $queryKaryawan = "SELECT *
                                                FROM `karyawan`
                                                WHERE `npk` != {$this->session->userdata('npk')} AND `sect_id` = {$this->session->userdata('sect_id')}
                                                ORDER BY `nama` ASC
                                                ";
                                    $tim = $this->db->query($queryKaryawan)->result_array();
                                    foreach ($tim as $t) : ?>
                                    <option data-subtext="<?= $t['inisial']; ?>" value="<?= $t['npk']; ?>"><?= $t['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">SELANJUTNYA</button>
                            <a href="<?= base_url('lembur/rencana'); ?>" class="btn btn-default">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>