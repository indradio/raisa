<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">weekend</i>
            </div>
            <p class="card-category">Saldo Aktif</p>
            <h3 class="card-title"><?=$saldo_aktif; ?> hari</h3>
          </div>
          <div class="card-footer">
            <div class="stats"></div>
              <a href="#" class="btn btn-facebook btn-block" data-toggle="modal" data-target="#tambahCuti">Tambah</a>
            </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">weekend</i>
            </div>
            <p class="card-category"></p>
            <h3 class="card-title"></h3>
          </div>
          <div class="card-footer">
            <div class="stats"></div>
              <a href="#" class="btn btn-linkedin btn-block" role="button" aria-disabled="false" data-toggle="modal" data-target="#importCuti">Import</a>
            </div>
        </div>
      </div>
    </div>
    <div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Saldo</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
            
              <!--        Here you can write extra buttons/actions for the toolbar              -->
              
            </div>
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Status</th>
                    <th>Kategori</th>
                    <th>Nama</th>
                    <th>Saldo <small>(digunakan)</small></th>
                    <th>Sisa Saldo</th>
                    <th>Keterangan</th>
                    <th>Berlaku Mulai</th>
                    <th>Berlaku Sampai</th>
                    <th class="text-right">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Status</th>
                    <th>Kategori</th>
                    <th>Nama</th>
                    <th>Saldo</th>
                    <th>Sisa Saldo</th>
                    <th>Keterangan</th>
                    <th>Berlaku Mulai</th>
                    <th>Berlaku Sampai</th>
                    <th class="text-right">Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($saldo as $row) : 
                    $status = $this->db->get_where('cuti_status', ['id' => $row['status']])->row_array();
                    $user = $this->db->get_where('karyawan', ['npk' => $row['npk']])->row_array(); ?>
                    <tr>
                      <td class="text-center"><?= $row['status'].'</br><small> ('.$row['id'].')</small>'; ?></td>
                      <td><?= $row['kategori']; ?></td>
                      <td><?= $user['nama']; ?></td>
                      <td><?= $row['saldo_awal'].'<small> ('.$row['saldo_digunakan'].')</small>'; ?></td>
                      <td><?= $row['saldo']; ?></td>
                      <td><?= $row['keterangan']; ?></td>
                      <td><?= date('d M Y', strtotime($row['valid'])); ?></td>
                      <td><?= date('d M Y', strtotime($row['expired'])); ?></td>
                      <td class="text-right">
                        <?php if ($row['saldo_digunakan']==0): ?>
                          <a href="#" class="btn btn-link btn-warning btn-just-icon" role="button" aria-disabled="false" data-toggle="modal" data-target="#editCuti" data-id="<?= $row['id']; ?>" data-valid="<?= date('d-m-Y', strtotime($row['valid'])); ?>" data-expired="<?= date('d-m-Y', strtotime($row['expired'])); ?>" data-saldo="<?= $row['saldo']; ?>" data-keterangan="<?= $row['keterangan']; ?>"><i class="material-icons">edit</i></a>
                          <a href="#" class="btn btn-link btn-danger btn-just-icon" role="button" aria-disabled="false" data-toggle="modal" data-target="#deleteCuti" data-id="<?= $row['id']; ?>"><i class="material-icons">delete_forever</i></a>
                          <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- end card body-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
  </div>
  <!-- end container-fluid -->
</div>
<!-- end content -->

