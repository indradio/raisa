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
                                                    <th class="disabled-sorting">Actions</th>
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
                                                        <td><a href="<?= base_url('cekdl/hapus_anggota/') . $perjalanan['id'] . '/' . $ang['karyawan_inisial']; ?>" class="badge badge-danger">HAPUS</a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php if ($perjalanan['jenis_perjalanan'] != 'TA') { ?>
                                        <button type="button" class="btn btn-facebook" data-toggle="modal" data-target="#tambahPeserta" data-id="<?= $perjalanan['id']; ?>">Tambah Peserta</button>
                                    <?php } ?>
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
                                        <input type="number" class="form-control" name="kmberangkat" minLength="4" required="true" />
                                    </div>
                                    <label class="col-sm-12 label-on-right">
                                        <code>Kilometer yg diinput minimal 4 digit.</code>
                                    </label>
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
                                <label class="col-md-2 col-form-label"></label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <p class="mb-0">Perhatikan hal-hal berikut:</p>
                                        <p class="mb-0">1. Pengemudi dan peserta yang tertulis sudah benar </p>
                                        <p class="mb-0">2. Kendaraan yang berangkat sudah sesuai dengan yang dipesan</p>
                                        <p class="mb-0">3. Kendaraan dalam kondisi layak jalan</p>
                                        <p class="mb-0">4. Pengemudi dalam kondisi baik
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="check" name="check" value="1">
                                            Saya sudah memastikan hal-hal di atas semuanya benar.
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <button type="submit" class="btn btn-fill btn-success" id="submit">BERANGKAT!</button>
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

<!-- Modal Tambah Peserta -->
<div class="modal fade" id="tambahPeserta" tabindex="-1" role="dialog" aria-labelledby="tambahPesertaTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Peseta perjalanan</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('cekdl/tambahpeserta'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-4 col-form-label">Nomor Perjalanan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Tambah Peserta</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="anggota[]" data-style="select-with-transition" multiple title="Pilih Peserta" data-live-search="true" data-size="7">
                                            <?php
                                            $queryKaryawan = "SELECT *
                                                FROM `karyawan`
                                                WHERE `is_active` = '1' AND `status` = '1'
                                                ORDER BY `nama` ASC
                                                ";
                                            $Karyawan = $this->db->query($queryKaryawan)->result_array();
                                            foreach ($Karyawan as $k) : ?>
                                                <option value="<?= $k['inisial']; ?>"><?= $k['nama']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success">TAMBAH PESERTA</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>