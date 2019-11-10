<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
  <!-- RENCANA -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Persetujuan Rencana Lembur</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Tanggal & Jam </th>
                    <th>Durasi</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nama</th>
                    <th>Tanggal & Jam </th>
                    <th>Durasi</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($rencana as $l) : ?>
                      <tr onclick="window.location='<?= base_url('lembur/persetujuan_rencana/') . $l['id']; ?>'" >
                      <td><?= $l['nama']; ?> <small>(<?= $l['id']; ?>)</small></td>
                      <td><?= date('d-M H:i', strtotime($l['tglmulai'])); ?></td>
                      <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                    </tr>
                  <?php endforeach; ?>
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
    <!-- REALISASI -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Persetujuan Realisasi Lembur</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="datatables2" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
              <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Tanggal & Jam </th>
                    <th>Durasi</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nama</th>
                    <th>Tanggal & Jam </th>
                    <th>Durasi</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($lembur as $l) : ?>
                  <tr onclick="window.location='<?= base_url('lembur/persetujuan_realisasi/') . $l['id']; ?>'" >
                      <td><?= $l['nama']; ?> <small>(<?= $l['id']; ?>)</small></td>
                      <td><?= date('d-M H:i', strtotime($l['tglmulai_aktual'])); ?></td>
                      <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                    </tr>
                  <?php endforeach; ?>
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
  </div>
</div>
<!-- Modal persetujuanRencana -->
<!-- <div class="modal fade" id="persetujuanRencana" tabindex="-1" role="dialog" aria-labelledby="persetujuanRencanaTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-primary text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">PERSETUJUAN RENCANA</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('lembur/setujui_aktivitas'); ?>">
          <div class="modal-body">
                        <div class="row">
                            <label class="col-md-4 col-form-label">Lembur ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id">
                                </div>
                            </div>
                        </div>
          <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover"  cellspacing="0" width="100%" style="width:100%">
                  <thead>
                      <tr>
                          <th>Nama</th>
                          <th>Projek</th>
                          <th>Aktivitas</th>
                          <th>Durasi</th>
                          <th>Status</th>
                          <th class="disabled-sorting"></th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                          <th>Nama</th>
                          <th>Projek</th>
                          <th>Aktivitas</th>
                          <th>Durasi</th>
                          <th>Status</th>
                          <th></th>
                      </tr>
                  </tfoot>
                  <tbody>
                      <?php
                          
                          // $queryLembur = "SELECT * FROM `lembur` WHERE (`id` = '$l[id]') "; 
                          // $ql = $this->db->query($queryLembur)->row_array();

                          
                          $queryAktivitas = "SELECT *
                                            FROM `aktivitas`
                                            WHERE(`link_aktivitas` = '$l[id]')
                                            ";
                          $qA = $this->db->query($queryAktivitas)->result_array();

                          foreach ($qA as $a) : ?>
                          <tr>
                              <?php $n = $this->db->get_where('lembur', ['id' => $a['link_aktivitas']])->row_array(); ?>
                                  <td ><?= $n['nama']; ?></td>
                              <td><?= $a['copro']; ?></td>
                              <td><?= $a['aktivitas']; ?></td>
                              <td><?= $a['durasi']; ?> jam</td>
                              <?php $status = $this->db->get_where('aktivitas_status', ['id' => $a['status']])->row_array(); ?>
                                  <td><?= $status['nama']; ?></td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
          </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-success">SETUJUI</button>
            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#batalRsv" data-id="<?= $l['id']; ?>">BATALKAN</a>
            <a href="<?= base_url('lembur/persetujuan_aktivitas_sect/') . $l['id']; ?>" id="edit" class="btn btn-warning" role="button">EDIT</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> -->
<!-- <script>
    $(function(){
    $('#persetujuanRencana').modal({
        keyboard: true,
        backdrop: "static",
        show:false,
        
    }).on('show', function(){
          var getIdFromRow = $(event.target).closest('tr').data('id');
        make your ajax call populate items or what even you need
        $(this).find('#id').html($('<b> Order Id selected: ' + getIdFromRow  + '</b>'))
        $(this).find('#nama').html($('<b> Order Id selected: ' + getIdFromRow  + '</b>'))
    });
});
</script> -->
<!-- Modal Batal Lembur-->
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
        <form class="form" method="post" action="<?= base_url('lembur/batal_lembur'); ?>">
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