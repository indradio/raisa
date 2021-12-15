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

    <!-- 1.1 Temp Dompet ASTRAPAY -->
    <div class="row">
    <?php if (empty($karyawan['ewallet_3'])){ ?>
      <div class="col-md-4 mt-2">
      <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">account_balance_wallet</i>
              </div>
              <h4 class="card-title">ASTRAPAY
                <small> - Dompet Digital</small>
              </h4>
            </div>
            <div class="card-body">
              <div class="form-group">
                  <label class="bmd-label-floating">NO HP</label>
                  <div class="input-group">
                      <input type="text" class="form-control" value="<?= $karyawan['ewallet_3']; ?>" disabled>
                      <div class="input-group-prepend">
                          <span class="input-group-text">
                              <a href="#" class="btn btn-link btn-success" data-toggle="modal" data-target="#updateEwallet">Aktifkan</a>
                          </span>
                      </div>
                  </div>
              </div>
            </div>
          </div>
      </div>
    
    <?php }; ?>

    
    <!-- 1.2 Survey  -->
    
      <div class="col-md-4 mt-2">
      <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">event_busy</i>
              </div>
              <h4 class="card-title">CUTI
                <small> - Segera Hadir</small>
              </h4>
            </div>
            <div class="card-body">
              <div class="form-group">
                <h4 class="card-title"><b>Kalo ada fitur cuti di-raisa, apa sih yg jadi ekspektasi kamu?</b></h4>
                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#surveyCuti">Kirim ide!</a>
              </div>
            </div>
          </div>
      </div>
    </div>

    <!-- 2. Banner -->
    <div class="row">
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
        $informasi = $this->db->query($queryInfo)->result_array();
      ?>
        <?php foreach ($informasi as $info) : ?>
          <div class="col-md-<?= $lay; ?>">
            <div class="card card-product">
              <div class="card-header card-header-image" data-header-animation="true">
                <a href="#pablo">
                  <img class="img" src="<?= base_url(); ?>assets/img/info/<?= $info['gambar_banner']; ?>">
                </a>
              </div>
              <div class="card-body">
                <div class="card-actions text-center">
                  <button type="button" class="btn btn-info btn-link fix-broken-card">
                    <i class="material-icons">build</i> Muat Ulang!
                  </button>
                  <a href="#" class="badge badge-pill badge-primary mt-3" rel="tooltip" title="" data-toggle="modal" data-target="#bannerModal" data-gambar="<?= base_url(); ?>assets/img/info/<?= $info['gambar_konten']; ?>">
                    Selengkapnya...
                  </a>
                </div>
                <h4 class="card-title">
                  <?= $info['judul']; ?>
                </h4>
              </div>
            </div>
          </div>
      <?php endforeach;
      } ?>
    </div>
    <!-- end banner -->
    
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
                              <div class="card-icon">
                                <i class="material-icons">emoji_transportation</i>
                              </div>
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
                              <div class="card-icon">
                                <i class="material-icons">emoji_transportation</i>
                              </div>
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
                              <div class="card-icon">
                                <i class="material-icons">emoji_transportation</i>
                              </div>
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

    <!-- 3. Sales Report -->
    <?php if ($this->session->userdata('posisi_id') == 1 or $this->session->userdata('posisi_id') == 2 or $this->session->userdata('posisi_id') == 3) { ?>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <h4 class="card-title">Laporan Pendapatan
                <small> - Revenue</small>
              </h4>
            </div>
            <div class="card-body">
              <div id="revenueChartDash" class="ct-chart"></div>
              <div class="material-datatables">
                <table id="revenueTables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Januari</th>
                      <th>Februari</th>
                      <th>Maret</th>
                      <th>April</th>
                      <th>Mei</th>
                      <th>Juni</th>
                      <th>Juli</th>
                      <th>Agustus</th>
                      <th>September</th>
                      <th>Oktober</th>
                      <th>November</th>
                      <th>Desember</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th></th>
                      <th>Januari</th>
                      <th>Februari</th>
                      <th>Maret</th>
                      <th>April</th>
                      <th>Mei</th>
                      <th>Juni</th>
                      <th>Juli</th>
                      <th>Agustus</th>
                      <th>September</th>
                      <th>Oktober</th>
                      <th>November</th>
                      <th>Desember</th>
                      <th>Total</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    foreach ($pendapatan as $revenue) : ?>
                      <tr>
                        <td><?= $revenue['nama']; ?></td>
                        <td><?= $revenue['januari']; ?></td>
                        <td><?= $revenue['februari']; ?></td>
                        <td><?= $revenue['maret']; ?></td>
                        <td><?= $revenue['april']; ?></td>
                        <td><?= $revenue['mei']; ?></td>
                        <td><?= $revenue['juni']; ?></td>
                        <td><?= $revenue['juli']; ?></td>
                        <td><?= $revenue['agustus']; ?></td>
                        <td><?= $revenue['september']; ?></td>
                        <td><?= $revenue['oktober']; ?></td>
                        <td><?= $revenue['november']; ?></td>
                        <td><?= $revenue['desember']; ?></td>
                        <td><?= $revenue['total']; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-md-12">
                  <h6 class="card-category"></h6>
                </div>
                <div class="col-md-12">
                  <i class="fa fa-circle text-success"></i> Last Year
                  <i class="fa fa-circle text-info"></i> Target
                  <i class="fa fa-circle text-warning"></i> Aktual
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->
    <?php }; ?>
    <!-- end Sales Report -->

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

