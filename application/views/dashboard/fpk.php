<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
  <div class="row">
      <div class="col-md-12">
        <form id="timePrecense" class="form" method="post" action="<?= base_url('dirumahaja/submit'); ?>">
          <div class="card ">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">local_hospital</i>
              </div>
              <h4 class="card-title">FORM PEDULI KESEHATAN KARYAWAN WINTEQ</h4>
            </div>
            <div class="card-body ">
            <div class="alert-default" role="alert">
              <!-- Begin Content -->
              ⚠️<strong>WAJIB BACA SEBELUM MENGISI</strong>⚠️
              </p>Tindakan bila ada yang terisi "Ya"
              </p><strong>Pernyataan A (Kondisi Kesehatan)</strong>
              </br>1. Periksa ke klinik tingkat pertama, ikuti protokol klinik.
              </br>2. Lapor ke Atasan sampai Manager.
              </p><strong>Pernyataan B (Risiko Penularan)</strong>
              </br>1. Lapor ke Atasan sampai Manager.
              </p><strong>Catatan</strong>
              </br>1. Bila ada yang terisi "Ya" dari quesionare ini, maka Karyawan harus segera menginformasikan ke atasannya (sampai Manager) di hari tersebut.
              </br>2. Form ini berlaku untuk semua orang yang bekerja di lingkungan WINTEQ.
              </p>
              <!-- End Content -->
            </div>
              <div class="progress" style="width: 100%">
                <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="1"></div>
              </div>
              <div class="form-group">
                <label class="bmd-label-floating">
                  <h4><b>A. Kondisi Kesehatan</b></h4>
                </label>
              </div>
              <div class="form-group">
              <label for="a1" class="bmd-label-floating">A1. Bagaimana kondisi kesehatan kamu hari ini?</label>
                      <div class="col-sm-4 col-sm-offset-1 checkbox-radios">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a1" name="a1" value="YA"> Sehat
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <small>*Tidak mengalami sakit dengan gejala COVID-19</small>
                        </br>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a2" name="a2" value="YA"> Demam dengan suhu tubuh >37,5° C
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a3" name="a3" value="YA"> Rasa tidak nyaman/Badan terasa lemas
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a4" name="a4" value="YA"> Batuk
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a5" name="a5" value="YA"> Sakit Kepala
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a6" name="a6" value="YA"> Nyeri Tenggorokan
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a7" name="a7" value="YA"> Diare
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a8" name="a8" value="YA"> Sesak Nafas
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a9" name="a9" value="YA"> Hilangnya indera perasa atau penciuman
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                    </div>

              <!-- <div class="form-group">
                <label for="a2" class="bmd-label-floating">A2. Menggunakan kendaraan <b>Batuk/Sakit Tenggorokan/Suara serak/</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="a2" name="a2" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA</option>
                  <option value="TIDAK">TIDAK</option>
                </select>
              </div>
              <div class="form-group">
                <label for="a3" class="bmd-label-floating">A3. Sedang mengalamai <b>Sesak nafas/Nafas pendek</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="a3" name="a3" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA</option>
                  <option value="TIDAK">TIDAK</option>
                </select>
              </div> -->
              </br>
              <div class="form-group">
                <label class="bmd-label-floating">
                  <h4><b>B. Risiko Penularan</b></h4>
                </label>
              </div>
              <div class="form-group">
                <label for="b1" class="bmd-label-floating">B1. Anggota keluarga dalam satu rumah sedang mengalami sakit dengan gejala berikut <b>Demam, Batuk, Nyeri Tenggorokan, Sesak Nafas atau Positif COVID-19</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="b1" name="b1" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA, ADA</option>
                  <option value="TIDAK">TIDAK ADA</option>
                </select>
              </div>
              <div class="form-group">
                <label for="b2" class="bmd-label-floating">B2. Di lingkungan tempat tinggal dengan radius <b>1 rumah kanan kiri langsung, rumah depan, dan rumah kanan kiri depan rumah</b>, ada tetangga yang dinyatakan positif COVID-19 atau sedang menjalani Isolasi Mandiri</label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="b2" name="b2" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA, ADA</option>
                  <option value="TIDAK">TIDAK ADA</option>
                </select>
              </div>
              <?php if (empty($karyawan['gol_darah'])){ ?>
              </br>
              <div class="form-group">
                <label class="bmd-label-floating">
                  <h4><b>C. Data</b></h4>
                </label>
              </div>
              <div class="form-group">
                <label for="c1" class="bmd-label-floating">C1. Golongan Darah</label>
                <div class="form-check form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="goldarah" id="goldarA" value="A" required>
                        A
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-check form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="goldarah" id="goldarB" value="B" required>
                        B
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-check form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="goldarah" id="goldarAB" value="AB" required>
                        AB
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-check form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="goldarah" id="goldarO" value="O" required>
                        O
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-check form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="goldarah" id="goldarX" value="TIDAK TAHU" required>
                        TIDAK TAHU
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
              </div>
              <?php } ?>
              <!-- <div class="form-group">
                <label for="b3" class="bmd-label-floating">B3. Penghuni satu rumah ada yang dinyatakan <b>Pasien Positif, PDP, ODP</b> ataupun <b>Orang yang sedang menjalani Isolasi Mandiri COVID-19</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="b3" name="b3" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA</option>
                  <option value="TIDAK">TIDAK</option>
                </select>
              </div>
              <div class="form-group">
                <label for="b4" class="bmd-label-floating">B4. Kamu masuk dalam status <b>Pasien Positif, PDP, ODP</b> ataupun <b>Orang yang sedang menjalani Isolasi Mandiri COVID-19</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="b4" name="b4" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA</option>
                  <option value="TIDAK">TIDAK</option>
                </select>
              </div>
              <div class="form-group">
                <label for="b5" class="bmd-label-floating">B5. Mengikuti pemerikasaan Rapid Test, PCR, ataupun Tes Kesehatan lainnya dengan hasil <b>"kemungkinan terinfeksi COVID-19"</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="b5" name="b5" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA</option>
                  <option value="TIDAK">TIDAK</option>
                </select>
              </div>
              <div class="form-group">
                <label for="b6" class="bmd-label-floating">B6. Pergi dan kembali dari <b>luar kota / Kab</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="b6" name="b6" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA, SAYA PERGI</option>
                  <option value="TIDAK">DI RUMAH AJA</option>
                </select>
              </div>
              <div class="form-group">
                <label for="b7" class="bmd-label-floating">B7. Beraktivitas jauh <b>(lebih dari 20KM)</b> dari rumah kediaman</label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="b7" name="b7" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA, SAYA PERGI</option>
                  <option value="TIDAK">DI RUMAH AJA</option>
                </select>
              </div> -->
              </p>
              <div class="form-group">
                <label for="catatan" class="bmd-label-floating"> Catatan <small><i>(Opsional)</i></small></label>
                <textarea rows="3" class="form-control" id="catatan" name="catatan"></textarea>
              </div>
              <div class="form-group" hidden="true">
                <textarea rows="3" class="form-control" id="loc" name="loc"></textarea>
                <input type="text" class="form-control" id="lat" name="lat" />
                <input type="text" class="form-control" id="lng" name="lng" />
                <input type="text" class="form-control" id="platform" name="platform" />
              </div>
              <div class="form-check mr-auto">
                <label class="form-check-label text-dark">
                  <input class="form-check-input" type="checkbox" id="check" value="" required>
                  <span class="form-check-sign">
                    <span class="check"></span>
                  </span>
                  <i>Dengan ini saya menyatakan telah memberikan informasi yang benar.</br>
                    Saya siap diproses secara hukum yang berlaku jika terbukti memanipulasi data yang saya berikan</i>
                </label>
              </div>
              <div class="category form-category">
              </div>
            </div>
            <div class="card-footer ml-auto">
              <button type="submit" id="submit" class="btn btn-success">SUBMIT</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- end row -->
  </div>
