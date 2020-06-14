<!-- Modal Detail DL - Persetujuan DL -->
<div class="modal fade" id="rsvDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Persetujuan Perjalanan Dinas</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form" method="post" action="<?= base_url('persetujuandl/setujudl'); ?>">
                        <div class="card-body">
                            <div class="row" hidden>
                                <label class="col-md-4 col-form-label">Nomor Reservasi</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-4 col-form-label">Nama</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nama">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Peserta</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled font-weight-bold" id="anggota" name="anggota">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Tujuan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control font-weight-bold disabled" name="tujuan">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Keperluan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control font-weight-bold disabled" name="keperluan"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
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
                                <label class="col-md-4 col-form-label">Waktu Keberangkatan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="berangkat">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Waktu Kembali</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="kembali">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-4 col-form-label">Tanggal Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tglberangkat">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-4 col-form-label">Jam Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control timepicker" id="jamberangkat" name="jamberangkat" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-4 col-form-label">Tanggal Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tglkembali">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-4 col-form-label">Jam Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control timepicker" id="jamkembali" name="jamkembali" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Estimasi Biaya</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" id="biaya" name="biaya" disabled="true" />
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

<!-- Modal Tambah Peserta -->
<div class="modal fade" id="tambahPeserta" tabindex="-1" role="dialog" aria-labelledby="tambahPesertaTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Peseta perjalanan</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('cekdl/tambahpeserta'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-4 col-form-label">Nomor Perjalanan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Tambah Peserta</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="anggota[]" data-style="select-with-transition" multiple title="Pilih Peserta" data-live-search="true" data-size="7">
                                            <?php
                                            $queryKaryawan = "SELECT *
                                                FROM `karyawan`
                                                WHERE `npk` != {$this->session->userdata('npk')} AND `npk` != '1111'
                                                ORDER BY `nama` ASC
                                                ";
                                            $Karyawan = $this->db->query($queryKaryawan)->result_array();
                                            foreach ($Karyawan as $k) : ?>
                                                <option value="<?= $k['inisial']; ?>"><?= $k['nama']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success">TAMBAH PESERTA</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Revisi DL - Cek DL -->
<div class="modal fade" id="revisiPerjalanan" tabindex="-1" role="dialog" aria-labelledby="revisiPerjalananLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="revisiPerjalananLabel">Berikan catatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('cekdl/revisi'); ?>">
                <div class="modal-body">
                    <input type="text" class="form-control disabled" name="id">
                    <textarea rows="2" class="form-control" name="catatan" required></textarea>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger">REVISI PERJALANAN INI!</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- end modal -->

<!-- Modal Lapor Bugs -->
<div class="modal fade" id="laporModal" tabindex="-1" role="dialog" aria-labelledby="laporModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Laporankan Masalah</h4>
                    </div>
                </div>
                <?= form_open_multipart('issues/newbug'); ?>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <select class="selectpicker" data-size="7" data-style="select-with-transition" title="PILIH MENU" required="true">
                                <?php
                                $menu = $this->db->get_where('user_menu', ['is_active' =>  '1'])->result();
                                foreach ($menu as $row) {
                                    echo '<option value="' . $row->id . '">' . $row->menu . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSubjek" class="bmd-label-floating">Subjek</label>
                            <input type="text" class="form-control" name="subjek" id="exampleSubjek" required="true">
                        </div>
                        <div class="form-group">
                            <label for="exampleDeskripsi" class="bmd-label-floating">Deskripsi</label>
                            <textarea type="text" rows="4" class="form-control" name="deskripsi" id="exampleDeskripsi" required="true"></textarea>
                        </div>
                        <div class="form-group text-center">
                            <h4 class="title">Unggah Gambar</h4>
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    <img src="<?= base_url(); ?>/assets/img/image_placeholder.jpg" alt="...">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div>
                                    <span class="btn btn-rose btn-round btn-sm btn-file">
                                        <span class="fileinput-new">Pilih Gambar</span>
                                        <span class="fileinput-exists">Ubah</span>
                                        <input type="file" name="..." />
                                    </span>
                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Hapus</a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                            <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
                            <button type="submit" class="btn btn-primary btn-round">LAPORKAN</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->