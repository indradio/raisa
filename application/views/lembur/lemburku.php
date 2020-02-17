<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="content">
    <div class="container-fluid">
        <?= $this->session->flashdata('jknotfound'); ?>
        <div class="row">
            <div class="col-md-12 align-content-start">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">update</i>
                        </div>
                        <?php $status = $this->db->get_where('lembur_status', ['id' => $lembur['status']])->row_array(); ?>
                        <h4 class="card-title">Lembur - <?= $lembur['id'].' <small>('.$status['nama'].')</small>'; ?></h4>
                    </div>
                    <form class="form" method="post" action="<?= base_url('lembur/ajukan_realisasi'); ?>">
                        <div class="card-body">
                        </br>
                        <form class="form" method="post" action="<?= base_url('lembur/ajukan_realisasi'); ?>">
                            <div class="form-group" hidden>
                                <label for="exampleID" class="bmd-label-floating">ID</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?= $lembur['id']; ?>">
                            </div>
                            <div class="form-group form-inline">
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
                            </div>
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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
                                <a href="<?= base_url('lembur/index/') ?>" class="btn btn-default" role="button">Kembali</a>
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
</form>