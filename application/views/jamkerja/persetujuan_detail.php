<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title"><?= $jamkerja['nama']; ?>
            <small> - <?= date("d M Y", strtotime($jamkerja['tglmulai'])); ?></small>
          </h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <?php
              $link = $jamkerja['id'];
              $durasi = $jamkerja['durasi'];

              $this->db->select_sum('durasi');
              $this->db->where('link_aktivitas', $link);
              $this->db->where('kategori', '1');
              $query1 = $this->db->get('aktivitas');
              $kategori1 = $query1->row()->durasi;
              $bar1 = $kategori1 * 12.5;
              $produktif1 = ($kategori1 / 8) * 100;

              $this->db->select_sum('durasi');
              $this->db->where('link_aktivitas', $link);
              $this->db->where('kategori', '2');
              $query2 = $this->db->get('aktivitas');
              $kategori2 = $query2->row()->durasi;
              $bar2 = $kategori2 * 12.5;
              $produktif2 = ($kategori2 / 8) * 100;

              $this->db->select_sum('durasi');
              $this->db->where('link_aktivitas', $link);
              $this->db->where('kategori', '3');
              $query3 = $this->db->get('aktivitas');
              $kategori3 = $query3->row()->durasi;
              $bar3 = $kategori3 * 12.5;
              $produktif3 = ($kategori3 / 8) * 0;

              $produktifitas = $produktif1 + $produktif2 + $produktif3;
              ?>
              <b><h3>Produktifitas : <?= $produktifitas; ?> % </h3></b>
              
              <div class="progress" style="width: 100%">
                  <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $bar1; ?>%" aria-valuenow="<?= $kategori1; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                  <div class="progress-bar progress-bar-warning" role="progressbar" style="width: <?= $bar2; ?>%" aria-valuenow="<?= $kategori2; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                  <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $bar3; ?>%" aria-valuenow="<?= $kategori3; ?>" aria-valuemin="0" aria-valuemax="8"></div>
              </div>
            </div>
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>Hasil (%)</th>
                        <th>Durasi (Jam)</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Kategori</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>Hasil</th>
                        <th>Durasi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    foreach ($aktivitas as $a) : ?>
                        <tr>
                            <?php $katgr = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                            <td><?= $katgr['nama']; ?> <small>(<?= $a['copro']; ?>)</small></td>
                            <td><?= $a['aktivitas']; ?></td>
                            <td><?= $a['deskripsi_hasil']; ?></td>
                            <td><?= $a['progres_hasil']; ?></td>
                            <td><?= $a['durasi']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
                    <div class="card-footer">
                        <div class="row">
                        <div class="col-md-12">
                        <?php 
                            $this->db->distinct();
                            $this->db->select('copro');
                            $this->db->where('link_aktivitas', $jamkerja['id']);
                            $aktivitas_copro = $this->db->get('aktivitas')->result_array();
                            foreach ($aktivitas_copro as $ac) : 
                              $project = $this->db->get_where('project', ['copro' =>  $ac['copro']])->row_array();
                              if ($ac['copro']){
                                echo  $ac['copro'] . ' = '. $project['deskripsi'] . '<br>';  
                              }
                            endforeach; 
                        ?>
                        </div>
                            <div class="col-md-12">
                                 <!-- Button SUBMIT -->
                                <a href="#" class="btn btn btn-success" role="button" aria-disabled="false" data-toggle="modal" data-target="#approveJamkerja" data-id="<?= $jamkerja['id']; ?>">APPROVE</a>
                                <a href="#" class="btn btn btn-warning" role="button" aria-disabled="false" data-toggle="modal" data-target="#revisiJamkerja" data-id="<?= $jamkerja['id']; ?>">REVISI</a>
                                <a href="<?= base_url('jamkerja/koordinator/'.date("Y-m-d", strtotime($jamkerja['tglmulai']))) ?>" class="btn btn-default" role="button">Kembali</a>
                            </div>
                        </div>
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
<!-- Modal Approve Jam Kerja-->
<div class="modal fade" id="approveJamkerja" tabindex="-1" role="dialog" aria-labelledby="approveJamkerjaTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-success text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">BERIKAN PENILAIAN</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('jamkerja/persetujuan_approve'); ?>">
          <div class="modal-body">
            <input type="text" class="form-control" hidden="true" id="id" name="id" value="<?= $jamkerja['id']; ?>">
            <input type="text" class="form-control" hidden="true" id="produktifitas" name="produktifitas" value="<?= $produktifitas; ?>">
            <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="poin" value="1" checked><i class="material-icons">star</i>
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="poin" value="2"><i class="material-icons">star</i><i class="material-icons">star</i>
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="poin" value="3"><i class="material-icons">star</i><i class="material-icons">star</i><i class="material-icons">star</i>
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="poin" value="4"><i class="material-icons">star</i><i class="material-icons">star</i><i class="material-icons">star</i><i class="material-icons">star</i>
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="poin" value="5"><i class="material-icons">star</i><i class="material-icons">star</i><i class="material-icons">star</i><i class="material-icons">star</i><i class="material-icons">star</i>
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-success mb-2">APPROVE!</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Revisi Jam Kerja-->
<div class="modal fade" id="revisiJamkerja" tabindex="-1" role="dialog" aria-labelledby="revisiJamkerjaTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-warning text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">ALASAN REVISI</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('jamkerja/persetujuan_revisi'); ?>">
          <div class="modal-body">
            <input type="text" class="form-control" hidden="true" id="id" name="id" value="<?= $jamkerja['id']; ?>">
            <textarea rows="2" class="form-control" id="catatan" name="catatan" placeholder="Kenapa laporan ini harus direvisi?" required></textarea>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-success mb-2">REVISI LAPORAN INI!</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>