  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?= $this->session->flashdata('message'); ?>
        </div>
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-rose card-header-icon">
              <div class="card-icon">
                <i class="material-icons">directions_car</i>
              </div>
              <h4 class="card-title">Data Perjalanan</h4>
            </div>
            <div class="card-body ">
              <form action="<?= base_url('reservasi/dl1c1_proses'); ?>" method="post">
                <div class="row">
                  <label class="col-md-2 col-form-label">Tujuan</label>
                  <div class="col-md-5">
                    <div class="form-group has-default">
                      <select class="selectpicker" name="tujuan[]" data-style="select-with-transition" multiple title="Pilih Tujuan" data-size="7" data-width="fit" data-live-search="true">
                        <?php
                        $queryTujuan = "SELECT *
                                    FROM `customer`
                                    ORDER BY `id` DESC
                                    ";
                        $tujuan = $this->db->query($queryTujuan)->result_array();
                        foreach ($tujuan as $tjn) : ?>
                          <small>
                            <option data-subtext="<?= substr($tjn['nama'], 0, 15); ?>" value="<?= $tjn['inisial']; ?>"><?= $tjn['inisial']; ?></option>
                          </small>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label"></label>
                  <div class="col-md-5">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="checktujuan"> Punya Tujuan Lainnya?
                        <span class="form-check-sign">
                          <span class="check"></span>
                        </span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label" id="lbllain" style="display:none;"></label>
                  <div class="col-md-5" id="tlain" style="display:none;">
                    <div class="form-group has-default">
                      <input type="text" class="form-control" name="tlainnya" id="tlainnya" placeholder="Tujuan Lainnya">
                    </div>
                  </div>
                </div>
                <p>
                  <div class="row">
                    <label class="col-md-2 col-form-label">COPRO</label>
                    <div class="col-md-5">
                      <div class="form-group has-default">
                        <select class="selectpicker" name="copro" id="copro" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                          <option value="NON PROJEK">NON PROJEK</option>
                          <?php
                          $queyCopro = "SELECT * FROM project where status != 'CLOSE'";
                          $copro = $this->db->query($queyCopro)->result_array();
                          foreach ($copro as $c) : ?>
                            <option data-subtext="<?= $c['deskripsi']; ?>" value="<?= $c['copro']; ?>"><?= $c['copro']; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-2 col-form-label">Keperluan</label>
                    <div class="col-md-5">
                      <div class="form-group has-default">
                        <textarea rows="2" class="form-control" name="keperluan" required><?= $reservasi_temp['keperluan']; ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-2 col-form-label">Peserta Perjalanan</label>
                    <div class="col-md-5">
                      <div class="form-group has-default">
                        <select class="selectpicker" name="anggota[]" data-style="select-with-transition" multiple title="Pilih Peserta" data-size="7" data-width="fit" data-live-search="true" required="true">
                          <?php
                          $queryKaryawan = "SELECT *
                                    FROM `karyawan`
                                    WHERE `is_active` = '1' AND `npk` != '1111'
                                    ORDER BY `nama` ASC
                                    ";
                          $Karyawan = $this->db->query($queryKaryawan)->result_array();
                          foreach ($Karyawan as $kry) : ?>
                            <option data-subtext="<?= $kry['nama']; ?>" value="<?= $kry['inisial']; ?>"><?= $kry['inisial']; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="row">
                  <label class="col-md-2"></label>
                  <div class="col-md-9">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="ikut" value="<?= $this->session->userdata('inisial'); ?>"> Saya ikut serta dalam perjalanan ini.
                        <span class="form-check-sign">
                          <span class="check"></span>
                        </span>
                      </label>
                    </div>
                  </div>
                </div> -->
                  <div class="row">
                    <label class="col-md-2 col-form-label">Catatan</label>
                    <div class="col-md-5">
                      <div class="form-group has-default">
                        <textarea rows="3" class="form-control" name="catatan"><?= $reservasi_temp['catatan']; ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                      <div class="form-group has-default">
                        <button type="submit" class="btn btn-fill btn-success">Berikutnya</button>
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
  <script type="text/javascript">
    $(document).ready(function() {
      var checktujuan = document.getElementById('checktujuan');
      // when unchecked or checked, run the function
      checktujuan.onchange = function() {
        if (this.checked) {
          document.getElementById("lbllain").style.display = "block";
          document.getElementById("tlain").style.display = "block";
        } else {
          document.getElementById("lbllain").style.display = "none";
          document.getElementById("tlain").style.display = "none";
          // document.getElementById("lblPenginapan").style.display = "none";
          // document.getElementById("lblLama").style.display = "none";
          // document.getElementById("lblMalam").style.display = "none";
          // $('#penginapan').prop('disabled', true);
          // $('#lama').prop('disabled', true);
        }
      }
    });
  </script>