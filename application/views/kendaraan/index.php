<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title"><?= $k4['nama']; ?> -
                        <small class="description"><?= $k4['nopol']; ?></small>
                        </h4>
                    </div>
                    <div class="card-body ">
                        <ul class="nav nav-pills nav-pills-warning" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#<?= $k4['id']; ?>" role="tablist">
                                <?= $k4['nama']; ?>
                                </a>
                            </li>     
                            <!-- <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#<?= $k4['nama']; ?>" role="tablist">
                                Details
                                </a>
                            </li>      -->
                        </ul>
                        <div class="tab-content tab-space">
                        <div class="tab-pane active" id="<?= $k4['id']; ?>">
                            <div class="row">
                                    <div class="col-md-12">
                                        <div id="k4_map" class="map" style="width:100%;height:380px;"></div>
                                    </div>
                                </div>
                            <div class="row">
                                    <label class="col-md-3 col-form-label">Device ID</label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="k4_device_id" id="k4_device_id" value="<?= $k4['device_id']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                    <label class="col-md-3 col-form-label">Nomor Polisi</label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="k4_nopol" id="k4_nopol" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Lokasi</label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                        <textarea rows="3" class="form-control disabled" name="k4_lokasi" id="k4_lokasi" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Ignition</label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="k4_ignition" id="k4_ignition" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="<?= $k4['nama']; ?>">
                                Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.
                                <br />
                                <br />Dramatically maintain clicks-and-mortar solutions without functional solutions.
                            </div>
                            <div class="tab-pane" id="link3">
                                Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                                <br />
                                <br />Dynamically innovate resource-leveling customer service for state of the art customer service.
                            </div>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-6-->
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title"><?= $k5['nama']; ?> -
                        <small class="description"><?= $k5['nopol']; ?></small>
                        </h4>
                    </div>
                    <div class="card-body ">
                        <ul class="nav nav-pills nav-pills-warning" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#<?= $k5['nama']; ?>" role="tablist">
                                <?= $k5['nama']; ?>
                                </a>
                            </li>     
                            <!-- <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#<?= $k5['nama']; ?>data" role="tablist">
                                Details
                                </a>
                            </li>      -->
                        </ul>
                        <div class="tab-content tab-space">
                        <div class="tab-pane active" id="<?= $k5['nama']; ?>">
                            <div class="row">
                                    <div class="col-md-12">
                                        <div id="k5_map" class="map" style="width:100%;height:380px;"></div>
                                    </div>
                                </div>
                            <div class="row">
                                    <label class="col-md-3 col-form-label">Device ID</label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="k5_device_id" id="k5_device_id" value="<?= $k5['device_id']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                    <label class="col-md-3 col-form-label">Nomor Polisi</label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="k5_nopol" id="k5_nopol" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Lokasi</label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                        <textarea rows="3" class="form-control disabled" name="k5_lokasi" id="k5_lokasi" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Ignition</label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="k5_ignition" id="k5_ignition" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="<?= $k5['nama']; ?>data">
                                Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.
                                <br />
                                <br />Dramatically maintain clicks-and-mortar solutions without functional solutions.
                            </div>
                            <div class="tab-pane" id="link3">
                                Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                                <br />
                                <br />Dynamically innovate resource-leveling customer service for state of the art customer service.
                            </div>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-6-->
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title"><?= $k6['nama']; ?> -
                        <small class="description"><?= $k6['nopol']; ?></small>
                        </h4>
                    </div>
                    <div class="card-body ">
                        <ul class="nav nav-pills nav-pills-warning" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#<?= $k6['nama']; ?>" role="tablist">
                                <?= $k6['nama']; ?>
                                </a>
                            </li>     
                            <!-- <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#<?= $k6['nama']; ?>data" role="tablist">
                                Details
                                </a>
                            </li>      -->
                        </ul>
                        <div class="tab-content tab-space">
                        <div class="tab-pane active" id="<?= $k6['nama']; ?>">
                            <div class="row">
                                    <div class="col-md-12">
                                        <div id="k6_map" class="map" style="width:100%;height:380px;"></div>
                                    </div>
                                </div>
                            <div class="row">
                                    <label class="col-md-3 col-form-label">Device ID</label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="k6_device_id" id="k6_device_id" value="<?= $k6['device_id']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                    <label class="col-md-3 col-form-label">Nomor Polisi</label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="k6_nopol" id="k6_nopol" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Lokasi</label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                        <textarea rows="3" class="form-control disabled" name="k6_lokasi" id="k6_lokasi" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Ignition</label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="k6_ignition" id="k6_ignition" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="<?= $k6['nama']; ?>data">
                                Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.
                                <br />
                                <br />Dramatically maintain clicks-and-mortar solutions without functional solutions.
                            </div>
                            <div class="tab-pane" id="link3">
                                Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                                <br />
                                <br />Dynamically innovate resource-leveling customer service for state of the art customer service.
                            </div>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-6-->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<!-- JS K4 -->
