<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
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
                            <table id="dtperjalanan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Jenis DL</th>
                                        <th>Nama</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Peserta</th>
                                        <th>Tanggal Keberangkatan</th>
                                        <th>Jam Keberangkatan</th>
                                        <th>KM Keberangkatan</th>
                                        <th>Security Keberangkatan</th>
                                        <th>Tanggal Kembali</th>
                                        <th>KM Kembali</th>
                                        <th>Security Kembali</th>
                                        <th>Jam Kembali</th>
                                        <th>Nomor Polisi</th>
                                        <th>Kendaraan</th>
                                        <th>Uang Saku</th>
                                        <th>UM 1</th>
                                        <th>UM 2</th>
                                        <th>UM 3</th>
                                        <th>UM 4</th>
                                        <th>Catatan GA</th>
                                        <th>Catatan Security</th>
                                        <th></th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Jenis DL</th>
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
                                        <th>No. Polisi</th>
                                        <th>Kendaraan</th>
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
                                        <td><?= $pdl['nopol']; ?></td>
                                        <td><?= $pdl['kepemilikan']; ?></td>
                                        <td><?= $pdl['uangsaku']; ?></td>
                                        <td><?= $pdl['um1']; ?></td>
                                        <td><?= $pdl['um2']; ?></td>
                                        <td><?= $pdl['um3']; ?></td>
                                        <td><?= $pdl['um4']; ?></td>
                                        <td><?= $pdl['catatan_ga']; ?></td>
                                        <td><?= $pdl['catatan_security']; ?></td>
                                        <td><?= $pdl['kmtotal']; ?></td>
                                        <?php $status = $this->db->get_where('perjalanan_status', ['id' => $pdl['status']])->row_array(); ?>
                                        <td><?= $status['nama']; ?></td>
                                        <td class="text-right">
                                            <a href="<?= base_url('perjalanandl/suratjalan/') . $pdl['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit" target="_blank"><i class="material-icons">dvr</i></a>
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