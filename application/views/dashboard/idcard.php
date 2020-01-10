<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <!-- Banner -->
    <div class="row">
      <?php
      $queryIC = "SELECT *
                                    FROM `idcard`
                                    ORDER BY `id` DESC
                                ";
      $idcard = $this->db->query($queryIC)->result_array();
      ?>
      <?php foreach ($idcard as $ic) : ?>
      <div class="col-md-4">
        <div class="card card-product">
          <div class="card-header card-header-image" data-header-animation="true">
            <a href="#pablo">
              <img class="img" src="<?= base_url(); ?>assets/img/idcard/<?= $ic['design']; ?>.jpg">
            </a>
          </div>
          <div class="card-body">
            <div class="card-actions text-center">
            </br>
                <?= $ic['design']; ?>
            </div>
          </div>
          <div class="card-footer">
                                <div class="price">
                                  <?php $like = $this->db->get_where('idcard_like', ['design' => $ic['design']]); ?>
                                  <h4><?= $like->num_rows(); ?> Like</h4>
                                </div>
                                <div class="stats">
                                  <p class="card-category"><i class="material-icons">person_pin</i> Design by <?= $ic['nama']; ?></p>
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