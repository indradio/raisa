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
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="#" id="tambah_copro" class="btn btn-info" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahCopro">Tambah Copro</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>COPRO</th>
                                        <th>Deskripsi</th>
                                        <th>Progres</th>
                                        <th>Due Date</th>
                                        <th>Status Project</th>
                                        <th>Status COPRO</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($project as $p) : ?>
                                    <tr>
                                        <td><?= $p['copro']; ?></td>
                                        <td><?= $p['deskripsi']; ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><?= $p['status']; ?></td>
                                        <td>
                                            <a href="<?= base_url('project/wbs/') . $p['copro']; ?>" class="btn btn-sm btn-success">AKTIVITAS</a>
                                            <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#projectModal" data-copro="<?= $p['copro']; ?>" data-deskripsi="<?= $p['deskripsi']; ?>" data-status="<?= $p['status']; ?>">UBAH</a>
                                            <a href="<?= base_url('pmd/hapus_project/') . $p['copro']; ?>" class="btn btn-sm btn-danger btn-sm btn-bataldl">HAPUS</a>
                                        </td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>COPRO</th>
                                        <th>Deskripsi</th>
                                        <th>Progres</th>
                                        <th>Due Date</th>
                                        <th>Status Project</th>
                                        <th>Status COPRO</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
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
<!-- Modal Tambah Karyawan -->
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
                <form class="form" method="post" action="<?= base_url('pmd/ubahProject'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="copro" name="copro" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-3 col-form-label">No Material</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" id="no_material" name="no_material">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Deskripsi</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea rows="3" class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Status</label>
                                <div class="col-md-4">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" id="status" name="status" data-style="select-with-transition" data-size="7"required>
                                        <?php
                                        $status = $this->db->get('project_status')->result_array();
                                        foreach ($status as $s) :
                                            echo '<option value="' . $s['nama'] . '"';
                                            if ($s['nama'] == $p['status']) {
                                                echo 'selected';
                                            }
                                            echo '>' . $s['nama'] . '</option>' . "\n";
                                        endforeach; ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success btn-round">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahCopro" tabindex="-1" role="dialog" aria-labelledby="tambahCoproTitle" aria-hidden="true">
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
                <form class="form" method="post" action="<?= base_url('pmd/tmbahCopro'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="copro" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Deskripsi</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea rows="3" class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
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
                                       <select class="selectpicker" id="status" name="status" data-style="select-with-transition" data-size="7"required>
                                            <?php
                                            $status = $this->db->get('project_status')->result_array();
                                            foreach ($status as $s) :
                                                echo '<option value="' . $s['nama'] . '"';
                                                if ($s['nama'] == $p['status']) {
                                                    echo 'selected';
                                                }
                                                echo '>' . $s['nama'] . '</option>' . "\n";
                                            endforeach; ?>
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