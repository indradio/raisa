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
                        <h4 class="card-title"><?php echo $project['deskripsi'];?></h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th >Copro</th> 
                                        <th >Part</th> 
                                        <th >Kategori</th> 
                                        <th >Biaya Estimasi</th> 
                                        <th >Biaya Aktual</th> 
                                        <th >Keterangan</th> 
                                        <th ></th> 
                                        
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($Projectbudget as $p) : ?>
                                    <tr>
                                        <td><?= $p['copro']; ?></td>
                                        <td><?= $p['part']; ?></td>
                                        <td><?= $p['kategori']; ?></td>
                                        <td>Rp <?= number_format($p['biaya_est'],0,',','.') ?></td>
                                        <td>Rp <?= number_format($p['biaya_act'],0,',','.') ?></td>
                                        <td><?= $p['keterangan']; ?></td>
                                        <td>
                                           
                                             <a href="javascript:;" 
                                                    data-copro="<?php echo $p['copro'] ?>"
                                                    data-id="<?php echo $p['id'] ?>"
                                                    data-kategori="<?php echo $p['kategori'] ?>"
                                                    data-part="<?php echo $p['part'] ?>"
                                                    data-biaya_est="<?php echo $p['biaya_est'] ?>"
                                                    data-biaya_act="<?php echo $p['biaya_act'] ?>"
                                                    data-keterangan="<?php echo $p['keterangan'] ?>"
                                                 
                                            class="btn btn-sm btn-info" data-toggle="modal" data-target="#projectModal" >Aktual Cost</a>
                                        </td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th >Copro</th> 
                                        <th >Part</th> 
                                        <th >Kategori</th> 
                                        <th >Biaya Estimasi</th> 
                                        <th >Biaya Aktual</th> 
                                        <th >Keterangan</th> 
                                        <th ></th> 
                                    </tr> 
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- end card-body-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end content -->
<!-- Modal Tambah Karyawan -->
<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-success text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Project Budget Aktualisasi</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('Projectbudget/aktualcost'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="copro" name="copro" required >
                                        <input type="hidden" class="form-control disabled" id="id" name="id" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Part</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled " id="part" name="part" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Kategori</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="kategori" name="kategori">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Biaya Estimasi</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="biaya_est" name="biaya_est" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Biaya Aktual</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" id="biaya_act" name="biaya_act">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Keterangan </label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                       <textarea id="keterangan" name="keterangan" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success btn-round">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
 $(document).ready(function() {
    $('#projectModal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal          = $(this)
            modal.find('#copro').attr("value",div.data('copro'));
            modal.find('#id').attr("value",div.data('id'));
            modal.find('#kategori').attr("value",div.data('kategori'));
            modal.find('#part').attr("value",div.data('part'));
            modal.find('#biaya_est').attr("value",div.data('biaya_est'));
            modal.find('#biaya_act').attr("value",div.data('biaya_act'));
            modal.find('#budget').attr("value",div.data('budget'));
            modal.find('textarea#keterangan').val(div.data('keterangan'));
        });
    
 
});
</script>