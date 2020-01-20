<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
    <!-- Start - Card summary kendaraan -->
    <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">update</i>
                        </div>
                        <h4 class="card-title">Laporan MH</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('lembur/laporan'); ?>" method="post">
                        <div class="row">
                                <label class="col-md-2 col-form-label">Laporan Berdasarkan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="laporan" id="laporan" data-style="select-with-transition" title="Pilih Laporan" data-size="7" required>
                                            <option value="1">List per tiap laporan</option>
                                            <option value="2">Karyawan</option>
                                            <option value="5">COPRO</option>
                                            <!-- <option value="3">Pelembur</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                                <label class="col-md-2 col-form-label">Tahun</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="tahun" id="tahun" data-style="select-with-transition" title="Pilih Tahun" data-size="7" required>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                                <label class="col-md-2 col-form-label">Bulan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="bulan" id="bulan" data-style="select-with-transition" title="Pilih Bulan" data-size="7" required>
                                            <option value="01">Januari</option>
                                            <option value="02">Febuari</option>
                                            <option value="03">Maret</option>
                                            <option value="04">April</option>
                                            <option value="05">Mei</option>
                                            <option value="06">Juni</option>
                                            <option value="07">Juli</option>
                                            <option value="08">Agustus</option>
                                            <option value="09">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <button type="submit" class="btn btn-fill btn-success">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Laporan MH</h4>
                            <p class="card-category">Berdasarkan Karyawan periode <?= date('F Y', strtotime("$tahun-$bulan-01")); ?></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dt-report" class="table table-striped table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Karyawan</th>
                                        <th>Man Hour <small>(JAM)</small></th>
                                        <th>MH Jam Kerja <small>(JAM)</small></th>
                                        <th>MH Durasi <small>(JAM)</small></th>
                                        <th>TUL</th>
                                        <th>Aktivitas</th>
                                        <th>Aktivitas Jam Kerja</th>
                                        <th>Aktivitas Lembur</th>
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
                                    $total_jamkerja = $this->db->get('jamkerja');

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

                                    ?>
                                    <tr>
                                        <td class="td-name"><?= $k['nama']; ?></td>
                                        <td class="td-name"><?= ($total_jamkerja->num_rows() * 8)+$total_durasi; ?></td>
                                        <td><?= $total_jamkerja->num_rows() * 8; ?></td>
                                        <td><?= $total_durasi; ?></td>
                                        <td><?= $total_tul; ?></td>
                                        <td><?= $total_jamkerja->num_rows()+$total_lembur->num_rows(); ?></td>
                                        <td><?= $total_jamkerja->num_rows(); ?></td>
                                        <td><?= $total_lembur->num_rows(); ?></td>
                                    </tr>
                                <?php 
                                endforeach; ?>
                                </tbody>
                            </table>
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

<script>
$(document).ready(function() {
    $('#dt-report').DataTable({
        "pagingType": "full_numbers",
        order: [
            [1, 'desc']
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });
} );
</script>