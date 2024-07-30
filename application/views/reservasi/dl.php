  <div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
      <!-- Start Card -->
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card card-product">
            <div class="card-header card-header-image" data-header-animation="false">
              <a href="#" class="btn btn-link" role="button" aria-disabled="true" data-toggle="modal" data-target="#dlpp"><img class="img" src="<?= base_url(); ?>assets/img/DLPP.jpeg"></a>
            </div>
            <div class="card-body">
              <h4 class="card-title">
                Perjalanan Dinas Luar Pulang Pergi <p>DLPP</p>
              </h4>
              <!-- <div class="card-footer justify-content-center">
                <a href="<?= base_url('reservasi/dl1a'); ?>" class="btn btn-primary btn-round" role="button" aria-disabled="false">Pilih</a>
              </div> -->
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-product">
            <div class="card-header card-header-image" data-header-animation="false">
            <a href="#" class="btn btn-link" role="button" aria-disabled="true" data-toggle="modal" data-target="#tapp"><img class="img" src="<?= base_url(); ?>assets/img/TAPP.jpeg"></a>
            </div>
            <div class="card-body">
              <h4 class="card-title">
                Perjalanan Dinas Luar Pulang Pergi <p>TAPP</p>
              </h4>
              <!-- <div class="card-footer justify-content-center">
                <a href="<?= base_url('reservasi/dl2a'); ?>" class="btn btn-primary btn-round" role="button" aria-disabled="true">Pilih</a>
              </div> -->
            </div>
          </div>
        </div>
        <!-- <div class="col-md-4">
          <div class="card card-product">
            <div class="card-header card-header-image" data-header-animation="false">
            <a href="#" class="btn btn-link" role="button" aria-disabled="true" data-toggle="modal" data-target="#ta"><img class="img" src="<?= base_url(); ?>assets/img/TA.jpeg"></a>
            </div>
            <div class="card-body">
              <h4 class="card-title">
                Perjalanan Dinas Luar Menginap <p>TA</p>
              </h4>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-product">
            <div class="card-header card-header-image" data-header-animation="false">
            <a href="#" class="btn btn-link" role="button" aria-disabled="true" data-toggle="modal" data-target="#training"><img class="img" src="<?= base_url(); ?>assets/img/TA.jpeg"></a>
            </div>
            <div class="card-body">
              <h4 class="card-title">
                Perjalanan Dinas Luar <p>TRAINING</p>
              </h4>
            </div>
          </div>
        </div> -->
      </div>
      <!-- end row -->
    </div>
    <!-- end container-fluid -->
  </div>
  <!-- end content -->
  <!-- Modal Tambah Perjalanan-->
  <div class="modal fade" id="dlpp" tabindex="-1" role="dialog" aria-labelledby="dlppTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">PERJALANAN DINAS DLPP</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('reservasi/dl1a_proses'); ?>">
                    <div class="modal-body">
                      <div class="row col-md-12">
                        <label class="col-md-5 col-form-label">Tanggal</label>
                        <div class="col-md-6">
                          <div class="form-group has-default">
                            <input type="text" class="form-control datepicker" id="tglberangkat" name="tglberangkat" value="<?= date('d-m-Y'); ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="row col-md-12">
                        <label class="col-md-5 col-form-label">jam Berangkat</label>
                        <div class="col-md-6">
                          <div class="form-group has-default">
                            <input type="text" class="form-control timepicker" id="jamberangkat" name="jamberangkat" value="07:30" required>
                         </div>
                        </div>
                      </div>
                      <div class="row col-md-12">
                        <label class="col-md-5 col-form-label">jam Kembali</label>
                        <div class="col-md-6">
                          <div class="form-group has-default">
                            <input type="text" class="form-control timepicker" id="jamkembali" name="jamkembali" value="16:30" required>
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
  <!-- Modal Tambah Perjalanan-->
  <div class="modal fade" id="tapp" tabindex="-1" role="dialog" aria-labelledby="tappTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">PERJALANAN DINAS TAPP</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('reservasi/dl2a_proses'); ?>">
                    <div class="modal-body">
                      <div class="row col-md-12">
                        <label class="col-md-5 col-form-label">Tanggal</label>
                        <div class="col-md-6">
                          <div class="form-group has-default">
                            <input type="text" class="form-control datepicker" id="tglberangkat" name="tglberangkat" value="<?= date('d-m-Y'); ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="row col-md-12">
                        <label class="col-md-5 col-form-label">jam Berangkat</label>
                        <div class="col-md-6">
                          <div class="form-group has-default">
                            <input type="text" class="form-control timepicker" id="jamberangkat" name="jamberangkat" value="07:30" required>
                         </div>
                        </div>
                      </div>
                      <div class="row col-md-12">
                        <label class="col-md-5 col-form-label">jam Kembali</label>
                        <div class="col-md-6">
                          <div class="form-group has-default">
                            <input type="text" class="form-control timepicker" id="jamkembali" name="jamkembali" value="16:30" required>
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
  <!-- Modal Tambah Perjalanan-->
  <div class="modal fade" id="ta" tabindex="-1" role="dialog" aria-labelledby="taTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
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
  <!-- Modal Tambah Perjalanan-->
  <div class="modal fade" id="training" tabindex="-1" role="dialog" aria-labelledby="trainingTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">PERJALANAN DINAS TRAINING</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('reservasi/dl1a_proses'); ?>">
                  <input type="text" class="form-control datepicker" id="kategori" name="kategori" value="<?= date('d-m-Y'); ?>" required>
                    <div class="modal-body">
                      <div class="row col-md-12">
                        <label class="col-md-5 col-form-label">Tanggal</label>
                        <div class="col-md-6">
                          <div class="form-group has-default">
                            <input type="text" class="form-control datepicker" id="tglberangkat" name="tglberangkat" value="<?= date('d-m-Y'); ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="row col-md-12">
                        <label class="col-md-5 col-form-label">jam Berangkat</label>
                        <div class="col-md-6">
                          <div class="form-group has-default">
                            <input type="text" class="form-control timepicker" id="jamberangkat" name="jamberangkat" value="07:30" required>
                         </div>
                        </div>
                      </div>
                      <div class="row col-md-12">
                        <label class="col-md-5 col-form-label">jam Kembali</label>
                        <div class="col-md-6">
                          <div class="form-group has-default">
                            <input type="text" class="form-control timepicker" id="jamkembali" name="jamkembali" value="16:30" required>
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