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
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="#" id="tambah_copro" class="btn btn-info" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahCopro">Tambah Project Budget</a>
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
                                        <td>Rp <?= number_format($p['budget'],0,',','.') ?></td>
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
                                            <a href="javascript:;" 
                                                    data-id="<?php echo $p['id'] ?>"
                                                    data-part="<?php echo $p['part'] ?>"
                                                    data-copro="<?php echo $p['copro'] ?>"
                                                    data-cost="<?php echo $p['est_cost'] ?>"
                                                    data-exprod="<?php echo $p['est_exprod'] ?>"
                                                    data-part="<?php echo $p['part'] ?>"
                                                    data-budget="<?php echo $p['budget'] ?>"
                                                    data-total="<?php echo $p['est_total'] ?>"
                                                    data-selisih="<?php echo $p['est_selisih'] ?>"
                                            class="btn btn-sm btn-info" data-toggle="modal" data-target="#projectModal" >Edit</a>
                                            
                                            <a href="/raisa/projectbudget/hapus_project/<?= $p['copro'];?>/<?= $p['id'];?>" class="btn btn-sm btn-danger">HAPUS</a>
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
                <form class="form" method="post" action="<?= base_url('Projectbudget/ubahProjectbudget'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Budget</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="hidden" class="form-control disabled" id="id" name="id" required >
                                        <input type="number" class="form-control " id="budget" name="budget" required >
                                        <input type="hidden" class="form-control " id="copro" name="copro" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">PART</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                       <input type="text" class="form-control disabled" name="part2" id="part2">
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">PP</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control disabled" id="pp" name="pp">
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">EXPROD</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control disabled" id="exprod" name="exprod">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Total</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control disabled" id="total" name="total" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Selisih</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control disabled" id="selisih" name="selisih" required>
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
                        <h4 class="card-title">Project Budget</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('projectbudget/tmbhbudget'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" hidden>
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" rows="3" class="form-control" id="copro" name="copro" value="<?= $project['copro']; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Part</label>
                                <div class="col-md-4">
                                    <div class="form-group has-default">
                                       <select class="selectpicker" id="part" name="part" data-style="select-with-transition" data-size="7"required>
                                            <?php    
                                            foreach ($query as $s) :
                                             
                                                    echo '<option value="' . $s['nama'] . '"';
                                                    echo '>' . $s['nama'] . '</option>' . "\n";
                                             
                                                
                                            endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Budget</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" rows="3" class="form-control" id="budget" name="budget" required>
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
<script type="text/javascript">
 $(document).ready(function() {
    $('#projectModal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal          = $(this)

            modal.find('#id').attr("value",div.data('id'));
            modal.find('#copro').attr("value",div.data('copro'));
            modal.find('#budget').attr("value",div.data('budget'));
            modal.find('#part2').attr("value",div.data('part'));
            modal.find('#pp').attr("value",div.data('cost'));
            modal.find('#exprod').attr("value",div.data('exprod'));
            modal.find('#total').attr("value",div.data('total'));
            modal.find('#selisih').attr("value",div.data('selisih'));
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