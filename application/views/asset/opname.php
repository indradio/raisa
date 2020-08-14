<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Opname Asset</h4>
                    </div>
                    <div class="card-body ">
                        <?= form_open_multipart('asset/opname_proses'); ?>
                        <input type="hidden" class="form-control" name="id" value="<?= $asset['id']; ?>" required>
                        <div class="row">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="col-md-4">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img src="<?= base_url(); ?>assets/img/asset/sto-photo.jpg" alt="foto" name="foto">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                        <span class="btn btn-round btn-facebook btn-file">
                                            <span class="fileinput-new">Ambil Foto</span>
                                            <span class="fileinput-exists">Ganti</span>
                                            <input type="file" name="foto" required="true"/>
                                        </span>
                                        <br />
                                        <a href="#" class="btn btn-youtube btn-round fileinput-exists" data-dismiss="fileinput"></i>Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">No. Asset</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="asset_no" value="<?= $asset['asset_no']; ?> - <?= $asset['asset_sub_no']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Asset Deskripsi</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <!-- <input type="text" class="form-control" name="asset_deskripsi" value="<?= $asset['asset_deskripsi']; ?>" required> -->
                                    <textarea rows="3" class="form-control" id="asset_deskripsi" name="asset_deskripsi" required="true"><?= $asset['asset_deskripsi']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Kategori</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="kategori" value="<?= $asset['kategori']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-2 col-form-label">First Acq</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="first_acq" value="<?= $asset['first_acq']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-2 col-form-label">Value Acq</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="value_acq" value="<?= $asset['value_acq']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-2 col-form-label">Cost Center</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="cost_center" value="<?= $asset['cost_center']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">PIC</label>
                            <div class="col-md-3">
                                <input type="hidden" class="form-control" name="old_npk" value="<?= $asset['npk']; ?>" />
                                <select class="selectpicker" name="new_npk" id="selectpic" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" data-live-search="true" required>
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
                            <div class="col-md-1">
                                <div class="form-check ml-auto">
                                    <label class="form-check-label text-dark">
                                    <input class="form-check-input" type="checkbox" name="checkpic" id="checkpic" value="1">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                    <i>Change</i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Lokasi</label>
                            <div class="col-md-3">
                                <input type="hidden" class="form-control" name="old_lokasi" value="<?= $asset['lokasi']; ?>" />
                                <select class="selectpicker" name="new_lokasi" id="selectloc" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" data-live-search="true" required>
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
                            <div class="col-md-1">
                                <div class="form-check ml-auto">
                                    <label class="form-check-label text-dark">
                                    <input class="form-check-input" type="checkbox" name="checkloc" id="checkloc" value="1">
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                    <i>Change</i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Status </label>
                            <div class="col-md-4">
                                <select class="selectpicker" name="status" id="stats" data-style="select-with-transition" data-size="5" title="Silahkan Pilih" required>
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
                            <label class="col-md-2 col-form-label">Catatan</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="catatan" id="catatan"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <a href="<?= base_url('asset'); ?>" class="btn btn-link">Kembali</a>
                            <button type="submit" class="btn btn-success btn-wd">OPNAME</button>
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
<script>
    $(document).ready(function() {
        var checkPic = document.getElementById('checkpic');
        var selectPic = document.getElementById('selectpic');
        selectPic.disabled = true;

        var checkLoc = document.getElementById('checkloc');
        var selectLoc = document.getElementById('selectloc');
        selectLoc.disabled = true;
       
        // when unchecked or checked, run the function
        checkPic.onchange = function() {
            if (this.checked) {
                // document.getElementById("selectpic").disabled = false;
                // $( "#selectpic" ).prop( "disabled", false );
                selectPic.disabled = false;
            } else {
                selectPic.disabled = true;
            }
        }

        // when unchecked or checked, run the function
        checkLoc.onchange = function() {
            if (this.checked) {
                // document.getElementById("selectLoc").disabled = false;
                // $( "#selectLoc" ).prop( "disabled", false );
                selectLoc.disabled = false;
            } else {
                selectLoc.disabled = true;
            }
        }
    })

    $('#stats').change(function() {
        var stats = $('#stats').val();
                if (stats == '1') {
                    $('#catatan').prop("required", false);
                } else if (stats == '2') {
                    $('#catatan').prop("required", false);
                } else {
                    $('#catatan').prop("required", true);
                }
            
    });
    
</script>