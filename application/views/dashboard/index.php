<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
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
          <div class="card-footer">
            <div class="price">
              <h4><?= $info['sect_nama']; ?></h4>
            </div>
            <div class="stats">
              <p class="card-category"><i class="material-icons">time</i> Berlaku sampai <?= $info['berlaku']; ?></p>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <!-- end banner -->
    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Perjalanan Dinas Hari Ini</h4>
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
                                        <th>Nomor DL</th>
                                        <th>Jenis DL</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Keberangkatan</th>
                                        <th>Kembali</th>
                                        <th>Status</th>
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
                                        $queryCari = "SELECT COUNT(*)
                                              FROM `reservasi`
                                              WHERE `nopol` =  '$nopol' AND `tglberangkat` <= CURDATE()  AND `tglkembali` >= CURDATE() AND `status` != 0 AND `status` != 9
                                              ";
                                        $Cari = $this->db->query($queryCari)->row_array();
                                        $total = $Cari['COUNT(*)'];
                                        if ($total == 0) { ?>
                                          <span class="badge badge-pill badge-success">Tersedia</span>
                                          </td>
                                        <?php } else { ?>
                                          <span class="badge badge-pill badge-danger">Sudah Dipesan</span>
                                          </td>
                                          <?php
                                            $queryPerjalanan = "SELECT *
                                            FROM `perjalanan`
                                            WHERE `nopol` = '$nopol' AND `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND  `status` != 0 AND `status` != 9
                                            ";
                                            $p = $this->db->query($queryPerjalanan)->row_array();
                                            if ($p['id'] != null) {
                                            ?>
                                              <td><?= $p['id']; ?></td>
                                              <td><?= $p['jenis_perjalanan']; ?></td>
                                              <td><?= $p['tujuan']; ?></td>
                                              <td><?= $p['keperluan']; ?></td>
                                              <td><?= $p['anggota']; ?></td>
                                              <td><?= date('d/m/Y', strtotime($p['tglberangkat'])). ' ' .date('H:i', strtotime($p['jamberangkat'])); ?></td>
                                              <td><?= date('d/m/Y', strtotime($p['tglkembali'])). ' ' .date('H:i', strtotime($p['jamkembali'])); ?></td>
                                              <?php $status = $this->db->get_where('perjalanan_status', ['id' => $p['status']])->row_array(); ?>
                                              <td><?= $status['nama']; ?></td>
                                            <?php } else { 
                                              $queryReservasi = "SELECT *
                                              FROM `reservasi`
                                              WHERE `nopol` = '$nopol' AND `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND  `status` != 0 AND `status` != 9
                                              ";
                                              $r = $this->db->query($queryReservasi)->row_array();?>
                                              <td><?= $r['id']; ?></td>
                                              <td><?= $r['jenis_perjalanan']; ?></td>
                                              <td><?= $r['tujuan']; ?></td>
                                              <td><?= $r['keperluan']; ?></td>
                                              <td><?= $r['anggota']; ?></td>
                                              <td><?= date('d/m/Y', strtotime($r['tglberangkat'])). ' ' .date('H:i', strtotime($r['jamberangkat'])); ?></td>
                                              <td><?= date('d/m/Y', strtotime($r['tglkembali'])). ' ' .date('H:i', strtotime($r['jamkembali'])); ?></td>
                                              <?php $statusrsv = $this->db->get_where('reservasi_status', ['id' => $r['status']])->row_array(); ?>
                                              <td><?= $statusrsv['nama']; ?></td>
                                            <?php }; ?>
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
                                                <img src="<?= base_url(); ?>assets/img/kendaraan/avanza.jpg" alt="...">
                                            </div>
                                        </td>
                                        <td class="td-name">
                                            <a><?= $pn['nopol']; ?></a>
                                            <br />
                                            <small><?= $pn['kepemilikan']; ?></small>
                                            <br />
                                          <span class="badge badge-pill badge-info">Non-Operasional</span>
                                        </td>  
                                              <td><?= $pn['id']; ?></td>
                                              <td><?= $pn['jenis_perjalanan']; ?></td>
                                              <td><?= $pn['tujuan']; ?></td>
                                              <td><?= $pn['keperluan']; ?></td>
                                              <td><?= $pn['anggota']; ?></td>
                                              <td><?= date('d/m/Y', strtotime($pn['tglberangkat'])). ' ' .date('H:i', strtotime($pn['jamberangkat'])); ?></td>
                                              <td><?= date('d/m/Y', strtotime($pn['tglkembali'])). ' ' .date('H:i', strtotime($pn['jamkembali'])); ?></td>
                                              <?php $status = $this->db->get_where('perjalanan_status', ['id' => $pn['status']])->row_array(); ?>
                                              <td><?= $status['nama']; ?></td>
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