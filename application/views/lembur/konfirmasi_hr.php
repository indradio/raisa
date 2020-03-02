<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <?php
    $jammulai = date('H:i', strtotime($lembur['tglmulai']));
    $jamselesai = date('H:i', strtotime($lembur['tglselesai']));

    $this->db->where('durasi', $lembur['durasi']);
    $this->db->where('hari', $lembur['hari']);
    $queryTul = $this->db->get('lembur_tul')->row_array();
    if (!empty($queryTul)){
        $tul = $queryTul['tul'];
    }else{
        $tul = 0;
    }
    
    if ($lembur['kategori']!='OT' AND $lembur['durasi']!=9) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Durasi harus 9 JAM untuk Ganti Hari atau Tabungan Cuti</strong>
            </br>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 align-content-start">
                <div class="card"> 
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">update</i>
                        </div>
                        <h4 class="card-title">Persetujuan HR - <?= $lembur['id']; ?></h4>
                    </div>
                    <form class="form-horizontal" method="post" action="<?= base_url('lembur/submit_konfirmasi_hr'); ?>">
                        <div class="card-body">
                        </br>
                            <div class="form-group" hidden>
                                <label for="exampleID" class="bmd-label-floating">ID</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?= $lembur['id']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleNama" class="bmd-label-floating">Nama</label>
                                <input type="text" class="form-control disabled" id="nama" name="nama" value="<?= $lembur['nama']; ?>">
                            </div>
                            <div class="form-group form-inline">
                                <label for="exampleDate" class="bmd-label-floating">Tanggal & Jam</label>
                                <input type="text" class="form-control disabled" id="tglmulai" name="tglmulai" value="<?= date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($lembur['tglselesai'])); ?>"> 
                            </div>
                            <div class="form-group">
                                <label for="exampleDurasi" class="bmd-label-floating">Durasi</label>
                                <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= $lembur['durasi']; ?> Jam">
                            </div>
                            <div class="form-group">
                                <label for="exampleLokasi" class="bmd-label-floating">Lokasi</label>
                                <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="<?= $lembur['lokasi']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleKategori" class="bmd-label-floating">Kategori</label>
                                <?php if ($lembur['kategori']=='OT'){
                                    echo '<input type="text" class="form-control disabled" id="kategori_lembur" name="kategori_lembur" value="LEMBUR">';
                                } elseif ($lembur['kategori']=='GH'){
                                    echo '<input type="text" class="form-control disabled" id="kategori_lembur" name="kategori_lembur" value="GANTI HARI">';
                                } elseif ($lembur['kategori']=='TC'){
                                    echo '<input type="text" class="form-control disabled" id="kategori_lembur" name="kategori_lembur" value="TABUNGAN CUTI">';
                                } ?>
                            </div>
                            <div class="form-group">
                                <label for="exampleCatatan" class="bmd-label-floating">Catatan</label>
                                <textarea rows="3" class="form-control disabled" name="catatan" id="catatan"><?= $lembur['catatan']; ?></textarea>
                            </div>
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                                <!-- <a href="#" class="btn btn-rose mb" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">Tambah Aktivitas</a> -->
                            </div>
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                        <tr>
                                            <th>Kategori</th>
                                            <th>Aktivitas</th>
                                            <th>Deskripsi</th>
                                            <th>Progres</th>
                                            <th>Durasi <small>(Jam)</small></th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Kategori</th>
                                            <th>Aktivitas</th>
                                            <th>Deskripsi</th>
                                            <th>Progres</th>
                                            <th>Durasi <small>(Jam)</small></th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($aktivitas as $a) : ?>
                                            <tr>
                                                <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                                <td><?= $k['nama']; ?> <small>(<?= $a['copro']; ?>)</small></td>
                                                <td><?= $a['aktivitas']; ?></td>
                                                <td><?= $a['deskripsi_hasil']; ?></td>
                                                <td><?= $a['progres_hasil']; ?>%</td>
                                                <td><?= $a['durasi']; ?> jam</td>
                                                <td class="text-right">
                                                    <a href="#" data-toggle="modal" data-target="#realisasiAktivitas" data-id="<?= $a['id']; ?>" data-aktivitas="<?= $a['aktivitas']; ?>" data-deskripsi_hasil="<?= $a['deskripsi_hasil']; ?>" data-progres_hasil="<?= $a['progres_hasil']; ?>" class="badge badge-pill badge-info">Revisi</a>
                                                    <a href="<?= base_url('lembur/hapus_aktivitas_realisasi/') . $a['id']; ?>" class="badge badge-pill badge-danger btn-sm btn-bataldl">Batalkan</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Button SUBMIT -->
                            <a href="#" class="btn btn-sm btn-success" role="button" aria-disabled="false" data-toggle="modal" data-target="#submitLembur" data-id="<?= $lembur['id']; ?>">SUBMIT</a>
                            <!-- <button type="submit" id="ajukan" class="btn btn-sm btn-success">PROSES</button> -->
                            <!-- Button BATALKAN & KEMBALI -->
                            <a href="#" id="batalAktivitas" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                            <a href="<?= base_url('lembur/konfirmasi/hr') ?>" class="btn btn-sm btn-default" role="button">Kembali</a>
                        </div>
                        <!-- end content-->
                    </form>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
