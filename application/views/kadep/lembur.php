<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
  <!-- RENCANA - Atasan 1 & 2 -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">RENCANA - Menunggu Persetujuan Koordinator/Section & Depthead</h4>
          </div>
          <div class="card-body">
          <div class="table-responsive">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar       Rencana Atasan 1 & 2       -->
            </div>
            <div class="material-datatables">
              <table id="#" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Durasi/Jam</th>
                    <th>Status</th>
                    <th class="disabled-sorting text-right">Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                  <th>ID</th>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Durasi/Jam</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($rencana as $rn) : ?>
                    <tr>
                      <td><?= $rn['id']; ?></td>
                      <td><?= $rn['nama']; ?></td>
                      <td><?= date('d/m/Y H:i', strtotime($rn['tglmulai'])); ?></td>
                      <td><?= date('H', strtotime($rn['durasi'])); ?> Jam <?= date('i', strtotime($rn['durasi'])); ?> Menit</td>
                      <?php $status = $this->db->get_where('lembur_status', ['id' => $rn['status']])->row_array(); ?>
                      <td><?= $status['nama']; ?></td>
                      <td><a href="<?= base_url('lembur/lemburku/') . $rn['id']; ?>" class="badge badge-pill badge-success">Detail</a></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- end content-->
        </div>
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
    <!-- RENCANA - Divhead -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">RENCANA - Menunggu Persetujuan Division Head</h4>
          </div>
          <div class="card-body">
          <div class="table-responsive">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar      Rencana Div        -->
            </div>
            <div class="material-datatables">
              <table id="#" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Tgl Mengajukan</th>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi/Jam</th>
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
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi/Jam</th>
                    <th>Admin GA</th>
                    <th>Admin HR</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($rencana_div as $rndiv) : ?>
                    <tr>
                      <td><?= $rndiv['id']; ?></td>
                      <td><?= $rndiv['tglpengajuan']; ?></td>
                      <td><?= $rndiv['nama']; ?></td>
                      <td><?= date('d/m/Y', strtotime($rndiv['tglmulai'])); ?></td>
                      <td><?= date('H:i', strtotime($rndiv['tglmulai'])); ?></td>
                      <td><?= date('d/m/Y', strtotime($rndiv['tglselesai'])); ?></td>
                      <td><?= date('H:i', strtotime($rndiv['tglselesai'])); ?></td>
                          <?php if($rndiv['status']== '1' or $rndiv['status']== '2' or $rndiv['status']== '3' or $rndiv['status']== '4' or $rndiv['status']== '10' or $rndiv['status']== '11') {?>
                      <td><?= date('H', strtotime($rndiv['durasi'])); ?> Jam <?= date('i', strtotime($rndiv['durasi'])); ?> Menit</td>
                          <?php } else { ?>
                      <td><?= date('H', strtotime($rndiv['durasi_aktual'])); ?> Jam <?= date('i', strtotime($rndiv['durasi_aktual'])); ?> Menit</td>
                          <?php }; ?>
                      <td><?= $rndiv['admin_ga']; ?></td>
                      <td><?= $rndiv['admin_hr']; ?></td>
                      <td><?= $rndiv['catatan']; ?></td>
                      <?php $status = $this->db->get_where('lembur_status', ['id' => $rndiv['status']])->row_array(); ?>
                      <td><?= $status['nama']; ?></td>
                      <td>
                          <?php if ($rndiv['status'] == '4' or $rndiv['status'] == '5' or $rndiv['status'] == '6' or $rndiv['status'] == '12' or $rndiv['status'] == '13') { ?>
                              <a href="<?= base_url('lembur/realisasi_aktivitas/') . $rndiv['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                          <?php }else if ($rndiv['status'] == '0' or $rndiv['status'] == '7' or $rndiv['status'] == '8' or $rndiv['status'] == '9') { ?>
                            <a href="<?= base_url('lembur/lemburku/') . $rndiv['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                          <?php } else { ?>
                              <a href="<?= base_url('lembur/rencana_aktivitas/') . $rndiv['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                          <?php }; ?>
                      </td>
                      <td class="text-right">
                          <?php if ($rndiv['status'] == '9' ) { ?>
                            <a href="<?= base_url('lembur/laporan_lembur/') . $rndiv['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit" target="_blank"><i class="material-icons">dvr</i></a>
                          <?php } else { ?>
                            <a href="<?= base_url('lembur/laporan_lembur/') . $rndiv['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit disabled"><i class="material-icons">dvr</i></a>
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
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
    <!-- RENCANA - COO -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">RENCANA - Menunggu Persetujuan COO</h4>
          </div>
          <div class="card-body">
          <div class="table-responsive">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar      Rencana Div        -->
            </div>
            <div class="material-datatables">
              <table id="#" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Tgl Mengajukan</th>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi/Jam</th>
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
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi/Jam</th>
                    <th>Admin GA</th>
                    <th>Admin HR</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($rencana_coo as $rncoo) : ?>
                    <tr>
                      <td><?= $rncoo['id']; ?></td>
                      <td><?= $rncoo['tglpengajuan']; ?></td>
                      <td><?= $rncoo['nama']; ?></td>
                      <td><?= date('d/m/Y', strtotime($rncoo['tglmulai'])); ?></td>
                      <td><?= date('H:i', strtotime($rncoo['tglmulai'])); ?></td>
                      <td><?= date('d/m/Y', strtotime($rncoo['tglselesai'])); ?></td>
                      <td><?= date('H:i', strtotime($rncoo['tglselesai'])); ?></td>
                          <?php if($rncoo['status']== '1' or $rncoo['status']== '2' or $rncoo['status']== '3' or $rncoo['status']== '4' or $rncoo['status']== '10' or $rncoo['status']== '11') {?>
                      <td><?= date('H', strtotime($rncoo['durasi'])); ?> Jam <?= date('i', strtotime($rncoo['durasi'])); ?> Menit</td>
                          <?php } else { ?>
                      <td><?= date('H', strtotime($rncoo['durasi_aktual'])); ?> Jam <?= date('i', strtotime($rncoo['durasi_aktual'])); ?> Menit</td>
                          <?php }; ?>
                      <td><?= $rncoo['admin_ga']; ?></td>
                      <td><?= $rncoo['admin_hr']; ?></td>
                      <td><?= $rncoo['catatan']; ?></td>
                      <?php $status = $this->db->get_where('lembur_status', ['id' => $rncoo['status']])->row_array(); ?>
                      <td><?= $status['nama']; ?></td>
                      <td>
                          <?php if ($rncoo['status'] == '4' or $rncoo['status'] == '5' or $rncoo['status'] == '6' or $rncoo['status'] == '12' or $rncoo['status'] == '13') { ?>
                              <a href="<?= base_url('lembur/realisasi_aktivitas/') . $rncoo['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                          <?php }else if ($rncoo['status'] == '0' or $rncoo['status'] == '7' or $rncoo['status'] == '8' or $rncoo['status'] == '9') { ?>
                            <a href="<?= base_url('lembur/lemburku/') . $rncoo['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                          <?php } else { ?>
                              <a href="<?= base_url('lembur/rencana_aktivitas/') . $rncoo['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                          <?php }; ?>
                      </td>
                      <td class="text-right">
                          <?php if ($rncoo['status'] == '9' ) { ?>
                            <a href="<?= base_url('lembur/laporan_lembur/') . $rncoo['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit" target="_blank"><i class="material-icons">dvr</i></a>
                          <?php } else { ?>
                            <a href="<?= base_url('lembur/laporan_lembur/') . $rncoo['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit disabled"><i class="material-icons">dvr</i></a>
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
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
    <!-- REALISASI - Atasan 1 & 2 -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">REALISASI - Menunggu Persetujuan Koordinator/Section & Depthead</h4>
          </div>
          <div class="card-body">
          <div class="table-responsive">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar       Rencana Atasan 1 & 2       -->
            </div>
            <div class="material-datatables">
              <table id="#" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Tgl Mengajukan</th>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi/Jam</th>
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
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi/Jam</th>
                    <th>Admin GA</th>
                    <th>Admin HR</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($realisasi as $l) : ?>
                    <tr>
                      <td><?= $l['id']; ?></td>
                      <td><?= $l['tglpengajuan']; ?></td>
                      <td><?= $l['nama']; ?></td>
                      <td><?= date('d/m/Y', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('H:i', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('d/m/Y', strtotime($l['tglselesai'])); ?></td>
                      <td><?= date('H:i', strtotime($l['tglselesai'])); ?></td>
                          <?php if($l['status']== '1' or $l['status']== '2' or $l['status']== '3' or $l['status']== '4' or $l['status']== '10' or $l['status']== '11') {?>
                      <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                          <?php } else { ?>
                      <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                          <?php }; ?>
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
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
    <!-- REALISASI - Divhead -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">REALISASI - Menunggu Persetujuan Division Head</h4>
          </div>
          <div class="card-body">
          <div class="table-responsive">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar       Rencana Atasan 1 & 2       -->
            </div>
            <div class="material-datatables">
              <table id="#" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Tgl Mengajukan</th>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi/Jam</th>
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
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi/Jam</th>
                    <th>Admin GA</th>
                    <th>Admin HR</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($realisasi_div as $l) : ?>
                    <tr>
                      <td><?= $l['id']; ?></td>
                      <td><?= $l['tglpengajuan']; ?></td>
                      <td><?= $l['nama']; ?></td>
                      <td><?= date('d/m/Y', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('H:i', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('d/m/Y', strtotime($l['tglselesai'])); ?></td>
                      <td><?= date('H:i', strtotime($l['tglselesai'])); ?></td>
                          <?php if($l['status']== '1' or $l['status']== '2' or $l['status']== '3' or $l['status']== '4' or $l['status']== '10' or $l['status']== '11') {?>
                      <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                          <?php } else { ?>
                      <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                          <?php }; ?>
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
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
    <!-- REALISASI - COO -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">REALISASI - Menunggu Persetujuan COO</h4>
          </div>
          <div class="card-body">
          <div class="table-responsive">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar       Rencana Atasan 1 & 2       -->
            </div>
            <div class="material-datatables">
              <table id="#" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Tgl Mengajukan</th>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi/Jam</th>
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
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi/Jam</th>
                    <th>Admin GA</th>
                    <th>Admin HR</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($realisasi_coo as $l) : ?>
                    <tr>
                      <td><?= $l['id']; ?></td>
                      <td><?= $l['tglpengajuan']; ?></td>
                      <td><?= $l['nama']; ?></td>
                      <td><?= date('d/m/Y', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('H:i', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('d/m/Y', strtotime($l['tglselesai'])); ?></td>
                      <td><?= date('H:i', strtotime($l['tglselesai'])); ?></td>
                          <?php if($l['status']== '1' or $l['status']== '2' or $l['status']== '3' or $l['status']== '4' or $l['status']== '10' or $l['status']== '11') {?>
                      <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                          <?php } else { ?>
                      <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                          <?php }; ?>
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
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
    <!-- RESUME LEMBUR SELESAI -->
    <div class="row">
      <div class="col-md-12">
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
                    <th>No. Lembur</th>
                    <th>Tgl Mengajukan</th>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi/Jam</th>
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
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi/Jam</th>
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
                      <td><?= $l['nama']; ?></td>
                      <td><?= date('d/m/Y', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('H:i', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('d/m/Y', strtotime($l['tglselesai'])); ?></td>
                      <td><?= date('H:i', strtotime($l['tglselesai'])); ?></td>
                          <?php if($l['status']== '1' or $l['status']== '2' or $l['status']== '3' or $l['status']== '4' or $l['status']== '10' or $l['status']== '11') {?>
                      <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                          <?php } else { ?>
                      <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                          <?php }; ?>
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

