<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-text">
              <h4 class="card-title">Presensi</h4>
              <p class="card-category">Periode <?= date('F Y', strtotime("$tahun-$bulan-01")); ?></p>
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <form class="form" method="post" action="<?= base_url('hr/download/presensi'); ?>">
                <div class="form-group">
                  <!-- <label for="copro">Project*</label> -->
                  <select class="selectpicker" data-style="btn btn-link" id="year" name="year" title="Pilih Tahun" data-size="7" data-live-search="true" required>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022" selected>2022</option>
                  </select>
                </div>
                <div class="form-group">
                  <!-- <label for="copro">Project*</label> -->
                  <select class="selectpicker" data-style="btn btn-link" id="month" name="month" title="Pilih Bulan" onchange='this.form.submit()' data-size="7" data-live-search="true" required>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                  </select>
                </div>
              </form>
            </div>
            <div class="material-datatables">
              <div class="table-responsive">
                <table id="dtperjalanan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>NPK</th>
                      <th>Nama</th>
                      <th>Jam</th>
                      <th>State</th>
                      <th>New State</th>
                      <th>Section</th>
                      <th>Dept</th>
                      <th>Lokasi</th>
                      <th>Device</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $this->db->where('year(time)', $tahun);
                      $this->db->where('month(time)', $bulan);
                      $presensi = $this->db->get('presensi')->result_array();
                      foreach ($presensi as $p) :
                        $dept = $this->db->get_where('karyawan_dept', ['id' => $p['dept_id']])->row_array();
                        $sect = $this->db->get_where('karyawan_sect', ['id' => $p['sect_id']])->row_array();
                      if (date('D', strtotime($p['time'])) == 'Sat' or date('D', strtotime($p['time'])) == 'Sun') {
                        echo '<tr class="table-danger">';
                      } else {
                        echo '<tr>';
                      }
                      echo '<th>' . date('m-d-Y', strtotime($p['time'])) . '</th>';
                      echo '<th>' . $p['npk'] . '</th>';
                      echo '<th>' . $p['nama'] . '</th>';
                      echo '<th>' . date('H:i', strtotime($p['time'])) . '</th>';
                      echo '<th>' . $p['state'] . '</th>';
                      echo '<th>' . $p['work_state'] . '</th>';
                      if ($sect){
                          echo '<th>' . $sect['nama'] . '</th>';
                        }else{
                            echo '<th></th>';
                        }
                        if ($dept){
                            echo '<th>' . $dept['nama'] . '</th>';
                        }else{
                            echo '<th></th>';
                        }
                        echo '<th>' . $p['location'] . '</th>';
                        echo '<th>' . $p['platform'] . '</th>';
                    endforeach;
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card-footer">
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
  </div>
</div>