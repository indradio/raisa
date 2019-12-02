<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <!-- RESUME LEMBUR SELESAI -->
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
                                <?php 
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
                               TOTAL Lembur di bulan ini
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-md-6 col-sm-6">
                                <?php 
                                  $this->db->select('SUM(durasi) as total');
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
                                 Total JAM LEMBUR bulan ini
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-md-6 col-sm-6">
                          <?php 
                                 $this->db->select('SUM(tul) as total');
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
                                Total TUL LEMBUR bulan ini
                                </div>
                              </div>
                            </div>
                          </div>
</div>
    <div class="row">
      <div class="col-md-12">
      <?= $this->session->flashdata('pilihtgl'); ?>
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">LEMBUR</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar       Rencana Atasan 1 & 2       -->
            </div>
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Durasi/Jam</th>
                    <th>TUL</th>
                    <th>Admin</th>
                    <th>Catatan</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Durasi/Jam</th>
                    <th>TUL</th>
                    <th>Admin</th>
                    <th>Catatan</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($lembur as $l) : ?>
                    <tr onclick="window.location='<?= base_url('kadep/lembur_detail/') . $l['id']; ?>'">
                      <td><?= $l['nama']; ?> <small>(<?= $l['id']; ?>)</small></td>
                      <td><?= date('d/m/Y H:i', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                      <td><?= $l['tul']; ?></td>
                      <td>GA : <?= $l['admin_ga']; ?></br>HR : <?= $l['admin_hr']; ?></td>
                      <td><?= $l['catatan']; ?></td>
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

