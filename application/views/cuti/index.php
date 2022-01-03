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
              <a href="#" class="btn btn-facebook btn-block" data-toggle="modal" data-target="#tambahCuti">Ajukan Cuti</a>
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
                      <td><?= date('d M Y', strtotime($row['tgl1'])); ?></td>
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
                              <label class="bmd-label"><mark>*Pengajuan cuti paling lambat <b>H-1 pukul 21:00</b>.</mark></label></br>
                              <label class="bmd-label"><mark>*Jika diantara cuti kamu terdapat <b>Hari Libur Nasional</b> di hari kerja, Harap dibuat menjadi 2x pengajuan cuti.</mark></label></br>
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
                      <div class="col-md-12 mr-1">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn btn-success">AJUKAN</button>
                      </div>
                    </div>
                </div>
              </form>
              <!-- <div class="col-md-12 ml-1">
                <div id="accordion" role="tablist">
                  <div class="card card-collapse">
                    <div class="card-header" role="tab" id="headingPanduan">
                      <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapsePanduan" aria-expanded="false" aria-controls="collapsePanduan">
                          Panduan
                          <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                      </h5>
                    </div>
                    <div id="collapsePanduan" class="collapse" role="tabpanel" aria-labelledby="headingPanduan" data-parent="#accordion">
                      <div class="card-body">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
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
     
      <?php } ?>

      $('#cancelCuti').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        })  
    });
    </script>