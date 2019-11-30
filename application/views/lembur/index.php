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
                              <a href="#" class="badge badge-pill badge-info" data-toggle="modal" data-target="#historyLembur"
                              data-tglmengajukan="<?= date('d M Y H:i', strtotime($l['tglpengajuan'])); ?>"
                              data-atasan1="<?= $l['atasan1_rencana']; ?>"
                              data-atasan2="<?= $l['atasan2_rencana']; ?>"
                              data-tgl1_rencana="<?= date('d M Y H:i', strtotime($l['tgl_atasan1_rencana'])); ?>"
                              data-tgl2_rencana="<?= date('d M Y H:i', strtotime($l['tgl_atasan2_rencana'])); ?>"
                              data-tgl1_realisasi="<?= date('d M Y H:i', strtotime($l['tgl_atasan1_realisasi'])); ?>"
                              data-tgl2_realisasi="<?= date('d M Y H:i', strtotime($l['tgl_atasan2_realisasi'])); ?>"
                              data-ga="<?= $l['admin_ga']; ?>"
                              data-hr="<?= $l['admin_hr']; ?>"
                              data-tgl_ga="<?= date('d M Y H:i', strtotime($l['tgl_admin_ga'])); ?>"
                              data-tgl_hr="<?= date('d M Y H:i', strtotime($l['tgl_admin_hr'])); ?>"
                              data-status="<?= $l['status']; ?>"
                              >history</a>
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
<div class="modal fade" id="historyLembur" tabindex="-1" role="dialog" aria-labelledby="historyLemburTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">HISTORY LEMBUR</h4>
                    </div>
                </div>
                  <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="card card-timeline card-plain">
                            <div class="card-body">
                              <ul class="timeline">
                                <li class="timeline-inverted">
                                  <div class="timeline-badge danger">
                                    <i class="material-icons">card_travel</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-danger">Proses HR SSC</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="admin_ssc"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li>
                                  <div class="timeline-badge success">
                                    <i class="material-icons">extension</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-success">Proses HR WTQ</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="admin_hr"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tgl_hr"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li class="timeline-inverted">
                                  <div class="timeline-badge info">
                                    <i class="material-icons">fingerprint</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-info">Persetujuan Realisasi Atasan 2</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="atasan2_realisasi"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tgl_atasan2_realisasi"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li class="timeline-inverted">
                                  <div class="timeline-badge info">
                                    <i class="material-icons">fingerprint</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-info">Persetujuan Realisasi Atasan 1</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="atasan1_realisasi"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tgl_atasan1_realisasi"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li class="timeline-inverted">
                                  <div class="timeline-badge info">
                                    <i class="material-icons">fingerprint</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-info">Persetujuan Rencana Atasan 2</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="atasan2_rencana"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tgl_atasan2_rencana"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li>
                                  <div class="timeline-badge success">
                                    <i class="material-icons">extension</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-success">Mengetahui GA</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="admin_ga"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tgl_ga"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li class="timeline-inverted">
                                  <div class="timeline-badge info">
                                    <i class="material-icons">fingerprint</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-info">Persetujuan Rencana Atasan 1</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="atasan1_rencana"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tgl_atasan1_rencana"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li>
                                  <div class="timeline-badge warning">
                                    <i class="material-icons">add_circle_outline</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-warning">Mengajukan</span>
                                    </div>
                                    <div class="timeline-body">
                                      <p id="lembur"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tglmengajukan"></i>
                                    </h6>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
                        </div>
                    </div>
                  </div>
                </div>    
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#historyLembur').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var tglmengajukan = button.data('tglmengajukan')
            var atasan1 = button.data('atasan1')
            var atasan2 = button.data('atasan2')
            var tgl1_rencana = button.data('tgl1_rencana')
            var tgl2_rencana = button.data('tgl2_rencana')
            var tgl1_realisasi = button.data('tgl1_realisasi')
            var tgl2_realisasi = button.data('tgl2_realisasi')
            var ga = button.data('ga')
            var tgl_ga = button.data('tgl_ga')
            var hr = button.data('hr')
            var tgl_hr = button.data('tgl_hr')
            var status = button.data('status')
            var modal = $(this)
            if (status > 0){
            document.getElementById("lembur").innerHTML = "Mengajukan lembur pada";
            document.getElementById("tglmengajukan").innerHTML = tglmengajukan;
            }else{
            document.getElementById("lembur").innerHTML = "Lembur kamu telah DIBATALKAN";
            document.getElementById("tglmengajukan").innerHTML = null;
            }
            if (status > 2){
            document.getElementById("atasan1_rencana").innerHTML = "Disetujui oleh " + atasan1;
            document.getElementById("tgl_atasan1_rencana").innerHTML = tgl1_rencana;
            }else{
            document.getElementById("atasan1_rencana").innerHTML = "Menunggu Persetujuan " + atasan1;
            document.getElementById("tgl_atasan1_rencana").innerHTML = null;
            }
            if (status > 3){
            document.getElementById("atasan2_rencana").innerHTML = "Disetujui oleh " + atasan2;
            document.getElementById("tgl_atasan2_rencana").innerHTML = tgl2_rencana;
            }else{
            document.getElementById("atasan2_rencana").innerHTML = "Menunggu Persetujuan " + atasan2;
            document.getElementById("tgl_atasan2_rencana").innerHTML = null;
            }
            if (status > 5){
            document.getElementById("atasan1_realisasi").innerHTML = "Disetujui oleh " + atasan1;
            document.getElementById("tgl_atasan1_realisasi").innerHTML = tgl1_realisasi;
            }else{
            document.getElementById("atasan1_realisasi").innerHTML = "Menunggu Persetujuan " + atasan1;
            document.getElementById("tgl_atasan1_realisasi").innerHTML = null;
            }
            if (status > 6){
            document.getElementById("atasan2_realisasi").innerHTML = "Disetujui oleh " + atasan2;
            document.getElementById("tgl_atasan2_realisasi").innerHTML = tgl2_realisasi;
            }else{
            document.getElementById("atasan2_realisasi").innerHTML = "Menunggu Persetujuan " + atasan2;
            document.getElementById("tgl_atasan2_realisasi").innerHTML = null;
            }
            if (status > 7){
            document.getElementById("admin_hr").innerHTML = "Diproses oleh " + hr;
            document.getElementById("tgl_hr").innerHTML = tgl_hr;
            document.getElementById("admin_ssc").innerHTML = "Fitur ini masih dalam pengembangan";
            }else{
            document.getElementById("admin_hr").innerHTML = "Menunggu proses HR ";
            document.getElementById("tgl_hr").innerHTML = null;
            document.getElementById("admin_ssc").innerHTML = "Fitur ini masih dalam pengembangan";
            }
            if (ga){
            document.getElementById("admin_ga").innerHTML = "Diketahui oleh " + ga;
            document.getElementById("tgl_ga").innerHTML = tgl_ga;
            }else{
            document.getElementById("admin_ga").innerHTML = "Lembur kamu BELUM/TIDAK diketahui oleh GA";
            document.getElementById("tgl_ga").innerHTML = null;
            }
        })
    });
</script>
