<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 align-content-start">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">update</i>
                        </div>
                        <h4 class="card-title">Persetujuan Realisasi Lembur</h4>
                    </div>
                    <form class="form" method="post" action="<?= base_url('lembur/setujui_realisasi'); ?>">
                    <div class="card-body">
                        <div class="row col-md-12">
                            <div class="row col-md-6">
                                <div class="row" hidden>
                                    <label class="col-ml-5 col-form-label">Lembur ID</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="id" name="id" value="<?= $lembur['id']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12" hidden>
                                    <label class="col-ml-5 col-form-label">Total Aktivitas</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                        <?php
                                            $lid = $lembur['id'];
                                            $queryLembur = "SELECT COUNT(*)
                                                    FROM `aktivitas`
                                                    WHERE `link_aktivitas` = '$lid' ";
                                                    $totalLembur = $this->db->query($queryLembur)->row_array();
                                                    $totalAktivitas = $totalLembur['COUNT(*)'];
                                        ;?>
                                            <input type="text" class="form-control disabled" id="total_aktivitas" name="total_aktivitas" value="<?= $totalAktivitas; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label class="col-ml-5 col-form-label">Nama</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="nama" name="nama" value="<?= $lembur['nama']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label class="col-ml-5 col-form-label">Tanggal Mulai</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datetimepicker disabled" id="tglmulai" name="tglmulai" value="<?= $lembur['tglmulai_aktual']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label class="col-ml-5 col-form-label">Tanggal Selesai</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datetimepicker disabled" id="tglselesai" name="tglselesai" value="<?= $lembur['tglselesai_aktual']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row col-md-6">
                                <div class="row col-md-12">
                                <label class="col-ml-5 col-form-label">Lokasi Lembur</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="<?= $lembur['lokasi']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label class="col-ml-5 col-form-label">Durasi Lembur</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= $lembur['durasi_aktual']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label class="col-ml-5 col-form-label">Status</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <?php $status = $this->db->get_where('lembur_status', ['id' => $lembur['status']])->row_array(); ?>
                                            <input type="text" class="form-control disabled" id="status" name="status" value="<?= $status['nama']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="toolbar">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover"  cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>jenis Aktivitas</th>
                                        <th>Kategori</th>
                                        <th>Rencana Aktivitas</th>
                                        <th>Durasi/Jam</th>
                                        <th>Hasil</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>jenis Aktivitas</th>
                                        <th>Kategori</th>
                                        <th>Rencana Aktivitas</th>
                                        <th>Durasi/Jam</th>
                                        <th>Hasil</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($aktivitas as $a) : ?>
                                        <tr>
                                            <td><?= $a['jenis_aktivitas']; ?></td>
                                            <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                            <td><?= $k['nama']; ?>  <small>(<?= $a['copro']; ?>)</small></td>
                                            <td><?= $a['aktivitas']; ?></td>
                                            <td><?= $a['durasi']; ?></td>
                                            <td><?= $a['deskripsi_hasil']; ?></td>
                                            <?php $status = $this->db->get_where('aktivitas_status', ['id' => $a['status']])->row_array(); ?>
                                                <td><?= $status['nama']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php if ($lembur['status'] !='4'){ ?>
                                    <button type="submit"  id="setujui" class="btn btn-sm btn-success">SETUJUI</button>
                                    <a href="#" id="batalAktivitas" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                                <?php }else{ ?>
                                    <button type="submit"  id="setujui" class="btn btn-sm btn-success disabled">SETUJUI</button>
                                    <a href="#" id="batalAktivitas" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                                <?php }; ?>
                                <a href="<?= base_url('lembur/persetujuan_lembur') ?>" class="btn btn-sm btn-default" role="button">Kembali</a>
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
<!-- Modal Batal Aktivitas-->
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalAktivitasTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-primary text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">ALASAN PEMBATALAN</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('lembur/batal_lembur'); ?>">
          <div class="modal-body">
            <input type="text" class="form-control disabled" name="id">
            <textarea rows="2" class="form-control" name="catatan" id="catatan" placeholder="Keterangan Pembatalan Lembur" required></textarea>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-rose">BATALKAN REALISASI LEMBUR INI!</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

