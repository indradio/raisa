<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 align-content-start">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">update</i>
                        </div>
                        <?php $status = $this->db->get_where('lembur_status', ['id' => $lembur['status']])->row_array(); ?>
                        <h4 class="card-title">Rencana - <?= $lembur['id'].' <small>('.$status['nama'].')</small>'; ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <?php if ($lembur['status'] == '1' AND $this->session->userdata('contract') == 'Direct Labor'){
                                echo '<a href="#" id="tambah_aktivitas" class="btn btn-facebook" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">Tambah Aktivitas</a>';
                            }elseif ($lembur['status'] == '1' AND $this->session->userdata('contract') == 'Indirect Labor'){
                                echo '<a href="#" id="tambah_aktivitas" class="btn btn-facebook" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitasIndirect">Tambah Aktivitas</a>';
                            }; ?>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Aktivitas</th>
                                        <th>Durasi <small>(Jam)</small></th>
                                        <?php if ($lembur['status'] == '1') { ?>
                                            <th class="disabled-sorting text-right">Actions</th>
                                        <?php }; ?>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Aktivitas</th>
                                        <th>Durasi <small>(Jam)</small></th>
                                        <?php if ($lembur['status'] == '1') { ?>
                                            <th class="disabled-sorting text-right">Actions</th>
                                        <?php }; ?>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($aktivitas as $a) : ?>
                                        <tr>
                                            <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                            <td><?= $k['nama']; ?>  <small>(<?= $a['copro']; ?>)</small></td>
                                            <td><?= $a['aktivitas']; ?></td>
                                            <td><?= $a['durasi']; ?> Jam</td>
                                            <?php if ($lembur['status'] == '1') { ?>
                                                <td class="text-right">
                                                    <a href="<?= base_url('lembur/hapus_aktivitas/') . $a['id']; ?>" class="badge badge-pill badge-danger btn-sm btn-bataldl">Batalkan</a>
                                                </td>
                                            <?php }; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div> 
                            </br>
                            <form class="form-horizontal" method="post" action="<?= base_url('lembur/ajukan_rencana'); ?>">
                            <!-- <div class="row"> -->
                                <?php if(empty($lembur['lokasi'])){ ?>
                                    <div class="form-group has-default">
                                        <input type="hidden" class="form-control" id="id" name="id" value="<?= $lembur['id']; ?>">
                                    </div>
                                    <label class="col-form-label">Tanggal & Jam</label>   
                                    <div class="form-group has-default form-inline">
                                        <input type="text" class="form-control disabled" id="tglmulai" name="tglmulai" value="<?= date('d M H:i', strtotime($lembur['tglmulai_rencana'])).date(' - H:i', strtotime($lembur['tglselesai_rencana'])); ?>">
                                        <a href="#" class="badge badge-pill badge-warning" data-toggle="modal" data-target="#ubhTanggal" data-id="<?= $lembur['id']; ?>">UBAH JAM</a>
                                    </div>
                                    <label class="col-form-label">Durasi</label>   
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= $lembur['durasi_rencana']; ?> Jam">
                                    </div>

                                    <label class="col-form-label">Kategori</label>
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="kategori_lembur" id="kategori_lembur" data-style="select-with-transition" title="Pilih Kategori" data-size="7" required>
                                            <option value="OT">Lembur</option>
                                            <option value="GH">Ganti Hari</option>
                                            <option value="TC">Tabungan Cuti</option>
                                        </select>
                                    </div>

                                    <label class="col-form-label">Lokasi</label>
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="lokasi" id="lokasi" data-style="select-with-transition" title="Pilih" data-size="5" data-live-search="true" onchange="admSelectCheck(this);" required>
                                            <option data-subtext="WORKSHOP FOR INDUSTRIAL EQUIPMENT" value="WTQ">WTQ</option>
                                            <?php 
                                            $queyCustomer = "SELECT * FROM customer ";
                                            $customer = $this->db->query($queyCustomer)->result_array();
                                            foreach ($customer as $c) : ?>
                                                <option data-subtext="<?= $c['nama']; ?>" value="<?= $c['inisial']; ?>"><?= $c['inisial']; ?></option>
                                            <?php endforeach; ?>
                                            <option data-subtext="Lokasi Lainnya" value="lainnya">LAINNYA</option>
                                        </select>
                                    </div>
                                
                                    <div class="form-group has-default" id="txtLokasi" style="display:none;">
                                        <input type="text" class="form-control" id="lokasi_lain" name="lokasi_lain" required>
                                    </div>

                                    <label class="col-form-label">Catatan</label>
                                    <div class="form-group has-default">
                                        <textarea rows="3" class="form-control" name="catatan" id="catatan"></textarea>
                                    </div>
                                <?php } else {?>
                                    <div class="form-group" hidden>
                                        <label for="exampleID" class="bmd-label-floating">ID</label>
                                        <input type="text" class="form-control" id="id" name="id" value="<?= $lembur['id']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleDate" class="bmd-label-floating">Tanggal & Jam</label>
                                        <input type="text" class="form-control disabled" id="tglmulai" name="tglmulai" value="<?= date('d M H:i', strtotime($lembur['tglmulai_rencana'])).date(' - H:i', strtotime($lembur['tglselesai_rencana'])); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleDurasi" class="bmd-label-floating">Durasi</label>
                                        <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= $lembur['durasi_rencana']; ?> Jam">
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
                                <?php }; ?>
                            
                        
                        </p>
                        <h4>Penting : </h4>
                        1. Durasi LEMBUR kamu termasuk <mark><b>JAM ISTIRAHAT</b></mark> pada saat lembur. 
                        <br>2. Untuk kamu <mark><b> DIRECT LABOR</b></mark>, Silahkan tambahkan istirahat ke dalam aktivitas <mark>(NON PROJEK -> Istirahat Siang / Malam)</mark>
                        <br>3. Untuk <b>GANTI HARI</b> atau <b>TABUNGAN CUTI</b> pastikan <b>DURASI 9 JAM</b> (Termasuk Istirahat) jika KURANG atau LEBIH maka tidak bisa dilakukan REALISASI!.
                        <br>4. Pastikan <b>JAM LEMBUR</b> kamu sesuai dengan <b>JAM PRESENSI</b> kamu ya!.
                        </p>
                        <!-- Button SUBMIT -->
                        <?php if ($lembur['status'] == 1 AND $lembur['aktivitas_rencana'] >= 1) {

                            if ($lembur['pemohon'] != $this->session->userdata('inisial')){
                                echo '<button type="submit" id="ajukan" class="btn btn-sm btn-success">TERIMA</button>';
                            } else {
                                echo '<button type="submit" id="ajukan" class="btn btn-sm btn-success">SUBMIT</button>';
                            }

                        } else { 
                            
                            echo '<button type="submit" id="ajukan" class="btn btn-sm btn-success disabled">SUBMIT</button>';
                        
                        } ?>
                        <!-- Button BATALKAN & KEMBALI -->
                            <a href="#" id="batalAktivitas" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                            <a href="<?= base_url('lembur/rencana/') ?>" class="btn btn-sm btn-default" role="button">KEMBALI</a>
                        </form>
                </div>
                <!-- end content-->
            </div>
            <!--  end card  -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
