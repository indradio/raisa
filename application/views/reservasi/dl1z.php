<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Rincian Perjalanan</h4>
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
                                <label class="col-md-2 col-form-label">Kendaraan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nopol" value="<?= $reservasi_temp['nopol'] . ' (' . $reservasi_temp['kendaraan'] . ')'; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Berangkat</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="berangkat" name="berangkat" value="<?= date("d M Y", strtotime($reservasi_temp['tglberangkat'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamberangkat'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="kembali" name="kembali" value="<?= date("d M Y", strtotime($reservasi_temp['tglkembali'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamkembali'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-2 col-form-label">Tanggal Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="tglberangkat" name="tglberangkat" value="<?= date("d / m / Y", strtotime($reservasi_temp['tglberangkat'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-2 col-form-label">Jam Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="time" class="form-control disabled" id="jamberangkat" name="jamberangkat" value="<?= $reservasi_temp['jamberangkat']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-2 col-form-label">Tanggal Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="tglkembali" name="tglkembali" value="<?= date("d / m / Y", strtotime($reservasi_temp['tglkembali'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
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
                                <label class="col-md-2 col-form-label">Keperluan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control disabled" name="keperluan"><?= $reservasi_temp['keperluan']; ?></textarea>
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
                                <label class="col-md-2 col-form-label">Peserta</label>
                                <div class="col-md-5">
                                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahPeserta" data-id="<?= $reservasi_temp['id']; ?>">TAMBAH MAGANG</button> -->
                                    <div class="material-datatables">
                                        <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Inisial</th>
                                                    <th>Nama</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $this->db->where('reservasi_id', $reservasi_temp['id']);
                                                $totalpeserta = $this->db->get('perjalanan_anggota');
                                                if ($totalpeserta->num_rows() == 0) {
                                                    $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <strong>Maaf!</strong> Peserta perjalanan minimal 1 orang.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>');
                                                    redirect('reservasi/dl1c1');
                                                }

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
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <p>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Tunjangan </br><small>Estimasi</small></label>
                                    <div class="col-md-5">
                                        <div class="material-datatables">
                                            <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Biaya</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Uang Saku <small>(TAPP)</small></td>
                                                        <td><?= number_format($reservasi_temp['uang_saku'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Insentif Pagi</br><small>Berangkat < 05:00</small> </td> <td><?= number_format($reservasi_temp['insentif_pagi'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Makan Pagi <small>(TAPP)</br>Berangkat < 06:00</small> </td> <td><?= number_format($reservasi_temp['um_pagi'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Makan Siang</td>
                                                        <td><?= number_format($reservasi_temp['um_siang'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Makan Malam</br><small>Kembali > 19:30</small></td>
                                                        <td><?= number_format($reservasi_temp['um_malam'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <small>*Untuk Perjalanan TA masih dalam pengembangan. Silahkan gunakan penyelesaian manual ke HR dan GA.</small>
                                        </div>
                                    </div>
                                </div>
                                <p>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Rincian Biaya </br><small>Estimasi</small></label>
                                    <div class="col-md-5">
                                        <div class="material-datatables">
                                            <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Biaya</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Taksi/Sewa</br><small>Pribadi per KM</small> </td>
                                                        <td><?= number_format($reservasi_temp['taksi'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>BBM</td>
                                                        <td><?= number_format($reservasi_temp['bbm'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tol</td>
                                                        <td><?= number_format($reservasi_temp['tol'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Parkir & Lainnya</td>
                                                        <td><?= number_format($reservasi_temp['parkir'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <label class="col-md-2 col-form-label">Total Biaya </br><small>Estimasi</small></label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="biaya" value="<?= number_format($reservasi_temp['total'], 0, ',', '.'); ?>">
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">PIC Perjalanan</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" name="pic" data-style="select-with-transition" title="Pilih PIC" data-size="10" required>
                                                <?php
                                                $peserta = $this->db->get_where('perjalanan_anggota', ['reservasi_id' => $reservasi_temp['id']])->result_array();
                                                foreach ($peserta as $p) : ?>
                                                    <option value="<?= $p['karyawan_inisial']; ?>"><?= $p['karyawan_nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Catatan</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <textarea rows="3" class="form-control" name="catatan"><?= $reservasi_temp['catatan']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label"></label>
                                    <div class="col-md-8">
                                        <?php if ($reservasi_temp['kendaraan']=='Pribadi'){ ?>
                                            <div class="form-group has-default">
                                            <p class="mb-0"><mark>Syarat dan ketentuan penggunaan mobil pribadi untuk perjalanan dinas luar:</mark></p>
                                            <p class="mb-0 text-danger"><b>1. Pastikan pengemudi memiliki sim A aktif.</p>
                                            <p class="mb-0 text-danger">2. Pastikan status pajak kendaraan aktif.</p>
                                            <p class="mb-0 text-danger">3. Mobil sudah berasuransi dan status perlindungannya aktif.</p>
                                            <p class="mb-0 text-danger">4. Segala kejadian selama perjalanan dinas menjadi tanggung jawab pengemudi.</p>
                                            <p class="mb-0 text-danger">5. Patuhi semua rambu-rambu lalu lintas dan undang-undang yang berlaku.</p>
                                            <p class="mb-0 text-danger">6. Patuhi peraturan GA yang berlaku.</b>
                                        </div>
                                        <?php }else{ ?>
                                        <div class="form-group has-default">
                                            <p class="mb-0">Perhatikan hal-hal berikut:</p>
                                            <p class="mb-0">1. Mengemudilah dengan aman dan gunakan selalu sabuk keselamatan.</p>
                                            <p class="mb-0">2. Patuhi semua rambu-rambu lalu lintas dan undang-undang yang berlaku.</p>
                                            <p class="mb-0">3. Jangan menaruh barang-barang di dashboard karena dapat mengganggu fungsi airbag.</p>
                                            <p class="mb-0">4. Jagalah kebersihan kendaraan, jangan tinggalkan sampah dan barang-barang lainnya.</p>
                                            <p class="mb-0">5. Hargai pengguna berikutnya. Kembalikan kendaraan dalam kondisi bersih dan rapih.</p>
                                            <p class="mb-0">6. Patuhi peraturan GA yang berlaku.
                                        </div>
                                        <?php }; ?>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" id="check" name="check" value="1" required="true">
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
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <button type="submit" class="btn btn-fill btn-success" id="submit">RESERVASI</button>
                                            <a href="<?= base_url('reservasi/dl1d'); ?>" class="btn btn-link btn-default">Kembali</a>
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
<script>
    $(document).ready(function() {
        var checker = document.getElementById('check');
        var sendbtn = document.getElementById('submit');
        sendbtn.disabled = true;
        // when unchecked or checked, run the function
        checker.onchange = function() {
            if (this.checked) {
                sendbtn.disabled = false;
            } else {
                sendbtn.disabled = true;
            }
        }
    });
</script>