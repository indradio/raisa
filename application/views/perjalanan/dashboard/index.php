<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
    <div class="row">
              <label class="col-md-3 col-form-label">Nomor Polisi</label>
              <div class="col-md-9">
                <div class="form-group has-default">
                  <input type="text" class="form-control" name="nopol" id="nopol">
                </div>
              </div>
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

<!-- Javascript -->
<script>
  $(document).ready(function() {

    const url = 'http://117.102.67.82:8002/apis/tracking/realtime.php?red=yes&username=winteq&password=winteq1231407&devices=2020080162';

fetch(url)
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    // Melakukan sesuatu dengan data yang diterima
    console.log(data);
  })
  .catch(error => {
    // Menangani kesalahan
    console.error('There was a problem with the fetch operation:', error);
  });

    // let timerInterval

    // setInterval(function() {

      // const cars = ["2020080159", "2020080160", "2020080161", "2020080162", "2020080163"];

      // for (let i = 0; i < cars.length; i++) {

      //   var xhr = new XMLHttpRequest();
      //   xhr.open("POST", 'https://gps.intellitrac.co.id/apis/tracking/realtime.php', true);

      //   //Send the proper header information along with the request
      //   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      //   xhr.onreadystatechange = function() { // Call a function when the state changes.
      //     if (this.readyState === XMLHttpRequest.DONE) {
      //       if (xhr.status === 302 || xhr.status === 200) {
      //         var myObj = JSON.parse(this.responseText);
      //         var image = 'https://raisa.winteq-astra.com/assets/img/iconmobil.png';
      //         var idloc = "loc" + cars[i];
      //         var lat = "lat" + cars[i];
      //         var lng = "lng" + cars[i]; 
              
      //         loc = myObj.data[cars[i]]['realtime']['location'];
      //         // z + cars[i] = myObj.data[cars[i]]['realtime']['ignition_status'];
      //         lat = myObj.data[cars[i]]['realtime']['latitude'];
      //         lng = myObj.data[cars[i]]['realtime']['longitude'];
              
      //         var mapCanvas = document.getElementById(cars[i]);
      //         document.getElementById(idloc).innerHTML = loc;
              
      //         var location = new google.maps.LatLng(lat, lng);
      //         var mapOptions = {
      //           center: location,
      //           zoom: 15,
      //           mapTypeId: "satellite",
      //           mapTypeId: google.maps.MapTypeId.ROADMAP
      //         }
      //         var map = new google.maps.Map(mapCanvas, mapOptions);

      //         var marker = new google.maps.Marker({
      //           position: location,
      //           icon: image
      //         });
              
      //         marker.setMap(map);

      //         var link = "username=winteq&password=winteq1231407&devices=" + cars[i];
      //       }
      //     }
      //   }
      // xhr.send("username=winteq&password=winteq1231407&devices=" + cars[i]);
      // // xhr.send("username=winteq&password=winteq1231407&devices=2020080159%3B2020080160%3B2020080161%3B2020080162%3B2020080163");
      // }
      
      // const cars = ["2020080159", "2020080160", "2020080161", "2020080162", "2020080163"];

      // for (let i = 0; i < cars.length; i++) {

      //   var xhr = new XMLHttpRequest();
      //   xhr.open("POST", 'https://gps.intellitrac.co.id/apis/tracking/realtime.php', true);

      //   //Send the proper header information along with the request
      //   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      //   xhr.onreadystatechange = function() { // Call a function when the state changes.
      //     if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      //       var myObj = JSON.parse(this.responseText);
      //       var image = 'https://raisa.winteq-astra.com/assets/img/iconmobil.png';
      //       var idloc = "loc" + cars[i];
      //       var lat = "lat" + cars[i];
      //       var lng = "lng" + cars[i]; 
            
      //       loc = myObj.data[cars[i]]['realtime']['location'];
      //       // z + cars[i] = myObj.data[cars[i]]['realtime']['ignition_status'];
      //       lat = myObj.data[cars[i]]['realtime']['latitude'];
      //       lng = myObj.data[cars[i]]['realtime']['longitude'];
            
      //       var mapCanvas = document.getElementById(cars[i]);
      //       document.getElementById(idloc).innerHTML = loc;
            
      //       var location = new google.maps.LatLng(lat, lng);
      //       var mapOptions = {
      //         center: location,
      //         zoom: 15,
      //         mapTypeId: "satellite",
      //         mapTypeId: google.maps.MapTypeId.ROADMAP
      //       }
      //       var map = new google.maps.Map(mapCanvas, mapOptions);

      //       var marker = new google.maps.Marker({
      //         position: location,
      //         icon: image
      //       });
            
      //       marker.setMap(map);
      //     }
      //   }
      // xhr.send("username=winteq&password=winteq1231407&devices=2020080159%3B2020080160%3B2020080161%3B2020080162%3B2020080163");
      // }
      // }, 15000);   

  });
</script>