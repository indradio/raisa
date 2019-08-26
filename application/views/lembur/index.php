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
              <h4 class="card-title">Data Reservasi</h4>
            </div>
            <div class="card-body">
              <div class="toolbar">
                <!--        Here you can write extra buttons/actions for the toolbar              -->
                <a href="<?= base_url('reservasi/dl'); ?>" class="btn btn-rose mb-2" role="button" aria-disabled="false">Reservasi Perjalanan Baru</a>
              </div>
              <div class="material-datatables">
                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>No. Reservasi</th>
                      <th>Jenis Perjalanan</th>
                      <th>Tgl Reservasi</th>
                      <th>Tujuan</th>
                      <th>Keperluan</th>
                      <th>Peserta</th>
                      <th>Atasan 1</th>
                      <th>Atasan 2</th>
                      <th>Catatan</th>
                      <th>Status</th>
                      <th class="disabled-sorting text-right">Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No. Reservasi</th>
                      <th>Jenis Perjalanan</th>
                      <th>Tgl Reservasi</th>
                      <th>Tujuan</th>
                      <th>Keperluan</th>
                      <th>Peserta</th>
                      <th>Atasan 1</th>
                      <th>Atasan 2</th>
                      <th>Catatan</th>
                      <th>Status</th>
                      <th class="text-right">Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($reservasi as $rsv) : ?>
                    <tr>
                      <td><?= $rsv['id']; ?></td>
                      <td><?= $rsv['jenis_perjalanan']; ?></td>
                      <td><?= $rsv['tglreservasi']; ?></td>
                      <td><?= $rsv['tujuan']; ?></td>
                      <td><?= $rsv['keperluan']; ?></td>
                      <td><?= $rsv['anggota']; ?></td>
                      <td><?= $rsv['atasan1']; ?></td>
                      <td><?= $rsv['atasan2']; ?></td>
                      <td><?= $rsv['catatan']; ?></td>
                      <?php $status = $this->db->get_where('reservasi_status', ['id' => $rsv['status']])->row_array(); ?>
                      <td><?= $status['nama']; ?></td>
                      <td class="text-right">
                        <?php if ($rsv['status'] == 1 or $rsv['status'] == 2 or $rsv['status'] == 3) { ?>
                        <a href="#" class="btn btn-link btn-danger btn-just-icon remove" data-toggle="modal" data-target="#batalRsv" data-id="<?= $rsv['id']; ?>"><i class="material-icons">close</i></a>
                        <?php } else { ?>
                        <a href="#" class="btn btn-link btn-danger btn-just-icon remove disabled"><i class="material-icons">close</i></a>
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
              <button type="submit" class="btn btn-danger">BATALKAN PERJALANAN INI!</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>