</div>

<script>
  $(document).ready(function() {

    // function showPosition(position) {
    //   document.getElementById("lat").value = position.coords.latitude;
    //   document.getElementById("lng").value = position.coords.longitude;

    //   lat = position.coords.latitude;
    //   lng = position.coords.longitude;

    //   var xhr = new XMLHttpRequest();
    //   xhr.open("POST", 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&key=AIzaSyAHFISdyofTP6NPRE142yGJjZPa1Z2VbU4', true);

    //   //Send the proper header information along with the request
    //   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    //   xhr.onreadystatechange = function() { // Call a function when the state changes.
    //     if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
    //       var myObj = JSON.parse(this.responseText);
    //       loc = myObj.results['0']['formatted_address'];
    //       document.getElementById("loc").value = loc;
    //     }
    //   }
    //   xhr.send();
    // };

    // document.getElementById("platform").value = navigator.platform;

    var checker = document.getElementById('check');
    var sendbtn = document.getElementById('submit');
    sendbtn.disabled = true;
    // when unchecked or checked, run the function
    checker.onchange = function() {
      if (this.checked) {
        sendbtn.disabled = false;
      } else {
        sendbtn.disabled = true;
      }
    }

    var a1 = document.getElementById('a1');
    var a2 = document.getElementById('a2');
    var a3 = document.getElementById('a3');
    var a4 = document.getElementById('a4');
    var a5 = document.getElementById('a5');
    var a6 = document.getElementById('a6');
    var a7 = document.getElementById('a7');
    var a8 = document.getElementById('a8');
    var a9 = document.getElementById('a9');

    // when unchecked or checked, run the function
    a1.onchange = function() {
      if (this.checked) {
        a2.checked = false;
        a2.disabled = true;
        a3.checked = false;
        a3.disabled = true;
        a4.checked = false;
        a4.disabled = true;
        a5.checked = false;
        a5.disabled = true;
        a6.checked = false;
        a6.disabled = true;
        a7.checked = false;
        a7.disabled = true;
        a8.checked = false;
        a8.disabled = true;
        a9.checked = false;
        a9.disabled = true;
      } else {
        a2.disabled = false;
        a3.disabled = false;
        a4.disabled = false;
        a5.disabled = false;
        a6.disabled = false;
        a7.disabled = false;
        a8.disabled = false;
        a9.disabled = false;
      }
    }
    
  });
</script>