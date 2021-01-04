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
                            <form action="<?= base_url('perjalanandl/cariperjalanan_ta'); ?>" method="post">
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
                            <table id="dtdesc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Nama</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Berangkat</th>
                                        <th>Kembali</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nomor DL</th>
                                        <th>Nama</th>
                                        <th>Peserta</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Berangkat</th>
                                        <th>Kembali</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $row) : ?>
                                        <tr>
                                            <td><?= $row['id']; ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td><?= $row['anggota']; ?></td>
                                            <td><?= $row['tujuan']; ?></td>
                                            <td><?= $row['keperluan']; ?></td>
                                            <td><?= date('d/m/Y', strtotime($row['tglberangkat'])) . ' ' . date('H:i', strtotime($row['jamberangkat'])); ?></td>
                                            <td><?= date('d/m/Y', strtotime($row['tglkembali'])) . ' ' . date('H:i', strtotime($row['jamkembali'])); ?></td>
                                            <td><?= $row['catatan']; ?></td>
                                            <?php $status = $this->db->get_where('perjalanan_status', ['id' => $row['status']])->row_array(); ?>
                                            <td><?= $status['nama']; ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('perjalanan/pdf/ta/') . $row['id']; ?>" class="btn btn-link btn-info btn-just-icon" target="_blank"><i class="material-icons">print</i></a>
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