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
                        <?php } else { ?>
                            <div class="progress" style="width: 100%">
                                <div class="progress-bar progress-bar-success" role="progressbar" style="width: 50%" aria-valuenow="4" aria-valuemin="0" aria-valuemax="8"></div>
                                <div class="progress-bar progress-bar-warning" role="progressbar" style="width: 25%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="8"></div>
                                <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 12.5%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="8"></div>
                            </div>
                            <a href="#" class="btn btn-facebook mb-2" role="button" data-toggle="modal" data-target="#aktivitasModal" aria-disabled="false">TAMBAH LAPORAN JAM KERJA</a>
                        </div>
                        <div class="material-datatables">
                        <?php }; ?>
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kategori</th>
                                    <th>COPRO</th>
                                    <th>WBS</th>
                                    <th>Milestone</th>
                                    <th>Aktivitas</th>
                                    <th>Deskripsi</th>
                                    <th>Durasi</th>
                                    <th>Progres</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                    <th class="disabled-sorting"></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Kategori</th>
                                    <th>COPRO</th>
                                    <th>WBS</th>
                                    <th>Milestone</th>
                                    <th>Aktivitas</th>
                                    <th>Deskripsi</th>
                                    <th>Durasi</th>
                                    <th>Progres</th>
                                    <th class="text-right">Actions</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($aktivitas as $a) : ?>
                                    <td><?= $a['id']; ?></td>
                                    <td><?= $a['kategori']; ?></td>
                                    <td><?= $a['copro']; ?></td>
                                    <td><?= $a['milestone']; ?></td>
                                    <td><?= $a['aktivitas']; ?></td>
                                    <td><?= $a['deskripsi_hasil']; ?></td>
                                    <td><?= $a['durasi']; ?></td>
                                    <td><?= $a['progres_hasil']; ?></td>
                                    <td class="text-right">
                                        <a href="<?= base_url('perjalanandl/prosesdl1/') . $a['id']; ?>" class="badge badge-pill badge-success">Proses</a>
                                    </td>
                                    <td>
                                        <a href="" class="badge badge-pill badge-danger" data-toggle="modal" data-target="#batala" data-id="<?= $a['id']; ?>">Batalkan</a>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-circle text-danger"></i> Perjalanan yang tanggal keberangkatan sudah lewat
                            </div>
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
                            <div class="form-group input-group-lg">
                                <div class="row justify-content-center">
                                    <select class="selectpicker" id="kategori" name="kategori" data-style="select-with-transition" title="Pilih Kategori" data-size="7" data-width="75%" data-live-search="false" required>
                                        <option value="1">Project</option>
                                        <option value="2">Lain-lain Project</option>
                                        <option value="3">Lain-lain Non Project</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group input-group-lg">
                                <div class="row justify-content-center">
                                    <select class="selectpicker" id="copro" name="copro" data-style="select-with-transition" title="Pilih Project" data-size="7" data-width="75%" data-live-search="true" required>
                                        <?php
                                        foreach ($project as $row) {
                                            echo '<option data-subtext="' . $row->deskripsi . '" value="' . $row->copro . '">' . $row->copro . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-rose btn-round">SELANJUTNYA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
                <form id="Aktivitas" class="form" method="post" action="<?= base_url('jamkerja/addaktivitas'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">COPRO</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="copro">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">No WBS</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Milestone</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="milestone">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Aktivitas</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="aktivitas">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Lama Pengerjaan</label>
                                <div class="col-md-4">
                                    <div class="form-group has-default">
                                        <input class="form-control" type="text" id="durasi" name="durasi" number="true" range="[1,8]" required="true" />
                                    </div>
                                </div>
                                <label class="col-sm-3 label-on-right">
                                    <code>range="1-8 Jam"</code>
                                </label>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Progres Hasil</label>
                                <div class="col-md-4">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" data-size="5" data-style="btn btn-primary btn-sm btn-round" id="progres_hasil" name="progres_hasil" title="Progres (%)" required="true">
                                            <option value="100">100%</option>
                                            <option value="95">95%</option>
                                            <option value="90">90%</option>
                                            <option value="85">85%</option>
                                            <option value="80">80%</option>
                                            <option value="75">75%</option>
                                            <option value="70">70%</option>
                                            <option value="65">65%</option>
                                            <option value="60">60%</option>
                                            <option value="55">55%</option>
                                            <option value="50">50%</option>
                                            <option value="45">45%</option>
                                            <option value="40">40%</option>
                                            <option value="35">35%</option>
                                            <option value="30">30%</option>
                                            <option value="25">25%</option>
                                            <option value="20">20%</option>
                                            <option value="15">15%</option>
                                            <option value="10">10%</option>
                                            <option value="5">5%</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Deskripsi Hasil <small><i>Opsional</i></small></label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea class="form-control" id="deskripsi_hasil" name="deskripsi_hasil" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-right">
                                <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
                                <button type="submit" class="btn btn-rose btn-round">SIMPAN</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>