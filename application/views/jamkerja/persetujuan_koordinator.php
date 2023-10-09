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
                    <th>Status</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Status</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php 
                  // $kry = $this->db->get_where('karyawan', ['sect_id' => $this->session->userdata('sect_id')])->result_array();
                  $this->db->where('atasan1', $this->session->userdata('inisial'));
                  $this->db->where('status', 1);
                  $jamkerja = $this->db->get_where('jamkerja')->result_array();
                  foreach ($jamkerja as $jk) : 

                      $respon = floor($jk['respon_create'] / (60 * 60 * 24));
                      if ($respon==0){
                        $respon = 'Tepat Waktu';
                      }else{
                        $respon = $respon.' Hari';
                      }

                      if ($jk['status']==1){ ?>
                        <tr onclick="window.location='<?= base_url('jamkerja/detail/'. $jk['id']); ?>'" >
                      <?php }else{
                        echo '<tr>';
                      } ?>
                      <td><?= date('D, d M Y', strtotime($jk['tglmulai'])); ?></td>
                      <td><?=$jk['nama'].' <small>( '. $respon .' )</small>'; ?></td>
                      <td>
                        <?php if ($jk['status']==1){
                          echo 'Menunggu Persetujuan Koordinator';
                        }elseif ($jk['status']==2){
                          echo 'Menunggu Persetujuan PPIC';
                        }elseif ($jk['status']==9){
                          echo 'Selesai';
                        }?>
                       </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
              <div class="row">
                  <div class="col-md-12">
                      
                  </div>
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
        "scrollX": true,
        "scrollCollapse": true,
        "paging":         false,
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 0
        }
    } );

    $('#dt-persetujuan').DataTable( {
        order: [[0, 'asc']],
        rowGroup: {
            dataSrc: 0
        }
    } );
} );
</script>