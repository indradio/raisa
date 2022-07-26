    <div class="content">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
        <div class="container-fluid">
        <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Presensi</h4>
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <button class="btn btn-success" role="button" aria-disabled="false" data-toggle="modal" data-target="#approveAll">
                      <span class="btn-label">
                        <i class="material-icons">done_all</i>
                      </span>
                      Approve All
                    <div class="ripple-container"></div></button>
                  </div>
                <div class="material-datatables">
                  <table id="dtpresensi" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Nama</th>
                          <th class="th-description">Date</th>
                          <th class="th-description">Time</th>
                          <th class="th-description">Flag</th>
                          <th class="th-description">Shift</th>
                          <th class="th-description">Catatan</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid-->
    </div>
    <!-- end content-->

<div class="modal fade" id="approveAll" tabindex="-1" role="dialog" aria-labelledby="approveAllTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
      <form class="form" id="formapproveAll" method="post" action="#">
          <div class="modal-body">
              <input type="hidden" class="form-control" id="id_all" name="id_all" value="all" />
              <h4 class="card-title text-center">Anda menyetujui semua absensi?</h4>
          </div>
          <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
              <button type="button" class="btn btn-success" id="btn_approve_all" >YA, SETUJU!</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="approveAbsen" tabindex="-1" role="dialog" aria-labelledby="approveAbsenTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
      <form class="form" id="formapproveAbsen" method="post" action="#">
          <div class="modal-body">
              <input type="hidden" class="form-control" id="id_approve" name="id_approve" />
              <h4 class="card-title text-center">Anda menyetujui absen ini?</h4>
          </div>
          <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
              <button type="button" class="btn btn-success" id="btn_approve" >YA, SETUJU!</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="rejectAbsen" tabindex="-1" role="dialog" aria-labelledby="rejectAbsenTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
      <form class="form" id="formrejectAbsen" method="post" action="#">
          <div class="modal-body">
              <input type="hidden" class="form-control" id="id_reject" name="id_reject" />
              <h4 class="card-title text-center">Anda tidak menyetujui absen ini?</h4>
          </div>
          <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
              <button type="button" class="btn btn-danger" id="btn_reject" >YA, TIDAK SETUJU!</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

    <script type="text/javascript">
      $(document).ready(function(){
        $('#dtpresensi').DataTable({
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
                    "url"   : "<?= site_url('presensi/get_data/persetujuan') ?>",
                    "type"  : "POST",
                    "data"  : {id:$('#id').val()}
                },
            columns: [
                { "data": "nama" },
                { "data": "date" },
                { "data": "time" },
                { "data": "flag" },
                { "data": "shift" },
                { "data": "catatan" },
                { "data": "action", className: "text-right" }
            ],
        });
        
        $('#approveAbsen').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id_approve"]').val(id)
        });

        $('#btn_approve').on('click',function(){
             $.ajax({
                  type : "POST",
                  url  : "<?= site_url('presensi/persetujuan/1/submit'); ?>",
                  data : {id:$('#id_approve').val()},
                  success: function(result){
                
                $.notify({
                      icon: "add_alert",
                      message: "<b>BERHASIL!</b> Aktivitas telah ditambahkan."
                  }, {
                        type: "success",
                        timer: 2000,
                        placement: {
                          from: "top",
                          align: "center"
                          }
                      });
                      
                    $('#approveAbsen').modal('hide');
                    $('#dtpresensi').DataTable().ajax.reload();
                },
                error: function(result){
                    $.notify({
                            icon: "add_alert",
                            message: "<b>GAGAL!</b> Data gagal tersimpan."
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

        $('#btn_approve_all').on('click',function(){
          $.ajax({
              type : "POST",
              url  : "<?= site_url('presensi/persetujuan/1/submit'); ?>",
              data : {id:$('#id_all').val()},
              success: function(result){
                $.notify({
                      icon: "add_alert",
                      message: "<b>BERHASIL!</b> Aktivitas telah ditambahkan."
                  }, {
                        type: "success",
                        timer: 2000,
                        placement: {
                          from: "top",
                          align: "center"
                          }
                      });
                      
                    $('#approveAll').modal('hide');
                    $('#dtpresensi').DataTable().ajax.reload();
                }, 
              error: function(result){
                  $.notify({
                      icon: "add_alert",
                      message: "<b>GAGAL!</b> Data gagal tersimpan."
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