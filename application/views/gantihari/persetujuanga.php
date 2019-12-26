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
                                    $lembur_cus = $this->db->get('gantihari');
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
                                <i class="material-icons">date_range</i> GANTI HARI di LUAR KANTOR
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
                                    $lembur_wtq = $this->db->get('gantihari');
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
                                <i class="material-icons">date_range</i> GANTI HARI di WTQ
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
                                    $lembur_wtq_besok = $this->db->get('gantihari');
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
                                <i class="material-icons">date_range</i> GANTI HARI BESOK di WTQ
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
                                    $lembur_wtq_lusa = $this->db->get('gantihari');
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
                                  <i class="material-icons">date_range</i> GANTI HARI LUSA di WTQ
                                </div>
                              </div>
                            </div>
                          </div>
</div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Konfirmasi Ganti Hari</h4>
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
                                    <?php foreach ($gantihari as $l) : ?>
                                        <tr data-toggle="modal" data-id="<?= $l['id']; ?>" 
                                        data-nama="<?= $l['nama']; ?>"
                                        data-tglpengajuan="<?= date('d-M H:i', strtotime($l['tglpengajuan'])); ?>"
                                        data-tglmulai="<?= date('d-M H:i', strtotime($l['tglmulai'])); ?>"
                                        data-tglselesai="<?= date('d-M H:i', strtotime($l['tglselesai'])); ?>"
                                        data-lokasi="<?= $l['lokasi']; ?>"
                                        data-target="#konf_lemburga">
                                            <td><?= $l['nama']; ?> <small>(<?= $l['id']; ?>)</small></td>
                                            <td><?= date('d-M H:i', strtotime($l['tglpengajuan'])); ?></td>
                                            <td><?= date('d-M H:i', strtotime($l['tgl_atasan1_rencana'])); ?></td>
                                            <td><?= date('d-M H:i', strtotime($l['tglmulai'])); ?></td>
                                            <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
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
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">GANTI HARI yg sudah DIKONFIRMASI</h4>
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
                                    <?php foreach ($gantihari_konfirmasi as $l) : ?>
                                        <tr>
                                            <td><?= $l['nama']; ?> <small>(<?= $l['id']; ?>)</small></td>
                                            <td><?= date('d-M H:i', strtotime($l['tglpengajuan'])); ?></td>
                                            <td><?= date('d-M H:i', strtotime($l['tglmulai'])); ?></td>
                                            <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                                            <td><?= $l['lokasi']; ?></td>
                                            <td><?= $l['konsumsi']; ?></td>
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
<!-- Modal Konfirmasi Lembur-->
<div class="modal fade" id="konf_lemburga" tabindex="-1" role="dialog" aria-labelledby="konf_lemburgaTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">KONFIRMASI GANTI HARI</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('gantihari/submit_konfirmasi_ga'); ?>">
                    <div class="card-body">
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-md-6 col-form-label">Nama</label>
                            <div class="col-md-6">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="nama">
                                    <input type="text" class="form-control disabled" id="id" name="id">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-6 col-form-label">Tanggal & Jam Mengajukan</label>
                            <div class="col-md-6">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="tglpengajuan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-6 col-form-label">Tanggal & Jam Lembur</label>
                            <div class="col-md-6">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="tglmulai">
                                    <input type="text" class="form-control disabled" name="tglselesai">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-6 col-form-label">Lokasi</label>
                            <div class="col-md-6">
                                <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="lokasi">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-6 col-form-label">Konsumsi</label>
                            <div class="col-md-6">
                                <div class="form-group has-default">
                                <select class="selectpicker" name="konsumsi" id="konsumsi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" required>
                                        <option value="YA">YA</option>
                                        <option value="TIDAK">TIDAK</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                                    <button type="submit" class="btn btn-success">PROSES</button>
                                    <button type="button" class="btn btn-default ml-1" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

