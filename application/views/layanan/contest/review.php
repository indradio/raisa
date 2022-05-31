<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Banner</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <a href="<?= base_url('layanan/informasi')?>" class="btn btn-success">
                            <span class="btn-label">
                                <i class="material-icons">keyboard_arrow_left</i>
                            </span>
                            KEMBALI KE UTAMA</a>
                    </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Banner</th>
                                        <th>Title</th>
                                        <th>Creator</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Banner</th>
                                        <th>Title</th>
                                        <th>Creator</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        foreach ($banner as $row) : ?>
                                            <tr>
                                                <td>
                                                    <div class="img-container">
                                                        <img src="<?= base_url(); ?>assets/img/info/<?= $row['gambar_banner']; ?>" alt="..." />
                                                    </div>
                                                </td>
                                                <td><?= $row['judul']; ?></td>
                                                <td><?= $row['created_by']; ?></td>
                                                <td class="text-right">
                                                    <a href="#" class="btn btn-sm btn-round btn-success btn-sm" data-toggle="modal" data-target="#approveBanner" data-id="<?= $row['id']; ?>">APPROVE</a>
                                                    <a href="#" class="btn btn-sm btn-round btn-danger btn-sm" data-toggle="modal" data-target="#rejectBanner" data-id="<?= $row['id']; ?>">REJECT</a>
                                                </td>
                                            </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        <!-- </div> -->
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->

<!-- Modal Upload Baner-->
<div class="modal fade" id="approveBanner" tabindex="-1" role="dialog" aria-labelledby="approveBannerTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                    <div class="modal-body">
                    <?= form_open_multipart('layanan/contest/approve'); ?>
                     
                        <input type="hidden" class="form-control" id="id" name="id" required>
                 
                        <div class="row">
                            <label class="col-md-4 col-form-label">Masa Aktif</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datepicker" id="berlaku" name="berlaku" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">APPROVE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Banner-->
<div class="modal fade" id="rejectBanner" tabindex="-1" role="dialog" aria-labelledby="rejectBannerTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
      <?= form_open_multipart('layanan/contest/reject'); ?>
          <div class="modal-body">
              <input type="hidden" class="form-control" id="id" name="id" />
              <h4 class="card-title text-center">Yakin ingin me-REJECT BANNER ini?</h4>
                <div class="row">
                    <label class="col-md-12 col-form-label">Alasan</label>
                    <div class="col-md-12">
                        <div class="form-group has-default">
                            <textarea rows="3" class="form-control" name="deskripsi" required></textarea>
                        </div>
                    </div>
                </div>
          </div>
          <div class="modal-footer justify-content-right">
              <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">REJECT!</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        $('#approveBanner').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') 
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id);
        });
        
        $('#rejectBanner').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') 
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id);
        });
    });
</script>