</div>
<!-- Modal -->
<!-- Proccess-->
<div class="modal fade" id="submitLembur" tabindex="-1" role="dialog" aria-labelledby="submitLemburTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <?php if ($lembur['kategori']=='OT'){
                            echo '<h4 class="card-title">LEMBUR</h4>';
                        } elseif ($lembur['kategori']=='GH'){
                            echo '<h4 class="card-title">GANTI HARI</h4>';
                        } elseif ($lembur['kategori']=='TC'){
                            echo '<h4 class="card-title">TABUNGAN CUTI</h4>';
                        } ?>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('lembur/submit_konfirmasi_hr'); ?>">
                    <div class="card-body">
                        <div class="col-md-12 align-content-start">
                            </br>
                            <div class="form-group" hidden>
                                <label for="exampleID" class="bmd-label-floating">ID</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?= $lembur['id']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleNama" class="bmd-label-floating">Nama</label>
                                <input type="text" class="form-control disabled" id="nama" name="nama" value="<?= $lembur['nama']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleKategori" class="bmd-label-floating">Kategori</label>
                                <?php if ($lembur['kategori']=='OT'){
                                    echo '<input type="text" class="form-control disabled" id="kategori_lembur" name="kategori_lembur" value="LEMBUR">';
                                } elseif ($lembur['kategori']=='GH'){
                                    echo '<input type="text" class="form-control disabled" id="kategori_lembur" name="kategori_lembur" value="GANTI HARI">';
                                } elseif ($lembur['kategori']=='TC'){
                                    echo '<input type="text" class="form-control disabled" id="kategori_lembur" name="kategori_lembur" value="TABUNGAN CUTI">';
                                } ?>
                            </div>
                            <div class="form-group form-inline">
                                <label for="exampleDate" class="bmd-label-floating">Tanggal & Jam</label>
                                <input type="text" class="form-control disabled" id="tglmulai" name="tglmulai" value="<?= date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($lembur['tglselesai'])); ?>"> 
                            </div>
                            <div class="form-group">
                                <label for="exampleDurasi" class="bmd-label-floating">Durasi</label>
                                <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= $lembur['durasi']; ?> Jam">
                            </div>
                            <div class="form-group">
                                <label for="exampleLokasi" class="bmd-label-floating">Lokasi</label>
                                <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="<?= $lembur['lokasi']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleTul" class="bmd-label-floating">Estimasi TUL</label>
                                <input type="text" class="form-control" id="tul" name="tul" value="<?= $tul; ?>">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <?php if ($lembur['durasi']>=4 AND $jammulai < '12:00' AND $jamselesai > '13:00'){
                                            echo '<input class="form-check-input" type="checkbox" id="istirahat1" name="istirahat1" value="1" checked>';
                                    }else{
                                            echo '<input class="form-check-input" type="checkbox" id="istirahat1" name="istirahat1" value="1">';
                                    } ?>
                                    Istirahat Siang 1 JAM (12:00 - 13:00)
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <?php if ($lembur['durasi']>=4 AND $jammulai < '18:30' AND $jamselesai > '19:00'){
                                        echo '<input class="form-check-input" type="checkbox" id="istirahat2" name="istirahat2" value="0.5" checked>';
                                    }else{
                                        echo '<input class="form-check-input" type="checkbox" id="istirahat2" name="istirahat2" value="0.5">';
                                    } ?>
                                    Istirahat Malam 0,5 JAM (18:30 - 19:00)
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="istirahat3" name="istirahat3" value="1">
                                    Istirahat Malam 1 JAM
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="modal-footer justify-content-right">
                                <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                                <button type="submit" class="btn btn-success">PROSES</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Realisasi Aktivitas -->
