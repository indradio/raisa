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
            <h4 class="card-title">Persetujuan Realisasi Lembur</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Nama</th>
                    <th>Tgl / Jam Pengajuan</th>
                    <th>Tgl / Jam Mulai</th>
                    <!-- <th>Jam Mulai</th> -->
                    <th>Tgl / Jam Selesai</th>
                    <!-- <th>Jam Selesai</th> -->
                    <th>Durasi/Jam</th>
                    <!-- <th>Catatan</th> -->
                    <!-- <th>Status</th> -->
                    <th class="disabled-sorting">Actions</th>
                    <th class="disabled-sorting"></th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No. Lembur</th>
                    <th>Nama</th>
                    <th>Tgl / Jam Pengajuan</th>
                    <th>Tgl / jam Mulai</th>
                    <!-- <th>Jam Mulai</th> -->
                    <th>Tgl / Jam Selesai</th>
                    <!-- <th>Jam Selesai</th> -->
                    <th>Durasi/Jam</th>
                    <!-- <th>Catatan</th> -->
                    <!-- <th>Status</th> -->
                    <th class="">Actions</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($lembur as $l) : ?>
                    <tr>
                      <td><?= $l['id']; ?></td>
                      <td><?= $l['nama']; ?></td>
                      <td><?= $l['tglpengajuan']; ?></td>
                      <td><?= date('d/m/Y H:i', strtotime($l['tglmulai_aktual'])); ?></td>
                      <!-- <td><?= date('H:i', strtotime($l['tglmulai_aktual'])); ?></td> -->
                      <td><?= date('d/m/Y H:i', strtotime($l['tglselesai_aktual'])); ?></td>
                      <!-- <td><?= date('H:i', strtotime($l['tglselesai_aktual'])); ?></td> -->
                      <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                      <!-- <td><?= $l['catatan']; ?></td> -->
                      <!-- <?php $status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array(); ?>
                      <td><?= $status['nama']; ?></td> -->
                      <td>
                        <a href="<?= base_url('lembur/persetujuan_realisasi_aktivitas/') . $l['id']; ?>" class="badge badge-pill badge-success">Detail</a>
                      </td>
                      <td class="">
                        <?php if ($l['status'] == 1 or $l['status'] == 2 or $l['status'] == 3) { ?>
                          <a href="#" class="btn btn-link btn-danger btn-just-icon remove" data-toggle="modal" data-target="#batalRsv" data-id="<?= $l['id']; ?>"><i class="material-icons">close</i></a>
                        <?php } else { ?>
                          <!-- <a href="#" class="btn btn-link btn-danger btn-just-icon remove disabled"><i class="material-icons">close</i></a> -->
                        <?php }; ?>
                      </td>
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
<!-- Modal -->
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalRsvTitle" aria-hidden="true">
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
        <form class="form" method="post" action="<?= base_url('reservasi/batalrsv'); ?>">
          <div class="modal-body">
            <input type="text" class="form-control disabled" name="id">
            <textarea rows="2" class="form-control" name="catatan" required></textarea>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-danger">BATALKAN LEMBUR INI!</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>