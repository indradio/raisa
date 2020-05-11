<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-default" role="alert">
          <!-- Begin Content -->
          Sesuai dengan Surat Keputusan No <strong>OO4/WTQ-HR/IV/2020</strong> tentang <strong>"Pengaturan Jam Kerja Karyawan pada bulan Ramadhan 1441 H"</strong>.
          </br>Berikut adalah perubahan jadwal absensi melalui RAISA.
          </br>
          </br><strong>1. Check in antara 06:30 - 07.30</strong>
          </br><strong>2. Istirahat antara 11.30 - 13.00</strong>
          </br><strong>3. Check out antara 16.00 - 18.00</strong>
          </br>
          </br>*Pastikan GPS smartphone kamu aktif dan pilih izinkan jika muncul peringatan saat membuka halaman.
          <!-- End Content -->
        </div>
      </div>
    </div>
    <?php
    $sudahIsi = $this->db->get_where('idcard', ['npk' => $this->session->userdata('npk')])->row_array();
    if (empty($sudahIsi)) {
    ?>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-danger">
              <div class="card-icon">
                <i class="material-icons">notification_important</i>
              </div>
              <h4 class="card-title">PAKTA INTEGRITAS KARYAWAN</h4>
            </div>
            <div class="card-body">
              Sudahkah kamu mengisi <strong>PAKTA INTEGRITAS KARYAWAN</strong>.
              </br>Jika belum, Klik link berikut : <a href="https://bit.ly/PaktaIntegritasWinteq" target="_blank">FORMULIR PAKTA INTEGRITAS KARYAWAN</a>
              </br>
              </br>
              <a href="<?= base_url('presensi/pik'); ?>" class="badge badge-warning">Jangan tampilkan lagi</a>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="row">
      <div class="col-md-6">
        <form id="timePrecense" class="form" method="post" action="<?= base_url('presensi/submit'); ?>">
          <div class="card ">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <!-- <i class="material-icons">location_on</i> -->
                <i class="material-icons">fingerprint</i>
              </div>
              <!-- <h4 class="card-title">Your Location</h4> -->
              <h4 class="card-title">Kehadiran</h4>
            </div>
            <div class="card-body ">
              <div id="map" class="map" style="width:100%;height:240px;"></div>
              <p id="location"></p>
              </br>
              <div class="form-group">
                <label for="vLoc" class="bmd-label-floating"> Location *</label>
                <textarea rows="3" class="form-control disabled" id="vLoc" name="vLoc" disabled> </textarea>
              </div>
              <div class="form-group">
                <label for="vLat" class="bmd-label-floating"> Latitude *</label>
                <input type="text" class="form-control" id="vLat" name="vLat" value=" " required="true" disabled="true" />
              </div>
              <div class="form-group">
                <label for="vLng" class="bmd-label-floating"> Longitude *</label>
                <input type="text" class="form-control" id="vLng" name="vLng" value=" " required="true" disabled="true" />
              </div>
              <div class="form-group">
                <label for="vState" class="bmd-label-floating"> State *</label>
                <input type="text" class="form-control" id="vState" name="vState" value="<?= $state; ?>" required="true" disabled="true" />
              </div>
              <div class="form-group">
                <label for="newstate" class="bmd-label-floating"> Work State *</label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="newstate" name="newstate" title="Silahkan Pilih" data-size="2" data-live-search="false" required>
                    <option value="WFH">WFH</option>
                    <option value="OFFDAY">OFF DAY</option>
                  </select>
              </div>
              <div class="form-group">
                <label for="time" class="bmd-label-floating"> Time *</label>
                <input type="text" class="form-control" id="time" name="time" value=" " required="true" disabled="true" />
              </div>
              <div class="form-group" hidden="true">
                <textarea rows="3" class="form-control" id="loc" name="loc"></textarea>
                <input type="text" class="form-control" id="lat" name="lat" required="true" />
                <input type="text" class="form-control" id="lng" name="lng" required="true" />
                <input type="text" class="form-control" id="state" name="state" value="<?= $state; ?>" required="true" />
                <input type="text" class="form-control" id="platform" name="platform" required="true" />
              </div>
              <div class="form-check mr-auto">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" id="check" value="" required>
                  <span class="form-check-sign">
                    <span class="check"></span>
                  </span>
                  <i>Dengan ini saya menyatakan telah memberikan lokasi dan waktu yang sesuai.</br>
                    Saya siap diproses secara hukum yang berlaku jika terbukti memanipulasi data yang saya berikan</i>
                </label>
              </div>
              <div class="category form-category">
              </div>
            </div>
            <div class="card-footer ml-auto">
              <?php
              if (date('H:i') >= '06:30' and date('H:i') <= '07:30') {
                echo '<button type="submit" id="submit" class="btn btn-success">Clock In</button>';
              } elseif (date('H:i') >= '11:30' and date('H:i') <= '13:00') {
                echo '<button type="submit" id="submit" class="btn btn-success">Rest Time</button>';
              } elseif (date('H:i') >= '16:00' and date('H:i') <= '18:00') {
                echo '<button type="submit" id="submit" class="btn btn-success">Clock Out</button>';
              } else {
                echo '<button type="submit" class="btn btn-default" disabled="false">Belum Waktunya</button>';
                echo '</div><div class="card-footer mr-auto">Kamu hanya bisa Clock In/Out di jendela waktu yang telah ditentukan.';
              }
              ?>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header card-header-icon card-header-rose">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Hari Ini</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    ID
                  </th>
                  <th>
                    Time
                  </th>
                  <th>
                    State
                  </th>
                  <th>
                    Location
                  </th>
                </thead>
                <tbody>
                  <?php
                  $this->db->where('year(time)', date('Y'));
                  $this->db->where('month(time)', date('m'));
                  $this->db->where('day(time)', date('d'));
                  $this->db->where('npk', $this->session->userdata('npk'));
                  $presenceToday = $this->db->get('presensi')->result_array();
                  foreach ($presenceToday as $i) : ?>
                    <tr>
                      <td>
                        <?= $i['id']; ?>
                      </td>
                      <td>
                        <?= date('H:i', strtotime($i['time'])); ?>
                      </td>
                      <td>
                        <?= $i['state']; ?>
                      </td>
                      <td>
                        <a href="https://www.google.com/maps/search/?api=1&query=<?= $i['lat'] . ',' . $i['lng']; ?>" target="_blank">View</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </div>
</div>

<script>
  $(document).ready(function() {
    var x = document.getElementById("location");

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      x.innerHTML = "Geolocation is not supported by this browser.";
    }

    function showPosition(position) {
      // x.innerHTML = "Latitude: " + position.coords.latitude +
      //   "<br>Longitude: " + position.coords.longitude;
      document.getElementById("lat").value = position.coords.latitude;
      document.getElementById("lng").value = position.coords.longitude;
      document.getElementById("vLat").value = position.coords.latitude;
      document.getElementById("vLng").value = position.coords.longitude;


      lat = position.coords.latitude;
      lng = position.coords.longitude;

      var xhr = new XMLHttpRequest();
      xhr.open("POST", 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&key=AIzaSyAHFISdyofTP6NPRE142yGJjZPa1Z2VbU4', true);

      //Send the proper header information along with the request
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      xhr.onreadystatechange = function() { // Call a function when the state changes.
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
          var myObj = JSON.parse(this.responseText);
          loc = myObj.results['0']['formatted_address'];
          document.getElementById("vLoc").value = loc;
          document.getElementById("loc").value = myObj.results['0']['formatted_address'];
        }
      }
      xhr.send();
      // xhr.send(new Int8Array()); 
      // xhr.send(element);

      var location = new google.maps.LatLng(lat, lng);
      var mapCanvas = document.getElementById('map');

      var mapOptions = {
        center: location,
        zoom: 16,

        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      var map = new google.maps.Map(mapCanvas, mapOptions);
      var marker = new google.maps.Marker({
        position: location,
        map: map
      });

      marker.setMap(map);
    };

    document.getElementById("platform").value = navigator.platform;

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

  var xmlHttp;

  function srvTime() {
    try {
      //FF, Opera, Safari, Chrome
      xmlHttp = new XMLHttpRequest();
    } catch (err1) {
      //IE
      try {
        xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
      } catch (err2) {
        try {
          xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
        } catch (eerr3) {
          //AJAX not supported, use CPU time.
          alert("AJAX not supported");
        }
      }
    }
    xmlHttp.open('HEAD', window.location.href.toString(), false);
    xmlHttp.setRequestHeader("Content-Type", "text/html");
    xmlHttp.send('');
    return xmlHttp.getResponseHeader("Date");
  }
  $(document).ready(function() {
    setInterval(function() {
      srvTime(st);
      var st = srvTime();
      var date = new Date(st);
      document.getElementById("time").value = date;
    }, 1000);

    window.setTimeout(function() {
      $(".alert").fadeTo(200, 0).slideUp(200, function() {
        $(this).remove();
      });
    }, 60000);
  });
</script>