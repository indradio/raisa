<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <div class="card-text">
                            <h4 class="card-title">Perjalanan</h4>
                            <p class="card-category"><?= $perjalanan['jenis_perjalanan'].' - '.$perjalanan['id']; ?></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('perjalanandl/penyelesaian/submit'); ?>" method="post">
                            <div class="row" hidden="true">
                                <label class="col-md-2 col-form-label">Nomor Perjalanan</label>
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
                                        <input type="text" class="form-control disabled" id="tgl" name="tgl" value="<?= date("d M Y", strtotime($perjalanan['tglberangkat'])) . ' '.date("H:i", strtotime($perjalanan['jamberangkat'])).' - ' .date("d M Y", strtotime($perjalanan['tglkembali'])).' '.date("H:i", strtotime($perjalanan['jamkembali'])); ?>">
                                    <?php }?>
                                    </div>
                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#gantiTgl" data-id="<?= $perjalanan['id']; ?>">Ubah Tanggal</a>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tujuan</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tujuan" value="<?= $perjalanan['tujuan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Kendaraan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="kepemilikan" value="<?= $perjalanan['kendaraan'].' ('.$perjalanan['kepemilikan'].')'; ?>">
                                        <input type="text" class="form-control disabled" name="nopol" value="<?= $perjalanan['nopol']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Jarak Tempuh </br><small>/Kilometer</small></label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="kmtotal" value="<?= $perjalanan['kmtotal']; ?> Km">
                                    </div>
                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#gantiJarak" data-id="<?= $perjalanan['id']; ?>">Ubah Jarak</a>
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
                                <label class="col-md-2 col-form-label">Peserta</label>
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Inisial</th>
                                                    <th>Nama</th>
                                                    <?php if ($perjalanan['uang_saku']>0){ echo '<th>Uang Saku</th>'; } ?>
                                                    <?php if ($perjalanan['insentif_pagi']>0){ echo '<th>Insentif</th>';} ?>
                                                    <?php if ($perjalanan['um_pagi']>0){ echo '<th>Pagi</th>';} ?>
                                                    <?php if ($perjalanan['um_siang']>0){ echo '<th>Siang</th>';} ?>
                                                    <?php if ($perjalanan['um_malam']>0){ echo '<th>Malam</th>';} ?>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $queryAnggota = "SELECT *
                                                        FROM `perjalanan_anggota`
                                                        WHERE `perjalanan_id` = '{$perjalanan['id']}'
                                                        ";
                                                $anggota = $this->db->query($queryAnggota)->result_array();
                                                foreach ($anggota as $a) : ?>
                                                    <tr>
                                                        <td><?= $a['karyawan_inisial']; ?></td>
                                                        <?php if ($perjalanan['pic_perjalanan'] == $a['karyawan_inisial']){ ?>
                                                            <td><?= $a['karyawan_nama'].' <a href="#" class="btn btn-link btn-success btn-just-icon" data-toggle="tooltip" data-placement="top" title="PIC Perjalanan"><i class="material-icons">military_tech</i></a>'; ?></td>
                                                        <?php }else{ ?>
                                                            <td><?= $a['karyawan_nama']; ?></td>
                                                        <?php } ?>
                                                        <?php if ($perjalanan['uang_saku']>0){ echo '<td>'.number_format($a['uang_saku'], 0, ',', '.').'</td>'; } ?>
                                                        <?php if ($perjalanan['insentif_pagi']>0){ echo '<td>'.number_format($a['insentif_pagi'], 0, ',', '.').'</td>';} ?>
                                                        <?php if ($perjalanan['um_pagi']>0){ echo '<td>'.number_format($a['um_pagi'], 0, ',', '.').'</td>';} ?>
                                                        <?php if ($perjalanan['um_siang']>0){ echo '<td>'.number_format($a['um_siang'], 0, ',', '.').'</td>';} ?>
                                                        <?php if ($perjalanan['um_malam']>0){ echo '<td>'.number_format($a['um_malam'], 0, ',', '.').'</td>';} ?>
                                                        <?php if ($perjalanan['pic_perjalanan'] == $a['karyawan_inisial']){ ?>
                                                            <td>
                                                            <?= number_format($a['total'] + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'] - $perjalanan['kasbon'], 0, ',', '.'); ?><br>
                                                            <small>Rincian :</small><br>
                                                            <small>+ <?= number_format($a['total'], 0, ',', '.'); ?> (Tunjangan)</small><br>
                                                            <small>+ <?= number_format($perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'], 0, ',', '.'); ?> (Perjalanan)</small><br>
                                                            <small>- <?= number_format($perjalanan['kasbon'], 0, ',', '.'); ?> (Kasbon)</small>
                                                            </td>
                                                        <?php }else{ ?>
                                                            <td><?= number_format($a['total'], 0, ',', '.'); ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <p>
                            <?php if ($perjalanan['jenis_perjalanan']!='TA'){ ?>
                            <div class="row">
                                    <label class="col-md-2 col-form-label">Tunjangan </br><small>Peserta</small></label>
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
                                                    <tr>
                                                        <td>Uang Saku <small>(TAPP)</small></td>
                                                        <td><?= number_format($perjalanan['uang_saku'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-info disabled">AUTO</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Insentif Pagi</br><small>Berangkat < 05:00</small> </td> <td><?= number_format($perjalanan['insentif_pagi'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-info disabled">AUTO</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Makan Pagi <small>(TAPP)</br>Berangkat < 06:00</small> </td> <td><?= number_format($perjalanan['um_pagi'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-info disabled">AUTO</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Makan Siang</td>
                                                        <td><?= number_format($perjalanan['um_siang'], 0, ',', '.'); ?></td>
                                                        <?php if ($perjalanan['um_siang']==0) {?>
                                                            <td><a href="<?= base_url('perjalanandl/update_umsiang/tambah/'.$perjalanan['id']); ?>" class="btn btn-fill btn-sm btn-success">TAMBAH</a></td>
                                                        <?php }else{ ?>
                                                            <td><a href="<?= base_url('perjalanandl/update_umsiang/kurang/'.$perjalanan['id']); ?>" class="btn btn-fill btn-sm btn-danger">HAPUS</a></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Makan Malam</br><small>Kembali > 19:30</small></td>
                                                        <td><?= number_format($perjalanan['um_malam'], 0, ',', '.'); ?></td>
                                                        <?php if ($perjalanan['um_malam']==0) {?>
                                                            <td><a href="<?= base_url('perjalanandl/update_ummalam/tambah/'.$perjalanan['id']); ?>" class="btn btn-fill btn-sm btn-success">TAMBAH</a></td>
                                                        <?php }else{ ?>
                                                            <td><a href="<?= base_url('perjalanandl/update_ummalam/kurang/'.$perjalanan['id']); ?>" class="btn btn-fill btn-sm btn-danger">HAPUS</a></td>
                                                        <?php } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Rincian Biaya </br><small>Perjalanan</small></label>
                                    <div class="col-md-8">
                                        <div class="material-datatables">
                                            <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Biaya</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Taksi/Sewa</br><small>Pribadi per KM</small> </td>
                                                        <td><?= number_format($perjalanan['taksi'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-warning" data-toggle="modal" data-target="#ubahTaksi" data-id="<?= $perjalanan['id']; ?>" data-taksi="<?= $perjalanan['taksi']; ?>">UBAH</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>BBM</td>
                                                        <td><?= number_format($perjalanan['bbm'], 0, ',', '.'); ?></td>
                                                        <td><a href="#" class="btn btn-fill btn-sm btn-warning" data-toggle="modal" data-target="#ubahBbm" data-id="<?= $perjalanan['id']; ?>" data-bbm="<?= $perjalanan['bbm']; ?>">UBAH</a></td>
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
                                                        <td><strong>SUB TOTAL</strong></td>
                                                        <td><strong><?= number_format($perjalanan['taksi']+$perjalanan['bbm']+$perjalanan['tol']+$perjalanan['parkir'], 0, ',', '.'); ?></strong></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Total</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="total" value="<?= number_format($perjalanan['total'], 0, ',', '.'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php if ($perjalanan['kasbon_out']>0){ ?>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Kasbon</br><small>Transfer</small></label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="kasbon" value="<?= number_format($perjalanan['kasbon_out'], 0, ',', '.'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Kasbon</br><small>Dikembalikan</small></label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="kasbon" value="<?= number_format($perjalanan['kasbon_in'], 0, ',', '.'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Kasbon</br><small>Total</small></label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="kasbon" value="<?= number_format($perjalanan['kasbon'], 0, ',', '.'); ?>">
                                            <?php if ($perjalanan['kasbon']>0){
                                                echo '<a href="#" class="btn btn-wd btn-facebook" data-toggle="modal" data-target="#kurangKasbon" data-id="'. $perjalanan['id'].'" data-total="'. $perjalanan['total'].'" data-kasbon="'. $perjalanan['kasbon'].'">DIKEMBALIKAN</a>';
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#tambahKasbon" data-id="<?= $perjalanan['id']; ?>" data-total="<?= $perjalanan['total']; ?>" data-kasbon="<?= $perjalanan['kasbon']; ?>">DIBAYARKAN (TAMBAH)</a>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Biaya Perjalanan </br><small>yang akan dibayar FA</small></label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="selisih" value="<?= number_format($perjalanan['total'] - $perjalanan['kasbon'], 0, ',', '.'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Catatan</label>
                                    <div class="col-md-5">
                                        <div class="form-group has-default">
                                            <textarea rows="2" class="form-control" name="catatan"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                        <?php 
                                         $this->db->where('perjalanan_id', $perjalanan['id']);
                                         $this->db->where('karyawan_inisial', $perjalanan['pic_perjalanan']);
                                         $pic = $this->db->get('perjalanan_anggota')->row_array();
                                         $selisih = ($pic['total']+$perjalanan['taksi']+$perjalanan['bbm']+$perjalanan['tol']+$perjalanan['parkir']) - $perjalanan['kasbon'];
                                         if ($selisih >= 0){ 
                                            echo '<button type="submit" class="btn btn-fill btn-success">VERIFIKASI</button>';
                                        }else{
                                            echo '<small>PIC Perjalanan harus menyelesaikan kasbon terlebih dulu senilai </small> Rp '. number_format($selisih, 0, ',', '.').' </br>';
                                            echo '<button type="submit" class="btn btn-wd btn-fill btn-danger disabled">PIC TIDAK BOLEH MINUS</button>';
                                        } ?>
                                            <a href="<?= base_url('perjalanandl/penyelesaian/daftar'); ?>" class="btn btn-link btn-default">Kembali</a>
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
<div class="modal fade" id="tambahKasbon" tabindex="-1" role="dialog" aria-labelledby="tambahKasbonLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKasbonLabel">Kasbon/Biaya Dibayarkan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/update_kasbon/tambah'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Total Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="total" name="total" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Kasbon</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="kasbon" name="kasbon" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Bayar Lagi</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="tambah_kasbon" name="tambah_kasbon" value="0" required="true" />
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
<div class="modal fade" id="kurangKasbon" tabindex="-1" role="dialog" aria-labelledby="kurangKasbonLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kurangKasbonLabel">Kasbon/Biaya Dibayarkan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/update_kasbon/kurang'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Total Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="total" name="total" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Kasbon</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="kasbon" name="kasbon" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Uang yang dikembalikan</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="kurang_kasbon" name="kurang_kasbon" value="0" required="true" />
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
<div class="modal fade" id="ubahUangsaku" tabindex="-1" role="dialog" aria-labelledby="ubahUangsakuLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahUangsakuLabel">Uang Saku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/penyelesaian_edit/uangsaku'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_uang_saku" name="e_uang_saku" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="uangsaku" name="uangsaku" required="true" />
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
<div class="modal fade" id="ubahInsentif" tabindex="-1" role="dialog" aria-labelledby="ubahInsentifLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahInsentifLabel">Insentif Pagi - <small>Berangkat sebelum Jam 05:00</small> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/penyelesaian_edit/insentif'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_insentif" name="e_insentif" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="insentif" name="insentif" required="true" />
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
<div class="modal fade" id="ubahUmpagi" tabindex="-1" role="dialog" aria-labelledby="ubahUmpagiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahUmpagiLabel">Makan Pagi - <small>Berangkat sebelum Jam 07:00</small> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/penyelesaian_edit/umpagi'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_umpagi" name="e_umpagi" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="umpagi" name="umpagi" required="true" />
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
<div class="modal fade" id="ubahUmsiang" tabindex="-1" role="dialog" aria-labelledby="ubahUmsiangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahUmsiangLabel">Makan Siang </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/penyelesaian_edit/umsiang'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_umsiang" name="e_umsiang" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="umsiang" name="umsiang" required="true" />
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
<div class="modal fade" id="ubahUmmalam" tabindex="-1" role="dialog" aria-labelledby="ubahUmmalamLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahUmmalamLabel">Makan Malam </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/penyelesaian_edit/ummalam'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_ummalam" name="e_ummalam" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="ummalam" name="ummalam" required="true" />
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
<div class="modal fade" id="ubahTaksi" tabindex="-1" role="dialog" aria-labelledby="ubahTaksiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahTaksiLabel">Taksi / Sewa / Pribadi <small>(per Kilometer)</small></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/penyelesaian_edit/taksi'); ?>">
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
<div class="modal fade" id="ubahBbm" tabindex="-1" role="dialog" aria-labelledby="ubahBbmLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahBbmLabel">Biaya Bbm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/penyelesaian_edit/bbm'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="e_bbm" name="e_bbm" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Aktual</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="bbm" name="bbm" required="true" />
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
            <form class="form" method="post" action="<?= base_url('perjalanandl/penyelesaian_edit/tol'); ?>">
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
            <form class="form" method="post" action="<?= base_url('perjalanandl/penyelesaian_edit/parkir'); ?>">
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
<div class="modal fade" id="gantiTgl" tabindex="-1" role="dialog" aria-labelledby="gantiTglTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">PERJALANAN DINAS</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('perjalanan/change_datetime'); ?>">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id" name="id" required>
                      <div class="row">
                        <label class="col-md-3 col-form-label">Berangkat</label>
                        <div class="col-md-9">
                          <div class="form-group has-default">
                            <input type="text" class="form-control datetimepicker" id="tglberangkat" name="tglberangkat" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <label class="col-md-3 col-form-label">Kembali</label>
                        <div class="col-md-9">
                          <div class="form-group has-default">
                            <input type="text" class="form-control datetimepicker" id="tglkembali" name="tglkembali" required>
                         </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                        <button type="submit" class="btn btn-success">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
<div class="modal fade" id="gantiJarak" tabindex="-1" role="dialog" aria-labelledby="gantiJarakTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">PERJALANAN DINAS</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('perjalanan/change_distance'); ?>">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id" name="id" required>
                      <div class="row">
                        <label class="col-md-3 col-form-label">Km Berangkat</label>
                        <div class="col-md-9">
                          <div class="form-group has-default">
                            <input type="number" class="form-control" id="kmberangkat" name="kmberangkat" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <label class="col-md-3 col-form-label">Km Kembali</label>
                        <div class="col-md-9">
                          <div class="form-group has-default">
                            <input type="number" class="form-control" id="kmkembali" name="kmkembali" required>
                         </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                        <button type="submit" class="btn btn-success">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
<script type="text/javascript">
    $(document).ready(function() {
     
        $('#tambahKasbon').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var total = button.data('total')
            var kasbon = button.data('kasbon')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="total"]').val(total)
            modal.find('.modal-body input[name="kasbon"]').val(kasbon)
        })
        $('#kurangKasbon').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var total = button.data('total')
            var kasbon = button.data('kasbon')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="total"]').val(total)
            modal.find('.modal-body input[name="kasbon"]').val(kasbon)
        })

        $('#gantiTgl').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        })

        $('#gantiJarak').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        })
    
        $('#ubahUangsaku').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var uang_saku = button.data('uang_saku')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_uang_saku"]').val(uang_saku)
        })
        $('#ubahInsentif').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var insentif = button.data('insentif')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_insentif"]').val(insentif)
        })
        $('#ubahUmpagi').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var umpagi = button.data('umpagi')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_umpagi"]').val(umpagi)
        })
        $('#ubahUmsiang').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var umsiang = button.data('umsiang')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_umsiang"]').val(umsiang)
        })
        $('#ubahUmmalam').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var ummalam = button.data('ummalam')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_ummalam"]').val(ummalam)
        })
        $('#ubahTaksi').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var taksi = button.data('taksi')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_taksi"]').val(taksi)
        })
        $('#ubahBbm').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var bbm = button.data('bbm')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="e_bbm"]').val(bbm)
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
        $('#prosesPerjalanan').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var total = button.data('total')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="total"]').val(total)
        })
    });
</script>