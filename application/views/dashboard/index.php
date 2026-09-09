<!-- Swiper CSS & JS via CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
  .swiper-banner-container {
    width: 100%;
    padding-top: 10px;
    padding-bottom: 40px;
    overflow: hidden;
  }
  
  /* Setting ukuran slide */
  .swiper-slide-banner {
    width: 70% !important; /* Diperbesar agar fokus tengah lebih dominan */
    height: 70% !important; /* Diperbesar tingginya */
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    transition: transform 0.4s ease, opacity 0.4s ease;
    opacity: 0.25;
    filter: blur(1px);
    transform: scale(0.65) !important;
  }

  /* Slide Tengah yang Aktif */
  .swiper-slide-banner.swiper-slide-active {
    transform: scale(1) !important; /* Ukuran normal 100% */
    opacity: 1;
    filter: blur(0);
    z-index: 10;
    box-shadow: 0 16px 35px rgba(0, 0, 0, 0.2);
  }

  .swiper-slide-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Warna Tombol Navigasi Swiper */
  .swiper-button-next, .swiper-button-prev {
    color: #ffffff;
    background: rgba(0, 0, 0, 0.3);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    backdrop-filter: blur(4px);
  }
  .swiper-button-next::after, .swiper-button-prev::after {
    font-size: 18px;
    font-weight: bold;
  }
</style>

<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">

    <!-- for Mobile -->
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

      <!-- for Web -->
      <?php
        // Duplikasi data secara otomatis jika gambar kurang dari 3 agar sisi kanan tidak melompong
        $bannerSlides = $informasi;
        if (count($informasi) > 0 && count($informasi) < 3) {
            $bannerSlides = array_merge($informasi, $informasi);
            if (count($bannerSlides) == 2) {
                $bannerSlides = array_merge($bannerSlides, $informasi);
            }
        }
      ?>

      <!-- ================= DESKTOP VIEW (SWIPER PREVIEW) ================= -->
      <div class="row mt-4">
      <!-- <div class="row d-none d-sm-block mb-4"> -->
        <div class="col-12">
          <div class="swiper mySwiperBanner swiper-banner-container">
            <div class="swiper-wrapper">
              <?php foreach ($bannerSlides as $row) : ?>
                <div class="swiper-slide swiper-slide-banner">
                  <a href="#" data-toggle="modal" data-target="#bannerModal" data-gambar="<?= base_url('assets/img/info/' . $row->gambar_banner); ?>">
                    <img src="<?= base_url('assets/img/info/' . $row->gambar_banner); ?>" alt="<?= $row->judul; ?>" />
                  </a>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        </div>
      </div>
      <!-- ================= END DESKTOP VIEW ================= -->

    </div>

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

<!-- Banner Modal -->
<div class="modal fade" id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="bannerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <img id="gambar" name="gambar" class="img-fluid" />
    </div>
  </div>
</div>


<!-- Javascript -->
<script>

  $(document).ready(function() {
    var swiper = new Swiper(".mySwiperBanner", {
      slidesPerView: "auto",
      centeredSlides: true,
      spaceBetween: -20,
      loop: true,
      loopAdditionalSlides: 3,
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  });

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

    <?php if ($this->session->flashdata('message')=='x'){ ?> 
      
        let timerInterval
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

    // $('#bannerModal').on('show.bs.modal', function(event) {
    //   var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
    //   var modal = $(this)
    //   modal.find('#gambar').attr('src', div.data('gambar'));
    // });

    // window.setTimeout(function() {
    //   $(".alert").fadeTo(200, 0).slideUp(200, function() {
    //     $(this).remove();
    //   });
    // }, 60000);

  });
</script>