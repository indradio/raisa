<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info alert-with-icon" data-notify="container">
                    <i class="material-icons" data-notify="icon">notifications</i>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span data-notify="message"><strong>UPDATE nomor GO-PAY Admin!</strong></span>
                    </br>Untuk pengembalian kasbon ke akaun GO-PAY sekarang ke nomor <strong>081311010378 a/n Dwi Septianingrum</strong>
                    </br>Jangan sampai salah transfer ya!
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">#<?= $perjalanan['id'] .' - '.$perjalanan['jenis_perjalanan']; ?></h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('perjalanan/penyelesaian/submit'); ?>" method="post">
                            <div class="row" hidden="true">
                                <label class="col-md-2 col-form-label">No Perjalanan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id" value="<?= $perjalanan['id']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Nama</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nama" value="<?= $perjalanan['nama']; ?>" />
                                        <input type="text" class="form-control disabled" name="npk" value="<?= $perjalanan['npk']; ?>" hidden="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tanggal (Jam)</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                    <?php if ($perjalanan['tglberangkat'] == $perjalanan['tglkembali']){ ?>
                                        <input type="text" class="form-control disabled" id="tgl" name="tgl" value="<?= date("d M Y", strtotime($perjalanan['tglberangkat'])) .' ('.date("H:i", strtotime($perjalanan['jamberangkat'])) . ' - ' . date("H:i", strtotime($perjalanan['jamkembali'])).') '; ?>">
                                    <?php }else{ ?>
                                        <input type="text" class="form-control disabled" id="tgl" name="tgl" value="<?= date("d M Y", strtotime($perjalanan['tglberangkat'])) . ' - ' .date("d M Y", strtotime($perjalanan['tglkembali'])); ?>">
                                    <?php }?>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <label class="col-md-2 col-form-label">Jam</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="jam" name="jam" value="<?= date("H:i", strtotime($perjalanan['jamberangkat'])) . ' - ' . date("H:i", strtotime($perjalanan['jamkembali'])); ?>">
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tujuan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tujuan" value="<?= $perjalanan['tujuan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Total Jarak</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="kmtotal" value="<?= $perjalanan['kmtotal']; ?> Km">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Kendaraan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="kepemilikan" value="<?= $perjalanan['kepemilikan'].' ('.$perjalanan['nopol'].')'; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden="true">
                                <label class="col-md-2 col-form-label">COPRO</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="copro" value="<?= $perjalanan['copro']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden="true">
                                <label class="col-md-2 col-form-label">Keperluan</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control disabled" name="keperluan"><?= $perjalanan['keperluan']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tunjangan </br><small>Peserta</small></label>
                                <div class="col-md-8">
                                    <?php if ($perjalanan['jenis_perjalanan']=='TAPP'){ echo '<a href="#" class="btn btn-sm btn-facebook" data-toggle="modal" data-target="#ubahKategori" data-id="'.$perjalanan['id'].'">Ganti Kategori DLPP</a>';}?>
                                    <div class="table-responsive">
                                        <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama</th>
                                                    <th>Total</th>
                                                    <?php if ($perjalanan['uang_saku']>0){ echo '<th><small>Uang Saku</small></th>'; } ?>
                                                    <?php if ($perjalanan['insentif_pagi']>0){ echo '<th><small>Insentif</small></th>';} ?>
                                                    <?php if ($perjalanan['um_pagi']>0){ echo '<th><small>Pagi</small></th>';} ?>
                                                    <?php if ($perjalanan['um_siang']>0){ echo '<th><small>Siang</small></th>';} ?>
                                                    <?php if ($perjalanan['um_malam']>0){ echo '<th><small>Malam</small></th>';} ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $queryAnggota = "SELECT *
                                                        FROM `perjalanan_anggota`
                                                        WHERE `perjalanan_id` = '{$perjalanan['id']}'
                                                        ";
                                                $anggota = $this->db->query($queryAnggota)->result_array();
                                                $totalTunj = 0;
                                                foreach ($anggota as $a) : ?>
                                                    <tr>
                                                        <td><?= $a['karyawan_inisial']; ?></td>
                                                        <?php if ($perjalanan['pic_perjalanan'] == $a['karyawan_inisial']){ 
                                                            $tunj_pic = $a['total']; 
                                                            ?>
                                                            <td><?= '<a href="#" class="btn btn-link btn-success btn-just-icon" data-toggle="tooltip" data-placement="top" title="PIC Perjalanan"><i class="material-icons">military_tech</i></a>'.$a['karyawan_nama']; ?></td>
                                                        <td><strong><?= number_format($a['total']+$perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir']-$perjalanan['kasbon'], 0, ',', '.'); ?></strong></td>
                                                        <?php }else{ ?>
                                                            <td><?= '<a href="'. base_url('perjalanan/change_pic/'.$perjalanan['id'].'/'.$a['karyawan_inisial']).'" class="btn btn-link btn-warning btn-just-icon" data-toggle="tooltip" data-placement="top" title="Jadikan PIC"><i class="material-icons">push_pin</i></a>'.$a['karyawan_nama']; ?></td>
                                                        <td><strong><?= number_format($a['total'], 0, ',', '.'); ?></strong></td>
                                                        <?php } ?>
                                                        <?php if ($perjalanan['uang_saku']>0){ echo '<td><small>'.number_format($a['uang_saku'], 0, ',', '.').'</small></td>'; } ?>
                                                        <?php if ($perjalanan['insentif_pagi']>0){ echo '<td><small>'.number_format($a['insentif_pagi'], 0, ',', '.').'</small></td>';} ?>
                                                        <?php if ($perjalanan['um_pagi']>0){ echo '<td><small>'.number_format($a['um_pagi'], 0, ',', '.').'</small></td>';} ?>
                                                        <?php if ($perjalanan['um_siang']>0){ echo '<td><small>'.number_format($a['um_siang'], 0, ',', '.').'</small></td>';} ?>
                                                        <?php if ($perjalanan['um_malam']>0){ echo '<td><small>'.number_format($a['um_malam'], 0, ',', '.').'</small></td>';} ?>
                                                    </tr>
                                                <?php 
                                                $totalTunj = $totalTunj + $a['total']; 
                                                endforeach; ?>
                                            </tbody>
                                        </table>
                                        <small>*<?= number_format($tunj_pic, 0, ',', '.') . ' (Tunjangan) + ' . number_format($perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'], 0, ',', '.'). ' (Biaya Perjalanan) - ' . number_format($perjalanan['kasbon'], 0, ',', '.'); ?> (Kasbon)</small>
                                    </div>
                                </div>
                            </div>
                            <!-- <p>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Tunjangan </br><small>Peserta</small></label>
                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Biaya</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Uang Saku <small>(TAPP)</small></td>
                                                        <td><?= number_format($perjalanan['uang_saku'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Insentif Pagi</br><small>Berangkat < 05:00</small> </td> <td><?= number_format($perjalanan['insentif_pagi'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Makan Pagi <small>(TAPP)</br>Berangkat < 07:00</small> </td> <td><?= number_format($perjalanan['um_pagi'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Makan Siang</td>
                                                        <td><?= number_format($perjalanan['um_siang'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Makan Malam</br><small>Kembali > 19:30</small></td>
                                                        <td><?= number_format($perjalanan['um_malam'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <small>*Untuk Perjalanan TA masih dalam pengembangan. Silahkan menggunakan penyelesaian manual.</small>
                                        </div>
                                    </div>
                                </div> -->
                            <p>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Rincian </br><small>Biaya Perjalanan</small></label>
                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Biaya</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="table-success">
                                                        <td>Tunjangan</td>
                                                        <td><?= number_format($totalTunj, 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-success disabled">AUTO</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Taksi/Sewa</br><small>Pribadi per KM</small> </td>
                                                        <td><?= number_format($perjalanan['taksi'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-warning" data-toggle="modal" data-target="#ubahTaksi" data-id="<?= $perjalanan['id']; ?>" data-taksi="<?= $perjalanan['taksi']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr class="table-danger" hidden>
                                                        <td>BBM</td>
                                                        <td><?= number_format($perjalanan['bbm'], 0, ',', '.'); ?></td>
                                                        <td>Voucher SPBU</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tol</td>
                                                        <td><?= number_format($perjalanan['tol'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-warning" data-toggle="modal" data-target="#ubahTol" data-id="<?= $perjalanan['id']; ?>" data-tol="<?= $perjalanan['tol']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Parkir & Lainnya</td>
                                                        <td><?= number_format($perjalanan['parkir'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-warning" data-toggle="modal" data-target="#ubahParkir" data-id="<?= $perjalanan['id']; ?>" data-parkir="<?= $perjalanan['parkir']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><h5>TOTAL</h5></td>
                                                        <td colspan="2" class="text-center"><h5><?= number_format($perjalanan['total'], 0, ',', '.'); ?></h5></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <small>*Isi Biaya tol jika menggunakan uang pribadi, kosongkan jika menggunakan e-toll dari GA.</small>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    $selisih = ($tunj_pic + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir']) - $perjalanan['kasbon'];
                                    $selisihPositif = $perjalanan['kasbon'] - ($tunj_pic + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir']);
                                    if ($perjalanan['kasbon'] > 0){ 
                                ?>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Kasbon</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="kasbon" value="<?= number_format($perjalanan['kasbon_out'], 0, ',', '.'); ?> (Terima)">
                                            <input type="text" class="form-control disabled" name="kasbon" value="<?= number_format($perjalanan['kasbon_in'], 0, ',', '.'); ?> (Kembali)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Selisih</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="selisih" value="<?= number_format(($tunj_pic + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir']) - $perjalanan['kasbon'], 0, ',', '.'); ?>">
                                        </div>
                                        <small>*Selisih =(Biaya Perjalanan + Tunj PIC) - Kasbon.</small></br>
                                        <?php if ($selisih < 0){ echo '<a href="#" class="btn btn-sm btn-facebook" data-toggle="modal" data-target="#penyelesaianKasbon" data-id="'.$perjalanan['id'].'" data-kasbon_out="'.number_format($perjalanan['kasbon_out'], 0, ',', '.').'" data-kasbon_out_ewallet="'.$perjalanan['kasbon_ewallet'].'" data-biaya="( '.number_format($perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'], 0, ',', '.').' )" data-tunj="( '.number_format($tunj_pic, 0, ',', '.').' )" data-kasbon_in="( '.number_format($perjalanan['kasbon_in'], 0, ',', '.').' )" data-kasbon_transfer="'.$selisihPositif.'" data-kasbon="'.number_format($selisihPositif, 0, ',', '.').'">Kembalikan Kasbon</a>'; }?>
                                    </div>
                                </div>
                                <?php } ?>
                                <!-- <div class="row">
                                    <label class="col-md-2 col-form-label">Grand Total</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="total" value="<?= number_format($perjalanan['total'], 0, ',', '.'); ?>">
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Customer*</br><small>Orang yang ditemui</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <textarea rows="3" class="form-control" name="tujuan_pic" placeholder="Siapa saja yang kamu temui?" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Catatan</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <textarea rows="2" class="form-control" name="catatan"><?= $perjalanan['catatan']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                        <?php if ($selisih < 0){ ?>
                                                <button type="submit" class="btn btn-fill btn-default disabled" disabled="true">KLAIM</button>
                                                <a href="<?= base_url('perjalanan/penyelesaian/daftar'); ?>" class="btn btn-link btn-default">Kembali</a>
                                                </br><small>*Silahkan kembalikan kasbon terlebih dahulu.</small>
                                            <?php }else{ ?>
                                                <button type="submit" class="btn btn-fill btn-success">KLAIM</button>
                                                <a href="<?= base_url('perjalanan/penyelesaian/daftar'); ?>" class="btn btn-link btn-default">Kembali</a>
                                            <?php } ?>
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
<div class="modal fade" id="ubahKategori" tabindex="-1" role="dialog" aria-labelledby="ubahKategoriLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-danger text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Ubah Kategori Perjalanan</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('perjalanan/change_kategori'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    Kategori perjalanan menjadi DLPP </br>
                    Nilai Tunjangan dalam perjalanan ini akan disesuaikan dengan kategori perjalanan. 
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-success">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ubahTaksi" tabindex="-1" role="dialog" aria-labelledby="ubahTaksiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahTaksiLabel">Taksi / Sewa / Pribadi <small>(per Kilometer)</small></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanan/penyelesaian_edit/taksi'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_taksi" name="e_taksi" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="taksi" name="taksi" required="true" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ubahTol" tabindex="-1" role="dialog" aria-labelledby="ubahTolLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahTolLabel">Biaya Tol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanan/penyelesaian_edit/tol'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_tol" name="e_tol" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="tol" name="tol" required="true" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ubahParkir" tabindex="-1" role="dialog" aria-labelledby="ubahParkirLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahParkirLabel">Biaya Parkir & Lainnya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanan/penyelesaian_edit/parkir'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_parkir" name="e_parkir" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="parkir" name="parkir" required="true" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="penyelesaianKasbon" tabindex="-1" role="dialog" aria-labelledby="penyelesaianKasbonLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penyelesaianKasbonLabel">Kasbon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/kasbon_in'); ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control disabled" id="id" name="id" />
                    <div class="row">
                        <label class="col-md-5 col-form-label">Kasbon (In)</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="kasbon_out" name="kasbon_out" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Tranfer ke</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="kasbon_out_ewallet" name="kasbon_out_ewallet" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Kasbon (Out)</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="kasbon_in" name="kasbon_in" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Biaya Perjalanan</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="biaya" name="biaya" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Tunjangan PIC</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="tunj" name="tunj" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 col-form-label text-center">Pengembalian Kasbon</label>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Kasbon</br><small>(yg harus dikembalikan)</small></label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="kasbon" name="kasbon" />
                                <input type="hidden" class="form-control" id="kasbon_transfer" name="kasbon_transfer" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Tranfer ke </label>
                        <div class="col-md-5">
                            <div class="form-group has-default">
                                <select class="selectpicker" name="kasbon_in_ewallet" id="kasbon_in_ewallet" data-style="select-with-transition" title="Pilih eWallet" data-size="7" required>
                                    <option value="GO-PAY - 085717304048">GO-PAY - 081311010378</option>
                                    <option value="DANA - 081311010378">DANA - 081311010378</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">KEMBALIKAN</button>
                </div>
                <div class="modal-footer">
                    <small>*Tunjukan bukti transfer kamu ke GA dan FA</small>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#ubahKategori').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        })
        $('#ubahTaksi').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var taksi = button.data('taksi')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_taksi"]').val(taksi)
        })
        $('#ubahTol').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var tol = button.data('tol')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_tol"]').val(tol)
        })
        $('#ubahParkir').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var parkir = button.data('parkir')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_parkir"]').val(parkir)
        })

        $('#penyelesaianKasbon').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var kasbon_out = button.data('kasbon_out')
            var kasbon_out_ewallet = button.data('kasbon_out_ewallet')
            var biaya = button.data('biaya')
            var tunj = button.data('tunj')
            var kasbon_in = button.data('kasbon_in')
            var kasbon_transfer = button.data('kasbon_transfer')
            var kasbon = button.data('kasbon')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="kasbon_out"]').val(kasbon_out)
            modal.find('.modal-body input[name="kasbon_out_ewallet"]').val(kasbon_out_ewallet)
            modal.find('.modal-body input[name="biaya"]').val(biaya)
            modal.find('.modal-body input[name="tunj"]').val(tunj)
            modal.find('.modal-body input[name="kasbon_in"]').val(kasbon_in)
            modal.find('.modal-body input[name="kasbon_transfer"]').val(kasbon_transfer)
            modal.find('.modal-body input[name="kasbon"]').val(kasbon)
        })
    });
</script>