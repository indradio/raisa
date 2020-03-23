<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title"><?php echo $project['deskripsi'];?> <small>(<?php echo $project['copro'];?>)</small></h4>
                    </div>
                    <div class="card-body">
                        <div class="row col-md-12">
                            <label class="col-md-2 col-form-label">COPRO</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="copro" name="copro" value="<?= $project['copro']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <label class="col-md-2 col-form-label">PO Receive</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datepicker disabled" id="po_date" name="po_date" value="<?= date("d-m-Y", strtotime($project['po_date'])); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <label class="col-md-2 col-form-label">Delivery Date <i>(Estimation)</i></label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datepicker disabled" id="delivery_date" name="delivery_date" value="<?= date("d-m-Y", strtotime($project['delivery_date'])); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <label class="col-md-2 col-form-label">Amount</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="cost_amount" name="cost_amount" value="<?= number_format($project['cost_amount'],0,',','.'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <label class="col-md-2 col-form-label">Material</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="material" name="material" value="<?= number_format($project['mt_budget'],0,',','.'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <label class="col-md-2 col-form-label">Man Hour</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="manhour" name="manhour" value="<?= $project['mh_budget']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <a href="javascript:;" 
                                    data-copro="<?php echo $project['copro'] ?>"
                                    data-po="<?php echo date("d-m-Y", strtotime($project['po_date'])) ?>"
                                    data-delivery="<?php echo date("d-m-Y", strtotime($project['delivery_date'])) ?>"
                                    data-amount="<?php echo $project['cost_amount'] ?>"
                                    class="btn btn-warning btn-round" data-toggle="modal" data-target="#projectModal">UPDATE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-md-12 -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title"><?php echo $project['deskripsi'];?> <small>(<?php echo $project['copro'];?>)</small></h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="dt-material" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <td>Part</td>
                                        <td>Budget <small>(Rp)</small></td> 
                                        <td>Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($material as $p) : ?>
                                    <tr>
                                        <td><?= $p['part']; ?></td>
                                        <td><?= number_format($p['budget'],0,',','.') ?></td>
                                        <td>
                                            <?php if ($p['budget']<1){ ?>
                                                <a href="javascript:;" 
                                                    data-id="<?php echo $p['id'] ?>"
                                                    data-part="<?php echo $p['part'] ?>"
                                                    data-copro="<?php echo $p['copro'] ?>"
                                                    data-budget="<?php echo $p['budget'] ?>"
                                                    class="btn btn-sm btn-success btn-round" data-toggle="modal" data-target="#updateBudget">ADD BUDGET</a>
                                            <?php }else{ ?>
                                                <a href="javascript:;" 
                                                    data-id="<?php echo $p['id'] ?>"
                                                    data-part="<?php echo $p['part'] ?>"
                                                    data-copro="<?php echo $p['copro'] ?>"
                                                    data-budget="<?php echo $p['budget'] ?>"
                                                    class="btn btn-sm btn-warning btn-round" data-toggle="modal" data-target="#updateBudget">UPDATE</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Part</td>
                                        <td>Budget</td>
                                        <td>Actions</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </br>
                        <a href="<?= base_url('project/project/se'); ?>" class="btn btn-reddit">BACK</a>
                    </div>
                    <!-- end card-body-->
                </div>
                    <!-- end card-->
            </div>
            <!-- end col-md-12 -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title"><?php echo $project['deskripsi'];?> <small>(<?php echo $project['copro'];?>)</small></h4>
                    </div>
                    <div class="card-body">
                    <div class="toolbar"><a href="javascript:;" data-copro="<?php echo $project['copro'] ?>" class="btn btn-facebook btn-round" data-toggle="modal" data-target="#addManhour">ADD BUDGET</a></div>
                        <div class="material-datatables">
                            <table id="dt-manhour" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <td>Part</td>
                                        <td>Budget <small>(Hour)</small></td> 
                                        <td>Dept</td> 
                                        <td>Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($manhour as $q) : ?>
                                    <tr>
                                        <td><?= $q['part']; ?></td>
                                        <td><?= $q['budget']; ?></td>
                                        <?php $dept = $this->db->get_where('karyawan_dept', ['id' => $q['dept_id']])->row_array(); ?>
                                        <td> <?= $dept['nama']; ?></td>
                                        <td>
                                                <a href="javascript:;" 
                                                    data-id="<?php echo $q['id'] ?>"
                                                    data-part="<?php echo $q['part'] ?>"
                                                    data-copro="<?php echo $q['copro'] ?>"
                                                    data-budget="<?php echo $q['budget'] ?>"
                                                    class="btn btn-sm btn-warning btn-round" data-toggle="modal" data-target="#updateManhour">UPDATE</a>
                                                <a href="javascript:;" 
                                                    data-id="<?php echo $q['id'] ?>"
                                                    data-part="<?php echo $q['part'] ?>"
                                                    data-copro="<?php echo $q['copro'] ?>"
                                                    class="btn btn-sm btn-danger btn-round" data-toggle="modal" data-target="#delManhour">DELETE</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Part</td>
                                        <td>Budget</td>
                                        <td>Dept</td> 
                                        <td>Actions</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </br>
                        <a href="<?= base_url('project/project/se'); ?>" class="btn btn-reddit">BACK</a>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end content -->
<!-- Modal Update Budget -->
<div class="modal fade" id="updateBudget" tabindex="-1" role="dialog" aria-labelledby="updateBudgetTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">PROJECT BUDGET</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('Projectbudget/updatebudget'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="hidden" class="form-control" id="id" name="id" required >
                            <input type="hidden" class="form-control" id="copro" name="copro" required >
                            <div class="row">
                                <label class="col-md-3 col-form-label">Part</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                       <input type="text" class="form-control disabled" name="part" id="part">
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Budget</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" id="budget" name="budget" required >
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-right">
                                <button type="submit" class="btn btn-success btn-round">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update Budget MH -->
<div class="modal fade" id="addManhour" tabindex="-1" role="dialog" aria-labelledby="addManhourTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">PROJECT BUDGET</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('Projectbudget/addmanhour'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="hidden" class="form-control" id="id" name="id" required>
                            <input type="hidden" class="form-control" id="copro" name="copro" required>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Part</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" id="part" name="part" style="text-transform: uppercase" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Budget</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" id="budget" name="budget" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Dept</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="dept_id" id="dept_id" data-style="select-with-transition" title="Pilih" data-size="2" data-width="fit" required>
                                            <option value="11">ENGINEERING</option>
                                            <option value="13">MACHINERY</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-right">
                                <button type="submit" class="btn btn-success btn-round">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update Budget MH -->
<div class="modal fade" id="updateManhour" tabindex="-1" role="dialog" aria-labelledby="updateManhourTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">PROJECT BUDGET</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('Projectbudget/updatemanhour'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="hidden" class="form-control" id="id" name="id" required >
                            <input type="hidden" class="form-control" id="copro" name="copro" required >
                            <div class="row">
                                <label class="col-md-3 col-form-label">Part</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                       <input type="text" class="form-control disabled" name="part" id="part">
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Budget</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" id="budget" name="budget" required >
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-right">
                                <button type="submit" class="btn btn-success btn-round">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update Budget -->
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
                <form class="form" method="post" action="<?= base_url('project/updateProjectSE'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="hidden" class="form-control" id="copro" name="copro" required >
                            <div class="row" >
                                <label class="col-md-3 col-form-label">PO Receive</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control datepicker" id="po_date" name="po_date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Delivery</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control datepicker" id="delivery_date" name="delivery_date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Amount</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" id="cost_amount" name="cost_amount" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-right">
                                <button type="submit" class="btn btn-success btn-round">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delManhour" tabindex="-1" role="dialog" aria-labelledby="delManhourLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delManhourLabel">Are you sure?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" action="<?= base_url('projectbudget/delmanhour'); ?>">
      <div class="modal-body">
        <div class="form-group" hidden="true">
            <label for="id">id</label>
            <input type="text" class="form-control" id="id" name="id">
            <input type="text" class="form-control" id="copro" name="copro" required>
            <input type="text" class="form-control" id="part" name="part" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
        <button type="submit" class="btn btn-danger">YEAH, DELETE!</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
 $(document).ready(function() {
    $('#updateBudget').on('show.bs.modal', function (event) {
        var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
        var modal = $(this)
        modal.find('#id').attr("value",div.data('id'));
        modal.find('#copro').attr("value",div.data('copro'));
        modal.find('#budget').attr("value",div.data('budget'));
        modal.find('#part').attr("value",div.data('part'));
    });

    $('#addManhour').on('show.bs.modal', function (event) {
        var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
        var modal = $(this)
        modal.find('#id').attr("value",div.data('id'));
        modal.find('#copro').attr("value",div.data('copro'));
    });

    $('#updateManhour').on('show.bs.modal', function (event) {
        var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
        var modal = $(this)
        modal.find('#id').attr("value",div.data('id'));
        modal.find('#copro').attr("value",div.data('copro'));
        modal.find('#budget').attr("value",div.data('budget'));
        modal.find('#part').attr("value",div.data('part'));
    });

    $('#delManhour').on('show.bs.modal', function (event) {
        var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
        var modal = $(this)
        modal.find('#id').attr("value",div.data('id'));
        modal.find('#copro').attr("value",div.data('copro'));
        modal.find('#part').attr("value",div.data('part'));
    });

    $('#projectModal').on('show.bs.modal', function (event) {
        var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
        var modal = $(this)
        modal.find('#copro').attr("value",div.data('copro'));
        modal.find('#po_date').attr("value",div.data('po'));
        modal.find('#delivery_date').attr("value",div.data('delivery'));
        modal.find('#cost_amount').attr("value",div.data('amount'));
    });

    $('#dt-material').DataTable( {
        "scrollY": "512px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false
    } );

    $('#dt-manhour').DataTable( {
        "scrollY": "512px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false
    } );
    
});
</script>

<script>
    $(document).ready(function() {
     
      // Initialise Sweet Alert library
      demo.showSwal();
    });
  </script>