<div class="content">
    <?php date_default_timezone_set('asia/jakarta'); ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ml-auto mr-auto">
                  <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Laporan Lembur</h4>
                            <p class="card-category">Berdasarkan periode minggu ke-<?= $at_week .' | '.$tglawal.' s/d '.$tglakhir; ?></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form" id="formDate" method="post" action="<?= base_url('hr/laporan/lembur'); ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="select_by" class="bmd-label-floating">Select By *</label>
                                <select class="selectpicker" data-style="btn btn-link" id="select_by" name="select_by" title="Please Select..." onchange="bySelect(this);" data-size="2" data-live-search="false" required>
                                    <option value="1">by Week</option>
                                    <option value="2">by Range</option>
                                </select>
                            </div>
                            <div class="col-md-6"></div>
                            </div>
                            <div class="row" id="r_week" style="display:none;">
                                <div class="col-md-3">
                                    <label for="select_date" class="bmd-label-floating">Select Date *</label>
                                    <input type="text" class="form-control datepicker" id="select_date" name="select_date" required="true" />
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="row" id="r_range" style="display:none;">
                                <div class="col-md-3">
                                    <label for="from_date" class="bmd-label-floating">From Date *</label>
                                    <input type="text" class="form-control datepicker" id="from_date" name="from_date" required="true" />
                                </div>
                                <div class="col-md-3">
                                    <label for="to_date" class="bmd-label-floating">To Date *</label>
                                    <input type="text" class="form-control datepicker" id="to_date" name="to_date" required="true" />
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                                    <button type="submit" class="btn btn-twitter"><i class="material-icons">search</i> Search by Date</button>
                            <p>
                        </form>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dt-report" class="table table-striped table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <!-- <tr>
                                        <th rowspan="2">Nama</th>
                                        <th colspan="3" style="text-align: center;">MAN HOUR</th>
                                        <th rowspan="2">TUL</th>
                                        <th colspan="3"style="text-align: center;">AKTIVITAS</th>
                                    </tr>  -->
                                    <tr>
                                        <th>NPK</th>
                                        <th>NAMA</th>
                                        <th>LEMBUR <small>TOTAL</small></th>
                                        <th>LEMBUR <small>JAM</small></th>
                                        <th>WEEK - MONTH <small>AT</small></th>
                                        <th>RANGE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $kry = $this->db->where('status', 1);
                                $kry = $this->db->get_where('karyawan', ['is_active' => 1])->result_array();
                                foreach ($kry as $k) : 
                                    
                                    $this->db->where('npk', $k['npk']);
                                    $this->db->where('tglmulai >=',$tglawal);
                                    $this->db->where('tglmulai <=',$tglakhir);
                                    $this->db->where('status', '9');
                                    $total_lembur = $this->db->get('lembur');

                                    $this->db->select_sum('durasi');
                                    $this->db->where('npk', $k['npk']);
                                    $this->db->where('tglmulai >=',$tglawal);
                                    $this->db->where('tglmulai <=',$tglakhir);
                                    $this->db->where('status', '9');
                                    $durasi = $this->db->get('lembur');
                                    $total_durasi = $durasi->row()->durasi;
                                    
                                    if ($total_lembur->num_rows()>0){ ?>
                                    <tr>
                                        <td class="td-name"><?= $k['npk']; ?></td>
                                        <td class="td-name"><?= $k['nama']; ?></td>
                                        <td><?= $total_lembur->num_rows(); ?></td>
                                        <td><?= $total_durasi; ?></td>
                                        <td><?= $at_week.' - '.$at_month; ?></td>
                                        <td><?= date("d-m-Y", strtotime($tglawal)).' s/d '.date("d-m-Y", strtotime($tglakhir)); ?></td>
                                    </tr>
                                    <?php };
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>

<script type="text/javascript">
    function bySelect(valueSelect) {
        var val = valueSelect.options[valueSelect.selectedIndex].value;

        document.getElementById("r_week").style.display = val == '1' ? "block" : 'none';
        document.getElementById("r_range").style.display = val == '2' ? "block" : 'none';
    }
    $('#select_by').change(function() {
        var select_by = $('#select_by').val();
        if (select_by == 1) {
            $('#select_date').prop('disabled', false);
            $('#select_date').prop('required', true);
            $('#from_date').prop('disabled', true);
            $('#from_date').prop('required', false);
            $('#to_date').prop('disabled', true);
            $('#to_date').prop('required', false);
        } else if (select_by == 2) {
            $('#select_date').prop('disabled', true);
            $('#select_date').prop('required', false);
            $('#from_date').prop('disabled', false);
            $('#from_date').prop('required', true);
            $('#to_date').prop('disabled', false);
            $('#to_date').prop('required', true);
        }
    })
    $(document).ready(function() {
        $('#dt-report').DataTable({
            "pagingType": "full_numbers",
            scrollX: true,
            scrollY: '512px',
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            order: [
                [0, 'asc']
            ],
            scrollCollapse: true,
            paging: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });
    } );
</script>