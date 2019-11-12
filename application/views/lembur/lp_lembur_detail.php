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
                        <h4 class="card-title">Data Lembur</h4>
                    </div>
                    <form class="form" method="post" action="<?= base_url('lembur/ajukan_realisasi'); ?>">
                        <div class="card-body">
                            <input type="text" class="form-control disabled" id="id" name="id" value="<?= $lembur['id']; ?>" hidden>
                                <div class="row col-md-12">
                                    <div class="form-group has-default">
                                        <label class="label">Nama</label>
                                        <input type="text" class="form-control disabled" id="nama" name="nama" value="<?= $lembur['nama']; ?>">
                                    </div>
                                </div>
                                    <div class="row col-md-12">
                                        <div class="form-group has-default">
                                            <label class="label">Tanggal Lembur</label>
                                            <input type="text" class="form-control disabled" id="nama" name="nama" value="<?= date('d-M H:i', strtotime($lembur['tglmulai_aktual'])); ?>">
                                                    </div>
                                                    </div>
                                                                <div class="row col-md-12">
                                                                    <div class="form-group has-default">
                                                                        <label class="label">Durasi Lembur</label>
                                                                        <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= date('H:i', strtotime($lembur['durasi_aktual'])).' Jam / '. $lembur['aktivitas']; ?> Aktivitas">
                                                                    </div>
                                                                    </div>
                                                                                <div class="row col-md-12">
                                        <div class="form-group has-default">
                                                <label class="label">Lokasi Lembur</label>
                                            <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="<?= $lembur['lokasi']; ?>">
                                        </div>
                            </div> 
                            <br>
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <!-- <th>No. Aktivitas</th> -->
                                            <th>Kategori</th>
                                            <!-- <th>WBS</th> -->
                                            <th>Aktivitas</th>
                                            <th>Deskripsi Hasil</th>
                                            <th>Durasi <small>(Jam)</small></th>
                                            <th>Hasil <small>(%)</small></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <!-- <th>No. Aktivitas</th> -->
                                            <th>Kategori</th>
                                            <!-- <th>WBS</th> -->
                                            <th>Aktivitas</th>
                                            <th>Deskripsi Hasil</th>
                                            <th>Durasi</th>
                                            <th>Hasil</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($aktivitas as $a) : ?>
                                            <tr>
                                                <!-- <td><?= $a['id']; ?></td> -->
                                                <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                                <td><?= $k['nama']; ?> <small>(<?= $a['copro']; ?>)</small></td>
                                                <!-- <td><?= $a['wbs']; ?></td> -->
                                                <td><?= $a['aktivitas']; ?></td>
                                                <td><?= $a['deskripsi_hasil']; ?></td>
                                                <td><?= $a['durasi']; ?> jam</td>
                                                <?php $status = $this->db->get_where('aktivitas_status', ['id' => $a['status']])->row_array(); ?>
                                                <td><?= $status['nama'] .', '.$a['progres_hasil']; ?>%</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <!-- <a href="<?= base_url('kadep/lembur_batalkan/'.$lembur['id']); ?>" class="btn btn-danger" role="button">BATALKAN</a> -->
                                <a href="<?= base_url('kadep/lembur'); ?>" class="btn btn-default" role="button">KEMBALI</a>
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