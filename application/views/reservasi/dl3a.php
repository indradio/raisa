  <?php 
  if ($reservasi_temp['id']==null)
  {
    redirect('reservasi/dl');
  }
  ?>
    <div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-rose card-header-icon">
              <div class="card-icon">
                <i class="material-icons">directions_car</i>
              </div>
              <h4 class="card-title">Perjalanan TA</h4>
            </div>
            <div class="card-body">
              <form class="form-horizontal" name="myForm" action="<?= base_url('reservasi/dl3a_proses'); ?>" onsubmit="return validateForm()"  method="post">
                        <div class="row">
                  <label class="col-md-2 col-form-label">Peserta Perjalanan* <br><small class="text-warning">(Termasuk kamu)</small></label>
                  <div class="col-md-5">
                    <div class="form-group has-default">
                      <select class="selectpicker" name="anggota[]" data-style="select-with-transition" multiple title="Pilih Peserta" data-size="7" data-width="fit" data-live-search="true" required>
                        <?php
                        $queryKaryawan = "SELECT *
                                    FROM `karyawan`
                                    WHERE `status` = '1' AND `is_active` = '1'
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
                <div class="row">
                  <label class="col-md-2 col-form-label">Tujuan*</label>
                  <div class="col-md-5">
                    <div class="form-group has-default">
                      <select class="selectpicker" id="tujuan" name="tujuan[]" data-style="select-with-transition" multiple title="Pilih Tujuan" data-size="7" data-width="fit" data-live-search="true">
                        <?php
                        $queryTujuan = "SELECT *
                                    FROM `customer`
                                    ORDER BY `id` DESC
                                    ";
                        $tujuan = $this->db->query($queryTujuan)->result_array();
                        foreach ($tujuan as $tjn) : ?>
                          <option data-subtext="<?= $tjn['nama']; ?>" value="<?= $tjn['inisial']; ?>"><?= $tjn['inisial']; ?></option>
                        <?php endforeach; ?>
                      </select>
                      <input type="text" class="form-control" id="tujuan_lain" name="tujuan_lain" placeholder="Tuliskan di sini jika tujuan kamu tidak ditemukan.">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label">COPRO*</label>
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
                  <label class="col-md-2 col-form-label">Keperluan*</label>
                  <div class="col-md-5">
                    <div class="form-group has-default">
                      <textarea rows="2" class="form-control" id="keperluan" name="keperluan" placeholder="Jelaskan keperluan kamu." required></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label">Akomodasi</label>
                  <div class="col-md-5">
                    <div class="form-group has-default">
                    <input type="text" class="form-control" id="akomodasi" name="akomodasi">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label"></label>
                  <div class="col-md-5">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="checkpenginapan"> Menginap
                        <span class="form-check-sign">
                          <span class="check"></span>
                        </span>
                      </label>
                    </div>    
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label"></label>
                  <div class="col-md-5" id="lblPenginapan" style="display:none;">
                    <div class="form-group has-default">
                    <select class="selectpicker" name="penginapan" id="penginapan" title="Pilih" data-style="select-with-transition" data-width="auto">
                      <option value="HOTEL">HOTEL</option>
                      <option value="KONTRAKAN">KONTRAKAN</option>
                      <option value="HOME STAY">HOME STAY</option>
                    </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label"></label>
                  <div class="col-md-1" id="lblLama" style="display:none;">
                      <div class="form-group has-default">
                        <input type="number" class="form-control" id="lama" name="lama">
                      </div>
                  </div> 
                  <div class="col-ml-2" id="lblMalam" style="display:none;">
                  <label class="col-form-label">Malam</label>
                  </div> 
                </div>
                <div class="row">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="col-md-5">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="checkoperasional" name="checkoperasional" value="YA"> Kendaraan Operasional
                        <span class="form-check-sign">
                          <span class="check"></span>
                        </span>
                      </label>
                    </div>    
                  </div>
                  </div>
                  <div class="row">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="col-md-5" id="pilihkendaraan" style="display:none;">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="kendaraan" id="kendaraan" title="Pilih" data-style="select-with-transition" data-size="5" data-width="fit" data-live-search="false">
                                    <?php
                                      $queryKendaraan = "SELECT *
                                        FROM `kendaraan`
                                        WHERE `id` > 100
                                        ORDER BY `id` ASC
                                        ";
                                      $kendaraan = $this->db->query($queryKendaraan)->result_array();
                                      foreach ($kendaraan as $k) : 

                                          $nopol = $k['nopol'];
                                          $tglberangkat = $reservasi_temp['tglberangkat'];
                                          $tglkembali = $reservasi_temp['tglkembali'];
                                          $jamberangkat = $reservasi_temp['jamberangkat'];
                                          $jamkembali = $reservasi_temp['jamkembali'];

                                          $queryCari = "SELECT COUNT(*)
                                              FROM `reservasi`
                                              WHERE `nopol` =  '$nopol' AND `status` != 0 AND `status` != 9
                                              AND ((`tglberangkat` <= '$tglberangkat'  AND `tglkembali` >= '$tglberangkat') 
                                              OR (`tglberangkat` <= '$tglkembali'  AND `tglkembali` >= '$tglkembali')
                                              OR (`tglberangkat` >= '$tglberangkat'  AND `tglkembali` <= '$tglkembali')
                                              OR (`tglberangkat` <= '$tglberangkat'  AND `tglkembali` >= '$tglkembali'))
                                              ";
                                          $cari = $this->db->query($queryCari)->row_array();
                                          $total = $cari['COUNT(*)'];
                                          if ($total == 0) 
                                          { 
                                            echo '<option data-subtext="'. $k['nopol'] . '" value="' . $k['nama'] .'">'. $k['nama'] .'</option>';
                                          }
                                      endforeach; ?>
                                          <option value="Taksi">Taksi</option>
                                          <option value="Sewa">Sewa</option>
                                          <option value="Pribadi">Kendaraan Pribadi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-3">
                    <div class="form-group has-default">
                      <button type="submit" class="btn btn-fill btn-rose">Selanjutnya</button>
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

          if(tujuan_lain.value == ""){
            $('#tujuan').prop('required', true);
          }

          tujuan_lain.oninput = function() {
            if(tujuan_lain.value == ""){
              $('#tujuan').prop('required', true);
            }else{
              $('#tujuan').prop('required', false);
            }
          };

          var checkpenginapan = document.getElementById('checkpenginapan');
          // when unchecked or checked, run the function
          checkpenginapan.onchange = function() {
              if (this.checked) {
                document.getElementById("lblPenginapan").style.display = "block";
                document.getElementById("lblLama").style.display = "block";
                document.getElementById("lblMalam").style.display = "block";
                $('#penginapan').prop('disabled', false);
                $('#penginapan').prop('required', true);
                $('#lama').prop('disabled', false);
                $('#lama').prop('required', true);
              } else {
                document.getElementById("lblPenginapan").style.display = "none";
                document.getElementById("lblLama").style.display = "none";
                document.getElementById("lblMalam").style.display = "none";
                $('#penginapan').prop('disabled', true);
                $('#lama').prop('disabled', true);
              }
          }
          var checkoperasional = document.getElementById('checkoperasional');
          // when unchecked or checked, run the function
          checkoperasional.onchange = function() {
              if (this.checked) {
                document.getElementById("pilihkendaraan").style.display = "block";
                $('#kendaraan').prop('disabled', false);
                $('#kendaraan').prop('required', true);
                $('#kendaraan').selectpicker('refresh');
              } else {
                document.getElementById("pilihkendaraan").style.display = "none";
                $('#kendaraan').prop('disabled', true);
              }
          }

      });
  </script>