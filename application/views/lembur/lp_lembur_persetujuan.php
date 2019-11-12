<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
  <!-- RENCANA - Atasan 1 & 2 -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">RENCANA - Menunggu Persetujuan Koordinator/Section & Depthead | <?= date("d-m-Y H:i"); ?></h4>
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
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Durasi/Jam</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($rencana_ats as $l) : ?>
                  <tr>
                      <td><?= $l['nama']; ?> <small>(<?= $l['id']; ?>)</small></td>
                      <td><?= date('d-M H:i', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                      <?php if ($l['status']==2){ ?>
                        <td><span class="badge badge-pill badge-warning">Menunggu <?= $l['atasan1_rencana']; ?></span></td>
                      <?php }elseif ($l['status']==3){ ?>
                        <td><span class="badge badge-pill badge-success">Menunggu <?= $l['atasan2_rencana']; ?></span></td>
                      <?php }; ?>
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
    <div class="row" hidden>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">RENCANA - Menunggu Persetujuan Division Head | <?= date("d-m-Y H:i"); ?></h4>
          </div>
          <div class="card-body">
          <div class="table-responsive">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar       Rencana Div Head       -->
            </div>
            <div class="material-datatables">
              <table id="#" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Durasi/Jam</th>
                    <th class="disabled-sorting">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($rencana_div as $l) : ?>
                    <tr>
                      <td><?= $l['id']; ?></td>
                      <td><?= $l['nama']; ?></td>
                      <td><?= date('d/m/Y H:i', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                      <td><a href="<?= base_url('lembur/lemburku/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a></td>
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
    <div class="row" hidden>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">RENCANA - Menunggu Persetujuan COO | <?= date("d-m-Y H:i"); ?></h4>
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
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tanggal Lembur</th>
                    <th>Durasi/Jam</th>
                    <th class="disabled-sorting">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($rencana_coo as $l) : ?>
                    <tr>
                      <td><?= $l['id']; ?></td>
                      <td><?= $l['nama']; ?></td>
                      <td><?= date('d/m/Y H:i', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                      <td><a href="<?= base_url('lembur/lemburku/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a></td>
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
    <!-- REALISASI -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">REALISASI - Menunggu Laporan dari Karyawan | <?= date("d-m-Y H:i"); ?></h4>
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
                    <th>Nama</th>
                    <th>Tanggal Selesai</th>
                    <th>Durasi</th>
                    <th>Sisa Waktu</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($realisasi as $l) :
                  $tglmulai = strtotime($l['tglselesai']);
                  $sekarang = strtotime(date('Y-m-d H:i:s'));
                  $tempo =  strtotime(date('Y-m-d H:i:s', strtotime('+3 days', strtotime($l['tglselesai']))));
                  $selisih = $tempo - $sekarang;
                  $hari  = floor($selisih / (60 * 60 * 24));
                  $jam = $selisih - $hari * (60 * 60 * 24);
                  $jam   = floor($jam / (60 * 60));
                  $menit = $selisih - $hari * (60 * 60 * 24) - $jam * (60 * 60);
                  $menit = floor($menit / 60);
                  ?>
                  <tr>
                      <td><?= $l['nama']; ?> <small>(<?= $l['id']; ?>)</small></td>
                      <td><?= date('d-M H:i', strtotime($l['tglselesai'])); ?></td>
                      <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                      <td><?= $hari; ?> Hari <?= $jam; ?> Jam <?= $menit; ?> Menit</td>
                      <!-- <td><?= floor($selisih / (60 * 60 * 24)); ?> Hari</td> -->
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
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">REALISASI - Menunggu Persetujuan Koordinator/Section & Depthead | <?= date("d-m-Y H:i"); ?></h4>
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
                    <th>Nama</th>
                    <th>Tanggal Lembur</th>
                    <th>Durasi/Jam</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($realisasi_ats as $l) : ?>
                  <tr>
                      <td><?= $l['nama']; ?> <small>(<?= $l['id']; ?>)</small></td>
                      <td><?= date('d-M H:i', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                      <?php if ($l['status']==5){ ?>
                        <td><span class="badge badge-pill badge-warning">Menunggu <?= $l['atasan1_realisasi']; ?></span></td>
                      <?php }elseif ($l['status']==6){ ?>
                        <td><span class="badge badge-pill badge-success">Menunggu <?= $l['atasan2_realisasi']; ?></span></td>
                      <?php }; ?>
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
    <div class="row" hidden>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">REALISASI - Menunggu Persetujuan Division Head | <?= date("d-m-Y H:i"); ?></h4>
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
                    <th class="disabled-sorting">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($realisasi_div as $l) : ?>
                    <tr>
                      <td><?= $l['id']; ?></td>
                      <td><?= $l['nama']; ?></td>
                      <td><?= date('d/m/Y H:i', strtotime($l['tglmulai_aktual'])); ?></td>
                      <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                      <td><a href="<?= base_url('lembur/lemburku/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a></td>
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
    <div class="row" hidden>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">REALISASI - Menunggu Persetujuan COO | <?= date("d-m-Y H:i"); ?></h4>
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
                    <th class="disabled-sorting">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($realisasi_coo as $l) : ?>
                    <tr>
                      <td><?= $l['id']; ?></td>
                      <td><?= $l['nama']; ?></td>
                      <td><?= date('d/m/Y H:i', strtotime($l['tglmulai_aktual'])); ?></td>
                      <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                      <td><a href="<?= base_url('lembur/lemburku/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a></td>
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
  </div>
</div>
<!-- Modal -->

