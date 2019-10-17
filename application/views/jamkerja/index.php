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
                        <h4 class="card-title">Laporan Kerja Harian</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <?php
                            $this->db->where('tanggal_mulai', date("Y-m-d 07:30:00"));
                            $this->db->or_where('tanggal_mulai', date("Y-m-d 07:00:00"));
                            $this->db->where('npk', $this->session->userdata('npk'));
                            $jamkerja = $this->db->get("jamkerja")->row_array();
                            if ($jamkerja['id'] == null) { ?>
                                <a href="<?= base_url('jamkerja/add_jamkerja'); ?>" class="btn btn-lg btn-block btn-youtube mb-2" role="button" aria-disabled="false">BUAT LAPORAN JAM KERJA</a>
                        </div>
                        <div class="material-datatables disabled">
                        <?php } else {
                            $link = 'JK' . date('ymd');

                            $this->db->select_sum('durasi');
                            $this->db->where('link_aktivitas', $link);
                            $query = $this->db->get('aktivitas');
                            $durasi = $query->row()->durasi;

                            $this->db->select_sum('durasi');
                            $this->db->where('link_aktivitas', $link);
                            $this->db->where('kategori', '1');
                            $query1 = $this->db->get('aktivitas');
                            $kategori1 = $query1->row()->durasi;
                            $bar1 = $kategori1 * 12.5;

                            $this->db->select_sum('durasi');
                            $this->db->where('link_aktivitas', $link);
                            $this->db->where('kategori', '2');
                            $query2 = $this->db->get('aktivitas');
                            $kategori2 = $query2->row()->durasi;
                            $bar2 = $kategori2 * 12.5;

                            $this->db->select_sum('durasi');
                            $this->db->where('link_aktivitas', $link);
                            $this->db->where('kategori', '3');
                            $query3 = $this->db->get('aktivitas');
                            $kategori3 = $query3->row()->durasi;
                            $bar3 = $kategori3 * 12.5;

                            if ($durasi == '0') {
                                $sisadurasi = 8;
                            } else {
                                $sisadurasi = 8 - $durasi;
                            }
                            $jam = $this->db->get_where('jam', ['id <=' =>  $sisadurasi])->result();
                            ?>
                            <div class="progress" style="width: 100%">
                                <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $bar1; ?>%" aria-valuenow="<?= $kategori1; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                                <div class="progress-bar progress-bar-warning" role="progressbar" style="width: <?= $bar2; ?>%" aria-valuenow="<?= $kategori2; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                                <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $bar3; ?>%" aria-valuenow="<?= $kategori3; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                            </div>
                            <?php if ($durasi < 8.0) { ?>
                                <a href="#" class="btn btn-facebook mb-2" role="button" data-toggle="modal" data-target="#aktivitasModal" aria-disabled="false">TAMBAH LAPORAN JAM KERJA</a>
                            <?php }; ?>
                        </div>
                        <div class="material-datatables">
                        <?php }; ?>
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kategori</th>
                                    <th>COPRO</th>
                                    <th>Aktivitas</th>
                                    <th>Durasi (Jam)</th>
                                    <th>Hasil (%)</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Kategori</th>
                                    <th>COPRO</th>
                                    <th>Aktivitas</th>
                                    <th>Durasi</th>
                                    <th>Hasil</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($aktivitas as $a) : ?>
                                    <tr>
                                        <td><?= $a['id']; ?></td>
                                        <?php $akategori = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                        <td><?= $akategori['nama']; ?></td>
                                        <td><?= $a['copro']; ?></td>
                                        <td><?= $a['aktivitas']; ?></td>
                                        <td><?= $a['durasi']; ?></td>
                                        <td><?= $a['progres_hasil']; ?></td>
                                        <td class="text-right">
                                            <a href="<?= base_url('perjalanandl/prosesdl1/') . $a['id']; ?>" class="badge badge-pill badge-danger">HAPUS</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
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
<!-- Modal -->
<div class="modal fade" id="aktivitasModal" tabindex="-1" role="dialog" aria-labelledby="aktivitasModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-rose text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Aktivitas</h4>
                    </div>
                </div>
                <form id="Aktivitas" class="form" method="post" action="<?= base_url('jamkerja/aktivitas'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="kategori" name="kategori" title="Pilih Kategori" required>
                                    <option value="1">Project</option>
                                    <option value="2">Lain-lain Project</option>
                                    <option value="3">Lain-lain Non Project</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="copro">Project</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="copro" name="copro" title="Pilih Project" data-size="5" data-live-search="false" required>
                                    <?php
                                    foreach ($project as $row) {
                                        echo '<option data-subtext="' . $row->deskripsi . '" value="' . $row->copro . '">' . $row->copro . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="aktivitas">Aktivitas</label>
                                <textarea class="form-control has-success" id="aktivitas" name="aktivitas" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="durasi">Durasi</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="durasi" name="durasi" title="Pilih Durasi" data-size="5" required>
                                    <?php
                                    foreach ($jam as $row) {
                                        echo '<option value="' . $row->id . '">' . $row->nama . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="progres_hasil">Hasil</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="progres_hasil" name="progres_hasil" title="Pilih Hasil" required>
                                    <option value="100">100%</option>
                                    <option value="90">90%</option>
                                    <option value="75">75%</option>
                                    <option value="50">50%</option>
                                    <option value="25">25%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-rose btn-round">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>