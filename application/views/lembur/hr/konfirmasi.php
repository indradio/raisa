<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <?php if ($lembur['kategori']!='OT' AND $lembur['durasi']!=9) { ?>
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
                        <h4 class="card-title">Approval - <?= $lembur['id']; ?></h4>
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
                                <input type="text" class="form-control disabled" id="tgl" name="tgl" value="<?= date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($lembur['tglselesai'])); ?>"> 
                                <button type="button" class="btn btn-success btn-link btn-just-icon" data-toggle="modal" data-target="#ubahTanggal" data-id="<?= $lembur['id']; ?>"><i class='material-icons'>manage_history</i></button>
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
                                <label for="exampleLokasi" class="bmd-label-floating">Lokasi</label>
                                <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="<?= $lembur['lokasi']; ?>">
                            </div>
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                                <!-- <a href="#" class="btn btn-rose mb" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">Tambah Aktivitas</a> -->
                            </div>
                            <div class="material-datatables">
                                <table id="dtaktivitas" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                        <tr>
                                            <th>Aktivitas</th>
                                            <th>Deskripsi</th>
                                            <th>Durasi <small>(Jam)</small></th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Aktivitas</th>
                                            <th>Deskripsi</th>
                                            <th>Durasi <small>(Jam)</small></th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="form-group">
                                <label for="exampleCatatan" class="bmd-label-floating">Catatan</label>
                                <textarea rows="3" class="form-control disabled" name="catatan" id="catatan"><?= $lembur['catatan']; ?></textarea>
                            </div>
                            <!-- Button SUBMIT -->
                            <button type="button" class="btn btn-success" id="btn_submit" data-toggle="modal" data-target="#submitLembur">VERIFIKASI</button>
                            <!-- Button BATALKAN & KEMBALI -->
                            <a href="#" id="batalAktivitas" class="btn btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                            <a href="<?= base_url('lembur/konfirmasi/hr') ?>" class="btn btn-link btn-default" role="button">Kembali</a>
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
                <form class="form-horizontal" method="post" action="<?= base_url('lembur/persetujuan_hr'); ?>">
                    <div class="card-body">
                        <div class="col-md-12 align-content-start">
                            </br>
                            <div class="form-group" hidden>
                                <label for="exampleID" class="bmd-label-static">ID</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?= $lembur['id']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Tanggal & Jam</label></br>
                                <input type="text" class="form-control disabled" id="tglmulai" name="tglmulai" value="<?= date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($lembur['tglselesai'])); ?>"> 
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Hari</label></br>
                                <select class="selectpicker" id="hari" name="hari" data-style="select-with-transition" data-width="fix" title="Select Contract" required>
                                                    <?php
                                                    $hari = $this->db->get('lembur_hari')->result();
                                                    foreach ($hari as $row) : echo '<option value="' . $row->nama . '"';
                                                        if ($row->nama == $lembur['hari']) {
                                                            echo 'selected';
                                                        }
                                                        echo '>' . $row->nama . '</option>' . "\n";
                                                    endforeach; ?>
                                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleDurasi" class="bmd-label-static">Durasi <small>(Jam)</small></label></br>
                                <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= $lembur['durasi']; ?>">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="istirahat1" name="istirahat1" value="1">
                                    Istirahat 1 JAM (12:00 - 13:00)
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                       <input class="form-check-input" type="checkbox" id="istirahat2" name="istirahat2" value="0.5">
                                    Istirahat 30 Menit (18:30 - 19:00)
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="istirahat3" name="istirahat3" value="1">
                                    Istirahat 1 JAM (Additional)
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            </br>
                            <div class="form-group">
                                <label for="exampleIstirahat" class="bmd-label-static">Istirahat <small>(Jam)</small></label></br>
                                <input type="text" class="form-control disabled" id="istirahat" name="istirahat" value="<?= $lembur['istirahat']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleTul" class="bmd-label-static">TUL</label></br>
                                <input type="text" class="form-control disabled" id="tul" name="tul" value="<?= $lembur['tul']; ?>">
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

<!-- Update Aktivitas -->
<div class="modal fade" id="updateAktivitas" tabindex="-1" role="dialog" aria-labelledby="updateAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form" method="post" action="#">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id_lembur" name="id_lembur">
                        <input type="hidden" class="form-control" id="id_aktivitas" name="id_aktivitas">
                        <div class="col-md-12 align-content-start">
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Aktivitas</label></br>
                                <textarea rows="3" class="form-control disabled" id="aktivitas" name="aktivitas"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Deskripsi</label></br>
                                <textarea rows="3" class="form-control" id="deskripsi_hasil" name="deskripsi_hasil" required></textarea>
                                <input type="hidden" class="form-control" id="progres_hasil" name="progres_hasil">
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Durasi</label></br>
                                <select class="selectpicker" name="durasi_aktivitas" id="durasi_aktivitas" data-style="select-with-transition" data-width="auto" required></select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                                <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                                <button type="button" class="btn btn-success" id="btn_update_aktivitas">UPDATE</button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hapus Aktivitas  -->
<div class="modal fade" id="hapusAktivitas" tabindex="-1" role="dialog" aria-labelledby="hapusAktivitasTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
      <form class="form" id="formhapusAktivitas" method="post" action="#">
          <div class="modal-body">
              <input type="hidden" class="form-control" id="id_lembur_hapus" name="id_lembur_hapus" />
              <input type="hidden" class="form-control" id="id_aktivitas_hapus" name="id_aktivitas_hapus" />
              <h4 class="card-title text-center">Yakin ingin membatalkan Aktivitas ini?</h4>
          </div>
          <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
              <button type="button" class="btn btn-danger" id="btn_hapus_aktivitas" >YA, BATALKAN!</button>
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

<!-- Modal Ubah Tanggal-->
<div class="modal fade" id="ubahTanggal" tabindex="-1" role="dialog" aria-labelledby="ubahTanggalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form-horizontal" id="formUbahTanggal" method="post" action="#">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id_lembur_tglmulai" name="id_lembur_tglmulai" />
                            <div class="col-md-12 align-content-start">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control datetimepicker" id="ubah_tglmulai" name="ubah_tglmulai" value="<?= date('Y-m-d H:i', strtotime($lembur['tglmulai']));?>" required>
                                </div>
                            </div>
                        <div class="modal-footer justify-content-right">
                            <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                            <button type="button" class="btn btn-success" id="btn_ubah_tglmulai">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        setFormValidation('#formUbahTanggal');
        $('#dtaktivitas').DataTable({
            "pagingType": "full_numbers",
            scrollX: true,
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            ajax: {
                    "url"   : "<?= site_url('lembur/get_aktivitas/hr') ?>",
                    "type"  : "POST",
                    "data"  : {id:$('#id').val()}
                },
            columns: [
                { "data": "aktivitas" },
                { "data": "deskripsi" },
                { "data": "durasi" },
                { "data": "action", className: "text-right" }
            ],
        });

        $('#updateAktivitas').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id_lembur = button.data('id_lembur') 
            var id_aktivitas = button.data('id_aktivitas') 
            var aktivitas = button.data('aktivitas') 
            var deskripsi_hasil = button.data('deskripsi_hasil')
            var progres_hasil = button.data('progres_hasil')
            var modal = $(this)
            modal.find('.modal-body input[name="id_lembur"]').val(id_lembur)
            modal.find('.modal-body input[name="id_aktivitas"]').val(id_aktivitas)
            modal.find('.modal-body textarea[name="aktivitas"]').val(aktivitas)
            modal.find('.modal-body textarea[name="deskripsi_hasil"]').val(deskripsi_hasil)
            modal.find('.modal-body input[name="progres_hasil"]').val(progres_hasil)

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/durasi_aktivitas') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#durasi_aktivitas').html(data);
                    $('#durasi_aktivitas').selectpicker('refresh');
                }
            })
        });

        $('#btn_update_aktivitas').on('click',function(){
            $('#deskripsi_hasil').prop('required', true);
            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/aktivitas/realisasi/update_hr') ?>",
                dataType : "JSON",
                data : {
                    id:$('#id_lembur').val(), 
                    id_aktivitas:$('#id_aktivitas').val(), 
                    deskripsi:$('#deskripsi_hasil').val(), 
                    progres:$('#progres_hasil').val(), 
                    durasi:$('#durasi_aktivitas').val()
                },
                success: function(result){

                    $('#updateAktivitas').modal('hide');
                    $('#tgl').val(result['data']['tgl']);
                    $('#tglmulai').val(result['data']['tgl']);
                    $('#durasi').val(result['data']['durasi']);
                    $('#istirahat').val(result['data']['istirahat']);
                    $('#tul').val(result['data']['tul']);
                    $('#dtaktivitas').DataTable().ajax.reload();

                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Aktivitas telah diperbaharui."
                    }, {
                        type: "success",
                        timer: 2000,
                        placement: {
                        from: "top",
                        align: "center"
                        }
                    });
                },
                error: function(result){
                    $.notify({
                            icon: "add_alert",
                            message: "<b>GAGAL!</b> Data gagal tersimpan."
                        }, {
                            type: "danger",
                            timer: 2000,
                            placement: {
                            from: "top",
                            align: "center"
                            }
                        });
                }
            });
            return false;
        });

        // Hapus AKtivitas 
        $('#hapusAktivitas').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id_lembur = button.data('id_lembur') 
            var id_aktivitas = button.data('id_aktivitas') 
            var modal = $(this)
            modal.find('.modal-body input[name="id_lembur_hapus"]').val(id_lembur);
            modal.find('.modal-body input[name="id_aktivitas_hapus"]').val(id_aktivitas);
        });

        $('#btn_hapus_aktivitas').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/aktivitas/realisasi/hapus_hr') ?>",
                dataType : "JSON",
                data : {id:$('#id_lembur_hapus').val(), id_aktivitas:$('#id_aktivitas_hapus').val()},
                success: function(result){

                    $('#hapusAktivitas').modal('hide');
                    $('#tgl').val(result['data']['tgl']);
                    $('#tglmulai').val(result['data']['tgl']);
                    $('#durasi').val(result['data']['durasi']);
                    $('#istirahat').val(result['data']['istirahat']);
                    $('#tul').val(result['data']['tul']);
                    $('#dtaktivitas').DataTable().ajax.reload();

                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Aktivitas telah dihapus."
                    }, {
                        type: "success",
                        timer: 2000,
                        placement: {
                        from: "top",
                        align: "center"
                        }
                    });
                },
                error: function(result){
                    $.notify({
                            icon: "add_alert",
                            message: "<b>GAGAL!</b> Data gagal tersimpan."
                        }, {
                            type: "danger",
                            timer: 2000,
                            placement: {
                            from: "top",
                            align: "center"
                            }
                        });
                }
            });
            return false;
        });

        $('#submitLembur').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/hari') ?>",
                data: {
                    id:$('#id').val()
                },
                success: function(data) {
                    // alert(data)
                    $('#hari').html(data);
                    $('#hari').selectpicker('refresh');
                }
            })
            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/count/istirahat') ?>",
                dataType : "JSON",
                data: {
                    id:$('#id').val()
                },
                success: function(result) {
                    // alert(data)
                    if (result['data']['istirahat1']>0){
                        $('#istirahat1').prop('checked',true);
                    }else{
                        $('#istirahat1').prop('checked',false);
                    };
                    if (result['data']['istirahat2']>0){
                        $('#istirahat2').prop('checked',true);
                    }else{
                        $('#istirahat2').prop('checked',false);
                    };
                    if (result['data']['istirahat3']>0){
                        $('#istirahat3').prop('checked',true);
                    }else{
                        $('#istirahat3').prop('checked',false);
                    };
                    $('#istirahat').val(result['data']['istirahat']);
                    $('#tul').val(result['data']['tul']);
                }
            });
        });

        $('#hari').change(function() {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/count/hari') ?>",
                dataType : "JSON",
                data: {
                    id:$('#id').val(), hari:$('#hari').val()
                },
                success: function(result){
                    $('#tul').val(result['data']['tul']);
                },
            });
            return false;
        });

        var istirahat1 = document.getElementById('istirahat1');
        var istirahat2 = document.getElementById('istirahat2');
        var istirahat3 = document.getElementById('istirahat3');

        // when unchecked or checked, run the function
        istirahat1.onchange = function() {
            if (this.checked) {
                var istirahat1 = 1;
            } else {
                var istirahat1 = 0 ;
            }

            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/count/istirahat1') ?>",
                dataType : "JSON",
                data : {id:$('#id').val(), istirahat1:istirahat1},
                success: function(result){
                    $('#istirahat').val(result['data']['istirahat']);
                    $('#tul').val(result['data']['tul']);
                },
            });
            return false;
        }
        istirahat2.onchange = function() {
            if (this.checked) {
                var istirahat2 = 0.5;
            } else {
                var istirahat2 = 0 ;
            }

            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/count/istirahat2') ?>",
                dataType : "JSON",
                data : {id:$('#id').val(), istirahat2:istirahat2},
                success: function(result){
                    $('#istirahat').val(result['data']['istirahat']);
                    $('#tul').val(result['data']['tul']);
                },
            });
            return false;
        }
        istirahat3.onchange = function() {
            if (this.checked) {
                var istirahat3 = 1;
            } else {
                var istirahat3 = 0 ;
            }

            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/count/istirahat3') ?>",
                dataType : "JSON",
                data : {id:$('#id').val(), istirahat3:istirahat3},
                success: function(result){
                    $('#istirahat').val(result['data']['istirahat']);
                    $('#tul').val(result['data']['tul']);
                },
            });
            return false;
        }

        // Hapus AKtivitas 
        $('#ubahTanggal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') 
            var modal = $(this)
            modal.find('.modal-body input[name="id_lembur_tglmulai"]').val(id);
        });

        $('#btn_ubah_tglmulai').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/ubah_jam/konfirmasi_hr') ?>",
                dataType : "JSON",
                data : {id:$('#id_lembur_tglmulai').val(), tglmulai:$('#ubah_tglmulai').val()},
                success: function(result){

                    $('#ubahTanggal').modal('hide');
                    $('#tgl').val(result['data']['tgl']);
                    $('#tglmulai').val(result['data']['tgl']);

                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Jam berhasil diubah."
                    }, {
                        type: "success",
                        timer: 2000,
                        placement: {
                        from: "top",
                        align: "center"
                        }
                    });
                },
                error: function(result){
                    $.notify({
                            icon: "add_alert",
                            message: "<b>GAGAL!</b> Data gagal tersimpan."
                        }, {
                            type: "danger",
                            timer: 2000,
                            placement: {
                            from: "top",
                            align: "center"
                            }
                        });
                }
            });
            return false;
        });
    });
</script>