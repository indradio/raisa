<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">weekend</i>
            </div>
            <p class="card-category">Saldo Cuti</p>
            <h3 class="card-title"></h3>
          </div>
          <form class="form" method="post" action="<?= base_url('role'); ?>">
          <div class="card-body">
                          <div class="form-group">
                              <label class="bmd-label">Kategori*</label></br>
                                <select class="selectpicker" name="user_role" id="user_role" title="Pilih" data-style="select-with-transition" data-size="5" data-width="block" data-live-search="false" onchange='this.form.submit()' required>
                                    <?php foreach ($user_role as $row) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['role'].' ('.$row['name'].')'; ?></option>
                                    <?php endforeach; ?>
                                </select>
                          </div>
            </div>
          <div class="card-footer">
            <div class="stats"></div>
              <a href="#" class="btn btn-facebook btn-block" data-toggle="modal" data-target="#tambahCuti">Ajukan Cuti</a>
            </div>
        </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Riwayat Cuti</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
            
              <!--        Here you can write extra buttons/actions for the toolbar              -->
              
            </div>
            <div class="material-datatables">
              <table id="dtdesc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Menu</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Menu</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($role as $row) : 
                    $user = $this->db->get_where('user_role', ['id' => $row['role_id']])->row_array();
                    $menu = $this->db->get_where('user_menu', ['id' => $row['menu_id']])->row_array(); ?>
                    <tr>
                    <td><?= $menu['menu'];?></td>
                      <td><?= $user['role']; ?></td>
                      <td><?= $user['name']; ?></td>
                      <td><a href="<?= base_url('role/delete/'.$row['id']); ?>" class="btn btn-danger btn-sm">Delete</a></td>
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
            <form class="form" method="post" action="<?= base_url('cuti/add'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <input type="hidden" class="form-control" id="npk" name="npk">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Dari*</label></br>
                              <input type="text" class="form-control datepicker" name="tgl1" id="tgl1" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Sampai*</label></br>
                              <input type="text" class="form-control datepicker" name="tgl2" id="tgl2" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Kategori*</label></br>
                                <select class="selectpicker" name="kategori" id="kategori" title="Pilih" data-style="select-with-transition" data-size="5" data-width="block" data-live-search="false" onchange="kategoriSelect(this);" required>
                                    <?php foreach ($saldo as $s) : ?>
                                        <option value="<?= $s['id']; ?>"><?= $s['kategori'].' ('.$s['saldo'].')'; ?></option>
                                    <?php endforeach; ?>
                                    <?php foreach ($kategori as $k) : ?>
                                        <option value="<?= $k['saldo_id']; ?>"><?= $k['kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            <button type="submit" class="btn btn-success">AJUKAN</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>