  <div class="content">
    <div class="container-fluid">
      <!-- Start Card -->
      <div class="row">
        <?php
        $queryKendaraan = "SELECT *
                                    FROM `kendaraan`
                                    WHERE `kontrak` >= CURDATE() AND `is_active` = 1
                                    ORDER BY `id` DESC
                                ";
        $kendaraan = $this->db->query($queryKendaraan)->result_array();
        ?>
        <?php foreach ($kendaraan as $kend) : ?>
          <div class="col-md-3">
            <div class="card card-product">
              <div class="card-header card-header-image" data-header-animation="false">
                <img class="img" src="<?= base_url(); ?>assets/img/kendaraan/<?= $kend['gambar']; ?>">
              </div>
              <div class="card-body">
                <h4 class="card-title">
                  <?= $kend['nopol']; ?>
                </h4>
                <div class="card-description">
                  <?= $kend['nama'] . '-' . $kend['tipe']; ?>
                </div>
              </div>
              <div class="card-footer justify-content-center">
                <?php
                $nopol = $kend['nopol'];
                $tglberangkat = $reservasi_temp['tglberangkat'];
                $tglkembali = $reservasi_temp['tglkembali'];
                $jamberangkat = $reservasi_temp['jamberangkat'];
                $jamkembali = $reservasi_temp['jamkembali'];
                $querySaring1 = "SELECT COUNT(*)
                      FROM `reservasi`
                      WHERE `nopol` =  '$nopol' AND `status` != 0
                      AND ((`tglberangkat` <= '$tglberangkat'  AND `tglkembali` >= '$tglberangkat') 
                      OR (`tglberangkat` <= '$tglkembali'  AND `tglkembali` >= '$tglkembali')
                      OR (`tglberangkat` >= '$tglberangkat'  AND `tglkembali` <= '$tglkembali')
                      OR (`tglberangkat` <= '$tglberangkat'  AND `tglkembali` >= '$tglkembali'))
                      ";
                $saring1 = $this->db->query($querySaring1)->row_array();
                $total = $saring1['COUNT(*)'];
                if ($total == 0) { ?>
                  <a href="<?= base_url('reservasi/dl1b_proses/') . $kend['id']; ?>" class="btn btn-success btn-round" role="button" aria-disabled="false">Pilih</a>
                <?php } else { ?>
                  <a href="#foo" class="btn btn-danger btn-round disabled" role="button" aria-disabled="true">Penuh</a>
                <?php
                }; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <!-- End Card -->
    </div>
  </div>