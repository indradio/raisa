<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">

    <!-- 1. Notification -->
      <!-- <div class="row">
        <div class="col-md-12">
          <div class="alert alert-default" role="alert">
            <strong>Butuh bantuan RAISA?</strong>
            </br>
            </br>Silahkan isi form berikut ya!
            </br><a href="#" class="btn btn-info text-white" role="button" aria-disabled="true" data-toggle="modal" data-target="#openTicket">Butuh bantuan? Klik sekarang</a>
          </div>
        </div>
      </div> -->
    <!-- End Notification -->

    <!-- 2. Banner -->
      <?php
      date_default_timezone_set('asia/jakarta');
      $queryLayInfo = "SELECT COUNT(*)
        FROM `informasi`
        WHERE `berlaku` >= CURDATE()
        ORDER BY `id` DESC
      ";
      $layinfo = $this->db->query($queryLayInfo)->row_array();
      $total = $layinfo['COUNT(*)'];
      if ($total != 0) {
        $lay = 12 / $total;
        $queryInfo = "SELECT *
                    FROM `informasi`
                    WHERE `berlaku` >= CURDATE()
                    ORDER BY `id` DESC
                  ";
        $informasi = $this->db->query($queryInfo)->result();
        }
      ?>
    <!-- end banner -->

    <!-- Icon for Mobile -->
    <div class="row">
      <?php foreach ($informasi as $row) : ?>
          <div class="col-md-0 mt-4 d-block d-sm-none">
            <div class="card card-product">
              <div class="card-header card-header-image" data-header-animation="true">
                <a href="#pablo">
                  <img class="img" src="<?= base_url().'assets/img/info/'.$row->gambar_banner; ?>">
                </a>
              </div>
              <div class="card-body">
                <div class="card-actions text-center">
                  <button type="button" class="btn btn-info btn-link fix-broken-card">
                    <i class="material-icons">build</i> Muat Ulang!
                  </button>
                  <a href="#" class="badge badge-pill badge-primary mt-3" rel="tooltip" title="" data-toggle="modal" data-target="#bannerModal" data-gambar="<?= base_url().'assets/img/info/'.$row->gambar_banner; ?>">
                    Selengkapnya...
                  </a>
                </div>
                <h4 class="card-title">
                  <?= $row->judul; ?>
                </h4>
              </div>
            </div>
          </div>
      <?php endforeach; ?>
      <div class="col-md-0 ml-auto mr-auto d-block d-sm-none">
          <div class="card">
              <div class="card-body">
                  <div class="row">
                    <div class="col-3 text-center">
                        <a href="<?= base_url('presensi'); ?>" class="btn btn-lg btn-just-icon btn-success">
                            <i class="fa fa-street-view"></i>
                        </a>
                        </br>
                        <a class="card-title"><small>ABSEN</small></a> 
                      </div>
                      <div class="col-3 text-center">
                          <a href="<?= base_url('lembur'); ?>" class="btn btn-lg btn-just-icon btn-facebook">
                              <i class="fa fa-clock-o"></i>
                          </a>
                          </br>
                          <a class="card-title"><small>OT</small></a> 
                      </div>
                      <div class="col-3 text-center">
                          <a href="<?= base_url('perjalanandl'); ?>" class="btn btn-lg btn-just-icon btn-facebook">
                              <i class="fa fa-car"></i>
                          </a>
                          </br>
                          <a class="card-title"><small>DL</small></a> 
                      </div>
                      <div class="col-3 text-center">
                          <a href="<?= base_url('imp'); ?>" class="btn btn-lg btn-just-icon btn-facebook">
                              <i class="fa fa-plane"></i>
                          </a>
                          </br>
                          <a class="card-title"><small>IMP</small></a> 
                      </div>
                      <div class="col-3 mr-auto text-center">
                          <a href="<?= base_url('cuti'); ?>" class="btn btn-lg btn-just-icon btn-facebook">
                              <i class="fa fa-calendar-times-o"></i>
                          </a>
                          </br>
                          <a class="card-title"><small>CUTI</small></a> 
                      </div>
                  </div>
              </div>
          </div>
          <!--  end card  -->
      </div>  

      <div class="col-md-10 ml-auto mr-auto d-none d-sm-block">
          <div class="card">
            <div class="card-body">
              <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <?php 
                  $i = 1;
                  foreach ($informasi as $row) : 
                    echo '<li data-target="#carouselExampleIndicators" data-slide-to="'.$i.'" class="'.$row->active.'"></li>';
                    $i++;
                  endforeach; 
                  ?>
                </ol>
                <div class="carousel-inner">
                  <?php foreach ($informasi as $row) : ?>
                  <div class="carousel-item <?= $row->active; ?>">
                    <img class="d-block w-100" src="<?= base_url().'assets/img/info/'.$row->gambar_banner; ?>" alt="">
                  </div>
                  <?php endforeach; ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
      </div> 
    </div>
    <!-- Icon for Mobile -->

    <!-- Absensi -->
    <div class="row">
    <!-- <div class="col-md-8">
        <div class="card">
          <div class="card-body">
          <div class="tab-content tab-space">
                            <div class="tab-pane active" id="link1">
                                <div class="embed-responsive embed-responsive-4by3">
                                    <iframe class="embed-responsive-item" src="https://docs.google.com/document/d/1kaQakHREfV1lQPkoXfqtxHEFf99iGrzbN4sfL2AnlSM/edit?usp=sharing"></iframe>
                                </div>
                            </div>
                        </div>
          </div>
        </div>
      </div> -->
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div id="accordionAbsensi" role="tablist">
              <div class="card-collapse">
                <div class="card-header" role="tab" id="headingAbsensi">
                  <h5 class="mb-0">
                    <a class="" data-toggle="collapse" href="#collapseAbsensi" aria-expanded="true" aria-controls="collapseAbsensi">
                    <h3 class="card-title">Absensi
                      <i class="material-icons">keyboard_arrow_down</i>
                    </h3>
                    </a>
                  </h5>
                </div>
                <div id="collapseAbsensi" class="collapse show" role="tabpanel" aria-labelledby="headingAbsensi" data-parent="#accordion">
                  <div class="card-body">
                    <div class="material-datatables">
                      <table id="dtpresensi" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%"></table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Absensi -->

    <div class="row">

      <!-- Outstanding Approval Absensi -->
      <?php if ($presensi != null){ ?>
      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header card-header-text card-header-warning">
            <div class="card-text">
              <h4 class="card-title">Outstanding</h4>
              <p class="card-category">Kehadiran</p>
            </div>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-warning">
                <th>Nama</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Direct</th>
              </thead>
              <tbody>
              <?php foreach ($presensi as $row) : ?>
              <tr onclick="window.location='<?= base_url('presensi/persetujuan/1/list'); ?>'" >
                <td><?= $row['nama']; ?></td>
                <td><?= date('d-M-Y H:i', strtotime($row['time'])); ?></td>
                <td><?= $row['work_state']; ?></td>
                <td><?= $row['state']; ?></td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php }; ?>

      <!-- Outstanding Approval Perjalanan -->
      <?php if ($Reservasi != null){ ?>
      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header card-header-text card-header-warning">
            <div class="card-text">
              <h4 class="card-title">Outstanding</h4>
              <p class="card-category">Perjalanan</p>
            </div>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-warning">
                <th>Peserta</th>
                <th>Tanggal</th>
                <th>Tujuan</th>
              </thead>
              <tbody>
              <?php foreach ($Reservasi as $row) : ?>
              <tr onclick="window.location='<?= base_url('persetujuandl'); ?>'" >
                <td><?= $row['anggota']; ?></td>
                <td><?= date('d-M', strtotime($row['tglberangkat'])); ?></td>
                <td><?= $row['tujuan']; ?></td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php }; ?>
        
      <!-- Outstanding Approval Lembur -->
      <?php if ($RencanaLembur != null or $RealisasiLembur != null){ ?>
      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header card-header-text card-header-warning">
            <div class="card-text">
              <h4 class="card-title">Outstanding</h4>
              <p class="card-category">Lembur</p>
            </div>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-warning">
                <th>Nama</th>
                <th>Waktu</th>
                <th>Durasi</th>
              </thead>
              <tbody>
              <?php foreach ($RencanaLembur as $row) : ?>
              <tr onclick="window.location='<?= base_url('lembur/persetujuan/rencana/') . $row['id']; ?>'" >
                <td><?= $row['nama']; ?> <small>(Rencana)</small></td>
                <td><?= date('d-M H:i', strtotime($row['tglmulai_rencana'])); ?></td>
                <td><?= $row['durasi_rencana']; ?> Jam</td>
              </tr>
              <?php endforeach; ?>
              <?php foreach ($RealisasiLembur as $row) : ?>
              <tr onclick="window.location='<?= base_url('lembur/persetujuan/realisasi/') . $row['id']; ?>'" >
                <td><?= $row['nama']; ?> <small>(Realisasi)</small></td>
                <td><?= date('d-M H:i', strtotime($row['tglmulai'])); ?></td>
                <td><?= $row['durasi']; ?> Jam</td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php }; ?>

      <!-- Outstanding Approval Cuti -->
      <?php if ($Cuti != null){ ?>
      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header card-header-text card-header-warning">
            <div class="card-text">
              <h4 class="card-title">Outstanding</h4>
              <p class="card-category">Cuti</p>
            </div>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-warning">
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Lama</th>
              </thead>
              <tbody>
              <?php foreach ($Cuti as $row) : ?>
              <tr onclick="window.location='<?= base_url('cuti/approval'); ?>'" >
                <td><?= $row['nama']; ?></td>
                <td><?= date('d-M', strtotime($row['tgl1'])); ?></td>
                <td><?= $row['lama']; ?> Hari</td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php }; ?>

      <!-- Outstanding Approval IMP -->
      <?php if ($imp != null){ ?>
      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-header card-header-text card-header-warning">
            <div class="card-text">
              <h4 class="card-title">Outstanding</h4>
              <p class="card-category">IMP</p>
            </div>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-warning">
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Jam</th>
              </thead>
              <tbody>
              <?php foreach ($imp as $row) : ?>
              <tr onclick="window.location='<?= base_url('imp/approval/outstanding'); ?>'" >
                <td><?= $row['name']; ?></td>
                <td><?= date('d-M', strtotime($row['date'])); ?></td>
                <td><?= date('H:i', strtotime($row['start_time'])).' - '.date('H:i', strtotime($row['end_time'])); ?></td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php }; ?>
    
    </div>
    
    <!-- 3. Perjalanan -->
    <div class="row">
                  <?php foreach ($kendaraan as $rowCars) : ?>
                    <div class="col-lg-2 col-md-4 col-sm-6 mt-0 mb-0">
                      <!-- Search from PERJALANAN -->
                      <?php
                      $nopol = $rowCars['nopol'];
                      $queryPerjalanan = "SELECT *
                                          FROM `perjalanan`
                                          WHERE `nopol` = '$nopol' AND `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND  (`status` = 1 OR `status` = 2 OR `status` = 8)
                                          ";
                      $p = $this->db->query($queryPerjalanan)->row_array();
                      if ($p) {
                      $status = $this->db->get_where('perjalanan_status', ['id' => $p['status']])->row_array(); 
                      $peserta = $this->db->get_where('perjalanan_anggota', ['perjalanan_id' => $p['id']])->result_array();
                      $tujuan = $this->db->get_where('perjalanan_tujuan', ['perjalanan_id' => $p['id']])->result_array(); ?>

                        <div class="card">
                          <div class="card-header <?= ($p['status'] == 2)? 'card-header-danger' : 'card-header-info';?> card-header-icon">
                              <!-- <div class="card-icon">
                                <i class="material-icons">emoji_transportation</i>
                              </div> -->
                                <?php if ($p['status'] == 1) { ?>
                                  <h4 class="card-title"><a href="#" class="btn btn-sm btn-info">READY</a></h4>
                                <?php } elseif ($p['status'] == 2) { ?>
                                  <h4 class="card-title"><a href="#" class="btn btn-sm btn-danger">ON DUTY</a></h4>
                                <?php }; ?>
                          </div>
                          <div class="card-body text-center">
                              <div class="img-container">
                                  <img src="<?= base_url(); ?>assets/img/kendaraan/<?= ($p['status'] == 2)? 'onduty' : 'ready';?>.png" alt="...">
                              </div>
                              </div>
                              <div class="card-footer" style="display:block;">
                                <div class="bootstrap-tagsinput info-badge">
                                    <?php foreach ($peserta as $row) : ?>
                                      <span class="tag badge" data-toggle="tooltip" data-placement="top" title="<?= $row['karyawan_nama']; ?>"><?= $row['karyawan_inisial']; ?></span><span data-role="remove"></span>
                                    <?php endforeach; ?>
                                </div>
                            <div data-toggle="tooltip" data-placement="top" title="<?php 
                                  foreach ($tujuan as $row) :
                                    echo $row['nama']. "\r\n";
                                  endforeach; ?>">
                                &nbsp;<i class="fa fa-map-marker text-success"></i> &nbsp;<?= $p['tujuan']; ?>
                            </div>
                              <i class="fa fa-clock-o text-success"> </i>
                              <?php if ($p['jenis_perjalanan']=='TA') : 
                                echo date('d-M', strtotime($p['tglberangkat'])) . ' ' . date('H:i', strtotime($p['jamberangkat'])) ." - ". date('d-M', strtotime($p['tglkembali'])) . ' ' . date('H:i', strtotime($p['jamkembali'])); 
                              else :
                                echo date('H:i', strtotime($p['jamberangkat'])) ." - <small>". date('H:i', strtotime($p['jamkembali']))."</small>"; 
                              endif; ?></br>
                              <i class="fa fa-car text-success"> </i> <?= $p['nopol']; ?> - <small><?= $p['kendaraan']; ?></small>
                              <div id="accordion" role="tablist">
                                <div class="card card-collapse">
                                  <div class="card-header" role="tab" id="heading<?=$p['id']; ?>">
                                    <h5 class="mb-0">
                                      <a class="collapsed" data-toggle="collapse" href="#collapse<?=$p['id']; ?>" aria-expanded="false" aria-controls="collapse<?=$p['id']; ?>">
                                        Details
                                        <i class="material-icons">keyboard_arrow_down</i>
                                      </a>
                                    </h5>
                                  </div>
                                  <div id="collapse<?=$p['id']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?=$p['id']; ?>" data-parent="#accordion">
                                    <div class="card-body">
                                      <div><?=$p['copro']; ?></div>
                                      <div><?=$p['keperluan']; ?></div>
                                    </div>
                                  </div>
                                </div>
                                <div class="card card-collapse">
                                  <div class="card-header" role="tab" id="heading<?=$rowCars['device_id']; ?>">
                                    <h5 class="mb-0">
                                      <a class="collapsed" data-toggle="collapse" href="#collapse<?=$rowCars['device_id']; ?>" aria-expanded="false" aria-controls="collapse<?=$rowCars['device_id']; ?>">
                                        Track
                                        <i class="material-icons">keyboard_arrow_down</i>
                                      </a>
                                    </h5>
                                  </div>
                                  <div id="collapse<?=$rowCars['device_id']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?=$rowCars['device_id']; ?>" data-parent="#accordion">
                                    <div class="card-body">
                                      <div id="<?=$rowCars['device_id']; ?>" class="map" style="width:100%;margin:0px;"></div>
                                      <small><div id="loc<?=$rowCars['device_id']; ?>"></div></small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>

                      <?php } else { 
                        $queryReservasi = "SELECT *
                                          FROM `reservasi`
                                          WHERE `nopol` = '$nopol' AND `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND  `status` != 0 AND `status` != 9
                                          ";
                        $r = $this->db->query($queryReservasi)->row_array();
                        if ($r) { 
                          $status = $this->db->get_where('reservasi_status', ['id' => $r['status']])->row_array(); 
                          $peserta = $this->db->get_where('perjalanan_anggota', ['reservasi_id' => $r['id']])->result_array();
                          $tujuan = $this->db->get_where('perjalanan_tujuan', ['reservasi_id' => $r['id']])->result_array(); ?>
                        
                        <div class="card">
                            <div class="card-header card-header-warning card-header-icon">
                              <!-- <div class="card-icon">
                                <i class="material-icons">emoji_transportation</i>
                              </div> -->
                              <?php if ($r['status'] == 1) { ?>
                                <h4 class="card-title"><a href="#" class="btn btn-sm btn-warning">Waiting | <?= $r['atasan1']; ?></a></h4>
                                <?php } elseif ($r['status'] == 2) { ?>
                                  <h4 class="card-title"><a href="#" class="btn btn-sm btn-warning">Waiting | <?= $r['atasan2']; ?></a></h4>
                                  <?php } elseif ($r['status'] == 3) { ?>
                                    <h4 class="card-title"><a href="#" class="btn btn-sm btn-warning">Waiting | FIN</a></h4>
                                    <?php } elseif ($r['status'] == 4) { ?>
                                      <h4 class="card-title"><a href="#" class="btn btn-sm btn-warning">Waiting | EJU</a></h4>
                                      <?php } elseif ($r['status'] == 5) { ?>
                                        <h4 class="card-title"><a href="#" class="btn btn-sm btn-warning">Waiting | HR</a></h4>
                                        <?php } elseif ($r['status'] == 6) { ?>
                                          <h4 class="card-title"><a href="#" class="btn btn-sm btn-warning">Waiting | GA</a></h4>
                                    <?php }; ?>
                            </div>
                          <div class="card-body text-center">
                              <div class="img-container">
                                  <img src="<?= base_url(); ?>assets/img/kendaraan/reserved.png" alt="...">
                              </div>
                          </div>
                          <div class="card-footer" style="display:block;">
                            <div class="bootstrap-tagsinput info-badge">
                                <?php foreach ($peserta as $row) : ?>
                                  <span class="tag badge" data-toggle="tooltip" data-placement="top" title="<?= $row['karyawan_nama']; ?>"><?= $row['karyawan_inisial']; ?></span><span data-role="remove"></span>
                                <?php endforeach; ?>
                            </div>
                            <div data-toggle="tooltip" data-placement="top" title="<?php 
                                  foreach ($tujuan as $row) :
                                    echo $row['nama']. "\r\n";
                                  endforeach; ?>">
                                &nbsp;<i class="fa fa-map-marker text-success"></i> &nbsp;<?= $r['tujuan']; ?>
                            </div>
                              <i class="fa fa-clock-o text-success"> </i>
                              <?php if ($r['jenis_perjalanan']=='TA') : 
                                echo date('d-M', strtotime($r['tglberangkat'])) . ' ' . date('H:i', strtotime($r['jamberangkat'])) ." - ". date('d-M', strtotime($r['tglkembali'])) . ' ' . date('H:i', strtotime($r['jamkembali'])); 
                              else :
                                echo date('H:i', strtotime($r['jamberangkat'])) ." - ". date('H:i', strtotime($r['jamkembali'])); 
                              endif; ?></br>
                              <i class="fa fa-car text-success"> </i> <?= $r['nopol']; ?> - <small><?= $r['kendaraan']; ?></small>
                            
                            <div id="accordion" role="tablist">
                              <div class="card card-collapse">
                                <div class="card-header" role="tab" id="heading<?=$r['id']; ?>">
                                  <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapse<?=$r['id']; ?>" aria-expanded="false" aria-controls="collapse<?=$r['id']; ?>">
                                      Details
                                      <i class="material-icons">keyboard_arrow_down</i>
                                    </a>
                                  </h5>
                                </div>
                                <div id="collapse<?=$r['id']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?=$r['id']; ?>" data-parent="#accordion">
                                  <div class="card-body">
                                    <div><?=$r['copro']; ?></div>
                                    <div><?=$r['keperluan']; ?></div>
                                  </div>
                                </div>
                              </div>
                              <div class="card card-collapse">
                                  <div class="card-header" role="tab" id="heading<?=$rowCars['device_id']; ?>">
                                    <h5 class="mb-0">
                                      <a class="collapsed" data-toggle="collapse" href="#collapse<?=$rowCars['device_id']; ?>" aria-expanded="false" aria-controls="collapse<?=$rowCars['device_id']; ?>">
                                        Track
                                        <i class="material-icons">keyboard_arrow_down</i>
                                      </a>
                                    </h5>
                                  </div>
                                  <div id="collapse<?=$rowCars['device_id']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?=$rowCars['device_id']; ?>" data-parent="#accordion">
                                    <div class="card-body">
                                      <div id="<?=$rowCars['device_id']; ?>" class="map" style="width:100%;margin:0px;"></div>
                                      <small><div id="loc<?=$rowCars['device_id']; ?>"></div></small>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                        <?php } else { ?>
                          <div class="card">
                            <div class="card-header card-header-success card-header-icon">
                              <!-- <div class="card-icon">
                                <i class="material-icons">emoji_transportation</i>
                              </div> -->
                              <h4 class="card-title"><a href="<?= base_url('reservasi/dl'); ?>" class="btn btn-sm btn-success">AVAILABLE</a></h4>
                            </div>
                            <div class="card-body text-center">
                                <div class="img-container">
                                  <img src="<?= base_url(); ?>assets/img/kendaraan/available.png" alt="...">
                                </div>
                            </div>
                                <div class="card-footer" style="display:block;">
                                <i class="fa fa-car text-success"> </i> <?= $rowCars['nopol']; ?> - <small><?= $rowCars['nama']; ?></small>
                                <div id="accordion" role="tablist">
                                  <div class="card card-collapse">
                                    <div class="card-header" role="tab" id="heading<?=$rowCars['device_id']; ?>">
                                      <h5 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapse<?=$rowCars['device_id']; ?>" aria-expanded="false" aria-controls="collapse<?=$rowCars['device_id']; ?>">
                                          Track
                                          <i class="material-icons">keyboard_arrow_down</i>
                                        </a>
                                      </h5>
                                    </div>
                                    <div id="collapse<?=$rowCars['device_id']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?=$rowCars['device_id']; ?>" data-parent="#accordion">
                                      <div class="card-body">
                                        <div id="<?=$rowCars['device_id']; ?>" class="map" style="width:100%;margin:0px;"></div>
                                        <small><div id="loc<?=$rowCars['device_id']; ?>"></div></small>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        <?php }; ?>
                      <?php }; ?>
                    </div>
                  <?php endforeach; ?>
                  <!-- Perjalanan Non Operasional -->
                  <?php
                          $queryPerjalananNon = "SELECT *
                                            FROM `perjalanan`
                                                WHERE `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND `kepemilikan` != 'Operasional' AND (`status` = 1 OR `status` = 2 OR `status` = 8)
                                                ORDER BY `kepemilikan` ASC ";
                          $perjalananNon = $this->db->query($queryPerjalananNon)->result_array();
                          foreach ($perjalananNon as $pn) : 
                            $status = $this->db->get_where('perjalanan_status', ['id' => $pn['status']])->row_array(); 
                            $peserta = $this->db->get_where('perjalanan_anggota', ['perjalanan_id' => $pn['id']])->result_array();
                            $tujuan = $this->db->get_where('perjalanan_tujuan', ['perjalanan_id' => $pn['id']])->result_array(); ?>
                      <div class="col-lg-2 col-md-4 col-sm-6 mt-0 mb-0">
                        <div class="card">
                          <div class="card-header <?= ($pn['status'] == 2)? 'card-header-danger' : 'card-header-info';?> card-header-icon">
                              <div class="card-icon">
                                <i class="material-icons">emoji_transportation</i>
                              </div>
                                <?php if ($pn['status'] == 1) { ?>
                                  <h4 class="card-title"><a href="#" class="btn btn-sm btn-info">READY</a></h4>
                                <?php } elseif ($pn['status'] == 2) { ?>
                                  <h4 class="card-title"><a href="#" class="btn btn-sm btn-danger">ON DUTY</a></h4>
                                <?php }; ?>
                           
                          </div>
                          <div class="card-body text-center">
                              <div class="img-container">
                                  <img src="<?= base_url(); ?>assets/img/kendaraan/<?= ($pn['status'] == 2)? 'onduty' : 'ready';?>.png" alt="...">
                              </div>
                            </div>
                              <div class="card-footer" style="display:block;">
                                <div class="bootstrap-tagsinput info-badge">
                                    <?php foreach ($peserta as $row) : ?>
                                      <span class="tag badge" data-toggle="tooltip" data-placement="top" title="<?= $row['karyawan_nama']; ?>"><?= $row['karyawan_inisial']; ?></span><span data-role="remove"></span>
                                    <?php endforeach; ?>
                                </div>
                            <div data-toggle="tooltip" data-placement="top" title="<?php 
                                  foreach ($tujuan as $row) :
                                    echo $row['nama']. "\r\n";
                                  endforeach; ?>">
                                &nbsp;<i class="fa fa-map-marker text-success"></i> &nbsp;<?= $pn['tujuan']; ?>
                            </div>
                              <i class="fa fa-clock-o text-success"> </i>
                              <?php if ($pn['jenis_perjalanan']=='TA') : 
                                echo date('d-M', strtotime($pn['tglberangkat'])) . ' ' . date('H:i', strtotime($pn['jamberangkat'])) ." - ". date('d-M', strtotime($pn['tglkembali'])) . ' ' . date('H:i', strtotime($pn['jamkembali'])); 
                              else :
                                echo date('H:i', strtotime($pn['jamberangkat'])) ." - <small>". date('H:i', strtotime($pn['jamkembali']))."</small>"; 
                              endif; ?></br>
                              <i class="fa fa-car text-success"> </i> <?= $pn['nopol']; ?> - <small><?= $pn['kendaraan']; ?></small>
                              <div id="accordion" role="tablist">
                                <div class="card card-collapse">
                                  <div class="card-header" role="tab" id="heading<?=$pn['id']; ?>">
                                    <h5 class="mb-0">
                                      <a class="collapsed" data-toggle="collapse" href="#collapse<?=$pn['id']; ?>" aria-expanded="false" aria-controls="collapse<?=$pn['id']; ?>">
                                        Details
                                        <i class="material-icons">keyboard_arrow_down</i>
                                      </a>
                                    </h5>
                                  </div>
                                  <div id="collapse<?=$pn['id']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?=$pn['id']; ?>" data-parent="#accordion">
                                    <div class="card-body">
                                      <div><?=$pn['copro']; ?></div>
                                      <div><?=$pn['keperluan']; ?></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                        </div>
                        <?php endforeach; ?>
                         <!-- Reservasi Non Operasional -->
                          <?php
                          $queryReservasiNon = "SELECT *
                                              FROM `reservasi`
                                              WHERE `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND `kepemilikan` != 'Operasional' AND `status` > 0 AND `status` < 7
                                              ORDER BY `kepemilikan` ASC ";
                          $reservasiNon = $this->db->query($queryReservasiNon)->result_array();
                          foreach ($reservasiNon as $rn) : 
                            $status = $this->db->get_where('reservasi_status', ['id' => $rn['status']])->row_array(); 
                            $peserta = $this->db->get_where('perjalanan_anggota', ['reservasi_id' => $rn['id']])->result_array();
                            $tujuan = $this->db->get_where('perjalanan_tujuan', ['reservasi_id' => $rn['id']])->result_array(); ?>
                          <div class="col-lg-2 col-md-4 col-sm-6 mt-0 mb-0">
                            <div class="card">
                              <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">emoji_transportation</i>
                                </div>
                                <?php if ($rn['status'] == 1) { ?>
                                <h4 class="card-title"><a href="#" class="btn btn-sm btn-warning">Waiting | <?= $rn['atasan1']; ?></a></h4>
                                <?php } elseif ($rn['status'] == 2) { ?>
                                  <h4 class="card-title"><a href="#" class="btn btn-sm btn-warning">Waiting | <?= $rn['atasan2']; ?></a></h4>
                                  <?php } elseif ($rn['status'] == 3) { ?>
                                    <h4 class="card-title"><a href="#" class="btn btn-sm btn-warning">Waiting | FIN</a></h4>
                                    <?php } elseif ($rn['status'] == 4) { ?>
                                      <h4 class="card-title"><a href="#" class="btn btn-sm btn-warning">Waiting | EJU</a></h4>
                                      <?php } elseif ($rn['status'] == 5) { ?>
                                        <h4 class="card-title"><a href="#" class="btn btn-sm btn-warning">Waiting | HR</a></h4>
                                        <?php } elseif ($rn['status'] == 6) { ?>
                                          <h4 class="card-title"><a href="#" class="btn btn-sm btn-warning">Waiting | GA</a></h4>
                                    <?php }; ?>
                              </div>
                              <div class="card-body text-center">
                                <div class="img-container">
                                    <img src="<?= base_url(); ?>assets/img/kendaraan/reserved.png" alt="...">
                                </div>
                              </div>
                              <div class="card-footer" style="display:block;">
                                <div class="bootstrap-tagsinput info-badge">
                                    <?php foreach ($peserta as $row) : ?>
                                      <span class="tag badge" data-toggle="tooltip" data-placement="top" title="<?= $row['karyawan_nama']; ?>"><?= $row['karyawan_inisial']; ?></span><span data-role="remove"></span>
                                    <?php endforeach; ?>
                                </div>
                                <div data-toggle="tooltip" data-placement="top" title="<?php 
                                      foreach ($tujuan as $row) :
                                        echo $row['nama']. "\r\n";
                                      endforeach; ?>">
                                    &nbsp;<i class="fa fa-map-marker text-success"></i> &nbsp;<?= $rn['tujuan']; ?>
                                </div>
                                  <i class="fa fa-clock-o text-success"> </i>
                                  <?php if ($rn['jenis_perjalanan']=='TA') : 
                                    echo date('d-M', strtotime($rn['tglberangkat'])) . ' ' . date('H:i', strtotime($rn['jamberangkat'])) ." - ". date('d-M', strtotime($rn['tglkembali'])) . ' ' . date('H:i', strtotime($rn['jamkembali'])); 
                                  else :
                                    echo date('H:i', strtotime($rn['jamberangkat'])) ." - ". date('H:i', strtotime($rn['jamkembali'])); 
                                  endif; ?></br>
                                  <i class="fa fa-car text-success"> </i> <?= $rn['nopol']; ?> - <small><?= $rn['kendaraan']; ?></small>
                              
                                <div id="accordion" role="tablist">
                                  <div class="card card-collapse">
                                    <div class="card-header" role="tab" id="heading<?=$rn['id']; ?>">
                                      <h5 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapse<?=$rn['id']; ?>" aria-expanded="false" aria-controls="collapse<?=$rn['id']; ?>">
                                          Details
                                          <i class="material-icons">keyboard_arrow_down</i>
                                        </a>
                                      </h5>
                                    </div>
                                    <div id="collapse<?=$rn['id']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?=$rn['id']; ?>" data-parent="#accordion">
                                      <div class="card-body">
                                        <div><?=$rn['copro']; ?></div>
                                        <div><?=$rn['keperluan']; ?></div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php endforeach; ?>
    </div>
    <!-- end Perjalanan -->

  </div>
  <!-- end container-fluid -->
