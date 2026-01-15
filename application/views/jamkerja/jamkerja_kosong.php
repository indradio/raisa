<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Laporan Kerja Harian
                            <small> - <?= date("d M Y", strtotime($tanggal)); ?></small>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                                <a href="#" class="btn btn-lg btn-block btn-facebook mb-2" data-toggle="modal" data-target="#jamkerjaModal" role="button" aria-disabled="false">BUAT LAPORAN JAM KERJA</a>
                        </div>
                        <div class="material-datatables disabled">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Aktivitas</th>
                                        <th>Deskripsi</th>
                                        <th>Durasi (Jam)</th>
                                        <th>Hasil (%)</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Aktivitas</th>
                                        <th>Deskripsi</th>
                                        <th>Durasi</th>
                                        <th>Hasil</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <!-- <div class="row"> -->
                        <p> Perhatikan hal-hal berikut :
                            </br> 1. Laporan Kerja Harian kamu akan otomatis ter-submit jika durasi sudah 6 Jam Kerja untuk shift 1.
                            </br> 2. Laporan Kerja Harian kamu akan otomatis ter-submit jika durasi sudah 8 Jam Kerja untuk shift 2.
                            </br> 3. Laporan Kerja Harian kamu akan otomatis ter-submit jika durasi sudah 7 Jam Kerja untuk shift 3.
                            </br> 4. Istirahat Siang hanya untuk aktivitas lembur, tidak untuk Laporan Kerja Harian.
                            <!-- </div> -->
                            </br>
                            </br>
                            <a href="<?= base_url('jamkerja'); ?>" class="btn btn-reddit mb-2" role="button" aria-disabled="false">KEMBALI</a>
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
<div class="modal fade" id="jamkerjaModal" tabindex="-1" role="dialog" aria-labelledby="jamkerjaModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form-horizontal" method="post" action="<?= base_url('jamkerja/add_jamkerja'); ?>">
                    <div class="modal-body">
                    <input type="hidden" class="form-control" id="tanggal" name="tanggal" value="<?= date("d-m-Y", strtotime($tanggal)); ?>">
                        <div class="row col-md-11 ml-auto mr-auto">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Mohon untuk memilih shift sesuai waktu kerja.
                                    </br>Untuk perubahan shift dapat menghubungi admin.
                            </div>
                        </div>
                        <div class="row">
                                <label class="col-md-3 col-form-label">Pilih Shift</label>
                                <div class="col-md-7">
                                    <div class="form-group has-default">
                                        <select class="form-control selectpicker" data-size="5" data-style="btn btn-link" id="shift" name="shift" title="Pilih Shift" required="true">
                                            <option value="SHIFT1">Shift 1 (00:00-07:00)</option>
                                            <option value="SHIFT1_PAKO">Shift 1_PAKO (21:00-04:00)</option>
                                            <option value="SHIFT2">Shift 2 (07:00-16:00)</option>
                                            <option value="SHIFT3_A">Shift 3_A (13:00-22:00)</option>
                                            <option value="SHIFT3">Shift 3 (16:00-00:00)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-success">BUAT LAPORAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>