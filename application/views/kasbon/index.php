<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row mt-3">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">price_change</i>
            </div>
            <!-- <p class="card-category">Ijin Meninggalkan Pekerjaan</p> -->
            <h3 class="card-title">Kasbon</h3>
          </div>
          <div class="card-footer">
            <div class="stats"></div>
            <?php if ($access){
              echo '<a href="#" id="btn_add" class="btn btn-facebook btn-block" >Ajukan Kasbon</a>';
            }else{
              echo '<a href="#" id="btn_add" class="btn btn-danger btn-block disabled" >Ajukan Kasbon</a>';
            } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Pengajuan</h4>
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
                    <th>Tanggal</th>
                    <th>Kasbon <small>(Rp)</small></th>
                    <th>Keterangan</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th class="text-right">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Kasbon</th>
                    <th>Keterangan</th>
                    <th>Due Date</th>
                    <th>Status</th>
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
<div class="modal fade" id="tambahKasbon" tabindex="-1" role="dialog" aria-labelledby="tambahKasbonLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKasbonLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('kasbon/submit/add'); ?>">
                <div class="modal-body">
                    <!-- <input type="hidden" class="form-control" id="id" name="id">
                    <input type="hidden" class="form-control" id="npk" name="npk"> -->
                    <div class="row">
                      <div class="col-md-12" id="form_advance">
                          <div class="form-group">
                              <label class="bmd-label">Nominal*</label></br>
                              <input type="number" class="form-control" name="advance" id="advance" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label">Keterangan/Keperluan*</label></br>
                          <textarea class="form-control has-success" id="remarks" name="remarks" rows="3" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12" id="form_plan">
                          <div class="form-group">
                              <label class="bmd-label">Rencana Penyelesaian*</label></br>
                              <input type="text" class="form-control datepicker" name="settlement_date" id="settlement_date" required/>
                          </div>
                      </div>
                    </div>
                    <p>
                      <!-- <div class="col-md-12 ml-1">
                            <div id="accordion" role="tablist">
                              <div class="card card-collapse">
                                <div class="card-header" role="tab" id="headingPanduan">
                                  <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapsePanduan" aria-expanded="false" aria-controls="collapsePanduan">
                                      Syarat dan ketentuan cuti di RAISA:
                                      <i class="material-icons">keyboard_arrow_down</i>
                                    </a>
                                  </h5>
                                </div>
                                <div id="collapsePanduan" class="collapse show" role="tabpanel" aria-labelledby="headingPanduan" data-parent="#accordion">
                                  <div class="card-body">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                          <label class="bmd-label">1. Form di RAISA hanya menggantikan form fisik sebelumnya tanpa mengubah pola interaksi, tetap informasikan pengajuan cuti Anda kepada pimpinan-pimpinan Anda secara langsung.</label></br>
                                          <label class="bmd-label">2. Kondisi darurat adalah kondisi yang tidak diharapkan DAN terjadi secara mendadak seperti kecelakaan, meninggal dunia, bencana alam, kerusuhan, kebakaran, serangan jantung, dan anak/istri sakit (dibuktikan dengan surat dokter). Selain kondisi-kondisi tersebut maka dianggap bukan kondisi darurat walaupun tidak diharapkan.</label></br>
                                          <label class="bmd-label">3. Ajukan cuti maksimal H-1 pukul 21.00 kecuali dalam kondisi darurat tersebut di atas.</label></br>
                                          <label class="bmd-label">4. Karyawan tidak boleh melakukan cutinya sebelum disetujui oleh atasan 1 dan atasan 2.</label></br>
                                          <label class="bmd-label">5. Raisa tidak bertanggung jawab atas permohonan cuti yang tidak kunjung disetujui oleh pimpinan terkait, tetap lakukan komunikasi dengan pimpinan-pimpinan terkait.</label></br>
                                          <label class="bmd-label">6. Karyawan yang melakukan cuti sebelum pengajuan cutinya disetujui pihak terkait, maka dianggap mangkir dan konsekuensinya akan mengikuti aturan perusahaan.</label></br>
                                          <label class="bmd-label">7. Permohonan cuti yang tidak diapprove sampai hari H, maka sistem langsung melakukan autoreject dan akan mengikuti ketentuan poin no 5 dan 6.</label></br>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <p>
                            
                          </div> -->
                          <div class="form-check">
                              <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" id="check" name="check" value="1" required>
                                  *Saya setuju dengan ketentuan yang berlaku.
                                  <span class="form-check-sign">
                                      <span class="check"></span>
                                  </span>
                              </label>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <div class="row">
                          <div class="col-md-12 mr-1">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            <button type="button" id="btn-add" class="btn btn-success">AJUKAN</button>
                          </div>
                        </div>
                      </div>
              </form>
              
        </div>
    </div>
</div>

