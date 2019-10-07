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
                        <h4 class="card-title">Laporan Kerja Harian</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                        </div>
                        <div class="material-datatables">
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aktivitas</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Aktivitas</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($aktivitas as $a) : ?>
                                <tr>
                                    <td><?= $a['no']; ?></td>
                                    <td><?= $a['aktivitas']; ?></td>
                                    <td class="text-right">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#aktivitasModal" data-kategori="<?= $kategori; ?>" data-aktivitas="<?= $a['aktivitas']; ?>">PILIH</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <i class="fa fa-circle text-danger"></i> Perjalanan yang tanggal keberangkatan sudah lewat -->
                            </div>
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
<div class="modal fade" id="aktivitasModal" tabindex="-1" role="dialog" aria-labelledby="aktivitasModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-rose text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Aktivitas</h4>
                    </div>
                </div>
                <form id="Aktivitas" class="form" method="post" action="<?= base_url('jamkerja/addaktivitas'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">Aktivitas</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="aktivitas">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Durasi</label>
                                <div class="col-md-4">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" data-size="5" data-style="btn btn-primary btn-sm btn-round" id="durasi" name="durasi" title="Durasi (Jam)" required="true">
                                            <option value="0.5">00:30</option>
                                            <option value="1">01:00</option>
                                            <option value="1.5">01:30</option>
                                            <option value="2">02:00</option>
                                            <option value="2.5">02:30</option>
                                            <option value="3">03:00</option>
                                            <option value="3.5">03:30</option>
                                            <option value="4">04:00</option>
                                            <option value="4.5">04:30</option>
                                            <option value="5">05:00</option>
                                            <option value="5.5">05:30</option>
                                            <option value="6">06:00</option>
                                            <option value="6.5">06:30</option>
                                            <option value="7">07:00</option>
                                            <option value="7.5">07:30</option>
                                            <option value="8">08:00</option>
                                           
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Deskripsi Hasil <small><i>Opsional</i></small></label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea class="form-control" id="deskripsi_hasil" name="deskripsi_hasil" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-right">
                                <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
                                <button type="submit" class="btn btn-rose btn-round">SIMPAN</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>