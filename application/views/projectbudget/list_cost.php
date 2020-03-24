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
                        <h4 class="card-title">List Estimations Cost</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                        </div>
                        <div class="material-datatables">
                            <table id="dt-cost" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Copro</th> 
                                        <th>Part</th> 
                                        <th>Kategori</th> 
                                        <th>No PP/BPB</th> 
                                        <th>Estimate <small><i>(ENG)</i></small></th> 
                                        <th>Actual <small><i>(PCH)</i></small></th> 
                                        <th>Remains</th> 
                                        <th>Keterangan</th> 
                                        <th>Actions</th> 
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($projectcost as $p) : 
                                    $remains = $p['est_cost'] - $p['act_cost']; 
                                    $project = $this->db->get_where('project', ['copro' => $p['copro']])->row_array();
                                    ?>
                                    <tr>
                                        <td><?= $p['copro']; ?></td>
                                        <td><?= $p['part']; ?></td>
                                        <td><?= $p['kategori']; ?></td>
                                        <td><?= $p['no']; ?></td>
                                        <td><?= number_format($p['est_cost'],0,',','.') ?></td>
                                        <td><?= number_format($p['act_cost'],0,',','.') ?></td>
                                        <td><?= number_format($remains,0,',','.') ?></td>
                                        <td><?= $p['keterangan']; ?></td>
                                        <td>
                                            <a href="<?= base_url('project/act/'.$p['copro']); ?>" class="btn btn-sm btn-round btn-warning">GO TO PROJECT</a>
                                        </td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Copro</th> 
                                        <th>Part</th> 
                                        <th>Kategori</th> 
                                        <th>No PP/BPB</th> 
                                        <th>Estimate</th> 
                                        <th>Actual</th> 
                                        <th>Remains</th> 
                                        <th>Keterangan</th> 
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
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Project Actual Cost</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('projectbudget/actualcost'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="hidden" class="form-control disabled" id="id" name="id" required >
                                        <input type="text" class="form-control disabled" id="copro" name="copro" required >
                                        <input type="text" class="form-control disabled" id="project" name="project" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Part</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled " id="part" name="part" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Kategori</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="kategori" name="kategori" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Calculation Cost</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="est_cost" name="est_cost" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Actual Cost</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" id="act_cost" name="act_cost">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Keterangan </label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                       <textarea id="keterangan " name="keterangan" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-right">
                                <button type="button" class="btn btn-link" data-dismiss="modal">Close</a>
                                <button type="submit" class="btn btn-success btn-round">Submit</button>
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
    $('#projectModal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
            modal.find('#id').attr("value",div.data('id'));
            modal.find('#copro').attr("value",div.data('copro'));
            modal.find('#project').attr("value",div.data('project'));
            modal.find('#kategori').attr("value",div.data('kategori'));
            modal.find('#part').attr("value",div.data('part'));
            modal.find('#est_cost').attr("value",div.data('est_cost'));
            modal.find('#act_cost').attr("value",div.data('act_cost'));
            modal.find('#budget').attr("value",div.data('budget'));
            modal.find('textarea#keterangan').val(div.data('keterangan'));
        });

        $('#dt-cost').DataTable( {
      order: [[0, 'asc']],
        rowGroup: {
            dataSrc: 0
        },
        "scrollY": "512px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging":false
    } );
});
</script>