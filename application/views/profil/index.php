    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <a href="#pablo">
                                <img class="img" src="<?= base_url(); ?>assets/img/faces/<?= $karyawan['foto']; ?>" />
                            </a>
                        </div>
                        <div class="card-body">
                            <h6 class="card-category text-gray"><?= $karyawan['npk']; ?></h6>
                            <h4 class="card-title"><?= $karyawan['nama']; ?></h4>
                            <p class="card-description">
                                Don't be scared of the truth because we need to restart the human foundation in truth And I love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose">
                            <div class="card-icon">
                                <i class="material-icons">perm_identity</i>
                            </div>
                            <h4 class="card-title">Data Karyawan</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Posisi / Jabatan</label>
                                            <?php $posisi = $this->db->get_where('karyawan_posisi', ['id' =>  $karyawan['posisi_id']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $posisi['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Golongan</label>
                                            <?php $golongan = $this->db->get_where('karyawan_gol', ['id' =>  $karyawan['gol_id']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $golongan['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Divisi</label>
                                            <?php $divisi = $this->db->get_where('karyawan_div', ['id' =>  $karyawan['div_id']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $divisi['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Departemen</label>
                                            <?php $departemen = $this->db->get_where('karyawan_dept', ['id' =>  $karyawan['dept_id']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $departemen['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Unit Organisasi / Seksi</label>
                                            <?php $seksi = $this->db->get_where('karyawan_sect', ['id' =>  $karyawan['sect_id']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $seksi['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Atasan 1</label>
                                            <?php $atasan1 = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata['atasan1']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $atasan1['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Atasan 2</label>
                                            <?php $atasan2 = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata['atasan2']])->row_array(); ?>
                                            <input type="text" class="form-control" value="<?= $atasan2['nama']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                <div class="card card-profile">
                        <div class="card-body">
                        <img class="img" src="<?= base_url(); ?>assets/img/qrcode/<?= $karyawan['qrcode'].'.png'; ?>" />
                        <h2 class="card-title"><?= $karyawan['qrcode']; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose">
                            <div class="card-icon">
                                <i class="material-icons">perm_identity</i>
                            </div>
                            <h4 class="card-title">Data Diri</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                    <?php 
                                    if (substr($karyawan['ewallet_1'], 0, 2)=='GO'){
                                        $gopay = substr($karyawan['ewallet_1'], 9);
                                    }elseif(substr($karyawan['ewallet_2'], 0, 2)=='GO'){
                                        $gopay = substr($karyawan['ewallet_2'], 9);
                                    }elseif(substr($karyawan['ewallet_1'], 0, 3)=='DAN' or substr($karyawan['ewallet_1'], 0, 3)=='OVO'){
                                        $gopay ="";
                                    }else{
                                        $gopay = $karyawan['ewallet_1'];
                                    }

                                    if (substr($karyawan['ewallet_1'], 0, 4)=='DANA'){
                                        $dana = substr($karyawan['ewallet_1'], 7);
                                    }elseif(substr($karyawan['ewallet_2'], 0, 4)=='DANA'){
                                        $dana = substr($karyawan['ewallet_2'], 7);
                                    }elseif(substr($karyawan['ewallet_2'], 0, 2)=='GO' or substr($karyawan['ewallet_2'], 0, 3)=='OVO'){
                                        $dana = "";
                                    }else{
                                        $dana = $karyawan['ewallet_2'];
                                    }

                                    if (substr($karyawan['ewallet_1'], 0, 3)=='OVO'){
                                        $ovo = substr($karyawan['ewallet_1'], 6);
                                    }elseif(substr($karyawan['ewallet_2'], 0, 3)=='OVO'){
                                        $ovo = substr($karyawan['ewallet_2'], 6);
                                    }else{
                                        $ovo = "";
                                    }
                                    ?>
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">GO-PAY</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="<?= $gopay; ?>" disabled>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <a href="#" class="btn btn-link btn-success" data-toggle="modal" data-target="#updateEwallet" data-ewallet="GOPAY" data-rek="<?= $gopay; ?>"><i class="material-icons">edit</i></a>
                                                    </span>
                                                </div>
                                            </div>
                                            <?php if ($karyawan['ewallet_utama']=='GO-PAY'){
                                                echo '<a href="#" class="btn btn-sm btn-info disabled" role="button" aria-disabled="false">Utama</a>';
                                            }else{
                                                echo '<a href="'.base_url('profil/ewallet_utama/GO-PAY'). '" class="btn btn-sm btn-warning" role="button" aria-disabled="false">Jadikan Utama</a>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">DANA</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="<?= $dana; ?>" disabled>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <a href="#" class="btn btn-link btn-success" data-toggle="modal" data-target="#updateEwallet" data-ewallet="DANA" data-rek="<?= $dana; ?>"><i class="material-icons">edit</i></a>
                                                    </span>
                                                </div>
                                            </div>
                                            <?php if ($karyawan['ewallet_utama']=='DANA'){
                                                echo '<a href="#" class="btn btn-sm btn-info disabled" role="button" aria-disabled="false">Utama</a>';
                                            }else{
                                                echo '<a href="'.base_url('profil/ewallet_utama/DANA'). '" class="btn btn-sm btn-warning" role="button" aria-disabled="false">Jadikan Utama</a>';
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Fist Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Last Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Adress</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">City</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Country</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Postal Code</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>About Me</label>
                                            <div class="form-group">
                                                <label class="bmd-label-floating"> Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.</label>
                                                <textarea class="form-control" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-rose pull-right">Update Profile</button> -->
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Add Claim Medical Modal -->
<div class="modal fade" id="updateEwallet" tabindex="-1" role="dialog" aria-labelledby="#updateEwalletTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-info text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">UPDATE e-Wallet</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('profil/update_ewallet'); ?>">
          <div class="modal-body">
            <input type="hidden" class="form-control" name="ewallet" id="ewallet" />
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nomor Handphone*</label>
                        <input type="text" class="form-control" name="rek" id="rek" value=" "/>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-right">
              <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                <button type="submit" class="btn btn-success">UPDATE</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#updateEwallet').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var ewallet = button.data('ewallet')
            var rek = button.data('rek')
            var modal = $(this)
            modal.find('.modal-body input[name="ewallet"]').val(ewallet)
            modal.find('.modal-body input[name="rek"]').val(rek)
        })  
    });
</script>