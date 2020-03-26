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
                        <h4 class="card-title">Daftar Project</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dtproject" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Project____________________________</th>
                                        <th rowspan="2">Delivery_</th>
                                        <th rowspan="2">Amount</th>
                                        <th colspan="9" style="text-align: center;">MAN HOUR</th>
                                        <th colspan="9" style="text-align: center;">MATERIAL</th>
                                        <th rowspan="2">DL</th>
                                        <th rowspan="2">Stats</th>
                                        <!-- <th rowspan="2">Actions</th> -->
                                    </tr> 
                                    <tr>
                                        <th>Budget</th>
                                        <th>EAC</th>
                                        <th>%</th>
                                        <th>RMNs</th>
                                        <th>%</th>
                                        <th>MH</th>
                                        <th>%</th>
                                        <th>OT</th>
                                        <th>%</th>
                                        <th>Budget</th>
                                        <th>EAC</th>
                                        <th>%</th>
                                        <th>RMNs</th>
                                        <th>%</th>
                                        <th>PP</th>
                                        <th>%</th>
                                        <th>PO</th>
                                        <th>%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($project as $p) : 
                                    
                                        if (!empty($p['mh_budget'])){
                                            $mh_budget = $p['mh_budget'];
                                        }else{
                                            $mh_budget = 1;
                                        }
                            
                                        if (!empty($p['mt_budget'])){
                                            $mt_budget = $p['mt_budget'];
                                        }else{
                                            $mt_budget = 1;
                                        }

                                        // date_default_timezone_set('asia/jakarta');
                                        // $now = time();
                                        // $delivery = strtotime(date('Y-m-d', strtotime($p['delivery_date'])));
                                        // $delivery = $delivery - $now ;
                                        // $delivery_remains = floor($delivery / (60 * 60 * 24));
                            
                                        $this->db->select_sum('durasi');
                                        $this->db->where('copro', $p['copro']);
                                        $this->db->where('status', '9'); 
                                        $mh = $this->db->get('aktivitas');
                                        $mh_total = $mh->row()->durasi;
                                      
                                        $mh_remains = $p['mh_budget'] - $mh_total;
                            
                                        $this->db->select_sum('durasi');
                                        $this->db->where('copro', $p['copro']);
                                        $this->db->where('jenis_aktivitas', 'JAM KERJA');
                                        $this->db->where('status', '9');
                                        $wh = $this->db->get('aktivitas');
                                        $mh_wh = $wh->row()->durasi;
                            
                                        $this->db->select_sum('durasi');
                                        $this->db->where('copro', $p['copro']);
                                        $this->db->where('jenis_aktivitas', 'LEMBUR');
                                        $this->db->where('status', '9');
                                        $ot = $this->db->get('aktivitas');
                                        $mh_ot = $ot->row()->durasi;
                            
                                        $this->db->select_sum('est_cost');
                                        $this->db->where('copro', $p['copro']);
                                        $this->db->where('act_cost', 0);
                                        $est = $this->db->get('project_material_detail');
                                        $mt_est = $est->row()->est_cost;
                            
                                        $this->db->select_sum('act_cost');
                                        $this->db->where('copro', $p['copro']);
                                        $this->db->where('act_cost >', 0);
                                        $act = $this->db->get('project_material_detail');
                                        $mt_act = $act->row()->act_cost;

                                        $mt_total = $mt_est + $mt_act;

                                        $mt_remains = $p['mt_budget'] - $mt_total;

                                        $this->db->where('copro', $p['copro']);
                                        $this->db->from('perjalanan');
                                
                                        $dl_total = $this->db->get()->num_rows();
                                        
                                        ?>
                                        <?php if ($p['status']=='OPEN'){ ?>
                                            <tr>
                                        <?php }else{ ?>
                                            <tr class="text-muted">
                                        <?php } ?>
                                            <td><?= substr($p['deskripsi'],0,25); ?><small> (<?= $p['copro']; ?>) </small></td>
                                            <td class="text-center"><?= date('d M y', strtotime($p['delivery_date'])); ?></td>
                                            <td class="text-center"><?= number_format(substr($p['cost_amount'],0,-6),0,',','.')?></td>
                                            <td class="text-center"><?= intval($p['mh_budget']); ?></td>
                                            <td class="text-center"><?= number_format((float)$mh_total, 1, ',', '');?></td>
                                            <?php if ($mh_total!=0){
                                            echo '<td class="text-center">'.intval($mh_total / $mh_budget* 100).'%</td>';
                                            }else{
                                            echo '<td class="text-center">0%</td>';
                                            } ?>
                                            <?php if ($mh_remains>0){
                                                echo '<td class="text-success text-center">'.$mh_remains.'</td>';
                                                echo '<td class="text-success text-center">'.intval($mh_remains / $mh_budget* 100).'%</td>';
                                            }elseif ($mh_remains<0){
                                                echo '<td class="text-danger text-center">'.$mh_remains.'<i class="material-icons">arrow_drop_down</i></td>';
                                                echo '<td class="text-danger text-center">'.intval($mh_remains / $mh_budget* 100).'%</td>';
                                            }elseif ($mh_remains==0){
                                                echo '<td class="text-danger text-center">0<i class="material-icons">arrow_drop_down</i></td>';
                                                echo '<td class="text-danger text-center">0%</td>';
                                            } ?>
                                            <td class="text-center"><?= number_format((float)$mh_wh, 1, ',', '');?></td>
                                            <?php if ($mh_wh!=0){
                                            echo '<td class="text-center">'.intval($mh_wh / $mh_budget* 100).'%</td>';
                                            }else{
                                            echo '<td class="text-center">0%</td>';
                                            } ?>
                                            <!-- <td class="text-center"><?= intval($mh_wh / $mh_budget* 100).'%'; ?></td> -->
                                            <td class="text-center"><?= number_format((float)$mh_ot, 1, ',', '');?></td>
                                            <?php if ($mh_ot!=0){
                                            echo '<td class="text-center">'.intval($mh_ot / $mh_budget* 100).'%</td>';
                                            }else{
                                            echo '<td class="text-center">0%</td>';
                                            } ?>
                                            <!-- <td class="text-center"><?= intval($mh_ot / $mh_budget* 100).'%'; ?></td> -->
                                            <td class="text-center"><?= substr(number_format($p['mt_budget'],0,',','.'),0,-8)?></td>
                                            <td class="text-center"><?= substr(number_format($mt_total,0,',','.'),0,-8)?></td>
                                            <td class="text-center"><?= intval($mt_total / $mt_budget* 100).'%'; ?></td>
                                            <?php if ($mt_remains>0){
                                                echo '<td class="text-success text-center">'.substr(number_format($mt_remains,0,',','.'),0,-8).'</td>';
                                                echo '<td class="text-success text-center">'.intval($mt_remains / $mt_budget* 100).'%</td>';
                                            }else{
                                                echo '<td class="text-danger text-center">'.substr(number_format($mt_remains,0,',','.'),0,-8).'<i class="material-icons">arrow_drop_down</i></td>';
                                                echo '<td class="text-danger text-center">'.intval($mt_remains / $mt_budget* 100).'%</td>';
                                            } ?>
                                            <td class="text-center"><?= substr(number_format($mt_est,0,',','.'),0,-8)?></td>
                                            <td class="text-center"><?= intval($mt_est / $mt_budget* 100).'%'; ?></td>
                                            <td class="text-center"><?= substr(number_format($mt_act,0,',','.'),0,-8)?></td>
                                            <td class="text-center"><?= intval($mt_act / $mt_budget* 100).'%'; ?></td>
                                            <td class="text-center"><?= $dl_total; ?></td>
                                            <td class="text-center"><?= $p['status']; ?></td>
                                            <!-- <td></td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Project</th>
                                        <th>Delivery</th>
                                        <th>Amount</th>
                                        <th>Budget</th>
                                        <th>Eac</th>
                                        <th>%</th>
                                        <th>Rmns</th>
                                        <th>%</th>
                                        <th>MH</th>
                                        <th>%</th>
                                        <th>OT</th>
                                        <th>%</th>
                                        <th>Budget</th>
                                        <th>Eac</th>
                                        <th>%</th>
                                        <th>Rmns</th>
                                        <th>%</th>
                                        <th>PP</th>
                                        <th>%</th>
                                        <th>PO</th>
                                        <th>%</th>
                                        <th>DL</th>
                                        <th>Stats</th>
                                        <!-- <th>Actions</th> -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer">
                        <!-- <div class="row"> -->
                            <p><b> Keterangan : </b>
                            </br> - EAC (Estimate at Completion) : Actual + Forecast
                            </br> - Rmns (Remains MH) : Budget - EAC
                            </br> - Rmns (Remains Material) : Budget - EAC
                            </br> - PP : Forecast PP, Belum PO
                            </br> - PO : PP yang sudah PO
                            </br> - DL (Trip) : Jumlah perjalanan Dinas Luar
                        <!-- </div> -->
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
                <form class="form" method="post" action="<?= base_url('project/wbs'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">COPRO</label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="copro">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Status</label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="status">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Deskripsi</label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                    <textarea rows="3" class="form-control disabled" name="deskripsi"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success btn-round">WBS</button>
                            </div> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //dtproject
        var tableproject = $('#dtproject').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "language": {
                "decimal": ",",
                "thousands": "."
            },
            "columnDefs": [
                { "width": "15%", "targets": [0] }
            ],
            scrollX: true,
        });

        $('#dtproject tbody').on('click', 'button', function() {
            var data = tableproject.row($(this).parents('tr')).data();
            $('#projectModal').on('show.bs.modal', function() {
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-body input[name="copro"]').val(data[1])
                modal.find('.modal-body input[name="status"]').val(data[2])
                modal.find('.modal-body textarea[name="deskripsi"]').val(data[3])
            })
            $('#projectModal').modal("show");
        });
    });
</script>