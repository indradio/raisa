<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">event</i>
            </div>
            <p class="card-category">Saldo Aktif</p>
            <!-- <h3 class="card-title"><?=$total; ?> hari</h3> -->
          </div>
          <div class="card-footer">
            <div class="stats"></div>
              <a href="#" class="btn btn-facebook btn-block" data-toggle="modal" data-target="#addEvent">Tambah</a>
            </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">weekend</i>
            </div>
            <p class="card-category"></p>
            <h3 class="card-title"></h3>
          </div>
          <div class="card-footer">
            <div class="stats"></div>
              <a href="#" class="btn btn-linkedin btn-block" role="button" aria-disabled="false" data-toggle="modal" data-target="#importCuti">Import</a>
            </div>
        </div>
      </div>
    </div>
    <div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">event</i>
            </div>
            <h4 class="card-title">Events</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
            
              <!--        Here you can write extra buttons/actions for the toolbar              -->
              <form class="form-horizontal" action="<?= base_url('calendar/events'); ?>" method="post">
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="year" id="year" data-style="select-with-transition" title="Pilih Tahun" data-size="7" onchange='this.form.submit()' required>
                                        <?php for ($y = date('Y')-1; $y <= date('Y')+1; $y++) { ?>
                                            <option value="<?= $y; ?>" <?php echo ($year == $y) ? 'selected' : ''; ?>><?= $y; ?></option>
                                        <?php };?>
                                        </select>
                                    </div>
                                </div>
                        </form>
              
            </div>
            <div class="material-datatables">
              <table id="dt-events" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Event</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th class="text-right">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Event</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th class="text-right">Action</th>
                  </tr>
                </tfoot>
                <tbody>
                </tbody>
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
<div class="modal fade" id="addEvent" tabindex="-1" role="dialog" aria-labelledby="addEventLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="card card-signup card-plain">
                <form class="form" method="post" id="formAddEvent" action="#">
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Judul</small></label></br>
                              <input type="text" class="form-control" name="title" id="title" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                            <label class="bmd-label-floating"><small>Keterangan</small></label></br>
                              <textarea class="form-control has-success" name="description" id="description" rows="3" required></textarea>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                          <label class="bmd-label-floating"><small>Kategori</small></label></br>
                                <select class="selectpicker" name="category" id="category" title="Pilih" data-style="select-with-transition" data-size="5" data-width="block" data-live-search="false" required>
                                        <option value="NASIONAL">LIBUR NASIONAL</option>
                                        <option value="KEAGAMAAN">LIBUR KEAGAMAAN</option>
                                        <option value="MASSAL">LIBUR CUTI MASAL</option>
                                        <option value="INTERNAL">ACARA INTERNAL</option>
                                </select>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                            <label class="bmd-label-floating"><small>Mulai</small></label></br>
                              <input type="text" class="form-control datepicker" name="start" id="start" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                            <label class="bmd-label-floating"><small>Selesai</small></label></br>
                              <input type="text" class="form-control datepicker" name="end" id="end" required/>
                          </div>
                      </div>                      
                    </div>
                    <p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                      <div class="col-md-12 mr-4">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
                          <button type="button" class="btn btn-success" id="btn_save" >SUBMIT</button>
                      </div>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importCuti" tabindex="-1" role="dialog" aria-labelledby="importCutiTitle" aria-hidden="true">
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
                <?= form_open_multipart('cuti/hr_saldo/import'); ?>
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="file" name="data" id="data" class="inputFileVisible" placeholder="Single File">
                        </div>
                        <div class="modal-footer">
                          <a href="<?= base_url('assets/temp_excel/template_upload_saldo_cuti.xlsx'); ?>" class="btn btn-linkedin btn-link" role="button" aria-disabled="false">DOWNLOAD TEMPLATE</a>
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