<div class="modal fade" id="cancelKasbon" tabindex="-1" role="dialog" aria-labelledby="cancelKasbonLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelKasbonLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('kasbon/submit/cancel'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="cl_id" name="cl_id">
                    <input type="hidden" class="form-control" id="cl_status" name="cl_status">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Kenapa mau dibatalkan? (Alasan)</small></label></br>
                              <textarea class="form-control has-success" id="cl_remarks" name="cl_remarks" rows="3" required="true"></textarea>
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
                            <button type="button" id="btn-cancel" class="btn btn-danger">BATALKAN</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- script ajax Kategori-->
<script type="text/javascript">
  $('#btn_add').on('click',function(){

      $('#tambahKasbon').modal("show");

  });
            
  $(document).ready(function(){
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
                  "url"   : "<?= site_url('kasbon/get_data/requestUser') ?>",
                  "type"  : "POST"
              },
          order: [],
          columns: [
              { "data": "id" },
              { "data": "advance_date" },
              { "data": "advance" },
              { "data": "remarks" },
              { "data": "settlement_date" },
              { "data": "status" },
              { "data": "action", className: "text-right" }
          ],
      });

      $('#btn-add').on('click',function(){
            $('#advance').prop('required', true);
            $('#remarks').prop('required', true);
            $('#settlement_date').prop('required', true);
            $.ajax({
                type : "POST",
                url  : "<?= site_url('kasbon/submit/add') ?>",
                dataType : "JSON",
                data : {advance:$('#advance').val(), remarks:$('#remarks').val(), settlement_date:$('#settlement_date').val()},
                success: function(result){

                    $('#tambahKasbon').modal('hide');
                    $('#dt-tables').DataTable().ajax.reload();

                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Kasbon telah diajukan."
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

                    $('#dt-tables').DataTable().ajax.reload();
                    $.notify({
                            icon: "add_alert",
                            message: "<b>GAGAL!</b> Pastikan semua data sudah dilengkapi."
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

        $('#tambahKasbon').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        });

        $('#btn-cancel').on('click',function(){
            $('#cl_id').prop('required', true);
            $('#cl_status').prop('required', true);
            $('#cl_remarks').prop('required', true);
            $.ajax({
                type : "POST",
                url  : "<?= site_url('kasbon/submit/cancel') ?>",
                dataType : "JSON",
                data : {id:$('#cl_id').val(), remarks:$('#cl_remarks').val(), status:$('#cl_status').val()},
                success: function(result){

                    $('#cancelKasbon').modal('hide');
                    $('#dt-tables').DataTable().ajax.reload();

                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Kasbon telah dihapus."
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

                    $('#dt-tables').DataTable().ajax.reload();
                    $.notify({
                            icon: "add_alert",
                            message: "<b>GAGAL!</b> Pastikan semua data sudah dilengkapi."
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

        $('#cancelKasbon').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
            modal.find('.modal-body input[name="cl_id"]').val(button.data('id'));
            modal.find('.modal-body input[name="cl_status"]').val(button.data('status'));
        });

        $('#cancelKasbon').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        });

        $('.advance').simpleMoneyFormat();


     <?php if ($this->session->flashdata('notify')=='success'){ ?>
       
      $.notify({
        icon: "add_alert",
        message: "<b>Berhasil!</b> Pastikan approval IMP kamu telah disetujui sebelum meninggalkan tempat kerja."
      }, {
        type: "success",
        timer: 3000,
        placement: {
          from: "top",
          align: "center"
        }
      });

     <?php }elseif ($this->session->flashdata('notify')=='cancel'){ ?>
      
      $.notify({
        icon: "add_alert",
        message: "<b>Oops!</b> IMP kamu telah dibatalkan."
      }, {
        type: "danger",
        timer: 3000,
        placement: {
          from: "top",
          align: "center"
        }
      });

     <?php }elseif ($this->session->flashdata('notify')=='over'){ ?>
      
      $.notify({
        icon: "add_alert",
        message: "<b>Maaf!</b> Kalo mau ngajuin harus sebelum IMP."
      }, {
        type: "danger",
        timer: 3000,
        placement: {
          from: "top",
          align: "center"
        }
      });

     <?php }elseif ($this->session->flashdata('notify')=='range'){ ?>
      
      $.notify({
        icon: "add_alert",
        message: "<b>Maaf!</b> Jam akhir harus lebih besar."
      }, {
        type: "danger",
        timer: 3000,
        placement: {
          from: "top",
          align: "center"
        }
      });

     <?php }elseif ($this->session->flashdata('notify')=='weekend'){ ?>
      
      $.notify({
        icon: "add_alert",
        message: "<b>Maaf!</b> This Weekend dude!."
      }, {
        type: "danger",
        timer: 3000,
        placement: {
          from: "top",
          align: "center"
        }
      });
     
      <?php } ?>

      $('#cancelImp').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(button.data('id'))
            modal.find('.modal-body input[name="cl_status"]').val(button.data('status'))
        })  

        var checker = document.getElementById('check');
        var submitbtn = document.getElementById('btn-add');
        submitbtn.disabled = true;
        // when unchecked or checked, run the function
        checker.onchange = function() {
            if (this.checked) {
                submitbtn.disabled = false;
            } else {
                submitbtn.disabled = true;
            }
        }
    });
    </script>