<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Jadwal keberangkatan</h4>
                    </div>
                    <div class="card-body ">
                        <form class="form-horizontal" action="<?= base_url('reservasi/dl1z_proses'); ?>" method="post">
                            <div class="row">
                                <label class="col-md-2 col-form-label">Jenis Perjalanan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="jperj" value="<?= $reservasi_temp['jenis_perjalanan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Nomor Polisi</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nopol" value="<?= $reservasi_temp['nopol'] . ' (' . $reservasi_temp['kepemilikan'] . ')'; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tanggal Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="tglberangkat" name="tglberangkat" value="<?= date("d / m / Y", strtotime($reservasi_temp['tglberangkat'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Jam Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="time" class="form-control disabled" id="jamberangkat" name="jamberangkat" value="<?= $reservasi_temp['jamberangkat']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tanggal Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="tglkembali" name="tglkembali" value="<?= date("d / m / Y", strtotime($reservasi_temp['tglkembali'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Jam Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="time" class="form-control disabled" id="jamkembali" name="jamkembali" value="<?= $reservasi_temp['jamkembali']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tujuan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tujuan" value="<?= $reservasi_temp['tujuan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">COPRO</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="copro" value="<?= $reservasi_temp['copro']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Keperluan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control disabled" name="keperluan"><?= $reservasi_temp['keperluan']; ?></textarea>
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
                                                        WHERE `reservasi_id` = '{$reservasi_temp['id']}'
                                                        ";
                                                $anggota = $this->db->query($queryAnggota)->result_array();
                                                foreach ($anggota as $ang) :
                                                    $rsvnpk = $ang['npk'];
                                                    $tglberangkat = $reservasi_temp['tglberangkat'];
                                                    $querySaring1 = "SELECT *
                                                              FROM `reservasi`
                                                              WHERE `tglberangkat` <= '$tglberangkat' AND `tglkembali` >= '$tglberangkat' AND `status` != 0 AND `status` != 9
                                                              ";
                                                    $reservasi = $this->db->query($querySaring1)->result_array();
                                                    foreach ($reservasi as $rsv) :
                                                        $rsvid = $rsv['id'];
                                                        $querySaring2 = "SELECT COUNT(*)
                                                                        FROM `perjalanan_anggota`
                                                                        WHERE `reservasi_id` = '$rsvid' AND `npk` = '$rsvnpk'
                                                                        ";
                                                        $ketemu = $this->db->query($querySaring2)->row_array();
                                                        $total = $ketemu['COUNT(*)'];
                                                        if ($total >= 1) {
                                                            $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                <strong>Maaf!</strong> ' .  $ang['karyawan_nama'] . ' sudah ikut dalam perjalanan lain.
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span>
                                                                </button>
                                                              </div>');
                                                            redirect('reservasi/dl1c1');
                                                        }
                                                    endforeach; ?>
                                                    <tr>
                                                        <td><?= $ang['karyawan_inisial']; ?></td>
                                                        <td><?= $ang['karyawan_nama']; ?></td>
                                                        <td><a href="<?= base_url('reservasi/hapuspeserta/') . $reservasi_temp['id'] . '/' . $ang['karyawan_inisial']; ?>" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahPeserta" data-id="<?= $reservasi_temp['id']; ?>">TAMBAH MAGANG</button>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Catatan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <textarea rows="3" class="form-control disabled" name="catatan"><?= $reservasi_temp['catatan']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label"></label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <p class="mb-0">Perhatikan hal-hal berikut:</p>
                                        <p class="mb-0">1. Mengemudilah dengan aman dan gunakan selalu sabuk keselamatan.</p>
                                        <p class="mb-0">2. Jangan menaruh barang-barang di dashboard karena dapat mengganggu fungsi airbag.</p>
                                        <p class="mb-0">3. Jagalah kebersihan kendaraan, jangan tinggalkan sampah dan barang-barang lainnya.</p>
                                        <p class="mb-0">4. Hargai pengguna berikutnya. Kembalikan kendaraan dalam kondisi bersih dan rapih.</p>
                                        <p class="mb-0">5. Patuhi peraturan GA yang berlaku.
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="check" name="check" value="1">
                                            Ya, Saya setuju dengan ketentuan di atas dan siap dikenakan sanksi yang berlaku atas pelanggaran dan kelalaian yang saya lakukan.
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
                                        <button type="submit" class="btn btn-fill btn-success" id="submit">RESERVASI</button>
                                        <a href="<?= base_url('reservasi/dl1c1'); ?>" class="btn btn-fill btn-default">Kembali</a>
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
<div class="modal fade" id="tambahPeserta" tabindex="-1" role="dialog" aria-labelledby="tambahPesertaTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Tambah Peseta perjalanan</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('reservasi/tambahpeserta'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Nama</label>
                                <div class="col-md-7">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" id="nama" name="nama" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Departemen</label>
                                <div class="col-md-7">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="dept" data-style="select-with-transition" title="Pilih" data-size="6" required>
                                            <?php
                                            $queryDept = "SELECT *
                                                                    FROM `karyawan_dept`
                                                                    ORDER BY `id` ASC
                                                                    ";
                                            $dept = $this->db->query($queryDept)->result_array();
                                            foreach ($dept as $d) : ?>
                                                <option value="<?= $d['nama']; ?>"><?= $d['nama']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-primary btn-link btn-wd btn-lg">TAMBAH</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>