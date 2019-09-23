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
                        <h4 class="card-title">WBS Project</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dtakwbs" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No WBS</th>
                                        <th>Milestone</th>
                                        <th>Aktivitas</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Man Power</th>
                                        <th>Progres</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($wbs as $wbs) : ?>
                                        <tr>
                                            <td><?= $wbs['id']; ?></td>
                                            <td><?= $wbs['milestone']; ?></td>
                                            <td><?= $wbs['aktivitas']; ?></td>
                                            <td><?= date('d/m/Y', strtotime($wbs['tglmulai_wbs'])); ?></td>
                                            <td><?= date('d/m/Y', strtotime($wbs['tglselesai_wbs'])); ?></td>
                                            <td><?= $wbs['manpower']; ?></td>
                                            <td><?= $wbs['progres']; ?></td>
                                            <td>
                                                <?php if ($wbs['status'] == 1) { ?>
                                                    <a href="#" class="badge badge-pill badge-info disabled">FINISH</a>
                                                <?php } elseif ($wbs['status'] == 0 and $wbs['tglselesai_wbs'] < date('Y-m-d')) { ?>
                                                    <a href="#" class="badge badge-pill badge-danger disabled">LATE</a>
                                                <?php } elseif ($wbs['status'] == 0 and $wbs['tglselesai_wbs'] == date('Y-m-d')) { ?>
                                                    <a href="#" class="badge badge-pill badge-warning disabled">LAST MINUTE</a>
                                                <?php } else if ($wbs['status'] == 0 and $wbs['tglselesai_wbs'] > date('Y-m-d')) { ?>
                                                    <a href="#" class="badge badge-pill badge-success disabled">ON TRACK</a>
                                                <?php }; ?>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#aktivitasModal" data-copro="<?= $wbs['copro']; ?>" data-id="<?= $wbs['id']; ?>" data-milestone="<?= $wbs['milestone']; ?>" data-aktivitas="<?= $wbs['aktivitas']; ?>">PILIH</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No WBS</th>
                                        <th>Milestone</th>
                                        <th>Aktivitas</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Man Power</th>
                                        <th>Progres</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- end card-body-->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <i>WBS yang sedang on going pada hari ini.</i>
                            </div>
                        </div>
                    </div>
                    <!-- end card-footer-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end content -->
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