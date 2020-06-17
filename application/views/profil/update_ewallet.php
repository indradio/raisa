<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form id="timePrecense" class="form" method="post" action="<?= base_url('profil/submit/e-wallet'); ?>">
          <div class="card ">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">account_balance_wallet</i>
              </div>
              <h4 class="card-title">UPDATE e-WALLET</h4>
            </div>
            <div class="card-body ">
              <div class="progress" style="width: 100%">
                <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="1"></div>
              </div>
              <div class="form-group">
                <label for="a1" class="bmd-label-floating">Utama*</b></label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="utama" name="utama" title="Silahkan Pilih" data-size="3" data-live-search="false" required>
                  <option value="OVO">OVO</option>
                  <option value="DANA">DANA</option>
                  <option value="GO-PAY">GO-PAY</option>
                </select>
                <div class="form-group has-default">
                <input type="text" class="form-control" name="utama_rek" placeholder="Nomor Rekening e-Wallet" required="true">
              </div>
              </div>
              <div class="form-group">
                <label for="a2" class="bmd-label-floating">Cadangan</label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="cadangan" name="cadangan" title="Silahkan Pilih" data-size="3" data-live-search="false">
                  <option value="OVO">OVO</option>
                  <option value="DANA">DANA</option>
                  <option value="GO-PAY">GO-PAY</option>
                </select>
                <div class="form-group has-default">
                <input type="text" class="form-control" name="cadangan_rek" placeholder="Nomor Rekening e-Wallet">
              </div>
              </div>
              <div class="form-check mr-auto">
                <label class="form-check-label text-dark">
                  <input class="form-check-input" type="checkbox" id="check" value="" required>
                  <span class="form-check-sign">
                    <span class="check"></span>
                  </span>
                  <i>Dengan ini saya menyatakan telah memberikan informasi yang benar, kesalahan nomor rekening adalah tanggung jawab saya.</i>
                </label>
              </div>
              <div class="category form-category">
              </div>
            </div>
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