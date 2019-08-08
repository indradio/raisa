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
                        <h4 class="card-title">Data Opname Asset</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Asset</th>
                                        <th class="th-description">Kategori</th>
                                        <th class="th-description">Lokasi</th>
                                        <th class="th-description">First Acq</th>
                                        <th class="th-description">Value Acq</th>
                                        <th class="th-description">Cost Center</th>
                                        <th class="th-description">PIC</th>
                                        <th class="th-description">Status</th>
                                        <th class="th-description">Catatan</th>
                                        <th class="th-description">Tgl Opname</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Asset</th>
                                        <th class="th-description">Kategori</th>
                                        <th class="th-description">Lokasi</th>
                                        <th class="th-description">First Acq</th>
                                        <th class="th-description">Value Acq</th>
                                        <th class="th-description">Cost Center</th>
                                        <th class="th-description">PIC</th>
                                        <th class="th-description">Status</th>
                                        <th class="th-description">Catatan</th>
                                        <th class="th-description">Tgl Opname</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($asset as $a) : ?>
                                        <tr>
                                            <td>
                                                <div class="img-container">
                                                    <img src="<?= base_url(); ?>assets/img/asset/<?= $a['asset_foto']; ?>" alt="...">
                                                </div>
                                            </td>
                                            <td class="td-name">
                                                <a><?= $a['asset_deskripsi']; ?></a>
                                                <br />
                                                <small><?= $a['asset_no'] . '-' . $a['asset_sub_no']; ?></small>
                                            </td>
                                            <td><?= $a['kategori']; ?></td>
                                            <td><?= $a['lokasi']; ?></td>
                                            <td><?= $a['first_acq']; ?></td>
                                            <td><?= $a['value_acq']; ?></td>
                                            <td><?= $a['cost_center']; ?></td>
                                            <?php $karyawan = $this->db->get_where('karyawan', ['npk' =>  $a['npk']])->row_array(); ?>
                                            <td><?= $karyawan['nama']; ?></td>
                                            <?php if ($a['status'] == 1) {
                                                echo '<td>BAIK-ADA-DIGUNAKAN</td>';
                                            } else if ($a['status'] == 2) {
                                                echo '<td>BAIK-TIDAK SESUAI</td>';
                                            } else if ($a['status'] == 3) {
                                                echo '<td>RUSAK</td>';
                                            } else if ($a['status'] == 4) {
                                                echo '<td>HILANG</td>';
                                            }; ?>
                                            <td><?= $a['catatan']; ?></td>
                                            <td><?= $a['tglopname']; ?></td>
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