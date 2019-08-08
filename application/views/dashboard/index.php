<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <!-- Banner -->
    <div class="row">
      <?php
      $queryInfo = "SELECT *
                                    FROM `informasi`
                                    WHERE `berlaku` >= CURDATE()
                                    ORDER BY `id` DESC LIMIT 3
                                ";
      $informasi = $this->db->query($queryInfo)->result_array();
      ?>
      <?php foreach ($informasi as $info) : ?>
        <div class="col-md-4">
          <div class="card card-product">
            <div class="card-header card-header-image" data-header-animation="true">
              <a href="#pablo">
                <img class="img" src="<?= base_url(); ?>assets/img/info/<?= $info['gambar']; ?>">
              </a>
            </div>
            <div class="card-body">
              <div class="card-actions text-center">
                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                  <i class="material-icons">build</i> Fix Header!
                </button>
                <a href="<?= base_url('dashboard/informasi/') . $info['id']; ?>" class="btn btn-default btn-link" rel="tooltip" title="">
                  Selengkapnya...
                </a>
              </div>
              <h4 class="card-title">
                <?= $info['judul']; ?>
              </h4>
              <div class="card-description">
                <?= $info['deskripsi']; ?>
              </div>
            </div>
            <div class="card-footer">
              <div class="price">
                <h4><?= $info['sect_nama']; ?></h4>
              </div>
              <div class="stats">
                <p class="card-category"><i class="material-icons">time</i> Berlaku sampai <?= $info['berlaku']; ?></p>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <!-- end banner -->
  </div>
  <!-- end container-fluid -->
</div>
<!-- end content -->