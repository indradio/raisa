<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
  <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Pertanyaan Seputar Cuti</h4>
                </div>
                <div class="card-body">
                  <div id="accordion" role="tablist">
                    <div class="card-collapse">
                      <div class="card-header" role="tab" id="headingOne">
                        <h5 class="mb-0">
                          <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="collapsed">
                            <b>Apa saja Jenis Ijin Khusus (DISPENSASI)?</b>
                            <i class="material-icons">keyboard_arrow_down</i>
                          </a>
                        </h5>
                      </div>
                      <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                        <div class="card-body">
                          <div class="table-responsive">
                            <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Alasan</th>
                                  <th>Lama</th>
                                </tr>
                              </thead>
                              <tfoot>
                                <tr>
                                  <th>No</th>
                                  <th>Alasan</th>
                                  <th>Lama</th>
                                </tr>
                              </tfoot>
                              <tbody>
                                <tr>
                                  <td>1</td>
                                  <td>Karyawan sendiri melangsungkan pernikahan</td>
                                  <td>3 (tiga) hari</td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td>Anak karyawan melangsungkan pernikahan</td>
                                  <td>2 (dua) hari</td>
                                  </tr>
                                <tr>
                                  <td>3</td>
                                  <td>Saudara sekandung karyawan melangsungkan pernikahan (dengan melampirkan kartu undangan & kartu keluarga)</td>
                                  <td>1 (satu) hari</td>
                                  </tr>
                                <tr>
                                  <td>4</td>
                                  <td>Kematian keluarga karyawan, orang tua, mertua, menantu</td>
                                  <td>2 (dua) hari</td>
                                  </tr>
                                <tr>
                                  <td>5</td>
                                  <td>Kematian kakek-nenek kandung / mertua, cucu, saudara kandung / ipar atau anggota keluarga dalam satu rumah</td>
                                  <td>1 (satu) hari</td>
                                  </tr>
                                <tr>
                                  <td>6</td>
                                  <td>Khitanan / pembaptisan anak karyawan</td>
                                  <td>2 (dua) hari</td>
                                  </tr>
                                <tr>
                                  <td>7</td>
                                  <td>Istri sah karyawan melahirkan / keguguran</td>
                                  <td>2 (dua) hari</td>
                                  </tr>
                                <tr>
                                  <td>8</td>
                                  <td>Hari ujian kesarjanaan / wisuda, apabila mengambil waktu sedikitnya 9 (sembilan) jam pada hari itu.</td>
                                  <td>1 (satu) hari</td>
                                  </tr>
                                <tr>
                                  <td>9</td>
                                  <td>Menunaikan ibadah haji atau umroh untuk yang pertama kali (mana yang tercapai lebih dahulu)</td>
                                  <td>Aktual</td>
                                  </tr>
                                <tr>
                                  <td>10</td>
                                  <td>Memenuhi panggilan Pengadilan atau pihak yang berwajib (bukan penahanan/pengurusan tilang)</td>
                                  <td>Aktual</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-collapse">
                      <div class="card-header" role="tab" id="headingTwo">
                        <h5 class="mb-0">
                          <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          <b>Bagaimana jika saya butuh waktu lebih lama dari yg ditentukan?</b>
                            <i class="material-icons">keyboard_arrow_down</i>
                          </a>
                        </h5>
                      </div>
                      <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                          Bila untuk keperluan di atas dibutuhkan waktu lebih dari yang telah ditentukan, maka kelebihan waktu tersebut akan diperhitungkan pada hak cuti karyawan tersebut.
                          </br> Silahkan mengajukan cuti dengan kategori tahunan, besar ataupun tabungan yang kamu miliki.
                        </div>
                      </div>
                    </div>
                    <div class="card-collapse">
                      <div class="card-header" role="tab" id="headingThree">
                        <h5 class="mb-0">
                          <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          <b>Bagaimana jika peristiwa tersebut terjadi dalam waktu libur?</b>
                            <i class="material-icons">keyboard_arrow_down</i>
                          </a>
                        </h5>
                      </div>
                      <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                          Bila peristiwa-peristiwa tersebut terjadi dalam waktu libur, maka ijin tersebut dengan sendirinya ikut  gugur, kecuali untuk peristiwa point 1, 4 & 5.
                        <p>Untuk peristiwa yang termasuk pada point 4 & 5, maka ijin tidak masuk kerja dapat digunakan 1 (satu) hari setelah peristiwa dengan lama ijin sesuai dengan ketentuan diatas.
                        </div>
                      </div>
                    </div>
                    <!-- <div class="card-collapse">
                      <div class="card-header" role="tab" id="headingFour">
                        <h5 class="mb-0">
                          <a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                          <b>Bagaimana jika peristiwa tersebut terjadi dalam waktu libur?</b>
                            <i class="material-icons">keyboard_arrow_down</i>
                          </a>
                        </h5>
                      </div>
                      <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">
                          Bila peristiwa-peristiwa tersebut terjadi dalam waktu libur, maka ijin tersebut dengan sendirinya ikut  gugur, kecuali untuk peristiwa point 1, 4 & 5.
                        </div>
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
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

<div class="modal fade" id="tambahCuti" tabindex="-1" role="dialog" aria-labelledby="tambahCutiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahCutiLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('cuti/saldo/add'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <input type="hidden" class="form-control" id="npk" name="npk">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Karyawan*</label></br>
                                <select class="selectpicker" name="karyawan" id="karyawan" title="Pilih" data-style="select-with-transition" data-size="5" data-width="block" data-live-search="true" required>
                                    <?php foreach ($allkaryawan as $k) : ?>
                                        <option value="<?= $k['npk']; ?>"><?= $k['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Kategori*</label></br>
                                <select class="selectpicker" name="kategori" id="kategori" title="Pilih" data-style="select-with-transition" data-size="5" data-width="block" data-live-search="false" onchange="kategoriSelect(this);" required>
                                    <?php foreach ($kategori as $k) : ?>
                                        <option value="<?= $k['kategori']; ?>"><?= $k['kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                            <button type="submit" class="btn btn-success">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>