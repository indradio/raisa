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
            <h4 class="card-title">Approval Kasbon</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
            
              <!--        Here you can write extra buttons/actions for the toolbar              -->
              
            </div>
            <div class="material-datatables">
              <table id="dt-tables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Kasbon</th>
                    <th>Keperluan</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Kasbon</th>
                    <th>Keperluan</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <!-- end card body-->
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

<!-- Modal -->
<div class="modal fade" id="approveKasbon" tabindex="-1" role="dialog" aria-labelledby="approveKasbonLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveKasbonLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Nama</small></label></br>
                              <input type="text" class="form-control" name="name" id="name" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Tanggal</small></label></br>
                              <input type="text" class="form-control" name="advance_date" id="advance_date" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Kasbon</small></label></br>
                              <input type="text" class="form-control" name="advance" id="advance" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating"><small>Keterangan</small></label></br>
                          <textarea class="form-control has-success" id="remarks" name="remarks" rows="3" disabled></textarea>
                        </div>
                      </div>
                    </div>
                    <p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <!-- <small></small> -->
                        <!-- <label class="col-md-5 col-form-label"></label> -->
                        <div class="col-md-12 mr-4">
                            <a href="#" class="btn btn-danger btn-link" data-toggle="modal" data-target="#rejectKasbon">REJECT</a>
                            <button type="button" class="btn btn-success" id="btn-approve" name="btn-approve">APPROVE</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectKasbon" tabindex="-1" role="dialog" aria-labelledby="rejectKasbonLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectKasbonLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="#">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id_reject" name="id_reject">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Alasan</small></label></br>
                              <textarea class="form-control has-success" id="reason" name="reason" rows="3" required="true"></textarea>
                          </div>
                      </div>
                    </div>
                    <p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12 mr-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            <button type="button" class="btn btn-danger" id="btn-reject" name="btn-reject">REJECT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

      $('#dt-tables').DataTable({
            pagingType: "full_numbers",
            scrollX: true,
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            ajax: {
                    "url"   : "<?= site_url('kasbon/get_data/approval_div') ?>",
                    "type"  : "POST"
                },
            order: [],
            columns: [
                { "data": "id" },
                { "data": "name" },
                { "data": "advance_date" },
                { "data": "advance" },
                { "data": "remarks" }
            ],
        });

      var table = $('#dt-tables').DataTable();
 
      $('#dt-tables tbody').on('click', 'tr', function () {
          var data = table.row(this).data();
          $.ajax({
              type : "POST",
              url  : "<?= site_url('kasbon/get_data/approvalView') ?>",
              dataType : "JSON",
              data : {id:data['id']},
              success: function(result){
                $('#approveKasbon').on('show.bs.modal', function(event) {
                    var modal = $(this)
                    modal.find('.modal-body input[name="id"]').val(result['data']['id'])
                    modal.find('.modal-body input[name="name"]').val(result['data']['name'])
                    modal.find('.modal-body input[name="advance_date"]').val(result['data']['advance_date'])
                    modal.find('.modal-body input[name="advance"]').val(result['data']['advance'])
                    modal.find('.modal-body textarea[name="remarks"]').val(result['data']['remarks'])
                });
                $('#approveKasbon').modal('show');
              }
          });

          $('#rejectKasbon').on('show.bs.modal', function(event) {
            $('#approveKasbon').modal('hide');
            $(this).find('form').trigger('reset');
            $(this).find('.modal-body input[name="id_reject"]').val(data['id'])
          });
        });
        
        $('#btn-approve').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('kasbon/approval/approve_div') ?>",
                dataType : "JSON",
                data : {id:$('#id').val()},
                success: function(result){
                    $('#approveKasbon').modal('hide');
                    $('#dt-tables').DataTable().ajax.reload();

                    $.notify({
                        icon: "add_alert",
                        message: "<b>TERIMA KASIH!</b> Kasbon telah disetujui."
                    }, {
                        type: "success",
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

        $('#btn-reject').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('kasbon/approval/reject_div') ?>",
                dataType : "JSON",
                data : {id:$('#id_reject').val(),reason:$('#reason').val()},
                success: function(result){
                    $('#rejectKasbon').modal('hide');
                    $('#dt-tables').DataTable().ajax.reload();

                    $.notify({
                        icon: "add_alert",
                        message: "<b>HUHU!</b> Anda tidak menyetujui Kasbon ini."
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