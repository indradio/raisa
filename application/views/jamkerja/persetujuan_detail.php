<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <?php if ($jamkerja['rev']==1) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>LAPORAN JAM KERJA ini membutuhkan REVISI,</strong>
                </br>
            </div>
        <?php } ?>
  <?php if ($jamkerja['catatan']) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Catatan dari ATASAN,</strong>
                </br>
                <?= $jamkerja['catatan']; ?>
            </div>
        <?php } ?>
  <?php if ($jamkerja['catatan_ppic']) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Catatan dari PPIC,</strong>
                </br>
                <?= $jamkerja['catatan_ppic']; ?>
            </div>
        <?php } ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">#<?= $jamkerja['id'].' - '. $jamkerja['shift']; ?></br>
            <small><?= $jamkerja['nama'].' - '.date("d M Y", strtotime($jamkerja['tglmulai'])); ?></small>
          </h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <?php
              $link = $jamkerja['id'];
              $durasi = $jamkerja['durasi'];
              
              if ($durasi < 4) {
                $shift = $durasi;
                $sisaDurasi = 4;
              } else {
                if ($jamkerja['shift']=='SHIFT1' OR $jamkerja['shift']=='SHIFT1_PAKO'){
                    $sisadurasi = 6 - $durasi;
                }elseif ($jamkerja['shift']=='SHIFT2' OR $jamkerja['shift']=='SHIFT3_A'){
                    $sisadurasi = 8 - $durasi;
                }elseif ($jamkerja['shift']=='SHIFT3'){
                    $sisadurasi = 7 - $durasi;
                }
              }

              $jam = $this->db->get_where('jam', ['jam <=' =>  $sisaDurasi])->result();

              // Select the sum of 'durasi' for each 'kategori' in a single query
              $this->db->select('kategori, SUM(durasi) as total_durasi');
              $this->db->where('link_aktivitas', $link);
              $this->db->where_in('kategori', ['1', '2', '3']);
              $this->db->group_by('kategori');
              $query = $this->db->get('aktivitas');

              // Initialize variables
              $kategori1 = $kategori2 = $kategori3 = 0;
              $bar1 = $bar2 = $bar3 = 0;
              $produktif1 = $produktif2 = $produktif3 = 0;

              // Process the results
              foreach ($query->result() as $row) {
                  switch ($row->kategori) {
                      case '1':
                          $kategori1 = $row->total_durasi;
                          $bar1 = $kategori1 * 12.5;
                          $produktif1 = ($kategori1 / $shift) * 100;
                          break;
                      case '2':
                          $kategori2 = $row->total_durasi;
                          $bar2 = $kategori2 * 12.5;
                          $produktif2 = ($kategori2 / $shift) * 100;
                          break;
                      case '3':
                          $kategori3 = $row->total_durasi;
                          $bar3 = $kategori3 * 12.5;
                          $produktif3 = ($kategori3 / $shift) * 100; // Adjusted to * 100 based on your original code
                          break;
                  }
              }

              $produktifitas = $produktif1 + $produktif2 + $produktif3;
              ?>
              <b><h3>Porsi ke COPRO : <?= $produktifitas; ?> % </h3></b>
              
              <div class="progress" style="width: 100%">
                  <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $bar1; ?>%" aria-valuenow="<?= $kategori1; ?>" aria-valuemin="0" aria-valuemax="<?= $shift; ?>"></div>
                  <div class="progress-bar progress-bar-warning" role="progressbar" style="width: <?= $bar2; ?>%" aria-valuenow="<?= $kategori2; ?>" aria-valuemin="0" aria-valuemax="<?= $shift; ?>"></div>
                  <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $bar3; ?>%" aria-valuenow="<?= $kategori3; ?>" aria-valuemin="0" aria-valuemax="<?= $shift; ?>"></div>
              </div>
              <?php if(($jamkerja['shift']=='SHIFT1' OR $jamkerja['shift']=='SHIFT1_PAKO') AND $jamkerja['durasi']<6){
                echo '<a href="#" class="btn btn-facebook mb-2" role="button" data-toggle="modal" data-target="#aktivitasModal" data-id="'. $jamkerja['id'].'" aria-disabled="false">TAMBAH AKTIVITAS JAM KERJA</a>';
              } elseif(($jamkerja['shift']=='SHIFT2' OR $jamkerja['shift']=='SHIFT3_A') AND $jamkerja['durasi']<8){
                echo '<a href="#" class="btn btn-facebook mb-2" role="button" data-toggle="modal" data-target="#aktivitasModal" data-id="'. $jamkerja['id'].'" aria-disabled="false">TAMBAH AKTIVITAS JAM KERJA</a>';
              } elseif($jamkerja['shift']=='SHIFT3' AND $jamkerja['durasi']<7){
                echo '<a href="#" class="btn btn-facebook mb-2" role="button" data-toggle="modal" data-target="#aktivitasModal" data-id="'. $jamkerja['id'].'" aria-disabled="false">TAMBAH AKTIVITAS JAM KERJA</a>';
              } ?>
            </div>
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>copro</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>Hasil (%)</th>
                        <th>Durasi (Jam)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Kategori</th>
                        <th>copro</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>Hasil</th>
                        <th>Durasi</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                     // Fetch all categories and map them by ID
                    foreach ($aktivitas as $row) : 
                    
                      $mapKategori = [
                        1 => 'Project',
                        2 => 'Non Project',
                        3 => 'Lain-lain Project'
                    ];
                    
                    $kategori = $mapKategori[$row['kategori']] ?? 'N/A';
                    
                    ?>
                        <tr>
                            <td><?= $kategori; ?></td>
                            <td><?= $row['copro']; ?>
                            <?php 
                            if ($this->session->userdata('npk')=='0209'){
                              if ($row['copro']){
                                echo '<a href="#" class="badge badge-sm badge-success" role="button" aria-disabled="false" data-toggle="modal" data-target="#ubahCopro" data-id="'. $row['id'] .'">UBAH COPRO</a>';
                              }else{
                                echo '<a href="#" class="badge badge-sm badge-default disabled" role="button" aria-disabled="true">NON PROJEK</a>';
                              }
                            }
                            ?>
                            </td>
                            <td><?= $row['aktivitas']; ?></td>
                            <td><?= $row['aktivitas']; ?></td>
                            <td><?= $row['deskripsi_hasil']; ?></td>
                            <td><?= $row['progres_hasil']; ?></td>
                            <td><?= $row['durasi']; ?></td>
                            <td>
                            <?php echo '<a href="#" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#hapusAktivitas" data-id="'. $row['id'] .'">HAPUS</a>'; ?>
                            </td>
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
                            if ($this->session->userdata('npk')=='0209'){
                              $role = 'ppic';
                            }else{
                              $role = 'koordinator';
                            }

                            foreach ($aktivitas as $row) : 
                              if ($row['copro']){
                                $project = $this->db->get_where('project', ['copro' =>  $row['copro']])->row_array();
                                echo  $row['copro'] . ' = '. $project['deskripsi'] . '<br>';  
                              }
                            endforeach; 
                        ?>
                        </div>
                            <div class="col-md-12">
                                <!-- Button SUBMIT -->
                                <?php if($sisaDurasi == 0){ ?>
                                  <form class="form" method="post" action="<?= base_url('jamkerja/approve/'.$role); ?>">
                                    <input type="hidden" class="form-control" id="id" name="id" value="<?= $jamkerja['id']; ?>">
                                    <input type="hidden" class="form-control" id="produktifitas" name="produktifitas" value="<?= $produktifitas; ?>">

                                    <button type="submit" class="btn btn-fill btn-success">APPROVE</button>
                                    
                                    <a href="#" class="btn btn btn-warning" role="button" aria-disabled="false" data-toggle="modal" data-target="#revisiJamkerja" data-id="<?= $jamkerja['id']; ?>">REVISI</a>
                                    <a href="#" class="btn btn btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#hapusJamkerja" data-id="<?= $jamkerja['id']; ?>">HAPUS</a>
                                    <!-- <a href="<?= base_url('jamkerja/persetujuan') ?>" class="btn btn-default" role="button">Kembali</a> -->
                                  </form>
                                <?php } ?>
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
        <form class="form" method="post" action="<?= base_url('jamkerja/approve/koordinator'); ?>">
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
            <div class="form-group">
              <textarea rows="2" class="form-control" id="catatan" name="catatan" placeholder="Berikan catatan"></textarea>
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

