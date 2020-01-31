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
                            <table id="dtproject" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Project</th>
                                        <th rowspan="2">Amount</th>
                                        <th rowspan="2">Delivery Date</th>
                                        <th rowspan="2">Stats</th>
                                        <th colspan="9" style="text-align: center;">MAN HOUR</th>
                                        <th colspan="7" style="text-align: center;">MATERIAL</th>
                                        <th rowspan="2">Perjalanan</th>
                                        <!-- <th rowspan="2">Actions</th> -->
                                    </tr> 
                                    <tr>
                                        <th>Budget</th>
                                        <th>Actual</th>
                                        <th>%</th>
                                        <th>Remains</th>
                                        <th>%</th>
                                        <th>MH</th>
                                        <th>%</th>
                                        <th>OT</th>
                                        <th>%</th>
                                        <th>Budget</th>
                                        <th>Actual</th>
                                        <th>%</th>
                                        <th>Remains</th>
                                        <th>%</th>
                                        <th>Estimasi</th>
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
                            
                                        $this->db->select_sum('est_total');
                                        $this->db->where('copro', $p['copro']);
                                        $est = $this->db->get('project_material');
                                        $mt_est = $est->row()->est_total;
                            
                                        $this->db->select_sum('act_total');
                                        $this->db->where('copro', $p['copro']);
                                        $act = $this->db->get('project_material');
                                        $mt_act = $act->row()->act_total;

                                        $mt_remains = $p['mt_budget'] - $mt_act;

                                        $this->db->where('copro', $p['copro']);
                                        $this->db->from('perjalanan');
                                
                                        $dl_total = $this->db->get()->num_rows();
                                        
                                        ?>
                                        <tr>
                                            <td><?= $p['deskripsi']; ?><small> (<?= $p['copro']; ?>) </small></td>
                                            <td><?= number_format($p['cost_amount'],0,',','.')?></td>
                                            <td><?= $p['delivery_date']; ?></td>
                                            <td><?= $p['status']; ?></td>
                                            <td><?= intval($p['mh_budget']); ?></td>
                                            <td><?= $mh_total; ?></td>
                                            <td><h6><?= intval($mh_total / $mh_budget* 100).'%'; ?></h6></td>
                                            <?php if ($mh_remains>0){
                                                echo '<td class="text-success">'.$mh_remains.'</td>';
                                                echo '<td class="text-success"><h6>'.intval($mh_remains / $mh_budget* 100).'%</h6></td>';
                                            }else{
                                                echo '<td class="text-danger">'.$mh_remains.'<i class="material-icons">arrow_drop_down</i></td>';
                                                echo '<td class="text-danger"><h6>'.intval($mh_remains / $mh_budget* 100).'%</h6></td>';
                                            } ?>
                                            <td><?= $mh_wh; ?></td>
                                            <td><h6><?= intval($mh_wh / $mh_budget* 100).'%'; ?></h6></td>
                                            <td><?= $mh_ot; ?></td>
                                            <td><h6><?= intval($mh_ot / $mh_budget* 100).'%'; ?></h6></td>
                                            <td class="td-name"><?= number_format($p['mt_budget'],0,',','.')?></td>
                                            <td><?= number_format($mt_act,0,',','.')?></td>
                                            <td><h6><?= intval($mt_act / $mt_budget* 100).'%'; ?></h6></td>
                                            <?php if ($mt_remains>0){
                                                echo '<td class="text-success">'.number_format($mt_remains,0,',','.').'</td>';
                                                echo '<td class="text-success"><h6>'.intval($mt_remains / $mt_budget* 100).'%</h6></td>';
                                            }else{
                                                echo '<td class="text-danger">'.number_format($mt_remains,0,',','.').'<i class="material-icons">arrow_drop_down</i></td>';
                                                echo '<td class="text-danger"><h6>'.intval($mt_remains / $mt_budget* 100).'%</h6></td>';
                                            } ?>
                                            <td><?= number_format($mt_est,0,',','.')?></td>
                                            <td><h6><?= intval($mt_est / $mt_budget* 100).'%'; ?></h6></td>
                                            <td><?= $dl_total; ?></td>
                                            <!-- <td></td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Project</th>
                                        <th>Amount</th>
                                        <th>Delivery Date</th>
                                        <th>Stats</th>
                                        <th>Budget</th>
                                        <th>Actual</th>
                                        <th>%</th>
                                        <th>Remains</th>
                                        <th>%</th>
                                        <th>MH</th>
                                        <th>%</th>
                                        <th>OT</th>
                                        <th>%</th>
                                        <th>Budget</th>
                                        <th>Actual</th>
                                        <th>%</th>
                                        <th>Remains</th>
                                        <th>%</th>
                                        <th>Estimasi</th>
                                        <th>%</th>
                                        <th>Perjalanan</th>
                                        <!-- <th>Actions</th> -->
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
                { "width": "25%", "targets": 0 }
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