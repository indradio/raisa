<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">warehouse</i>
                        </div>
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