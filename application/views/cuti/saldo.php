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
            <p class="card-category">Saldo</p>
            <h3 class="card-title"><?=$saldo_total; ?> hari</h3>
          </div>
          <div class="card-footer">
            <div class="stats"></div>
              <!-- <a href="#" class="btn btn-facebook btn-block" data-toggle="modal" data-target="#tambahCuti">Tambah Cuti</a> -->
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
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
              <table id="dtdesc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Saldo</th>
                    <th>Digunakan</th>
                    <th>Sisa Saldo</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th>Berlaku Sampai</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Saldo</th>
                    <th>Digunakan</th>
                    <th>Sisa Saldo</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th>Berlaku</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($saldo as $row) : 
                    $status = $this->db->get_where('cuti_status', ['id' => $row['status']])->row_array();
                    $user = $this->db->get_where('karyawan', ['npk' => $row['npk']])->row_array(); ?>
                    <tr>
                      <td><?= $row['id']; ?></td>
                      <td><?= $row['saldo_awal']; ?></td>
                      <td><?= $row['saldo_digunakan']; ?></td>
                      <td><?= $row['saldo']; ?></td>
                      <td><?= $row['kategori']; ?></td>
                      <td><?= $row['keterangan']; ?></td>
                      <td><?= date('d M Y', strtotime($row['expired'])); ?></td>
                      <td><?= $row['status']; ?></td>
                      <td class="text-right">
                        <?php if ($row['saldo_digunakan'] > 0): ?>
                          <a href="<?= base_url('cuti/saldo_riwayat/'.$row['id'].'/'.time()); ?>" class="btn btn-link btn-info btn-just-icon" target="_blank" role="button" aria-disabled="false"><i class="material-icons">plagiarism</i></a>
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
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalRsvTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-info text-center">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  <i class="material-icons">clear</i>
              </button>
              <h4 class="card-title">ALASAN PEMBATALAN</h4>
          </div>
        </div>
      <form class="form" method="post" action="<?= base_url('reservasi/batalrsv'); ?>">
          <div class="modal-body">
              <input type="hidden" class="form-control disabled" name="id" >
              <textarea rows="3" class="form-control" name="catatan" placeholder="Contoh : Tidak jadi berangkat" required></textarea>
          </div>
          <div class="modal-footer justify-content-right">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
              <button type="submit" class="btn btn-danger">BATALKAN!</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="tambahCuti" tabindex="-1" role="dialog" aria-labelledby="tambahCutiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahCutiLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('cuti/saldo/add'); ?>">
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                            <button type="submit" class="btn btn-success">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>