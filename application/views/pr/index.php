<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
                <div class="col-lg-2 col-md-6 col-sm-6 d-none d-sm-block">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">near_me</i>
                            </div>
                            <p class="card-category">REQUEST</p>
                            <h3 class="card-title"><?= isset($counts['null']) ? $counts['null'] : 0; ?></h3>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 d-none d-sm-block">
                    <div class="card card-stats">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">report</i>
                            </div>
                            <p class="card-category">PR RELEASE</p>
                            <h3 class="card-title"><?= isset($counts['X']) ? $counts['X'] : 0; ?></h3>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 d-none d-sm-block">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">report</i>
                            </div>
                            <p class="card-category">ADMIN PCH</p>
                            <h3 class="card-title"><?= isset($counts['XX']) ? $counts['XX'] : 0; ?></h3>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 d-none d-sm-block">
                    <div class="card card-stats">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">report</i>
                            </div>
                            <p class="card-category">BUYER</p>
                            <h3 class="card-title"><?= isset($counts['XXX']) ? $counts['XXX'] : 0; ?></h3>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 d-none d-sm-block">
                    <div class="card card-stats">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">report</i>
                            </div>
                            <p class="card-category">PO RELEASE</p>
                            <h3 class="card-title"><?= isset($counts['XXXX']) ? $counts['XXXX'] : 0; ?></h3>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 d-none d-sm-block">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">report</i>
                            </div>
                            <p class="card-category">DEL, QC, ARRIVED</p>
                            <h3 class="card-title"><?= isset($counts['XXXXX']) ? $counts['XXXXX'] : 0; ?></h3>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Purchase Request</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Last Update : <?= $last; ?></h3>
                            <?php if ($this->session->userdata('sect_id') == '222' or $this->session->userdata('npk') == '1111'): ?>
                                <a href="#" class="btn btn-linkedin" role="button" aria-disabled="false" data-toggle="modal" data-target="#importProject">
                                    Import ZMPU
                                </a>
                            <?php endif; ?>
                        </div>
</p>
                        <div class="material-datatables">
                            <table id="dtproject" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>PR DATE</th>
                                        <th>PR NUMBER</th>
                                        <th>STATUS</th>
                                        <th>REQUESTOR</th>
                                        <th>COPRO</th>
                                        <th>DESC</th>
                                        <th>QTY</th>
                                        <th>UoM</th>
                                        <th>PCH</th>
                                        <th>DETAILS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>PR Date</th>
                                        <th>PR Number</th>
                                        <th>Status</th>
                                        <th>Requestor</th>
                                        <th>COPRO</th>
                                        <th>Description</th>
                                        <th>Qty</th>
                                        <th>UoM</th>
                                        <th>PCH</th>
                                        <th>Details</th>
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
                        <h4 class="card-title">Project</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('project/updateProject'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">COPRO</label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="copro">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Customer</label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="customer">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Deskripsi</label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="deskripsi"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Status</label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                    <select class="selectpicker" name="status" id="status" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" required>
                                    <?php
                                        foreach ($liststatus as $s) : ?>
                                            <option value="<?= $s->nama; ?>"><?= $s->nama; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Tanggal</label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                    <input type="text" class="form-control datepicker" id="tanggal" name="tanggal" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-warning btn-round">UPDATE</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addProject" tabindex="-1" role="dialog" aria-labelledby="addProjectTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Project</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('project/addProject'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">COPRO</label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="copro">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Customer</label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                    <select class="selectpicker" name="customer" id="customer" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                    <?php
                                        foreach ($listcustomer as $s) : ?>
                                            <option value="<?= $s->inisial; ?>"><?= $s->nama.' ('.$s->inisial.')'; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Description</label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="deskripsi" style="text-transform: uppercase"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <label class="col-md-3 col-form-label">Create Date</label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control datepicker" id="tanggal" name="tanggal" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success btn-round">Tambah</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importProject" tabindex="-1" role="dialog" aria-labelledby="importProjectTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">ZMPU</h4>
                    </div>
                </div>
                <?= form_open_multipart('Purchaserequest/ImportData'); ?>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <!-- <label class="col-md-3 col-form-label">Select File </label> -->
                                <!-- <div class="fileinput fileinput-new" data-provides="fileinput"> -->
                                
                                    <!-- <input type="file" class="inputFileHidden"> -->
                                    <div class="input-group">
                                        <input type="file" name="zmpu" id="zmpu" class="form-control inputFileVisible" placeholder="Single File">
                                        <!-- <span class="input-group-btn">
                                            <button type="file" class="btn btn-fab btn-round btn-primary">
                                                <i class="material-icons">attach_file</i>
                                            </button>
                                        </span> -->
                                    </div>
                                <!-- </div> -->
                            </div>
                            <div class="modal-footer justify-content-right">
                            <a href="<?= base_url('assets/temp_excel/template_upload_zmpu.xlsx'); ?>" class="btn btn-linkedin btn-link" role="button" aria-disabled="false">DOWNLOAD TEMPLATE</a>
                                <button type="submit" class="btn btn-success">Import</button>
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
        //dtproject
        var tableproject = $('#dtproject').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            scrollX: true,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('Purchaserequest/getDataZmpu') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [6,9], //first column / numbering column
                // "targets": [0,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18], //first column / numbering column
                "orderable": false, //set not orderable
            },
            // {
            //     "targets": [9], //first column / numbering column
            //     "orderable": false, //set not orderable
            //     "defaultContent": "<a href='#' class='btn btn-sm btn-info btn-round'>DETAIL</a>",
            // }, 
        ],
    });

    $('#dtproject tbody').on('click', 'button', function() {
        var data = tableproject.row($(this).parents('tr')).data();
        $('#projectModal').on('show.bs.modal', function() {
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-body input[name="copro"]').val(data[1])
            modal.find('.modal-body input[name="customer"]').val(data[2])
            modal.find('.modal-body textarea[name="deskripsi"]').val(data[3])
        })
        
        $('#projectModal').modal("show");
        
    });

        var groupColumn = 1;
        var tablewbs = $('#dtwbs').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [-1],
                ["All"]
            ],
            scrollX: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "visible": false,
                "targets": groupColumn
            }, ],
            "columnDefs": [{
                "targets": [12], //first column / numbering column
                "orderable": false, //set not orderable
            }, ],
            "order": [
                [0, 'asc']
            ],
            "displayLength": -1,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(groupColumn, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group"><td colspan="13">' + group + '</td></tr>'
                        );

                        last = group;
                    }
                });
            }
        });

        // var groupColumn = 1;
        var tableakwbs = $('#dtakwbs').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [-1],
                ["All"]
            ],
            scrollX: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "visible": false,
                "targets": groupColumn
            }, ],
            "columnDefs": [{
                "targets": [8], //first column / numbering column
                "orderable": false, //set not orderable
            }, ],
            "order": [
                [0, 'asc']
            ],
            "displayLength": -1,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(groupColumn, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group"><td colspan="9">' + group + '</td></tr>'
                        );

                        last = group;
                    }
                });
            }
        });
    });
</script>