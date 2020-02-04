<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <!-- <div class="container-fluid"> -->
        <!-- <div class="row">
            <label class="col-md-2 col-form-label">Catatan <p><small> *Opsional</small></p></label>
            <div class="col-md-5">
                <div class="form-group has-default">
                    <textarea rows="2" class="form-control" name="catatan"></textarea>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Kirim Pesan</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!-- Here you can write extra buttons/actions for the toolbar -->
                            <a href="#" class="btn btn-info mb-2" role="button" aria-disabled="false" data-toggle="modal" data-target="#kirimPesan">Kirim Pesan Baru</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Dari</th>
                                        <th>Ke</th>
                                        <th>Pesan</th>
                                        <!-- <th class="disabled-sorting text-right">Actions</th> -->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>Tanggal</th>
                                        <th>Dari</th>
                                        <th>Ke</th>
                                        <th>Pesan</th>
                                        <!-- <th class="text-right">Actions</th> -->
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        foreach ($pesan as $p) : ?>
                                            <tr>
                                                <td><?= date('d-M-Y H:i', strtotime( $p['create_at'])); ?></td>
                                                <td><?= $p['pengirim']; ?></td>
                                                <td><?= $p['penerima']; ?></td>
                                                <td><?= $p['pesan']; ?></td>
                                                <!-- <td class="text-right">
                                                    <a href="<?= base_url('layanan/hapusInformasi/') . $p['id']; ?>" class="btn btn-round btn-danger btn-sm">DELETE</a>
                                                </td> -->
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
        <!-- </div> -->
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<!-- <script>
    tinymce.init({
        selector: 'textarea'
    });
</script> -->

<!-- Modal Buat Informasi Baru-->
<div class="modal fade" id="kirimPesan" tabindex="-1" role="dialog" aria-labelledby="kirimPesanTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">KIRIM PESAN</h4>
                    </div>
                </div>
                    <div class="modal-body">
                    <?= form_open_multipart('layanan/messages_send'); ?>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Kepada</label>
                            <div class="col-md-9">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="penerima[]" id="penerima" data-style="select-with-transition" title="Pilih" data-size="7" multiple data-live-search="true" required>
                                        <?php 
                                    $karyawan = $this->db->where('is_active','1');
                                    $karyawan = $this->db->where('status','1');
                                    $karyawan = $this->db->get('karyawan')->result_array();
                                    foreach ($karyawan as $k) : ?>
                                        <option data-subtext="<?= $k['nama']; ?>" value="<?= $k['phone']; ?>"><?= $k['inisial']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                                        
                        <div class="row">
                            <label class="col-md-2 col-form-label">Pesan</label>
                            <div class="col-md-9">
                                <div class="form-group has-default">
                                    <textarea rows="5" class="form-control" name="pesan" id="pesan"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                            <a href="" class="btn btn-link">Close</a>
                            <button type="submit" class="btn btn-success">KIRIM</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Upload Baner-->
<div class="modal fade" id="uploadBanner" tabindex="-1" role="dialog" aria-labelledby="uploadBannerTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">UPDATE INFORMASI</h4>
                    </div>
                </div>
                    <div class="modal-body">
                    <?= form_open_multipart('layanan/updateInformasi'); ?>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Id</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" id="id" name="id" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Title</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" id="judul" name="judul" required>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <label class="col-md-4 col-form-label">Deskripsi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="deskripsi"></textarea>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <label class="col-md-4 col-form-label">Expired</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datepicker" id="berlaku" name="berlaku" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Banner</label>
                            <div class="col-md-7">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img src="<?= base_url(); ?>assets/img/info" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                        <span class="btn btn-round btn-rose btn-file btn-sm">
                                            <span class="fileinput-new">Pilih Gambar</span>
                                            <span class="fileinput-exists">Ganti</span>
                                            <input type="file" name="gambar_banner" />
                                        </span>
                                        <br />
                                        <a href="#" class="btn btn-danger btn-round fileinput-exists btn-sm" data-dismiss="fileinput"><i class="fa fa-times"></i>Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                            <a href="" class="btn btn-link">Close</a>
                            <button type="submit" class="btn btn-success">UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>