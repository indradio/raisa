<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ml-auto mr-auto">
              <div class="page-categories">
                <h3 class="title text-center">Informasi COVID-19</h3>
                <ul class="nav nav-pills nav-pills-info nav-pills-icons justify-content-center" role="tablist">
                <!-- <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#link11" role="tablist">
                        <i class="material-icons">verified_user</i> Keamanan
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#link7" role="tablist">
                        <i class="material-icons">info</i> Info Persebaran
                    </a>
                </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#link8" role="tablist">
                      <i class="material-icons">local_hospital</i> Cek Risiko
                    </a>
                  </li>
                  <!-- <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#link9" role="tablist">
                      <i class="material-icons">home_work</i> Work From Home (WFH)
                    </a>
                  </li> -->
                  <!-- <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#link10" role="tablist">
                      <i class="material-icons">computer</i> IT
                    </a>
                  </li> -->
                </ul>
                <div class="tab-content tab-space tab-subcategories">
                  <div class="tab-pane active" id="link7">
                    <div class="card">
                      <!-- <div class="card-header">
                        <h4 class="card-title">Description about product</h4>
                        <p class="card-category">
                          More information here
                        </p>
                      </div> -->
                      <div class="card-body">
                        <div class="embed-responsive embed-responsive-16by9">
                          <iframe src="https://experience.arcgis.com/experience/57237ebe9c5b4b1caa1b93e79c920338"></iframe>
                        </div>
                        Informasi lebih lengkap kunjungi link berikut : <a href="https://covid19.go.id" target="_blank">https://covid19.go.id</a>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="link8">
                    <div class="card">
                      <!-- <div class="card-header">
                        <h4 class="card-title">Location of the product</h4>
                        <p class="card-category">
                          More information here
                        </p>
                      </div> -->
                      <div class="card-body">
                        <div class="embed-responsive embed-responsive-16by9">
                          <iframe class="embed-responsive-item" src="https://covid19-livechat.alodokter.com"></iframe>
                        </div>
                      Kamu bisa juga cek risiko tertular covid-19 melalui link berikut : <a href="https://covid19-livechat.alodokter.com" target="_blank">https://covid19-livechat.alodokter.com</a>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="link11">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Legal info of the product</h4>
                        <p class="card-category">
                          More information here
                        </p>
                      </div>
                      <div class="card-body">
                        Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                        <br>
                        <br>Dynamically innovate resource-leveling customer service for state of the art customer service.
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="link9">
                  <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Protokol WFH</h4>
                            <p class="card-category">
                              Prosedur Pelaksanaan WFH
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="<?= base_url(); ?>assets/pdf/wfh.pdf"></iframe>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="link10">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Protokol IT</h4>
                            <p class="card-category">
                            Cara Penggunaan VPN untuk WFH
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="<?= base_url(); ?>assets/pdf/Cara menggunakan VPN.pdf"></iframe>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->