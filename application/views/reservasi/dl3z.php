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
              <h4 class="card-title">Rincian Perjalanan TA</h4>
            </div>
            <div class="card-body">
              <form class="form-horizontal" action="<?= base_url('reservasi/dl3z_proses'); ?>" method="post">
              <div class="row">
                                <label class="col-md-2 col-form-label">Jenis Perjalanan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="jperj" value="<?= $reservasi_temp['jenis_perjalanan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Berangkat</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="berangkat" name="berangkat" value="<?= date("d M Y", strtotime($reservasi_temp['tglberangkat'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamberangkat'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="kembali" name="kembali" value="<?= date("d M Y", strtotime($reservasi_temp['tglkembali'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamkembali'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-2 col-form-label">Tanggal Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="tglberangkat" name="tglberangkat" value="<?= date("d / m / Y", strtotime($reservasi_temp['tglberangkat'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-2 col-form-label">Jam Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="time" class="form-control disabled" id="jamberangkat" name="jamberangkat" value="<?= $reservasi_temp['jamberangkat']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-2 col-form-label">Tanggal Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="tglkembali" name="tglkembali" value="<?= date("d / m / Y", strtotime($reservasi_temp['tglkembali'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-2 col-form-label">Jam Kembali</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="time" class="form-control disabled" id="jamkembali" name="jamkembali" value="<?= $reservasi_temp['jamkembali']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tujuan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tujuan" value="<?= $reservasi_temp['tujuan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Keperluan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control disabled" name="keperluan"><?= $reservasi_temp['keperluan']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">COPRO</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="copro" value="<?= $reservasi_temp['copro']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Akomodasi</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="akomodasi" value="<?= $reservasi_temp['akomodasi']; ?>">
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($reservasi_temp['kendaraan'])){ ?>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Kendaraan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nopol" value="<?= $reservasi_temp['nopol'] . ' (' . $reservasi_temp['kendaraan'] . ')'; ?>">
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Penginapan/Hotel</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="penginapan" value="<?= $reservasi_temp['penginapan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Lama Menginap</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="menginap" value="<?= $reservasi_temp['lama_menginap']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Peserta Perjalanan</label>
                                <div class="col-md-8">
                                  <div class="toolbar">
                                  <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    <!-- <a href="#" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahPerjalanan">Tambah</a> -->
                                  </div>
                                  <div class="material-datatables">
                                    <table id="#" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                      <thead>
                                        <tr>
                                          <th>No</th>
                                          <th>Inisial</th>
                                          <th>Nama</th>
                                          <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                                        <?php
                                                              $no = 1; 
                                                              $peserta = $this->db->get_where('perjalanan_anggota', ['reservasi_id' => $reservasi_temp['id']])->result_array();
                                                              foreach ($peserta as $p) : ?>
                                                            <tr>
                                                                <td><?= $no; ?></td>
                                                                <td><?= $p['karyawan_inisial']; ?></td>
                                                                <td><?= $p['karyawan_nama']; ?></td>
                                                                <td class="text-right"><a href="<?= base_url('reservasi/hapuspeserta/') . $reservasi_temp['id'] . '/' . $p['karyawan_inisial']; ?>" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a></td>
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
                                <label class="col-md-2 col-form-label">Jadwal Perjalanan</label>
                                <div class="col-md-8">
                                  <div class="toolbar">
                                  <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    <!-- <a href="#" class="btn btn-facebook" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahPerjalanan">Tambah</a> -->
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
                                    <label class="col-md-2 col-form-label">PIC Perjalanan</label>
                                    <div class="col-md-3">
                                        <div class="form-group has-default">
                                            <select class="selectpicker" name="pic" data-style="select-with-transition" title="Pilih PIC" data-size="10" required>
                                                <?php
                                                $peserta = $this->db->get_where('perjalanan_anggota', ['reservasi_id' => $reservasi_temp['id']])->result_array();
                                                foreach ($peserta as $p) : ?>
                                                    <option value="<?= $p['karyawan_inisial']; ?>"><?= $p['karyawan_nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                    <div class="row">
                                <label class="col-md-2 col-form-label">Catatan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <textarea rows="3" class="form-control" name="catatan"><?= $reservasi_temp['catatan']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label"></label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <p class="mb-0">Perhatikan hal-hal berikut:</p>
                                        <p class="mb-0">1. Mengemudilah dengan aman dan gunakan selalu sabuk keselamatan.</p>
                                        <p class="mb-0">2. Jangan menaruh barang-barang di dashboard karena dapat mengganggu fungsi airbag.</p>
                                        <p class="mb-0">3. Jagalah kebersihan kendaraan, jangan tinggalkan sampah dan barang-barang lainnya.</p>
                                        <p class="mb-0">4. Hargai pengguna berikutnya. Kembalikan kendaraan dalam kondisi bersih dan rapih.</p>
                                        <p class="mb-0">5. Patuhi peraturan GA yang berlaku.
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="check" name="check" required>
                                            Ya, Saya setuju dengan ketentuan di atas dan siap dikenakan sanksi yang berlaku atas pelanggaran dan kelalaian yang saya lakukan.
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                    <?php
                                        $cekjadwal = $this->db->get_where('perjalanan_jadwal', ['reservasi_id' => $reservasi_temp['id']])->row_array();
                                        if (!empty($cekjadwal['reservasi_id'])){
                                            echo '<button type="submit" class="btn btn-fill btn-success" id="submit">RESERVASI</button>';
                                        }else{
                                            echo '<button type="submit" class="btn btn-fill btn-danger disabled" id="submit">JADWAL PERJALANAN TIDAK BOLEH KOSONG</button>';
                                        }
                                        ?>
                                        <a href="<?= base_url('reservasi/dl3b'); ?>" class="btn btn-link btn-default">Kembali</a>
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
                    <div class="card-header card-header-primary text-center">
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

            var checker = document.getElementById('check');
            var sendbtn = document.getElementById('submit');
            sendbtn.disabled = true;
            // when unchecked or checked, run the function
            checker.onchange = function() {
                if (this.checked) {
                    sendbtn.disabled = false;
                } else {
                    sendbtn.disabled = true;
                }
            }
        });
    </script>
