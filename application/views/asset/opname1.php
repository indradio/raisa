<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
                <div class="card ">
                    <div class="card-body ">
                        <?= form_open_multipart('asset/opname_proses/1'); ?>
                        <input type="hidden" class="form-control" name="id" value="<?= $asset['id']; ?>" required>
                            <div class="col-md-4 ml-auto mr-auto">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img src="<?= base_url('assets/img/asset/no-photo.jpg'); ?>" alt="foto" name="foto">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                        <span class="btn btn-round btn-facebook btn-file btn-sm">
                                            <span class="fileinput-new">Upload Foto</span>
                                            <span class="fileinput-exists">Ulangi</span>
                                            <input type="file" name="foto" required="true"/>
                                        </span>
                                        <a href="#" class="btn btn-youtube btn-round btn-sm fileinput-exists" data-dismiss="fileinput"></i>Hapus</a>
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer justify-content-end">
                            <a href="<?= base_url('asset/outstanding'); ?>" class="btn btn-link">Kembali</a>
                            <button type="submit" class="btn btn-success">SELANJUTNYA</button>
                        </div>
                        </form>
                    </div>
                </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->