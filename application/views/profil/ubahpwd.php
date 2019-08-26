<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-rose card-header-icon">
              <div class="card-icon">
                <i class="material-icons">vpn_key</i>
              </div>
              <h4 class="card-title">Ubah Password</h4>
            </div>
            <div class="card-body ">
              <form class="form-horizontal" action="<?= base_url('profil/ubahpwd_proses'); ?>" method="post">
                <div class="row">
                  <label class="col-md-2 col-form-label">Password Sebelumnya</label>
                  <div class="col-md-3">
                    <div class="form-group has-default">
                    <input type="password" class="form-control" name="passlama">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label">Password Baru</label>
                  <div class="col-md-3">
                    <div class="form-group has-default">
                    <input type="password" class="form-control" name="passbaru1">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label">Konfirmasi Password Baru</label>
                  <div class="col-md-3">
                    <div class="form-group has-default">
                    <input type="password" class="form-control" name="passbaru2">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-3">
                    <div class="form-group has-default">
                      <button type="submit" class="btn btn-fill btn-rose">UBAH</button>
                      <a href="<?= base_url('profil/index'); ?>" class="btn btn-fill btn-default">Kembali</a>
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