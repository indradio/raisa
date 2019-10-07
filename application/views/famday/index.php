<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Data Peserta Family Day 2019</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="#" class="btn btn-lg btn-primary mb-2" data-toggle="modal" data-target="#daftar" role="button" aria-disabled="false">DAFTAR</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Ikut</th>
                                        <th>Ukuran Baju</th>
                                        <th>Istri/Suami</th>
                                        <th>Ukuran Baju</th>
                                        <th>Anak Ke-1</th>
                                        <th>Anak Ke-2</th>
                                        <th>Anak Ke-3</th>
                                        <th>Tambahan (Orang)</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Ikut</th>
                                        <th>Ukuran Baju</th>
                                        <th>Istri/Suami</th>
                                        <th>Ukuran Baju</th>
                                        <th>Anak Ke-1</th>
                                        <th>Anak Ke-2</th>
                                        <th>Anak Ke-3</th>
                                        <th>Tambahan (Orang)</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($famday as $f) : ?>
                                        <tr>
                                            <td><?= $f['ikut']; ?></td>
                                            <td><?= $f['ukuran']; ?></td>
                                            <td><?= $f['pasangan']; ?></td>
                                            <td><?= $f['ukuran_pasangan']; ?></td>
                                            <td><?= $f['anak1']; ?></td>
                                            <td><?= $f['anak2']; ?></td>
                                            <td><?= $f['anak3']; ?></td>
                                            <td><?= $f['tambahan']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<!-- Modal -->
<div class="modal fade" id="daftar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-rose text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Pendataan Peserta Family Day 2019</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form" method="post" action="<?= base_url('famday/daftar'); ?>">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-4 col-form-label">Nama Karyawan</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nama" value="<?= $karyawan['nama']; ?> ">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Keikutsertaan</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="ikut" name="ikut" value="1">
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Ukuran Baju</label>
                                <div class="col-md-6">
                                    <select class="selectpicker" id="baju" name="baju" data-style="select-with-transition" title="Pilih" data-size="7" data-width="75%" data-live-search="false" required>
                                        <?php
                                        $ukuran = $this->db->get_where('famday_baju')->result_array();
                                        foreach ($ukuran as $u) : ?>
                                            <option value="<?= $u['ukuran']; ?>"><?= $u['ukuran']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Istri/Suami</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="pasangan" name="pasangan" value="1">
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Ukuran Baju</label>
                                <div class="col-md-6">
                                    <select class="selectpicker" id="pasangan_baju" name="pasangan_baju" data-style="select-with-transition" title="Pilih" data-size="7" data-width="75%" data-live-search="false" required>
                                        <?php
                                        // $ukuran = $this->db->get_where('famday_baju')->result_array();
                                        foreach ($ukuran as $u) : ?>
                                            <option value="<?= $u['ukuran']; ?>"><?= $u['ukuran']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Anak</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="anak1" name="anak1" value="1">
                                        Anak Ke-1
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label"></label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="anak2" name="anak2" value="1">
                                        Anak Ke-2
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label"></label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="anak3" name="anak3" value="1">
                                        Anak Ke-3
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 col-form-label">Keluarga Tambahan</label>
                                <div class="col-md-6">
                                    <select class="selectpicker" id="tambahan" name="tambahan" data-style="select-with-transition" title="Pilih" data-size="7" data-width="75%" data-live-search="false" required>
                                        <option value="">Tidak Ada</option>
                                        <option value="1">1 Orang</option>
                                        <option value="2">2 Orang</option>
                                        <option value="3">3 Orang</option>
                                        <option value="4">4 Orang</option>
                                        <option value="5">5 Orang</option>
                                        <option value="6">6 Orang</option>
                                        <option value="7">7 Orang</option>
                                        <option value="8">8 Orang</option>
                                        <option value="9">9 Orang</option>
                                        <option value="10">10 Orang</option>
                                        <option value="10+">Lebih dari 10 Orang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-fill btn-success">DAFTAR</button>
                                <button type="button" class="btn btn-fill btn-default ml-1" data-dismiss="modal">TUTUP</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>