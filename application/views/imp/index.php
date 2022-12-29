<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row mt-3">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">directions_run</i>
            </div>
            <p class="card-category">Ijin Meninggalkan Pekerjaan</p>
            <h3 class="card-title">IMP</h3>
          </div>
          <div class="card-footer">
            <div class="stats"></div>
            <a href="#" id="btn_add" class="btn btn-facebook btn-block" >Ajukan IMP</a>
            <!-- data-toggle="modal" data-target="#tambahCuti" -->
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
            <h4 class="card-title">Riwayat</h4>
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
                    <th>Tanggal</th>
                    <th>Lama <small>(Jam)</small></th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th class="text-right">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Lama</th>
                    <th>Keterangan</th>
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
<div class="modal fade" id="tambahIMP" tabindex="-1" role="dialog" aria-labelledby="tambahIMPLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahIMPLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('imp/submit/add'); ?>">
                <div class="modal-body">
                    <!-- <input type="hidden" class="form-control" id="id" name="id">
                    <input type="hidden" class="form-control" id="npk" name="npk"> -->
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Kategori*</label></br>
                                <select class="selectpicker" name="category" id="category" title="Pilih" data-style="select-with-transition" data-size="5" data-width="block" data-live-search="false" onchange="categorySelect(this);" required>
                                    <?php foreach ($kategori as $row) : ?>
                                        <option value="<?= $row->kategori; ?>"><?= $row->deskripsi; ?></option>
                                    <?php endforeach; ?>
                                </select>
                          </div>
                      </div>
                      <!-- <div class="col-md-12" id="">
                          <div class="form-group">
                              <label class="bmd-label"><mark>*Jika diantara Cuti kamu terdapat <b>Hari Libur Nasional</b> di hari kerja, Harap dibuat menjadi 2x pengajuan cuti.</mark></label></br>
                          </div>
                      </div> -->
                      <div class="col-md-12" id="form_date">
                          <div class="form-group">
                              <label class="bmd-label">Tanggal*</label></br>
                              <input type="text" class="form-control datepicker" name="date" id="date" required/>
                          </div>
                      </div>
                      <div class="col-md-6" id="form_start" style="display:none;">
                          <div class="form-group">
                              <label class="bmd-label">Keluar/Mulai*</label></br>
                              <input type="text" class="form-control timepicker" name="start_time" id="start_time" required/>
                          </div>
                      </div>
                      <div class="col-md-6 ml-auto" id="form_end" style="display:none;">
                          <div class="form-group">
                              <label class="bmd-label">Masuk/Sampai*</label></br>
                              <input type="text" class="form-control timepicker" name="end_time" id="end_time" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label">Keterangan/Alasan*</label></br>
                          <textarea class="form-control has-success" id="remarks" name="remarks" rows="3" required></textarea>
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
                                  Ya, Saya setuju dengan ketentuan di atas.
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
                            <button type="submit" id="submit" class="btn btn-success">AJUKAN IMP</button>
                          </div>
                        </div>
                      </div>
              </form>
              
        </div>
    </div>
</div>

<div class="modal fade" id="cancelImp" tabindex="-1" role="dialog" aria-labelledby="cancelImpLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelImpLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('imp/submit/cancel'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
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
                            <button type="submit" class="btn btn-danger">BATALKAN</button>
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
    
    var now_d = '<?= date('D') ?>';
    let now_t = <?= strtotime(date('H:i:s')) ?>;
    let min_t = <?= strtotime(date('07:30:00')) ?>;
    let max_t = <?= strtotime(date('16:30:00')) ?>;

    if (now_d == 'Sat' || now_d == 'Sun' || now_t < min_t || now_t > max_t) {

    Swal.fire({
      title: 'Perhatian!',
      icon: 'warning',
      html:
      'Kamu mengajukan permohonan di luar jam kerja, untuk itu harap kontak langsung pimpinan-pimpinan kamu dan pihak yang berkepentingan untuk merelease permohonan kamu.</p> ' +
      'Sudah mengajukan di RAISA tidak berarti menyerahkan tanggung jawab kamu ke RAISA, RAISA tidak bertanggung jawab atas permohonan kamu yang tidak kunjung disetujui, kamu tetap harus proaktif.',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ya, Saya Mengerti',
      showClass: {
        popup: 'animate__animated animate__heartBeat'
      },
      hideClass: {
        popup: 'animate__animated animate__fadeOut'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        $('#tambahIMP').modal("show");
      }
    });

    }else{

      $('#tambahIMP').modal("show");

    }
  });

        function categorySelect(valueSelect)
            {
                var kategori = valueSelect.options[valueSelect.selectedIndex].value;
                var start = document.getElementById("form_start");
                var end = document.getElementById("form_end");
                var start_time = document.getElementById("start_time");
                var end_time = document.getElementById("end_time");
                if(kategori === "IMP2"){
                  start.style.display = "none";
                  start_time.value = "07:30"
                  end.style.display = "block";
                }else if(kategori === "IMP3"){
                  start.style.display = "block";
                  end.style.display = "none";
                  end_time.value = "16:30"
                }else{
                  start.style.display = "block";
                  end.style.display = "block";
                }
               
            }   
            
    $(document).ready(function(){
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
                    "url"   : "<?= site_url('imp/get_data/index') ?>",
                    "type"  : "POST"
                },
            order: [],
            columns: [
                { "data": "id" },
                { "data": "date" },
                { "data": "time" },
                { "data": "remarks" },
                { "data": "status" },
                { "data": "action", className: "text-right" }
            ],
        });

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
sssssssssw
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
        var submitbtn = document.getElementById('submit');
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