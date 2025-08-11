<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">

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
                  <img class="img lazyload" data-src="<?= base_url().'assets/img/info/'.$row->gambar_banner; ?>" />
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
                      <div class="col-3 text-center"  style="padding-left: 1%;padding-right: 1%;max-width: 20%">
                          <a href="<?= base_url('perjalanandl'); ?>" class="btn btn-lg btn-just-icon  btn-round btn-facebook">
                              <i class="fa fa-car"></i>
                          </a>
                          </br>
                          <a class="card-title"><small>DL</small></a> 
                      </div>
                      <div class="col-3 text-center"  style="padding-left: 1%;padding-right: 1%;max-width: 20%">
                          <a href="<?= base_url('lembur'); ?>" class="btn btn-lg btn-just-icon  btn-round btn-facebook">
                              <i class="fa fa-clock-o"></i>
                          </a>
                          </br>
                          <a class="card-title"><small>OT</small></a> 
                        </div>
                        <div class="col-3 mr-auto text-center"  style="padding-left: 1%;padding-right: 1%;max-width: 20%">
                            <a href="<?= base_url('jamkerja'); ?>" class="btn btn-lg btn-just-icon  btn-round btn-facebook">
                                <i class="fa fa-check-square-o"></i>
                            </a>
                            </br>
                            <a class="card-title"><small>JK</small></a> 
                        </div>
                      <div class="col-3 text-center" style="padding-left: 1%;padding-right: 1%;max-width: 20%">
                            <a href="<?= base_url('presensi'); ?>" class="btn btn-lg btn-just-icon  btn-round btn-facebook">
                                  <i class="fa fa-street-view"></i>
                            </a>
                            </br>
                            <a class="card-title"><small>AB</small></a> 
                        </div>
                      <div class="col-3 mr-auto text-center"  style="padding-left: 1%;padding-right: 1%;max-width: 20%">
                          <button id="btn_fcksunfish3" class="btn btn-lg btn-just-icon  btn-round btn-facebook">
                              <i class="fa fa-calendar-times-o"></i>
                              </button>
                          </br>
                          <a class="card-title"><small>CT</small></a> 
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
                    <img class="d-block w-100 lazyload" data-src="<?= base_url().'assets/img/info/'.$row->gambar_banner; ?>" />
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

          <!-- 1. Notification -->

      <!-- <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info alert-with-icon" data-notify="container">
              <i class="material-icons" data-notify="icon">notifications</i>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
              </button>
              <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
              <span data-notify="message">Terimkasih kamu telah memilih <b></b> sebagai ketua bipartit selanjutnya.</span>
            </div>
        </div>
      </div> -->
    <!-- End Notification -->

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
        </div> -->

    <?php if ($this->session->userdata('posisi_id') > 0 ){ ?>
    <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div id="accordionForm" role="tablist">
              <div class="card-collapse">
                <div class="card-header" role="tab" id="headingForm">
                  <h5 class="mb-0">
                    <a class="" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm">
                    <h3 class="card-title">Calendar of Event Winteq 2025 
                      <i class="material-icons">keyboard_arrow_down</i>
                    </h3>
                    </a>
                  </h5>
                </div>
                <div id="collapseForm" class="collapsed collapse" role="tabpanel" aria-labelledby="headingForm" data-parent="#accordion">
                  <div class="card-body">
                    <div class="material-datatables">
                      <table id="dtForm" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>CoE 2025</th>
                                <th><a href="https://drive.google.com/file/d/1hWhwaBSvwujCYccx2awJLW4RfTPNHJl0/view?usp=sharing" target="_blank" class='btn btn-link btn-success'><i class='fa fa-download'></i> Download<div class='ripple-container'></div></a></th>
                              </tr>
                            <tr>
                                <th>Pengumuman tanggal 18 Agst 2025</th>
                                <th><a href="https://drive.google.com/file/d/1w-hmKRX6nvUc9WAi9vXlnro68wBt950x/view" target="_blank" class='btn btn-link btn-success'><i class='fa fa-download'></i> Download<div class='ripple-container'></div></a></th>
                              </tr>
                            <!-- <tr>
                                <th>FORM PENGAJUAN BANTUAN RELOKASI</th>
                                <th><a href="https://drive.google.com/file/d/1GL82ndCXngkLUjurLLp1qHzqU5BJ6rK7/view?usp=sharing" target="_blank" class='btn btn-link btn-success'><i class='fa fa-download'></i> Download<div class='ripple-container'></div></a></th>
                              </tr>
                              <tr>
                                <th>FORM PENGAJUAN PINJAMAN UANG</th>
                                <th><a href="https://drive.google.com/file/d/1Y2CFhbPnVzcSq6rm3Mo3y0mmvRCkTs-A/view?usp=sharing" target="_blank" class='btn btn-link btn-success'><i class='fa fa-download'></i> Download<div class='ripple-container'></div></a></th>
                            </tr> -->
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php }; ?>
    <?php if (date('Y-m-d') < date('2024-06-31') ){ ?>
    <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div id="accordionForm" role="tablist">
              <div class="card-collapse">
                <div class="card-header" role="tab" id="headingForm">
                  <h5 class="mb-0">
                    <a class="" data-toggle="collapse" href="#collapseForm2" aria-expanded="false" aria-controls="collapseForm2">
                    <h3 class="card-title">Panduan App 
                      <i class="material-icons">keyboard_arrow_down</i>
                    </h3>
                    </a>
                  </h5>
                </div>
                <div id="collapseForm2" class="collapsed collapse" role="tabpanel" aria-labelledby="headingForm" data-parent="#accordion">
                  <div class="card-body">
                    <div class="material-datatables">
                      <table id="dtForm" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Panduan Sunfish</th>
                                <th><a href="https://drive.google.com/file/d/18mVbd0ti4V-WQRfWULycERhvF-xqjSdf/view" target="_blank" class='btn btn-link btn-success'><i class='fa fa-download'></i> Download<div class='ripple-container'></div></a></th>
                              </tr>
                            <tr>
                                <th>Panduan registrasi myDPA</th>
                                <th><a href="https://drive.google.com/file/d/1X5PFkv8O3xgt4VJAzV3Tz_bxdsOiWGp6/view?usp=sharing" target="_blank" class='btn btn-link btn-success'><i class='fa fa-download'></i> Download<div class='ripple-container'></div></a></th>
                              </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php }; ?>
      
    </div>
    <!-- End Absensi -->

    <div class="row">

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
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-text card-header-info">
            <div class="card-text">
              <h4 class="card-title">Perjalanan</h4>
              <p class="card-category">Dinas</p>
            </div>
          </div>
        <div class="card-body table-responsive">
      <div class="material-datatables">
        <table id="dt-perjalanan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
            <thead>
                <tr>
                  <th class="text-center">Status</th>
                  <th>Berangkat</th>
                  <th>Tujuan</th>
                  <th>Peserta</th>
                  <th>Nopol</th>
                </tr>
            </thead>
            <!-- <tfoot>
                <tr>
                    <th>Aktivitas</th>
                    <th>Durasi <small>(Jam)</small></th>
                    <th class="disabled-sorting text-right">Actions</th>
                </tr>
            </tfoot> -->
        </table>
      </div> 
      </div> 
    </div>
    <!-- end Perjalanan -->

  </div>
  <!-- end container-fluid -->
