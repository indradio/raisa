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
                                        <th>Dept</th>
                                        <th>Status</th>
                                        <th>Ganti PIC</th>
                                        <th>Ganti Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($asset as $row) : 
                                        $opnamed = $this->db->get_where('asset_opnamed', ['id' => $row['id']])->row_array();
                                        if (empty($opnamed)){    
                                    ?>
                                        <tr class="table-danger">
                                            <td>
                                                <?= $row['asset_no']; ?>
                                            </td>
                                            <td>
                                                <?= $row['asset_sub_no']; ?>
                                            </td>
                                            <td class="td-name">
                                                <?= $row['asset_description']; ?>
                                            </td>
                                            <td>
                                                <?= $row['kategori']; ?>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td><?= $row['npk']; ?></td>
                                            <?php $pic = $this->db->get_where('karyawan', ['npk' => $row['npk']])->row_array(); ?>
                                            <td><?= $pic['nama']; ?></td>
                                            <td></td>
                                            <td><?= $row['lokasi']; ?></td>
                                            <td><?= $row['first_acq']; ?></td>
                                            <td><?= $row['value_acq']; ?></td>
                                            <td><?= $row['cost_center']; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>BELUM DIOPNAME</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php }else{ 
                                        $status = $this->db->get_where('asset_status', ['id' => $opnamed['status']])->row_array();
                                            ?>
                                        <tr>
                                            
                                            <td>
                                                <?= $row['asset_no']; ?>
                                            </td>
                                            <td>
                                                <?= $row['asset_sub_no']; ?>
                                            </td>
                                            <td class="td-name">
                                                <?= $row['asset_description']; ?>
                                            </td>
                                            <td>
                                                <?= $row['kategori']; ?>
                                            </td>
                                            <td><?= $row['npk']; ?></td>
                                            <?php $pic = $this->db->get_where('karyawan', ['npk' => $row['npk']])->row_array(); ?>
                                            <td><?= $pic['nama']; ?></td>
                                            <td><?= $opnamed['npk']; ?></td>
                                            <?php $ex_pic = $this->db->get_where('karyawan', ['npk' => $opnamed['npk']])->row_array(); ?>
                                            <td><?= $ex_pic['nama']; ?></td>
                                            <td><?= $opnamed['lokasi']; ?></td>
                                            <td><?= $row['lokasi']; ?></td>
                                            <td><?= $row['first_acq']; ?></td>
                                            <td><?= $row['value_acq']; ?></td>
                                            <td><?= $row['cost_center']; ?></td>
                                            <td><?= $opnamed['catatan']; ?></td>
                                            <td><?= date('d M Y', strtotime($opnamed['opnamed_at'])).' Oleh '.$opnamed['opnamed_by']; ?></td>
                                            <td><?= date('d M Y', strtotime($opnamed['verify_at'])).' Oleh '.$opnamed['verify_by']; ?></td>
                                            <?php $dept = $this->db->get_where('karyawan_dept', ['id' => $opnamed['dept_id']])->row_array(); ?>
                                            <td><?= $dept['nama']; ?></td>
                                            <td><?= $status['name']; ?></td>
                                            <td><?= $opnamed['change_pic']; ?></td>
                                            <td><?= $opnamed['change_lokasi']; ?></td>
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
                                        <th>Dept</th>
                                        <th>Status</th>
                                        <th>Ganti PIC</th>
                                        <th>Ganti Lokasi</th>
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