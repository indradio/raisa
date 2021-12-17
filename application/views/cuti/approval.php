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
            <h4 class="card-title">Persetujuan Cuti</h4>
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
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Lama</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No. Cuti</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Lama</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($cuti as $row) : ?>
                    <tr onclick="#" data-toggle="modal" data-target="#approveCuti" 
                    data-id="<?= $row['id']; ?>" 
                    data-nama="<?= $row['nama']; ?>" 
                    data-tglcuti="<?= date('d M Y', strtotime($row['tgl_cuti1'])).' - '.date('d M Y', strtotime($row['tgl_cuti2'])); ?>" 
                    data-lama="<?= $row['lama']; ?> Hari" 
                    data-kategori="<?= $row['kategori']; ?>" 
                    data-keterangan="<?= $row['keterangan']; ?>">
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= date('d M Y', strtotime($row['tgl_cuti1'])); ?></td>
                        <td><?= $row['lama']; ?></td>
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

<div class="modal fade" id="approveCuti" tabindex="-1" role="dialog" aria-labelledby="approveCutiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveCutiLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('cuti/approve'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Nama</small></label></br>
                              <input type="text" class="form-control" name="nama" id="nama" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Tanggal</small></label></br>
                              <input type="text" class="form-control" name="tglcuti" id="tglcuti" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Lama</small></label></br>
                              <input type="text" class="form-control" name="lama" id="lama" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Cuti</small></label></br>
                              <input type="text" class="form-control" name="kategori" id="kategori" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Keterangan</small></label></br>
                              <textarea class="form-control has-success" id="keterangan" name="keterangan" rows="3" disabled></textarea>
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
                            <a href="#" class="btn btn-danger btn-link" data-toggle="modal" data-target="#rejectCuti" data-id="asdasd">REJECT</a>
                            <button type="submit" class="btn btn-success">APPROVE</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectCuti" tabindex="-1" role="dialog" aria-labelledby="rejectCutiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectCutiLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('cuti/reject'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Keterangan</small></label></br>
                              <textarea class="form-control has-success" id="keterangan" name="keterangan" rows="3"></textarea>
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
                            <button type="submit" class="btn btn-danger">REJECT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#approveCuti').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var nama = button.data('nama')
            var tglcuti = button.data('tglcuti')
            var lama = button.data('lama')
            var kategori = button.data('kategori')
            var keterangan = button.data('keterangan')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="nama"]').val(nama)
            modal.find('.modal-body input[name="tglcuti"]').val(tglcuti)
            modal.find('.modal-body input[name="lama"]').val(lama)
            modal.find('.modal-body input[name="kategori"]').val(kategori)
            modal.find('#keterangan').val(keterangan)
        })  

        $('#rejectCuti').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = $('#id').val()
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        })  
    });
</script>