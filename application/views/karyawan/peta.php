<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
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
              <div id="map" class="map" style="width:100%;height:640px;"></div>
              <!-- <p id="location"></p> -->
              </br>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- end row -->
  </div>
</div>
<script>

</script>
<script>
     function initMap() {
      var center = {lat: -6.5034587, lng: 106.8379949};
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: center
      });
      var infowindow =  new google.maps.InfoWindow({});
      var marker, count;
      var pin = 'https://raisa.winteq-astra.com/assets/img/navigation.png';
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          myObj = JSON.parse(this.responseText);
          // document.getElementById("location").innerHTML = myObj.name;
          for (count = 0; count < myObj.length; count++) {
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(myObj[count][1], myObj[count][2]),
          map: map,
          icon: pin,
          title: myObj[count][0]
        });
    google.maps.event.addListener(marker, 'click', (function (marker, count) {
          return function () {
            infowindow.setContent(myObj[count][0]);
            infowindow.open(map, marker);
          }
        })(marker, count));
      }

        }
      };

      xmlhttp.open("GET", "<?= site_url('karyawan/jsondata'); ?>", true);
      xmlhttp.send();

    
        
    }
    </script>
    <script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-ubIYpWmP5j_UGlt6B4xzUsjASRsmeo0&callback=initMap">
    </script>
    <!-- <script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHFISdyofTP6NPRE142yGJjZPa1Z2VbU4&callback=initMap">
    </script> -->