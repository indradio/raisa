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
                        <h4 class="card-title">Daftar Project SE</h4>
                    </div>
                    <div class="card-body">
                       <a href="#" id="tambah_copro" class="btn btn-info" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahCopro">Tambah Project</a>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>COPRO</th>
                                        <th>Deskripsi</th>
                                        <th>Progres</th>
                                        <th>Due Date</th>
                                        <th>Date PO</th>
                                        <th>Amount</th>
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
                                        <td><?= $p['due_receive']; ?></td>
                                        <td><?= number_format($p['cost_amount'],0,',','.') ?></td>
                                        <td></td>
                                        <td><?= $p['status']; ?></td>
                                        <td>
                                            <a href="<?= base_url('projectbudget/budget/') . $p['copro']; ?>" class="btn btn-sm btn-success">Project Budget</a>
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
                                        <th>Date PO</th>
                                        <th>Amount</th>
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
<div class="modal fade" id="tambahCopro" tabindex="-1" role="dialog" aria-labelledby="projectModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-success text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Tambah Project</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('Project/tambahproject'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control " id="copro" name="copro" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Deskripsi</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control " id="deskripsi" name="deskripsi" required>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Customer ID</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                    <select class="selectpicker" id="inisial" name="inisial" data-style="select-with-transition" data-size="7"required>
                                      <option value='0'>--pilih--</option>
                                      <?php 
                                      foreach ($customer as $c) {
                                      echo "<option value='$c[inisial]'>$c[inisial]</option>";
                                    } ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Status</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        
                                        <select class="form-control" name="status">
                                            <option>OPEN</option>
                                            <option>TECO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">PO Recive</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="date" class="form-control " id="due_recive" name="due_receive" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Due Date</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="date" class="form-control" id="due_date" name="due_date">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">MH ENG</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control " id="jam" name="jameng" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">MH MCH</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control " id="jam" name="jammch" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Cost Amount</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" id="cost" name="cost">
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