<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-default" role="alert">
          <!-- Begin Content -->
          ⚠️<strong>WAJIB BACA SEBELUM MENGISI FORM</strong>⚠️
          </p>Tindakan bila ada yang terisi "Ya"
          </p><strong>Pernyataan A1-A3 (Kondisi Kesehatan)</strong>
          </br>1. Periksa ke klinik tingkat pertama, ikuti protokol klinik.
          </br>2. Lapor ke Atasan sampai Manager.
          </p><strong>Pernyataan B1-B7 (Risiko Penularan)</strong>
          </br>1. Lapor ke Atasan sampai Manager.
          </br>2. Jangan masuk kerja di tanggal 2 Juni 2020 sampai ada instruksi dari Managernya.
          </p><strong>Catatan</strong>
          </br>1. Bila ada yang terisi "Ya" dari quesionare ini, maka Karyawan harus segera menginformasikan ke atasannya (sampai Manager) di hari tersebut.
          </br>2. Form ini berlaku untuk semua orang yang bekerja di lingkungan WINTEQ.
          </br>3. Tanpa form ini Karyawan tidak diperkenankan masuk di hari kerja setelah Libur Lebaran.
          <!-- End Content -->
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <form id="timePrecense" class="form" method="post" action="<?= base_url('dirumahaja/submit'); ?>">
          <div class="card ">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">local_hospital</i>
              </div>
              <h4 class="card-title">FORM PEDULI KESEHATAN KARYAWAN WINTEQ SELAMA LIBUR LEBARAN</h4>
            </div>
            <div class="card-body ">
              <div class="progress" style="width: 100%">
                <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="1"></div>
              </div>
              <div class="form-group">
                <label class="bmd-label-floating">
                  <h4><b>A. Kondisi Kesehatan</b></h4>
                </label>
              </div>
              <div class="form-group">
                <label for="a1" class="bmd-label-floating">A1. Kondisi kesehatan selama libur lebaran <b>(Demam/Pilek/Influenza)</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="a1" name="a1" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA</option>
                  <option value="TIDAK">TIDAK</option>
                </select>
              </div>
              <div class="form-group">
                <label for="a2" class="bmd-label-floating">A2. Kondisi kesehatan selama libur lebaran <b>(Batuk/Suara serak/Demam)</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="a2" name="a2" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA</option>
                  <option value="TIDAK">TIDAK</option>
                </select>
              </div>
              <div class="form-group">
                <label for="a3" class="bmd-label-floating">A3. Kondisi kesehatan selama libur lebaran <b>(Sesak nafas/Nafas pendek)</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="a3" name="a3" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA</option>
                  <option value="TIDAK">TIDAK</option>
                </select>
              </div>
              </br>
              <div class="form-group">
                <label class="bmd-label-floating">
                  <h4><b>B. Risiko Penularan</b></h4>
                </label>
              </div>
              <div class="form-group">
                <label for="b1" class="bmd-label-floating">B1. Pernah berinteraksi dengan <b>Pasien Positif, PDP, ODP</b> ataupun <b>Orang yang sedang menjalani Isolasi Mandiri COVID-19</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="b1" name="b1" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA, PERNAH</option>
                  <option value="TIDAK">TIDAK PERNAH</option>
                </select>
              </div>
              <div class="form-group">
                <label for="b2" class="bmd-label-floating">B2. Pernah berkunjung ke rumah keluarga <b>Pasien Positif, PDP, ODP</b> ataupun <b>Orang yang sedang menjalani Isolasi Mandiri COVID-19</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="b2" name="b2" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                  <option value="YA">YA, PERNAH</option>
                  <option value="TIDAK">TIDAK PERNAH</option>
                </select>
              </div>
              <div class="form-group">
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
              </div>
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
  });
</script>