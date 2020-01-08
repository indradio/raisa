<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?= $this->session->flashdata('pilihtgl'); ?>
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Laporan Jam Kerja</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <form action="<?= base_url('pmd/lembur'); ?>" method="post">
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
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Nama</th>
                                            <th>NPK</th>
                                            <th>Kategori</th>
                                            <th>COPRO</th>
                                            <th>Aktivitas</th>
                                            <th>Deskripsi Hasil</th>
                                            <th>Progres Hasil</th>
                                            <th>Durasi</th>
                                            <th>Cell / Section</th>
                                            <th>Dept</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Nama</th>
                                            <th>NPK</th>
                                            <th>Kategori</th>
                                            <th>COPRO</th>
                                            <th>Aktivitas</th>
                                            <th>Deskripsi Hasil</th>
                                            <th>Progres Hasil</th>
                                            <th>Durasi</th>
                                            <th>Cell / Section</th>
                                            <th>Dept</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($aktivitas as $a) : 
                                              $lembur = $this->db->get_where('lembur', ['id' => $a['link_aktivitas']])->row_array();
                                        ?>
                                            <tr>
                                                <td><?= date('m-d-Y H:i', strtotime($lembur['tglmulai_aktual'])); ?></td>
                                                <td><?= date('m-d-Y H:i', strtotime($lembur['tglselesai_aktual'])); ?></td>
                                                <?php $krywn = $this->db->get_where('karyawan', ['npk' => $a['npk']])->row_array(); ?>
                                                <td><?= $krywn['nama']; ?></td>
                                                <td><?= $a['npk']; ?></td>
                                                <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                                <td><?= $k['nama']; ?> </td>
                                                <td><?= $a['copro']; ?></td>
                                                <td><?= $a['aktivitas']; ?></td>
                                                <td><?= $a['deskripsi_hasil']; ?></td>
                                                <?php $s = $this->db->get_where('aktivitas_status', ['id' => $a['status']])->row_array(); ?>
                                                <td><?= $s['nama'] .', '. $a['progres_hasil']; ?>%</td>
                                                <td><?= $a['durasi']; ?> jam</td>
                                                <?php $sect = $this->db->get_where('karyawan_sect', ['id' => $krywn['sect_id']])->row_array(); ?>
                                                <td><?= $sect['nama']; ?></td>
                                                <?php $dept = $this->db->get_where('karyawan_dept', ['id' => $krywn['dept_id']])->row_array(); ?>
                                                <td><?= $dept['inisial']; ?></td>
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