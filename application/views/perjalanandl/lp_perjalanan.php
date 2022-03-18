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
                        <h4 class="card-title">Laporan Perjalanan Dinas</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('perjalanandl/laporan'); ?>" method="post">
                        <div class="row">
                                <label class="col-md-2 col-form-label">Laporan Berdasarkan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="laporan" id="laporan" data-style="select-with-transition" title="Pilih Laporan" data-size="7" required>
                                            <option value="1">Kategori</option>
                                            <option value="2">Perjalanan</option>
                                            <option value="3">Kendaraan</option>
                                            <option value="4">Peserta</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                                <label class="col-md-2 col-form-label">Tahun</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="tahun" id="tahun" data-style="select-with-transition" title="Pilih Tahun" data-size="7" required>
                                        <?php for ($y = date('Y')-2; $y <= date('Y'); $y++) { ?>
                                            <option value="<?= $y; ?>" <?php echo ($tahun == $y) ? 'selected' : ''; ?>><?= $y; ?></option>
                                        <?php };?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                                <label class="col-md-2 col-form-label">Bulan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="bulan" id="bulan" data-style="select-with-transition" title="Pilih Bulan" data-size="7" required>
                                            <option value="01" <?= ($bulan == '01') ? 'selected' : ''; ?>>Januari</option>
                                            <option value="02" <?= ($bulan == '02') ? 'selected' : ''; ?>>Febuari</option>
                                            <option value="03" <?= ($bulan == '03') ? 'selected' : ''; ?>>Maret</option>
                                            <option value="04" <?= ($bulan == '04') ? 'selected' : ''; ?>>April</option>
                                            <option value="05" <?= ($bulan == '05') ? 'selected' : ''; ?>>Mei</option>
                                            <option value="06" <?= ($bulan == '06') ? 'selected' : ''; ?>>Juni</option>
                                            <option value="07" <?= ($bulan == '07') ? 'selected' : ''; ?>>Juli</option>
                                            <option value="08" <?= ($bulan == '08') ? 'selected' : ''; ?>>Agustus</option>
                                            <option value="09" <?= ($bulan == '09') ? 'selected' : ''; ?>>September</option>
                                            <option value="10" <?= ($bulan == '10') ? 'selected' : ''; ?>>Oktober</option>
                                            <option value="11" <?= ($bulan == '11') ? 'selected' : ''; ?>>November</option>
                                            <option value="12" <?= ($bulan == '12') ? 'selected' : ''; ?>>Desember</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <button type="submit" class="btn btn-fill btn-success">SUBMIT</button>
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