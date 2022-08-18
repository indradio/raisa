<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header card-header-icon card-header-danger">
            <div class="card-icon">
              <i class="material-icons">notification_important</i>
            </div>
            <h4 class="card-title">Broadcast</h4>
          </div>
          <div class="card-body">
            <a href="<?= base_url('layanan/broadcast_send/A'); ?>" class="btn btn-info">Group A</a>
            <label class="col-md-2 col-form-label">Last Sent : <?= $lastA['last_sent'];?></label>
            </br>
            <a href="<?= base_url('layanan/broadcast_send/B'); ?>" class="btn btn-twitter">Group B</a>
            <label class="col-md-2 col-form-label">Last Sent : <?= $lastB['last_sent'];?></label>
            </br>
            <a href="<?= base_url('layanan/broadcast_send/C'); ?>" class="btn btn-linkedin">Group C</a>
            <label class="col-md-2 col-form-label">Last Sent : <?= $lastC['last_sent'];?></label>
            </br>
            <a href="<?= base_url('layanan/broadcast_send/D'); ?>" class="btn btn-facebook">Group D</a>
            <label class="col-md-2 col-form-label">Last Sent : <?= $lastD['last_sent'];?></label>
            </br>
            <a href="<?= base_url('layanan/broadcast_send/E'); ?>" class="btn btn-tumblr">Group E</a>
            <label class="col-md-2 col-form-label">Last Sent : <?= $lastE['last_sent'];?></label>
            </br>
            <a href="<?= base_url('layanan/broadcast_send/F'); ?>" class="btn btn-github">Group F</a>
            <label class="col-md-2 col-form-label">Last Sent : <?= $lastF['last_sent'];?></label>
            </br>
            <!-- </br>
            <a href="<?= base_url('presensi/notifikasi/sect'); ?>" class="btn btn-info">Notifikasi for Sect/RDA</a>
            </br>
            <a href="<?= base_url('presensi/notifikasi/dept'); ?>" class="btn btn-info">Notifikasi for Dept</a> -->
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header card-header-icon card-header-danger">
            <div class="card-icon">
              <i class="material-icons">notification_important</i>
            </div>
            <h4 class="card-title">Broadcast Gol 4 & 4up</h4>
          </div>
          <div class="card-body">
            <a href="<?= base_url('layanan/broadcast_send_up/A'); ?>" class="btn btn-info">Group A</a>
            </br>
            <a href="<?= base_url('layanan/broadcast_send_up/B'); ?>" class="btn btn-twitter">Group B</a>
            </br>
            <a href="<?= base_url('layanan/broadcast_send_up/C'); ?>" class="btn btn-linkedin">Group C</a>
            </br>
            <a href="<?= base_url('layanan/broadcast_send_up/D'); ?>" class="btn btn-facebook">Group D</a>
            </br>
            <a href="<?= base_url('layanan/broadcast_send_up/E'); ?>" class="btn btn-tumblr">Group E</a>
            </br>
            <a href="<?= base_url('layanan/broadcast_send_up/F'); ?>" class="btn btn-github">Group F</a>
            </br>
            <!-- </br>
            <a href="<?= base_url('presensi/notifikasi/sect'); ?>" class="btn btn-info">Notifikasi for Sect/RDA</a>
            </br>
            <a href="<?= base_url('presensi/notifikasi/dept'); ?>" class="btn btn-info">Notifikasi for Dept</a> -->
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </div>
</div>