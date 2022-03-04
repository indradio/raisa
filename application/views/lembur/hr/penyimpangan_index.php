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
                        <h4 class="card-title">Penyimpangan Lembur</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="dt-lembur" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Kategori</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Durasi/Jam</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Kategori</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Durasi/Jam</th>
                                        <th>Catatan</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
</div>
<div class="modal fade" id="penyimpanganModal" tabindex="-1" role="dialog" aria-labelledby="penyimpanganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penyimpanganModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="penyimpanganForm" method="#" action="#">
                <div class="modal-body">
                    <div class="form-group">
                      <label for="exampleid" class="bmd-label-floating">#</label>
                      <input type="text" class="form-control disabled" id="id" name="id" value=" " />
                    </div>
                    <div class="form-group">
                      <label for="exampleNama" class="bmd-label-floating">Nama</label>
                      <input type="text" class="form-control disabled" id="nama" name="nama" value=" "/>
                    </div>
                    <div class="form-group">
                      <label for="exampleTanggal" class="bmd-label-floating">Tanggal</label>
                      <input type="text" class="form-control disabled" id="tanggal" name="tanggal" value=" "/>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="checker" required="true"> Karyawan telah mengajukan memo yg ditanda tangani oleh atasan sampai kadiv
                        <span class="form-check-sign">
                          <span class="check"></span>
                        </span>
                      </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12 mr-1">
                            <button type="button" class="btn btn-default btn-link" data-dismiss="modal">KEMBALI</button>
                            <button type="button" id="submitBtn" class="btn btn-success">YA, AKTIFKAN!</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    setFormValidation('#penyimpanganForm');
    $('#dt-lembur').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        responsive: true,
        language: {
        search: "_INPUT_",
        searchPlaceholder: "Search records",
        zeroRecords: "Oops!",
        },
        processing: true,
        ajax: {
                "url": "<?= site_url('lembur/getData/penyimpangan') ?>",
                "type": "POST"
            },
        columns: [
            { "data": "id" },
            { "data": "kategori" },
            { "data": "nama" },
            { "data": "tanggal" },
            { "data": "durasi" },
            { "data": "catatan" }
        ]
    });

    var checker = document.getElementById('checker');
    var submitbtn = document.getElementById('submitBtn');
    
    $('#dt-lembur').on('click', 'tr', function () {
        var id = $('td', this).eq(0).text();
        var nama = $('td', this).eq(2).text();
        var tanggal = $('td', this).eq(3).text();
        $('#penyimpanganModal').modal("show");
        $('#penyimpanganModal').find('.modal-body input[name="id"]').val($('td', this).eq(0).text());
        $('#penyimpanganModal').find('.modal-body input[name="nama"]').val($('td', this).eq(2).text());
        $('#penyimpanganModal').find('.modal-body input[name="tanggal"]').val($('td', this).eq(3).text());
        checker.checked = false;
        submitbtn.disabled = true;
    });

    // when unchecked or checked, run the function
    checker.onchange = function() {
        if (this.checked) {
            submitbtn.disabled = false;
        } else {
            submitbtn.disabled = true;
        }
    }

    $('#submitBtn').on('click',function(){
            var id=$('#id').val();
            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/penyimpangan/submit') ?>",
                // dataType : "JSON",
                data : {id:id},
                success: function(result){
                    // result = JSON.parse(result)
                    // alert(result);

                    $('#penyimpanganModal').modal('hide');
                    $('#dt-lembur').DataTable().ajax.reload();
                    
                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Lembur telah diaktifkan."
                    }, {
                        type: "success",
                        timer: 2000,
                        placement: {
                        from: "top",
                        align: "center"
                        }
                    });
                },
                error: function(result){
                    $('#penyimpanganModal').modal('hide');
                    $.notify({
                            icon: "add_alert",
                            message: "<b>GAGAL!</b> Lembur tidak dapat diaktifkan."
                        }, {
                            type: "danger",
                            timer: 2000,
                            placement: {
                            from: "top",
                            align: "center"
                            }
                        });
                }
            });
            return false;
        });

});
</script>
