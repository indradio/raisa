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
                        <h4 class="card-title">Laporan Perjalanan Dinas (Kendaraan)</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="dtreportkr" class="table table-striped table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Kendaraan</th>
                                        <th>Perjalanan</th>
                                        <th>Total Kilometer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $queryKendaraan = "SELECT *
                                                    FROM `kendaraan`
                                                    WHERE `id` != '1' AND `id` != '2' AND `id` != '3' AND `id` != '4'
                                                    ORDER BY `id` DESC";
                                $kendaraan = $this->db->query($queryKendaraan)->result_array();
                                foreach ($kendaraan as $k) : 
                                    $this->db->where('nopol', $k['nopol']);
                                    $this->db->where('year(tglberangkat)',$tahun);
                                    $this->db->where('month(tglberangkat)',$bulan);
                                    $this->db->where('status','9');
                                    $queryTrip = $this->db->get('perjalanan');
                                
                                    $this->db->select_sum('kmtotal');
                                    $this->db->where('nopol', $k['nopol']);
                                    $this->db->where('year(tglberangkat)',$tahun);
                                    $this->db->where('month(tglberangkat)',$bulan);
                                    $this->db->where('status','9');
                                    $queryKm = $this->db->get('perjalanan');
                                    $kmtotal = $queryKm->row()->kmtotal;
                                    if ($kmtotal != 0){
                                ?>
                                    <tr>
                                        <td class="td-name"><?= $k['nopol']; ?></td>
                                        <td><?= $queryTrip->num_rows(); ?></td>
                                        <td><?= $kmtotal; ?></td>
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
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->