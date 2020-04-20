<div class="content">
    <?php date_default_timezone_set('asia/jakarta'); ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assessment</i>
                        </div>
                        <h4 class="card-title">Laporan Man Hour</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('lembur/laporan/depthead'); ?>" method="post">
                        <!-- <div class="row">
                                <label class="col-md-2 col-form-label">Laporan Berdasarkan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="laporan" id="laporan" data-style="select-with-transition" title="Pilih Laporan" data-size="7">
                                            <option value="1">List per tiap laporan</option>
                                            <option value="2">Karyawan</option>
                                            <option value="5">COPRO</option>
                                            <option value="3">Pelembur</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
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
            <div class="col-md-12 ml-auto mr-auto">
              <div class="page-categories">
                <h3 class="title text-center">Pilih Laporan</h3>
                <br />
                <ul class="nav nav-pills nav-pills-primary nav-pills-icons justify-content-center" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#link7" role="tablist">
                      <i class="material-icons">person</i> Karyawan
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#link8" role="tablist">
                      <i class="material-icons">insert_chart_outlined</i> COPRO
                    </a>
                  </li>
                  <!-- <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#link9" role="tablist">
                      <i class="material-icons">gavel</i> Legal Info
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#link10" role="tablist">
                      <i class="material-icons">help_outline</i> Help Center
                    </a>
                  </li> -->
                </ul>
                <div class="tab-content tab-space tab-subcategories">
                  <div class="tab-pane" id="link7">
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
                            <table id="dt-report1" class="table table-striped table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Nama</th>
                                        <th colspan="3" style="text-align: center;">MAN HOUR</th>
                                        <th rowspan="2">TUL</th>
                                        <th colspan="3"style="text-align: center;">AKTIVITAS</th>
                                    </tr> 
                                    <tr>
                                        <th>TOTAL</th>
                                        <th>JAM KERJA <small>(JAM)</small></th>
                                        <th>LEMBUR <small>(JAM)</small></th>
                                        <th>TOTAL</th>
                                        <th>JAM KERJA</th>
                                        <th>LEMBUR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $kry = $this->db->get_where('karyawan', ['status' => 1])->result_array();
                                foreach ($kry as $k) : 
                                
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
                  <div class="tab-pane active" id="link8">
                  <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                    <div class="card-text">
                            <h4 class="card-title">Laporan MH</h4>
                            <p class="card-category">Berdasarkan COPRO periode <?= date('F Y', strtotime("$tahun-$bulan-01")); ?></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dt-report2" class="table table-striped table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Copro</th>
                                        <th>Nama Projek</th>
                                        <th>Customer</th>
                                        <th>MH Budget<small>(JAM)</small></th>
                                        <th>MH Aktual<small>(JAM)</small></th>
                                        <th>MH Sisa<small>(JAM)</small></th>
                                        <th>MH JAMKERJA <small>(JAM)</small></th>
                                        <th>MH LEMBUR <small>(JAM)</small></th>
                                        <th>Aktivitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $this->db->distinct();
                                $this->db->select('copro');
                                $this->db->where('year(tgl_aktivitas)',$tahun);
                                $this->db->where('month(tgl_aktivitas)',$bulan);
                                $this->db->where('month(tgl_aktivitas)',$bulan);
                                $this->db->where('status >', '1');
                                $aktivitas_copro = $this->db->get('aktivitas')->result_array();
                                foreach ($aktivitas_copro as $k) : 
                                
                                    $this->db->where('copro', $k['copro']);
                                    $this->db->where('year(tgl_aktivitas)',$tahun);
                                    $this->db->where('month(tgl_aktivitas)',$bulan);
                                    $this->db->where('status >', '1');
                                    $total_copro = $this->db->get('aktivitas');

                                    $this->db->select_sum('durasi');
                                    $this->db->where('copro', $k['copro']);
                                    $this->db->where('year(tgl_aktivitas)',$tahun);
                                    $this->db->where('month(tgl_aktivitas)',$bulan);
                                    $this->db->where('jenis_aktivitas', 'LEMBUR'); 
                                    $this->db->where('status >', '1'); 
                                    $durasi_lembur = $this->db->get('aktivitas');
                                    $total_durasi_lembur = $durasi_lembur->row()->durasi;

                                    $this->db->select_sum('durasi');
                                    $this->db->where('copro', $k['copro']);
                                    $this->db->where('year(tgl_aktivitas)',$tahun);
                                    $this->db->where('month(tgl_aktivitas)',$bulan);
                                    $this->db->where('jenis_aktivitas', 'JAM KERJA'); 
                                    $this->db->where('status >', '1'); 
                                    $durasi_jamkerja = $this->db->get('aktivitas');
                                    $total_durasi_jamkerja = $durasi_jamkerja->row()->durasi;

                                    $total_durasi = $total_durasi_jamkerja + $total_durasi_lembur;

                                    if ($k['copro']){ 
                                        $projek = $this->db->get_where('project', ['copro' => $k['copro']])->row_array();?>
                                    <tr>
                                     <td class="td-name"><?= $k['copro']; ?></td>
                                        <td><?= $projek['deskripsi']; ?></td>
                                        <td><?= substr($projek['deskripsi'], 0,3); ?></td>
                                        <td class="td-name"></td>
                                        <td class="td-name"><?= $total_durasi; ?></td>
                                        <td class="td-name"></td>
                                        <td><?= $total_durasi_jamkerja; ?></td>
                                        <td><?= $total_durasi_lembur; ?></td>
                                        <td><?= $total_copro->num_rows(); ?></td>
                                    </tr>
                                <?php 
                                };
                                endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
                  </div>
                  <div class="tab-pane" id="link9">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Legal info of the product</h4>
                        <p class="card-category">
                          More information here
                        </p>
                      </div>
                      <div class="card-body">
                        Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                        <br>
                        <br>Dynamically innovate resource-leveling customer service for state of the art customer service.
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="link10">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Help center</h4>
                        <p class="card-category">
                          More information here
                        </p>
                      </div>
                      <div class="card-body">
                        From the seamless transition of glass and metal to the streamlined profile, every detail was carefully considered to enhance your experience. So while its display is larger, the phone feels just right.
                        <br>
                        <br> Another Text. The first thing you notice when you hold the phone is how great it feels in your hand. The cover glass curves down around the sides to meet the anodized aluminum enclosure in a remarkable, simplified design.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dt-report1').DataTable({
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
    $('#dt-report2').DataTable({
        "pagingType": "full_numbers",
        order: [
            [4, 'desc']
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });
} );
</script>