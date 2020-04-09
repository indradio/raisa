<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-default" role="alert">
          <!-- Begin Content -->
          Sesuai dengan aturan pemerintah terkait situasi darurat nasional mengatasi pandemi Covid-19, karyawan yang tidak ke kantor diharapkan <strong>untuk tetap di rumah, tidak keluar rumah atau bahkan mudik</strong>.
          </br>
          </br>Untuk itu WINTEQ akan memantau dan memastikan karyawan mengikuti himbauan pemerintah. Karyawan diwajibkan melakukan absen yang mengirimkan lokasi realtime di 3 jendela waktu berikut:
          </br>
          </br>1. Check in antara 7.00-7.30
          </br>2. Istirahat antara 11.30-12.00
          </br>3. Check out antara 16.30-17.00
          </br>
          </br>Harap mengijinkan browser mengakses lokasi perangkat tiap kali diminta.
          <!-- End Content -->
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <form id="RegisterValidation" action="" method="">
          <div class="card ">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <!-- <i class="material-icons">location_on</i> -->
                <i class="material-icons">touch_app</i>
              </div>
              <!-- <h4 class="card-title">Your Location</h4> -->
              <h4 class="card-title">Kehadiran</h4>
            </div>
            <div class="card-body ">
              <div id="map" class="map" style="width:100%;height:240px;"></div>
              <p id="loc"></p>
              </br>
              <div class="form-group">
                <label for="lat" class="bmd-label-floating"> Latitude *</label>
                <input type="text" class="form-control" id="lat" name="lat" value=" " required="true" disabled="true" />
              </div>
              <div class="form-group">
                <label for="long" class="bmd-label-floating"> Longitude *</label>
                <input type="text" class="form-control" id="long" name="long" value=" " required="true" disabled="true" />
              </div>
              <div class="form-group">
                <label for="platform" class="bmd-label-floating"> Platform *</label>
                <input type="text" class="form-control" id="platform" name="platform" value=" " required="true" disabled="true" />
              </div>
              <div class="form-group">
                <label for="platform" class="bmd-label-floating"> Platform *</label>
                <input type="text" class="form-control RealServerTime" id="state" name="state" value=" " required="true" disabled="true" />
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
              <button type="submit" id="submit" class="btn btn-success">Clock In</button>
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
            <h4 class="card-title">Today History</h4>
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
                  <tr>
                    <td>
                      1
                    </td>
                    <td>
                      07:22
                    </td>
                    <td>
                      C/In
                    </td>
                    <td>
                      View
                    </td>
                  </tr>
                  <tr>
                    <td>
                      2
                    </td>
                    <td>
                      11:58
                    </td>
                    <td>
                      C/Rest
                    </td>
                    <td>
                      View
                    </td>
                  </tr>
                  <tr>
                    <td>
                      3
                    </td>
                    <td>
                      16:42
                    </td>
                    <td>
                      C/Out
                    </td>
                    <td>
                      View
                    </td>
                  </tr>
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

    // document.getElementById("state").value = dt;

    var x = document.getElementById("loc");

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      x.innerHTML = "Geolocation is not supported by this browser.";
    }

    function showPosition(position) {
      // x.innerHTML = "Latitude: " + position.coords.latitude +
      //   "<br>Longitude: " + position.coords.longitude;
      document.getElementById("lat").value = position.coords.latitude;
      document.getElementById("long").value = position.coords.longitude;


      lat = position.coords.latitude;
      lng = position.coords.longitude;

      var location = new google.maps.LatLng(lat, lng);

      var mapCanvas = document.getElementById('map');

      var mapOptions = {
        center: location,
        zoom: 16,

        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      var map = new google.maps.Map(mapCanvas, mapOptions);
      var image = 'https://raisa.winteq-astra.com/assets/img/iconmobil.png';
      var marker = new google.maps.Marker({
        position: location,
        map: map
        // icon: image
      });

      marker.setMap(map);
    }

    document.getElementById("platform").value = navigator.platform;

    window.setTimeout(function() {
      $(".alert").fadeTo(200, 0).slideUp(200, function() {
        $(this).remove();
      });
    }, 60000);

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

  var SyncTimeframe = 1000 * 60 * 60 * 3; // 3 Hours
  var LastSyncKey = 'LastSyncWithTimeServer';
  var TimeDiffKey = 'Local-Server-TimeDiff';

  var RetryMax = 3;
  var RetryCount = 0;
  var AcceptedDelay = 500;

  if (window.localStorage.getItem(LastSyncKey) == null) {
    window.localStorage.setItem(LastSyncKey, '' + (new Date(0)));
  }

  LastSync = new Date(window.localStorage.getItem(LastSyncKey));

  if (Math.abs((new Date()) - LastSync) > SyncTimeframe) {
    SyncTime();
  } else {
    ShowTime();
  }

  function SyncTime() {
    var StartTime = new Date();

    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("HEAD", "http://www.googleapis.com", true);
    xmlhttp.onreadystatechange = function() {

      if (xmlhttp.readyState == 4) {
        TimeDiff = new Date(xmlhttp.getResponseHeader("Date")) - (new Date()) + ((new Date()) - StartTime) / 2;

        if (++RetryCount < 3 && (new Date()) - StartTime > AcceptedDelay) {
          SyncTime();
        } else {
          window.localStorage.setItem(LastSyncKey, '' + (new Date()));
          window.localStorage.setItem(TimeDiffKey, TimeDiff);
          ShowTime();
        }

      }
    }
    xmlhttp.send(null);
  }

  function ShowTime() {
    // var AllNodes = document.getElementsByClassName("RealServerTime");
    var AllNodes = document.getElementById("state").value;

    var diff = parseInt(window.localStorage.getItem(TimeDiffKey), 10);

    // format Date and Time 
    var TimeToString = (new Date(Date.now() + diff)).toTimeString().split(' ')[0];

    for (var ipos = 0; ipos < AllNodes.length; ipos++) {
      AllNodes[ipos].innerHTML = TimeToString;
    }

    window.setTimeout(ShowTime, 1000);

  }
</script>