</div>
<!-- end content -->

<!-- Modal Detail -->
<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="detailTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-info text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">DETAIL PERJALANAN</h4>
          </div>
        </div>
        <form class="form-horizontal">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div id="map" class="map" style="width:100%;height:380px;"></div>
              </div>
            </div>
            <div class="row">
              <label class="col-md-3 col-form-label">Device ID</label>
              <div class="col-md-9">
                <div class="form-group has-default">
                  <input type="text" class="form-control" name="device_id" id="device_id" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-md-3 col-form-label">Nomor Polisi</label>
              <div class="col-md-9">
                <div class="form-group has-default">
                  <input type="text" class="form-control" name="nopol" id="nopol" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-md-3 col-form-label">Lokasi</label>
              <div class="col-md-9">
                <div class="form-group has-default">
                  <textarea rows="3" class="form-control disabled" name="lokasi" id="lokasi" disabled></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-md-3 col-form-label">Ignition</label>
              <div class="col-md-9">
                <div class="form-group has-default">
                  <input type="text" class="form-control" name="ignition" id="ignition" disabled>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Banner Modal -->
<div class="modal fade" id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="bannerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <img id="gambar" name="gambar" class="img-fluid" />
    </div>
  </div>
</div>

<!-- Add Claim Medical Modal -->
<div class="modal fade" id="tambahClaim" tabindex="-1" role="dialog" aria-labelledby="#tambahClaimTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-info text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">CLAIM MEDICAL</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('dashboard/medical/add'); ?>">
          <div class="modal-body">
            <div class="row">
              <label class="col-md-4 col-form-label">Karyawan</label>
              <div class="col-md-7">
                <div class="form-group has-default">
                  <select class="selectpicker" data-style="select-with-transition" id="karyawan" name="karyawan[]" multiple title="Pilih Karyawan" data-size="7" data-live-search="true" required>
                    <?php
                    foreach ($listkaryawan as $row) {
                      echo '<option value="' . $row->npk . '">' . $row->nama . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-md-4 col-form-label">Transfer</label>
              <div class="col-md-7">
                <input type="text" class="form-control datepicker" id="tgltransfer" name="tgltransfer" required>
              </div>
            </div>
            <div class="modal-footer justify-content-right">
              <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                <button type="submit" class="btn btn-success">SUBMIT MEDICAL</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Clear Claim Medical Modal -->
<div class="modal fade" id="emptyClaim" tabindex="-1" role="dialog" aria-labelledby="emptyClaimLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Kamu yakin mau menghapus semua data ini?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" action="<?= base_url('dashboard/medical/empty'); ?>">
        <div class="modal-body">
          <input type="hidden" class="form-control" id="id" name="id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
          <button type="submit" class="btn btn-danger">YA, HAPUS!</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Aktivasi ASTRAPAY Modal -->
<div class="modal fade" id="updateEwallet" tabindex="-1" role="dialog" aria-labelledby="#updateEwalletTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-info text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">ASTRAPAY</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('profil/update_ewallet'); ?>">
          <div class="modal-body">
            <input type="hidden" class="form-control" name="ewallet" id="ewallet" value="ASTRAPAY"/>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nomor HP*</label>
                        <input type="text" class="form-control" name="rek" id="rek" value=""/>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-right">
              <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                <button type="submit" class="btn btn-success">AKTIFKAN</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Javascript -->
<script>
  $(document).ready(function() {

    let timerInterval
    <?php if ($this->session->flashdata('message')=='masuk'){ ?> 
      
        // Swal.fire({
        //   title: 'Selamat Hari Raya Idul Fitri 1443H',
        //   html: '',
        //   imageUrl: '<?= base_url(); ?>/assets/img/info/idul-fitri-1443H.jpg',
        //   imageWidth: 400,
        //   imageHeight: 200,
        //   imageAlt: 'Custom image',
        //   timer: 5000,
        //   timerProgressBar: true,
        //   showConfirmButton: false,
        //   willClose: () => {
        //     clearInterval(timerInterval)
        //   }
        // }).then((result) => {
        //   /* Read more about handling dismissals below */
        //   if (result.dismiss === Swal.DismissReason.timer) {
        //     console.log('I was closed by the timer')
        //   }
        // });
       
     <?php }; ?>

    $('#dtpresensi').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
      serverSide: false,
      processing: true,
      ajax: {
              "url"   : "<?= site_url('presensi/get_data/today') ?>",
              "type"  : "POST",
          },
      columns: [
        { "data":"status"},
        { "data":"time"}
      ],
    });

    $('#hapusClaim').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id') // Extract info from data-* attributes
      var modal = $(this)
      modal.find('.modal-body input[name="id"]').val(id)
    });

    $('#bannerModal').on('show.bs.modal', function(event) {
      var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
      var modal = $(this)
      modal.find('#gambar').attr('src', div.data('gambar'));
    });

    window.setTimeout(function() {
      $(".alert").fadeTo(200, 0).slideUp(200, function() {
        $(this).remove();
      });
    }, 60000);

    // $('#detail').on('show.bs.modal', function(event) {
    //   var button = $(event.relatedTarget) // Button that triggered the modal
    //   var id = button.data('id') // Extract info from data-* attributes
    //   var modal = $(this)
    //   modal.find('.modal-body input[name="device_id"]').val(id)

    // setInterval(function() {

      const cars = ["2020080159", "2020080160", "2020080161", "2020080162", "2020080163"];

      for (let i = 0; i < cars.length; i++) {

        var xhr = new XMLHttpRequest();
        xhr.open("POST", 'https://gps.intellitrac.co.id/apis/tracking/realtime.php', true);

        //Send the proper header information along with the request
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() { // Call a function when the state changes.
          if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            var myObj = JSON.parse(this.responseText);
            var image = 'https://raisa.winteq-astra.com/assets/img/iconmobil.png';
            var idloc = "loc" + cars[i];
            var lat = "lat" + cars[i];
            var lng = "lng" + cars[i]; 
            
            loc = myObj.data[cars[i]]['realtime']['location'];
            // z + cars[i] = myObj.data[cars[i]]['realtime']['ignition_status'];
            lat = myObj.data[cars[i]]['realtime']['latitude'];
            lng = myObj.data[cars[i]]['realtime']['longitude'];
            
            var mapCanvas = document.getElementById(cars[i]);
            document.getElementById(idloc).innerHTML = loc;
            
            var location = new google.maps.LatLng(lat, lng);
            var mapOptions = {
              center: location,
              zoom: 15,
              mapTypeId: "satellite",
              mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map(mapCanvas, mapOptions);

            var marker = new google.maps.Marker({
              position: location,
              icon: image
            });
            
            marker.setMap(map);
          }
        }
      xhr.send("username=winteq&password=winteq1231407&devices=2020080159%3B2020080160%3B2020080161%3B2020080162%3B2020080163");
      }

    // }, 5000);

    var checker = document.getElementById('check');
    var sendbtn = document.getElementById('submit');
    sendbtn.disabled = true;

    // when unchecked or checked, run the function
    checker.onchange = function() {
      if (this.checked) {
        sendbtn.disabled = false;
      } else {
        sendbtn.disabled = true;
      }
    }

    var cJamkerja = $('#calendarJamkerja');

    today = new Date();
    y = today.getFullYear();
    m = today.getMonth();
    d = today.getDate();

    cJamkerja.fullCalendar({
      timeZone: 'asia/jakarta', // the default (unnecessary to specify)
      viewRender: function(view, element) {
        // We make sure that we activate the perfect scrollbar when the view isn't on Month
        if (view.name != 'month') {
          $(element).find('.fc-scroller').perfectScrollbar();
        }
      },
      header: {
        left: 'month',
        center: 'title',
        right: 'prev,next,today'
      },

      firstDay: 1,
      defaultDate: today,
      businessHours: [{
        default: false,
        // days of week. an array of zero-based day of week integers (0=Sunday)
        dow: [1, 2, 3, 4, 5], // Monday - Friday
        start: '07:30', // a start time 
        end: '16:30' // an end time 
      }],

      views: {
        month: { // name of view
          titleFormat: 'MMMM YYYY'
          // other view-specific options here
        },
        week: {
          titleFormat: " MMMM D YYYY"
        },
        day: {
          titleFormat: 'D MMM, YYYY'
        }
      },

      selectable: true,
      selectHelper: true,
      editable: true,

      eventSources: [{
          events: function(start, end, timezone, callback) {
            $.ajax({
              url: '<?php echo base_url() ?>jamkerja/GET_MY_jamkerja',
              dataType: 'json',
              success: function(msg) {
                var events = msg.events;
                callback(events);
              }
            });
          }
        },
        {
          events: function(start, end, timezone, callback) {
            $.ajax({
              url: '<?php echo base_url() ?>jamkerja/GET_MY_lembur',
              dataType: 'json',
              success: function(msg) {
                var events = msg.events;
                callback(events);
              }
            });
          },
          color: 'red' // an option!
        },
      ],
      eventLimit: true, // allow "more" link when too many events

      select: function(start, end, info) {
        window.location = 'https://raisa.winteq-astra.com/jamkerja/tanggal/' + start.format();
      },
    });    

  });
</script>