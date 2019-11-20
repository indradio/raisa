<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">Reservasi</h4>
                    </div>
                    <div class="card-body ">
                        <form class="form-horizontal" action="<?= 'http://gps.intellitrac.co.id/apis/tracking/realtime.php'; ?>" method="post">
                            <div class="row">
                                <label class="col-md-2 col-form-label">User</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Password</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Device</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="devices">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <button type="submit" class="btn btn-fill btn-rose">OK!</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="rsvGantikend" tabindex="-1" role="dialog" aria-labelledby="rsvGantikendTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Ganti Kendaraan</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('perjalanandl/gantikend/') . $reservasi['id']; ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">Jenis Kendaraan</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="kepemilikan" data-style="select-with-transition" data-size="7" required>
                                            <?php
                                            $Kendaraan = $this->db->get('kendaraan_status')->result_array();
                                            foreach ($Kendaraan as $kend) :
                                                echo '<option value="' . $kend['nama'] . '"';
                                                if ($kend['nama'] == $reservasi['kepemilikan']) {
                                                    echo 'selected';
                                                }
                                                echo '>' . $kend['nama'] . '</option>' . "\n";
                                            endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Nomor Polisi</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="nopol" list="listnopol" value="<?= $reservasi['nopol']; ?>">
                                        <datalist id="listnopol">
                                            <?php
                                            $Kendaraan = $this->db->get('kendaraan')->result_array();
                                            foreach ($Kendaraan as $kend) : ?>
                                                <option><?= $kend['nopol']; ?></option>
                                            <?php endforeach; ?>
                                        </datalist>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary btn-link btn-wd btn-lg">OK!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>