<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <!-- Banner -->
    <div class="row">
      <?php
      $queryInfo = "SELECT *
                                    FROM `informasi`
                                    WHERE `berlaku` >= CURDATE()
                                    ORDER BY `id` DESC
                                ";
      $informasi = $this->db->query($queryInfo)->result_array();
      ?>
      <?php foreach ($informasi as $info) : ?>
      <div class="col-md-4">
        <div class="card card-product">
          <div class="card-header card-header-image" data-header-animation="true">
            <a href="#pablo">
              <img class="img" src="<?= base_url(); ?>assets/img/info/<?= $info['gambar']; ?>">
            </a>
          </div>
          <div class="card-body">
            <div class="card-actions text-center">
              <button type="button" class="btn btn-danger btn-link fix-broken-card">
                <i class="material-icons">build</i> Fix Header!
              </button>
              <a href="<?= base_url('dashboard/informasi/') . $info['id']; ?>" class="btn btn-default btn-link" rel="tooltip" title="">
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
            <h4 class="card-title">Perjalanan Dinas Luar Hari ini</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Nomor DL</th>
                    <th>Jenis DL</th>
                    <th>Nomor Polisi</th>
                    <th>Kendaraan</th>
                    <th>Tujuan</th>
                    <th>Keperluan</th>
                    <th>Peserta</th>
                    <th>Tanggal Keberangkatan</th>
                    <th>Jam Keberangkatan</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nomor DL</th>
                    <th>Jenis DL</th>
                    <th>No. Polisi</th>
                    <th>Kendaraan</th>
                    <th>Tujuan</th>
                    <th>Keperluan</th>
                    <th>Peserta</th>
                    <th>Tgl Keberangkatan</th>
                    <th>Jam Keberangkatan</th>
                    <th>Status</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  $queryPerjalanan = "SELECT *
                   FROM `perjalanan`
                   WHERE `tglberangkat` >= CURDATE() and `tglkembali` <= CURDATE()
               ";
                  $perjalanan = $this->db->query($queryPerjalanan)->result_array();
                  foreach ($perjalanan as $p) : ?>
                  <tr>
                    <td><?= $p['id']; ?></td>
                    <td><?= $p['jenis_perjalanan']; ?></td>
                    <td><?= $p['nopol']; ?></td>
                    <td><?= $p['kepemilikan']; ?></td>
                    <td><?= $p['tujuan']; ?></td>
                    <td><?= $p['keperluan']; ?></td>
                    <td><?= $p['anggota']; ?></td>
                    <td><?= date('d/m/Y', strtotime($p['tglberangkat'])); ?></td>
                    <td><?= date('H:i', strtotime($p['jamberangkat'])); ?></td>
                    <?php $status = $this->db->get_where('perjalanan_status', ['id' => $p['status']])->row_array(); ?>
                    <td><?= $status['nama']; ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
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