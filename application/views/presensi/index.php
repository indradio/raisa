<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
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
              <h4 class="card-title">Presensi</h4>
            </div>
            <div class="card-body ">
              <div id="map" class="map" style="width:100%;height:380px;"></div>
              <p id="loc"></p>
              </br>
              <div class="form-group">
                <label for="exampleEmail" class="bmd-label-floating"> Nama *</label>
                <input type="text" class="form-control" id="exampleEmail" value="<?= $karyawan['nama']; ?>" required="true">
              </div>
              <div class="form-group">
                <label for="examplePassword" class="bmd-label-floating"> Tanggal *</label>
                <input type="text" class="form-control" id="examplePassword" value="<?= date('d M Y'); ?>" required="true" name="password">
              </div>
              <div class="form-group">
                <label for="examplePassword1" class="bmd-label-floating"> Jam *</label>
                <input type="text" class="form-control" id="examplePassword1" value="<?= date('h:i'); ?>" required="true" equalTo="#examplePassword" name="password_confirmation">
              </div>
              <div class="category form-category">* Required fields</div>
            </div>
            <div class="card-footer text-right">
              <div class="form-check mr-auto">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" value="" required> Presensi saya bukan tipu-tipu
                  <span class="form-check-sign">
                    <span class="check"></span>
                  </span>
                </label>
              </div>
              <button type="submit" class="btn btn-rose">Clock In</button>
            </div>
          </div>
        </form>
      </div>
      <!-- <div class="col-md-6">
        <form id="RegisterValidation" action="" method="">
          <div class="card ">
            <div class="card-header card-header-rose card-header-icon">
              <div class="card-icon">
                <i class="material-icons">touch_app</i>
              </div>
              <h4 class="card-title">Presensi</h4>
            </div>
            <div class="card-body ">
              <div class="form-group">
                <label for="exampleEmail" class="bmd-label-floating"> Nama *</label>
                <input type="text" class="form-control" id="exampleEmail" value="<?= $karyawan['nama']; ?>" required="true">
              </div>
              <div class="form-group">
                <label for="examplePassword" class="bmd-label-floating"> Tanggal *</label>
                <input type="text" class="form-control" id="examplePassword" value="<?= date('d M Y'); ?>" required="true" name="password">
              </div>
              <div class="form-group">
                <label for="examplePassword1" class="bmd-label-floating"> Jam *</label>
                <input type="text" class="form-control" id="examplePassword1" value="<?= date('h:i'); ?>" required="true" equalTo="#examplePassword" name="password_confirmation">
              </div>
              <div class="category form-category">* Required fields</div>
            </div>
            <div class="card-footer text-right">
              <div class="form-check mr-auto">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" value="" required> Presensi saya bukan tipu-tipu
                  <span class="form-check-sign">
                    <span class="check"></span>
                  </span>
                </label>
              </div>
              <button type="submit" class="btn btn-rose">Clock In</button>
            </div>
          </div>
        </form>
      </div> -->
    </div>
    <!-- end row -->
  </div>
</div>

<script>
  $(document).ready(function() {
    var x = document.getElementById("loc");


    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      x.innerHTML = "Geolocation is not supported by this browser.";
    }

    function showPosition(position) {
      x.innerHTML = "Latitude: " + position.coords.latitude +
        "<br>Longitude: " + position.coords.longitude;


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
        icon: image
      });

      marker.setMap(map);
    }
  });
</script>