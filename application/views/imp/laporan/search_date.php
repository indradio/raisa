<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-text">
              <h4 class="card-title">IMP</h4>
              <p class="card-category">Laporan</p>
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <form class="form-horizontal" method="post" action="<?= base_url('imp/hr_report/search_date'); ?>">
                  <div class="row">
                      <label class="col-md-1 col-form-label">Dari</label>
                      <div class="col-md-2">
                          <div class="form-group has-default">
                              <input type="text" class="form-control datepicker" id="start" name="start" value="<?= date('d-m-Y', strtotime($periode['start'])); ?>">
                          </div>
                      </div>
                      <label class="col-md-1 col-form-label">Sampai</label>
                      <div class="col-md-2">
                          <div class="form-group has-default">
                              <input type="text" class="form-control datepicker" id="end" name="end" value="<?= date('d-m-Y', strtotime($periode['end'])); ?>">
                          </div>
                      </div>
                      <div class="col-md-1"></div>
                      <div class="col-md-1">
                          <button type="submit" id="btn-submit" class="btn btn-success"><i class="material-icons">search</i> Cari</a>
                      </div>
                  </div>
              </form>
            </div>
            <div class="material-datatables">
              <div class="table-responsive">
                <table id="dt-imp" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Kategori</th>
                      <th>Tanggal</th>
                      <th>Jam</th>
                      <th>NPK</th>
                      <th>Nama</th>
                      <th>Lama</th>
                      <th>Keterangan</th>
                      <th>Áction</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Tanggal</th>
                      <th>Jam</th>
                      <th>NPK</th>
                      <th>Nama</th>
                      <th>Kategori</th>
                      <th>Lama</th>
                      <th>Keterangan</th>
                      <th>Áction</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card-footer">
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

<script>
    $(document).ready(function(){
        $('#dt-imp').DataTable({
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
                    "url"   : "<?= site_url('imp/get_data/search_date') ?>",
                    "type"  : "POST",
                    // "dataType" : "JSON",
                    "data" : {start:$('#start').val(), end:$('#end').val()},
                },
            columns: [
                { "data": "id" },
                { "data": "category" },
                { "data": "date" },
                { "data": "time" },
                { "data": "npk" },
                { "data": "name" },
                { "data": "loss" },
                { "data": "remarks"},
                { "data": "action"}
            ],
        });

        // $('#btn-submit').on('click',function(){
          // $('#tglawal').val('10-12-2022');
          // $('#tglakhir').val('10-12-2022');
          // alert($('#tglawal').val());
            // $('#partNumber').prop('required', true);
            // $('#description').prop('required', true);
            // $('#material').prop('required', true);
            // $('#category').prop('required', true);
            // $('#code').prop('required', true);
            // $.ajax({
            //     type : "POST",
            //     url  : "<?= site_url('product/master/add') ?>",
            //     dataType : "JSON",
            //     data : {name:$('#add-product').val(), series:$('#add-series').val(), code:$('#add-code').val()},
            //     success: function(result){

            //         $('#addModal').modal('hide');
                    // $('#dt-presensi').DataTable().ajax.reload();

            //         $.notify("Product added successfully", "success");
            //     },
            //     error: function(result){
                    // $.notify({
                    //         icon: "add_alert",
                    //         message: "<b>GAGAL!</b> Data gagal tersimpan."
                    //     }, {
                    //         type: "danger",
                    //         timer: 2000,
                    //         placement: {
                    //         from: "top",
                    //         align: "center"
                    //         }
                    //     });
            //     }
            // });
            // return false;
        // });
    });
</script>