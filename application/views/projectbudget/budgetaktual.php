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
                        <h4 class="card-title"><?php echo $project['deskripsi'];?></h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Copro</th> 
                                        <th rowspan="2">Part</th>
                                        <th rowspan="2">Budget</th>
                                        <th colspan="6" style="text-align: center;">Estimasi Cost</th>
                                        <th colspan="6"style="text-align: center;">Actual Cost</th>
                                        <th rowspan="2" style="text-align: center;">Action</th>
                                    </tr> 
                                    <tr>
                                        <td>PP</td>
                                        <td>Exprod</td> 
                                        <td>Total</td>
                                        <td>%</td>
                                        <td>Selisih</td>
                                        <td>%</td>
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
                                    foreach ($Projectbudget as $p) : ?>
                                    <tr>
                                        <td><?= $p['copro']; ?></td>
                                        <td><?= $p['part']; ?></td>
                                        <td>Rp <?= number_format($p['budget'],0,',','.')?></td>
                                        <td>Rp <?= number_format($p['est_cost'],0,',','.') ?></td>
                                        <td>Rp <?= number_format($p['est_exprod'],0,',','.') ?></td>
                                        <td>Rp <?= number_format($p['est_total'],0,',','.') ?></td>
                                        <td><?= $p['est_persen']; ?>%</td>
                                        <td>Rp <?= number_format($p['est_selisih'],0,',','.') ?></td>
                                        <td><?= $p['est_selisihpersen']; ?>%</td>
                                        <td>Rp <?= number_format($p['act_cost'],0,',','.') ?></td>
                                        <td>Rp <?= number_format($p['act_exprod'],0,',','.') ?></td>
                                        <td>Rp <?= number_format($p['act_total'],0,',','.') ?></td>
                                        <td><?= $p['act_persen']; ?>%</td>
                                        <td>Rp <?= number_format($p['act_selisih'],0,',','.') ?></td>
                                        <td><?= $p['act_selisihpersen']; ?>%</td>
                                        <td>
                                            <!-- $sect_id -->
                                             <!-- <a href="javascript:;" 
                                                    data-copro="<?php echo $p['copro'] ?>"
                                                    data-id="<?php echo $p['id'] ?>"
                                                    data-budget="<?php echo $p['budget'] ?>"
                                                    data-cost="<?php echo $p['act_cost'] ?>"
                                                    data-exprod="<?php echo $p['act_exprod'] ?>"
                                                    data-total="<?php echo $p['act_total'] ?>"
                                                    data-persen="<?php echo $p['act_persen'] ?>"
                                                    data-selisih="<?php echo $p['act_selisih'] ?>"
                                                    data-selisihpersen="<?php echo $p['act_selisihpersen'] ?>"
                                            class="btn btn-sm btn-info" data-toggle="modal" data-target="#projectModal" >Aktual Cost</a> -->

                                             <a href="/raisa/projectbudget/budgetpchdetail/<?= $p['copro'];?>/<?= $p['part'];?>" class="btn btn-sm btn-success">Project Budget</a>
                                        </td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th rowspan="2">Copro <br></th> 
                                        <th rowspan="2">Part</th>
                                        <th rowspan="2">Budget</th>
                                        <th colspan="6" style="text-align: center;">Estimasi Cost</th>
                                        <th colspan="6"style="text-align: center;">Actual Cost</th>
                                        <th rowspan="2" style="text-align: center;">Action <br>
                                        </th>
                                    </tr> 
                                    <tr>
                                        <td>PP</td>
                                        <td>Exprod</td> 
                                        <td>Total</td>
                                        <td>%</td>
                                        <td>Selisih</td>
                                        <td>%</td>
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
                        <h4 class="card-title">Project Budget Estimasi</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('Projectbudget/aktualcost'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Budget</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control disabled" id="budget" name="budget" required ><input type="text" class="form-control disabled" id="copro" name="copro" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">PP</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control " id="cost" name="cost" required>
                                        <input type="hidden" class="form-control disabled" id="id" name="id" required>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Exprod</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" id="exprod" name="exprod">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Total</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control " id="total" name="total" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">%</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" id="persen" name="persen">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Selisih</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control " id="selisih" name="selisih" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">%</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" id="selisihpersen" name="selisihpersen">
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
    $('#projectModal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal          = $(this)
            modal.find('#copro').attr("value",div.data('copro'));
            modal.find('#id').attr("value",div.data('id'));
            modal.find('#budget').attr("value",div.data('budget'));
            modal.find('#cost').attr("value",div.data('cost'));
            modal.find('#exprod').attr("value",div.data('exprod'));
            modal.find('#total').attr("value",div.data('total'));
            modal.find('#persen').attr("value",div.data('persen'));
            modal.find('#selisih').attr("value",div.data('selisih'));
            modal.find('#selisihpersen').attr("value",div.data('selisihpersen'));
        });
 $(document).ready(function(){
    $("#cost").on("change", function(){
    total = parseInt($("#cost").val()) + parseInt($("#exprod").val()); 
    $("#total").val(total);
    selisih = parseInt($("#budget").val()) - parseInt($("#total").val());
    $("#selisih").val(selisih);
    persen = parseInt($("#total").val()) / (parseInt($("#budget").val())/100);
    $("#persen").val(persen); 
    selisihpersen = parseInt($("#selisih").val()) / (parseInt($("#budget").val())/100);
    $("#selisihpersen").val(selisihpersen);
        });
    });
});
</script>