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
                                        <th>Customer</th>
                                        <th>Deskripsi</th>
                                        <th>Amount</th>
                                        <th>Budget</th>
                                        <th>Estimasi</th>
                                        <th>Aktual</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($project as $p) : ?>
                                    <tr>
                                        <td><?= $p['copro']; ?></td>
                                        <td><?= $p['customer_inisial']; ?></td>
                                        <td><?= $p['deskripsi']; ?></td>
                                        <td><?= number_format($p['cost_amount'],0,',','.') ?></td>
                                        <td><?= number_format($p['mt_budget'],0,',','.') ?></td>
                                        <td><?= number_format($p['cost_amount'],0,',','.') ?></td>
                                        <td></td>
                                        <td><?= $p['status']; ?></td>
                                        <td>
                                            <a href="<?= base_url('projectbudget/budget/') . $p['copro']; ?>" class="btn btn-sm btn-success">Project Budget</a>
                                            <a href="javascript:;" 
                                                    data-copro="<?php echo $p['copro'] ?>"
                                                    data-desk="<?php echo $p['deskripsi'] ?>"
                                                    data-receive="<?php echo $p['po_receive'] ?>"
                                                    data-duedate="<?php echo $p['due_date'] ?>"
                                                    data-total="<?php echo $p['mh_budget'] ?>"
                                            class="btn btn-sm btn-info" data-toggle="modal" data-target="#update" >Update Data Project</a>
                                        </td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>COPRO</th>
                                        <th>Customer</th>
                                        <th>Deskripsi</th>
                                        <th>Amount</th>
                                        <th>Budget</th>
                                        <th>Estimasi</th>
                                        <th>Aktual</th>
                                        <th>Status</th>
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
                                        <input type="date" class="form-control " id="due_recive" name="po_receive" required>
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
                                <label class="col-md-3 col-form-label">MH TOTAL</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control " id="jam" name="jam" required>
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

<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="projectModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-success text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Update Project</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('Project/updateproject'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="copro" name="copro"  >
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
                            <div class="row">
                                <label class="col-md-3 col-form-label">PO DATE</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="date" class="form-control " id="po_date" name="po_date" required>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">DUE DATE</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="date" class="form-control " id="due_date" name="due_date" required>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">MH Total</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control " id="mh_total" name="mh_total" required>
                                       
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

<script type="text/javascript">
 $(document).ready(function() {
    $('#update').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal          = $(this)
            sisa = (div.data('budget') - div.data('total'));
            modal.find('#copro').attr("value",div.data('copro'));
            modal.find('#deskripsi').attr("value",div.data('desk'));
            modal.find('#po_date').attr("value",div.data('receive'));
            modal.find('#due_date').attr("value",div.data('duedate'));
            modal.find('#mh_total').attr("value",div.data('total'));
        });
    $('.biaya').mask("000,000,000,000,000", {reverse: true});

    
});
                

           
</script>