<!-- Modal -->
<div class="modal fade" id="tambahCuti" tabindex="-1" role="dialog" aria-labelledby="tambahCutiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="card card-signup card-plain">
                  <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <h4 class="card-title"> </h4>
                      </div>
                    </div>
                <form class="form" method="post" id="formAddCuti" action="<?= base_url('cuti/hr_saldo/add'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <input type="hidden" class="form-control" id="npk" name="npk">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Karyawan*</label></br>
                                <select class="selectpicker" name="karyawan" id="karyawan" title="Pilih" data-style="select-with-transition" data-size="5" data-width="block" data-live-search="true" required>
                                    <?php foreach ($allkaryawan as $k) : ?>
                                        <option value="<?= $k['npk']; ?>"><?= $k['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Kategori*</label></br>
                                <select class="selectpicker" name="kategori" id="kategori" title="Pilih" data-style="select-with-transition" data-size="5" data-width="block" data-live-search="false" onchange="kategoriSelect(this);" required>
                                    <?php foreach ($kategori as $k) : ?>
                                        <option value="<?= $k['kategori']; ?>"><?= $k['kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Berlaku Mulai*</label></br>
                              <input type="text" class="form-control datepicker" name="valid" id="valid" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Berlaku Sampai*</label></br>
                              <input type="text" class="form-control datepicker" name="expired" id="expired" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Saldo*</label></br>
                              <input type="number" class="form-control" name="saldo" id="saldo" required/>
                          </div>
                      </div>
                      
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Keterangan*</label></br>
                              <textarea class="form-control has-success" id="keterangan" name="keterangan" rows="3" required></textarea>
                          </div>
                      </div>
                    </div>
                    <p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <!-- <small></small> -->
                        <!-- <label class="col-md-5 col-form-label"></label> -->
                        <div class="col-md-12 mr-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
                            <button type="submit" class="btn btn-success">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importCuti" tabindex="-1" role="dialog" aria-labelledby="importCutiTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Import</h4>
                    </div>
                </div>
                <?= form_open_multipart('cuti/hr_saldo/import'); ?>
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="file" name="data" id="data" class="inputFileVisible" placeholder="Single File">
                        </div>
                        <div class="modal-footer">
                          <a href="<?= base_url('assets/temp_excel/template_upload_saldo_cuti.xlsx'); ?>" class="btn btn-linkedin btn-link" role="button" aria-disabled="false">DOWNLOAD TEMPLATE</a>
                          <div class="row">
                            <div class="col-md-12 mr-4">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
                                <button type="submit" class="btn btn-success">SUBMIT</button>
                            </div>
                          </div>
                        </div>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editCuti" tabindex="-1" role="dialog" aria-labelledby="editCutiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="card card-signup card-plain">
                <form class="form" id="rormEditCuti" method="post" action="<?= base_url('cuti/hr_saldo/edit'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <input type="hidden" class="form-control" id="npk" name="npk">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Berlaku Mulai*</label></br>
                              <input type="text" class="form-control datepicker" name="valid" id="valid" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Berlaku Sampai*</label></br>
                              <input type="text" class="form-control datepicker" name="expired" id="expired" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Saldo*</label></br>
                              <input type="number" class="form-control" name="saldo" id="saldo" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Keterangan*</label></br>
                              <textarea class="form-control has-success" id="keterangan" name="keterangan" rows="3" required></textarea>
                          </div>
                      </div>
                    </div>
                    <p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <!-- <small></small> -->
                        <!-- <label class="col-md-5 col-form-label"></label> -->
                        <div class="col-md-12 mr-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
                            <button type="submit" class="btn btn-success">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteCuti" tabindex="-1" role="dialog" aria-labelledby="deleteCutiTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-danger text-center">
              <h4 class="card-title"></h4>
          </div>
        </div>
      <form class="form" id="formDeleteCuti" method="post" action="<?= base_url('cuti/hr_saldo/del'); ?>">
          <div class="modal-body">
              <input type="hidden" class="form-control" id="id" name="id">
              <h4 class="card-title text-center">Yakin ingin menghapus saldo cuti ini?</h4>
          </div>
          <div class="modal-footer justify-content-right">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
              <button type="submit" class="btn btn-danger">YA, HAPUS!</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  
  $(document).ready(function() {
  setFormValidation('#formAddCuti');
  setFormValidation('#formEditCuti');
    $('#deleteCuti').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body input[name="id"]').val(id)
    });

    $('#editCuti').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var valid = button.data('valid')
        var expired = button.data('expired')
        var saldo = button.data('saldo')
        var keterangan = button.data('keterangan')
        var modal = $(this)
        modal.find('.modal-body input[name="id"]').val(id)
        modal.find('.modal-body input[name="valid"]').val(valid)
        modal.find('.modal-body input[name="expired"]').val(expired)
        modal.find('.modal-body input[name="saldo"]').val(saldo)
        modal.find('.modal-body textarea[name="keterangan"]').val(keterangan)
    });
});
</script>