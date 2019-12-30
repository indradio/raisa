  <div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
      <!-- Start Card -->
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card card-product">
            <div class="card-header card-header-image" data-header-animation="false">
              <img class="img" src="<?= base_url(); ?>assets/img/DLPP.jpeg">
            </div>
            <div class="card-body">
              <h4 class="card-title">
                Perjalanan Dinas Luar Pulang Pergi <p>DLPP</p>
              </h4>
              <div class="card-footer justify-content-center">
                <a href="<?= base_url('reservasi/dl1a'); ?>" class="btn btn-primary btn-round" role="button" aria-disabled="false">Pilih</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-product">
            <div class="card-header card-header-image" data-header-animation="false">
              <img class="img" src="<?= base_url(); ?>assets/img/TAPP.jpeg">
            </div>
            <div class="card-body">
              <h4 class="card-title">
                Perjalanan Dinas Luar Pulang Pergi <p>TAPP</p>
              </h4>
              <div class="card-footer justify-content-center">
                <a href="<?= base_url('reservasi/dl2a'); ?>" class="btn btn-primary btn-round" role="button" aria-disabled="true">Pilih</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-product">
            <div class="card-header card-header-image" data-header-animation="false">
              <img class="img" src="<?= base_url(); ?>assets/img/TA.jpeg">
            </div>
            <div class="card-body">
              <h4 class="card-title">
                Perjalanan Dinas Luar Menginap <p>TA</p>
              </h4>
              <div class="card-footer justify-content-center">
                <a href="#" class="btn btn-primary btn-round" role="button" aria-disabled="true" data-toggle="modal" data-target="#ta">Pilih</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- end container-fluid -->
  </div>
  <!-- end content -->
  <!-- Modal Tambah Perjalanan-->
  <div class="modal fade" id="ta" tabindex="-1" role="dialog" aria-labelledby="taTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">PERJALANAN DINAS TA</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('reservasi/dl3_proses'); ?>">
                    <div class="modal-body">
                      <div class="row col-md-12">
                        <label class="col-md-5 col-form-label">Keberangkatan</label>
                        <div class="col-md-6">
                          <div class="form-group has-default">
                            <input type="text" class="form-control datetimepicker" id="tglberangkat" name="tglberangkat" required>
                          </div>
                        </div>
                      </div>
                      <div class="row col-md-12">
                        <label class="col-md-5 col-form-label">Kembali</label>
                        <div class="col-md-6">
                          <div class="form-group has-default">
                            <input type="text" class="form-control datetimepicker" id="tglkembali" name="tglkembali" required>
                         </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                      <button type="submit" class="btn btn-success">SELANJUTNYA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>