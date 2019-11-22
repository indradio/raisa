<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <!-- <div class="alert alert-rose alert-dismissible fade show" role="alert">
    <strong>Hay Your RAISA!</strong> Buat kamu yang penikmat kopi, Mau dapet COFFEE MAKER biar gak repot nyeduh? Gampangg! 
    </br>yuk isi survei kepuasan acara FAMILY DAY 2019 dan kamu punya kesempatan untuk mendapatkan COFFEE MAKER keren ini? Klik <a href="<?= base_url('famday/survey'); ?>" target="_blank">DISINI</a>. 
    </br>RAISA tunggu paling lambat <b>Tanggal 22 Nov 2019 Jam 16:30</b>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div> -->
  <div class="container-fluid">
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
    if ($total!=0)
    {
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
              <a href="<?= base_url('dashboard/informasi/') . $info['id']; ?>" class="badge badge-pill badge-primary mt-3" rel="tooltip" title="">
                Selengkapnya...
              </a>
            </div>
            <h4 class="card-title">
              <?= $info['judul']; ?>
            </h4>
            <div class="card-description">
              <?= $info['deskripsi']; ?>
            </div>
          </div>
          <!-- <div class="card-footer">
            <div class="price">
              <h4></h4>
            </div>
            <div class="stats">
              <p class="card-category"></p>
            </div>
          </div> -->
        </div>
      </div>
      <?php endforeach; 
      }?>
    </div>
    <!-- end banner -->
    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
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
                                        <th>Nomor</th>
                                        <th>Jenis</th>
                                        <th>Keberangkatan</th>
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
                                                                ORDER BY `id` DESC
                                                            ";
                                    $kendaraan = $this->db->query($queryKendaraan)->result_array();
                                    foreach ($kendaraan as $k) : ?>
                                    <tr>
                                        <td>
                                            <div class="img-container">
                                                <img src="<?= base_url(); ?>assets/img/kendaraan/<?= $k['gambar']; ?>" alt="...">
                                            </div>
                                        </td>
                                        <td class="td-name">
                                            <a><?= $k['nopol']; ?></a>
                                            <br />
                                            <small><?= $k['nama'] . ' - ' . $k['tipe']; ?></small>
                                            <br />
                                            <?php
                                              $nopol = $k['nopol'];
                                              $queryPerjalanan = "SELECT *
                                              FROM `perjalanan`
                                              WHERE `nopol` = '$nopol' AND `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND  `status` != 0 AND `status` != 9
                                              ";
                                              $p = $this->db->query($queryPerjalanan)->row_array();
                                              if ($p['id'] == null) {
                                              $queryReservasi = "SELECT *
                                              FROM `reservasi`
                                              WHERE `nopol` = '$nopol' AND `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND  `status` != 0 AND `status` != 9
                                              ";
                                              $r = $this->db->query($queryReservasi)->row_array();
                                                if ($r['id'] == null) { ?>
                                                  <a href="<?= base_url('reservasi/dl'); ?>" class="badge badge-pill badge-success">Tersedia</a>
                                                </td>
                                                <?php } else { 
                                                  if ($r['status'] == 1) {?>
                                                    <span class="badge badge-pill badge-warning">Menunggu Persetujuan <?= $r['atasan1']; ?></span>
                                                  <?php }elseif ($r['status'] == 2) {?>
                                                    <span class="badge badge-pill badge-warning">Menunggu Persetujuan <?= $r['atasan2']; ?></span>
                                                  <?php }elseif ($r['status'] == 3) {?>
                                                    <span class="badge badge-pill badge-warning">Menunggu Persetujuan DWA</span>
                                                  <?php }elseif ($r['status'] == 4) {?>
                                                    <span class="badge badge-pill badge-warning">Menunggu Persetujuan EJU</span>
                                                  <?php }elseif ($r['status'] == 5) {?>
                                                    <span class="badge badge-pill badge-warning">Menunggu Persetujuan GA</span>
                                                  <?php };?>
                                                  </td>
                                                  <td><?= $r['anggota']; ?></td>
                                                  <td><?= $r['tujuan']; ?></td>
                                                  <td><?= $r['keperluan']; ?></td>
                                                  <td><?= $r['id']; ?></td>
                                                  <td><?= $r['jenis_perjalanan']; ?></td>
                                                  <td><?= date('d-M', strtotime($r['tglberangkat'])). ' ' .date('H:i', strtotime($r['jamberangkat'])); ?></td>
                                                  <td><?= date('d-M', strtotime($r['tglkembali'])). ' ' .date('H:i', strtotime($r['jamkembali'])); ?></td>
                                                <?php };?>
                                              <?php } else { ?>
                                                <?php $status = $this->db->get_where('perjalanan_status', ['id' => $p['status']])->row_array(); ?>
                                                <?php if ($p['status'] == 1) {?>
                                                  <span class="badge badge-pill badge-info"><?= $status['nama']; ?></span>
                                                <?php }elseif ($p['status'] == 2) {?>
                                                  <span class="badge badge-pill badge-danger"><?= $status['nama']; ?></span>
                                                <?php } elseif ($p['status'] == 8 or $p['status'] == 11) {?>
                                                  <span class="badge badge-pill badge-warning"><?= $status['nama']; ?></span>
                                                <?php };?>
                                                </td>
                                                <td><?= $p['anggota']; ?></td>
                                                <td><?= $p['tujuan']; ?></td>
                                                <td><?= $p['keperluan']; ?></td>
                                                <td><?= $p['id']; ?></td>
                                                <td><?= $p['jenis_perjalanan']; ?></td>
                                                <td><?= date('d-M', strtotime($p['tglberangkat'])). ' ' .date('H:i', strtotime($p['jamberangkat'])); ?></td>
                                                <td><?= date('d-M', strtotime($p['tglkembali'])). ' ' .date('H:i', strtotime($p['jamkembali'])); ?></td>
                                              <?php }; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tbody>
                                    <?php
                                        $queryPerjalananNon = "SELECT *
                                        FROM `perjalanan`
                                            WHERE `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND  `status` != 0 AND `status` != 9 AND `kepemilikan` != 'Operasional'
                                            ";
                                            $perjalananNon = $this->db->query($queryPerjalananNon)->result_array();
                                            foreach ($perjalananNon as $pn) : ?>
                                      <tr>
                                        <td>
                                            <div class="img-container">
                                            <?php if($pn['kepemilikan']=='Pribadi'){ ?>
                                             <img src="<?= base_url(); ?>assets/img/kendaraan/inova.jpg" alt="...">
                                            <?php }else{ ?>
                                              <img src="<?= base_url(); ?>assets/img/kendaraan/taksi.jpg" alt="...">
                                            <?php }; ?>
                                            </div>
                                        </td>
                                        <td class="td-name">
                                            <a><?= $pn['nopol']; ?></a>
                                            <br />
                                            <small><?= $pn['kepemilikan']; ?></small>
                                            <br />
                                            <?php $pnstatus = $this->db->get_where('perjalanan_status', ['id' => $pn['status']])->row_array(); ?>
                                            <?php if ($pn['status'] == '1') {?>
                                              <span class="badge badge-pill badge-info"><?= $pnstatus['nama']; ?></span>
                                              <?php } elseif ($pn['status'] == '2') {?>
                                              <span class="badge badge-pill badge-danger"><?= $pnstatus['nama']; ?></span>
                                              <?php } elseif ($pn['status'] == '8' or $pn['status'] == '11') {?>
                                              <span class="badge badge-pill badge-warning"><?= $pnstatus['nama']; ?></span>
                                            <?php };?>
                                        </td> 
                                        <td><?= $pn['anggota']; ?></td>
                                        <td><?= $pn['tujuan']; ?></td>
                                        <td><?= $pn['keperluan']; ?></td>
                                        <td><?= $pn['id']; ?></td>
                                        <td><?= $pn['jenis_perjalanan']; ?></td>
                                        <td><?= date('d-M', strtotime($pn['tglberangkat'])). ' ' .date('H:i', strtotime($pn['jamberangkat'])); ?></td>
                                        <td><?= date('d-M', strtotime($pn['tglkembali'])). ' ' .date('H:i', strtotime($pn['jamkembali'])); ?></td>
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
            <!-- end col-md-4 -->
    </div>
    <!-- end row -->
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
            <div id="revenueChart" class="ct-chart"></div>
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
                <i class="fa fa-circle text-info"></i> Target
                <!-- <i class="fa fa-circle text-warning"></i> Samsung -->
                <i class="fa fa-circle text-danger"></i> Aktual
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