<!-- Modal Accept Jam Kerja-->
<div class="modal fade" id="acceptJamkerja" tabindex="-1" role="dialog" aria-labelledby="acceptJamkerjaTitle" aria-hidden="true">
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
        <form class="form" method="post" action="<?= base_url('jamkerja/approve/ppic'); ?>">
          <div class="modal-body">
            <input type="text" class="form-control" hidden="true" id="id" name="id" value="<?= $jamkerja['id']; ?>">
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
<div class="modal fade" id="revisiJamkerja" tabindex="-1" role="dialog" aria-labelledby="revisiJamkerjaTitle">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-primary text-center">
            <button type="button" class="close" data-dismiss="modal">
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
            <button type="submit" class="btn btn-facebook mb-2">REVISI LAPORAN INI!</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Hapus Jam Kerja-->
<div class="modal fade" id="hapusJamkerja" tabindex="-1" role="dialog" aria-labelledby="hapusJamkerjaTitle">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-danger text-center">
            <button type="button" class="close" data-dismiss="modal">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">YAKIN MAU MENGHAPUS JAM KERJA INI?</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('jamkerja/hapus'); ?>">
          <div class="modal-body">
            <input type="hidden" class="form-control" id="id" name="id" value="<?= $jamkerja['id']; ?>">
            <h4 class="card-title text-center"><?= date("d M Y", strtotime($jamkerja['tglmulai'])).' - '. $jamkerja['nama']; ?></br>
            <small>#<?= $jamkerja['id']; ?></small>
            </br>
            <small class="text-danger"><i>INGAT! Jam kerja yang dihapus tidak dapat diaktifkan kembali.</i></small>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-facebook mb-2">YA, SAYA YAKIN!</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add Aktivitas-->
