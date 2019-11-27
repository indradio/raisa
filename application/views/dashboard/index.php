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
        </div>
      </div>
      <?php endforeach; 
      }?>
    </div>
    <!-- end banner -->
 <!-- START List Makan LEMBUR -->
    <?php if (date('H:i') >= '16:00' AND date('H:i') <= '20:00' ){ ?>
    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Daftar Makan Malam Lembur </h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lembur_makan_malam as $lmm) : ?>
                                        <tr>
                                            <td><?= $lmm['nama']; ?> <small>(<?= $lmm['id']; ?>)</small></td>
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
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    <?php }; ?>
    <!-- END List Makan LEMBUR -->

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
                                        <th>Jenis</th>
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
                                              if ($p['id']) { ?>
                                                <td class="text-center">
                                                  <?php $status = $this->db->get_where('perjalanan_status', ['id' => $p['status']])->row_array(); ?>
                                                  <?php if ($p['status'] == 1) {?>
                                                    <div class="img-container">
                                                      <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan3.png" alt="...">
                                                    </div>
                                                    <span class="badge badge-pill badge-info"><?= $status['nama']; ?></span>
                                                  <?php }elseif ($p['status'] == 2) {?>
                                                    <div class="img-container">
                                                      <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan4.png" alt="...">
                                                    </div>
                                                    <a href="#" class="badge badge-pill badge-danger" data-toggle="modal" data-target="#detail" data-id="<?= $k['device_id']; ?>"><?= $status['nama']; ?></a>
                                                  <?php } elseif ($p['status'] == 8 or $p['status'] == 11) {?>
                                                    <div class="img-container">
                                                      <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan3.png" alt="...">
                                                    </div>
                                                    <span class="badge badge-pill badge-warning"><?= $status['nama']; ?></span>
                                                  <?php };?>
                                                </td>
                                                <td class="td-name">
                                                    <a><?= $k['nopol']; ?></a>
                                                    <br />
                                                    <small><?= $k['nama'] . ' - ' . $k['tipe']; ?></small>
                                                    <br />
                                                    <small><?= $p['id']; ?></small>
                                                </td>
                                                <td><?= $p['anggota']; ?></td>
                                                <td><?= $p['tujuan']; ?></td>
                                                <td><?= $p['keperluan']; ?></td>
                                                <td><?= $p['jenis_perjalanan']; ?></td>
                                                <td><?= date('d-M', strtotime($p['tglberangkat'])). ' ' .date('H:i', strtotime($p['jamberangkat'])); ?></td>
                                                <td><?= date('d-M', strtotime($p['tglkembali'])). ' ' .date('H:i', strtotime($p['jamkembali'])); ?></td>
                                              <?php }else{
                                                $queryReservasi = "SELECT *
                                                FROM `reservasi`
                                                WHERE `nopol` = '$nopol' AND `tglberangkat` <= CURDATE() AND `tglkembali` >= CURDATE() AND  `status` != 0 AND `status` != 9
                                                ";
                                                $r = $this->db->query($queryReservasi)->row_array();
                                                if ($r['id']) { ?>
                                                  <td class="text-center">
                                                  <div class="img-container">
                                                      <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan2.png" alt="...">
                                                  </div>
                                                  <?php if ($r['status'] == 1) {?>
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
                                                  <td class="td-name">
                                                    <a><?= $k['nopol']; ?></a>
                                                    <br />
                                                    <small><?= $k['nama'] . ' - ' . $k['tipe']; ?></small>
                                                    <br />
                                                    <small><?= $r['id']; ?></small>
                                                  </td>
                                                  <td><?= $r['anggota']; ?></td>
                                                  <td><?= $r['tujuan']; ?></td>
                                                  <td><?= $r['keperluan']; ?></td>
                                                  <td><?= $r['jenis_perjalanan']; ?></td>
                                                  <td><?= date('d-M', strtotime($r['tglberangkat'])). ' ' .date('H:i', strtotime($r['jamberangkat'])); ?></td>
                                                  <td><?= date('d-M', strtotime($r['tglkembali'])). ' ' .date('H:i', strtotime($r['jamkembali'])); ?></td>
                                                <?php }else{ ?>
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
                                                  <?php if ($pn['status'] == 1) {?>
                                                    <div class="img-container">
                                                      <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan3.png" alt="...">
                                                    </div>
                                                    <span class="badge badge-pill badge-info"><?= $status_pn['nama']; ?></span>
                                                  <?php }elseif ($pn['status'] == 2) {?>
                                                    <div class="img-container">
                                                      <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan4.png" alt="...">
                                                    </div>
                                                    <span class="badge badge-pill badge-danger"><?= $status_pn['nama']; ?></span>
                                                  <?php } elseif ($pn['status'] == 8 or $pn['status'] == 11) {?>
                                                    <div class="img-container">
                                                      <img src="<?= base_url(); ?>assets/img/kendaraan/kendaraan3.png" alt="...">
                                                    </div>
                                                    <span class="badge badge-pill badge-warning"><?= $status_pn['nama']; ?></span>
                                                  <?php };?>
                                                </td>
                                        <td class="td-name">
                                            <a><?= $pn['nopol']; ?></a>
                                            <br />
                                            <small><?= $pn['kepemilikan']; ?></small>
                                            <br />
                                            <small><?= $pn['id']; ?></small>
                                        </td> 
                                        <td><?= $pn['anggota']; ?></td>
                                        <td><?= $pn['tujuan']; ?></td>
                                        <td><?= $pn['keperluan']; ?></td>
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
<script>
    $(document).ready(function(){
        $('#detail').on('show.bs.modal', function (event) {
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
                    
                    if (id){
                      x = myObj.data[id]['device_info']['name'];
                      y = myObj.data[id]['realtime']['location'];
                      z = myObj.data[id]['realtime']['ignition_status'];
                      lat = myObj.data[id]['realtime']['latitude'];
                      lng = myObj.data[id]['realtime']['longitude'];
                      document.getElementById("nopol").value = x;
                      document.getElementById("lokasi").value = y;
                      document.getElementById("ignition").value = z;
                      // Request finished. Do processing here.
                    }else{
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

                    var marker = new google.maps.Marker({
                    position: location
                    });

                    marker.setMap(map);

                }
            }
            xhr.send("username=winteq&password=winteq123&devices=2019110056%3B2019110057%3B2019110055");
            // xhr.send(new Int8Array()); 
            // xhr.send(element);
        })
    });
</script>