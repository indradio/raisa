<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="alert alert-info alert-with-icon" data-notify="container">
      <i class="material-icons" data-notify="icon">notifications</i>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="material-icons">close</i>
      </button>
      <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
      <span data-notify="message">Kategori Absen :</span>
      <span data-notify="message">1. SHIFT Untuk kamu yang kerja normal, langsung dari/ke Customer</span>
      <span data-notify="message">2. WFH Untuk kamu yang saat ini <strong>KERJA</strong> dari rumah</span>
      <span data-notify="message">3. OFF DAY Untuk kamu yang harus standby di rumah</span>
      <span data-notify="message">4. ISOMAN Untuk kamu yang sedang berjuang melawan COVID-19, Semangat!</span>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="card card-product">
          <div class="card-header card-header-image" data-header-animation="true">
            <?php if ($workstate == 'not found'){ ?>
              <a href="#" class="btn btn-link" role="button" data-toggle="modal" data-target="#clockTime" data-state="C/In" data-btnstate="Clock In">
                <img class="img" src="<?= base_url(); ?>/assets/img/clock-in.jpg">
              </a>
            <?php }else{ ?>
              <a href="#" class="btn btn-link" role="button" data-toggle="modal" data-target="#clockTime" data-state="C/Out" data-btnstate="Clock Out">
                <img class="img" src="<?= base_url(); ?>/assets/img/clock-out.jpg">
              </a>
            <?php } ?>
          </div>
          <div class="card-body">
            <div class="card-actions text-center">
              <button type="button" class="btn btn-danger btn-link fix-broken-card">
                <i class="material-icons">build</i> Fix Header!
              </button>
              <!-- <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="View">
                <i class="material-icons">art_track</i>
              </button>
              <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                <i class="material-icons">edit</i>
              </button>
              <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Remove">
                <i class="material-icons">close</i>
              </button> -->
            </div>
            <h4 class="card-title">
            <?php 
            if ($workstate == 'not found'){ ?>
              <a href="#" data-toggle="modal" data-target="#clockTime" data-state="C/In" data-btnstate="Clock In">Clock In</a>
            <?php }else{ ?>
              <a href="#" data-toggle="modal" data-target="#clockTime" data-state="C/Out" data-btnstate="Clock Out">Clock Out</a>
            <?php } ?>
            </h4>
            <!-- <div class="card-description">
              The place is close to Metro Station and bus stop just 2 min by walk and near to "Naviglio" where you can enjoy the night life in London, UK.
            </div> -->
          </div>
          <!-- <div class="card-footer">
            <div class="price">
              <h4>$1.119/night</h4>
            </div>
            <div class="stats">
              <p class="card-category"><i class="material-icons">place</i> London, UK</p>
            </div>
          </div> -->
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-text card-header-primary">
            <div class="card-text">
              <h4 class="card-title">Last Attendance</h4>
              <p class="card-category"><?= $this->session->userdata('nama'); ?></p>
            </div>
          </div>
          <div class="card-body">
              <div id="calendarPresensi"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12" hidden>
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
              <p id="browser"></p>
              </br>
              <div class="form-group" hidden="true">
                <input type="text" class="form-control" id="lat" name="lat" required="true" />
                <input type="text" class="form-control" id="lng" name="lng" required="true" />
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- end row -->
  </div>
</div>

