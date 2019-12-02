<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
    <!-- Start - Card summary kendaraan -->
    <div class="row">
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Laporan Lembur</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="dtreportps" class="table table-striped table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Karyawan</th>
                                        <th>Total Lembur</th>
                                        <th>Total Durasi <small>(JAM)</small></th>
                                        <th>Total TUL <small>(TUL))</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $queryKaryawan = "SELECT *
                                                    FROM `karyawan`
                                                    WHERE `status` = '1'
                                                    ORDER BY `npk` ASC";
                                $Karyawan = $this->db->query($queryKaryawan)->result_array();
                                foreach ($Karyawan as $k) : 
                                
                                    $this->db->where('npk', $k['npk']);
                                    $this->db->where('year(tglmulai)',$tahun);
                                    $this->db->where('month(tglmulai)',$bulan);
                                    $this->db->where('status', '9');
                                    $total_lembur = $this->db->get('lembur');

                                    $this->db->select_sum('durasi');
                                    $this->db->where('npk', $k['npk']);
                                    $this->db->where('year(tglmulai)',$tahun);
                                    $this->db->where('month(tglmulai)',$bulan);
                                    $this->db->where('status', '9');
                                    $durasi = $this->db->get('lembur');
                                    $total_durasi = $durasi->row()->durasi;

                                    $this->db->select_sum('tul');
                                    $this->db->where('npk', $k['npk']);
                                    $this->db->where('year(tglmulai)',$tahun);
                                    $this->db->where('month(tglmulai)',$bulan);
                                    $this->db->where('status', '9');
                                    $tul = $this->db->get('lembur');
                                    $total_tul = $tul->row()->tul;

                                    if ($total_lembur->num_rows() > 0){ ?>
                                    <tr>
                                        <td class="td-name"><?= $k['nama']; ?></td>
                                        <td><?= $total_lembur->num_rows(); ?></td>
                                        <td><?= $total_durasi; ?></td>
                                        <td><?= $total_tul; ?></td>
                                    </tr>
                                <?php 
                                };
                                endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
       <!-- End - Card summary Peserta -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->