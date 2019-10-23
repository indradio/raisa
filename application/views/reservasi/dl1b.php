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
                $querySaring1 = "SELECT *
                      FROM `perjalanan`
                      WHERE `nopol` =  '$nopol' AND `tglberangkat` <= '$tglberangkat'  AND `tglkembali` >= '$tglberangkat' AND `status` != 0 AND `status` != 9
                      ";
                $saring1 = $this->db->query($querySaring1)->row_array();
                // $total1 = $saring1['COUNT(*)'];
                if ($saring1 != null) { ?>
                  <a href="#foo" class="btn btn-danger btn-round" role="button" data-toggle="modal" data-target="#detailRsvModal" data-id="<?= $saring1['id']; ?>" data-tujuan="<?= $saring1['tujuan']; ?>" data-peserta="<?= $saring1['anggota']; ?>" data-keperluan="<?= $saring1['keperluan']; ?>"><?= $saring1['id'];?></a>
                <?php } else { 
                  $querySaring2 = "SELECT *
                        FROM `reservasi`
                        WHERE `nopol` =  '$nopol' AND `tglberangkat` <= '$tglberangkat'  AND `tglkembali` >= '$tglberangkat' AND `status` != 0 AND `status` != 9
                        ";
                  $saring2 = $this->db->query($querySaring2)->row_array();
                  // $total2 = $saring2['COUNT(*)'];
                    if ($saring2 != null) { ?>
                      <a href="#foo" class="btn btn-danger btn-round" role="button" data-toggle="modal" data-target="#detailRsvModal" data-id="<?= $saring2['id']; ?>" data-tujuan="<?= $saring2['tujuan']; ?>" data-peserta="<?= $saring2['anggota']; ?>" data-keperluan="<?= $saring2['keperluan']; ?>"><?= $saring2['id'];?></a>
                    <?php } else { ?>
                      <a href="<?= base_url('reservasi/dl1b_proses/') . $kend['id']; ?>" class="btn btn-success btn-round" role="button" aria-disabled="false">Pilih</a>
                    <?php }; ?>
                <?php }; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <!-- End Card -->
    </div>
  </div>

  <!-- Start Modal -->
  <div class="modal fade" id="detailRsvModal" tabindex="-1" role="dialog" aria-labelledby="detailRsvModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-rose text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Perjalanan Dinas</h4>
                    </div>
                </div>
                <form id="" class="form" method="post" action="">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="tujuan">Tujuan</label>
                                <input type="text" class="form-control disabled" id="tujuan" name="tujuan">
                            </div>
                            <div class="form-group">
                                <label for="peserta">Peserta</label>
                                <input type="text" class="form-control disabled" id="peserta" name="peserta">
                            </div>
                            <div class="form-group">
                                <label for="keperluan">Keperluan</label>
                                <textarea class="form-control has-success disabled" id="keperluan" name="keperluan" rows="3"></textarea>
                            </div>
                    </div>
                    <!-- <div class="modal-footer justify-content-right">
                        <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-info btn-round">IKUT</button>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- End Modal -->