<div class="modal fade" id="clockTime" tabindex="-1" role="dialog" aria-labelledby="clockTimeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clockTimeLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('presensi/submit'); ?>
                <div class="modal-body">
                    <div class="form-group" hidden>
                        <input type="text" class="form-control" id="state" name="state" required="true" />
                        <input type="text" class="form-control" id="workstate" name="workstate" />
                        <input type="text" class="form-control" id="latitude" name="latitude" required="true" />
                        <input type="text" class="form-control" id="longitude" name="longitude" required="true" />
                        <textarea rows="3" class="form-control" id="location" name="location" required="true"></textarea>
                        <input type="text" class="form-control" id="platform" name="platform" required="true" />
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div id="modalMap" class="map" style="width:100%;height:380px;"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 ml-auto mr-auto">
                        <div class="form-group">
                          <label for="loc" class="bmd-label-floating"> Lokasi *</label>
                          <textarea rows="3" class="form-control" id="loc" name="loc" disabled> </textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 ml-auto mr-auto">
                        <div class="form-group has-default">  
                          <div class="btn-group-toggle" data-toggle="buttons">
                              <!-- <label class="btn btn-default" id="labelOption1" style="width: 100%;">
                                      <input type="radio" name="options" id="option1" autocomplete="off" value="SHIFT1" required>SHIFT1
                                  </label> -->
                              <label class="btn btn-default" id="labelOption2" style="width: 100%;">
                                      <input type="radio" name="options" id="option2" autocomplete="off" value="SHIFT2" required>SHIFT2 (07:00-16:30)
                                  </label>
                              <!-- <label class="btn btn-default" id="labelOption3" style="width: 100%;">
                                      <input type="radio" name="options" id="option3" autocomplete="off" value="SHIFT3" required>SHIFT3 (16:30-00:00)
                                  </label> -->
                              <label class="btn btn-default" id="labelOption4" style="width: 100%;">
                                      <input type="radio" name="options" id="option4" autocomplete="off" value="WFH" required>WORK FROM HOME
                                  </label>
                              <label class="btn btn-default" id="labelOption5" style="width: 100%;">
                                      <input type="radio" name="options" id="option5" autocomplete="off" value="OFF" required>OFF DAY
                                  </label>
                              <label class="btn btn-default" id="labelOption6" style="width: 100%;">
                                      <input type="radio" name="options" id="option6" autocomplete="off" value="ISOMAN" required>ISOMAN / QUARANTINE
                                  </label>
                              <!-- <label class="btn btn-info">
                                      <input type="radio" name="options" id="option4" autocomplete="off" value="D" required>D
                                  </label>
                              <label class="btn btn-info">
                                      <input type="radio" name="options" id="option5" autocomplete="off" value="E" required>E
                                  </label> -->
                          </div>   
                        </div>
                      </div>
                    </div>
                    </p>
                    <div class="row">
                      <div class="col-md-12 ml-auto mr-auto">
                        <div class="form-group">
                          <label for="note" class="bmd-label-floating"> Catatan * <small><i>(yang akan/sudah kamu kerjakan hari ini atau kondisi kesehatan kamu)</i></small></label>
                          <textarea rows="5" class="form-control" id="note" name="note" required="true"></textarea>
                        </div>
                      </div>
                    </div>
                    </p>
                    <div class="form-check mr-auto">
                      <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" id="check" value="" required>
                        <span class="form-check-sign">
                          <span class="check"></span>
                        </span>
                        <i><small>Dengan ini saya menyatakan telah memberikan lokasi dan waktu yang sesuai.</br>
                          Saya siap diproses secara hukum yang berlaku jika terbukti memanipulasi data yang saya berikan</small></i>
                      </label>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <div class="col-md-10 mr-auto">
                      <input type="text" class="form-control disabled" id="time" name="time" />
                    </div>
                    <div class="ml-auto">
                      <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button> -->
                      <button type="submit" id="submit" class="btn btn-success">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    var x = document.getElementById("browser");

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
      // document.getElementById("vLat").value = position.coords.latitude;
      // document.getElementById("vLng").value = position.coords.longitude;
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
          document.getElementById("loc").value = myObj.results['0']['formatted_address'];
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

  $(document).ready(function() {

    $('#clockTime').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var state = button.data('state')
        var btnstate = button.data('btnstate')
        var modal = $(this)
        document.getElementById("clockTimeLabel").innerHTML= btnstate ;
        modal.find('.modal-body input[name="state"]').val(state)
        document.getElementById("submit").innerHTML= btnstate ;

        // lat = position.coords.latitude;
        // lng = position.coords.longitude;

        // var xhr = new XMLHttpRequest();
        // xhr.open("POST", 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&key=AIzaSyAHFISdyofTP6NPRE142yGJjZPa1Z2VbU4', true);

        // //Send the proper header information along with the request
        // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // xhr.onreadystatechange = function() { // Call a function when the state changes.
        //   if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        //     var myObj = JSON.parse(this.responseText);
        //     loc = myObj.results['0']['formatted_address'];
        //     document.getElementById("loc").value = myObj.results['0']['formatted_address'];
        //     document.getElementById("location").value = myObj.results['0']['formatted_address'];
        //   }
        // }
        // xhr.send();
        // xhr.send(new Int8Array()); 
        // xhr.send(element);

        var location = new google.maps.LatLng(lat, lng);
        var mapCanvas = document.getElementById('modalMap');

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
    })

    // var labelOption1 = document.getElementById('labelOption1');
    var labelOption2 = document.getElementById('labelOption2');
    // var labelOption3 = document.getElementById('labelOption3');
    var labelOption4 = document.getElementById('labelOption4');
    var labelOption5 = document.getElementById('labelOption5');
    var labelOption6 = document.getElementById('labelOption6');

    // var option1 = document.getElementById('option1');
    // // when unchecked or checked, run the function
    // option1.onchange = function() {
    //   if (this.checked) {
    //     document.getElementById('workstate').value = 'NORMAL';
    //     labelOption1.style.background = '#00aec5';
    //     labelOption2.style.background = '#999999';
    //     labelOption3.style.background = '#999999';
    //     labelOption4.style.background = '#999999';
    //     labelOption5.style.background = '#999999';
    //     labelOption6.style.background = '#999999';
    //   }
    // }

    var option2 = document.getElementById('option2');
    // when unchecked or checked, run the function
    option2.onchange = function() {
      if (this.checked) {
        document.getElementById('workstate').value = 'SHIFT2';
        // labelOption1.style.background = '#999999';
        labelOption2.style.background = '#00aec5';
        // labelOption3.style.background = '#999999';
        labelOption4.style.background = '#999999';
        labelOption5.style.background = '#999999';
        labelOption6.style.background = '#999999';
      }
    }

    // var option3 = document.getElementById('option3');
    // // when unchecked or checked, run the function
    // option3.onchange = function() {
    //   if (this.checked) {
    //     document.getElementById('workstate').value = 'SHIFT3';
    //     // labelOption1.style.background = '#999999';
    //     labelOption2.style.background = '#999999';
    //     labelOption3.style.background = '#00aec5';
    //     labelOption4.style.background = '#999999';
    //     labelOption5.style.background = '#999999';
    //     labelOption6.style.background = '#999999';
    //   }
    // }

    var option4 = document.getElementById('option4');
    // when unchecked or checked, run the function
    option4.onchange = function() {
      if (this.checked) {
        document.getElementById('workstate').value = 'WFH';
        // labelOption1.style.background = '#999999';
        labelOption2.style.background = '#999999';
        // labelOption3.style.background = '#999999';
        labelOption4.style.background = '#00aec5';
        labelOption5.style.background = '#999999';
        labelOption6.style.background = '#999999';
      }
    }

    var option5 = document.getElementById('option5');
    // when unchecked or checked, run the function
    option5.onchange = function() {
      if (this.checked) {
        document.getElementById('workstate').value = 'OFF';
        // labelOption1.style.background = '#999999';
        labelOption2.style.background = '#999999';
        // labelOption3.style.background = '#999999';
        labelOption4.style.background = '#999999';
        labelOption5.style.background = '#00aec5';
        labelOption6.style.background = '#999999';
      }
    }

    var option6 = document.getElementById('option6');
    // when unchecked or checked, run the function
    option6.onchange = function() {
      if (this.checked) {
        document.getElementById('workstate').value = 'ISOMAN';
        // labelOption1.style.background = '#999999';
        labelOption2.style.background = '#999999';
        // labelOption3.style.background = '#999999';
        labelOption4.style.background = '#999999';
        labelOption5.style.background = '#999999';
        labelOption6.style.background = '#00aec5';
      }
    }

    setInterval(function() {
      var date = new Date();
      document.getElementById("time").value = date;
    }, 1000);

    window.setTimeout(function() {
      $(".alert").fadeTo(200, 0).slideUp(200, function() {
        $(this).remove();
      });
    }, 60000);
  });

  $(document).ready(function() {
        var cPresensi = $('#calendarPresensi');

        today = new Date();
        y = today.getFullYear();
        m = today.getMonth();
        d = today.getDate();

        cPresensi.fullCalendar({
            timeZone: 'asia/jakarta', // the default (unnecessary to specify)
            viewRender: function(view, element) {
                // We make sure that we activate the perfect scrollbar when the view isn't on Month
                if (view.name != 'month') {
                    $(element).find('.fc-scroller').perfectScrollbar();
                }
            },
            header: {
                left: 'month,agendaWeek,agendaDay',
                center: 'title',
                right: 'prev,next,today'
            },

            firstDay: 1,
            defaultDate: today,
            businessHours: [{
                default: false,
                // days of week. an array of zero-based day of week integers (0=Sunday)
                dow: [1, 2, 3, 4, 5], // Monday - Friday
                start: '00:00', // a start time 
                end: '23:59' // an end time 
            }],

            views: {
                month: { // name of view
                    titleFormat: 'MMMM YYYY'
                    // other view-specific options here
                },
                week: {
                    titleFormat: " MMMM D YYYY"
                },
                day: {
                    titleFormat: 'D MMM, YYYY'
                }
            },

            selectable: true,
            selectHelper: true,
            editable: true,

            eventSources: [{
                    events: function(start, end, timezone, callback) {
                        $.ajax({
                            url: '<?php echo base_url('presensi/GET_MY_IN') ?>',
                            dataType: 'json',
                            success: function(msg) {
                                var events = msg.events;
                                callback(events);
                            }
                        });
                    }
                },
                
            ],
            eventLimit: true, // allow "more" link when too many events
        });
    });
</script>