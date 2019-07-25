    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">directions_car</i>
                            </div>
                            <h4 class="card-title">Data Perjalanan</h4>
                        </div>
                        <div class="card-body ">
                            <form action="<?= base_url('reservasi/dl1c1_proses'); ?>" method="post">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Kepemilikan</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" name="kepemilikan" data-style="select-with-transition" title="Pilih" data-size="7" required>
                                                <?php
                                                $queryKendaraan = "SELECT *
                                    FROM `kendaraan_status`
                                    WHERE `id` != 1
                                    ORDER BY `id` ASC
                                    ";
                                                $Kendaraan = $this->db->query($queryKendaraan)->result_array();
                                                foreach ($Kendaraan as $kend) : ?>
                                                    <option value="<?= $kend['nama']; ?>"><?= $kend['nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Nomor Polisi</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="nopol" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Tujuan</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" name="tujuan[]" data-style="select-with-transition" multiple title="Pilih Tujuan" data-size="7" required>
                                                <?php
                                                $queryTujuan = "SELECT *
                                    FROM `customer`
                                    ORDER BY `id` DESC
                                    ";
                                                $tujuan = $this->db->query($queryTujuan)->result_array();
                                                foreach ($tujuan as $tjn) : ?>
                                                    <option value="<?= $tjn['inisial']; ?>"><?= $tjn['nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Tujuan Lainnya</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="tlainnya">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Keperluan</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <textarea rows="2" class="form-control" name="keperluan" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Anggota Perjalanan</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" name="anggota[]" data-style="select-with-transition" multiple title="Pilih Anggota" data-size="7" required>
                                                <?php
                                                $queryKaryawan = "SELECT *
                                    FROM `karyawan`
                                    WHERE `npk` != {$this->session->userdata('npk')} AND `npk` != '1111'
                                    ORDER BY `nama` ASC
                                    ";
                                                $Karyawan = $this->db->query($queryKaryawan)->result_array();
                                                foreach ($Karyawan as $kry) : ?>
                                                    <option value="<?= $kry['inisial']; ?>"><?= $kry['nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2"></label>
                                    <div class="col-md-9">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="ikut" value="<?= ', ' . $this->session->userdata('inisial'); ?>"> Saya ikut serta dalam perjalanan ini.
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
                                            <button type="submit" class="btn btn-fill btn-rose">Berikutnya</button>
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