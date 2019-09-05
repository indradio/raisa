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
                        <h4 class="card-title">Data Karyawan</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!-- Here you can write extra buttons/actions for the toolbar -->
                            <a href="#" class="btn btn-rose mb-2" role="button" aria-disabled="false" data-toggle="modal" data-target="#karyawanAdd">Tambah Karyawan Baru</a>
                            <a href="<?= base_url('hr/qrc/'); ?>" class="btn btn-warning disabled">Generate QR CODE</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Foto</th>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Inisial</th>
                                        <th>Email</th>
                                        <th>No. HP</th>
                                        <th>Golongan</th>
                                        <th>Fasilitas</th>
                                        <th>Posisi</th>
                                        <th>Divisi</th>
                                        <th>Departemen</th>
                                        <th>Seksi</th>
                                        <th>Atasan 1</th>
                                        <th>Atasan 2</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>QR Code</th>
                                        <th>Foto</th>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Inisial</th>
                                        <th>Email</th>
                                        <th>No. HP</th>
                                        <th>Golongan</th>
                                        <th>Fasilitas</th>
                                        <th>Posisi</th>
                                        <th>Divisi</th>
                                        <th>Departemen</th>
                                        <th>Seksi</th>
                                        <th>Atasan 1</th>
                                        <th>Atasan 2</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($datakaryawan as $kry) :
                                        $golongan = $this->db->get_where('karyawan_gol', ['id' =>  $kry['gol_id']])->row_array();
                                        $fasilitas = $this->db->get_where('karyawan_fasilitas', ['id' =>  $kry['fasilitas_id']])->row_array();
                                        $posisi = $this->db->get_where('karyawan_posisi', ['id' =>  $kry['posisi_id']])->row_array();
                                        $divisi = $this->db->get_where('karyawan_div', ['id' =>  $kry['div_id']])->row_array();
                                        $departemen = $this->db->get_where('karyawan_dept', ['id' =>  $kry['dept_id']])->row_array();
                                        $seksi = $this->db->get_where('karyawan_sect', ['id' =>  $kry['sect_id']])->row_array();
                                        $atasan1 = $this->db->get_where('karyawan_posisi', ['id' =>  $kry['atasan1']])->row_array();
                                        $atasan2 = $this->db->get_where('karyawan_posisi', ['id' =>  $kry['atasan2']])->row_array();
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="img-container">
                                                    <img src="<?= base_url(); ?>assets/img/qrcode/<?= $kry['qrcode'] . '.png'; ?>" alt="...">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="img-container">
                                                    <img src="<?= base_url(); ?>assets/img/faces/<?= $kry['foto']; ?>" alt="...">
                                                </div>
                                            </td>
                                            <td><?= $kry['npk']; ?></td>
                                            <td><?= $kry['nama']; ?></td>
                                            <td><?= $kry['inisial']; ?></td>
                                            <td><?= $kry['email']; ?></td>
                                            <td><?= $kry['phone']; ?></td>
                                            <td><?= $golongan['nama']; ?></td>
                                            <td><?= $fasilitas['nama']; ?></td>
                                            <td><?= $posisi['nama']; ?></td>
                                            <td><?= $divisi['nama']; ?></td>
                                            <td><?= $departemen['nama']; ?></td>
                                            <td><?= $seksi['nama']; ?></td>
                                            <td><?= $atasan1['nama']; ?></td>
                                            <td><?= $atasan2['nama']; ?></td>
                                            <?php if ($kry['is_active'] == 1) : ?>
                                                <td>Aktif</td>
                                            <?php else : ?>
                                                <td>Nonaktif</td>
                                            <?php endif; ?>
                                            <td class="text-right">
                                                <a href="<?= base_url('hr/ubah/') . $kry['npk']; ?>" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">dvr</i></a>
                                                <a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
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