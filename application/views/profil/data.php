<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title">
                        <!-- <small class="description">PerjalananKu</small> -->
                        </h4>
                    </div>
                        <form id="dataKaryawanForm" class="form-horizontal" action="<?= base_url('profil/save'); ?>" method="post">
                            <div class="card-body">
                                <div class="row">
                                    <label class="col-md-3 col-form-label">NIK</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="nik" value="<?= (!empty($details)) ? $details['nik'] : ''; ?>" required="true"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">No HP </br><small>Kontak</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="kontak" value="<?= (!empty($details)) ? $details['kontak'] : ''; ?>" required="true"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Email Pribadi</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="email" value="<?= (!empty($details)) ? $details['email'] : ''; ?>" required="true"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Tempat Lahir</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="lahir_tempat" value="<?= (!empty($details)) ? $details['lahir_tempat'] : ''; ?>" required="true"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Tanggal Lahir</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" name="lahir_tanggal" value="<?= (!empty($details)) ? date('d-m-Y', strtotime($details['lahir_tanggal'])) : ''; ?>" required="true"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Alamat Lengkap </br><small>KTP</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <textarea rows="4" class="form-control" name="alamat_ktp" id="alamat_ktp" placeholder="Jalan, Kampung atau Komplek Perumahan, Nomor Rumah, Blok, RT/RW" required="true"><?= (!empty($details)) ? $details['alamat_ktp'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Provinsi </br><small>KTP</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default" style="display: flex;">
                                            <select class="selectpicker show-tick" name="prov_ktp" id="prov_ktp" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-actions-box="true" data-live-search="true" required="true">
                                                <?php 
                                                    foreach ($provinsi as $row) : ?>
                                                        <option value="<?= $row->id; ?>" <?= (!empty($details) && $row->nama == $details['provinsi_ktp']) ? 'selected' : ''; ?>><?= $row->nama; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                            <a href="#" id="refresh_ktp" class="btn btn-just-icon btn-link btn-twitter" onclick="myFunction()">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Kabupaten / Kota </br><small>KTP</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                        <select class="selectpicker show-tick" name="kab_ktp" id="kab_ktp" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="true" required="true">
                                        <?php $kabupaten_ktp = $this->db->get_where('wilayah_kabupaten', ['nama' => $details['kabupaten_ktp']])->result();
                                        foreach ($kabupaten_ktp as $row) : ?>
                                            <option value="<?= $row->id; ?>"<?= (!empty($details) && $row->nama == $details['kabupaten_ktp']) ? 'selected' : ''; ?>><?= $row->nama; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Kecamatan </br><small>KTP</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                        <select class="selectpicker show-tick" name="kec_ktp" id="kec_ktp" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="true" required="true">
                                        <?php $kecamatan_ktp = $this->db->get_where('wilayah_kecamatan', ['nama' => $details['kecamatan_ktp']])->result();
                                        foreach ($kecamatan_ktp as $row) : ?>
                                            <option value="<?= $row->id; ?>"<?= (!empty($details) && $row->nama == $details['kecamatan_ktp']) ? 'selected' : ''; ?>><?= $row->nama; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Desa/Kelurahan </br><small>KTP</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                        <select class="selectpicker show-tick" name="desa_ktp" id="desa_ktp" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="true" required="true">
                                        <?php $desa_ktp = $this->db->get_where('wilayah_desa', ['nama' => $details['desa_ktp']])->result();
                                        foreach ($desa_ktp as $row) : ?>
                                            <option value="<?= $row->id; ?>"<?= (!empty($details) && $row->nama == $details['desa_ktp']) ? 'selected' : ''; ?>><?= $row->nama; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <p>
                                <div class="row">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <div class="form-check">
                                                    <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" id="checkdomisili" name="checkdomisili" value="1" onchange="checkDomisili(this);"> Alamat KTP sesuai dengan Domisili
                                                    <span class="form-check-sign">
                                                    <span class="check"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="domisili1">
                                    <label class="col-md-3 col-form-label">Alamat Lengkap</br><small>Domisili</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <textarea rows="4" class="form-control" name="alamat" id="alamat" placeholder="Jalan, Kampung atau Komplek Perumahan, Nomor Rumah, Blok, RT/RW" required="true"><?= (!empty($details)) ? $details['alamat'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="domisili2">
                                    <label class="col-md-3 col-form-label">Provinsi </br><small>Domisili</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default" style="display: flex;">
                                        <select class="selectpicker show-tick" name="prov" id="prov" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="true" required="true">
                                        <?php 
                                        foreach ($provinsi as $row) : ?>
                                            <option value="<?= $row->id; ?>"<?= (!empty($details) && $row->nama == $details['provinsi']) ? 'selected' : ''; ?>><?= $row->nama; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                        <a href="#" id="refresh" class="btn btn-just-icon btn-link btn-twitter" onclick="myFunction()">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="domisili3">
                                    <label class="col-md-3 col-form-label">Kabupaten / Kota </br><small>Domisili</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                        <select class="selectpicker show-tick" name="kab" id="kab" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="true" required="true">
                                        <?php 
                                        $kabupaten = $this->db->get_where('wilayah_kabupaten', ['nama' => $details['kabupaten']])->result();
                                        foreach ($kabupaten as $row) : ?>
                                            <option value="<?= $row->id; ?>"<?= (!empty($details) && $row->nama == $details['kabupaten']) ? 'selected' : ''; ?>><?= $row->nama; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="domisili4">
                                    <label class="col-md-3 col-form-label">Kecamatan </br><small>Domisili</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                        <select class="selectpicker show-tick" name="kec" id="kec" title="Pilih" value="<?= (!empty($details)) ? $details['kecamatan'] : ''; ?>" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="true" required="true">
                                        <?php 
                                        $kecamatan = $this->db->get_where('wilayah_kecamatan', ['nama' => $details['kecamatan']])->result();
                                        foreach ($kecamatan as $row) : ?>
                                            <option value="<?= $row->id; ?>"<?= (!empty($details) && $row->nama == $details['kecamatan']) ? 'selected' : ''; ?>><?= $row->nama; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="domisili5">
                                    <label class="col-md-3 col-form-label">Desa/Kelurahan </br><small>Domisili</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                        <select class="selectpicker show-tick" name="desa" id="desa" title="Pilih" value="<?= (!empty($details)) ? $details['desa'] : ''; ?>" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="true" required="true">
                                        <?php 
                                        $desa = $this->db->get_where('wilayah_desa', ['nama' => $details['desa']])->result();
                                        foreach ($desa as $row) : ?>
                                            <option value="<?= $row->id; ?>"<?= (!empty($details) && $row->nama == $details['desa']) ? 'selected' : ''; ?>><?= $row->nama; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- <p>
                                <div class="row col-md-11 ml-auto mr-auto">
                                    <div class="progress" style="width: 100%">
                                        <div class="progress-bar progress-bar-info" role="progressbar" style="width: 100%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="1"></div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Nama Institusi</br><small>Pendidikan</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="pend_institusi" value="<?= (!empty($details)) ? $details['pendidikan_institusi'] : ''; ?>"  required="true"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Jenjang </br><small>Pendidikan</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <select class="selectpicker show-tick" name="pend_jenjang" id="pend_jenjang" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required="true">
                                                <option value="SMA/SMK"<?= (!empty($details) && $details['pendidikan_jenjang'] == 'SMA/SMK') ? 'selected' : ''; ?>>SMA/SMK</option>
                                                <option value="D3"<?= (!empty($details) && $details['pendidikan_jenjang'] == 'D3') ? 'selected' : ''; ?>>D3</option>
                                                <option value="D4"<?= (!empty($details) && $details['pendidikan_jenjang'] == 'D4') ? 'selected' : ''; ?>>D4</option>
                                                <option value="S1"<?= (!empty($details) && $details['pendidikan_jenjang'] == 'S1') ? 'selected' : ''; ?>>S1</option>
                                                <option value="S2"<?= (!empty($details) && $details['pendidikan_jenjang'] == 'S2') ? 'selected' : ''; ?>>S2</option>
                                                <option value="S3"<?= (!empty($details) && $details['pendidikan_jenjang'] == 'S3') ? 'selected' : ''; ?>>S3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Tahun Lulus</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <select class="selectpicker show-tick" name="pend_tahun" id="pend_tahun" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="true" required="true">
                                            <?php for ($y = date('Y')-50; $y <= date('Y'); $y++) { ?>
                                                <option value="<?= $y; ?>" <?= (!empty($details) && $details['pendidikan_tahun'] == $y) ? 'selected' : ''; ?>><?= $y; ?></option>
                                            <?php };?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Status Pernikahan</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <select class="selectpicker show-tick" name="status_pernikahan" id="status_pernikahan" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required="true">
                                                <option value="Lajang"<?= (!empty($details) && $details['status_pernikahan'] == 'Lajang') ? 'selected' : ''; ?>>Lajang</option>
                                                <option value="Menikah"<?= (!empty($details) && $details['status_pernikahan'] == 'Menikah') ? 'selected' : ''; ?>>Menikah</option>
                                                <option value="Duda/Janda"<?= (!empty($details) && $details['status_pernikahan'] == 'Duda/Janda') ? 'selected' : ''; ?>>Duda/Janda</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Memiliki Anak </br><small>Tanggungan</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <select class="selectpicker show-tick" name="status_tanggungan" id="status_tanggungan" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required="true">
                                                <option value="YA"<?= (!empty($details) && $details['status_tanggungan'] == 'YA') ? 'selected' : ''; ?>>YA</option>
                                                <option value="TIDAK"<?= (!empty($details) && $details['status_tanggungan'] == 'TIDAK') ? 'selected' : ''; ?>>TIDAK</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <label class="col-md-3 col-form-label">Vaksin</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <select class="selectpicker show-tick" name="vaksin_nama" id="vaksin_nama" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required="true">
                                                <option value="Belum Vaksin"<?= (!empty($details) && $details['vaksin_nama'] == 'Belum Vaksin') ? 'selected' : ''; ?>>Belum Vaksin</option>
                                                <option value="Sinovac"<?= (!empty($details) && $details['vaksin_nama'] == 'Sinovac') ? 'selected' : ''; ?>>Sinovac</option>
                                                <option value="Sinopharm"<?= (!empty($details) && $details['vaksin_nama'] == 'Sinopharm') ? 'selected' : ''; ?>>Sinopharm</option>
                                                <option value="AstraZeneca"<?= (!empty($details) && $details['vaksin_nama'] == 'AstraZeneca') ? 'selected' : ''; ?>>AstraZeneca</option>
                                                <option value="Moderna"<?= (!empty($details) && $details['vaksin_nama'] == 'Moderna') ? 'selected' : ''; ?>>Moderna</option>
                                                <option value="Pfizer"<?= (!empty($details) && $details['vaksin_nama'] == 'Pfizer') ? 'selected' : ''; ?>>Pfizer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="vaksin">
                                    <label class="col-md-3 col-form-label">Vaksin Ke- </br><small>Dosis</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <select class="selectpicker show-tick" name="vaksin_dosis" id="vaksin_dosis" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required="true">
                                                <option value="1"<?= (!empty($details) && $details['vaksin_dosis'] == '1') ? 'selected' : ''; ?>>1</option>
                                                <option value="2"<?= (!empty($details) && $details['vaksin_dosis'] == '2') ? 'selected' : ''; ?>>2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <label class="col-md-3 col-form-label">Tanggal Vaksin </br><small>Terakhir</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" name="vaksin_tanggal" id="vaksin_tanggal" value="<?= (!empty($details)) ? $details['vaksin_tanggal'] : ''; ?>" required="true"/>
                                        </div>
                                    </div>
                                </div> -->
                                <p>
                                <div class="row col-md-11 ml-auto mr-auto">
                                    <div class="progress" style="width: 100%">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="1"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Nama Kerabat</br><small>Darurat</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="kerabat_nama" value="<?= (!empty($details)) ? $details['kerabat_nama'] : ''; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Hubungan Kerabat</br><small>Darurat</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="kerabat_hubungan" value="<?= (!empty($details)) ? $details['kerabat_hubungan'] : ''; ?>" />
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <label class="col-md-3 col-form-label">No HP</br><small>Darurat</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control" name="kerabat_kontak" value="<?= (!empty($details)) ? $details['kerabat_kontak'] : ''; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Alamat Lengkap</br><small>Darurat</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <textarea rows="4" class="form-control" name="kerabat_alamat" id="kerabat_alamat" placeholder="Alamat Lengkap" required="true"><?= (!empty($details)) ? $details['kerabat_alamat'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" id="checkConfirm" name="checkConfirm" value="1" required="true">
                                                Saya sudah memastikan data yang saya isi adalah benar.
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <button type="submit" class="btn btn-fill btn-success" id="submit" disabled="true">UPDATE</button>
                                            <a href="#" class="btn btn-link btn-default">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <div class="col-md-6">
              <div class="card ">
                <div class="card-header">
                    <h4 class="card-title">
                    <!-- <small class="description">PerjalananKu</small> -->
                    </h4>
                </div>
                <div class="card-body"> 
                    <div class="toolbar">
                    <a href="#" class="btn btn-facebook" data-toggle="modal" data-target="#tambahKeluarga"><i class="material-icons">person_add</i> Tambah</a>
                    </div>
                    <div class="material-datatables">
                    <table id="dt_keluarga" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th>Status</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat <small> lahir </small></th>
                            <th>Tanggal <small> lahir </small></th>
                            <th>Jenis <small> Kelamin </small></th>
                            <th>Pekerjaan</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Status</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat <small> lahir </small></th>
                            <th>Tanggal <small> lahir </small></th>
                            <th>Jenis <small> Kelamin </small></th>
                            <th>Pekerjaan</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        
                        </tbody>
                    </table>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahKeluarga" tabindex="-1" role="dialog" aria-labelledby="tambahKeluargaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKeluargaLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form class="form" method="post" action="<?= base_url(''); ?>"> -->
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">NIK*</label></br>
                              <input type="text" class="form-control" name="nik" id="nik" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Nama Lengkap*</label></br>
                              <input type="text" class="form-control" name="nama" id="nama" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Tempat Lahir*</label></br>
                              <input type="text" class="form-control" name="lahir_tempat" id="lahir_tempat" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Tanggal Lahir*</label></br>
                              <input type="text" class="form-control datepicker" name="lahir_tanggal" id="lahir_tanggal" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Jenis Kelamin*</label></br>
                              <select class="selectpicker" name="jenis_kelamin" id="jenis_kelamin" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                  <option value="Laki-Laki">Laki-Laki</option>
                                  <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label">Hubungan*</label></br>
                                  <select class="selectpicker" name="hubungan" id="hubungan" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                          <option value="ISTRI">ISTRI</option>
                                          <option value="SUAMI">SUAMI</option>
                                          <option value="ANAK1">ANAK1</option>
                                          <option value="ANAK2">ANAK2</option>
                                          <option value="ANAK3">ANAK3</option>
                                  </select>
                            </div>
                        </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Pekerjaan*</label></br>
                                <select class="selectpicker" name="pekerjaan" id="pekerjaan" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                        <option value="IRT">Ibu rumah Tangga</option>
                                        <option value="PENGAJAR">Pengajar (Guru, Dosen Dll)</option>
                                        <option value="NAKES">Tenaga kesehatan</option>
                                        <option value="PEKERJA">Pekerja</option>
                                        <option value="PNS">Pegawai Negeri Sipil</option>
                                        <option value="ENTERPRENEUR">Enterpreneur</option>
                                        <option value="PELAJAR">Pelajar</option>
                                        <option value="ARTIS">Artis, Designer, Youtuber Dll</option>
                                </select>
                          </div>
                      </div>
                      <!-- <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Vaksin*</label></br>
                              <select class="selectpicker show-tick" name="vaksin_nama" id="vaksin_nama" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required="true">
                                    <option value="Belum Vaksin">Belum Vaksin</option>
                                    <option value="Sinovac">Sinovac</option>
                                    <option value="Sinopharm">Sinopharm</option>
                                    <option value="AstraZeneca">AstraZeneca</option>
                                    <option value="Moderna">Moderna</option>
                                    <option value="Pfizer">Pfizer</option>
                                </select>
                          </div>
                      </div>
                      <div class="col-md-12" id="vaksin">
                          <div class="form-group">
                              <label class="bmd-label">Dosis*</label></br>
                              <select class="selectpicker show-tick" name="vaksin_dosis" id="vaksin_dosis" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required="true">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                          </div>
                      </div> -->
                    </div>
                    <p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                      <div class="col-md-12 mr-1">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                        <button type="button" id="btn_save" class="btn btn-success">TAMBAH</button>
                      </div>
                    </div>
                </div>
              <!-- </form> -->
        </div>
    </div>
</div>
<div class="modal fade" id="hapusKeluarga" tabindex="-1" role="dialog" aria-labelledby="hapusKeluargaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusKeluargaLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form class="form" method="post" action="<?= base_url(''); ?>"> -->
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" name="nik1" id="nik1"/>
                        <input type="hidden" class="form-control" name="nama1" id="nama1"/>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">NIK*</label></br>
                              <input type="text" class="form-control" name="nik" id="nik" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Nama Lengkap*</label></br>
                              <input type="text" class="form-control" name="nama" id="nama" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Tempat Lahir*</label></br>
                              <input type="text" class="form-control" name="lahir_tempat" id="lahir_tempat" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Tanggal Lahir*</label></br>
                              <input type="text" class="form-control datepicker" name="lahir_tanggal" id="lahir_tanggal" disabled/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label">Jenis Kelamin*</label></br>
                                <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" disabled/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label">Status Hubungan*</label></br>
                                <input type="text" class="form-control" name="hubungan" id="hubungan" disabled/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label">Pekerjaan*</label></br>
                                <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" disabled/>
                            </div>
                        </div>
                    </div>
                    <p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                      <div class="col-md-12 mr-1">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                        <button type="button" id="btn_delete" class="btn btn-danger">HAPUS</button>
                      </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<script>
    $(window).load(function() {
        <?php if ($details['domisili_ktp']=='1'){ ?>

            $('#checkdomisili').prop('checked',true)
            $('#domisili1').prop('style').display='none';
            $('#domisili2').prop('style').display='none';
            $('#domisili3').prop('style').display='none';
            $('#domisili4').prop('style').display='none';
            $('#domisili5').prop('style').display='none';

        <?php }else{ ?>

            $('#checkdomisili').prop('checked',false)
            $('#domisili1').prop('style').display='';
            $('#domisili2').prop('style').display='';
            $('#domisili3').prop('style').display='';
            $('#domisili4').prop('style').display='';
            $('#domisili5').prop('style').display='';

        <?php } ?>

        <?php if ($details['vaksin_nama']=='Belum Vaksin'){ ?>

            $('#vaksin').prop('style').display='none';

        <?php }else{ ?>

            $('#vaksin').prop('style').display='';

        <?php } ?>

    });

    $(document).ready(function() {

        setFormValidation('#dataKaryawanForm');

        $('#dt_keluarga').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
            zeroRecords: "Oops!",
            },
            serverSide: true,
            processing: true,
            ajax: {
                    "url": "<?= site_url('profil/keluarga/get') ?>",
                    "type": "POST"
                },
            columns: [
                { "data": "hubungan" },
                { "data": "nik" },
                { "data": "nama" },
                { "data": "lahir_tempat" },
                { "data": "lahir_tanggal" },
                { "data": "jenis_kelamin" },
                { "data": "pekerjaan" }
            ]
        });

        $('#dt_keluarga').on('click', 'tr', function () {
            var nik = $('td', this).eq(1).text();
            var nama = $('td', this).eq(2).text();
            var tempat = $('td', this).eq(3).text();
            var tanggal = $('td', this).eq(4).text();
            var jenis_kelamin = $('td', this).eq(5).text();
            var hubungan = $('td', this).eq(0).text();
            var pekerjaan = $('td', this).eq(6).text();
            $('#hapusKeluarga').modal("show");
            $('#hapusKeluarga').find('.modal-body input[name="nik1"]').val(nik);
            $('#hapusKeluarga').find('.modal-body input[name="nama1"]').val(nama);
            $('#hapusKeluarga').find('.modal-body input[name="nik"]').val(nik);
            $('#hapusKeluarga').find('.modal-body input[name="nama"]').val(nama);
            $('#hapusKeluarga').find('.modal-body input[name="lahir_tempat"]').val(tempat);
            $('#hapusKeluarga').find('.modal-body input[name="lahir_tanggal"]').val(tanggal);
            $('#hapusKeluarga').find('.modal-body input[name="jenis_kelamin"]').val(jenis_kelamin);
            $('#hapusKeluarga').find('.modal-body input[name="hubungan"]').val(hubungan);
            $('#hapusKeluarga').find('.modal-body input[name="pekerjaan"]').val(pekerjaan);
        });

        $('#refresh_ktp').click(function() {
            $('#prov_ktp').selectpicker('val', '');
            $('#prov_ktp').selectpicker('refresh');
            $('#kab_ktp').selectpicker('val', '');
            $('#kab_ktp').selectpicker('refresh');
            $('#kec_ktp').selectpicker('val', '');
            $('#kec_ktp').selectpicker('refresh');
            $('#desa_ktp').selectpicker('val', '');
            $('#desa_ktp').selectpicker('refresh');
        });

        $('#prov_ktp').change(function() {
            var prov = $('#prov_ktp').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('wilayah/kab') ?>",
                data: {
                    prov: prov
                },
                success: function(data) {
                    // alert(data)
                    $('#kab_ktp').html(data);
                    $('#kab_ktp').selectpicker('refresh');
                    $('#kec_ktp').selectpicker('val', '');
                    $('#kec_ktp').selectpicker('refresh');
                    $('#desa_ktp').selectpicker('val', '');
                    $('#desa_ktp').selectpicker('refresh');
                }
            })
        });

        $('#kab_ktp').change(function() {
            var kab = $('#kab_ktp').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('wilayah/kec') ?>",
                data: {
                    kab: kab
                },
                success: function(data) {
                    // alert(data)
                    $('#kec_ktp').html(data);
                    $('#kec_ktp').selectpicker('refresh');
                    $('#desa_ktp').selectpicker('val', '');
                    $('#desa_ktp').selectpicker('refresh');
                }
            })
        });

        $('#kec_ktp').change(function() {
            var kec = $('#kec_ktp').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('wilayah/desa') ?>",
                data: {
                    kec: kec
                },
                success: function(data) {
                    // alert(data)
                    $('#desa_ktp').html(data);
                    $('#desa_ktp').selectpicker('refresh');
                }
            })
        });

        $('#refresh').click(function() {
            $('#prov').selectpicker('val', '');
            $('#prov').selectpicker('refresh');
            $('#kab').selectpicker('val', '');
            $('#kab').selectpicker('refresh');
            $('#kec').selectpicker('val', '');
            $('#kec').selectpicker('refresh');
            $('#desa').selectpicker('val', '');
            $('#desa').selectpicker('refresh');
        });

        $('#prov').change(function() {
            var prov = $('#prov').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('wilayah/kab') ?>",
                data: {
                    prov: prov
                },
                success: function(data) {
                    // alert(data)
                    $('#kab').html(data);
                    $('#kab').selectpicker('refresh');
                    $('#kec').selectpicker('val', '');
                    $('#kec').selectpicker('refresh');
                    $('#desa').selectpicker('val', '');
                    $('#desa').selectpicker('refresh');
                }
            })
        });

        $('#kab').change(function() {
            var kab = $('#kab').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('wilayah/kec') ?>",
                data: {
                    kab: kab
                },
                success: function(data) {
                    // alert(data)
                    $('#kec').html(data);
                    $('#kec').selectpicker('refresh');
                    $('#desa').selectpicker('val', '');
                    $('#desa').selectpicker('refresh');
                }
            })
        });

        $('#kec').change(function() {
            var kec = $('#kec').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('wilayah/desa') ?>",
                data: {
                    kec: kec
                },
                success: function(data) {
                    // alert(data)
                    $('#desa').html(data);
                    $('#desa').selectpicker('refresh');
                }
            })
        });

        // when unchecked or checked, run the function
        $('#checkdomisili').change(function() {
            if (this.checked) {
                $('#domisili1').prop('style').display='none';
                $('#domisili2').prop('style').display='none';
                $('#domisili3').prop('style').display='none';
                $('#domisili4').prop('style').display='none';
                $('#domisili5').prop('style').display='none';
                $('#alamat').prop('disabled', true);
                $('#prov').prop('disabled', true);
                $('#kab').prop('disabled', true);
                $('#kec').prop('disabled', true);
                $('#desa').prop('disabled', true);
                
            } else {
                $('#domisili1').prop('style').display='';
                $('#domisili2').prop('style').display='';
                $('#domisili3').prop('style').display='';
                $('#domisili4').prop('style').display='';
                $('#domisili5').prop('style').display='';
                $('#alamat').prop('disabled', false);
                $('#prov').prop('disabled', false);
                $('#kab').prop('disabled', false);
                $('#kec').prop('disabled', false);
                $('#desa').prop('disabled', false);
            }
        });

        $('#vaksin_nama').change(function() {
            var vaksin = $('#vaksin_nama').val();
            if (vaksin == 'Belum Vaksin'){
                $('#vaksin').prop('style').display='none';
                $('#vaksin_dosis').val('');
                $('#vaksin_dosis').prop('disabled', true);
                $('#vaksin_dosis').prop('required', false);
                $('#vaksin_tanggal').val('');
                $('#vaksin_tanggal').prop('disabled', true);
                $('#vaksin_tanggal').prop('required', false);
            }else{
                $('#vaksin').prop('style').display='';
                $('#vaksin_dosis').prop('disabled', false);
                $('#vaksin_dosis').prop('required', true);
                $('#vaksin_tanggal').prop('disabled', false);
                $('#vaksin_tanggal').prop('required', true);
            }

        });

        // when unchecked or checked, run the function
        $('#checkConfirm').change(function() {
            if (this.checked) {
                $('#submit').prop('disabled', false);
            } else {
                $('#submit').prop('disabled', true);
            }
        });

        $('#btn_save').on('click',function(){
            var hubungan=$('#hubungan').val();
            var nik=$('#nik').val();
            var nama=$('#nama').val();
            var jenis_kelamin=$('#jenis_kelamin').val();
            var lahir_tempat=$('#lahir_tempat').val();
            var lahir_tanggal=$('#lahir_tanggal').val();
            var pekerjaan=$('#pekerjaan').val();
            $.ajax({
                type : "POST",
                url  : "<?= site_url('profil/keluarga/add') ?>",
                // dataType : "JSON",
                data : {hubungan:hubungan, nik:nik, nama:nama, lahir_tempat:lahir_tempat, lahir_tanggal:lahir_tanggal, jenis_kelamin:jenis_kelamin, pekerjaan:pekerjaan},
                success: function(result){
                    // result = JSON.parse(result)
                    // alert(result);

                    $('#tambahKeluarga').modal('hide');
                    $('#dt_keluarga').DataTable().ajax.reload();
                    
                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Data telah tersimpan."
                    }, {
                        type: "success",
                        timer: 2000,
                        placement: {
                        from: "top",
                        align: "center"
                        }
                    });
                },
                error: function(result){
                    $('#tambahKeluarga').modal('hide');
                    $.notify({
                            icon: "add_alert",
                            message: "<b>GAGAL!</b> Anggota keluarga ini sudah ada."
                        }, {
                            type: "danger",
                            timer: 2000,
                            placement: {
                            from: "top",
                            align: "center"
                            }
                        });
                }
            });
            return false;
        });
        
        $('#btn_delete').on('click',function(){
            var nik=$('#nik1').val();
            var nama=$('#nama1').val();
            $.ajax({
                type : "POST",
                url  : "<?= site_url('profil/keluarga/delete') ?>",
                // dataType : "JSON",
                data : {nik:nik, nama:nama},
                success: function(result){
                    // result = JSON.parse(result)
                    // alert(result);

                    $('#hapusKeluarga').modal('hide');
                    $('#dt_keluarga').DataTable().ajax.reload();
                    
                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Data berhasil dihapus."
                    }, {
                        type: "success",
                        timer: 2000,
                        placement: {
                        from: "top",
                        align: "center"
                        }
                    });
                },
                error: function(result){
                    $('#hapusKeluarga').modal('hide');
                    $.notify({
                            icon: "add_alert",
                            message: "<b>GAGAL!</b> Data gagal dihapus."
                        }, {
                            type: "danger",
                            timer: 2000,
                            placement: {
                            from: "top",
                            align: "center"
                            }
                        });
                }
            });
            return false;
        });

        <?php if ($this->session->flashdata('notify')=='success'){ ?>
       
       $.notify({
            icon: "add_alert",
            message: "<b>Berhasil!</b> Data telah tersimpan."
        }, {
            type: "success",
            timer: 2000,
            placement: {
                from: "top",
                align: "center"
            }
        });
      
       <?php } ?>
    });
</script>