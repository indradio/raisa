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
                                        <td><?= number_format($p['budget'],0,',','.')?></td>
                                        <td><?= number_format($p['est_cost'],0,',','.') ?></td>
                                        <td><?= number_format($p['est_exprod'],0,',','.') ?></td>
                                        <td><?= number_format($p['est_total'],0,',','.') ?></td>
                                        <td><?= $p['est_persen']; ?>%</td>
                                        <td><?= number_format($p['est_selisih'],0,',','.') ?></td>
                                        <td><?= $p['est_selisihpersen']; ?>%</td>
                                        <td><?= number_format($p['act_cost'],0,',','.') ?></td>
                                        <td><?= number_format($p['act_exprod'],0,',','.') ?></td>
                                        <td><?= number_format($p['act_total'],0,',','.') ?></td>
                                        <td><?= $p['act_persen']; ?>%</td>
                                        <td><?= number_format($p['act_selisih'],0,',','.') ?></td>
                                        <td><?= $p['act_selisihpersen']; ?>%</td>
                                        <td>
                                           

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
                        </div><a href="<?= base_url('projectbudget/'); ?>"  class="btn btn-sm ">back</a>
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
