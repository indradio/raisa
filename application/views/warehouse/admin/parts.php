<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
    <div class="row mt-3">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">warehouse</i>
            </div>
            <p class="card-category">Total Item</p>
            <h3 class="card-title"><?= $total_part; ?></h3>
          </div>
          <div class="card-footer">
            <a href="#" class="btn btn-facebook btn-block" role="button" aria-disabled="false" data-toggle="modal" data-target="#importPart">Upload</a>
          </div>
        </div>
      </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <!-- <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div> -->
                        <h4 class="card-title">Daftar Komponen</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dt-parts" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Description</th>
                                        <th>Location</th>
                                        <th>Stock</th>
                                        <th>Unit</th>
                                        <th class="th-description">Price</th>
                                        <th class="disabled-sorting th-description text-right">Actions</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Asset</th>
                                        <th class="th-description">Tgl Opname</th>
                                        <th class="th-description text-right">Actions</th>
                                    </tr>
                                </tfoot> -->
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

<div class="modal fade" id="importPart" tabindex="-1" role="dialog" aria-labelledby="importPartTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Import</h4>
                    </div>
                </div>
                <?= form_open_multipart('warehouse/admin_parts_upload'); ?>
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="file" name="data" id="data" class="inputFileVisible" placeholder="Single File">
                        </div>
                        <div class="modal-footer">
                          <a href="<?= base_url('assets/temp_excel/template_upload_part.xlsx'); ?>" class="btn btn-linkedin btn-link" role="button" aria-disabled="false">DOWNLOAD TEMPLATE</a>
                          <div class="row">
                            <div class="col-md-12 mr-4">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
                                <button type="submit" class="btn btn-success">SUBMIT</button>
                            </div>
                          </div>
                        </div>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#dt-parts').DataTable({
            "pagingType": "full_numbers",
            scrollX: true,
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            ajax: {
                    "url"   : "<?= site_url('warehouse/get/parts') ?>",
                    "type"  : "POST"
                },
            columns: [
                { "data": "id" },
                { "data": "description" },
                { "data": "loc" },
                { "data": "stock" },
                { "data": "unit" },
                { "data": "price" },
                { "data": "action", className: "text-right" }
            ],
        });

        // $('#opname').on('show.bs.modal', function(event) {
        //     var button = $(event.relatedTarget)
        //     var id = button.data('id')
        //     var modal = $(this)
        //     modal.find('.modal-body input[name="id"]').val(id)
        // })

    });
</script>