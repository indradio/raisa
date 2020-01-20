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
                        <h4 class="card-title">Daftar Project </h4>
                    </div>
                    <div class="card-body">
                        
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

                                        <td> <?php if($karyawan['posisi_id']<7 AND $karyawan['dept_id']==11 ){?>
                                            <a href="<?= base_url('projectbudget/budgeteng/') . $p['copro']; ?>" class="btn btn-sm btn-success">Project Budget</a>
                                        <?php }?>
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
