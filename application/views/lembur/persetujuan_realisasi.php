<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 align-content-start">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">update</i>
                        </div>
                        <h4 class="card-title">Persetujuan Realisasi</h4>
                    </div>
                    <form class="form" method="post" action="<?= base_url('lembur/setujui_realisasi'); ?>">
                    <div class="card-body">
                    </br>
                            <div class="form-group" hidden>
                                <label for="exampleID" class="bmd-label-floating">ID</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?= $lembur['id']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleNama" class="bmd-label-floating">Nama</label>
                                <input type="text" class="form-control disabled" id="nama" name="nama" value="<?= $lembur['nama']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-floating">Tanggal & Jam</label>
                                <input type="text" class="form-control disabled" id="tglmulai" name="tglmulai" value="<?= date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($lembur['tglselesai'])); ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleDurasi" class="bmd-label-floating">Durasi</label>
                                <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= $lembur['durasi']; ?> Jam">
                            </div>
                            <div class="form-group">
                                <label for="exampleLokasi" class="bmd-label-floating">Lokasi</label>
                                <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="<?= $lembur['lokasi']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleKategori" class="bmd-label-floating">Kategori</label>
                                <?php if ($lembur['kategori']=='OT'){
                                    echo '<input type="text" class="form-control disabled" id="kategori_lembur" name="kategori_lembur" value="LEMBUR">';
                                } elseif ($lembur['kategori']=='GH'){
                                    echo '<input type="text" class="form-control disabled" id="kategori_lembur" name="kategori_lembur" value="GANTI HARI">';
                                } elseif ($lembur['kategori']=='TC'){
                                    echo '<input type="text" class="form-control disabled" id="kategori_lembur" name="kategori_lembur" value="TABUNGAN CUTI">';
                                } ?>
                            </div>
                            <div class="form-group">
                                <label for="exampleCatatan" class="bmd-label-floating">Catatan</label>
                                <textarea rows="3" class="form-control disabled" name="catatan" id="catatan"><?= $lembur['catatan']; ?></textarea>
                            </div> 
                            </br>
                        <div class="toolbar">
                        <?php
                        if ($lembur['dept_id']==11 or $lembur['dept_id']==13)
                          {
                            $durasi = $lembur['durasi'];
                            $panjang = 100 / $durasi;

                            $this->db->select_sum('durasi');
                            $this->db->where('link_aktivitas', $lembur['id']);
                            $this->db->where('kategori', '1');
                            $query1 = $this->db->get('aktivitas');
                            $kategori1 = $query1->row()->durasi;
                            $bar1 = $kategori1 * $panjang;
                            $produktif1 = ($kategori1 / $durasi) * 100;

                            $this->db->select_sum('durasi');
                            $this->db->where('link_aktivitas', $lembur['id']);
                            $this->db->where('kategori', '2');
                            $query2 = $this->db->get('aktivitas');
                            $kategori2 = $query2->row()->durasi;
                            $bar2 = $kategori2 * $panjang;
                            $produktif2 = ($kategori2 / $durasi) * 100;

                            $this->db->select_sum('durasi');
                            $this->db->where('link_aktivitas', $lembur['id']);
                            $this->db->where('kategori', '3');
                            $query3 = $this->db->get('aktivitas');
                            $kategori3 = $query3->row()->durasi;
                            $bar3 = $kategori3 * $panjang;
                            $produktif3 = ($kategori3 / $durasi) * 0;

                            $produktifitas = $produktif1 + $produktif2 + $produktif3;
                            ?>
                            <b><h3>Porsi ke COPRO : <?= number_format((float)$produktifitas, 2, ',', ''); ?> % </h3></b>
                            
                            <div class="progress" style="width: 100%">
                                <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $bar1; ?>%" aria-valuenow="<?= $kategori1; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                                <div class="progress-bar progress-bar-warning" role="progressbar" style="width: <?= $bar2; ?>%" aria-valuenow="<?= $kategori2; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                                <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $bar3; ?>%" aria-valuenow="<?= $kategori3; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                            </div>
                          <?php } ?>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover"  cellspacing="0" width="100%" style="width:100%">
                              <thead>
                                  <tr>
                                      <th>Kategori</th>
                                      <th>Aktivitas</th>
                                      <th>Deskripsi</th>
                                      <th>Progres</th>
                                      <th>Durasi <small>(Jam)</small></th>
                                  </tr>
                              </thead>
                              <tfoot>
                                  <tr>
                                      <th>Kategori</th>
                                      <th>Aktivitas</th>
                                      <th>Deskripsi</th>
                                      <th>Progres</th>
                                      <th>Durasi <small>(Jam)</small></th>
                                  </tr>
                              </tfoot>
                              <tbody>
                                  <?php foreach ($aktivitas as $a) : ?>
                                      <tr>
                                          <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                          <td><?= $k['nama']; ?> <small>(<?= $a['copro']; ?>)</small></td>
                                          <td><?= $a['aktivitas']; ?></td>
                                          <td><?= $a['deskripsi_hasil']; ?></td>
                                          <td><?= $a['progres_hasil']; ?>%</td>
                                          <td><?= $a['durasi']; ?> jam</td>
                                      </tr>
                                  <?php endforeach; ?>
                              </tbody>
                            </table>
                          </div>
                                </p>
                                 <!-- Button SUBMIT -->
                                <?php if ($lembur['status'] == 5 or $lembur['status'] == 6){ ?>
                                    <button type="submit" id="setujui" class="btn btn-sm btn-success">SETUJUI</button>
                                    <a href="#" id="revisiAktivitas" class="btn btn-sm btn-warning" role="button" aria-disabled="false" data-toggle="modal" data-target="#revisiRealisasi" data-id="<?= $lembur['id']; ?>">REVISI</a>
                                    <a href="#" id="batalAktivitas" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                                <?php }else{
                                    echo '<button type="submit" id="setujui" class="btn btn-sm btn-success disabled">SETUJUI</button>';
                                    echo '<a href="#" id="revisiAktivitas" class="btn btn-sm btn-warning disabled">REVISI</a>';
                                    echo '<a href="#" id="batalAktivitas" class="btn btn-sm btn-danger disabled">BATALKAN</a>';
                                }; ?>
                                <a href="<?= base_url('lembur/persetujuan_lembur') ?>" class="btn btn-sm btn-default" role="button">Kembali</a>    
                        </div>
                      </form>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
