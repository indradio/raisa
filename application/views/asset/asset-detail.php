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
                        <h4 class="card-title">Data Asset</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dt-asset" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sub</th>
                                        <th>Deskripsi</th>
                                        <th>Kategori</th>
                                        <th>PIC NPK (Baru)</th>
                                        <th>PIC Nama (Baru)</th>
                                        <th>PIC NPK (Lama)</th>
                                        <th>PIC NAMA (Lama)</th>
                                        <th>Lokasi (Baru)</th>
                                        <th>Lokasi (Lama)</th>
                                        <th>First Acq</th>
                                        <th>Value Acq</th>
                                        <th>Cost Center</th>
                                        <th>Catatan</th>
                                        <th class="th-description">Tgl Opname</th>
                                        <th>Verifikasi</th>
                                        <th>Disetujui</th>
                                        <th>Dept</th>
                                        <th class="disabled-sorting th-description text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($asset as $a) : 
                                        $opnamed = $this->db->get_where('asset_opnamed', ['id' => $a['id']])->row_array();
                                        if (empty($opnamed)){    
                                    ?>
                                        <tr>
                                            <td>
                                                <?= $a['asset_no']; ?>
                                            </td>
                                            <td>
                                                <?= $a['asset_sub_no']; ?>
                                            </td>
                                            <td class="td-name">
                                                <?= $a['asset_deskripsi']; ?>
                                            </td>
                                            <td>
                                                <?= $a['kategori']; ?>)
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td><?= $a['npk']; ?></td>
                                            <?php $pic = $this->db->get_where('karyawan', ['npk' => $a['npk']])->row_array(); ?>
                                            <td><?= $pic['nama']; ?></td>
                                            <td></td>
                                            <td><?= $a['lokasi']; ?></td>
                                            <td><?= $a['first_acq']; ?></td>
                                            <td><?= $a['value_acq']; ?></td>
                                            <td><?= $a['cost_center']; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-fill btn-danger disabled">BELUM </br>DIOPNAME</a>
                                            </td>
                                        </tr>
                                    <?php }else{ ?>
                                        <tr>
                                            
                                            <td>
                                                <?= $a['asset_no']; ?>
                                            </td>
                                            <td>
                                                <?= $a['asset_sub_no']; ?>
                                            </td>
                                            <td class="td-name">
                                                <?= $a['asset_deskripsi']; ?>
                                            </td>
                                            <td>
                                                <?= $a['kategori']; ?>)
                                            </td>
                                            <td><?= $opnamed['new_npk']; ?></td>
                                            <td><?= $opnamed['new_pic']; ?></td>
                                            <td><?= $opnamed['old_npk']; ?></td>
                                            <td><?= $opnamed['old_pic']; ?></td>
                                            <td><?= $opnamed['new_lokasi']; ?></td>
                                            <td><?= $opnamed['old_lokasi']; ?></td>
                                            <td><?= $a['first_acq']; ?></td>
                                            <td><?= $a['value_acq']; ?></td>
                                            <td><?= $a['cost_center']; ?></td>
                                            <td><?= $opnamed['catatan']; ?></td>
                                            <td><?= date('d M Y', strtotime($opnamed['opname_at'])); ?></td>
                                            <td><?= date('d M Y', strtotime($opnamed['verify_at'])).' Oleh '.$opnamed['verify_by']; ?></td>
                                            <td><?= date('d M Y', strtotime($opnamed['approve_at'])).' Oleh '.$opnamed['approve_by']; ?></td>
                                            <?php $dept = $this->db->get_where('karyawan_dept', ['id' => $opnamed['dept_id']])->row_array(); ?>
                                            <td><?= $dept['nama']; ?></td>
                                            <td class="text-right">
                                                <?php if ($a['status']==1){ ?>
                                                    <a href="#" class="btn btn-sm btn-fill btn-danger">BELUM </br>DIVERIFIKASI</a>
                                                <?php } elseif ($a['status']==2){ ?>
                                                    <a href="#" class="btn btn-sm btn-fill btn-warning">BELUM </br>DIAPPROVE</a>
                                                <?php } elseif ($a['status']==9){ ?>
                                                    <a href="#" class="btn btn-sm btn-fill btn-success">SUDAH </br>DIOPNAME</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                        <th>No</th>
                                        <th>Sub</th>
                                        <th>Deskripsi</th>
                                        <th>Kategori</th>
                                        <th>PIC NPK (Baru)</th>
                                        <th>PIC Nama (Baru)</th>
                                        <th>PIC NPK (Lama)</th>
                                        <th>PIC NAMA (Lama)</th>
                                        <th>Lokasi (Baru)</th>
                                        <th>Lokasi (Lama)</th>
                                        <th>First Acq</th>
                                        <th>Value Acq</th>
                                        <th>Cost Center</th>
                                        <th>Catatan</th>
                                        <th class="th-description">Tgl Opname</th>
                                        <th>Verifikasi</th>
                                        <th>Disetujui</th>
                                        <th>Dept</th>
                                        <th class="disabled-sorting th-description text-right">Actions</th>
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
        $('#dt-asset').DataTable( {
            "pagingType": "full_numbers",
            scrollX: true,
            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'excelHtml5',
                    title: 'DATA OPNAME ASSET 2020',
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