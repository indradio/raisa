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
            <form class="form" method="POST" action="<?= base_url('jamkerja/koordinator'); ?>">
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
                    <th>Durasi</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Durasi</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($jamkerja as $jk) : ?>
                      <tr onclick="window.location='<?= base_url('jamkerja/persetujuan_detail/') .$jk['id']; ?>'" >
                      <td><?= date('d M Y', strtotime($jk['tglmulai'])); ?></td>
                      <td><?=$jk['nama']; ?> <small>(<?=$jk['id']; ?>)</small></td>
                      <?php if ($jk['durasi']<8){ ?>
                        <td class="text-danger">
                      <?php }else{ ?>
                        <td>
                      <?php } ?>
                      <?= date('H', strtotime($jk['durasi'])); ?> Jam <?= date('i', strtotime($jk['durasi'])); ?> Menit</td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-circle text-danger"></i> Durasi Jam Kerja kurang dari 8 JAM. 
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
    $('#dt-persetujuan').DataTable( {
        order: [[0, 'asc']],
        rowGroup: {
            dataSrc: 0
        }
    } );
} );
</script>