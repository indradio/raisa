  <div class="content">
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
                      <th>Tgl Reservasi</th>
                      <th>Tujuan</th>
                      <th>Keperluan</th>
                      <th>Anggota</th>
                      <th class="disabled-sorting text-right">Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No. Reservasi</th>
                      <th>Tgl Reservasi</th>
                      <th>Tujuan</th>
                      <th>Keperluan</th>
                      <th>Anggota</th>
                      <th class="text-right">Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($reservasi as $rsv) : ?>
                      <tr>
                        <td><?= $rsv['id']; ?></td>
                        <td><?= $rsv['tglreservasi']; ?></td>
                        <td><?= $rsv['tujuan']; ?></td>
                        <td><?= $rsv['keperluan']; ?></td>
                        <td><?= $rsv['anggota']; ?></td>
                        <td class="text-right">
                          <a href="#" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">dvr</i></a>
                          <a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
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