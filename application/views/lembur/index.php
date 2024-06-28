<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row mt-3">
      <div class="col-lg-4 col-md-6 col-sm-6">
            <?php 
                $bulan = date('m');
                $tahun = date('Y');

                $this->db->where('npk', $this->session->userdata('npk'));
                $this->db->where('year(tglmulai)',$tahun);
                $this->db->where('month(tglmulai)',$bulan);
                $this->db->where('status', '9');
                $total_lembur = $this->db->get('lembur');

                $this->db->select('SUM(durasi) as total');
                $this->db->where('npk', $this->session->userdata('npk'));
                $this->db->where('year(tglmulai)',$tahun);
                $this->db->where('month(tglmulai)',$bulan);
                $this->db->where('status', '9');
                $this->db->from('lembur');
                $totalDurasi = $this->db->get()->row()->total;

                $this->db->select('SUM(tul) as total');
                $this->db->where('npk', $this->session->userdata('npk'));
                $this->db->where('year(tglmulai)',$tahun);
                $this->db->where('month(tglmulai)',$bulan);
                $this->db->where('status', '9');
                $this->db->from('lembur');
                $totalTul = $this->db->get()->row()->total;
              
            ?>
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">date_range</i>
            </div>
            <p class="card-category">Lembur bulan ini</p>
            <h3 class="card-title"><?= $total_lembur->num_rows().'x | '.$totalDurasi.' jam | '.$totalTul.' Tul'; ?></h3>
            <p class="card-category">*Ini hanya estimasi, belum diverifikasi oleh data absensi dan system SAP</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn btn-facebook btn-block" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahLembur">Rencana Lembur</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6">
            <?php 
                $bulanLalu = date('m') ;

                $this->db->where('npk', $this->session->userdata('npk'));
                $this->db->where('year(tglmulai)',$tahun);
                $this->db->where('month(tglmulai)',$bulanLalu);
                $this->db->where('status', '9');
                $totalLemburLast = $this->db->get('lembur');

                $this->db->select('SUM(durasi) as total');
                $this->db->where('npk', $this->session->userdata('npk'));
                $this->db->where('year(tglmulai)',$tahun);
                $this->db->where('month(tglmulai)',$bulanLalu);
                $this->db->where('status', '9');
                $this->db->from('lembur');
                $totalDurasiLast = $this->db->get()->row()->total;

                $this->db->select('SUM(tul) as total');
                $this->db->where('npk', $this->session->userdata('npk'));
                $this->db->where('year(tglmulai)',$tahun);
                $this->db->where('month(tglmulai)',$bulan);
                $this->db->where('status', '9');
                $this->db->from('lembur');
                $totalTulLast = $this->db->get()->row()->total;
              
            ?>
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">date_range</i>
            </div>
            <p class="card-category">Lembur bulan lalu</p>
            <h3 class="card-title"><?= $totalLemburLast->num_rows().'x | '.$totalDurasiLast.' jam | '.$totalTulLast.' Tul'; ?></h3>
            <p class="card-category">*Ini hanya estimasi, belum diverifikasi oleh data absensi dan system SAP</p>
          </div>
          <div class="card-footer">
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <!-- <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Data Lembur</h4>
          </div> -->
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="dtlembur" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Durasi</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="disabled-sorting text-right">Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Durasi</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
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
<!-- Modal Lembur Hari Lain Aktivitas-->
<div class="modal fade" id="tambahLembur" tabindex="-1" role="dialog" aria-labelledby="tambahLemburTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">RENCANA LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/tambah_harilain'); ?>">
                    <div class="modal-body">
                      <div class="col-md-12 align-content-start">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">date_range</i>
                            </span>
                          </div>
                          <input type="text" class="form-control datetimepicker" id="tglmulai" name="tglmulai" placeholder="Tanggal & Jam" required>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-right">
                                <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                                <button type="submit" class="btn btn-success">SELANJUTNYA</button>
                      </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="historyLembur" tabindex="-1" role="dialog" aria-labelledby="historyLemburTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">HISTORY LEMBUR</h4>
                    </div>
                </div>
                  <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="card card-timeline card-plain">
                            <div class="card-body">
                              <ul class="timeline">
                                <li class="timeline-inverted">
                                  <div class="timeline-badge danger">
                                    <i class="material-icons">card_travel</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-danger">Proses HR SSC</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="admin_ssc"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li>
                                  <div class="timeline-badge success">
                                    <i class="material-icons">extension</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-success">Proses HR WTQ</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="admin_hr"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tgl_hr"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li class="timeline-inverted">
                                  <div class="timeline-badge info">
                                    <i class="material-icons">fingerprint</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-info">Persetujuan Realisasi Atasan 2</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="atasan2_realisasi"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tgl_atasan2_realisasi"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li class="timeline-inverted">
                                  <div class="timeline-badge info">
                                    <i class="material-icons">fingerprint</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-info">Persetujuan Realisasi Atasan 1</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="atasan1_realisasi"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tgl_atasan1_realisasi"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li class="timeline-inverted">
                                  <div class="timeline-badge info">
                                    <i class="material-icons">fingerprint</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-info">Persetujuan Rencana Atasan 2</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="atasan2_rencana"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tgl_atasan2_rencana"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li>
                                  <div class="timeline-badge success">
                                    <i class="material-icons">extension</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-success">Mengetahui GA</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="admin_ga"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tgl_ga"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li class="timeline-inverted">
                                  <div class="timeline-badge info">
                                    <i class="material-icons">fingerprint</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-info">Persetujuan Rencana Atasan 1</span>
                                    </div>
                                    <div class="timeline-body">
                                    <p id="atasan1_rencana"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tgl_atasan1_rencana"></i>
                                    </h6>
                                  </div>
                                </li>
                                <li>
                                  <div class="timeline-badge warning">
                                    <i class="material-icons">add_circle_outline</i>
                                  </div>
                                  <div class="timeline-panel">
                                    <div class="timeline-heading">
                                      <span class="badge badge-pill badge-warning">Mengajukan</span>
                                    </div>
                                    <div class="timeline-body">
                                      <p id="lembur"></p>
                                    </div>
                                    <h6>
                                      <i class="ti-time" id="tglmengajukan"></i>
                                    </h6>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
                        </div>
                    </div>
                  </div>
                </div>    
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
      $('#dtlembur').DataTable({
            "pagingType": "full_numbers",
            scrollX: true,
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            order: [0,"desc"],
            ajax: {
                    "url"   : "<?= site_url('lembur/getData/lemburku') ?>",
                    "type"  : "POST",
                    "data"  : {id:$('#id').val()}
                },
            columns: [
                { "data": "id" },
                { "data": "mulai" },
                { "data": "selesai" },
                { "data": "durasi" },
                { "data": "catatan" },
                { "data": "status" },
                { "data": "action", className: "text-right" }
            ],
        });

        $('#historyLembur').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var tglmengajukan = button.data('tglmengajukan')
            var atasan1 = button.data('atasan1')
            var atasan2 = button.data('atasan2')
            var tgl1_rencana = button.data('tgl1_rencana')
            var tgl2_rencana = button.data('tgl2_rencana')
            var tgl1_realisasi = button.data('tgl1_realisasi')
            var tgl2_realisasi = button.data('tgl2_realisasi')
            var ga = button.data('ga')
            var tgl_ga = button.data('tgl_ga')
            var hr = button.data('hr')
            var tgl_hr = button.data('tgl_hr')
            var status = button.data('status')
            var modal = $(this)
            if (status > 0){
            document.getElementById("lembur").innerHTML = "Mengajukan lembur pada";
            document.getElementById("tglmengajukan").innerHTML = tglmengajukan;
            }else{
            document.getElementById("lembur").innerHTML = "Lembur kamu telah DIBATALKAN";
            document.getElementById("tglmengajukan").innerHTML = null;
            }
            if (status > 2){
            document.getElementById("atasan1_rencana").innerHTML = "Disetujui oleh " + atasan1;
            document.getElementById("tgl_atasan1_rencana").innerHTML = tgl1_rencana;
            }else{
            document.getElementById("atasan1_rencana").innerHTML = "Menunggu Persetujuan " + atasan1;
            document.getElementById("tgl_atasan1_rencana").innerHTML = null;
            }
            if (status > 3){
            document.getElementById("atasan2_rencana").innerHTML = "Disetujui oleh " + atasan2;
            document.getElementById("tgl_atasan2_rencana").innerHTML = tgl2_rencana;
            }else{
            document.getElementById("atasan2_rencana").innerHTML = "Menunggu Persetujuan " + atasan2;
            document.getElementById("tgl_atasan2_rencana").innerHTML = null;
            }
            if (status > 5){
            document.getElementById("atasan1_realisasi").innerHTML = "Disetujui oleh " + atasan1;
            document.getElementById("tgl_atasan1_realisasi").innerHTML = tgl1_realisasi;
            }else{
            document.getElementById("atasan1_realisasi").innerHTML = "Menunggu Persetujuan " + atasan1;
            document.getElementById("tgl_atasan1_realisasi").innerHTML = null;
            }
            if (status > 6){
            document.getElementById("atasan2_realisasi").innerHTML = "Disetujui oleh " + atasan2;
            document.getElementById("tgl_atasan2_realisasi").innerHTML = tgl2_realisasi;
            }else{
            document.getElementById("atasan2_realisasi").innerHTML = "Menunggu Persetujuan " + atasan2;
            document.getElementById("tgl_atasan2_realisasi").innerHTML = null;
            }
            if (status > 7){
            document.getElementById("admin_hr").innerHTML = "Diproses oleh " + hr;
            document.getElementById("tgl_hr").innerHTML = tgl_hr;
            document.getElementById("admin_ssc").innerHTML = "Fitur ini masih dalam pengembangan";
            }else{
            document.getElementById("admin_hr").innerHTML = "Menunggu proses HR ";
            document.getElementById("tgl_hr").innerHTML = null;
            document.getElementById("admin_ssc").innerHTML = "Fitur ini masih dalam pengembangan";
            }
            if (ga){
            document.getElementById("admin_ga").innerHTML = "Diketahui oleh " + ga;
            document.getElementById("tgl_ga").innerHTML = tgl_ga;
            }else{
            document.getElementById("admin_ga").innerHTML = "Lembur kamu BELUM/TIDAK diketahui oleh GA";
            document.getElementById("tgl_ga").innerHTML = null;
            }
        })
    });
</script>
