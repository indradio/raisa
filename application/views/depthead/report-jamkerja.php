<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-text">
              <h4 class="card-title">Jam Kerja</h4>
              <p class="card-category">Periode <?= $fr . ' - ' . $to; ?></p>
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <form class="form" action="<?= base_url('depthead/jk'); ?>" method="post">
                <div class="row">
                  <label class="col-md-1 col-form-label">From</label>
                  <div class="col-md-2">
                    <div class="form-group has-default">
                      <input type="text" class="form-control datepicker" id="datefr" name="datefr" value="<?= date('d-m-Y', strtotime($fr)); ?>" required="true" />
                    </div>
                  </div>
                  <label class="col-md-1 col-form-label">To</label>
                  <div class="col-md-2">
                    <div class="form-group has-default">
                      <input type="text" class="form-control datepicker" id="dateto" name="dateto" value="<?= date('d-m-Y', strtotime($to)); ?>" required="true" />
                    </div>
                  </div>
                  <div class="col-md-1">
                    <button type="submit" class="btn btn-sm btn-twitter"><i class="material-icons">search</i> Calculate</button>
                  </div>
                  <div class="col-md-5"></div>
                </div>
              </form>

              <!-- Script Filter per Bulan -->
              <!-- <form class="form" method="post" action="<?= base_url('depthead/presensi'); ?>">
                <div class="form-group">
                  <label for="copro">Project*</label>
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
              </form> -->
            </div>
            <div class="material-datatables">
              <div class="table-responsive">
                <table id="dtJamkerja" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>AKTIVITAS</th>
                    <?php
                    $this->db->where('work_contract', 'Direct Labor');
                    $this->db->where('is_active', '1');
                    $this->db->order_by('inisial ASC');
                    $labor = $this->db->get('karyawan')->result_array();
                    foreach ($labor as $row) :
                      echo '<th>'.$row['inisial'].'</th>';
                    endforeach;
                    ?>
                      <!-- <th>Time</th>
                      <th>State</th>
                      <th>New State</th>
                      <th>Location</th>
                      <th>Health</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>Dept</th>
                      <?php
                      foreach ($labor as $row) :
                        $dept = $this->db->get_where('karyawan_dept', ['id' => $row['dept_id']])->row_array();

                        echo '<th>'.$dept['inisial'].'</th>';
                      endforeach;
                      ?>
                    </tr>
                    <tr>
                      <th>Project</th>
                      <?php
                      foreach ($labor as $row) :
                        $this->db->select('SUM(durasi) as durasi');
                        $this->db->where('npk', $row['npk']);
                        $this->db->where('kategori', '1');
                        $this->db->where('tgl_aktivitas >=',date('Y-m-d', strtotime($fr)));
                        $this->db->where('tgl_aktivitas <=',date('Y-m-d', strtotime($to)));
                        $this->db->where('status', '9');
                        $this->db->from('aktivitas');
                  
                        $totalDurasi = $this->db->get()->row()->durasi;
                        echo '<th>'. ($totalDurasi > 0 ? $totalDurasi : '0') .'</th>';
                      endforeach;
                      ?>
                    </tr>
                    <?php
                    $this->db->distinct();
                    $this->db->select('aktivitas');
                    $aktivitas = $this->db->get('jamkerja_lain')->result_array();
                    foreach ($aktivitas as $row) :
                      echo '<tr>';
                      echo '<th>' . $row['aktivitas'] . '</th>';
                      foreach ($labor as $user) :
                        $this->db->select('SUM(durasi) as durasi');
                        $this->db->where('npk', $user['npk']);
                        $this->db->where('aktivitas', $row['aktivitas']);
                        $this->db->where('tgl_aktivitas >=',date('Y-m-d', strtotime($fr)));
                        $this->db->where('tgl_aktivitas <=',date('Y-m-d', strtotime($to)));
                        $this->db->where('status', '9');
                        $this->db->from('aktivitas');
                  
                        $totalDurasi = $this->db->get()->row()->durasi;
                        echo '<th>'. ($totalDurasi > 0 ? $totalDurasi : '0') .'</th>';
                      endforeach;
                      echo '</tr>';
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

<script>
  $(document).ready(function() {
    $('#dtJamkerja').DataTable({
      "pagingType": "full_numbers",
      scrollX: true,
      "ordering": false,
      "paging": false,
      dom: 'Bfrtip',
      buttons: [
        'csv', 'print'
      ],
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search records",
      }

      // "scrollY": "512px",
      // "scrollX": true,
      // "scrollCollapse": true,

    });
  });
</script>