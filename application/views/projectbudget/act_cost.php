

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
                        <h4 class="card-title"><?php echo $project['deskripsi'];?></h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <!-- <a href="#" id="tambah_copro" class="btn btn-info" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahCopro">Tambah Project Budget</a> -->
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>

                                    <tr>
                                        <th rowspan="2">Part</th>
                                        <th rowspan="2">Budget</th>
                                        <th colspan="6" style="text-align: center;">Actual Cost</th> 
                                    </tr> 
                                    <tr>
                                        <td>PP</td>
                                        <td>Exprod</td> 
                                        <td>Total</td>
                                        <td>%</td>
                                        <td>Selisih</td>
                                        <td>%</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($material as $p) : 
                                        if ($p['budget']==0){
                                            if ($p['act_total']==0){
                                                $totalpersen = 0;
                                                $selisihpersen = 0;
                                            }else{
                                                $totalpersen = 100;
                                                $selisihpersen = -100;
                                            }
                                        }else{
                                            if ($p['act_total']!=0){
                                                $totalpersen = ($p['act_total']/$p['budget'])*100;
                                                $selisihpersen = 100-$totalpersen;
                                            }else{
                                                $totalpersen = 0;
                                                $selisihpersen = 100;
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td><?= $p['part']; ?></td>
                                        <td><?= number_format($p['budget'],0,',','.')?></td>
                                        <td><?= number_format($p['act_cost'],0,',','.')?></td>
                                        <td><?= number_format($p['act_exprod'],0,',','.')?></td>
                                        <td><?= number_format($p['act_total'],0,',','.')?></td>
                                        <td><?= $totalpersen; ?>%</td>
                                        <?php if($p['act_selisih']<0 ){?>
                                            <td class="text-danger"><?= number_format($p['act_selisih'],0,',','.')?></td>
                                        <?php } else { ?>
                                            <td><?= number_format($p['act_selisih'],0,',','.')?></td>
                                        <?php }; ?>
                                        <td><?= $selisihpersen; ?>%</td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Part</td>
                                        <td>Budget</td>
                                        <td>PP</td>
                                        <td>Exprod</td> 
                                        <td>Total</td>
                                        <td>%</td>
                                        <td>Selisih</td>
                                        <td>%</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- end card-body-->
                </div>
                <!--  end card  -->
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Details Cost</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                        </div>
                        <div class="material-datatables">
                            <table id="dt-cost" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
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
                                    $projectMt = $this->db->where('copro', $p['copro']);
                                    $projectMt = $this->db->get_where('project_material', ['part' => $p['part']])->row_array();
                                    ?>
                                    <tr>
                                        <td><?= $p['part']; ?></td>
                                        <td><?= $p['kategori']; ?></td>
                                        <td><?= $p['no']; ?></td>
                                        <td><?= number_format($p['est_cost'],0,',','.') ?></td>
                                        <td><?= number_format($p['act_cost'],0,',','.') ?></td>
                                        <td><?= number_format($remains,0,',','.') ?></td>
                                        <td><?= $p['keterangan']; ?></td>
                                        <td>
                                             <a href="javascript:;" 
                                                data-id="<?php echo $p['id'] ?>"
                                                data-copro="<?php echo $p['copro'] ?>"
                                                data-project="<?php echo $project['deskripsi'] ?>"
                                                data-budget="<?php echo $projectMt['budget'] ?>"
                                                data-kategori="<?php echo $p['kategori'] ?>"
                                                data-part="<?php echo $p['part'] ?>"
                                                data-est_cost="<?php echo $p['est_cost'] ?>"
                                                data-act_cost="<?php echo $p['act_cost'] ?>"
                                                data-keterangan="<?php echo $p['keterangan'] ?>"
                                                class="btn btn-sm btn-round btn-success" data-toggle="modal" data-target="#actCost">Actual Cost</a>
                                        </td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
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
                            </br>
                            <a href="<?= base_url('project/project/pch'); ?>" class="btn btn-reddit">BACK</a>
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
                        <h4 class="card-title">Project Actual Cost</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('Projectbudget/estimasicost'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Project</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="hidden" class="form-control disabled" id="id" name="id" required >
                                        <input type="text" class="form-control disabled" id="copro" name="copro" required >
                                        <input type="text" class="form-control disabled" id="desk" name="desk" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Part</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="part" name="part" required>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Budget</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="hidden" class="form-control disabled" id="budget" name="budget">
                                        <input type="text" class="form-control disabled" id="budget_sh" name="budget_sh">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Remains</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="sisa" name="sisa" >
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Kategori</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" data-style="select-with-transition" name="kategori" id="kategori" title="Pilih Kategori" required>
                                            <option value="PP">PP</option>
                                            <option value="EXPROD">Exprod</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">No. PP/Exprod</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" id="no" name="no" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Est Cost</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" id="cost" name="cost" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Note</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
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
<div class="modal fade" id="actCost" tabindex="-1" role="dialog" aria-labelledby="actCostTitle" aria-hidden="true">
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
                                        <input type="hidden" class="form-control disabled" id="id" name="id" required>
                                        <input type="hidden" class="form-control disabled" id="budget" name="budget" required>
                                        <input type="text" class="form-control disabled" id="copro" name="copro" required>
                                        <input type="text" class="form-control disabled" id="project" name="project" required>
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
                            <div class="row">
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
                                <label class="col-md-3 col-form-label">Note</label>
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
            sisa = (div.data('budget') - div.data('total'));
            modal.find('#id').attr("value",div.data('id'));
            modal.find('#copro').attr("value",div.data('copro'));
            modal.find('#desk').attr("value",div.data('desk'));
            modal.find('#part').attr("value",div.data('part'));
            modal.find('#budget').attr("value",div.data('budget'));
            modal.find('#budget_sh').attr("value",div.data('budget_sh'));
            modal.find('#cost').attr("value",div.data('cost'));
            modal.find('#exprod').attr("value",div.data('exprod'));
            modal.find('#total').attr("value",div.data('total'));
            modal.find('#sisa').attr("value",div.data('selisih'));
            modal.find('#selisihpersen').attr("value",div.data('selisihpersen'));
        });
    // $('.biaya').mask("000,000,000,000,000", {reverse: true});
    $('#actCost').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
            modal.find('#id').attr("value",div.data('id'));
            modal.find('#copro').attr("value",div.data('copro'));
            modal.find('#project').attr("value",div.data('project'));
            modal.find('#budget').attr("value",div.data('budget'));
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
    });
});
                

           
</script>