</div>
<!-- end content -->

<!-- Modal Detail -->
<!-- <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="detailTitle" aria-hidden="true">
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
</div> -->

<!-- Banner Modal -->
<div class="modal fade" id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="bannerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <img id="gambar" name="gambar" class="img-fluid" />
    </div>
  </div>
</div>

<!-- Aktivasi ASTRAPAY Modal -->
<!-- <div class="modal fade" id="updateEwallet" tabindex="-1" role="dialog" aria-labelledby="#updateEwalletTitle" aria-hidden="true">
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
</div> -->

<!-- Button trigger modal (optional) -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" style="display: none;">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Vote Ketua Bipartit</h5>
      </div>
      <form class="form" method="post" action="<?= base_url('dashboard/vote_bipartit'); ?>">
        <div class="modal-body">
        Mari pilih calon ketua yang bijak, santun dan mengedepankan keharmonisan hubungan antara karyawan dan perusahaan.
              </br>
          <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Pilih calon*</label></br>
                                <select class="selectpicker" name="vote" id="vote" title="Pilih" data-style="select-with-transition" data-size="5" data-width="block" data-live-search="false" required>
                                    <?php 
                                    $candidate = $this->db->query("SELECT * FROM `karyawan` WHERE `gol_id` = '1' AND `status` = '1' AND `is_active` = '1'")->result_array();
                                    foreach ($candidate as $row) : 
                                    ?>
                                        <option value="<?= $row['npk']; ?>"><?= $row['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                          </div>
                      </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">VOTE!</button>
        </div>
        </form>
    </div>
  </div>
</div>


<!-- Javascript -->
<script>

  $(document).ready(function() {

    $('#btn_fcksunfish1').on('click',function(){

      Swal.fire({
        title: 'Perhatian!',
        icon: 'warning',
        html:
        'Fitur Absensi sekarang sudah beralih ke sunfish.',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Saya Mengerti',
        showClass: {
          popup: 'animate__animated animate__heartBeat'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOut'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          
        }
      });

    });

    $('#btn_fcksunfish2').on('click',function(){

      Swal.fire({
        title: 'Perhatian!',
        icon: 'warning',
        html:
        'Fitur Imp sekarang sudah beralih ke sunfish.',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Saya Mengerti',
        showClass: {
          popup: 'animate__animated animate__heartBeat'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOut'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          
        }
      });

    });

    $('#btn_fcksunfish3').on('click',function(){

      Swal.fire({
        title: 'Perhatian!',
        icon: 'warning',
        html:
        'Fitur Cuti sekarang sudah beralih ke sunfish.',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Saya Mengerti',
        showClass: {
          popup: 'animate__animated animate__heartBeat'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOut'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          
        }
      });

    });

    

    let timerInterval
    <?php if ($this->session->flashdata('message')=='x'){ ?> 
      
        Swal.fire({
          title: 'Qoute of the day!',
          html: 'Gak ada! kerja kerja...',
          // imageUrl: '<?= base_url(); ?>/assets/img/info/idul-fitri-1443H.jpg',
          // imageWidth: 400,
          // imageHeight: 200,
          // imageAlt: 'Custom image',
          timer: 1000,
          timerProgressBar: true,
          showConfirmButton: false,
          willClose: () => {
            clearInterval(timerInterval)
          }
        }).then((result) => {
          /* Read more about handling dismissals below */
          if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
          }
        });
       
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

    $('#dtcuti').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
      serverSide: false,
      processing: true,
      ajax: {
              "url"   : "<?= site_url('cuti/get_data/today') ?>",
              "type"  : "POST",
          },
      columns: [
        { "data":"name"},
        { "data":"until"}
      ],
    });

    $('#dt-perjalanan').DataTable({
            "pagingType": "full_numbers",
            scrollX: true,
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            pageLength: 50,
            serverSide: false,
            processing: true,
            ajax: {
                    "url"   : "<?= site_url('perjalanan/get_data/dashboard') ?>",
                    "type"  : "POST",
                },
            columns: [
                { "data": "status", className: "text-center" },
                { "data": "berangkat" },
                { "data": "tujuan" },
                { "data": "peserta" },
                { "data": "kendaraan" }
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

    // var cJamkerja = $('#calendarJamkerja');

    // today = new Date();
    // y = today.getFullYear();
    // m = today.getMonth();
    // d = today.getDate();

    // cJamkerja.fullCalendar({
    //   timeZone: 'asia/jakarta', // the default (unnecessary to specify)
    //   viewRender: function(view, element) {
    //     // We make sure that we activate the perfect scrollbar when the view isn't on Month
    //     if (view.name != 'month') {
    //       $(element).find('.fc-scroller').perfectScrollbar();
    //     }
    //   },
    //   header: {
    //     left: 'month',
    //     center: 'title',
    //     right: 'prev,next,today'
    //   },

    //   firstDay: 1,
    //   defaultDate: today,
    //   businessHours: [{
    //     default: false,
    //     // days of week. an array of zero-based day of week integers (0=Sunday)
    //     dow: [1, 2, 3, 4, 5], // Monday - Friday
    //     start: '07:30', // a start time 
    //     end: '16:30' // an end time 
    //   }],

    //   views: {
    //     month: { // name of view
    //       titleFormat: 'MMMM YYYY'
    //       // other view-specific options here
    //     },
    //     week: {
    //       titleFormat: " MMMM D YYYY"
    //     },
    //     day: {
    //       titleFormat: 'D MMM, YYYY'
    //     }
    //   },

    //   selectable: true,
    //   selectHelper: true,
    //   editable: true,

    //   eventSources: [{
    //       events: function(start, end, timezone, callback) {
    //         $.ajax({
    //           url: '<?php echo base_url() ?>jamkerja/GET_MY_jamkerja',
    //           dataType: 'json',
    //           success: function(msg) {
    //             var events = msg.events;
    //             callback(events);
    //           }
    //         });
    //       }
    //     },
    //     {
    //       events: function(start, end, timezone, callback) {
    //         $.ajax({
    //           url: '<?php echo base_url() ?>jamkerja/GET_MY_lembur',
    //           dataType: 'json',
    //           success: function(msg) {
    //             var events = msg.events;
    //             callback(events);
    //           }
    //         });
    //       },
    //       color: 'red' // an option!
    //     },
    //   ],
    //   eventLimit: true, // allow "more" link when too many events

    //   select: function(start, end, info) {
    //     window.location = 'https://raisa.winteq-astra.com/jamkerja/tanggal/' + start.format();
    //   },
    // });    

  });
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHFISdyofTP6NPRE142yGJjZPa1Z2VbU4&callback=initMap"></script> -->