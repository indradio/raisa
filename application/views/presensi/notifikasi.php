<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-icon card-header-danger">
            <div class="card-icon">
              <i class="material-icons">notification_important</i>
            </div>
            <h4 class="card-title">Notifikasi</h4>
          </div>
          <div class="card-body">
            <a href="<?= base_url('presensi/notifikasi/clin'); ?>" class="btn btn-success">Notifikasi Clock In</a>
            </br>
            <a href="<?= base_url('presensi/notifikasi/clrest'); ?>" class="btn btn-warning">Notifikasi Clock Rest</a>
            </br>
            <a href="<?= base_url('presensi/notifikasi/clout'); ?>" class="btn btn-danger">Notifikasi Clock Out</a>
            </br>
            </br>
            <a href="<?= base_url('presensi/notifikasi/sect'); ?>" class="btn btn-info">Notifikasi for Sect/RDA</a>
            </br>
            <a href="<?= base_url('presensi/notifikasi/dept'); ?>" class="btn btn-info">Notifikasi for Dept</a>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </div>
</div>