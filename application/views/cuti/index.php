<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">weekend</i>
            </div>
            <p class="card-category">Saldo</p>
            <h3 class="card-title"><?=$saldo_total; ?> hari</h3>
          </div>
          <div class="card-footer">
            <div class="stats"></div>
              <a href="#" id="btn_fcksunfish" class="btn btn-facebook btn-block">Ajukan Cuti</a>
              <!-- data-toggle="modal" data-target="#tambahCuti" -->
            </div>
            <div class="col-md-12">
              <div id="accordion" role="tablist">
              <div class="card card-collapse">
                <div class="card-header" role="tab" id="headingSaldo">
                  <h5 class="mb-0">
                    <a class="collapsed" data-toggle="collapse" href="#collapseSaldo" aria-expanded="false" aria-controls="collapseSaldo">
                      Details
                      <i class="material-icons">keyboard_arrow_down</i>
                    </a>
                  </h5>
                </div>
                <div id="collapseSaldo" class="collapse" role="tabpanel" aria-labelledby="headingSaldo" data-parent="#accordion">
                  <div class="card-body">
                    <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Kategori</th>
                          <th>Saldo</th>
                          <th>Masa Berlaku</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($saldo as $row) : 
                          $user = $this->db->get_where('karyawan', ['npk' => $row['npk']])->row_array(); ?>
                          <tr>
                            <td><?= $row['kategori']. ' </br><small>('.$row['id'].')</small>'; ?></td>
                            <td><?= $row['saldo']; ?></td>
                            <td><?= date('d M Y', strtotime($row['valid'])).'</br>',date('d M Y', strtotime($row['expired'])); ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
        </div>
      </div>
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
              <table id="dtdesc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Lama <small>(Hari)</small></th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th class="text-right">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No. Cuti</th>
                    <th>Tanggal</th>
                    <th>Lama</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th class="text-right">Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($cuti as $row) : 
                    $status = $this->db->get_where('cuti_status', ['id' => $row['status']])->row_array(); ?>
                    <tr>
                    <td><?= $row['kategori']. ' </br><small>('.$row['id'].')</small>'; ?></td>
                    <?php if ($row['lama']==1){ ?>
                        <td><?= date('d M Y', strtotime($row['tgl1'])); ?></td>
                      <?php }else{ ?>
                        <td><?= date('d M Y', strtotime($row['tgl1'])).' - '.date('d M Y', strtotime($row['tgl2'])); ?></td>
                    <?php } ?>
                      <td><?= $row['lama']; ?></td>
                      <td><?= $row['keterangan']; ?></td>
                      <td><?= $status['nama']; ?></td>
                      <td class="text-right">
                        <?php if ($row['status'] != '0' and $row['status'] != '9'): ?>
                          <a href="#" class="btn btn-link btn-danger btn-just-icon" role="button" aria-disabled="false" data-toggle="modal" data-target="#cancelCuti" data-id="<?= $row['id']; ?>"><i class="material-icons">close</i></a>
                          <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
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
<div class="modal fade" id="tambahCuti" tabindex="-1" role="dialog" aria-labelledby="tambahCutiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahCutiLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('cuti/add'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <input type="hidden" class="form-control" id="npk" name="npk">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Kategori*</label></br>
                                <select class="selectpicker" name="kategori" id="kategori" title="Pilih" data-style="select-with-transition" data-size="5" data-width="block" data-live-search="false" onchange="kategoriSelect(this);" required>
                                    <?php foreach ($saldo as $s) : ?>
                                        <option value="<?= $s['id']; ?>"><?= $s['kategori'].' ('.$s['saldo'].')'; ?></option>
                                    <?php endforeach; ?>
                                    <?php foreach ($kategori as $k) : ?>
                                        <option value="<?= $k['saldo_id']; ?>"><?= $k['kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                          </div>
                      </div>
                      <div class="col-md-12" id="catatan" style="display:none;">
                          <div class="form-group">
                              <label class="bmd-label text-danger">*Pastikan kamu sudah mengetahui ketentuan cuti DISPENSASI, Silahkan baca di Q&A</label></br>
                              <label class="bmd-label text-danger">*Jika membutuhkan waktu lebih lama, silahkan mengajukan cuti (Tahunan, Besar atau Tabungan) yang kamu miliki.</label></br>
                              <label class="bmd-label text-danger">*Harap menunjukan dokumen terkait sebagai bukti ke-HR</label></br>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Dari*</label></br>
                              <input type="text" class="form-control datepicker" name="tgl1" id="tgl1" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Sampai*</label></br>
                              <input type="text" class="form-control datepicker" name="tgl2" id="tgl2" required/>
                          </div>
                      </div>
                      <div class="col-md-12" id="">
                          <div class="form-group">
                              <label class="bmd-label"><mark>*Jika diantara Cuti kamu terdapat <b>Hari Libur (Weekend/Nasional)</b>, Harap dibuat menjadi beberapa pengajuan cuti hanya di hari kerja sesuai CoE.</mark></label></br>
                          </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label">Keterangan*</label></br>
                          <textarea class="form-control has-success" id="keterangan" name="keterangan" rows="3" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="togglebutton">
                            <label>
                              <input type="checkbox" id="darurat" name="darurat" value="1">
                                <span class="toggle"></span>
                                  Darurat?
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <p>
                      <div class="col-md-12 ml-1">
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
                      </div>
                      <div class="modal-footer">
                        <div class="row">
                          <div class="col-md-12">
                            
                          </div>
                          <div class="col-md-12 mr-1">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            <button type="submit" id="submit" class="btn btn-success">AJUKAN</button>
                          </div>
                        </div>
                      </div>
              </form>
              
        </div>
    </div>
</div>

<div class="modal fade" id="cancelCuti" tabindex="-1" role="dialog" aria-labelledby="cancelCutiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelCutiLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('cuti/cancel'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Kenapa mau dibatalkan? (Alasan)</small></label></br>
                              <textarea class="form-control has-success" id="keterangan" name="keterangan" rows="3" required="true"></textarea>
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
  $('#btn_tambahCuti').on('click',function(){
    
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
        $('#tambahCuti').modal("show");
      }
    });

    }else{

      $('#tambahCuti').modal("show");

    }
  });

  $('#btn_fcksunfish').on('click',function(){

    Swal.fire({
      title: 'Perhatian!',
      icon: 'warning',
      html:
      'Mulai tanggal 30 Juli 2024, fitur CUTI sudah beralih menggunakan sunfish.',
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
        
      }
    });

  });

        function kategoriSelect(valueSelect)
            {
                var kategori = valueSelect.options[valueSelect.selectedIndex].value;
                var x = document.getElementById("catatan");
                if(kategori === "KED" || kategori === "NIK" || kategori === "MEL" || kategori === "KEG" || kategori === "KHI" || kategori === "WIS" || kategori === "UMR" || kategori === "HAJ" || kategori === "PEN" || kategori === "DLL"){
                  x.style.display = "block";
                }else{
                  x.style.display = "none";
                }
               
            }   
            
    $(document).ready(function(){
     <?php if ($this->session->flashdata('notify')=='success'){ ?>
       
      $.notify({
        icon: "add_alert",
        message: "<b>Berhasil!</b> Pastikan saat kamu cuti tidak ada deadline/janji di tanggal tersebut ya."
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
        message: "<b>Oops!</b> Cuti kamu telah dibatalkan."
      }, {
        type: "danger",
        timer: 3000,
        placement: {
          from: "top",
          align: "center"
        }
      });

     <?php }elseif ($this->session->flashdata('notify')=='overquota'){ ?>
      
      $.notify({
        icon: "add_alert",
        message: "<b>Maaf!</b> Saldo cuti kamu tidak cukup."
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
        message: "<b>Maaf!</b> Tanggal akhir harus lebih besar."
      }, {
        type: "danger",
        timer: 3000,
        placement: {
          from: "top",
          align: "center"
        }
      });

     <?php }elseif ($this->session->flashdata('notify')=='late'){ ?>
      
      $.notify({
        icon: "add_alert",
        message: "<b>Maaf!</b> Kalo mau ngajuin cuti jangan dadakan ya! apalagi udah lewat tanggalnya."
      }, {
        type: "danger",
        timer: 3000,
        placement: {
          from: "top",
          align: "center"
        }
      });

     <?php }elseif ($this->session->flashdata('notify')=='saldolate'){ ?>
      
      $.notify({
        icon: "add_alert",
        message: "<b>Maaf!</b> Masa berlaku saldo kamu sudah lewat."
      }, {
        type: "danger",
        timer: 3000,
        placement: {
          from: "top",
          align: "center"
        }
      });

     <?php }elseif ($this->session->flashdata('notify')=='exist'){ ?>
      
      $.notify({
        icon: "add_alert",
        message: "<b>Maaf!</b> Kamu sudah mengajukan cuti di tanggal ini."
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
        message: "<b>Maaf!</b> Kamu gak perlu repot2 ngajuin cuti di hari libur (sabtu & minggu)."
      }, {
        type: "danger",
        timer: 3000,
        placement: {
          from: "top",
          align: "center"
        }
      });
     
      <?php } ?>

      $('#cancelCuti').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
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