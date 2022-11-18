<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">weekend</i>
            </div>
            <p class="card-category">Saldo</p>
            <h3 class="card-title">Total <?=$saldo->saldo_awal; ?> hari</h3>
            <h5 class="card-title">Digunakan <?=$saldo->saldo_digunakan; ?> hari</h5>
            <h5 class="card-title">Sisa <?=$saldo->saldo; ?> hari</h5>
          </div>
          <div class="card-footer">
            <div class="stats"></div>
            <a href="<?= base_url('cuti/hr_saldo'); ?>" class="btn btn-facebook btn-block" >Kembali</a>
            <!-- data-toggle="modal" data-target="#tambahCuti" -->
          </div>
        </div>
      </div>
    </div>
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
                        </div>
                        <div class="material-datatables">
                            <table id="dt-cuti" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Pengajuan <small>Tanggal</small></th>
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
                                        <th>DARURAT</th>
                                        <th class="disabled-sorting text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($cuti as $row) :
                                    $status = $this->db->get_where('cuti_status', ['id' => $row->status])->row(); ?>
                                    <tr>
                                        <td><?= $row->id; ?></td>
                                        <td><?= date('d M Y H:i', strtotime($row->created_at)); ?></td>
                                        <td><?= $row->kategori; ?></td>
                                        <td><?= $row->npk; ?></td>
                                        <td><?= $row->nama; ?></td>
                                        <td><?= date('d M Y', strtotime($row->tgl1)); ?></td>
                                        <td><?= date('d M Y', strtotime($row->tgl2)); ?></td>
                                        <td><?= $row->lama; ?></td>
                                        <td><?= $row->keterangan; ?></td>
                                        <td><?php if ($row->acc_atasan1){
                                            echo $row->acc_atasan1.' pada '.date('d M Y H:i', strtotime($row->tgl_atasan1));
                                            }?>
                                        </td>
                                        <td><?php if ($row->acc_atasan2){
                                            echo $row->acc_atasan2.' pada '.date('d M Y H:i', strtotime($row->tgl_atasan2));
                                            }?></td>
                                        <td><?php if ($row->acc_hr){
                                            echo $row->acc_hr.' pada '.date('d M Y H:i', strtotime($row->tgl_hr));
                                            }?></td>
                                        <td><?php if ($row->darurat==1){
                                            echo 'DARURAT';
                                        }else{
                                            echo 'NORMAL';
                                        }?></td>
                                        <td><?= $status->nama; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Pengajuan <small>Tanggal</small></th>
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
                                        <th>DARURAT</th>
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