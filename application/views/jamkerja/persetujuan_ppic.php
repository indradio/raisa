<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Persetujuan Jam Kerja</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="dt-persetujuan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Cell</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Cell</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  date_default_timezone_set('asia/jakarta');
                  $kry = $this->db->get_where('karyawan', ['work_contract' => 'Direct Labor'])->result_array();
                  $this->db->where('status', 2);
                  $jamkerja = $this->db->get_where('jamkerja')->result_array();
                  foreach ($jamkerja as $jk) : 
                                         
                      $respon = floor($jk['respon_create'] / (60 * 60 * 24));
                      if ($respon==0){
                        $respon = 'Tepat Waktu';
                      }else{
                        $respon = $respon.' Hari';
                      }

                      $now = time();
                      // $due = strtotime($jk['create']);
                      $due = strtotime(date('Y-m-d 23:59:00', strtotime($jk['create'])));
                      $approve = $due - $now;
                      $approve = floor($approve / (60 * 60 * 24));
                      if ($approve<0){
                        $approve = '( '.$approve.' Hari )';
                      }else{
                        $approve = null;
                      } ?>

                    
                    <tr onclick="window.location='<?= base_url('jamkerja/detail/'. $jk['id']); ?>'" >
                    
                      <td><?= date('D, d M Y', strtotime($jk['tglmulai'])); ?></td>
                      <td><?=$jk['nama'].' <small>( '. $respon .' )</small>'; ?></td>
                      <?php $sect = $this->db->get_where('karyawan_sect', ['id' =>  $jk['sect_id']])->row_array(); ?>
                      <td><?=$sect['nama']; ?></td>
                    </tr>
                   
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
           
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
            <h4 class="card-title">Status Jam Kerja Periode <?= date('F Y', strtotime("$tahun-$bulan-01")); ?></h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="dt-status" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Nama</th>
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
<!-- Modal Revisi Jam Kerja-->
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalAktivitasTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-primary text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">ALASAN PEMBATALAN</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('jamkerja/batal'); ?>">
          <div class="modal-body">
            <input type="text" class="form-control disabled" name="id">
            <textarea rows="2" class="form-control" name="catatan" id="catatan" placeholder="Keterangan Pembatalan Lembur" required></textarea>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-rose mb-2">BATALKAN LEMBUR INI!</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#dt-status').DataTable( {
      order: [[1, 'asc']],
        rowGroup: {
            dataSrc: 1
        },
        "scrollY": "512px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging":         false
    } );

    $('#dt-persetujuan').DataTable( {
        order: [[0, 'asc']],
        rowGroup: {
            dataSrc: 0
        },
        "scrollY":        "512px",
        "scrollCollapse": true,
        "paging":         false
    } );
} );
</script>