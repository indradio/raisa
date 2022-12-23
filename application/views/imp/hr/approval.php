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
            <h4 class="card-title">Approval IMP</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
            
              <!--        Here you can write extra buttons/actions for the toolbar              -->
              
            </div>
            <div class="material-datatables">
              <table id="dt-imp" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Keterangan</th>
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
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalRsvTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-info text-center">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  <i class="material-icons">clear</i>
              </button>
              <h4 class="card-title">ALASAN PEMBATALAN</h4>
          </div>
        </div>
      <form class="form" method="post" action="<?= base_url('reservasi/batalrsv'); ?>">
          <div class="modal-body">
              <input type="hidden" class="form-control disabled" name="id" >
              <textarea rows="3" class="form-control" name="catatan" placeholder="Contoh : Tidak jadi berangkat" required></textarea>
          </div>
          <div class="modal-footer justify-content-right">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
              <button type="submit" class="btn btn-danger">BATALKAN!</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="approveImp" tabindex="-1" role="dialog" aria-labelledby="approveImpLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveImpLabel"></h5>
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
                              <input type="text" class="form-control" name="date" id="date" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Jam</small></label></br>
                              <input type="text" class="form-control" name="time" id="time" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Kategori</small></label></br>
                              <input type="text" class="form-control" name="category" id="category" disabled/>
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
                            <a href="#" class="btn btn-danger btn-link" data-toggle="modal" data-target="#rejectImp">REJECT</a>
                            <button type="button" class="btn btn-success" id="btn_approve" name="btn_approve">APPROVE</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectImp" tabindex="-1" role="dialog" aria-labelledby="rejectImpLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectImpLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('cuti/reject'); ?>">
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
                        <!-- <small></small> -->
                        <!-- <label class="col-md-5 col-form-label"></label> -->
                        <div class="col-md-12 mr-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            <button type="button" class="btn btn-danger" id="btn_reject" name="btn_reject">REJECT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

      $('#dt-imp').DataTable({
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
                    "url"   : "<?= site_url('imp/get_data/hr_approval') ?>",
                    "type"  : "POST"
                },
            order: [],
            columns: [
                { "data": "id" },
                { "data": "name" },
                { "data": "date" },
                { "data": "time" },
                { "data": "remarks" }
            ],
        });

      var table = $('#dt-imp').DataTable();
 
      $('#dt-imp tbody').on('click', 'tr', function () {
          var data = table.row(this).data();
          $.ajax({
              type : "POST",
              url  : "<?= site_url('imp/get_data/details') ?>",
              dataType : "JSON",
              data : {id:data['id']},
              success: function(result){
                $('#approveImp').on('show.bs.modal', function(event) {
                    var modal = $(this)
                    modal.find('.modal-body input[name="id"]').val(result['data']['id'])
                    modal.find('.modal-body input[name="name"]').val(result['data']['name'])
                    modal.find('.modal-body input[name="date"]').val(result['data']['date'])
                    modal.find('.modal-body input[name="time"]').val(result['data']['time'])
                    modal.find('.modal-body input[name="category"]').val(result['data']['category'])
                    modal.find('.modal-body textarea[name="remarks"]').val(result['data']['remarks'])
                });
                $('#approveImp').modal('show');
              }
          });

          $('#rejectImp').on('show.bs.modal', function(event) {
            $('#approveImp').modal('hide');
            $(this).find('form').trigger('reset');
            $(this).find('.modal-body input[name="id_reject"]').val(data['id'])
          });
        });
        
        $('#btn_approve').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('imp/hr_approval/approve') ?>",
                dataType : "JSON",
                data : {id:$('#id').val()},
                success: function(result){
                    $('#approveImp').modal('hide');
                    $('#dt-imp').DataTable().ajax.reload();

                    $.notify({
                        icon: "add_alert",
                        message: "<b>TERIMA KASIH!</b> IMP telah disetujui."
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

        $('#btn_reject').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('imp/hr_approval/reject') ?>",
                dataType : "JSON",
                data : {id:$('#id_reject').val(),reason:$('#reason').val()},
                success: function(result){
                    $('#rejectImp').modal('hide');
                    $('#dt-imp').DataTable().ajax.reload();

                    $.notify({
                        icon: "add_alert",
                        message: "<b>HUHU!</b> Anda tidak menyetujui IMP ini."
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