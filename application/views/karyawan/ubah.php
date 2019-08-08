<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">people</i>
                        </div>
                        <h4 class="card-title">Ubah Data Karyawan</h4>
                    </div>
                    <div class="card-body ">
                        <?= form_open_multipart('hr/ubah_proses'); ?>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Foto</label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail img-circle">
                                        <img src="<?= base_url(); ?>assets/img/faces/<?= $datakaryawan['foto']; ?>" alt="foto" name="foto">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
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
                            <label class="col-md-1 col-form-label">NPK</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="npk" value="<?= $datakaryawan['npk']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Inisial</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="inisial" value="<?= $datakaryawan['inisial']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="nama" value="<?= $datakaryawan['nama']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Email</label>
                            <div class="col-md-9">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="email" value="<?= $datakaryawan['email']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">No HP</label>
                            <div class="col-md-9">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="phone" value="<?= $datakaryawan['phone']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Posisi</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="posisi" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $posisi = $this->db->get('karyawan_posisi')->result_array();
                                    foreach ($posisi as $po) :
                                        echo '<option value="' . $po['id'] . '"';
                                        if ($po['id'] == $datakaryawan['posisi_id']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $po['nama'] . '</option>' . "\n";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Divisi</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="div" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $divisi = $this->db->get('karyawan_div')->result_array();
                                    foreach ($divisi as $div) :
                                        echo '<option value="' . $div['id'] . '"';
                                        if ($div['id'] == $datakaryawan['div_id']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $div['nama'] . '</option>' . "\n";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Departemen</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="dept" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $departemen = $this->db->get('karyawan_dept')->result_array();
                                    foreach ($departemen as $dept) :
                                        echo '<option value="' . $dept['id'] . '"';
                                        if ($dept['id'] == $datakaryawan['dept_id']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $dept['nama'] . '</option>' . "\n";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Unit Organisasi</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="sect" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $section = $this->db->get('karyawan_sect')->result_array();
                                    foreach ($section as $sect) :
                                        echo '<option value="' . $sect['id'] . '"';
                                        if ($sect['id'] == $datakaryawan['sect_id']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $sect['nama'] . '</option>' . "\n";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Golongan</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="gol" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $golongan = $this->db->get('karyawan_gol')->result_array();
                                    foreach ($golongan as $gol) :
                                        echo '<option value="' . $gol['id'] . '"';
                                        if ($gol['id'] == $datakaryawan['gol_id']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $gol['nama'] . '</option>' . "\n";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Fasilitas</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="fasilitas" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $fasilitas = $this->db->get('karyawan_fasilitas')->result_array();
                                    foreach ($fasilitas as $f) :
                                        echo '<option value="' . $f['id'] . '"';
                                        if ($f['id'] == $datakaryawan['fasilitas_id']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $f['nama'] . '</option>' . "\n";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Atasan 1</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="atasan1" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $posisi = $this->db->get('karyawan_posisi')->result_array();
                                    foreach ($posisi as $po) :
                                        echo '<option value="' . $po['id'] . '"';
                                        if ($po['id'] == $datakaryawan['atasan1']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $po['nama'] . '</option>' . "\n";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Atasan 2</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="atasan2" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $posisi = $this->db->get('karyawan_posisi')->result_array();
                                    foreach ($posisi as $po) :
                                        echo '<option value="' . $po['id'] . '"';
                                        if ($po['id'] == $datakaryawan['atasan2']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $po['nama'] . '</option>' . "\n";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Role <p><small>(catatan : Hanya untuk menu RAISA)</small></p></label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="role" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $role = $this->db->order_by('id', "ASC");
                                    $role = $this->db->get('user_role')->result_array();
                                    foreach ($role as $ro) :
                                        echo '<option value="' . $ro['id'] . '"';
                                        if ($ro['id'] == $datakaryawan['role_id']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $ro['name'] . '</option>' . "\n";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary btn-wd btn-lg">UBAH</button>
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