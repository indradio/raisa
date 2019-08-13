<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Opname Asset</h4>
                    </div>
                    <div class="card-body ">
                        <?= form_open_multipart('asset/opname_proses'); ?>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Foto</label>
                            <div class="col-md-3">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img src="<?= base_url(); ?>assets/img/asset/<?= $asset['asset_foto']; ?>" alt="foto" name="foto">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                        <span class="btn btn-round btn-rose btn-file">
                                            <span class="fileinput-new">Pilih Foto</span>
                                            <span class="fileinput-exists">Ganti</span>
                                            <input type="file" name="foto" />
                                        </span>
                                        <br />
                                        <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i>Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Nomor Asset</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="asset_no" value="<?= $asset['asset_no']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Nomor Sub Asset</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="asset_sub_no" value="<?= $asset['asset_sub_no']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Asset Deskripsi</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="asset_deskripsi" value="<?= $asset['asset_deskripsi']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Kategori</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="kategori" value="<?= $asset['kategori']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Lokasi</label>
                            <div class="col-md-3">
                                <select class="selectpicker" name="lokasi" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php $lokasi = $this->db->get('asset_lokasi')->result_array();
                                    foreach ($lokasi as $lok) :
                                        echo '<option value="' . $lok['id'] . '"';
                                        if ($lok['id'] == $asset['lokasi']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $lok['id'] . '</option>' . "\n";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">First Acq</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="first_acq" value="<?= $asset['first_acq']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-1 col-form-label">Value Acq</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="value_acq" value="<?= $asset['value_acq']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">PIC</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control disabled" name="npklama" value="<?= $asset['npk']; ?>" hidden>
                                <select class="selectpicker" name="npk" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php $karyawan = $this->db->get('karyawan')->result_array();
                                    foreach ($karyawan as $k) :
                                        echo '<option value="' . $k['npk'] . '"';
                                        if ($k['npk'] == $asset['npk']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $k['nama'] . '</option>' . "\n";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-1 col-form-label">Cost Center</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="cost_center" value="<?= $asset['cost_center']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Status </label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="status" data-style="select-with-transition" data-size="5" title="Silahkan Pilih" required>
                                    <option value="1" <?php if ($asset['status'] == 1) {
                                                            echo 'selected';
                                                        }; ?>>BAIK-ADA-DIGUNAKAN</option>
                                    <option value="2" <?php if ($asset['status'] == 2) {
                                                            echo 'selected';
                                                        }; ?>>BAIK-TIDAK SESUAI</option>
                                    <option value="3" <?php if ($asset['status'] == 3) {
                                                            echo 'selected';
                                                        }; ?>>RUSAK</option>
                                    <option value="4" <?php if ($asset['status'] == 4) {
                                                            echo 'selected';
                                                        }; ?>>HILANG</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Catatan</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="catatan"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary btn-wd btn-lg">OPNAME</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->