<div class="modal fade" id="editCuti" tabindex="-1" role="dialog" aria-labelledby="editCutiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="card card-signup card-plain">
                <form class="form" id="rormEditCuti" method="post" action="<?= base_url('cuti/hr_saldo/edit'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <input type="hidden" class="form-control" id="npk" name="npk">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Berlaku Mulai*</label></br>
                              <input type="text" class="form-control datepicker" name="valid" id="valid" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Berlaku Sampai*</label></br>
                              <input type="text" class="form-control datepicker" name="expired" id="expired" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Saldo*</label></br>
                              <input type="number" class="form-control" name="saldo" id="saldo" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Keterangan*</label></br>
                              <textarea class="form-control has-success" id="keterangan" name="keterangan" rows="3" required></textarea>
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
                            <button type="submit" class="btn btn-success">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteEvent" tabindex="-1" role="dialog" aria-labelledby="deleteEventTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
      <form class="form" id="formDeleteEvent" method="post" action="#">
          <div class="modal-body">
              <input type="hidden" class="form-control" id="iddel" name="iddel" />
              <h4 class="card-title text-center">Yakin ingin membatalkan Event ini?</h4>
          </div>
          <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
              <button type="button" class="btn btn-danger" id="btn_delete" >YA, BATALKAN!</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    setFormValidation('#formAddEvent');
    setFormValidation('#formDeleteEvent');
    $('#dt-events').DataTable({
            "pagingType": "full_numbers",
            scrollX: true,
            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'excelHtml5',
                    text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i>',
                    
                    footer: true
                },
                {
                    extend: 'pdfHtml5',
                    text:'<i class="fa fa-file-pdf-o" aria-hidden="true" ></i>',
                    
                    orientation: 'landscape',
                    pageSize: 'A3',
                    download: 'open',
                    footer: true
                }
            ],
            scrollCollapse: true,
            order: [], //Initial no order.
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            ajax: {
                    "url"   : "<?= site_url('calendar/GET_EVENTS_BY_YEAR') ?>",
                    "type"  : "POST",
                    "data"  : {year:$('#year').selectpicker('val')}
                },
            columns: [
                { "data": "title" },
                { "data": "description" },
                { "data": "date" },
                { "data": "category" },
                { "data": "action" }
            ],
        });

    $('#btn_save').on('click',function(){
      var title=$('#title').val();
      var description=$('#description').val();
      var category=$('#category').val();
      var start=$('#start').val();
      var end=$('#end').val();
      $.ajax({
          type : "POST",
          url  : "<?= site_url('calendar/events/add') ?>",
          // dataType : "JSON",
          data : {title:title, description:description, category:category, start:start, end:end},
          success: function(result){
              // result = JSON.parse(result)
              // alert(result);

              $('#addEvent').modal('hide');
              $('#dt-events').DataTable().ajax.reload();
              
              $.notify({
                  icon: "add_alert",
                  message: "<b>BERHASIL!</b> Data telah tersimpan."
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

    $('#deleteEvent').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body input[name="iddel"]').val(id)
    });

    $('#btn_delete').on('click',function(){
      var id=$('#id').val();
      $.ajax({
          type : "POST",
          url  : "<?= site_url('calendar/events/delete') ?>",
          // dataType : "JSON",
          data : {id:$('#iddel').val()},
          success: function(result){
              // result = JSON.parse(result)
              // alert(result);

              $('#deleteEvent').modal('hide');
              $('#dt-events').DataTable().ajax.reload();
              
              $.notify({
                  icon: "add_alert",
                  message: "<b>BERHASIL!</b> Data telah tersimpan."
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

    // $('#editCuti').on('show.bs.modal', function(event) {
    //     var button = $(event.relatedTarget)
    //     var id = button.data('id')
    //     var valid = button.data('valid')
    //     var expired = button.data('expired')
    //     var saldo = button.data('saldo')
    //     var keterangan = button.data('keterangan')
    //     var modal = $(this)
    //     modal.find('.modal-body input[name="id"]').val(id)
    //     modal.find('.modal-body input[name="valid"]').val(valid)
    //     modal.find('.modal-body input[name="expired"]').val(expired)
    //     modal.find('.modal-body input[name="saldo"]').val(saldo)
    //     modal.find('.modal-body textarea[name="keterangan"]').val(keterangan)
    // });
});
</script>