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
                            <form action="<?= base_url('reservasi/dl1c2_proses'); ?>" method="post">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Jenis Kendaraan</label>
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