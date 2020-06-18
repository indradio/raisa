<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <strong>UJI COBA FITUR ESTIMASI BIAYA & PENYELESAIAN PERJALANAN DINAS</strong>
                    </br>
                    </br>Dalam tahap uji coba aplikasi
                </div>
            </div>
        </div>
        <!-- Banner -->
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Estimasi Biaya</h4>
                    </div>
                    <div class="card-body ">
                        <form class="form-horizontal" action="<?= base_url('reservasi/dl1d_proses'); ?>" method="post">
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
                                <label class="col-md-2 col-form-label">Tanggal</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="tgl" name="tgl" value="<?= date("d M Y", strtotime($reservasi_temp['tglberangkat'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Jam</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="jam" name="jam" value="<?= date("H:i", strtotime($reservasi_temp['jamberangkat'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamkembali'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Peserta</label>
                                <div class="col-md-7">
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <?php if ($reservasi_temp['uang_saku']>0){ echo '<th>Uang Saku</th>'; } ?>
                                                    <?php if ($reservasi_temp['insentif_pagi']>0){ echo '<th>Insentif</th>';} ?>
                                                    <?php if ($reservasi_temp['um_pagi']>0){ echo '<th>Pagi</th>';} ?>
                                                    <?php if ($reservasi_temp['um_siang']>0){ echo '<th>Siang</th>';} ?>
                                                    <?php if ($reservasi_temp['um_malam']>0){ echo '<th>Malam</th>';} ?>
                                                    <th class="disabled-sorting">Actions</th>
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
                                                        <td><?= $ang['karyawan_nama']; ?></td>
                                                        <?php if ($reservasi_temp['uang_saku']>0){ echo '<td>'.number_format($ang['uang_saku'], 0, ',', '.').'</td>'; } ?>
                                                        <?php if ($reservasi_temp['insentif_pagi']>0){ echo '<td>'.number_format($ang['insentif_pagi'], 0, ',', '.').'</td>';} ?>
                                                        <?php if ($reservasi_temp['um_pagi']>0){ echo '<td>'.number_format($ang['um_pagi'], 0, ',', '.').'</td>';} ?>
                                                        <?php if ($reservasi_temp['um_siang']>0){ echo '<td>'.number_format($ang['um_siang'], 0, ',', '.').'</td>';} ?>
                                                        <?php if ($reservasi_temp['um_malam']>0){ echo '<td>'.number_format($ang['um_malam'], 0, ',', '.').'</td>';} ?>
                                                        <td><a href="<?= base_url('reservasi/hapuspeserta/') . $reservasi_temp['id'] . '/' . $ang['karyawan_inisial']; ?>" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahPeserta" data-id="<?= $reservasi_temp['id']; ?>">TAMBAH PESERTA</button> -->
                                </div>
                            </div>
                            <p>
                            
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Biaya Taksi/Sewa</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <input type="number" class="form-control" id="taksi" name="taksi" value="<?= $reservasi_temp['taksi']; ?>" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Biaya BBM</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <input type="number" class="form-control" id="bbm" name="bbm" value="<?= $reservasi_temp['bbm']; ?>" disabled="true" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Biaya Tol</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <input type="number" class="form-control" id="tol" name="tol" value="<?= $reservasi_temp['tol']; ?>" required />
                                            </br><small>*Biaya tol jika menggunakan uang pribadi, kosongkan jika menggunakan e-toll dari GA.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Biaya Parkir & Lainnya</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <input type="number" class="form-control" id="parkir" name="parkir" value="<?= $reservasi_temp['parkir']; ?>" required />
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
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <button type="submit" class="btn btn-fill btn-success" id="submit">SELANJUTNYA</button>
                                            <a href="<?= base_url('reservasi/dl1c1'); ?>" class="btn btn-link btn-default">Kembali</a>
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