<script>
    $(document).ready(function(){
      
        var id = document.getElementById("k4_device_id").value // Extract info from data-* attributes

        var xhr = new XMLHttpRequest();
        xhr.open("POST", 'https://gps.intellitrac.co.id/apis/tracking/realtime.php', true);

        //Send the proper header information along with the request
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() { // Call a function when the state changes.
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                var myObj = JSON.parse(this.responseText);
                
                if (id){
                x = myObj.data[id]['device_info']['name'];
                y = myObj.data[id]['realtime']['location'];
                z = myObj.data[id]['realtime']['ignition_status'];
                lat = myObj.data[id]['realtime']['latitude'];
                lng = myObj.data[id]['realtime']['longitude'];
                document.getElementById("k4_nopol").value = x;
                document.getElementById("k4_lokasi").value = y;
                document.getElementById("k4_ignition").value = z;
                // Request finished. Do processing here.
                }else{
                document.getElementById("k4_nopol").value = null;
                document.getElementById("k4_lokasi").value = null;
                document.getElementById("k4_ignition").value = null;
                lat = null;
                lng = null;
                }

                var location = new google.maps.LatLng(lat, lng);

                var mapCanvas = document.getElementById('k4_map');

                var mapOptions = {
                    center: location,
                    zoom: 18,

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
        }
    
        xhr.send("username=winteq&password=winteq123&devices=2019110056%3B2019110057%3B2019110055");
    
        setInterval(function() { 
            var id = document.getElementById("k4_device_id").value // Extract info from data-* attributes

            var xhr = new XMLHttpRequest();
            xhr.open("POST", 'https://gps.intellitrac.co.id/apis/tracking/realtime.php', true);

            //Send the proper header information along with the request
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() { // Call a function when the state changes.
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    var myObj = JSON.parse(this.responseText);
                    
                    if (id){
                    x = myObj.data[id]['device_info']['name'];
                    y = myObj.data[id]['realtime']['location'];
                    z = myObj.data[id]['realtime']['ignition_status'];
                    lat = myObj.data[id]['realtime']['latitude'];
                    lng = myObj.data[id]['realtime']['longitude'];
                    document.getElementById("k4_nopol").value = x;
                    document.getElementById("k4_lokasi").value = y;
                    document.getElementById("k4_ignition").value = z;
                    // Request finished. Do processing here.
                    }else{
                    document.getElementById("k4_nopol").value = null;
                    document.getElementById("k4_lokasi").value = null;
                    document.getElementById("k4_ignition").value = null;
                    lat = null;
                    lng = null;
                    }

                    var location = new google.maps.LatLng(lat, lng);

                    var mapCanvas = document.getElementById('k4_map');

                    var mapOptions = {
                        center: location,
                        zoom: 18,

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
            }
        
            xhr.send("username=winteq&password=winteq123&devices=2019110056%3B2019110057%3B2019110055");
            // xhr.send(new Int8Array()); 
            // xhr.send(element);
        }, 5000);
    });
</script>
<!-- JS K5-->
<script>
    $(document).ready(function(){
        var id = document.getElementById("k5_device_id").value // Extract info from data-* attributes

        var xhr = new XMLHttpRequest();
        xhr.open("POST", 'https://gps.intellitrac.co.id/apis/tracking/realtime.php', true);

        //Send the proper header information along with the request
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() { // Call a function when the state changes.
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                var myObj = JSON.parse(this.responseText);
                
                if (id){
                x = myObj.data[id]['device_info']['name'];
                y = myObj.data[id]['realtime']['location'];
                z = myObj.data[id]['realtime']['ignition_status'];
                lat = myObj.data[id]['realtime']['latitude'];
                lng = myObj.data[id]['realtime']['longitude'];
                document.getElementById("k5_nopol").value = x;
                document.getElementById("k5_lokasi").value = y;
                document.getElementById("k5_ignition").value = z;
                // Request finished. Do processing here.
                }else{
                document.getElementById("k5_nopol").value = null;
                document.getElementById("k5_lokasi").value = null;
                document.getElementById("k5_ignition").value = null;
                lat = null;
                lng = null;
                }

                var location = new google.maps.LatLng(lat, lng);

                var mapCanvas = document.getElementById('k5_map');

                var mapOptions = {
                    center: location,
                    zoom: 18,

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
        }
        xhr.send("username=winteq&password=winteq123&devices=2019110056%3B2019110057%3B2019110055");
        // xhr.send(new Int8Array()); 
        // xhr.send(element);
    });
</script>
<!-- JS K5-->
<script>
    $(document).ready(function(){
        var id = document.getElementById("k6_device_id").value // Extract info from data-* attributes

        var xhr = new XMLHttpRequest();
        xhr.open("POST", 'https://gps.intellitrac.co.id/apis/tracking/realtime.php', true);

        //Send the proper header information along with the request
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() { // Call a function when the state changes.
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                var myObj = JSON.parse(this.responseText);
                
                if (id){
                x = myObj.data[id]['device_info']['name'];
                y = myObj.data[id]['realtime']['location'];
                z = myObj.data[id]['realtime']['ignition_status'];
                lat = myObj.data[id]['realtime']['latitude'];
                lng = myObj.data[id]['realtime']['longitude'];
                document.getElementById("k6_nopol").value = x;
                document.getElementById("k6_lokasi").value = y;
                document.getElementById("k6_ignition").value = z;
                // Request finished. Do processing here.
                }else{
                document.getElementById("k6_nopol").value = null;
                document.getElementById("k6_lokasi").value = null;
                document.getElementById("k6_ignition").value = null;
                lat = null;
                lng = null;
                }

                var location = new google.maps.LatLng(lat, lng);

                var mapCanvas = document.getElementById('k6_map');

                var mapOptions = {
                    center: location,
                    zoom: 18,

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
        }
        xhr.send("username=winteq&password=winteq123&devices=2019110056%3B2019110057%3B2019110055");
        // xhr.send(new Int8Array()); 
        // xhr.send(element);
    });
</script>
