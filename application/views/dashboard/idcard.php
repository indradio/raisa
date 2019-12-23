<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <!-- <div class="alert alert-rose alert-dismissible fade show" role="alert">
    <strong>Hay Your RAISA!</strong> Buat kamu yang penikmat kopi, Mau dapet COFFEE MAKER biar gak repot nyeduh? Gampangg! 
    </br>yuk isi survei kepuasan acara FAMILY DAY 2019 dan kamu punya kesempatan untuk mendapatkan COFFEE MAKER keren ini? Klik <a href="<?= base_url('famday/survey'); ?>" target="_blank">DISINI</a>. 
    </br>RAISA tunggu paling lambat <b>Tanggal 22 Nov 2019 Jam 16:30</b>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div> -->
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
            <h4 class="card-title">
                Design by <?= $ic['nama']; ?>
            </h4>
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