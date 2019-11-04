<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <!-- Start - Card summary kategory -->
        <div class="row">
        <?php
        $queryKrKategori = "SELECT *
                            FROM `kendaraan_status` ";
        $krkategori = $this->db->query($queryKrKategori)->result_array();
        foreach ($krkategori as $k) : 
            $this->db->where('kepemilikan', $k['nama']);
            $this->db->where('month(tglberangkat)','11');
            $this->db->where('status','9');
            $queryKategori = $this->db->get('perjalanan');
           
            $this->db->select_sum('kmtotal');
            $this->db->where('kepemilikan', $k['nama']);
            $this->db->where('month(tglberangkat)','11');
            $this->db->where('status','9');
            $queryKm = $this->db->get('perjalanan');
            $kmtotal = $queryKm->row()->kmtotal;
        ?>
        <div class="col-md-3">
          <div class="card card-product">
            <div class="card-header card-header-image" data-header-animation="false">
              <img class="img" src="<?= base_url(); ?>assets/img/kendaraan/avanza.jpg">
            </div>
            <div class="card-body">
              <h4 class="card-title">
                <?= $k['nama']; ?>
              </h4>
              <div class="card-description">
                <?= $queryKategori->num_rows(); ?> Perjalanan
              </div>
            </div>
            <div class="card-footer justify-content-center">
                <a href="#" class="btn btn-primary btn-round" role="button" aria-disabled="true"><?= $kmtotal; ?> KM</a>                 
            </div>
          </div>
        </div>
        <?php 
        endforeach; 
        ?>
      </div>
      <!-- End - Card summary kategory -->
    <!-- Start - Card summary kendaraan -->
    <div class="row">
        <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Laporan Perjalanan Dinas (Kendaraan)</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="dtreportkr" class="table table-striped table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Kendaraan</th>
                                        <th>Perjalanan</th>
                                        <th>Total Kilometer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $queryKendaraan = "SELECT *
                                                    FROM `kendaraan`
                                                    WHERE `id` != '1' AND `id` != '2' AND `id` != '3' AND `id` != '4'
                                                    ORDER BY `id` DESC";
                                $kendaraan = $this->db->query($queryKendaraan)->result_array();
                                foreach ($kendaraan as $k) : 
                                    $this->db->where('nopol', $k['nopol']);
                                    $this->db->where('month(tglberangkat)','11');
                                    $this->db->where('status','9');
                                    $queryTrip = $this->db->get('perjalanan');
                                
                                    $this->db->select_sum('kmtotal');
                                    $this->db->where('nopol', $k['nopol']);
                                    $this->db->where('month(tglberangkat)','11');
                                    $this->db->where('status','9');
                                    $queryKm = $this->db->get('perjalanan');
                                    $kmtotal = $queryKm->row()->kmtotal;
                                    if ($kmtotal != 0){
                                ?>
                                    <tr>
                                        <td class="td-name"><?= $k['nopol']; ?></td>
                                        <td><?= $queryTrip->num_rows(); ?></td>
                                        <td><?= $kmtotal; ?></td>
                                    </tr>
                                <?php 
                                };
                                endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-6 -->
        <!-- End - Card summary kendaraan -->
        <!-- Start - Card summary Peserta -->
        <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Laporan Perjalanan Dinas (Peserta)</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="dtreportps" class="table table-striped table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Karyawan</th>
                                        <th>Perjalanan</th>
                                        <th>Total Kilometer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $queryPeserta = "SELECT *
                                                    FROM `karyawan`
                                                    WHERE `status` = '1'
                                                    ORDER BY `npk` ASC";
                                $peserta = $this->db->query($queryPeserta)->result_array();
                                foreach ($peserta as $p) : 
                                    $this->db->like('anggota', $p['inisial']);
                                    $this->db->where('month(tglberangkat)','11');
                                    $this->db->where('status','9');
                                    $queryTrip = $this->db->get('perjalanan');
                                
                                    $this->db->select_sum('kmtotal');
                                    $this->db->like('anggota', $p['inisial']);
                                    $this->db->where('month(tglberangkat)','11');
                                    $this->db->where('status','9');
                                    $queryKm = $this->db->get('perjalanan');
                                    $kmtotal = $queryKm->row()->kmtotal;
                                    if ($kmtotal != 0){
                                ?>
                                    <tr>
                                        <td class="td-name"><a href="#" class="btn btn-primary btn-link" role="button" aria-disabled="true"><?= $p['nama']; ?></a></td>
                                        <td><?= $queryTrip->num_rows(); ?></td>
                                        <td><?= $kmtotal; ?></td>
                                    </tr>
                                <?php 
                                };
                                endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-6 -->
        <!-- end off all -->
       <!-- End - Card summary Peserta -->
        <div class="row" hidden>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Data Perjalanan Dinas Luar</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <form action="<?= base_url('perjalanandl/cariperjalanan'); ?>" method="post">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Dari Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglawal" name="tglawal">
                                        </div>
                                    </div>
                                    <label class="col-md-2 col-form-label">Sampai Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglakhir" name="tglakhir">
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-rose">Cari</a>
                                    </div>
                                </div>
                            </form>
                            <table id="dtperjalanan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Jenis DL</th>
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>KM Keberangkatan</th>
                                        <th>Security Keberangkatan</th>
                                        <th>Tgl Kembali</th>
                                        <th>Jam Kembali</th>
                                        <th>KM Kembali</th>
                                        <th>Security Kembali</th>
                                        <th>KM Total</th>
                                        <th>Uang Saku</th>
                                        <th>UM 1</th>
                                        <th>UM 2</th>
                                        <th>UM 3</th>
                                        <th>UM 4</th>
                                        <th>Catatan GA</th>
                                        <th>Catatan Security</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Jenis DL</th>
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>KM Keberangkatan</th>
                                        <th>Security Keberangkatan</th>
                                        <th>Tgl Kembali</th>
                                        <th>Jam Kembali</th>
                                        <th>KM Kembali</th>
                                        <th>Security Kembali</th>
                                        <th>KM Total</th>
                                        <th>Uang Saku</th>
                                        <th>UM 1</th>
                                        <th>UM 2</th>
                                        <th>UM 3</th>
                                        <th>UM 4</th>
                                        <th>Catatan GA</th>
                                        <th>Catatan Security</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $pdl) : ?>
                                        <tr>
                                            <td><?= $pdl['id']; ?></td>
                                            <td><?= $pdl['jenis_perjalanan']; ?></td>
                                            <td><?= $pdl['nopol']; ?></td>
                                            <td><?= $pdl['kepemilikan']; ?></td>
                                            <td><?= $pdl['nama']; ?></td>
                                            <td><?= $pdl['tujuan']; ?></td>
                                            <td><?= $pdl['keperluan']; ?></td>
                                            <td><?= $pdl['anggota']; ?></td>
                                            <td><?= $pdl['tglberangkat']; ?></td>
                                            <td><?= $pdl['jamberangkat']; ?></td>
                                            <td><?= $pdl['kmberangkat']; ?></td>
                                            <td><?= $pdl['cekberangkat']; ?></td>
                                            <td><?= $pdl['tglkembali']; ?></td>
                                            <td><?= $pdl['jamkembali']; ?></td>
                                            <td><?= $pdl['kmkembali']; ?></td>
                                            <td><?= $pdl['cekkembali']; ?></td>
                                            <td><?= $pdl['kmtotal']; ?></td>
                                            <td><?= $pdl['uangsaku']; ?></td>
                                            <td><?= $pdl['um1']; ?></td>
                                            <td><?= $pdl['um2']; ?></td>
                                            <td><?= $pdl['um3']; ?></td>
                                            <td><?= $pdl['um4']; ?></td>
                                            <td><?= $pdl['catatan_ga']; ?></td>
                                            <td><?= $pdl['catatan_security']; ?></td>
                                            <?php $status = $this->db->get_where('perjalanan_status', ['id' => $pdl['status']])->row_array(); ?>
                                            <td><?= $status['nama']; ?></td>
                                            <td class="text-right">
                                                <?php if ($pdl['status'] == '0') { ?>
                                                    <a href="<?= base_url('perjalanandl/aktifkan/') . $pdl['id']; ?>" class="badge badge-success">Aktifkan</a>
                                                <?php } elseif ($pdl['status'] == '9') { ?>
                                                    <a href="<?= base_url('perjalanandl/suratjalan/') . $pdl['id']; ?>" class="btn btn-link btn-info btn-just-icon" target="_blank"><i class="material-icons">print</i></a>
                                                <?php }; ?>
                                            </td>
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
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->