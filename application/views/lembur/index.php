<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
  <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
                                <?php 
                                    $bulan = date('m');
                                    $tahun = date('Y');

                                    $this->db->where('npk', $this->session->userdata('npk'));
                                    $this->db->where('year(tglmulai)',$tahun);
                                    $this->db->where('month(tglmulai)',$bulan);
                                    $this->db->where('status', '9');
                                    $total_lembur = $this->db->get('lembur');
                                ?>
                            <div class="card card-stats">
                              <div class="card-header card-header-rose card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">date_range</i>
                                </div>
                                <p class="card-category">Total</p>
                                <h3 class="card-title"><?= $total_lembur->num_rows(); ?></h3>
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                               TOTAL Lembur kamu di bulan ini
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- <div class="col-lg-3 col-md-6 col-sm-6">
                                <?php   
                                    $this->db->where('status >', '2');
                                    $this->db->where('day(tglmulai)',$tanggal);
                                    $this->db->where('lokasi','WTQ');
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
                          </div> -->
                          <div class="col-lg-4 col-md-6 col-sm-6">
                                <?php 
                                  $this->db->select('SUM(durasi) as total');
                                  $this->db->where('npk', $this->session->userdata('npk'));
                                  $this->db->where('year(tglmulai)',$tahun);
                                  $this->db->where('month(tglmulai)',$bulan);
                                  $this->db->where('status', '9');
                                  $this->db->from('lembur');
                           
                                  $totalDurasi = $this->db->get()->row()->total;
                                ?>
                            <div class="card card-stats">
                              <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">schedule</i>
                                </div>
                                <p class="card-category">JAM</p>
                                <h3 class="card-title"><?= $totalDurasi; ?></h3>
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                                 Total JAM LEMBUR Kamu bulan ini
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-md-6 col-sm-6">
                          <?php 
                                 $this->db->select('SUM(tul) as total');
                                 $this->db->where('npk', $this->session->userdata('npk'));
                                 $this->db->where('status', '9');
                                 $this->db->where('month(tglmulai)',$bulan);
                                 $this->db->where('year(tglmulai)',$tahun);
                                 $this->db->from('lembur');
                          
                                 $totalTUL = $this->db->get()->row()->total;
                                ?>
                            <div class="card card-stats">
                              <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                <i class="material-icons">attach_money</i>
                                </div>
                                <p class="card-category">TUL</p>
                                <h3 class="card-title"><?= $totalTUL; ?></h3>
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                                Total TUL LEMBUR Kamu bulan ini
                                </div>
                              </div>
                            </div>
                          </div>
</div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Data Lembur</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Tgl Mengajukan</th>
                    <th>Tanggal & Jam Mulai</th>
                    <th>Durasi</th>
                    <th>TUL</th>
                    <th>Admin GA</th>
                    <th>Admin HR</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="disabled-sorting text-right">Actions</th>
                    <th class="disabled-sorting"></th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Tgl Mengajukan</th>
                    <th>Tanggal & Jam Mulai</th>
                    <th>Durasi</th>
                    <th>TUL</th>
                    <th>Admin GA</th>
                    <th>Admin HR</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($lembur as $l) : ?>
                    <tr>
                      <td><?= $l['id']; ?></td>
                      <td><?= $l['tglpengajuan']; ?></td>
                          <?php if($l['status']== '1' or $l['status']== '2' or $l['status']== '3' or $l['status']== '4' or $l['status']== '10' or $l['status']== '11') {?>
                            <td><?= date('d-M H:i', strtotime($l['tglmulai'])); ?></td>
                            <td><?= date('H', strtotime($l['durasi_rencana'])); ?> Jam <?= date('i', strtotime($l['durasi_rencana'])); ?> Menit</td>
                          <?php } else { ?>
                            <td><?= date('d-M H:i', strtotime($l['tglmulai_aktual'])); ?></td>
                            <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                          <?php }; ?>
                      <td><?= $l['tul']; ?></td>
                      <td><?= $l['admin_ga']; ?></td>
                      <td><?= $l['admin_hr']; ?></td>
                      <td><?= $l['catatan']; ?></td>
                      <?php $status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array(); ?>
                      <td><?= $status['nama']; ?></td>
                      <td>
                          <?php if ($l['status'] == '4' or $l['status'] == '5' or $l['status'] == '6' or $l['status'] == '12' or $l['status'] == '13') { ?>
                              <a href="<?= base_url('lembur/realisasi_aktivitas/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                          <?php }else if ($l['status'] == '0' or $l['status'] == '7' or $l['status'] == '8' or $l['status'] == '9') { ?>
                            <a href="<?= base_url('lembur/lemburku/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                          <?php } else { ?>
                              <a href="<?= base_url('lembur/rencana_aktivitas/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                          <?php }; ?>
                      </td>
                      <td class="text-right">
                          <?php if ($l['status'] == '9' ) { ?>
                            <a href="<?= base_url('lembur/laporan_lembur/') . $l['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit" target="_blank"><i class="material-icons">dvr</i></a>
                          <?php } else { ?>
                            <a href="<?= base_url('lembur/laporan_lembur/') . $l['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit disabled"><i class="material-icons">dvr</i></a>
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

