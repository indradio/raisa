<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <!-- Begin Content -->
          <strong>INFO PENTING! PERUBAHAN JAM KEHADIRAN</strong>
          </br>
          </br>Sesuai dengan Surat Keputusan No <strong>OO4/WTQ-HR/IV/2020</strong> tentang <strong>"Pengaturan Jam Kerja Karyawan pada bulan Ramadhan 1441 H"</strong>.
          </br>Berikut adalah perubahan jadwal absensi melalui RAISA.
          </br>
          </br><strong>1. Check in antara 06:30 - 07.30</strong>
          </br><strong>2. Istirahat antara 11.30 - 13.00</strong>
          </br><strong>3. Check out antara 16.00 - 18.00</strong>
          </br>
          </br><a href="<?= base_url(); ?>presensi" class="btn btn-success">KLIK DISINI UNTUK ABSENSI</a>
          </br><small>*Pastikan GPS smartphone kamu aktif dan pilih izinkan jika muncul peringatan saat membuka halaman.</small>
          <!-- End Content -->
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-danger card-header-icon">
            <div class="card-icon">
              <i class="material-icons">feedback</i>
            </div>
            <h4 class="card-title">Surat Keterangan/Izin Operasional</h4>
          </div>
          <div class="card-body">
            <!-- Begin Content -->
            Sesuai dengan peraturan pemerintah terkait kebijakan <strong>Pembatasan Sosial Berskala Besar (PSBB)</strong>.
            </br>Oleh karena itu, Kegiatan Operasional WINTEQ tetap dijalankan dengan mengikuti aturan yang telah ditetapkan oleh pemerintah.
            </br>Bagi teman-teman yang membutuhkan surat keterangan/izin tersebut dapat dilihat melalui link berikut :
            </br>
            </br><a href="<?= base_url('assets/pdf/dispensasi_kemenperin.pdf'); ?>" class="btn btn-linkedin" target="_blank">
              <span class="btn-label">
                <i class="material-icons">cloud_download</i>
              </span>
              DOWNLOAD SK KEMENPERIN
            </a>
            </br><small>*Surat Keterangan/Izin dari Kemenperin</small>
            </br>
            </br><a href="<?= base_url('assets/pdf/dispensasi_winteq.pdf'); ?>" class="btn btn-linkedin" target="_blank">
              <span class="btn-label">
                <i class="material-icons">cloud_download</i>
              </span>
              DOWNLOAD SK WINTEQ
            </a>
            </br><small>*Surat Keterangan/Izin internal winteq</small>
            </br>
            </br>Surat Keterangan/Izin tersebut dapat juga akses pada halaman berikut : <a href="<?= base_url(); ?>corona/izin">SK OPERASIONAL</a>
            <!-- End Content -->
          </div>
        </div>
      </div>
    </div>
    <!-- Banner -->
    <div class="row">
      <?php
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
    <!-- 16:9 aspect ratio -->
    <!-- <div class="embed-responsive embed-responsive-16by9">
      <iframe src="https://experience.arcgis.com/experience/57237ebe9c5b4b1caa1b93e79c920338"></iframe>
      </div>
    </br> -->
    <div class="row">
      <div class="col-md-6">
        <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/B_HAmnQnmNo/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="12" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
          <div style="padding:16px;"> <a href="https://www.instagram.com/p/B_HAmnQnmNo/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">
              <div style=" display: flex; flex-direction: row; align-items: center;">
                <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>
                <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">
                  <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>
                  <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>
                </div>
              </div>
              <div style="padding: 19% 0;"></div>
              <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-511.000000, -20.000000)" fill="#000000">
                      <g>
                        <path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>
                      </g>
                    </g>
                  </g>
                </svg></div>
              <div style="padding-top: 8px;">
                <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;"> View this post on Instagram</div>
              </div>
              <div style="padding: 12.5% 0;"></div>
              <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;">
                <div>
                  <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div>
                  <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div>
                  <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div>
                </div>
                <div style="margin-left: 8px;">
                  <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div>
                  <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div>
                </div>
                <div style="margin-left: auto;">
                  <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div>
                  <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div>
                  <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div>
                </div>
              </div>
            </a>
            <p style=" margin:8px 0 0 0; padding:0 4px;"> <a href="https://www.instagram.com/p/B_HAmnQnmNo/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_blank">Kamu termasuk yang sedang melaksanakan #WorkFromHome saat ini? Pasti banyak sekali godaan yang menghambat pekerjaanmu ☹️ Mulai dari kasur yang terlihat menggoda, suasana rumah yang tidak kondusif atau bahkan karena ruang kerja yang tidak nyaman? Berikut tips #WorkFromHome agar tetap produktif, disimak yaa. Ayo share juga tips #WorkFromHome produktif versimu dengan komen di bawah ini 👇🏻👇🏻 Stay safe &amp; healty untuk semua ya! #KitaSATUIndonesia #Winteq #astraotoparts #astrainternational #astra #dirumahaja</a></p>
            <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">A post shared by <a href="https://www.instagram.com/astra_winteq/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank"> PT Astra Otoparts - WINTEQ</a> (@astra_winteq) on <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;" datetime="2020-04-18T04:54:02+00:00">Apr 17, 2020 at 9:54pm PDT</time></p>
          </div>
        </blockquote>
        <script async src="//www.instagram.com/embed.js"></script>
      </div>
      <div class="col-md-6 ml-auto">
        <div class="card">
          <div class="card-header card-header-tabs card-header-info">
            <div class="nav-tabs-navigation">
              <div class="nav-tabs-wrapper">
                <span class="nav-tabs-title">TransaksiKu:</span>
                <ul class="nav nav-tabs" data-tabs="tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#perjalanan" data-toggle="tab">
                      <i class="material-icons">emoji_transportation</i> Perjalanan
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#lembur" data-toggle="tab">
                      <i class="material-icons">update</i> Lembur
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <!-- <li class="nav-item">
                          <a class="nav-link" href="#jamkerja" data-toggle="tab">
                            <i class="material-icons">emoji_transportation</i> Jam Kerja
                            <div class="ripple-container"></div>
                          </a>
                        </li> -->
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="perjalanan">
                <table class="table">
                  <tbody>
                    <?php
                    $this->db->where('npk', $this->session->userdata('npk'));
                    $this->db->where('status !=', '0');
                    $this->db->where('status !=', '7');
                    $this->db->where('status !=', '9');
                    $reservasi = $this->db->get('reservasi')->result_array();
                    if (!empty($reservasi)) {
                      $no = 1;
                      foreach ($reservasi as $r) {
                        $status = $this->db->get_where('reservasi_status', ['id' => $r['status']])->row_array();
                    ?>
                        <tr>
                          <td>
                            <?= $no; ?>
                          </td>
                          <td>Reservasi Perjalanan kamu dengan nomor ID : <b><?= $r['id']; ?></b> saat ini dalam status <b><?= $status['nama']; ?></b></td>
                        </tr>
                    <?php $no++;
                      }
                    }
                    ?>
                    <?php
                    $this->db->where('npk', $this->session->userdata('npk'));
                    $this->db->where('status !=', '0');
                    $this->db->where('status !=', '9');
                    $perjalanan = $this->db->get('perjalanan')->result_array();
                    if (!empty($perjalanan)) {
                      $no = 1;
                      foreach ($perjalanan as $p) {
                        $status = $this->db->get_where('perjalanan_status', ['id' => $p['status']])->row_array();
                    ?>
                        <tr>
                          <td>
                            <?= $no; ?>
                          </td>
                          <td>Perjalanan kamu dengan nomor ID : <b><?= $p['id']; ?></b> saat ini dalam status <b><?= $status['nama']; ?></b></td>
                        </tr>
                    <?php $no++;
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="lembur">
                <table class="table">
                  <tbody>
                    <?php
                    $this->db->where('npk', $this->session->userdata('npk'));
                    $this->db->where('status !=', '0');
                    $this->db->where('status !=', '9');
                    $lembur = $this->db->get('lembur')->result_array();
                    if (!empty($lembur)) {
                      $no = 1;
                      foreach ($lembur as $l) {
                        $status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array();
                    ?>
                        <tr>
                          <td>
                            <?= $no; ?>
                          </td>
                          <td>Lembur kamu dengan nomor ID : <b><?= $l['id']; ?></b> saat ini dalam status <b><?= $status['nama']; ?></b></td>
                          <!-- <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                      <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                      <i class="material-icons">close</i>
                                    </button>
                                  </td> -->
                        </tr>
                    <?php $no++;
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- <div class="tab-pane" id="messages">
                      <table class="table">
                        <tbody>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="" checked>
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                            </td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="">
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Sign contract for "What are conference organizers afraid of?"</td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    </p>
    <?php if ($this->session->userdata('contract') == 'Direct Labor') { ?>
      <!-- START OUTSTANDING JAM KERJA -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">assignment</i>
              </div>
              <?php
              $tahun = date('Y');
              $bulan = date('m');
              ?>
              <h4 class="card-title">Status Jam Kerja Periode <?= date('F Y', strtotime("$tahun-$bulan-01")); ?></h4>
            </div>
            <div class="card-body">
              <div class="toolbar">
                <a href="<?= base_url('jamkerja/tanggal/' . date('Y-m-d')); ?>" class="btn btn-facebook" role="button" aria-disabled="false">Laporkan Jam Kerja</a>
              </div>
              <div class="material-datatables">
                <div class="table-responsive">
                  <table id="dt-status" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                      <tr>
                        <?php
                        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                        for ($i = 1; $i < $tanggal + 1; $i++) {
                          echo '<th>' . date('D, d', strtotime($tahun . '-' . $bulan . '-' . $i)) . '</th>';
                        } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      for ($i = 1; $i < $tanggal + 1; $i++) {
                        echo '<td>';
                        $this->db->where('npk', $this->session->userdata('npk'));
                        $this->db->where('year(tglmulai)', $tahun);
                        $this->db->where('month(tglmulai)', $bulan);
                        $this->db->where('day(tglmulai)', $i);
                        $this->db->where('status >', 0);
                        $jamkerja = $this->db->get_where('jamkerja')->row_array();

                        if (date('D', strtotime($tahun . '-' . $bulan . '-' . $i)) == 'Sat' or date('D', strtotime($tahun . '-' . $bulan . '-' . $i)) == 'Sun') {
                          echo '<i class="fa fa-circle text-default"></i>';
                        } else {
                          if (!empty($jamkerja)) {
                            if ($jamkerja['status'] == 9) {
                              echo '<i class="fa fa-circle text-success"></i>';
                            } elseif ($jamkerja['status'] == 1) {
                              echo '<i class="fa fa-circle text-warning"></i>';
                            } elseif ($jamkerja['status'] == 2) {
                              echo '<i class="fa fa-circle text-info"></i>';
                            }
                          } else {
                            echo '<i class="fa fa-circle text-danger"></i>';
                          }
                        }
                      } ?>
                      </tr>
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-md-12">
                  <i class="fa fa-circle text-success"></i> Laporan Jam Kerja Selesai. | <i class="fa fa-circle text-warning"></i> Laporan Jam Kerja sedang diproses oleh RDA/Koordinator.
                  | <i class="fa fa-circle text-info"></i> Laporan Jam Kerja Sedang diproses oleh PPIC.
                  | <i class="fa fa-circle text-danger"></i> Tidak ada Laporan Jam Kerja (Belum melaporkan).
                  | <i class="fa fa-circle text-default"></i> Hari libur akhir pekan.
                </div>
              </div>
            </div>
            <!-- end content-->
          </div>
          <!--  end card  -->
        </div>
        <!-- end col-md-12 -->
      </div>
      <!-- end row -->
      <!-- END OUTSTANDING JAM KERJA -->
    <?php } ?>
    <div class="row">
      <div class="col-md-12">
        <div class="page-categories">
          <!-- <h3 class="title text-center">Page Subcategories</h3> -->
          <!-- <br /> -->
          <ul class="nav nav-pills nav-pills-info nav-pills-icons justify-content-center" role="tablist">
            <!-- <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#link7" role="tablist">
                <i class="material-icons">info</i> Description
              </a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#tabperjalanan" role="tablist">
                <i class="material-icons">emoji_transportation</i> Perjalanan <br>Dinas
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#tablembur" role="tablist">
                <i class="material-icons">update</i> Lembur
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#tabmedical" role="tablist">
                <i class="material-icons">local_hospital</i> Claim <br>Medical
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#proschedule" role="tablist">
                <i class="material-icons">event_note</i> Project <br>Schedule
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#link10" role="tablist">
                <i class="material-icons">help_outline</i> Help Center
              </a>
            </li> -->
          </ul>
          <div class="tab-content tab-space tab-subcategories">
            <!-- <div class="tab-pane" id="link7">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Description about product</h4>
                  <p class="card-category">
                    More information here
                  </p>
                </div>
                <div class="card-body">
                  Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits.
                  <br>
                  <br> Dramatically visualize customer directed convergence without revolutionary ROI.
                </div>
              </div>
            </div> -->
            <div class="tab-pane active" id="tabperjalanan">
              <div class="card">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">directions_car</i>
                  </div>
                  <h4 class="card-title">Perjalanan Dinas Hari Ini <?= date("d-M-Y"); ?></h4>
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="table-responsive">
                    <div class="material-datatables">
                      <table id="" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                          <tr>
                            <th class="text-center"></th>
                            <th>Kendaraan</th>
                            <th>Peserta</th>
                            <th>Tujuan</th>
                            <th>Keperluan</th>
                            <th>Berangkat</th>
                            <th>Kembali</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th class="text-center"></th>
                            <th></th>
                          </tr>
                        </tfoot>
                        <tbody>
                          <?php
                          $queryKendaraan = "SELECT *
                                                      FROM `kendaraan`
                                                      WHERE `kontrak` >= CURDATE() AND `is_active` = 1 AND `id` != 1
                                                      ORDER BY `id` ASC
                                                  ";
                          $kendaraan = $this->db->query($queryKendaraan)->result_array();
                          foreach ($kendaraan as $k) : ?>
                            <tr>
                              <?php
                              $nopol = $k['nopol'];
                              $queryPerjalanan = "SELECT *
                                                  FROM `perjalanan`
                                                  WHERE `nopol` = '$nopol' AND `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND  `status` != 0 AND `status` != 9
                                                  ";
                              $p = $this->db->query($queryPerjalanan)->row_array();
                              if (!empty($p)) { ?>
                                <td class="text-center">
                                  <?php $status = $this->db->get_where('perjalanan_status', ['id' => $p['status']])->row_array(); ?>
                                  <?php if ($p['status'] == 1) { ?>
                                    <div class="img-container">
                                      <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan3.png" alt="...">
                                    </div>
                                    <span class="badge badge-pill badge-info"><?= $status['nama']; ?></span>
                                  <?php } elseif ($p['status'] == 2) { ?>
                                    <div class="img-container">
                                      <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan4.png" alt="...">
                                    </div>
                                    <a href="#" class="badge badge-pill badge-danger" data-toggle="modal" data-target="#detail" data-id="<?= $k['device_id']; ?>"><?= $status['nama']; ?></a>
                                  <?php } elseif ($p['status'] == 8 or $p['status'] == 11) { ?>
                                    <div class="img-container">
                                      <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan3.png" alt="...">
                                    </div>
                                    <span class="badge badge-pill badge-warning"><?= $status['nama']; ?></span>
                                  <?php }; ?>
                                </td>
                                <td class="td-name">
                                  <a><?= $k['nopol']; ?></a>
                                  <br />
                                  <small><?= $k['nama'] . ' - ' . $k['tipe']; ?></small>
                                  <br />
                                  <small><?= $p['id'] . ' - ' . $p['jenis_perjalanan']; ?></small>
                                </td>
                                <td><?= $p['anggota']; ?></td>
                                <td><?= $p['tujuan']; ?></td>
                                <td><?= $p['keperluan']; ?></td>
                                <td><?= date('d-M', strtotime($p['tglberangkat'])) . ' ' . date('H:i', strtotime($p['jamberangkat'])); ?></td>
                                <td><?= date('d-M', strtotime($p['tglkembali'])) . ' ' . date('H:i', strtotime($p['jamkembali'])); ?></td>
                                <?php } else {
                                $queryReservasi = "SELECT *
                                                    FROM `reservasi`
                                                    WHERE `nopol` = '$nopol' AND `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND  `status` != 0 AND `status` != 9
                                                    ";
                                $r = $this->db->query($queryReservasi)->row_array();
                                if (!empty($r)) { ?>
                                  <td class="text-center">
                                    <div class="img-container">
                                      <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan2.png" alt="...">
                                    </div>
                                    <?php if ($r['status'] == 1) { ?>
                                      <span class="badge badge-pill badge-warning">Menunggu Persetujuan <?= $r['atasan1']; ?></span>
                                    <?php } elseif ($r['status'] == 2) { ?>
                                      <span class="badge badge-pill badge-warning">Menunggu Persetujuan <?= $r['atasan2']; ?></span>
                                    <?php } elseif ($r['status'] == 3) { ?>
                                      <span class="badge badge-pill badge-warning">Menunggu Persetujuan DWA</span>
                                    <?php } elseif ($r['status'] == 4) { ?>
                                      <span class="badge badge-pill badge-warning">Menunggu Persetujuan EJU</span>
                                    <?php } elseif ($r['status'] == 5) { ?>
                                      <span class="badge badge-pill badge-warning">Menunggu Persetujuan HR</span>
                                    <?php } elseif ($r['status'] == 6) { ?>
                                      <span class="badge badge-pill badge-warning">Menunggu Persetujuan GA</span>
                                    <?php }; ?>
                                  </td>
                                  <td class="td-name">
                                    <a><?= $k['nopol']; ?></a>
                                    <br />
                                    <small><?= $k['nama'] . ' - ' . $k['tipe']; ?></small>
                                    <br />
                                    <small><?= $r['id'] . ' - ' . $r['jenis_perjalanan']; ?></small>
                                  </td>
                                  <td><?= $r['anggota']; ?></td>
                                  <td><?= $r['tujuan']; ?></td>
                                  <td><?= $r['keperluan']; ?></td>
                                  <td><?= date('d-M', strtotime($r['tglberangkat'])) . ' ' . date('H:i', strtotime($r['jamberangkat'])); ?></td>
                                  <td><?= date('d-M', strtotime($r['tglkembali'])) . ' ' . date('H:i', strtotime($r['jamkembali'])); ?></td>
                                <?php } else { ?>
                                  <td class="text-center">
                                    <div class="img-container">
                                      <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan1.png" alt="...">
                                    </div>
                                    <a href="<?= base_url('reservasi/dl'); ?>" class="badge badge-pill badge-success">Tersedia</a>
                                  </td>
                                  <td class="td-name">
                                    <a><?= $k['nopol']; ?></a>
                                    <br />
                                    <small><?= $k['nama'] . ' - ' . $k['tipe']; ?></small>
                                  </td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              <?php }
                              } ?>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                        <!-- Reservasi Non Operasional -->
                        <tbody>
                          <?php
                          $queryReservasiNon = "SELECT *
                                              FROM `reservasi`
                                              WHERE `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND  `status` != 0 AND `status` < 7 AND `kepemilikan` != 'Operasional'
                                              ORDER BY `kepemilikan` ASC ";
                          $reservasiNon = $this->db->query($queryReservasiNon)->result_array();
                          foreach ($reservasiNon as $rn) : ?>
                            <tr>
                              <td class="text-center">
                                <div class="img-container">
                                  <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan2.png" alt="...">
                                </div>
                                <?php if ($rn['status'] == 1) { ?>
                                  <span class="badge badge-pill badge-warning">Menunggu Persetujuan <?= $rn['atasan1']; ?></span>
                                <?php } elseif ($rn['status'] == 2) { ?>
                                  <span class="badge badge-pill badge-warning">Menunggu Persetujuan <?= $rn['atasan2']; ?></span>
                                <?php } elseif ($rn['status'] == 3) { ?>
                                  <span class="badge badge-pill badge-warning">Menunggu Persetujuan DWA</span>
                                <?php } elseif ($rn['status'] == 4) { ?>
                                  <span class="badge badge-pill badge-warning">Menunggu Persetujuan EJU</span>
                                <?php } elseif ($rn['status'] == 5) { ?>
                                  <span class="badge badge-pill badge-warning">Menunggu Persetujuan HR</span>
                                <?php } elseif ($rn['status'] == 6) { ?>
                                  <span class="badge badge-pill badge-warning">Menunggu Persetujuan GA</span>
                                <?php }; ?>
                              </td>
                              <td class="td-name">
                                <a><?= $rn['nopol']; ?></a>
                                <br />
                                <small><?= $rn['kepemilikan']; ?></small>
                                <br />
                                <small><?= $rn['id'] . ' - ' . $rn['jenis_perjalanan']; ?></small>
                              </td>
                              <td><?= $rn['anggota']; ?></td>
                              <td><?= $rn['tujuan']; ?></td>
                              <td><?= $rn['keperluan']; ?></td>
                              <td><?= date('d-M', strtotime($rn['tglberangkat'])) . ' ' . date('H:i', strtotime($rn['jamberangkat'])); ?></td>
                              <td><?= date('d-M', strtotime($rn['tglkembali'])) . ' ' . date('H:i', strtotime($rn['jamkembali'])); ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                        <!-- Perjalanan Non Operasional -->
                        <tbody>
                          <?php
                          $queryPerjalananNon = "SELECT *
                                            FROM `perjalanan`
                                                WHERE `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND  `status` != 0 AND `status` != 9 AND `kepemilikan` != 'Operasional'
                                                ORDER BY `kepemilikan` ASC ";
                          $perjalananNon = $this->db->query($queryPerjalananNon)->result_array();
                          foreach ($perjalananNon as $pn) : ?>
                            <tr>
                              <td class="text-center">
                                <?php $status_pn = $this->db->get_where('perjalanan_status', ['id' => $pn['status']])->row_array(); ?>
                                <?php if ($pn['status'] == 1) { ?>
                                  <div class="img-container">
                                    <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan3.png" alt="...">
                                  </div>
                                  <span class="badge badge-pill badge-info"><?= $status_pn['nama']; ?></span>
                                <?php } elseif ($pn['status'] == 2) { ?>
                                  <div class="img-container">
                                    <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan4.png" alt="...">
                                  </div>
                                  <span class="badge badge-pill badge-danger"><?= $status_pn['nama']; ?></span>
                                <?php } elseif ($pn['status'] == 8 or $pn['status'] == 11) { ?>
                                  <div class="img-container">
                                    <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan3.png" alt="...">
                                  </div>
                                  <span class="badge badge-pill badge-warning"><?= $status_pn['nama']; ?></span>
                                <?php }; ?>
                              </td>
                              <td class="td-name">
                                <a><?= $pn['nopol']; ?></a>
                                <br />
                                <small><?= $pn['kepemilikan']; ?></small>
                                <br />
                                <small><?= $pn['id'] . ' - ' . $pn['jenis_perjalanan']; ?></small>
                              </td>
                              <td><?= $pn['anggota']; ?></td>
                              <td><?= $pn['tujuan']; ?></td>
                              <td><?= $pn['keperluan']; ?></td>
                              <td><?= date('d-M', strtotime($pn['tglberangkat'])) . ' ' . date('H:i', strtotime($pn['jamberangkat'])); ?></td>
                              <td><?= date('d-M', strtotime($pn['tglkembali'])) . ' ' . date('H:i', strtotime($pn['jamkembali'])); ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!--  end card  -->
            </div>
            <div class="tab-pane" id="tablembur">
              <div class="card">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Lembur Hari Ini <?= date("d-M-Y"); ?></h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <div class="material-datatables">
                      <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                          <tr>
                            <th>Nama</th>
                            <th>Jam</th>
                            <th>Lokasi</th>
                            <th>Approved <small>(atasan1)</small></th>
                            <th>Konsumsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($listlembur as $l) : ?>
                            <?php if ($l['konsumsi'] > 0) {
                              echo '<tr class="table-success">';
                            } else if ($l['konsumsi'] == '0') {
                              echo '<tr class="table-danger">';
                            } else {
                              echo '<tr>';
                            } ?>
                            <td><?= $l['nama']; ?> <small>(<?= $l['id']; ?>)</small></td>
                            <td><?= date('H:i', strtotime($l['tglmulai'])); ?> - <?= date('H:i', strtotime($l['tglselesai'])); ?></td>
                            <td><?= $l['lokasi']; ?></td>
                            <td><?= date('d-M H:i', strtotime($l['tgl_atasan1_rencana'])); ?></td>
                            <?php $konsumsi = $this->db->get_where('lembur_konsumsi', ['id' => $l['konsumsi']])->row_array(); ?>
                            <td><?= $konsumsi['nama']; ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-12">
                      *Konsumsi akan diupdate pada jam 16:00 atau lebih.
                      </br>Pastikan Rencana Lembur kamu sudah disetujui oleh atasan1 paling lambat atau sebelum jam 16:00.
                    </div>
                  </div>
                </div>
                <!-- end content-->
              </div>
              <!--  end card  -->
            </div>
            <div class="tab-pane" id="tabmedical">
              <div class="card">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Claim Medical</h4>
                </div>
                <div class="card-body">
                  <div class="toolbar text-right mb-2">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                    <?php if ($this->session->userdata('sect_id') == 212) {
                      echo '<a href="#" class="btn btn-facebook" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahClaim">Tambah Claim Medical</a>';
                      echo '<a href="#" class="btn btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#emptyClaim">Hapus Semua Medical</a>';
                    }
                    ?>
                  </div>
                  <div class="table-responsive">
                    <div class="material-datatables">
                      <table id="medical" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal Transfer</th>
                            <?php if ($this->session->userdata('sect_id') == 212) {
                              echo '<th>Actions</th>';
                            }
                            ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 1;

                          foreach ($listclaim as $row) : ?>
                            <tr>
                              <td><?= $no++; ?></td>
                              <td><?= $row->nama ?></td>
                              <td><?= date('d M Y', strtotime($row->transfer_at)) ?></td>
                              <?php if ($this->session->userdata('sect_id') == 212) {
                                echo '<td><a href="#" class="btn btn-link btn-danger btn-just-icon" data-toggle="modal" data-target="#hapusClaim" data-id="' . $row->id . '"><i class="material-icons">close</i></a></td>';
                              }
                              ?>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- end content-->
              </div>
              <!--  end card  -->
            </div>
            <div class="tab-pane" id="proschedule">
              <div class="card">
                <!-- <div class="card-header">
                  <h4 class="card-title">Help center</h4>
                  <p class="card-category">
                    More information here
                  </p>
                </div> -->
                <div class="card-body text-center">

                  <!-- <div class="my-gallery" itemscope itemtype="http://schema.org/ImageGallery"> -->


                  <!-- <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                      <a href="<?= base_url(); ?>assets/img/info/wbs.jpg" itemprop="contentUrl" data-size="1440x720">
                          <img class="img-responsive" src="<?= base_url(); ?>assets/img/info/wbs.jpg" itemprop="thumbnail" alt="Image description" />
                      </a>
                      <figcaption itemprop="caption description">Image caption  1</figcaption>
                    </figure> -->

                  <!-- <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                      <a href="https://farm2.staticflickr.com/1043/5186867718_06b2e9e551_b.jpg" itemprop="contentUrl" data-size="964x1024">
                          <img src="https://farm2.staticflickr.com/1043/5186867718_06b2e9e551_m.jpg" itemprop="thumbnail" alt="Image description" />
                      </a>
                      <figcaption itemprop="caption description">Image caption 2</figcaption>
                    </figure>

                    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                      <a href="https://farm7.staticflickr.com/6175/6176698785_7dee72237e_b.jpg" itemprop="contentUrl" data-size="1024x683">
                          <img src="https://farm7.staticflickr.com/6175/6176698785_7dee72237e_m.jpg" itemprop="thumbnail" alt="Image description" />
                      </a>
                      <figcaption itemprop="caption description">Image caption 3</figcaption>
                    </figure>

                    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                      <a href="https://farm6.staticflickr.com/5023/5578283926_822e5e5791_b.jpg" itemprop="contentUrl" data-size="1024x768">
                          <img src="https://farm6.staticflickr.com/5023/5578283926_822e5e5791_m.jpg" itemprop="thumbnail" alt="Image description" />
                      </a>
                      <figcaption itemprop="caption description">Image caption 4</figcaption>
                    </figure> -->


                  <!-- </div> -->

                  <!-- Root element of PhotoSwipe. Must have class pswp. -->
                  <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                    <!-- Background of PhotoSwipe. 
                          It's a separate element, as animating opacity is faster than rgba(). -->
                    <div class="pswp__bg"></div>

                    <!-- Slides wrapper with overflow:hidden. -->
                    <div class="pswp__scroll-wrap">

                      <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
                      <!-- don't modify these 3 pswp__item elements, data is added later on. -->
                      <div class="pswp__container">
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                      </div>

                      <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                      <div class="pswp__ui pswp__ui--hidden">

                        <div class="pswp__top-bar">

                          <!--  Controls are self-explanatory. Order can be changed. -->

                          <div class="pswp__counter"></div>

                          <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                          <button class="pswp__button pswp__button--share" title="Share"></button>

                          <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                          <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                          <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                          <!-- element will get class pswp__preloader--active when preloader is running -->
                          <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                              <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                          <div class="pswp__share-tooltip"></div>
                        </div>

                        <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                        </button>

                        <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                        </button>

                        <div class="pswp__caption">
                          <div class="pswp__caption__center"></div>
                        </div>

                      </div>

                    </div>

                  </div>

                </div>
              </div>
            </div>
            <!-- <div class="tab-pane" id="link10">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Help center</h4>
                  <p class="card-category">
                    More information here
                  </p>
                </div>
                <div class="card-body">
                  From the seamless transition of glass and metal to the streamlined profile, every detail was carefully considered to enhance your experience. So while its display is larger, the phone feels just right.
                  <br>
                  <br> Another Text. The first thing you notice when you hold the phone is how great it feels in your hand. The cover glass curves down around the sides to meet the anodized aluminum enclosure in a remarkable, simplified design.
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
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

<!-- Add Claim Medical Modal -->
<div class="modal fade" id="hapusClaim" tabindex="-1" role="dialog" aria-labelledby="hapusClaimLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Kamu yakin mau menghapus ini?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" action="<?= base_url('dashboard/medical/delete'); ?>">
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

<!-- Add Claim Medical Modal -->
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
    }, 30000);

    $('#detail').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id') // Extract info from data-* attributes
      var modal = $(this)
      modal.find('.modal-body input[name="device_id"]').val(id)

      var xhr = new XMLHttpRequest();
      xhr.open("POST", 'https://gps.intellitrac.co.id/apis/tracking/realtime.php', true);

      //Send the proper header information along with the request
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      xhr.onreadystatechange = function() { // Call a function when the state changes.
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
          var myObj = JSON.parse(this.responseText);

          if (id) {
            x = myObj.data[id]['device_info']['name'];
            y = myObj.data[id]['realtime']['location'];
            z = myObj.data[id]['realtime']['ignition_status'];
            lat = myObj.data[id]['realtime']['latitude'];
            lng = myObj.data[id]['realtime']['longitude'];
            document.getElementById("nopol").value = x;
            document.getElementById("lokasi").value = y;
            document.getElementById("ignition").value = z;
            // Request finished. Do processing here.
          } else {
            document.getElementById("nopol").value = null;
            document.getElementById("lokasi").value = null;
            document.getElementById("ignition").value = null;
            lat = null;
            lng = null;
          }

          var location = new google.maps.LatLng(lat, lng);

          var mapCanvas = document.getElementById('map');

          var mapOptions = {
            center: location,
            zoom: 18,

            mapTypeId: google.maps.MapTypeId.ROADMAP
          }
          var map = new google.maps.Map(mapCanvas, mapOptions);
          var image = 'https://raisa.winteq-astra.com/assets/img/iconmobil.png';
          var marker = new google.maps.Marker({
            position: location,
            icon: image
          });

          marker.setMap(map);

        }
      }
      xhr.send("username=winteq&password=winteq123&devices=2019110056%3B2019110057%3B2019110055");
      // xhr.send(new Int8Array()); 
      // xhr.send(element);
    })

    var dataMultipleBarsChart = {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
</script>