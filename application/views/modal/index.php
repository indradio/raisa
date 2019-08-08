<!-- Modal Detail DL - Persetujuan DL -->
<div class="modal fade" id="rsvDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-rose text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Persetujuan Perjalanan Dinas</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form" method="post" action="<?= base_url('persetujuandl/setujudl'); ?>">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-4 col-form-label">Nomor Reservasi</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Nama</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nama">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Tujuan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tujuan">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Keperluan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control disabled" name="keperluan"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Peserta</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="anggota">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Nomor Polisi</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nopol">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Jenis Kendaraan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="kepemilikan">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Tanggal Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tglberangkat">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Jam Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="jamberangkat">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Tanggal Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tglkembali">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Jam Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="jamkembali">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn btn-link btn-danger" data-toggle="modal" data-target="#rsvBatal">BATALKAN!</a>
                                <button type="submit" class="btn btn-fill btn-success">SETUJUI</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Batal DL - Persetujuan DL -->
<div class="modal fade" id="rsvBatal" tabindex="-1" role="dialog" aria-labelledby="rsvBatalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rsvBatalLabel">Masukan alasan pembatalan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('persetujuandl/bataldl'); ?>">
                <div class="modal-body">
                    <input type="text" class="form-control disabled" name="id" hidden>
                    <textarea rows="2" class="form-control" name="catatan" required></textarea>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger">BATALKAN PERJALANAN INI!</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Menu - Revenue-->
<div class="modal fade" id="revTambah" tabindex="-1" role="dialog" aria-labelledby="revtambahTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Tambah Menu</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('pendapatan/revtambah'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">Menu</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="nama">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary btn-link btn-wd btn-lg">TAMBAH</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Menu - Revenue-->
<div class="modal fade" id="revHapus" tabindex="-1" role="dialog" aria-labelledby="revHapusTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Hapus Menu</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('pendapatan/revhapus'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">Menu</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="nama" data-style="select-with-transition" data-size="7" required>
                                            <?php
                                            $menu = $this->db->get('pendapatan')->result_array();
                                            foreach ($menu as $m) : ?>
                                                <option value="<?= $m['nama']; ?>"><?= $m['nama']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary btn-link btn-wd btn-lg">HAPUS!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Menu - Revenue-->
<div class="modal fade" id="revEdit" tabindex="-1" role="dialog" aria-labelledby="revEditTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Edit Data</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('pendapatan/revedit'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">Menu</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nama">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Januari</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="januari">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Februari</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="februari">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Maret</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="maret">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">April</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="april">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Mei</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="mei">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Juni</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="juni">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Juli</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="juli">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Agustus</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="agustus">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">September</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="september">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Oktober</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="oktober">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">November</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="november">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Desember</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="desember">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary btn-link btn-wd btn-lg">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Tambah Karyawan -->
<div class="modal fade" id="karyawanAdd" tabindex="-1" role="dialog" aria-labelledby="karyawanAddTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Tambah Data Karyawan Baru</h4>
                    </div>
                </div>
                <?= form_open_multipart('hr/tambah'); ?>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <label class="col-md-3 col-form-label">NPK</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="npk" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Inisial</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="inisial" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="nama" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Email</label>
                            <div class="col-md-9">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">No HP</label>
                            <div class="col-md-9">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Posisi</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="posisi" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $posisi = $this->db->get('karyawan_posisi')->result_array();
                                    foreach ($posisi as $po) : ?>
                                        <option value="<?= $po['id']; ?>"><?= $po['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Divisi</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="div" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $divisi = $this->db->get('karyawan_div')->result_array();
                                    foreach ($divisi as $div) : ?>
                                        <option value="<?= $div['id']; ?>"><?= $div['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Departemen</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="dept" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $departemen = $this->db->get('karyawan_dept')->result_array();
                                    foreach ($departemen as $dept) : ?>
                                        <option value="<?= $dept['id']; ?>"><?= $dept['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Unit Organisasi</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="sect" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $section = $this->db->get('karyawan_sect')->result_array();
                                    foreach ($section as $sect) : ?>
                                        <option value="<?= $sect['id']; ?>"><?= $sect['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Golongan</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="gol" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $golongan = $this->db->get('karyawan_gol')->result_array();
                                    foreach ($golongan as $gol) : ?>
                                        <option value="<?= $gol['id']; ?>"><?= $gol['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Fasilitas</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="fasilitas" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $fasilitas = $this->db->get('karyawan_fasilitas')->result_array();
                                    foreach ($fasilitas as $f) : ?>
                                        <option value="<?= $f['id']; ?>"><?= $f['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Atasan 1</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="atasan1" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $posisi = $this->db->get('karyawan_posisi')->result_array();
                                    foreach ($posisi as $po) : ?>
                                        <option value="<?= $po['id']; ?>"><?= $po['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Atasan 2</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="atasan2" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $posisi = $this->db->get('karyawan_posisi')->result_array();
                                    foreach ($posisi as $po) : ?>
                                        <option value="<?= $po['id']; ?>"><?= $po['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Role (catatan : Hanya untuk menu RAISA)</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="role" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $role = $this->db->order_by('id', "ASC");
                                    $role = $this->db->get('user_role')->result_array();
                                    foreach ($role as $ro) : ?>
                                        <option value="<?= $ro['id']; ?>"><?= $ro['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Foto</label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail img-circle">
                                        <img src="<?= base_url(); ?>assets/img/default-avatar.png" alt="foto">
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
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary btn-link btn-wd btn-lg">TAMBAH</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->