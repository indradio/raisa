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
            <h4 class="card-title">Persetujuan Jam Kerja</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
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
                                 <!-- Button SUBMIT -->
                                <a href="<?= base_url('jamkerja/persetujuan_approve/' . $jamkerja['id']) ?>" id="approve" class="btn btn btn-success" role="button" aria-disabled="false">APPROVE</a>
                                <a href="#" class="btn btn btn-warning" role="button" aria-disabled="false" data-toggle="modal" data-target="#revisiJamkerja" data-id="<?= $jamkerja['id']; ?>">REVISI</a>
                                <a href="<?= base_url('jamkerja/persetujuan') ?>" class="btn btn btn-link" role="button">Kembali</a>
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
<!-- Modal Revisi Jam Kerja-->
<div class="modal fade" id="revisiJamkerja" tabindex="-1" role="dialog" aria-labelledby="revisiJamkerjaTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-primary text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">ALASAN REVISI</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('jamkerja/persetujuan_revisi/' . $jamkerja['id']); ?>">
          <div class="modal-body">
            <input type="text" class="form-control disabled" name="id" value="<?= $jamkerja['id']; ?>">
            <textarea rows="2" class="form-control" name="catatan" id="catatan" placeholder="Kenapa laporan ini harus direvisi?" required></textarea>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-success mb-2">REVISI LAPORAN INI!</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>