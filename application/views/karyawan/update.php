    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <a href="#pablo">
                                <img class="img" src="<?= base_url(); ?>assets/img/faces/<?= $karyawan['foto']; ?>" />
                            </a>
                        </div>
                        <div class="card-body">
                            <h6 class="card-category text-gray"><?= $karyawan['npk']; ?></h6>
                            <h4 class="card-title"><?= $karyawan['nama']; ?></h4>
                            <p class="card-description">
                                Don't be scared of the truth because we need to restart the human foundation in truth And I love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose">
                            <div class="card-icon">
                                <i class="material-icons">perm_identity</i>
                            </div>
                            <h4 class="card-title">Data Karyawan</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">NPK</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="npk" value="<?= $dataKar['npk']; ?>" disabled="true" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Inisial</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="inisial" value="<?= $dataKar['inisial']; ?>" disabled="true" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Nama Lengkap</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="nama" value="<?= $dataKar['nama']; ?>" required="true" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Email</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="email" email="true" value="<?= $dataKar['email']; ?>" required="true" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Phone</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="phone" value="<?= $dataKar['phone']; ?>" required="true" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Role<p><small>(Akses MENU)</small></p></label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" id="role_id" name="role_id" data-style="select-with-transition" data-width="auto" title="Select Division" required>
                                                <?php
                                                $role = $this->db->where('id !=', '1');
                                                $role = $this->db->order_by('id', "ASC");
                                                $role = $this->db->get('user_role')->result_array();
                                                foreach ($role as $r) : echo '<option value="' . $r['id'] . '"';
                                                    if ($r['id'] == $dataKar['role_id']) {
                                                        echo 'selected';
                                                    }
                                                    echo '>' . $r['name'] . '</option>' . "\n";
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-rose pull-right">Update Profile</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="card-body">
                            <img class="img" src="<?= base_url(); ?>assets/img/qrcode/<?= $dataKar['qrcode'] . '.png'; ?>" />
                            <h2 class="card-title"><?= $dataKar['qrcode']; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose">
                            <div class="card-icon">
                                <i class="material-icons">perm_identity</i>
                            </div>
                            <h4 class="card-title">Data Karyawan</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Division</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" id="div_id" name="div_id" data-style="select-with-transition" data-width="auto" title="Select Division" required>
                                                <?php
                                                $divisi = $this->db->get('karyawan_div')->result_array();
                                                foreach ($divisi as $div) :
                                                    echo '<option value="' . $div['id'] . '"';
                                                    if ($div['id'] == $dataKar['div_id']) {
                                                        echo 'selected';
                                                    }
                                                    echo '>' . $div['nama'] . '</option>' . "\n";
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Deparment</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" id="dept_id" name="dept_id" data-style="select-with-transition" data-width="auto" title="Select Department" required>
                                                <?php
                                                $dept = $this->db->get_where('karyawan_dept', ['div_id' => $dataKar['div_id']])->result_array();
                                                foreach ($dept as $d) :
                                                    echo '<option value="' . $d['id'] . '"';
                                                    if ($d['id'] == $dataKar['dept_id']) {
                                                        echo 'selected';
                                                    }
                                                    echo '>' . $d['nama'] . '</option>' . "\n";
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Section</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" id="sect_id" name="sect_id" data-style="select-with-transition" data-width="auto" title="Select Section" required>
                                                <?php
                                                $sect = $this->db->get_where('karyawan_sect', ['dept_id' => $dataKar['dept_id']])->result_array();
                                                foreach ($sect as $s) :
                                                    echo '<option value="' . $s['id'] . '"';
                                                    if ($s['id'] == $dataKar['sect_id']) {
                                                        echo 'selected';
                                                    }
                                                    echo '>' . $s['nama'] . '</option>' . "\n";
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Position</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" id="posisi_id" name="posisi_id" data-style="select-with-transition" data-width="auto" title="Select Division" required>
                                                <?php
                                                $posisi = $this->db->get_where('karyawan_posisi', ['id !=' => '6'])->result_array();
                                                foreach ($posisi as $p) : echo '<option value="' . $p['id'] . '"';
                                                    if ($p['id'] == $dataKar['posisi_id']) {
                                                        echo 'selected';
                                                    }
                                                    echo '>' . $p['nama'] . '</option>' . "\n";
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Atasan 1</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" id="atasan1" name="atasan1" data-style="select-with-transition" data-width="auto" title="Select Division" required>
                                                <?php
                                                $atasan1 = $this->db->get('karyawan_posisi')->result_array();
                                                foreach ($atasan1 as $a1) : echo '<option value="' . $a1['id'] . '"';
                                                    if ($a1['id'] == $dataKar['atasan1']) {
                                                        echo 'selected';
                                                    }
                                                    echo '>' . $a1['nama'] . '</option>' . "\n";
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Atasan 2</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" id="atasan2" name="atasan2" data-style="select-with-transition" data-width="auto" title="Select Division" required>
                                                <?php
                                                $atasan2 = $this->db->get('karyawan_posisi')->result_array();
                                                foreach ($atasan2 as $a2) : echo '<option value="' . $a2['id'] . '"';
                                                    if ($a2['id'] == $dataKar['atasan2']) {
                                                        echo 'selected';
                                                    }
                                                    echo '>' . $a2['nama'] . '</option>' . "\n";
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Golongan</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" id="gol_id" name="gol_id" data-style="select-with-transition" data-width="auto" title="Select Division" required>
                                                <?php
                                                $gol = $this->db->get('karyawan_gol')->result_array();
                                                foreach ($gol as $g) : echo '<option value="' . $g['id'] . '"';
                                                    if ($g['id'] == $dataKar['gol_id']) {
                                                        echo 'selected';
                                                    }
                                                    echo '>' . $g['nama'] . '</option>' . "\n";
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Fasilitas</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" id="fasilitas_id" name="fasilitas_id" data-style="select-with-transition" data-width="auto" title="Select Division" required>
                                                <?php
                                                $fasilitas = $this->db->get('karyawan_fasilitas')->result_array();
                                                foreach ($fasilitas as $f) : echo '<option value="' . $f['id'] . '"';
                                                    if ($f['id'] == $dataKar['fasilitas_id']) {
                                                        echo 'selected';
                                                    }
                                                    echo '>' . $f['nama'] . '</option>' . "\n";
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label text-danger">Work Labor</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" id="gol_id" name="gol_id" data-style="select-with-transition" data-width="auto" title="Select Division" required>
                                                <?php
                                                $gol = $this->db->get('karyawan_gol')->result_array();
                                                foreach ($gol as $g) : echo '<option value="' . $g['id'] . '"';
                                                    if ($g['id'] == $dataKar['gol_id']) {
                                                        echo 'selected';
                                                    }
                                                    echo '>' . $g['nama'] . '</option>' . "\n";
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label text-danger">Cost Center</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" id="gol_id" name="gol_id" data-style="select-with-transition" data-width="auto" title="Select Division" required>
                                                <?php
                                                $gol = $this->db->get('karyawan_gol')->result_array();
                                                foreach ($gol as $g) : echo '<option value="' . $g['id'] . '"';
                                                    if ($g['id'] == $dataKar['gol_id']) {
                                                        echo 'selected';
                                                    }
                                                    echo '>' . $g['nama'] . '</option>' . "\n";
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Nama Lengkap</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="nama" required="true" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Email</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="email" email="true" required="true" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Phone</label>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="phone" required="true" />
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-rose pull-right">Update Profile</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#div_id').change(function() {
                var div = $('#div_id').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('hr/dept') ?>",
                    data: {
                        div: div
                    },
                    success: function(data) {
                        // alert(data)
                        $('#dept_id').html(data);
                        $('#dept_id').selectpicker('refresh');
                        $('#sect_id').selectpicker('val', '');
                        $('#sect_id').selectpicker('refresh');
                    }
                })
            })
            $('#dept_id').change(function() {
                var dept = $('#dept_id').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('hr/sect') ?>",
                    data: {
                        dept: dept
                    },
                    success: function(data) {
                        // alert(data)
                        $('#sect_id').html(data);
                        $('#sect_id').selectpicker('refresh');
                    }
                })
            })
        });
    </script>