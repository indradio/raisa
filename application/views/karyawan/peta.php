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
                <i class="material-icons">map</i>
              </div>
              <!-- <h4 class="card-title">Your Location</h4> -->
              <h4 class="card-title">Peta</h4>
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
    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">account_box</i>
                        </div>
                        <h4 class="card-title">Data Karyawan</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!-- Here you can write extra buttons/actions for the toolbar -->
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($datakaryawan as $row) :
                                    ?>
                                        <tr>
                                            <td><?= $row['nama']; ?></td>
                                            <td><?= $row['loc']; ?></td>
                                            <td class="text-right">
                                            <?php if (empty($row['lat']) or empty($row['lng'])){ ?>
                                                <a href="#" class="btn btn-link btn-default btn-just-icon disabled"><i class="material-icons">directions</i></a>
                                            <?php }else{ ?>
                                                <a href="https://www.google.com/maps/search/?api=1&query=<?= $row['lat'] . ',' . $row['lng'];?>" target="_blank" class="btn btn-link btn-success btn-just-icon edit"><i class="material-icons">directions</i></a>
                                            <?php } ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
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
    <!-- <script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-ubIYpWmP5j_UGlt6B4xzUsjASRsmeo0&callback=initMap">
    </script> -->
    <script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHFISdyofTP6NPRE142yGJjZPa1Z2VbU4&callback=initMap">
    </script>