<div class="modal fade" id="realisasiAktivitas" tabindex="-1" role="dialog" aria-labelledby="realisasiAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">UPDATE AKTIVITAS</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/update_aktivitas_realisasi'); ?>">
                    <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Lembur ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $lembur['id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">No Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Rencana aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="aktivitas" name="aktivitas">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Deskripsi Hasil</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" id="deskripsi_hasil" name="deskripsi_hasil" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                <?php
                                    $queryJam = "SELECT * FROM `jam`";
                                    $jam = $this->db->get_where('jam', ['id <=' => 4])->result_array();
                                    foreach ($jam as $j) : ?>
                                        <option value="+<?= $j['menit']; ?> minute"><?= $j['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">progres</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="progres_hasil" name="progres_hasil">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-success">SIMPAN</button>
                            <br>
                            <button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Aktivitas -->
<div class="modal fade" id="tambahAktivitas" tabindex="-1" role="dialog" aria-labelledby="tambahAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">AKTIVITAS LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/tambah_aktivitas_realisasi'); ?>">
                    <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Lembur ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $lembur['id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Kategori</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="kategori" id="kategori" data-style="select-with-transition" title="Pilih" data-size="3" required>
                                        <?php foreach ($kategori as $k) : ?>
                                            <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#kategori').change(function() {
                                    var kategori = $('#kategori').val();
                                    if (kategori >= 3) {
                                        $('#copro').prop('disabled', true);
                                    } else {
                                        $('#copro').prop('disabled', false);
                                    }
                                });
                            });
                        </script>
                        <div class="row">
                            <label class="col-md-4 col-form-label">COPRO</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="copro" id="copro" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <?php
                                        $queyCopro = "SELECT * FROM project where status='open' or status='teco' ";
                                        $copro = $this->db->query($queyCopro)->result_array();
                                        foreach ($copro as $c) : ?>
                                            <option data-subtext="<?= $c['deskripsi']; ?>" value="<?= $c['copro']; ?>"><?= $c['copro']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="aktivitas" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Deskripsi Hasil</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="deskripsi_hasil" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                    <?php
                                        $queryJam = "SELECT * FROM `jam`";
                                        $jam = $this->db->get_where('jam', ['id <=' => 4])->result_array();
                                        foreach ($jam as $j) : ?>
                                            <option value="+<?= $j['menit']; ?> minute"><?= $j['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Progres</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="progres_hasil" id="progres_hasil" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <option value="10">10 %</option>
                                        <option value="25">25 %</option>
                                        <option value="50">50 %</option>
                                        <option value="55">55 %</option>
                                        <option value="60">60 %</option>
                                        <option value="65">65 %</option>
                                        <option value="70">70 %</option>
                                        <option value="75">75 %</option>
                                        <option value="80">80 %</option>
                                        <option value="85">85 %</option>
                                        <option value="90">90 %</option>
                                        <option value="95">95 %</option>
                                        <option value="100">100 %</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-success">SIMPAN</button>
                            <br>
                            <button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Batal Aktivitas-->
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalAktivitasTitle" aria-hidden="true">
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
                <form class="form" method="post" action="<?= base_url('lembur/batal_lembur'); ?>">
                    <div class="modal-body">
                        <input type="hidden" class="form-control disabled" name="id">
                        <textarea rows="2" class="form-control" name="catatan" id="catatan" placeholder="Keterangan Pembatalan Lembur" required></textarea>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                        <button type="submit" class="btn btn-success">SUBMIT PEMBATALAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
      $('#submitLembur').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var aktivitas = button.data('aktivitas') // Extract info from data-* attributes
        var deskripsi_hasil = button.data('deskripsi_hasil') 
        var progres_hasil = button.data('progres_hasil') 
        var modal = $(this)
        modal.find('.modal-body input[name="id"]').val(id)
        modal.find('.modal-body input[name="aktivitas"]').val(aktivitas)
        modal.find('.modal-body textarea[name="deskripsi_hasil"]').val(deskripsi_hasil)
        modal.find('.modal-body input[name="progres_hasil"]').val(progres_hasil)
        });
    })
</script>