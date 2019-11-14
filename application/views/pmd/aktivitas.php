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
                        <h4 class="card-title">Daftar Project</h4>
                    </div>
                        <form class="form" method="post" action="<?= base_url('lembur/ajukan_rencana'); ?>">
                        <div class="card-body">
                            <div class="row" hidden>
                                <label class="col-md-5 col-form-label">Copro</label>
                                <div class="col-md-7">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="copro" name="copro" value="<?= $project['copro']; ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="#" id="tambah_aktifvitas" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#projectModal" data-copro="<?= $project['copro']; ?>">Tambah Aktivitas</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Aktivitas</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($aktivitas as $a) : ?>
                                    <tr>
                                        <td><?= $a['id']; ?></td>
                                        <td><?= $a['aktivitas']; ?></td>
                                        <td>
                                            <a href="<?= base_url('pmd/hapus_aktivitas/') . $a['id']; ?>" class="btn btn-sm btn-round btn-danger">Hapus</a>
                                        </td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Aktivitas</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                                <a href="<?= base_url('pmd/project/') ?>" class="btn btn-sm btn-default" role="button">KEMBALI</a>
                        </div>
                    </div>
                    <!-- end card-body-->
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
<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-success text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Project</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('pmd/tmbahAkt'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="copro" value="<?= $project['copro']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Aktivitas</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea rows="3" class="form-control" id="aktivitas" name="aktivitas" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Due Date</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control datetimepicker" id="duedate" name="duedate">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Status</label>
                                <div class="col-md-4">
                                    <div class="form-group has-default">
                                       <select class="selectpicker" name="status" id="status" data-style="select-with-transition" title="Pilih" data-size="4" required>
                                        <?php foreach ($project_status as $ps) : ?>
                                            <option value="<?= $ps['id']; ?>"><?= $ps['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success btn-round">SIMPAN</button>
                                <br>
                                <button type="button" class="btn btn-default btn-round" data-dismiss="modal">TUTUP</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>