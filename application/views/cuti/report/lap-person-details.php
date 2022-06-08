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
                        <h4 class="card-title">Data</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <form class="form-horizontal" action="<?= base_url('cuti/hr_report_details'); ?>" method="post">
              <div class="row">
                <div class="col-sm-6 col-lg-3">
                  <div class="form-group has-default">
                    <select class="selectpicker" name="tahun" id="tahun" data-style="select-with-transition" title="Pilih tahun" data-size="3" onchange='this.form.submit()' required>
                      <?php for ($y = date('Y')-3; $y <= date('Y'); $y++) { ?>
                          <option value="<?= $y; ?>" <?php echo ($tahun == $y) ? 'selected' : ''; ?>><?= $y; ?></option>
                      <?php };?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div class="form-group has-default">
                    <select class="selectpicker" name="selectedKaryawan" id="selectedKaryawan" data-style="select-with-transition" title="Pilih Karyawan" data-size="7" data-live-search="true" onchange='this.form.submit()' required>
                    <?php 
                     $this->db->where('is_active', '1');
                     $this->db->where('status', '1');
                    $listKaryawan = $this->db->get('karyawan')->result();
                        foreach ($listKaryawan as $row) :
                            echo '<option data-subtext="'. $row->nama.'" value="'. $row->npk.'"';
                            if ($row->npk == $selectedKaryawan['npk']) {
                                echo 'selected';
                            }
                            echo '>'. $row->inisial.'</option>';
                        endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
            </form>
                        </div>
                        <div class="material-datatables">
                            <table id="dt-cuti" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kategori</th>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Dari <small>Tanggal</small></th>
                                        <th>Sampai <small>Tanggal</small></th>
                                        <th>Lama <small>Hari</small></th>
                                        <th>Keterangan</th>
                                        <th>ACC Atasan1</th>
                                        <th>ACC Atasan2</th>
                                        <th>ACC HR</th>
                                        <th class="disabled-sorting text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($cuti as $row) :
                                    $status = $this->db->get_where('cuti_status', ['id' => $row->status])->row(); ?>
                                    <tr>
                                        <td><?= $row->id; ?></td>
                                        <td><?= $row->kategori; ?></td>
                                        <td><?= $row->npk; ?></td>
                                        <td><?= $row->nama; ?></td>
                                        <td><?= date('d M Y', strtotime($row->tgl1)); ?></td>
                                        <td><?= date('d M Y', strtotime($row->tgl2)); ?></td>
                                        <td><?= $row->lama; ?></td>
                                        <td><?= $row->keterangan; ?></td>
                                        <td><?php if ($row->acc_atasan1){
                                            echo $row->acc_atasan1.' pada '.date('d M Y', strtotime($row->tgl_atasan1));
                                            }?>
                                        </td>
                                        <td><?php if ($row->acc_atasan2){
                                            echo $row->acc_atasan2.' pada '.date('d M Y', strtotime($row->tgl_atasan2));
                                            }?></td>
                                        <td><?php if ($row->acc_hr){
                                            echo $row->acc_hr.' pada '.date('d M Y', strtotime($row->tgl_hr));
                                            }?></td>
                                        <td><?= $status->nama; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <!-- <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kategori</th>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Dari <small>Tanggal</small></th>
                                        <th>Sampai <small>Tanggal</small></th>
                                        <th>Lama <small>Hari</small></th>
                                        <th>Keterangan</th>
                                        <th>ACC Atasan1</th>
                                        <th>ACC Atasan2</th>
                                        <th>ACC HR</th>
                                        <th class="text-right">Status</th>
                                    </tr>
                                </tfoot> -->
                            </table>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#dt-cuti').DataTable( {
            "pagingType": "full_numbers",
            scrollX: true,
            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'excelHtml5',
                    title: 'DATA CUTI',
                    text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i>',
                    footer: true
                },
                {extend: 'pdfHtml5',
                    title: 'Data Cuti <?=$selectedKaryawan['nama'];?>',
                    text:'<i class="fa fa-file-pdf-o" aria-hidden="true" ></i>',
                    messageTop: 'REKAP CUTI TAHUN <?= $tahun; ?>',
                    orientation: 'landscape',
                    pageSize: 'A3',
                    download: 'open',
                    footer: true
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });
    });
</script>