</div>
</div>
<!-- Modal -->
<!-- Tambah Aktivitas Direct -->
<div class="modal fade" id="tambahAktivitas" tabindex="-1" role="dialog" aria-labelledby="tambahAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">AKTIVITAS RENCANA LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/tambah_aktivitas'); ?>">
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
                                    <select class="selectpicker" name="kategori" id="kategori" title="Pilih" data-style="select-with-transition" data-size="5" data-width="fit" data-live-search="false" onchange="kategoriSelect(this);" required>
                                        <?php foreach ($kategori as $k) : ?>
                                            <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label" id="lblCopro" style="display:none;">Copro</label>
                            <div class="col-md-7" id="admCopro" style="display:none;">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="copro" id="copro" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                    <?php
                                        $queyCopro = "SELECT * FROM project where status ='open' or status='teco' ";
                                        $copro = $this->db->query($queyCopro)->result_array();
                                        foreach ($copro as $c) : ?>
                                            <option data-subtext="<?= $c['deskripsi']; ?>" value="<?= $c['copro']; ?>"><?= $c['copro']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label" id="lblAkt" style="display:none;">Aktivitas</label>
                            <div class="col-md-7" id="admLain" style="display:none;">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="aktivitas" id="akt_lain" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" required></select>
                                </div>
                            </div>
                            <!-- <div class="col-md-7" id="admAkt" style="display:none;"> -->
                            <div class="col-md-7" id="admAkt" style="display:none;">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="aktivitas" id="akt" required></textarea>
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
<div class="modal fade" id="tambahAktivitasIndirect" tabindex="-1" role="dialog" aria-labelledby="tambahAktivitasIndirectTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">AKTIVITAS RENCANA LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/tambah_aktivitas'); ?>">
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
                            <label class="col-md-4 col-form-label">Kategori</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="kategori" name="kategori" value="3">
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
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-success">TAMBAH</button>
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
                        <h4 class="card-title">PEMBATALAN LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/batal_lembur'); ?>">
                    <div class="modal-body">
                        <input type="hidden" class="form-control disabled" name="id">
                        <textarea rows="2" class="form-control" name="catatan" id="catatan" placeholder="Berikan penjelasan untuk membatalkan" required></textarea>
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
<!-- Modal Ubah Jam-->
<div class="modal fade" id="ubhTanggal" tabindex="-1" role="dialog" aria-labelledby="ubhTanggalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">UBAH JAM</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('lembur/gtJamRencana'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" hidden>
                                <label class="col-md-5 col-form-label">Lembur ID</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="id" name="id" value="<?= $lembur['id']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-5 col-form-label">Jam Mulai</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default" id="jammulai">
                                        <input type="text" class="form-control timepicker" id="jammulai" name="jammulai" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                            <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                            <button type="submit" class="btn btn-success">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
<script>
    function admSelectCheck(nameSelect)
    {
        var val = nameSelect.options[nameSelect.selectedIndex].value;
        // document.getElementById("lblLokasi").style.display = val == 'lainnya' ? "block" : 'none';
        document.getElementById("txtLokasi").style.display = val == 'lainnya' ? "block" : 'none';
    }
        $(document).ready(function() {
            $('#lokasi').change(function() {
                var lokasi = $('#lokasi').val();
                if (lokasi == 'lainnya') {
                    $('#lokasi_lain').prop('disabled', false);
                } else {
                    $('#lokasi_lain').prop('disabled', true);
                }
            });
        });
</script>

<!-- script ajax Kategori-->
<script type="text/javascript">
    function kategoriSelect(valueSelect)
            {
                var val = valueSelect.options[valueSelect.selectedIndex].value;
                document.getElementById("admLain").style.display = val != '1' ? "block" : 'none';
                document.getElementById("admCopro").style.display = val != '3' ? "block" : 'none';
                document.getElementById("admAkt").style.display = val == '1' ? "block" : 'none';
                document.getElementById("lblCopro").style.display = val != '3' ? "block" : 'none';
                document.getElementById("lblAkt").style.display = val != '0' ? "block" : 'none';
            }
        $('#kategori').change(function(){
            var kategori = $('#kategori').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/ajax')?>",
                data: {kategori:kategori},
                success: function(data) {
                    // alert(data)
                    $('#akt_lain').html(data); 
                    if(kategori == 1){
                        $('#copro').prop('disabled', false);
                        $('#akt').prop('disabled', false);
                        $('#akt_lain').prop('disabled', true);
                    }
                    else if(kategori == 2){
                        $('#copro').prop('disabled', false);
                        $('#akt_lain').prop('disabled', false);
                        $('#akt_lain').selectpicker('refresh');
                        $('#akt').prop('disabled', true);
                    }
                    else if(kategori == 3){
                        $('#copro').prop('disabled', true);
                        $('#akt_lain').prop('disabled', false);
                        $('#akt_lain').selectpicker('refresh');
                        $('#akt').prop('disabled', true);
                    }    
                }
            })
        })
        
    </script>