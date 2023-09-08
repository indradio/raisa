<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body ">
                        <?= form_open_multipart('asset/verification/proses'); ?>
                        <input type="hidden" class="form-control" name="id" value="<?= $asset['id']; ?>" required>
                        <div class="row">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="col-md-4">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img src="<?= base_url().'assets/img/asset/2023/'. $asset['asset_image']; ?>" alt="foto" name="foto">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <!-- <div>
                                        <span class="btn btn-round btn-facebook btn-file">
                                            <span class="fileinput-new">Ambil Foto</span>
                                            <span class="fileinput-exists">Ganti</span>
                                            <input type="file" name="foto" required="true"/>
                                        </span>
                                        <br />
                                        <a href="#" class="btn btn-youtube btn-round fileinput-exists" data-dismiss="fileinput"></i>Hapus</a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">No. Asset</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="asset_no" value="<?= $asset['asset_no']; ?> - <?= $asset['asset_sub_no']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Asset Deskripsi</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control disabled" id="asset_deskripsi" name="asset_deskripsi"><?= $asset['asset_description']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Kategori</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="kategori" value="<?= $asset['category']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-2 col-form-label">First Acq</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="first_acq" value="<?= $asset['first_acq']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-2 col-form-label">Value Acq</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="value_acq" value="<?= $asset['value_acq']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-2 col-form-label">Cost Center</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="cost_center" value="<?= $asset['cost_center']; ?>" />
                                </div>
                            </div>
                        </div>
                        <?php $pic = $this->db->get_where('karyawan', ['npk' => $asset['npk']])->row(); ?>
                        <div class="row">
                            <label class="col-md-2 col-form-label">PIC</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="" value="<?= $pic->nama; ?>" />
                                </div>
                            </div>
                        </div>
                        <?php if ($asset['change_pic']=='Y'){
                            $new_pic = $this->db->get_where('karyawan', ['npk' => $asset['new_npk']])->row();?>
                        <div class="row">
                            <label class="col-md-2 col-form-label">New PIC</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="" value="<?= $new_pic->nama; ?>" />
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Room</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="" value="<?= $asset['room']; ?>" />
                                </div>
                            </div>
                        </div>
                        <?php if ($asset['change_room']=='Y'){ ?>
                        <div class="row">
                            <label class="col-md-2 col-form-label">New Room</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" name="" value="<?= $asset['new_room']; ?>" />
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-2">
                            <?php if ($asset['status']=='1'){ 
                                echo ' <button type="button" class="btn btn-success btn-wd disabled">BAIK-ADA-DIGUNAKAN</button>';
                            }elseif($asset['status']=='2'){
                                echo ' <button type="button" class="btn btn-warning btn-wd disabled">BAIK-TIDAK SESUAI</button>';
                            }elseif($asset['status']=='3'){
                                echo ' <button type="button" class="btn btn-danger btn-wd disabled">RUSAK</button>';
                            }elseif($asset['status']=='4'){
                                echo ' <button type="button" class="btn btn-dark btn-wd disabled">HILANG</button>';
                            }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Catatan</label>
                            <div class="col-md-4">
                                <div class="form-group has-default">
                                    <textarea rows="5" class="form-control" name="catatan" id="catatan" disabled><?= $asset['catatan']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <a href="<?= base_url('asset/fa/verification'); ?>" class="btn btn-link">Kembali</a>
                            <button type="button" class="btn btn-danger btn-link" role="button" data-toggle="modal" data-target="#reopname" data-id="<?= $asset['id']; ?>">REOPNAME</button>
                            <button type="submit" class="btn btn-success btn-wd">Verify</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<div class="modal fade" id="reopname" tabindex="-1" role="dialog" aria-labelledby="reopnameLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reopnameLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?= form_open_multipart('asset/reopname'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id" name="id" required="true" />
                    </div>
                    <div class="col-md-10 ml-auto mr-auto">
                        <div class="form-group">
                            <label for="note" class="bmd-label-floating"> Keterangan*</label>
                            <textarea rows="5" class="form-control" id="note" name="note"></textarea>
                        </div>
                    </div>
                    </p>
                    <div class="modal-footer">
                        <div class="ml-auto">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                          <button type="submit" id="submit" class="btn btn-success">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        
        $('#reopname').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        })
       
    });
</script>