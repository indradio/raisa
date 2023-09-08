<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-product">
                    <div class="card-header card-header-image" data-header-animation="true">
                    <a href="#pablo">
                        <img class="img" src="<?= base_url('assets/img/asset/2023/'.$opnamed['asset_image']); ?>">
                    </a>
                    </div>
                    <div class="card-body ">
                        <?= form_open_multipart('asset/opname_proses/2'); ?>
                        <input type="hidden" class="form-control" name="id" value="<?= $asset['id']; ?>" required>
                        <div class="row">
                            <label class="col-md-2 col-form-label">No. Asset</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="asset_no" value="<?= $asset['asset_no']; ?> - <?= $asset['asset_sub_no']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Asset Deskripsi</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control disabled" id="asset_deskripsi" name="asset_deskripsi"><?= $asset['asset_description']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Kategori</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="kategori" value="<?= $asset['category']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-2 col-form-label">First Acq</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="first_acq" value="<?= $asset['first_acq']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-2 col-form-label">Value Acq</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="value_acq" value="<?= $asset['value_acq']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-2 col-form-label">Cost Center</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="cost_center" value="<?= $asset['cost_center']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">PIC</label>
                            <div class="col-md-3">
                                <input type="hidden" class="form-control" name="old_npk" value="<?= $asset['npk']; ?>" />
                                <select class="selectpicker" name="new_npk" id="selectpic" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" data-live-search="true">
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
                        <div class="row">
                            <label class="col-md-2 col-form-label">Lokasi</label>
                            <div class="col-md-3">
                                <input type="hidden" class="form-control" name="old_lokasi" value="<?= $asset['room']; ?>" />
                                <select class="selectpicker" name="new_lokasi" id="selectloc" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" data-live-search="true">
                                    <?php $lokasi = $this->db->get('asset_lokasi')->result_array();
                                    foreach ($lokasi as $lok) :
                                        echo '<option value="' . $lok['id'] . '"';
                                        if ($lok['id'] == $asset['room']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $lok['id'] . '</option>' . "\n";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Kondisi</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">  
                                    <div class="btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-default w-100" id="labelOption1">
                                        <input type="radio" name="options" id="option1" autocomplete="off" value="1" required>BAIK-ADA-DIGUNAKAN
                                    </label>
                                    <label class="btn btn-default w-100" id="labelOption2">
                                        <input type="radio" name="options" id="option2" autocomplete="off" value="2" required>BAIK-TIDAK SESUAI
                                    </label>
                                    <label class="btn btn-default w-100" id="labelOption3">
                                        <input type="radio" name="options" id="option3" autocomplete="off" value="3" required>RUSAK
                                    </label>
                                    <label class="btn btn-default w-100" id="labelOption4">
                                        <input type="radio" name="options" id="option4" autocomplete="off" value="4" required>HILANG
                                    </label>
                                    </div>   
                                    <input type="hidden" class="form-control" id="status" name="status" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Catatan</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <textarea rows="5" class="form-control" name="catatan" id="catatan"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <a href="<?= base_url('asset/outstanding'); ?>" class="btn btn-link">Kembali</a>
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

        var labelOption1 = document.getElementById('labelOption1');
        var labelOption2 = document.getElementById('labelOption2');
        var labelOption3 = document.getElementById('labelOption3');
        var labelOption4 = document.getElementById('labelOption4');

        var option1 = document.getElementById('option1');
        // when unchecked or checked, run the function
        option1.onchange = function() {
            if (this.checked) {
                document.getElementById('status').value = '1';
                labelOption1.style.background = '#4caf50';
                labelOption2.style.background = '#999999';
                labelOption3.style.background = '#999999';
                labelOption4.style.background = '#999999';
                document.getElementById("catatan").required = false;
            }
        }

        var option2 = document.getElementById('option2');
        // when unchecked or checked, run the function
        option2.onchange = function() {
            if (this.checked) {
                document.getElementById('status').value = '2';
                labelOption1.style.background = '#999999';
                labelOption2.style.background = '#FFB236';
                labelOption3.style.background = '#999999';
                labelOption4.style.background = '#999999';
                document.getElementById("catatan").required = true;
            }
        }

        var option3 = document.getElementById('option3');
        // when unchecked or checked, run the function
        option3.onchange = function() {
            if (this.checked) {
                document.getElementById('status').value = '3';
                labelOption1.style.background = '#999999';
                labelOption2.style.background = '#999999';
                labelOption3.style.background = '#f44336';
                labelOption4.style.background = '#999999';
                document.getElementById("catatan").required = true;
            }
        }

        var option4 = document.getElementById('option4');
        // when unchecked or checked, run the function
        option4.onchange = function() {
            if (this.checked) {
                document.getElementById('status').value = '4';
                labelOption1.style.background = '#999999';
                labelOption2.style.background = '#999999';
                labelOption3.style.background = '#999999';
                labelOption4.style.background = '#000000';
                document.getElementById("catatan").required = true;
            }
        }
    });
</script>