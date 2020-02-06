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
                        <h4 class="card-title"><?php echo $project['deskripsi'];?><SMALL>(Budget Man Hour)</SMALL></h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                       <th>Part</th>
                                       <th>Budget</th>
                                       <th>EAC</th>
                                       <th>Aktual</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($manhour as $mh) : ?>

                                    <tr>
                                        <td><?= $mh['part']; ?></td>
                                        <td><?= $mh['budget']; ?></td>
                                        <td><?= $mh['estimasi']; ?></td>
                                        <?php $a=$mh['budget'];
                                            $b=$mh['estimasi'];
                                            $c= $a-$b; ?>
                                        <td><?= $c; ?></td>
                                        <td>
                                            <!-- $sect_id -->
                                           <a href="javascript:;" 
                                                    data-id="<?php echo $mh['id'] ?>"
                                                    data-part="<?php echo $mh['part'] ?>"
                                                    data-copro="<?php echo $mh['copro'] ?>"
                                                    data-budget="<?php echo $mh['budget'] ?>"
                                                    data-estimasi="<?php echo $mh['estimasi'] ?>"
                                            class="btn btn-sm btn-info" data-toggle="modal" data-target="#projectModal" >EAC</a></td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                       <th>Part</th>
                                       <th>Budget</th>
                                       <th>EAC</th>
                                       <th>Aktual</th>
                                       <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <a href="<?= base_url('projectbudget/'); ?>"  class="btn btn-sm ">back</a>
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
                        <h4 class="card-title">Project Budget Estimasi</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('mh/updateeac'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" >
                                <label class="col-md-3 col-form-label">COPRO</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="hidden" class="form-control disabled" id="id" name="id" required >
                                        <input type="text" class="form-control disabled" id="copro" name="copro" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">PART</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                       <input type="text" class="form-control disabled" name="part" id="part">
                                    </div>
                                </div>
                            </div>  <div class="row" >
                                <label class="col-md-3 col-form-label">BUDGET</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control disabled" id="budget" name="budget">
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">EAC</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" id="estimasi" name="estimasi">
                                    </div>
                                </div>
                            </div>
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
<div class="modal fade" id="tambahCopro" tabindex="-1" role="dialog" aria-labelledby="tambahCoproTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-success text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Project Budget</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('mh/tmbhmanhour'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" hidden>
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" rows="3" class="form-control" id="copro" name="copro" value="<?= $project['copro']; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Part</label>
                                <div class="col-md-4">
                                    <div class="form-group has-default">
                                       <select class="selectpicker" id="part" name="part" data-style="select-with-transition" data-size="7"required>
                                           <option value="ENG">Engginer</option> 
                                           <option value="MCH">Machinery</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Estimasi</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" rows="3" class="form-control" id="estimasi" name="estimasi" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success btn-round">SIMPAN</button>
                                <br>
                                <button type="button" class="btn btn-default btn-round" data-dismiss="modal">TUTUP</button>
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

            modal.find('#id').attr("value",div.data('id'));
            modal.find('#copro').attr("value",div.data('copro'));
            modal.find('#estimasi').attr("value",div.data('estimasi'));
            modal.find('#part').attr("value",div.data('part'));
            modal.find('#budget').attr("value",div.data('budget'));
          
        }); 
});
</script><script>
    $(document).ready(function() {
      // Initialise Sweet Alert library
      demo.showSwal();
    });
  </script>