<!-- Survei Cuti Modal -->
<div class="modal fade" id="surveyCuti" tabindex="-1" role="dialog" aria-labelledby="#surveyCutiTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-info text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">CUTI</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('dashboard/survei/cuti'); ?>">
          <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="bmd-label-floating">Raisa cuti itu harusnya!</label>
                        <textarea class="form-control has-success" id="ide" name="ide" rows="5" required></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-right">
              <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                <button type="submit" class="btn btn-success">SAMPAIKAN!</button>
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
      // xhr.send(new Int8Array()); 
      // xhr.send(element);
    // })
      }

    var dataMultipleBarsChart = {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      series: [
        [
          <?php
          $revAct = $this->db->get_where('pendapatan', ['id' => 1])->row_array();
          echo $revAct['januari'] . ',' . $revAct['februari'] . ',' . $revAct['maret'] . ',' . $revAct['april'] . ',' . $revAct['mei'] . ',' . $revAct['juni'] . ',' . $revAct['juli'] . ',' . $revAct['agustus'] . ',' . $revAct['september'] . ',' . $revAct['oktober'] . ',' . $revAct['november'] . ',' . $revAct['desember'];
          ?>
        ],
        [
          <?php
          $revTarget = $this->db->get_where('pendapatan', ['id' => 2])->row_array();
          echo $revTarget['januari'] . ',' . $revTarget['februari'] . ',' . $revTarget['maret'] . ',' . $revTarget['april'] . ',' . $revTarget['mei'] . ',' . $revTarget['juni'] . ',' . $revTarget['juli'] . ',' . $revTarget['agustus'] . ',' . $revTarget['september'] . ',' . $revTarget['oktober'] . ',' . $revTarget['november'] . ',' . $revTarget['desember'];
          ?>
        ],
        [
          <?php
          $revLast = $this->db->get_where('pendapatan', ['id' => 3])->row_array();
          echo $revLast['januari'] . ',' . $revLast['februari'] . ',' . $revLast['maret'] . ',' . $revLast['april'] . ',' . $revLast['mei'] . ',' . $revLast['juni'] . ',' . $revLast['juli'] . ',' . $revLast['agustus'] . ',' . $revLast['september'] . ',' . $revLast['oktober'] . ',' . $revLast['november'] . ',' . $revLast['desember'];
          ?>
        ]
      ]
    };

    var optionsMultipleBarsChart = {
      seriesBarDistance: 10,
      axisX: {
        showGrid: false
      },
      height: '300px'
    };

    var responsiveOptionsMultipleBarsChart = [
      ['screen and (max-width: 640px)', {
        seriesBarDistance: 5,
        axisX: {
          labelInterpolationFnc: function(value) {
            return value[0];
          }
        }
      }]
    ];

    var multipleBarsChart = Chartist.Bar('#revenueChartDash', dataMultipleBarsChart, optionsMultipleBarsChart, responsiveOptionsMultipleBarsChart);

    //start animation for the Emails Subscription Chart
    md.startAnimationForBarChart(multipleBarsChart);

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

  });

  var initPhotoSwipeFromDOM = function(gallerySelector) {

    // parse slide data (url, title, size ...) from DOM elements 
    // (children of gallerySelector)
    var parseThumbnailElements = function(el) {
      var thumbElements = el.childNodes,
        numNodes = thumbElements.length,
        items = [],
        figureEl,
        linkEl,
        size,
        item;

      for (var i = 0; i < numNodes; i++) {

        figureEl = thumbElements[i]; // <figure> element

        // include only element nodes 
        if (figureEl.nodeType !== 1) {
          continue;
        }

        linkEl = figureEl.children[0]; // <a> element

        size = linkEl.getAttribute('data-size').split('x');

        // create slide object
        item = {
          src: linkEl.getAttribute('href'),
          w: parseInt(size[0], 10),
          h: parseInt(size[1], 10)
        };



        if (figureEl.children.length > 1) {
          // <figcaption> content
          item.title = figureEl.children[1].innerHTML;
        }

        if (linkEl.children.length > 0) {
          // <img> thumbnail element, retrieving thumbnail url
          item.msrc = linkEl.children[0].getAttribute('src');
        }

        item.el = figureEl; // save link to element for getThumbBoundsFn
        items.push(item);
      }

      return items;
    };

    // find nearest parent element
    var closest = function closest(el, fn) {
      return el && (fn(el) ? el : closest(el.parentNode, fn));
    };

    // triggers when user clicks on thumbnail
    var onThumbnailsClick = function(e) {
      e = e || window.event;
      e.preventDefault ? e.preventDefault() : e.returnValue = false;

      var eTarget = e.target || e.srcElement;

      // find root element of slide
      var clickedListItem = closest(eTarget, function(el) {
        return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
      });

      if (!clickedListItem) {
        return;
      }

      // find index of clicked item by looping through all child nodes
      // alternatively, you may define index via data- attribute
      var clickedGallery = clickedListItem.parentNode,
        childNodes = clickedListItem.parentNode.childNodes,
        numChildNodes = childNodes.length,
        nodeIndex = 0,
        index;

      for (var i = 0; i < numChildNodes; i++) {
        if (childNodes[i].nodeType !== 1) {
          continue;
        }

        if (childNodes[i] === clickedListItem) {
          index = nodeIndex;
          break;
        }
        nodeIndex++;
      }



      if (index >= 0) {
        // open PhotoSwipe if valid index found
        openPhotoSwipe(index, clickedGallery);
      }
      return false;
    };

    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    var photoswipeParseHash = function() {
      var hash = window.location.hash.substring(1),
        params = {};

      if (hash.length < 5) {
        return params;
      }

      var vars = hash.split('&');
      for (var i = 0; i < vars.length; i++) {
        if (!vars[i]) {
          continue;
        }
        var pair = vars[i].split('=');
        if (pair.length < 2) {
          continue;
        }
        params[pair[0]] = pair[1];
      }

      if (params.gid) {
        params.gid = parseInt(params.gid, 10);
      }

      return params;
    };

    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
      var pswpElement = document.querySelectorAll('.pswp')[0],
        gallery,
        options,
        items;

      items = parseThumbnailElements(galleryElement);

      // define options (if needed)
      options = {

        // define gallery index (for URL)
        galleryUID: galleryElement.getAttribute('data-pswp-uid'),

        getThumbBoundsFn: function(index) {
          // See Options -> getThumbBoundsFn section of documentation for more info
          var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
            pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
            rect = thumbnail.getBoundingClientRect();

          return {
            x: rect.left,
            y: rect.top + pageYScroll,
            w: rect.width
          };
        }

      };

      // PhotoSwipe opened from URL
      if (fromURL) {
        if (options.galleryPIDs) {
          // parse real index when custom PIDs are used 
          // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
          for (var j = 0; j < items.length; j++) {
            if (items[j].pid == index) {
              options.index = j;
              break;
            }
          }
        } else {
          // in URL indexes start from 1
          options.index = parseInt(index, 10) - 1;
        }
      } else {
        options.index = parseInt(index, 10);
      }

      // exit if index not found
      if (isNaN(options.index)) {
        return;
      }

      if (disableAnimation) {
        options.showAnimationDuration = 0;
      }

      // Pass data to PhotoSwipe and initialize it
      gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
      gallery.init();
    };

    // loop through all gallery elements and bind events
    var galleryElements = document.querySelectorAll(gallerySelector);

    for (var i = 0, l = galleryElements.length; i < l; i++) {
      galleryElements[i].setAttribute('data-pswp-uid', i + 1);
      galleryElements[i].onclick = onThumbnailsClick;
    }

    // Parse URL and open gallery if it contains #&pid=3&gid=1
    var hashData = photoswipeParseHash();
    if (hashData.pid && hashData.gid) {
      openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
    }
  };

  // execute above function
  initPhotoSwipeFromDOM('.my-gallery');

  $(document).ready(function() {
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