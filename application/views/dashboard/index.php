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
          <div class="card bg-transparent">
              <div class="card-body">
                  <div class="row">
                    <div class="col-4 text-center" style="padding-left: 1%;padding-right: 1%">
                        <a href="<?= base_url('presensi'); ?>" class="btn btn-lg btn-just-icon btn-success">
                            <i class="fa fa-street-view"></i>
                        </a>
                        </br>
                        <a class="card-title"><small>ABSEN</small></a> 
                      </div>
                      <div class="col-4 text-center"  style="padding-left: 1%;padding-right: 1%">
                          <a href="<?= base_url('lembur'); ?>" class="btn btn-lg btn-just-icon btn-facebook">
                              <i class="fa fa-clock-o"></i>
                          </a>
                          </br>
                          <a class="card-title"><small>OT</small></a> 
                      </div>
                      <div class="col-4 text-center"  style="padding-left: 1%;padding-right: 1%">
                          <a href="<?= base_url('perjalanandl'); ?>" class="btn btn-lg btn-just-icon btn-facebook">
                              <i class="fa fa-car"></i>
                          </a>
                          </br>
                          <a class="card-title"><small>DL</small></a> 
                      </div>
                      <div class="col-4 text-center"  style="padding-left: 1%;padding-right: 1%">
                          <a href="<?= base_url('imp'); ?>" class="btn btn-lg btn-just-icon btn-facebook">
                              <i class="fa fa-plane"></i>
                          </a>
                          </br>
                          <a class="card-title"><small>IMP</small></a> 
                      </div>
                      <div class="col-4 mr-auto text-center"  style="padding-left: 1%;padding-right: 1%">
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
    <!-- </div> -->
    <!-- End Absensi -->

    <?php if ($this->session->userdata('posisi_id') < 7){ ?>
    <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div id="accordionCuti" role="tablist">
              <div class="card-collapse">
                <div class="card-header" role="tab" id="headingCuti">
                  <h5 class="mb-0">
                    <a class="" data-toggle="collapse" href="#collapseCuti" aria-expanded="true" aria-controls="collapseCuti">
                    <h3 class="card-title">Cuti
                      <i class="material-icons">keyboard_arrow_down</i>
                    </h3>
                    </a>
                  </h5>
                </div>
                <div id="collapseCuti" class="collapse show" role="tabpanel" aria-labelledby="headingCuti" data-parent="#accordion">
                  <div class="card-body">
                    <div class="material-datatables">
                      <table id="dtcuti" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
            <tr>
                <th>Nama</th>
                <th>Sampai</th>
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
    <!-- </div> -->
    <!-- End Absensi -->

    <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div id="accordionForm" role="tablist">
              <div class="card-collapse">
                <div class="card-header" role="tab" id="headingForm">
                  <h5 class="mb-0">
                    <a class="" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm">
                    <h3 class="card-title">Download Form 
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
                <th>FORM PENGAJUAN BANTUAN RELOKASI</th>
                <th><a href="https://drive.google.com/file/d/1GL82ndCXngkLUjurLLp1qHzqU5BJ6rK7/view?usp=sharing" target="_blank" class='btn btn-link btn-success'><i class='fa fa-download'></i> Download<div class='ripple-container'></div></a></th>
              </tr>
              <tr>
                <th>FORM PENGAJUAN PINJAMAN UANG</th>
                <th><a href="https://drive.google.com/file/d/1Y2CFhbPnVzcSq6rm3Mo3y0mmvRCkTs-A/view?usp=sharing" target="_blank" class='btn btn-link btn-success'><i class='fa fa-download'></i> Download<div class='ripple-container'></div></a></th>
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

  </div>
  <!-- end container-fluid -->
</div>
<!-- end content -->

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
      
        Swal.fire({
          title: 'Untuk melihat perjalanan hari ini silahkan ke menu Perjalanan Dinas lalu pilih "Sedang Bertugas"',
          html: '',
          // imageUrl: '<?= base_url(); ?>/assets/img/info/idul-fitri-1443H.jpg',
          // imageWidth: 400,
          // imageHeight: 200,
          // imageAlt: 'Custom image',
          timer: 5000,
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

  });
</script>