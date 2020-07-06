<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <?php if ($jamkerja['status'] == 0) { ?>
        <?php if ($jamkerja['rev'] == 1) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>LAPORAN JAM KERJA ini membutuhkan REVISI,</strong>
                </br>
            </div>
        <?php } ?>
        <?php if ($jamkerja['catatan']) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Catatan dari ATASAN,</strong>
                </br>
                <?= $jamkerja['catatan']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
        <?php if ($jamkerja['catatan_ppic']) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Catatan dari PPIC,</strong>
                </br>
                <?= $jamkerja['catatan_ppic']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
    <?php } elseif ($jamkerja['status'] == 1) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Terimakasih, kamu sudah melaporkan Jam Kerja</strong>
            <?php if ($this->session->userdata('posisi_id') > 6) { ?>
                </br>
                <small>Laporan Jam Kerja kamu sedang diperiksa oleh <?= $jamkerja['atasan1']; ?></small>
            <?php } ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } elseif ($jamkerja['status'] == 2) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Terimakasih, kamu sudah melaporkan Jam Kerja</strong>
            </br>
            <small>Laporan Jam Kerja kamu sedang diperiksa oleh PPIC</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } else { ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Yeayy, Laporan Jam Kerja kamu sudah disetujui</strong>
            </br>
            <small>Laporan Jam Kerja kamu sudah diperiksa oleh Atasan & PPIC</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Laporan Kerja Harian <?= $jamkerja['shift']; ?>
                            <small> - <?= date("d M Y", strtotime($jamkerja['tglmulai'])); ?></small>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <?php if ($jamkerja['id']) {
                                if ($jamkerja['status'] != 9) {
                                    $link = $jamkerja['id'];
                                    $durasi = $jamkerja['durasi'];

                                    $this->db->select_sum('durasi');
                                    $this->db->where('link_aktivitas', $link);
                                    $this->db->where('jenis_aktivitas', 'JAM KERJA');
                                    $this->db->where('kategori', '1');
                                    $query1 = $this->db->get('aktivitas');
                                    $kategori1 = $query1->row()->durasi;
                                    $bar1 = $kategori1 * 12.5;

                                    $this->db->select_sum('durasi');
                                    $this->db->where('link_aktivitas', $link);
                                    $this->db->where('jenis_aktivitas', 'JAM KERJA');
                                    $this->db->where('kategori', '2');
                                    $query2 = $this->db->get('aktivitas');
                                    $kategori2 = $query2->row()->durasi;
                                    $bar2 = $kategori2 * 12.5;

                                    $this->db->select_sum('durasi');
                                    $this->db->where('link_aktivitas', $link);
                                    $this->db->where('jenis_aktivitas', 'JAM KERJA');
                                    $this->db->where('kategori', '3');
                                    $query3 = $this->db->get('aktivitas');
                                    $kategori3 = $query3->row()->durasi;
                                    $bar3 = $kategori3 * 12.5;

                                    if ($durasi < 4) {
                                        $sisadurasi = 4;
                                    } else {
                                        if ($jamkerja['shift']=='SHIFT1'){
                                            $sisadurasi = 6 - $durasi;
                                        }elseif ($jamkerja['shift']=='SHIFT2'){
                                            $sisadurasi = 8 - $durasi;
                                        }elseif ($jamkerja['shift']=='SHIFT3'){
                                            $sisadurasi = 7 - $durasi;
                                        }
                                    }
                                    $jam = $this->db->get_where('jam', ['id <=' =>  $sisadurasi])->result();
                                    ?>
                                    <div class="progress" style="width: 100%">
                                        <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $bar1 . '%'; ?>" aria-valuenow="<?= $kategori1; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                                        <div class="progress-bar progress-bar-warning" role="progressbar" style="width: <?= $bar2 . '%'; ?>" aria-valuenow="<?= $kategori2; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                                        <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $bar3 . '%'; ?>" aria-valuenow="<?= $kategori3; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                                    </div>

                                    <?php if ($jamkerja['shift']=='SHIFT1' and $durasi < 6.0) { ?>
                                        <a href="#" class="btn btn-facebook mb-2" role="button" data-toggle="modal" data-target="#aktivitasModal" data-id="<?= $jamkerja['id']; ?>" aria-disabled="false">TAMBAH AKTIVITAS JAM KERJA</a>
                                    <?php }elseif ($jamkerja['shift']=='SHIFT2' and $durasi < 8.0){ ?>
                                        <a href="#" class="btn btn-facebook mb-2" role="button" data-toggle="modal" data-target="#aktivitasModal" data-id="<?= $jamkerja['id']; ?>" aria-disabled="false">TAMBAH AKTIVITAS JAM KERJA</a>
                                    <?php }elseif ($jamkerja['shift']=='SHIFT3' and $durasi < 7.0){ ?>
                                        <a href="#" class="btn btn-facebook mb-2" role="button" data-toggle="modal" data-target="#aktivitasModal" data-id="<?= $jamkerja['id']; ?>" aria-disabled="false">TAMBAH AKTIVITAS JAM KERJA</a>
                                    <?php }; ?>
                        </div>
                        <div class="material-datatables">
                        <?php } else { ?>
                        </div>
                        <div class="material-datatables disabled">
                        <?php }; ?>
                    <?php } else { ?>
                        <form class="form" method="post" action="<?= base_url('jamkerja/add_jamkerja_tanggal'); ?>">
                            <input type="text" id="tanggal" name="tanggal" class="form-control" value="<?php $tanggal; ?>" />
                            <button type="submit" class="btn btn-lg btn-block btn-youtube mb-2" role="button" aria-disabled="false"><?php $tanggal; ?>BUAT LAPORAN JAM KERJA</button>
                        </form>
                        </div>
                        <div class="material-datatables disabled">
                        <?php }; ?>
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Aktivitas</th>
                                    <th>Deskripsi</th>
                                    <th>Durasi (Jam)</th>
                                    <th>Hasil (%)</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Aktivitas</th>
                                    <th>Deskripsi</th>
                                    <th>Durasi</th>
                                    <th>Hasil</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $aktivitas = $this->db->get_where('aktivitas', ['link_aktivitas' => $jamkerja['id']])->result_array();
                                foreach ($aktivitas as $a) : ?>
                                    <tr>
                                        <?php $katgr = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                        <td><?= $katgr['nama']; ?> <small>(<?= $a['copro']; ?>)</small></td>
                                        <td><?= $a['aktivitas']; ?></td>
                                        <td><?= $a['deskripsi_hasil']; ?></td>
                                        <td><?= $a['durasi']; ?></td>
                                        <td><?= $a['progres_hasil']; ?></td>
                                        <td class="text-right">
                                            <a href="#" class="badge badge-pill badge-danger" data-toggle="modal" data-target="#batalAktivitasModal" data-id="<?= $a['id']; ?>">BATAL</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <!-- <div class="row"> -->
                        <p> Perhatikan hal-hal berikut :
                            </br> 1. Laporan Kerja Harian kamu akan otomatis ter-submit jika durasi sudah 8 Jam Kerja untuk shift 1.
                            </br> 2. Laporan Kerja Harian kamu akan otomatis ter-submit jika durasi sudah 7 Jam Kerja untuk shift 2.
                            </br> 3. Istirahat Siang hanya untuk aktivitas lembur, tidak untuk Laporan Kerja Harian.
                            <!-- </div> -->
                            </br>
                            </br>
                            <a href="<?= base_url('jamkerja'); ?>" class="btn btn-reddit mb-2" role="button" aria-disabled="false">KEMBALI</a>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<!-- Modal -->
<div class="modal fade" id="aktivitasModal" tabindex="-1" role="dialog" aria-labelledby="aktivitasModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Aktivitas Kerja</h4>
                    </div>
                </div>
                <form id="Aktivitas" class="form" method="post" action="<?= base_url('jamkerja/add_aktivitas'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group" hidden="true">
                                <label for="id">id</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?= $jamkerja['id']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori*</label>
                                <select class="form-control selectpicker" name="kategori" id="kategori" title="Pilih Kategori" data-style="btn btn-link" data-size="3" data-live-search="false" onchange="kategoriSelect(this);" required>
                                    <?php foreach ($kategori as $row) {
                                        echo '<option value="' . $row->id . '">' . $row->nama . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group" id="copro_0" style="display:none;">
                                <label for="copro">Project*</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="copro" name="copro" title="Pilih Project" data-size="5" data-live-search="true" required>
                                    <?php
                                    foreach ($project as $row) {
                                        echo '<option value="' . $row->copro . '">' . $row->copro . ' - ' . substr($row->deskripsi, -25) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group" id="aktivitas_23" style="display:none;">
                                <label for="aktivitas">Aktivitas*</label>
                                <!-- Aktivitas Lain-lain Project & Non Project -->
                                <select class="form-control selectpicker" id="aktivitas_lain" name="aktivitas" data-style="btn btn-link" title="Pilih Aktivitas" data-size="7"></select>
                            </div>
                            <div class="form-group" id="aktivitas_1" style="display:none;">
                                <label for="aktivitas">Aktivitas*</label>
                                <!-- Aktivitas Project -->
                                <textarea class="form-control has-success" id="aktivitas" name="aktivitas" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi <small><i>(Opsional)</i></small></label>
                                <textarea class="form-control has-success" id="deskripsi" name="deskripsi" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="durasi">Durasi*</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="durasi" name="durasi" title="Pilih Durasi" data-size="5" required>
                                    <?php
                                    foreach ($jam as $row) {
                                        echo '<option value="' . $row->id . '">' . $row->nama . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="progres_hasil">Hasil*</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="progres_hasil" name="progres_hasil" title="Pilih Hasil" required>
                                    <option value="100">100%</option>
                                    <option value="90">90%</option>
                                    <option value="75">75%</option>
                                    <option value="50">50%</option>
                                    <option value="25">25%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-facebook btn-round">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="batalAktivitasModal" tabindex="-1" role="dialog" aria-labelledby="batalAktivitasModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="batalAktivitasModalLabel">Kamu yakin ingin membatalkan aktivitas ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('jamkerja/batal_aktivitas'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <label for="id">id</label>
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-danger">YA, BATALKAN!</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function kategoriSelect(valueSelect) {
        var val = valueSelect.options[valueSelect.selectedIndex].value;

        // document.getElementById("aktivitas_1").style.display = val == '1' ? "block" : 'none';
        if (val === '1') {
            document.getElementById("aktivitas_1").style.display = "block";
        } else {
            document.getElementById("aktivitas_1").style.display = "none";
        }
        document.getElementById("aktivitas_23").style.display = val != '1' ? "block" : 'none';
        document.getElementById("copro_0").style.display = val != '3' ? "block" : 'none';
    }
    $('#kategori').change(function() {
        var kategori = $('#kategori').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('jamkerja/ajax') ?>",
            data: {
                kategori: kategori
            },
            success: function(data) {
                // alert(data)
                $('#aktivitas_lain').html(data);
                if (kategori == 1) {
                    $('#copro').prop('disabled', false);
                    $('#copro').prop('required', true);
                    $('#aktivitas').prop('disabled', false);
                    $('#aktivitas').prop('required', true);
                    $('#aktivitas_lain').prop('disabled', true);
                } else if (kategori == 2) {
                    $('#copro').prop('disabled', false);
                    $('#copro').prop('required', true);
                    $('#aktivitas_lain').prop('disabled', false);
                    $('#aktivitas_lain').selectpicker('refresh');
                    $('#aktivitas_lain').prop('required', true);
                    $('#aktivitas').prop('disabled', true);
                } else if (kategori == 3) {
                    $('#copro').prop('disabled', true);
                    $('#aktivitas_lain').prop('disabled', false);
                    $('#aktivitas_lain').selectpicker('refresh');
                    $('#aktivitas_lain').prop('required', true);
                    $('#aktivitas').prop('disabled', true);
                }
            }
        })
    })

    $(document).ready(function() {
        $('#aktivitasModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        })

        $('#batalAktivitasModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        })
    });
</script>