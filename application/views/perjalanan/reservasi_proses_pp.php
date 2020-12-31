<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">emoji_transportation</i>
                        </div>
                        <h4 class="card-title"><?= $reservasi['jenis_perjalanan'] .' - '. $reservasi['id']; ?></h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('perjalanan/submit'); ?>" method="post">
                            <div class="row" hidden>
                                <label class="col-md-2 col-form-label">Nomor Reservasi</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id" value="<?= $reservasi['id']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Nama</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nama" value="<?= $reservasi['nama']; ?>">
                                        <input type="text" class="form-control disabled" name="npk" value="<?= $reservasi['npk']; ?>" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Berangkat</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="berangkat" name="berangkat" value="<?= date("d M Y", strtotime($reservasi['tglberangkat'])) . ' - ' . date("H:i", strtotime($reservasi['jamberangkat'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Kembali</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="kembali" name="kembali" value="<?= date("d M Y", strtotime($reservasi['tglkembali'])) . ' - ' . date("H:i", strtotime($reservasi['jamkembali'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Kendaraan</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nopol" value="<?= $reservasi['kendaraan']; ?> - <?= $reservasi['nopol']; ?>">
                                        <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#rsvgk" data-id="<?= $reservasi['id']; ?>">Ganti Kendaraan</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tujuan</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tujuan" value="<?= $reservasi['tujuan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Keperluan</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control disabled" name="keperluan"><?= $reservasi['keperluan']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Peserta</label>
                                <div class="col-md-8">
                                    <div class="material-datatables">
                                        <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Inisial</th>
                                                    <th>Nama</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $queryAnggota = "SELECT *
                                                        FROM `perjalanan_anggota`
                                                        WHERE `reservasi_id` = '{$reservasi['id']}'
                                                        ";
                                                $anggota = $this->db->query($queryAnggota)->result_array();
                                                foreach ($anggota as $ang) : 
                                                $gol = $this->db->get_where('karyawan_gol', ['id' => $ang['karyawan_gol']])->row_array();
                                                ?>
                                                    <tr>
                                                        <td><?= $ang['karyawan_inisial']; ?></td>
                                                        <?php if ($reservasi['pic_perjalanan'] == $ang['karyawan_inisial']){ ?>
                                                            <td><?= $ang['karyawan_nama'].' <a href="#" class="btn btn-link btn-success btn-just-icon" data-toggle="tooltip" data-placement="top" title="PIC Perjalanan"><i class="material-icons">military_tech</i></a>'; ?></td>
                                                        <?php }else{ ?>
                                                            <td><?= $ang['karyawan_nama']; ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <p>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Tunjangan </br><small>Estimasi</small></label>
                                    <div class="col-md-8">
                                        <div class="material-datatables">
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
                                                        <td><?= number_format($reservasi['uang_saku'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Insentif Pagi</br><small>Berangkat < 05:00</small> </td> <td><?= number_format($reservasi['insentif_pagi'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Makan Pagi <small>(TAPP)</br>Berangkat < 07:00</small> </td> <td><?= number_format($reservasi['um_pagi'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Makan Siang</td>
                                                        <td><?= number_format($reservasi['um_siang'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Makan Malam</br><small>Kembali > 19:30</small></td>
                                                        <td><?= number_format($reservasi['um_malam'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <p>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Rincian Biaya </br><small>Estimasi</small></label>
                                    <div class="col-md-8">
                                        <div class="material-datatables">
                                            <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Biaya</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Taksi/Sewa</br><small>Pribadi per KM</small> </td>
                                                        <td><?= number_format($reservasi['taksi'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>BBM</td>
                                                        <td><?= number_format($reservasi['bbm'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tol</td>
                                                        <td><?= number_format($reservasi['tol'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Parkir & Lainnya</td>
                                                        <td><?= number_format($reservasi['parkir'], 0, ',', '.'); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Total Biaya </br><small>Estimasi</small></label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" name="biaya" value="<?= number_format($reservasi['total'], 0, ',', '.'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Catatan</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <textarea rows="3" class="form-control" name="catatan"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <a href="#" class="btn btn-fill btn-success" data-toggle="modal" data-target="#prosesPerjalanan" data-id="<?= $reservasi['id']; ?>" data-total="<?= $reservasi['total']; ?>">PROSES</a>
                                            <!-- <button type="submit" class="btn btn-fill btn-success">PROSES</button> -->
                                            <a href="<?= base_url('perjalanan/reservasi'); ?>" class="btn btn-link btn-default">Kembali</a>
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
<div class="modal fade" id="rsvgk" tabindex="-1" role="dialog" aria-labelledby="rsvgkTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">GANTI KENDARAAN</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('perjalanan/rsvgk'); ?>">
                    <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">Kendaraan</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="kendaraan" id="kendaraan" title="Pilih Kendaraan" data-style="select-with-transition" data-size="7" required>
                                            <?php                                           
                                            $queryOperasional = "SELECT *
                                                FROM `kendaraan`
                                                WHERE `id` > 100 AND `is_active` = 1
                                                ORDER BY `id` ASC
                                                ";
                                            $operasional = $this->db->query($queryOperasional)->result_array();
                                            foreach ($operasional as $row) : 
                                                echo '<option data-subtext="'. $row['nama'] . '" value="' . $row['nama'] .'">'. $row['nopol'] .'</option>';
                                            endforeach; 
                                                echo ' <option value="Taksi">Taksi</option>';
                                                echo ' <option value="Sewa">Sewa</option>';
                                                echo ' <option value="Pribadi">Pribadi</option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label" id="lblnopol" style="display:none;">Nomor Polisi</label>
                                <div class="col-md-6">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" name="nopol" id="nopol" style="display:none;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-success">GANTI KENDARAAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="prosesPerjalanan" tabindex="-1" role="dialog" aria-labelledby="prosesPerjalananLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prosesPerjalananLabel">Proses Perjalanan Dinas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanan/reservasi/submit'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Estimasi Biaya</label>
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
                                <input type="number" class="form-control" id="kasbon" name="kasbon" value="0" required="true" />
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#prosesPerjalanan').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var total = button.data('total')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="total"]').val(total)
            modal.find('.modal-body input[name="kasbon"]').focus()
        })

        $('#rsvgk').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        })

        $('#kendaraan').change(function() {
            var kendaraan = $('#kendaraan').val();
            if (kendaraan == 'Taksi') {
                document.getElementById("lblnopol").style.display = 'block';
                document.getElementById("nopol").style.display = 'block';
                document.getElementById("nopol").required = true;
            } else if (kendaraan == 'Sewa') {
                document.getElementById("lblnopol").style.display = 'block';
                document.getElementById("nopol").style.display = 'block';
                document.getElementById("nopol").required = true;
            } else if (kendaraan == 'Pribadi') {
                document.getElementById("lblnopol").style.display = 'block';
                document.getElementById("nopol").style.display = 'block';
                document.getElementById("nopol").required = true;
            } else {
                document.getElementById("lblnopol").style.display = 'none';
                document.getElementById("nopol").style.display = 'none';
                document.getElementById("nopol").required = false;
            }
        });
    });
</script>