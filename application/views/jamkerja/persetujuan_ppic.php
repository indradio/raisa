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
            <h4 class="card-title">Persetujuan Jam Kerja</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
            <form class="form" method="POST" action="<?= base_url('jamkerja/persetujuan'); ?>">
                      <div class="form-group label-floating">
                        <div class="input-group date">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </span>
                          </div>
                          <input type="text" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Pilih Tanggal" required="true" />
                            <div class="input-group-append">
                              <span class="input-group-text">
                              <button type="submit" class="btn btn-success">CARI</button>
                              </span>
                            </div>
                        </div>
                      </div>
                  </form>
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="dt-persetujuan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Cell</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Cell</th>
                    <th>Status</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  date_default_timezone_set('asia/jakarta');
                  $kry = $this->db->get_where('karyawan', ['work_contract' => 'Direct Labor'])->result_array();
                  foreach ($kry as $k) : 
                    $this->db->where('npk', $k['npk']);
                    $this->db->where('tglmulai', $tanggal);
                    $this->db->where('status >', 0);
                    $jamkerja = $this->db->get_where('jamkerja')->row_array();
                    
                    if (!empty($jamkerja)){
                      
                      $respon = floor($jamkerja['respon_create'] / (60 * 60 * 24));
                      if ($respon==0){
                        $respon = 'Tepat Waktu';
                      }else{
                        $respon = $respon.' Hari';
                      }

                      $now = time();
                      // $due = strtotime($jamkerja['create']);
                      $due = strtotime(date('Y-m-d 23:59:00', strtotime($jamkerja['create'])));
                      $approve = $due - $now;
                      $approve = floor($approve / (60 * 60 * 24));
                      if ($approve<0){
                        $approve = '( '.$approve.' Hari )';
                      }else{
                        $approve = null;
                      }

                      if ($jamkerja['status']==2){ ?>
                        <tr onclick="window.location='<?= base_url('jamkerja/detail/'. $jamkerja['id']); ?>'" >
                      <?php }else{
                        echo '<tr>';
                      } ?>
                      <td><?= date('D, d M Y', strtotime($tanggal)); ?></td>
                      <td><?=$k['nama'].' <small>( '. $respon .' )</small>'; ?></td>
                      <?php $sect = $this->db->get_where('karyawan_sect', ['id' =>  $k['sect_id']])->row_array(); ?>
                      <td><?=$sect['nama']; ?></td>
                      <td>
                        <?php if ($jamkerja['status']==1){
                          echo 'Menunggu Persetujuan '.$jamkerja['atasan1'].' <small>'. $approve .'</small>';
                        }elseif ($jamkerja['status']==2){
                          echo 'Menunggu Persetujuan PPIC';
                        }elseif ($jamkerja['status']==9){
                          echo 'Selesai';
                        }?>
                       </td>
                    </tr>
                    <?php }else{ ?>
                      <tr>
                        <td><?= date('D, d M Y', strtotime($tanggal)); ?></td>
                        <td><?=$k['nama']; ?></td>
                        <?php $sect = $this->db->get_where('karyawan_sect', ['id' =>  $k['sect_id']])->row_array(); ?>
                      <td><?=$sect['nama']; ?></td>
                        <td class="text-danger">Tidak ada Laporan Jam Kerja</td>
                      </tr>
                        <?php } ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
              <div class="row">
                  <div class="col-md-12">
                      <i class="fa fa-circle text-danger"></i> Tidak ada laporan jam kerja (Belum melaporkan, Hari libur, Cuti atau Tidak masuk kerja). 
                  </div>
              </div>
          </div>
          <div class="card-footer">
            <div class="col-mr-auto">
              <a href="<?= base_url('jamkerja/ppic/'.date('Y-m-d', strtotime("-1 day", strtotime($tanggal)))); ?>" class="btn btn-primary">SEBELUMNYA</a>
            </div>
          
            <div class="col-ml-auto">
              <a href="<?= base_url('jamkerja/ppic/'.date('Y-m-d', strtotime("+1 day", strtotime($tanggal)))); ?>" class="btn btn-primary">SELANJUTNYA</a>
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
    $('#dt-persetujuan').DataTable( {
        order: [[2, 'asc']],
        rowGroup: {
            dataSrc: 2
        },
        "scrollY":        "500px",
        "scrollCollapse": true,
        "paging":         false
    } );
} );
</script>