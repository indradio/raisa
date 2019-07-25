  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-rose card-header-icon">
              <div class="card-icon">
                <i class="material-icons">today</i>
              </div>
              <h4 class="card-title">Jadwal keberangkatan</h4>
            </div>
            <div class="card-body ">
              <form class="form-horizontal" action="<?= base_url('reservasi/dl1a_proses'); ?>" method="post">
                <div class="row">
                  <label class="col-md-2 col-form-label">Tanggal Keberangkatan</label>
                  <div class="col-md-3">
                    <div class="form-group has-default">
                      <input type="date" class="form-control datepicker" id="tglberangkat" name="tglberangkat">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label">Jam Keberangkatan</label>
                  <div class="col-md-3">
                    <div class="form-group has-default">
                      <input type="time" class="form-control timepicker" id="jamberangkat" name="jamberangkat">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label">Jam Kembali</label>
                  <div class="col-md-3">
                    <div class="form-group has-default">
                      <input type="time" class="form-control timepicker" id="jamkembali" name="jamkembali">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-3">
                    <div class="form-group has-default">
                      <button type="submit" class="btn btn-fill btn-rose">Cari</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>