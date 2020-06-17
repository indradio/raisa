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
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Posisi / Jabatan</label>
                                            <?php $posisi = $this->db->get_where('karyawan_posisi', ['id' =>  $karyawan['posisi_id']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $posisi['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Golongan</label>
                                            <?php $golongan = $this->db->get_where('karyawan_gol', ['id' =>  $karyawan['gol_id']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $golongan['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Divisi</label>
                                            <?php $divisi = $this->db->get_where('karyawan_div', ['id' =>  $karyawan['div_id']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $divisi['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Departemen</label>
                                            <?php $departemen = $this->db->get_where('karyawan_dept', ['id' =>  $karyawan['dept_id']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $departemen['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Unit Organisasi / Seksi</label>
                                            <?php $seksi = $this->db->get_where('karyawan_sect', ['id' =>  $karyawan['sect_id']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $seksi['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Atasan 1</label>
                                            <?php $atasan1 = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata['atasan1']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $atasan1['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Atasan 2</label>
                                            <?php $atasan2 = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata['atasan2']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $atasan2['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
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
                        <img class="img" src="<?= base_url(); ?>assets/img/qrcode/<?= $karyawan['qrcode'].'.png'; ?>" />
                        <h2 class="card-title"><?= $karyawan['qrcode']; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose">
                            <div class="card-icon">
                                <i class="material-icons">perm_identity</i>
                            </div>
                            <h4 class="card-title">Data Diri</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">e-Wallet Utama</label>
                                            <input type="text" class="form-control" value="<?= $karyawan['ewallet_1']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">e-Wallet Cadangan</label>
                                            <input type="text" class="form-control" value="<?= $karyawan['ewallet_2']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Fist Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Last Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Adress</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">City</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Country</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Postal Code</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>About Me</label>
                                            <div class="form-group">
                                                <label class="bmd-label-floating"> Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.</label>
                                                <textarea class="form-control" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-rose pull-right">Update Profile</button> -->
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>