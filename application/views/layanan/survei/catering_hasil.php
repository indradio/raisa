<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <?php

          //Hitung total audien
          $this->db->from('survei_catering');
          $total_sum = $this->db->get()->num_rows();

          //Hitung total audien
          $this->db->where('rekomendasi', 'DILANJUTKAN');
          $this->db->from('survei_catering');
          $total_ya = $this->db->get()->num_rows();
          $avg_ya = ($total_ya / $total_sum) * 100;

          $total_tidak = $total_sum - $total_ya;
          $avg_tidak = ($total_tidak / $total_sum) * 100;

          //Hitung total nilai
          $this->db->select('SUM(p1) as total_p1');
          $this->db->from('survei_catering');
          $total_p1 = $this->db->get()->row()->total_p1;
          $avg_p1 = $total_p1 / $total_sum;
          
          $this->db->select('SUM(p2) as total_p2');
          $this->db->from('survei_catering');
          $total_p2 = $this->db->get()->row()->total_p2;
          $avg_p2 = $total_p2 / $total_sum;

          $this->db->select('SUM(p3) as total_p3');
          $this->db->from('survei_catering');
          $total_p3 = $this->db->get()->row()->total_p3;
          $avg_p3 = $total_p3 / $total_sum;

          $this->db->select('SUM(p4) as total_p4');
          $this->db->from('survei_catering');
          $total_p4 = $this->db->get()->row()->total_p4;
          $avg_p4 = $total_p4 / $total_sum;

          $this->db->select('SUM(p5) as total_p5');
          $this->db->from('survei_catering');
          $total_p5 = $this->db->get()->row()->total_p5;
          $avg_p5 = $total_p5 / $total_sum;

          $this->db->select('SUM(p6) as total_p6');
          $this->db->from('survei_catering');
          $total_p6 = $this->db->get()->row()->total_p6;
          $avg_p6 = $total_p6 / $total_sum;

          $this->db->select('SUM(p7) as total_p7');
          $this->db->from('survei_catering');
          $total_p7 = $this->db->get()->row()->total_p7;
          $avg_p7 = $total_p7 / $total_sum;

          $this->db->select('SUM(p8) as total_p8');
          $this->db->from('survei_catering');
          $total_p8 = $this->db->get()->row()->total_p8;
          $avg_p8 = $total_p8 / $total_sum;

          $this->db->select('SUM(p9) as total_p9');
          $this->db->from('survei_catering');
          $total_p9 = $this->db->get()->row()->total_p9;
          $avg_p9 = $total_p9 / $total_sum;

        ?>
    <div class="row">
                          <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                              <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">thumb_up</i>
                                </div>
                                <p class="card-category">LANJUTKAN 10 PERIODE</p>
                                <h3 class="card-title"><?= $avg_ya.' ('.$avg_ya.'%)'; ?></h3>
                              </div>
                              <div class="card-footer">
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                              <div class="card-header card-header-rose card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">thumb_down</i>
                                </div>
                                <p class="card-category">GANTI AJA</p>
                                <h3 class="card-title"><?= $total_tidak.' ('.$avg_tidak.'%)'; ?></h3>
                              </div>
                              <div class="card-footer">
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
                        <h4 class="card-title">Survei Catering</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar text-right mb-2">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dt" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Variasi menu makanan</td>
                                            <td><?= $avg_p1; ?>/5</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Rasa makanan</td>
                                            <td><?= $avg_p2; ?>/5</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Kebersiahan penyajian</td>
                                            <td><?= $avg_p3; ?>/5</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Kebersihan area makan/kantin</td>
                                            <td><?= $avg_p4; ?>/5</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Kebersihan area pencucian piring</td>
                                            <td><?= $avg_p5; ?>/5</td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Sopan santun pelayanan</td>
                                            <td><?= $avg_p6; ?>/5</td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>Cepat tanggap menerima keluhan</td>
                                            <td><?= $avg_p7; ?>/5</td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>Kebersihan & kerapihan juru layan</td>
                                            <td><?= $avg_p8; ?>/5</td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>Pembuangan limbah bekas makanan</td>
                                            <td><?= $avg_p9; ?>/5</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
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
                        <div class="toolbar text-right mb-2">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dtcatering" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>p1</th>
                                        <th>p2</th>
                                        <th>p3</th>
                                        <th>p4</th>
                                        <th>p5</th>
                                        <th>p6</th>
                                        <th>p7</th>
                                        <th>p8</th>
                                        <th>p9</th>
                                        <th>komentar</th>
                                        <th>Rekomendasi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>p1</th>
                                        <th>p2</th>
                                        <th>p3</th>
                                        <th>p4</th>
                                        <th>p5</th>
                                        <th>p6</th>
                                        <th>p7</th>
                                        <th>p8</th>
                                        <th>p9</th>
                                        <th>komentar</th>
                                        <th>Rekomendasi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#dtcatering').DataTable({
            "pagingType": "full_numbers",
            scrollX: true,
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
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
            serverSide: false,
            processing: true,
            ajax: {
                    "url"   : "<?= site_url('survei/hasil/get_catering') ?>",
                    "type"  : "POST",
                    "data"  : {}
                },
            columns: [
                { "data": "nama" },
                { "data": "p1" },
                { "data": "p2" },
                { "data": "p3" },
                { "data": "p4" },
                { "data": "p5" },
                { "data": "p6" },
                { "data": "p7" },
                { "data": "p8" },
                { "data": "p9" },
                { "data": "komentar" },
                { "data": "rekomendasi" }
            ],
        });
    });
</script>