</div>
<!-- Modal Batal Aktivitas-->
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalAktivitasTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-info text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">PEMBATALAN LEMBUR</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('lembur/batal_lembur'); ?>">
          <div class="modal-body">
            <input type="hidden" class="form-control disabled" name="id">
            <textarea rows="3" class="form-control" name="catatan" id="catatan" placeholder="Berikan penjelasan untuk membatalkan" required></textarea>
          </div>
          <div class="modal-footer justify-content-right">
            <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
            <button type="submit" class="btn btn-success">SUBMIT PEMBATALAN</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Revisi Realisasi-->
<div class="modal fade" id="revisiRealisasi" tabindex="-1" role="dialog" aria-labelledby="revisiRealisasiTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-info text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">REVISI LEMBUR</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('lembur/revisi_lembur'); ?>">
          <div class="modal-body">
            <input type="hidden" class="form-control disabled" name="id">
            <textarea rows="3" class="form-control" name="catatan" id="catatan" placeholder="Berikan penjelasan untuk revisi" required></textarea>
          </div>
          <div class="modal-footer justify-content-right">
            <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
            <button type="submit" class="btn btn-success">SUBMIT REVISI</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('#revisiRealisasi').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') 
        var modal = $(this)
        modal.find('.modal-body input[name="id"]').val(id)
})

      });
  </script>