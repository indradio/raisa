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
                            <form class="form-horizontal" action="<?= base_url('cuti/report'); ?>" method="post">
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
                    <select class="selectpicker" name="bulan" id="bulan" data-style="select-with-transition" title="Pilih Bulan" data-size="7" onchange='this.form.submit()' required>
                      <option value="01"<?php echo ($bulan == '01') ? 'selected' : ''; ?>>Januari</option>
                      <option value="02"<?php echo ($bulan == '02') ? 'selected' : ''; ?>>Februari</option>
                      <option value="03"<?php echo ($bulan == '03') ? 'selected' : ''; ?>>Maret</option>
                      <option value="04"<?php echo ($bulan == '04') ? 'selected' : ''; ?>>April</option>
                      <option value="05"<?php echo ($bulan == '05') ? 'selected' : ''; ?>>Mei</option>
                      <option value="06"<?php echo ($bulan == '06') ? 'selected' : ''; ?>>Juni</option>
                      <option value="07"<?php echo ($bulan == '07') ? 'selected' : ''; ?>>Juli</option>
                      <option value="08"<?php echo ($bulan == '08') ? 'selected' : ''; ?>>Agustus</option>
                      <option value="09"<?php echo ($bulan == '09') ? 'selected' : ''; ?>>September</option>
                      <option value="10"<?php echo ($bulan == '10') ? 'selected' : ''; ?>>Oktober</option>
                      <option value="11"<?php echo ($bulan == '11') ? 'selected' : ''; ?>>November</option>
                      <option value="12"<?php echo ($bulan == '12') ? 'selected' : ''; ?>>Desember</option>
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
                                <tfoot>
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
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
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