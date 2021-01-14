    <div class="content">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="container-fluid">
        <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Presensi</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-shopping">
                      <thead>
                        <tr>
                          <th class="text-center"></th>
                          <th>Nama</th>
                          <th class="th-description">Time</th>
                          <th class="th-description">Flag</th>
                          <th class="th-description">Status</th>
                          <th class="th-description">Catatan</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($presensi as $row) : ?>
                        <tr>
                          <td>
                            <div class="img-container">
                              <img src="<?= base_url(); ?>assets/img/presensi/<?= $row['file_name']; ?>" alt="...">
                            </div>
                          </td>
                          <td class="td-name">
                            <a href="#"><?= $row['nama']; ?></a>
                            <br>
                            <small><?= $row['location']; ?></small>
                          </td>
                          <td> 
                          <?= date('d-m-Y H:i', strtotime($row['time'])); ?>
                          </td>
                          <td> 
                          <?= $row['state']; ?>
                          </td>
                          <td>
                          <?= $row['work_state']; ?>
                          </td>
                          <td>
                           <?= $row['note']; ?>
                          </td>
                          <td class="td-actions">
                            <a href="<?= base_url('presensi/persetujuan/'.$params1.'/submit/'.$row['id']); ?>" rel="tooltip" data-placement="left" title="" class="btn btn-link btn-success" data-original-title="Approve">
                              <i class="material-icons">check</i>
                            </a>
                          </td>
                        </tr>
                        <?php endforeach; 
                        if (!empty($presensi)){ ?>
                          <td colspan="4"></td>
                          <td colspan="2" class="text-right">
                          <a href="<?= base_url('presensi/persetujuan/'.$params1.'/submit/all'); ?>" class="btn btn-info btn-round">Complete <i class="material-icons">keyboard_arrow_right</i></a>
                          </td>
                        </tr>
                        <?php }; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid-->
    </div>
    <!-- end content-->