<div class="modal fade" id="aktivitasModal" tabindex="-1" role="dialog" aria-labelledby="aktivitasModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Aktivitas Kerja</h4>
                    </div>
                </div>
                <form id="Aktivitas" class="form" method="post" action="<?= base_url('jamkerja/add_aktivitas_by_koor'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group" hidden="true">
                                <label for="id">id</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?= $jamkerja['id']; ?>">
                                <input type="text" class="form-control" id="deptid" name="deptid" value="<?= $jamkerja['dept_id']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori*</label>
                                <select class="form-control selectpicker" name="kategori" id="kategori" title="Pilih Kategori" data-style="btn btn-link" data-size="3" data-live-search="false" onchange="kategoriSelect(this);" required>
                                  <option value="1">PROJECT</option>
                                  <option value="2">LAIN-LAIN PROJECT</option>
                                  <option value="3">NON PROJECT</option>
                                </select>
                            </div>
                            <div class="form-group" id="copro_0" style="display:none;">
                                <label for="copro">Project*</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="copro" name="copro" title="Pilih Project" data-size="5" data-live-search="true" required>
                                    <?php
                                    foreach ($listproject as $row) {
                                        echo '<option data-subtext="' . $row->deskripsi . '" value="' . $row->copro . '">' . $row->copro . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group" id="aktivitas_23" style="display:none;">
                                <label for="aktivitas">Aktivitas*</label>
                                <!-- Aktivitas Lain-lain Project & Non Project -->
                                <select class="form-control selectpicker" id="aktivitas_lain" name="aktivitas" data-style="btn btn-link" title="Pilih Aktivitas" data-size="7"></select>
                            </div>
                            <div class="form-group" id="aktivitas_1" style="display:none;">
                                <label for="aktivitas">Aktivitas*</label>
                                <!-- Aktivitas Project -->
                                <textarea class="form-control has-success" id="aktivitas" name="aktivitas" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi <small><i>(Opsional)</i></small></label>
                                    <textarea class="form-control has-success" id="deskripsi" name="deskripsi" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="durasi">Durasi*</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="durasi" name="durasi" title="Pilih Durasi" data-size="5" required>
                                    <?php
                                    foreach ($jam as $row) {
                                        echo '<option value="' . $row->jam . '">' . $row->nama . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="progres_hasil">Hasil*</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="progres_hasil" name="progres_hasil" title="Pilih Hasil" required>
                                    <option value="100">100%</option>
                                    <option value="90">90%</option>
                                    <option value="75">75%</option>
                                    <option value="50">50%</option>
                                    <option value="25">25%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-facebook btn-round">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal batal Aktivitas-->
<div class="modal fade" id="hapusAktivitas" tabindex="-1" role="dialog" aria-labelledby="hapusAktivitasLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="hapusAktivitasLabel">Kamu yakin ingin menghapus aktivitas ini?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" action="<?= base_url('jamkerja/batal_aktivitas'); ?>">
      <div class="modal-body">
        <div class="form-group" hidden="true">
            <label for="id">id</label>
            <input type="text" class="form-control" id="id" name="id">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
        <button type="submit" class="btn btn-danger">YA, HAPUS!</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ubahCopro" tabindex="-1" role="dialog" aria-labelledby="ubahCoproTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">List Project</h4>
                    </div>
                </div>
                <form id="Copro" class="form" method="post" action="<?= base_url('jamkerja/ubah_copro'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group" hidden="true">
                                <label for="id">id</label>
                                <input type="text" class="form-control" id="id" name="id">
                            </div>
                            <div class="form-group">
                                <label for="copro">Project*</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="copro" name="copro" title="Pilih Project" data-size="7" data-live-search="true" required>
                                    <?php
                                    foreach ($listproject as $row) {
                                        echo '<option value="' . $row->copro . '">' . $row->copro . ' - ' .$row->deskripsi. '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-facebook btn-round">Ubah COPRO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        function kategoriSelect(valueSelect)
            {
                var val = valueSelect.options[valueSelect.selectedIndex].value;
                document.getElementById("aktivitas_1").style.display = val == '1' ? "block" : 'none';
                document.getElementById("aktivitas_23").style.display = val != '1' ? "block" : 'none';
                document.getElementById("copro_0").style.display = val != '3' ? "block" : 'none';
            }
            $('#kategori').change(function(){
                var kategori = $('#kategori').val();
                var deptid = $('#deptid').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('jamkerja/selectAktivitas')?>",
                    data: {kategori:kategori, deptid: deptid},
                    success: function(data) {
                        // alert(data)
                        $('#aktivitas_lain').html(data); 
                        if(kategori == 1){
                            $('#copro').prop('disabled', false);
                            $('#copro').prop('required', true);
                            $('#aktivitas').prop('disabled', false);
                            $('#aktivitas').prop('required', true);
                            $('#aktivitas_lain').prop('disabled', true);
                        }
                        else if(kategori == 2){
                            $('#copro').prop('disabled', false);
                            $('#copro').prop('required', true);
                            $('#aktivitas_lain').prop('disabled', false);
                            $('#aktivitas_lain').selectpicker('refresh');
                            $('#aktivitas_lain').prop('required', true);
                            $('#aktivitas').prop('disabled', true);
                        }
                        else if(kategori == 3){
                            $('#copro').prop('disabled', true);
                            $('#aktivitas_lain').prop('disabled', false);
                            $('#aktivitas_lain').selectpicker('refresh');
                            $('#aktivitas_lain').prop('required', true);
                            $('#aktivitas').prop('disabled', true);
                        }    
                    }
                })
            })
  
        $(document).ready(function(){
            $('#ubahCopro').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var id = button.data('id') 
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            })  
            
            $('#batalAktivitas').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) 
                var id = button.data('id') 
                var modal = $(this)
                modal.find('.modal-body input[name="id"]').val(id)
            })
        });  
    </script>