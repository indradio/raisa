  <?php 
  if ($reservasi_temp['id']==null)
  {
    redirect('reservasi/dl');
  }
  ?>
  <div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
      <!-- Start Card -->
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-rose card-header-icon">
              <div class="card-icon">
                <i class="material-icons">directions_car</i>
              </div>
              <h4 class="card-title">Jadwal Perjalanan TA</h4>
            </div>
            <div class="card-body">
              <form class="form-horizontal" action="<?= base_url('reservasi/dl3z_proses'); ?>" method="post">
               
                            <div class="row">
                                <label class="col-md-2 col-form-label">Jadwal Perjalanan</label>
                                <div class="col-md-9">
                                  <div class="toolbar">
                                  <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    <a href="#" class="btn btn-facebook" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahPerjalanan">Tambah</a>
                                  </div>
                                  <div class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                      <thead>
                                        <tr>
                                          <th>No</th>
                                          <th>Waktu</th>
                                          <th>Berangkat Dari</th>
                                          <th>Tempat Tujuan</th>
                                          <th>Transportasi</th>
                                          <th>Keterangan</th>
                                          <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                      </thead>
                                      <tfoot>
                                        <tr>
                                          <th>No</th>
                                          <th>Waktu</th>
                                          <th>Berangkat Dari</th>
                                          <th>Tempat Tujuan</th>
                                          <th>Transportasi</th>
                                          <th>Keterangan</th>
                                          <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                      </tfoot>
                                      <tbody>
                                      <?php
                                                              $no = 1; 
                                                              $jadwal = $this->db->get_where('perjalanan_jadwal', ['reservasi_id' => $reservasi_temp['id']])->result_array();
                                                              foreach ($jadwal as $j) : ?>
                                                            <tr>
                                                                <td><?= $no; ?></td>
                                                                <td><?= date("d-m-Y H:i", strtotime($j['waktu'])); ?></td>
                                                                <td><?= $j['berangkat']; ?></td>
                                                                <td><?= $j['tujuan']; ?></td>
                                                                <td><?= $j['transportasi']; ?></td>
                                                                <td><?= $j['keterangan']; ?></td>
                                                                <td class="text-right"><a href="<?= base_url('reservasi/hapusjadwal/') . $j['id']; ?>" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a></td>
                                                            </tr>
                                                        <?php 
                                                              $no++;
                                                              endforeach; ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <div class="form-group has-default">
                                    <?php
                                        $cekjadwal = $this->db->get_where('perjalanan_jadwal', ['reservasi_id' => $reservasi_temp['id']])->row_array();
                                        if (!empty($cekjadwal['reservasi_id'])){
                                            echo '<a href="'.base_url('reservasi/dl3z').'"  class="btn btn-fill btn-success" id="submit">SELANJUTNYA</a>';
                                        }else{
                                            echo '<button type="submit" class="btn btn-fill btn-danger disabled" id="submit">JADWAL PERJALANAN TIDAK BOLEH KOSONG</button>';
                                        }
                                        ?>
                                        <a href="<?= base_url('reservasi/dl3a'); ?>" class="btn btn-link btn-default">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </form>
          </div>
        </div>
      </div>
      <!-- End Row -->
    </div>
  </div>
  </div>
  <!-- Modal Tambah Perjalanan-->
  <div class="modal fade" id="tambahPerjalanan" tabindex="-1" role="dialog" aria-labelledby="tambahPerjalananTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">JADWAL PERJALANAN</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('reservasi/tambahjadwal'); ?>">
                    <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">RSV ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id" value="<?= $reservasi_temp['id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <label class="col-md-4 col-form-label">Waktu Keberangkatan*</label>
                          <div class="col-md-7">
                            <div class="form-group has-default">
                              <input type="text" class="form-control datetimepicker" id="waktu" name="waktu" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Berangkat Dari*</label>
                            <div class="col-md-7">
                              <div class="form-group has-default">
                                <input type="text" class="form-control" id="berangkat" name="berangkat" required>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Tempat Tujuan*</label>
                            <div class="col-md-7">
                              <div class="form-group has-default">
                                <input type="text" class="form-control" id="tujuan" name="tujuan" required>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Transportasi*</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select onchange="transportasiSelect(this);" class="selectpicker" name="transportasi" id="transportasi" title="Pilih" data-style="select-with-transition" data-size="5" data-width="fit" data-live-search="false" >
                                      <option value="Operasional">Operasional</option>
                                      <option value="Taksi">Taksi</option>
                                      <option value="Pribadi">Kendaraan Pribadi</option>
                                      <option value="Pesawat">Pesawat</option>
                                      <option value="Kereta Api">Kereta Api</option>
                                      <option value="Travel">Travel</option>
                                      <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label" id="lblTransportasi" style="display:none;"></label>
                            <div class="col-md-7" id="txtTransportasi" style="display:none;">
                              <div class="form-group has-default">
                                <input type="text" class="form-control" id="transportasi_lain" name="transportasi_lain">
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Keterangan</label>
                            <div class="col-md-7">
                              <div class="form-group has-default">
                              <textarea rows="2" class="form-control" name="keterangan"></textarea>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                      <button type="submit" class="btn btn-success">SIMPAN</button>
                        <br>
                      <button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
  <script>
    function transportasiSelect(nameSelect)
    {
        var val = nameSelect.options[nameSelect.selectedIndex].value;
        document.getElementById("lblTransportasi").style.display = val == 'Lainnya' ? "block" : 'none';
        document.getElementById("txtTransportasi").style.display = val == 'Lainnya' ? "block" : 'none';
    }

    $(document).ready(function() {
            $('#transportasi').change(function() {
                var Transportasi = $('#transportasi').val();
                if (Transportasi == 'Lainnya') {
                    $('#transportasi_lain').prop('disabled', false);
                    $('#transportasi_lain').prop('required', true);
                } else {
                    $('#transportasi_lain').prop('disabled', true);
                    $('#transportasi_lain').prop('required', false);
                }
            });
        });
    </script>