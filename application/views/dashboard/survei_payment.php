<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
  <div class="row">
      <div class="col-md-12">
        <form id="survei_payment" class="form" method="post" action="<?= base_url('dashboard/survei/submit'); ?>">
          <div class="card ">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">payments</i>
              </div>
              <h4 class="card-title">SURVEI PEMBAYARAN PERJALANAN DINAS VIA E-WALLET</h4>
            </div>
            <div class="card-body ">
            <div class="alert-default" role="alert">
              <!-- Begin Content -->
              <!-- ⚠️<strong>WAJIB BACA SEBELUM MENGISI</strong>⚠️
              </p>Tindakan bila ada yang terisi "Ya"
              </p><strong>Pernyataan A (Kondisi Kesehatan)</strong>
              </br>1. Periksa ke klinik tingkat pertama, ikuti protokol klinik.
              </br>2. Lapor ke Atasan sampai Manager.
              </p><strong>Pernyataan B (Risiko Penularan)</strong>
              </br>1. Lapor ke Atasan sampai Manager.
              </p><strong>Catatan</strong>
              </br>1. Bila ada yang terisi "Ya" dari quesionare ini, maka Karyawan harus segera menginformasikan ke atasannya (sampai Manager) di hari tersebut.
              </br>2. Form ini berlaku untuk semua orang yang bekerja di lingkungan WINTEQ.
              </p> -->
              <!-- End Content -->
            </div>
              <div class="progress" style="width: 100%">
                <div class="progress-bar progress-bar-info" role="progressbar" style="width: 100%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="1"></div>
              </div>
              <div class="form-group">
              <label for="a1" class="bmd-label-floating"><h4><b>Kamu memilih <?= $karyawan['ewallet_utama']; ?> Sebagai media transfer uang perjalanan dinas, uang itu kemudian biasanya kamu relokasi ke mana?</b></h4></label>
                      <div class="col-sm-4 col-sm-offset-1 checkbox-radios">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a1" name="a1" value="Langsung transfer ke rekening"> Langsung transfer ke rekening
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a2" name="a2" value="Langsung transfer ke e-wallet lain"> Langsung transfer ke e-wallet lain
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a3" name="a3" value="Kumpulkan sampai jumlah tertentu, kemudian transfer ke rekening"> Kumpulkan sampai jumlah tertentu, kemudian transfer ke rekening
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a4" name="a4" value="Dipakai belanja di merchant-merchant offline"> Dipakai belanja di merchant-merchant offline
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a5" name="a5" value="Dipakai belanja online"> Dipakai belanja online
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="a6" name="a6" value="Dipakai beli produk digital (pulsa listrik, HP, bayar tagihan, dll)"> Dipakai beli produk digital (pulsa listrik, HP, bayar tagihan, dll)
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        </p>
                        <div class="form-group">
                          <label for="lainnya" class="bmd-label-floating"> Lainnya <small><i>(Opsional)</i></small></label>
                          <textarea rows="3" class="form-control" id="lainnya" name="lainnya"></textarea>
                        </div>
                      </div>
                    </div>
                    <p id="text"></p>
            <div class="card-footer ml-auto">
              <button type="submit" id="submit" class="btn btn-success">SUBMIT</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- end row -->
  </div>
</div>

<script>
  $(document).ready(function() {

    // var checker = document.getElementById('check');
    var sendbtn = document.getElementById('submit');
    sendbtn.disabled = true;
    // // when unchecked or checked, run the function
    // checker.onchange = function() {
    //   if (this.checked) {
    //     sendbtn.disabled = false;
    //   } else {
    //     sendbtn.disabled = true;
    //   }
    // }

    var a1 = document.getElementById('a1');
    var a2 = document.getElementById('a2');
    var a3 = document.getElementById('a3');
    var a4 = document.getElementById('a4');
    var a5 = document.getElementById('a5');
    var a6 = document.getElementById('a6');
    var a7 = document.getElementById('a7');
    var a8 = document.getElementById('a8');
    var a9 = document.getElementById('a9');
    let total = 0;

    // when unchecked or checked, run the function
    a1.onchange = function() {
      if (this.checked) {
        total = total + 1;
      } else {
        total = total - 1;
      }

      if (total==0) {
        sendbtn.disabled = true;
      } else {
        sendbtn.disabled = false;
      }
    }
    a2.onchange = function() {
      if (this.checked) {
        total = total + 1;
      } else {
        total = total - 1;
      }

      if (total==0) {
        sendbtn.disabled = true;
      } else {
        sendbtn.disabled = false;
      }
    }
    a3.onchange = function() {
      if (this.checked) {
        total = total + 1;
      } else {
        total = total - 1;
      }

      if (total==0) {
        sendbtn.disabled = true;
      } else {
        sendbtn.disabled = false;
      }
    }
    a4.onchange = function() {
      if (this.checked) {
        total = total + 1;
      } else {
        total = total - 1;
      }

      if (total==0) {
        sendbtn.disabled = true;
      } else {
        sendbtn.disabled = false;
      }
    }
    a5.onchange = function() {
      if (this.checked) {
        total = total + 1;
      } else {
        total = total - 1;
      }

      if (total==0) {
        sendbtn.disabled = true;
      } else {
        sendbtn.disabled = false;
      }
    }
    a6.onchange = function() {
      if (this.checked) {
        total = total + 1;
      } else {
        total = total - 1;
      }

      if (total==0) {
        sendbtn.disabled = true;
      } else {
        sendbtn.disabled = false;
      }
    }
    
  });
</script>