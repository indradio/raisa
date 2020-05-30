<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          <!-- Begin Content -->
          <strong>TERIMA KASIH KAMU SUDAH MENGISI FORM PEDULI KESEHATAN</strong>
          </p>Tindakan bila ada yang terisi "Ya"
          </p><strong>Pernyataan A1-A3 (Kondisi Kesehatan)</strong>
          </br>1. Periksa ke klinik tingkat pertama, ikuti protokol klinik.
          </br>2. Lapor ke Atasan sampai Manager.
          </p><strong>Pernyataan B1-B7 (Risiko Penularan)</strong>
          </br>1. Lapor ke Atasan sampai Manager.
          </br>2. Jangan masuk kerja di tanggal 2 Juni 2020 sampai ada instruksi dari Managernya.
          </p><strong>Catatan</strong>
          </br>1. Bila ada yang terisi "Ya" dari quesionare ini, maka Karyawan harus segera menginformasikan ke atasannya (sampai Manager) di hari tersebut.
          </br>2. Form ini berlaku untuk semua orang yang bekerja di lingkungan WINTEQ.
          </br>3. Tanpa form ini Karyawan tidak diperkenankan masuk di hari kerja setelah Libur Lebaran.
          <!-- End Content -->
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <form id="timePrecense" class="form" method="post" action="<?= base_url('dirumahaja/submit'); ?>">
          <div class="card ">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">local_hospital</i>
              </div>
              <h4 class="card-title">FORM PEDULI KESEHATAN KARYAWAN WINTEQ SELAMA LIBUR LEBARAN</h4>
            </div>
            <div class="card-body ">
              <div class="progress" style="width: 100%">
                <div class="progress-bar progress-bar-success" role="progressbar" style="width: 100%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="1"></div>
              </div>
              <div class="form-group">
                <label class="bmd-label-floating">
                  <h4><b>A. Kondisi Kesehatan</b></h4>
                </label>
              </div>

              <label for="a1" class="bmd-label-floating">A1. Kondisi kesehatan selama libur lebaran <b>(Demam/Pilek/Influenza)</b></label>
              <div class="form-group">
                <input type="text" class="form-control" id="a1" name="a1" value="<?= $kesehatan['a1']; ?>" disabled="true" />
              </div>

              <label for="a2" class="bmd-label-floating">A2. Kondisi kesehatan selama libur lebaran <b>(Batuk/Suara serak/Demam)</b></label>
              <div class="form-group">
                <input type="text" class="form-control" id="a2" name="a2" value="<?= $kesehatan['a2']; ?>" disabled="true" />
              </div>

              <label for="a3" class="bmd-label-floating">A3. Kondisi kesehatan selama libur lebaran <b>(Sesak nafas/Nafas pendek)</b></label>
              <div class="form-group">
                <input type="text" class="form-control" id="a3" name="a3" value="<?= $kesehatan['a3']; ?>" disabled="true" />
              </div>
              </br>
              <div class="form-group">
                <label class="bmd-label-floating">
                  <h4><b>B. Risiko Penularan</b></h4>
                </label>
              </div>

              <label for="b1" class="bmd-label-floating">B1. Pernah berinteraksi dengan <b>Pasien Positif, PDP, ODP</b> ataupun <b>Orang yang sedang menjalani Isolasi Mandiri COVID-19</b></label>
              <div class="form-group">
                <input type="text" class="form-control" id="b1" name="b1" value="<?= $kesehatan['b1']; ?>" disabled="true" />
              </div>

              <label for="b2" class="bmd-label-floating">B2. Pernah berkunjung ke rumah keluarga <b>Pasien Positif, PDP, ODP</b> ataupun <b>Orang yang sedang menjalani Isolasi Mandiri COVID-19</b></label>
              <div class="form-group">
                <input type="text" class="form-control" id="b2" name="b2" value="<?= $kesehatan['b2']; ?>" disabled="true" />
              </div>

              <label for="b3" class="bmd-label-floating">B3. Penghuni satu rumah ada yang dinyatakan <b>Pasien Positif, PDP, ODP</b> ataupun <b>Orang yang sedang menjalani Isolasi Mandiri COVID-19</b></label>
              <div class="form-group">
                <input type="text" class="form-control" id="b3" name="b3" value="<?= $kesehatan['b3']; ?>" disabled="true" />
              </div>

              <label for="b4" class="bmd-label-floating">B4. Kamu masuk dalam status <b>Pasien Positif, PDP, ODP</b> ataupun <b>Orang yang sedang menjalani Isolasi Mandiri COVID-19</b></label>
              <div class="form-group">
                <input type="text" class="form-control" id="b4" name="b4" value="<?= $kesehatan['b4']; ?>" disabled="true" />
              </div>

              <label for="b5" class="bmd-label-floating">B5. Mengikuti pemerikasaan Rapid Test, PCR, ataupun Tes Kesehatan lainnya dengan hasil <b>"kemungkinan terinfeksi COVID-19"</b></label>
              <div class="form-group">
                <input type="text" class="form-control" id="b5" name="b5" value="<?= $kesehatan['b5']; ?>" disabled="true" />
              </div>

              <label for="b6" class="bmd-label-floating">B6. Pergi dan kembali dari <b>luar kota / Kab</b></label>
              <div class="form-group">
                <input type="text" class="form-control" id="b6" name="b6" value="<?= $kesehatan['b6']; ?>" disabled="true" />
              </div>

              <label for="b7" class="bmd-label-floating">B7. Beraktivitas jauh <b>(lebih dari 20KM)</b> dari rumah kediaman</label>
              <div class="form-group">
                <input type="text" class="form-control" id="b7" name="b7" value="<?= $kesehatan['b7']; ?>" disabled="true" />
              </div>
              </p>
              <div class="form-group">
                <label for="catatan" class="bmd-label-floating"> Catatan <small><i>(Opsional)</i></small></label>
                <textarea rows="3" class="form-control" id="catatan" name="catatan" disabled="true"><?= $kesehatan['catatan']; ?> </textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- end row -->
  </div>
</div>
</script>