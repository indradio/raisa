<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-text card-header-warning">
            <div class="card-text">
              <h4 class="card-title">Last Attendance</h4>
              <p class="card-category"><?= $this->session->userdata('nama'); ?></p>
            </div>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-warning">
                <th>State</th>
                <th>Time</th>
              </tr></thead>
              <tbody>
              <?php
                  $this->db->where('year(time)',date("Y"));
                  $this->db->where('month(time)',date("m"));
                  $this->db->where('day(time)',date("d"));
                  $this->db->order_by('time DESC');
                  $presensi = $this->db->get('presensi')->result_array();
                  foreach ($presensi as $row) :
              ?>
                <tr>
                  <td><?= $row['state']; ?></td>
                  <td><?= date("H:i", strtotime($row['time'])); ?></td>
                </tr>
               <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <form id="timePrecense" class="form" method="post" action="<?= base_url('presensi/submit'); ?>">
          <div class="card ">
            <div class="card-header card-header-text card-header-icon card-header-info">
              <div class="card-text">
                <h4 class="card-title"><?= $flag; ?></h4>
                <p class="card-category"><?= date("d F Y") ; ?></p>
                <h3 class="card-title" id="timestamp"></h3>
              </div>
            </div>
            <div class="card-body">
              <div id="map" class="map" style="width:100%;height:240px;"></div>
              <p id="loc"></p>
              </br>
              <div class="form-group" hidden="true">
                <textarea rows="3" class="form-control" id="location" name="location"></textarea>
                <input type="text" class="form-control" id="latitude" name="latitude" required="true" />
                <input type="text" class="form-control" id="longitude" name="longitude" required="true" />
                <input type="text" class="form-control" id="platform" name="platform" required="true" />
              </div>
              <div class="form-group">
                <label for="vLoc" class="bmd-label-floating"> Location *</label>
                <textarea rows="3" class="form-control disabled" id="vLoc" name="vLoc" disabled> </textarea>
              </div>
              <!-- <div class="form-group">
                <label for="vState" class="bmd-label-floating"> State *</label>
                <input type="text" class="form-control" id="vState" name="vState" value="Clock In" required="true" disabled="true" />
              </div> -->
              <?php if ($workstate == 'not found'){ ?>
              <div class="form-group">
                <label for="workstate" class="bmd-label-floating"> Work State *</label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="workstate" name="workstate" title="Silahkan Pilih" data-size="7" data-live-search="false" onchange="workstateSelect(this);" required>
                  <option value="SHIFT2">SHIFT</option>
                  <option value="WFH">WORK FROM HOME</option>
                  <option value="OFF">OFF DAY</option>
                  <option value="ISOMAN">ISOLASI MANDIRI</option>
                </select>
              </div>
              <div class="form-group" style="display:none;" id="selectShift">
                <label for="shift" class="bmd-label-floating"> Shift *</label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="shift" name="shift" title="Silahkan Pilih" data-size="7" data-live-search="false" required>
                  <option value="SHIFT1" disabled>SHIFT 1 00:30 - 07:30</option>
                  <option value="SHIFT2" selected>SHIFT 2 07:30 - 16:30</option>
                  <option value="SHIFT3a" disabled>SHIFT 3a 16:00 - 00:00</option>
                  <option value="SHIFT3b" disabled>SHIFT 3b 16:30 - 00:30</option>
                </select>
                <!-- </p>
                <div class="togglebutton">
                  <label>
                    <input type="checkbox" id="ta" name="ta">
                    <span class="toggle"></span>
                    Dinas Luar Menginap
                  </label>
                </div> -->
              </div>
              <?php } else { echo $workstate; ?>
                <input type="text" class="form-control" id="workstate" name="workstate" value="<?= $workstate ; ?>" hidden="true" />
              <?php } ?>
              <div class="form-group">
              </div>
              <div class="form-group">
                <label for="description" class="bmd-label-floating"> Jelaskan aktivitas / kondisi kesehatan kamu *</label>
                <textarea rows="3" class="form-control" id="description" name="description" required="true"></textarea>
              </div>
              <!-- <div class="form-group">
                <label for="time" class="bmd-label-floating"> Time *</label>
                <input type="text" class="form-control" id="time" name="time" value=" " required="true" disabled="true" />
              </div> -->
              <?php if ($flag != 'notime'){ ?>
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
              <?php }else{ ?>
                <div class="form-check mr-auto">
                <label class="form-check-label">
                  <i> Check In  : <b>07:00 s/d 08:30</b></br>
                      Rest Time : <b>11:30 s/d 13:00</b></br>
                      Check Out : <b>16:00 s/d 17:00</b></br>
                      Jangan lewatkan setiap jendela waktu ya!
                  </i>
                </label>
              </div>
              <?php } ?>
            </div>
            <div class="card-footer ml-auto">
              <?php if ($flag != 'notime'){ ?>
                <button type="submit" id="submit" class="btn btn-success" disabled="true">Submit</button>
              <?php } ?>
            </div>
          </div>
        </form>
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
      // x.innerHTML = "Latitude: " + position.coords.latitude +
      //   "<br>Longitude: " + position.coords.longitude;
      document.getElementById("latitude").value = position.coords.latitude;
      document.getElementById("longitude").value = position.coords.longitude;


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
          document.getElementById("location").value = myObj.results['0']['formatted_address'];
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

  function workstateSelect(valueSelect)
            {
                var val = valueSelect.options[valueSelect.selectedIndex].value;
                document.getElementById("selectShift").style.display = val == 'SHIFT2' ? "block" : 'none';
            }
            $('#workstate').change(function(){
                var workstate = $('#workstate').val();
                        if(workstate == "SHIFT2"){
                          $('#shift').prop('disabled', false);
                          $('#ta').prop('disabled', false);
                          $('#shift').prop('required', true);
                        }
                        else{
                          $('#shift').prop('disabled', true);
                          $('#ta').prop('disabled', true);
                          $('#shift').prop('required', false);
                        }
                })

  $(document).ready(function() {
    setInterval(function() {
      srvTime(st);
      var st = srvTime();
      var date = new Date(st);
      // document.getElementById("time").value = date;

      var days = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];

      var hour = date.getHours();
      var minute = date.getMinutes();
      var second = date.getSeconds();
      document.getElementById("timestamp").innerHTML  = hour + ":" + minute+ ":" + second;
      document.getElementById("timestamp").innerHTML  = date.toTimeString();
    }, 1000);

    window.setTimeout(function() {
      $(".alert").fadeTo(200, 0).slideUp(200, function() {
        $(this).remove();
      });
    }, 60000);
  });
</script>