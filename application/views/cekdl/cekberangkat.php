<div class="content">
    <?php date_default_timezone_set('asia/jakarta'); ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Perjalanan Dinas Luar</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('cekdl/cekberangkat_proses'); ?>" method="post">
                            <div class="row">
                                <label class="col-md-2 col-form-label">No. Perjalanan DL</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id" value="<?= $perjalanan['id']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Jenis Perjalanan DL</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="jenis" value="<?= $perjalanan['jenis_perjalanan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Nama</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nama" value="<?= $perjalanan['nama']; ?>">
                                        <input type="text" class="form-control disabled" name="npk" value="<?= $perjalanan['npk']; ?>" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Nomor Polisi</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nopol" value="<?= $perjalanan['nopol']; ?>">
                                        <input type="text" class="form-control disabled" name="kepemilikan" value="<?= $perjalanan['kepemilikan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tanggal Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="tglberangkat" name="tglberangkat" value="<?= date("d / m / Y", strtotime($perjalanan['tglberangkat'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Jam Keberangkatan*</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="time" class="form-control disabled" id="jamberangkat" name="jamberangkat" value="<?= date('H:i:s'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Peserta</label>
                                <div class="col-md-5">
                                    <div class="material-datatables">
                                        <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Inisial</th>
                                                    <th>Nama</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $queryAnggota = "SELECT *
                                                        FROM `perjalanan_anggota`
                                                        WHERE `perjalanan_id` = '{$perjalanan['id']}'
                                                        ";
                                                $anggota = $this->db->query($queryAnggota)->result_array();
                                                foreach ($anggota as $ang) : ?>
                                                    <tr>
                                                        <td><?= $ang['karyawan_inisial']; ?></td>
                                                        <td><?= $ang['karyawan_nama']; ?></td>
                                                        <td><a href="<?= base_url('cekdl/hapus_anggota/') . $perjalanan['id'] . '/' . $ang['karyawan_inisial']; ?>" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahPeserta" data-id="<?= $perjalanan['id']; ?>">Tambahkan</button>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Pengemudi</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="supirberangkat" data-style="select-with-transition" title="Pilih Pengemudi" data-size="7" required>
                                            <option value="UMUM">Pengemudi Umum</option>
                                            <?php
                                            $peserta = $this->db->get_where('perjalanan_anggota', ['perjalanan_id' =>  $perjalanan['id']])->result_array();
                                            foreach ($peserta as $p) : ?>
                                                <option value="<?= $p['karyawan_inisial']; ?>"><?= $p['karyawan_nama']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Kilometer Awal*</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" name="kmberangkat" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Catatan <p><small> *Opsional</small></p></label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control" name="catatan"></textarea>
                                        <small> Mohon mencantumkan nama jika memberikan catatan</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <button type="submit" class="btn btn-fill btn-success">BERANGKAT!</button>
                                        <a href="<?= base_url('cekdl/berangkat'); ?>" class="btn btn-fill btn-default">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>