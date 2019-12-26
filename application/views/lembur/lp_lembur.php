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
                        <h4 class="card-title">Laporan Lembur</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('lembur/laporan'); ?>" method="post">
                        <div class="row">
                                <label class="col-md-2 col-form-label">Laporan Berdasarkan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="laporan" id="laporan" data-style="select-with-transition" title="Pilih Laporan" data-size="7" required>
                                            <option value="1">Jam & TUL</option>
                                            <option value="2">Pelembur</option>
                                            <option value="5">Copro</option>
                                            <!-- <option value="3">Pelembur</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                                <label class="col-md-2 col-form-label">Tahun</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="tahun" id="tahun" data-style="select-with-transition" title="Pilih Tahun" data-size="7" required>
                                            <option value="2019">2019</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                                <label class="col-md-2 col-form-label">Bulan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="bulan" id="bulan" data-style="select-with-transition" title="Pilih Bulan" data-size="7" required>
                                            <option value="01">Januari</option>
                                            <option value="02">Febuari</option>
                                            <option value="03">Maret</option>
                                            <option value="04">April</option>
                                            <option value="05">Mei</option>
                                            <option value="06">Juni</option>
                                            <option value="07">Juli</option>
                                            <option value="08">Agustus</option>
                                            <option value="09">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
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