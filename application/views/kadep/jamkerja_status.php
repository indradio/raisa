<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-info card-header-icon">
                <div class="card-text">
                    <h4 class="card-title">Laporan Status Jam Kerja</h4>
                    <p class="card-category">Periode <?= date('F Y', strtotime("$tahun-$bulan-01")); ?></p>
                </div>
            </div>
            <div class="card-body">
            <div class="toolbar">
                <form class="form" method="post" action="<?= base_url('kadep/status/jamkerja'); ?>">
                    <div class="form-group">
                        <!-- <label for="copro">Project*</label> -->
                        <select class="selectpicker" data-style="btn btn-link" id="month" name="month" title="Pilih Bulan" onchange='this.form.submit()' data-size="7" data-live-search="true" required>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
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
                </form>
            </div>
            <div class="material-datatables">
              <table id="dt-status" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Nama__________</th>
                    <th>Cell</th>
                    <?php
                    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                    for ($i=1; $i < $tanggal+1; $i++) { 
                      echo '<th>'. date('D, d', strtotime($tahun.'-'.$bulan.'-'.$i)) .'</th>';
                    } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $kry = $this->db->get_where('karyawan', ['work_contract' => 'Direct Labor'])->result_array();
                  foreach ($kry as $k) : 
                  $sect = $this->db->get_where('karyawan_sect', ['id' => $k['sect_id']])->row_array();?>
                  <tr>
                    <td><?=$k['nama']; ?></td>
                    <td><?= $sect['nama']; ?></td>
                  <?php
                  for ($i=1; $i < $tanggal+1; $i++) { 
                    echo '<td>';
                    $this->db->where('npk', $k['npk']);
                    $this->db->where('year(tglmulai)', $tahun);
                    $this->db->where('month(tglmulai)', $bulan);
                    $this->db->where('day(tglmulai)', $i);
                    $this->db->where('status >', 0);
                    $jamkerja = $this->db->get_where('jamkerja')->row_array();
                                
                    
                      if (date('D', strtotime($tahun.'-'.$bulan.'-'.$i))=='Sat' or date('D', strtotime($tahun.'-'.$bulan.'-'.$i))=='Sun'){
                        echo '<i class="fa fa-circle text-default"></i>';
                      }else{
                        if (!empty($jamkerja)){
                          if ($jamkerja['status']==9){
                            echo '<i class="fa fa-circle text-success"></i>';
                          }elseif ($jamkerja['status']==1){
                            echo '<i class="fa fa-circle text-warning"></i>';
                          }elseif ($jamkerja['status']==2){
                            echo '<i class="fa fa-circle text-info"></i>';
                          }
                        }else{
                          echo '<i class="fa fa-circle text-danger"></i>';
                        }
                      }
                  } ?>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
              <div class="row">
                  <div class="col-md-12">
                      <i class="fa fa-circle text-success"></i> Laporan Jam Kerja.
                      </br><i class="fa fa-circle text-warning"></i> Jam Kerja sedang diproses oleh RDA/Koordinator.
                      </br><i class="fa fa-circle text-info"></i> Jam Kerja Sedang diproses oleh PPIC. 
                      </br><i class="fa fa-circle text-danger"></i> Tidak ada Laporan Jam Kerja (Belum melaporkan, Cuti atau Tidak masuk kerja). 
                      </br><i class="fa fa-circle text-default"></i> Hari libur Pekan. 
                  </div>
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
$(document).ready(function() {
    $('#dt-status').DataTable( {
      order: [[1, 'asc']],
        rowGroup: {
            dataSrc: 1
        },
        "scrollY":        "512px",
        "scrollCollapse": true,
        "paging":         false
    } );
} );
</script>