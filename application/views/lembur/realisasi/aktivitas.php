<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
                        <h4 class="card-title">Realisasi</h4>
                    </div>
                    <div class="card-body">
                    <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                                <?php if ($lembur['status'] == '4' AND $this->session->userdata('contract') == 'Direct Labor'){
                                    echo '<a href="#" id="tambah_aktivitas" class="btn btn-facebook" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitasDirect" data-id="'.$lembur['id'].'">Tambah Aktivitas</a>';
                                }else{
                                    echo '<a href="#" id="tambah_aktivitas" class="btn btn-facebook" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas" data-id="'.$lembur['id'].'">Tambah Aktivitas</a>';
                                }; ?>
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
                        </br>
                        <form class="form" method="post" action="<?= base_url('lembur/realisasi/submit'); ?>">
                            <div class="form-group" hidden>
                                <label for="exampleID" class="bmd-label-floating">ID</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?= $lembur['id']; ?>">
                            </div>
                            <div class="form-group form-inline">
                                <label for="exampleDate" class="bmd-label-floating">Tanggal & Jam</label>
                                <input type="text" class="form-control disabled" id="tgl" name="tgl" value="<?= date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($lembur['tglselesai'])); ?>"> 
                                <a href="#" class="badge badge-pill badge-warning" data-toggle="modal" data-target="#ubahJam" data-id="<?= $lembur['id']; ?>">UBAH JAM</a>
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
                            </br>
                            </p>
                            <h4>Penting : </h4>
                            1. Durasi LEMBUR kamu termasuk <mark><b>JAM ISTIRAHAT</b></mark> pada saat lembur. 
                            <br>2. Untuk kamu <mark><b> DIRECT LABOR</b></mark>, Silahkan tambahkan istirahat ke dalam aktivitas <mark>(NON PROJEK -> Istirahat Siang / Malam)</mark>
                            <br>3. Pastikan semua aktivitas sudah <mark><b>DIREALISASI</b></mark> atau aktivitas kamu akan terhapus.
                            <br>4. Untuk <b>GANTI HARI</b> atau <b>TABUNGAN CUTI</b> pastikan <b>DURASI 9 JAM</b> (Termasuk Istirahat) jika KURANG atau LEBIH maka tidak bisa dilakukan REALISASI!.
                            <br>5. Pastikan <b>JAM LEMBUR</b> kamu sesuai dengan <b>JAM PRESENSI</b> kamu ya!.
                            </p>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="check" name="check" value="1" required>
                                    Ya, Saya setuju dengan ketentuan di atas.
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            </p>
                            <!-- Button SUBMIT -->
                            <button type="submit" id="submit" class="btn btn-sm btn-success">SUBMIT</button>';
                                <!-- Button BATALKAN & KEMBALI -->
                            <a href="#" id="batalAktivitas" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                            <a href="<?= base_url('lembur/realisasi/') ?>" class="btn btn-sm btn-default" role="button">Kembali</a>
                        </form>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
</div>
<!-- Modal -->
<!-- Realisasi Aktivitas -->
<div class="modal fade" id="updateAktivitas" tabindex="-1" role="dialog" aria-labelledby="updateAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form" method="post" action="#">
                    <div class="modal-body">
                    <input type="hidden" class="form-control" id="id_lembur_update" name="id_lembur_update" />
                    <input type="hidden" class="form-control" id="id_aktivitas_update" name="id_aktivitas_update" />
                    <div class="col-md-12 align-content-start">
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Aktivitas</label></br>
                                <textarea rows="3" class="form-control disabled" id="aktivitas_update" name="aktivitas_update" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Deskripsi*</label></br>
                                <textarea rows="5" class="form-control" id="deskripsi_update" name="deskripsi_update" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Progres</label></br>
                                <select class="selectpicker" name="progres_update" id="progres_update" data-style="select-with-transition" data-width="auto" data-size="5" required>
                                <?php for ($i = 0; $i <= 100; $i=$i+10) {
                                    echo '<option value="'. $i.'">'.$i.'%</option>';
                                } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Durasi</label></br>
                                <select class="selectpicker" name="durasi_aktivitas_update" id="durasi_aktivitas_update" data-style="select-with-transition" data-width="auto" required>
                                <?php
                                        $jam = $this->db->get_where('jam', ['jam <=' => 4])->result();
                                        foreach ($jam as $row) :
                                            echo '<option value="'. $row->jam.'">'.$row->nama.'</option>';
                                        endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                                <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                                <button type="button" class="btn btn-success btn-block" id="btn_update_aktivitas">SIMPAN</button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Aktivitas Indirect-->
<div class="modal fade" id="tambahAktivitas" tabindex="-1" role="dialog" aria-labelledby="tambahAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form" method="post" action="#">
                <div class="modal-body">
                        <input type="hidden" class="form-control" id="id_lembur_tambah" name="id_lembur_tambah" />
                        <div class="col-md-12 align-content-start">
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Aktivitas*</label></br>
                                <textarea rows="3" class="form-control" id="aktivitas_tambah" name="aktivitas_tambah" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Deskripsi*</label></br>
                                <textarea rows="5" class="form-control" id="deskripsi_tambah" name="deskripsi_tambah" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Progres*</label></br>
                                <select class="selectpicker" name="progres_tambah" id="progres_tambah" data-style="select-with-transition" data-width="auto" data-size="5" required>
                                <?php for ($i = 0; $i <= 100; $i=$i+10) {
                                    echo '<option value="'. $i.'">'.$i.'%</option>';
                                } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Durasi*</label></br>
                                <select class="selectpicker" name="durasi_aktivitas_tambah" id="durasi_aktivitas_tambah" data-style="select-with-transition" data-width="auto" required>
                                <?php
                                        $jam = $this->db->get_where('jam', ['jam <=' => 4])->result();
                                        foreach ($jam as $row) :
                                            echo '<option value="'. $row->jam.'">'.$row->nama.'</option>';
                                        endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                            <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                            <button type="button" class="btn btn-success btn-block" id="btn_tambah_aktivitas">SIMPAN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Aktivitas Direct -->
<div class="modal fade" id="tambahAktivitasDirect" tabindex="-1" role="dialog" aria-labelledby="tambahAktivitasDirectTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form" method="post" action="#">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id_lembur_direct" name="id_lembur_direct" />
                        <div class="col-md-12 align-content-start">
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Kategori</label></br>
                                    <select class="selectpicker" name="kategori" id="kategori" title="Pilih" data-style="select-with-transition" data-size="5" data-width="fit" data-live-search="false" onchange="kategoriSelect(this);" required>
                                        <?php 
                                        $kategori = $this->db->get('jamkerja_kategori')->result();
                                        foreach ($kategori as $row) : 
                                            echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                                        endforeach; ?>
                                    </select>
                            </div>
                            <div class="form-group" id="selectAktivitas" style="display:none;">
                                <label for="exampleDate" class="bmd-label-static">Aktivitas</label></br>
                                    <select class="selectpicker" id="aktivitas_direct" name="aktivitas_direct" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" required></select>
                            </div>
                            <div class="form-group" id="textAktivitas" style="display:none;">
                                <label for="exampleDate" class="bmd-label-static">Aktivitas</label></br>
                                <textarea rows="3" class="form-control" id="aktivitas_projek" name="aktivitas_projek" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Deskripsi*</label></br>
                                <textarea rows="5" class="form-control" id="deskripsi_direct" name="deskripsi_direct" required></textarea>
                            </div>
                            <div class="form-group" id="selectCopro" style="display:none;">
                                <label for="exampleDate" class="bmd-label-static">COPRO</label></br>
                                    <select class="selectpicker" name="copro" id="copro" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <?php 
                                        $copro = $this->db->get_where('project', ['status !=' => 'CLOSED'])->result();
                                        foreach ($copro as $row) :
                                            echo '<option data-subtext="'. $row->deskripsi.'" value="'. $row->copro.'">'. $row->copro.'</option>';
                                        endforeach; ?>
                                    </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Progres*</label></br>
                                <select class="selectpicker" name="progres_direct" id="progres_direct" data-style="select-with-transition" data-width="auto" data-size="5" required>
                                <?php for ($i = 0; $i <= 100; $i=$i+10) {
                                    echo '<option value="'. $i.'">'.$i.'%</option>';
                                } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Durasi</label></br>
                                <select class="selectpicker" name="durasi_aktivitas_direct" id="durasi_aktivitas_direct" data-style="select-with-transition" data-width="auto" required>
                                <?php
                                        $jam = $this->db->get_where('jam', ['jam <=' => 4])->result();
                                        foreach ($jam as $row) :
                                            echo '<option value="'. $row->jam.'">'.$row->nama.'</option>';
                                        endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                                <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                                <button type="button" class="btn btn-success btn-block" id="btn_tambah_aktivitas_direct">SIMPAN</button>
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

<!-- Modal Ubah Jam-->
<div class="modal fade" id="ubahJam" tabindex="-1" role="dialog" aria-labelledby="ubahJamTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form-horizontal" method="post" action="#">
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="hidden" class="form-control" id="id_lembur_tglmulai" name="id_lembur_tglmulai" value="<?= $lembur['id']; ?>">
                            <div class="row">
                                <label class="col-md-5 col-form-label">Jam Mulai</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control timepicker" id="jammulai" name="jammulai" />
                                    </div>
                                <small>Untuk lembur hari ini, Jam mulai harus lebih besar dari jam sekarang!</small>
                                </div>
                            </div>
                            <div class="row">
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

<!-- script ajax Kategori-->
<script type="text/javascript">
    function kategoriSelect(valueSelect)
    {
        var val = valueSelect.options[valueSelect.selectedIndex].value;
        document.getElementById("selectCopro").style.display = val != '3' ? "block" : 'none';
        document.getElementById("selectAktivitas").style.display = val != '1' ? "block" : 'none';
        document.getElementById("textAktivitas").style.display = val == '1' ? "block" : 'none';
    };

    $(document).ready(function(){
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
                    "url"   : "<?= site_url('lembur/get_aktivitas/realisasi') ?>",
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
        // Update 
        $('#updateAktivitas').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id_lembur = button.data('id_lembur') 
            var id_aktivitas = button.data('id_aktivitas') 
            var aktivitas = button.data('aktivitas') 
            var deskripsi = button.data('deskripsi') 
            var modal = $(this)
            modal.find('.modal-body input[name="id_lembur_update"]').val(id_lembur);
            modal.find('.modal-body input[name="id_aktivitas_update"]').val(id_aktivitas);
            modal.find('.modal-body textarea[name="aktivitas_update"]').val(aktivitas);
            modal.find('.modal-body textarea[name="deskripsi_update"]').val(deskripsi);

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/progres_aktivitas') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#progres_update').html(data);
                    $('#progres_update').selectpicker('refresh');
                }
            })

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/durasi_aktivitas') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#durasi_aktivitas_update').html(data);
                    $('#durasi_aktivitas_update').selectpicker('refresh');
                }
            })
        });
        $('#btn_update_aktivitas').on('click',function(){
            $('#deskripsi_update').prop('required', true);
            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/aktivitas/realisasi/update') ?>",
                dataType : "JSON",
                data : {id:$('#id_lembur_update').val(), id_aktivitas:$('#id_aktivitas_update').val(), deskripsi:$('#deskripsi_update').val(), progres:$('#progres_update').val(), durasi:$('#durasi_aktivitas_update').val()},
                success: function(result){

                    $('#updateAktivitas').modal('hide');
                    $('#tgl').val(result['data']['tgl']);
                    $('#durasi').val(result['data']['durasi']);
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
        // Tambah Non Direct 
        $('#tambahAktivitas').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') 
            var modal = $(this)
            modal.find('.modal-body input[name="id_lembur_tambah"]').val(id);
            $('#aktivitas_tambah').prop('required', true);
        });

        $('#tambahAktivitas').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
            $('#progres_tambah').selectpicker('refresh');
            $('#durasi_aktivitas_tambah').selectpicker('refresh');
            $('#aktivitas_tambah').prop('required', false);
        });

        $('#btn_tambah_aktivitas').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/aktivitas/realisasi/tambah') ?>",
                dataType : "JSON",
                data : { 
                    id:$('#id_lembur_tambah').val(), 
                    aktivitas:$('#aktivitas_tambah').val(), 
                    deskripsi:$('#deskripsi_tambah').val(), 
                    progres:$('#progres_tambah').val(),
                    durasi:$('#durasi_aktivitas_tambah').val()
                },
                success: function(result){

                    $('#tambahAktivitas').modal('hide');
                    $('#tgl').val(result['data']['tgl']);
                    $('#durasi').val(result['data']['durasi']);
                    $('#dtaktivitas').DataTable().ajax.reload();

                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Aktivitas telah ditambahkan."
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
        // Tambah Direct 
        $('#tambahAktivitasDirect').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') 
            var modal = $(this)
            modal.find('.modal-body input[name="id_lembur_direct"]').val(id);
            $('#deskripsi_tambah').prop('required', true);
        });

        $('#tambahAktivitasDirect').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
            $('#kategori').selectpicker('refresh');
            $('#aktivitas_direct').selectpicker('refresh');
            $('#deskripsi_direct').selectpicker('refresh');
            $('#copro').selectpicker('refresh');
            $('#progres_direct').selectpicker('refresh');
            $('#durasi_aktivitas_direct').selectpicker('refresh');
            document.getElementById("selectCopro").style.display = 'none';
            document.getElementById("selectAktivitas").style.display = 'none';
            document.getElementById("textAktivitas").style.display = 'none';
            $('#deskripsi_direct').prop('required', false);
        });

        $('#btn_tambah_aktivitas_direct').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/aktivitas/realisasi/tambah') ?>",
                dataType : "JSON",
                data : {
                    id:$('#id_lembur_direct').val(), 
                    kategori:$('#kategori').val(), 
                    aktivitas_direct:$('#aktivitas_direct').val(), 
                    aktivitas_projek:$('#aktivitas_projek').val(), 
                    deskripsi:$('#deskripsi_direct').val(), 
                    copro:$('#copro').val(), 
                    progres:$('#progres_direct').val(),
                    durasi:$('#durasi_aktivitas_direct').val()},

                success: function(result){

                    $('#tambahAktivitasDirect').modal('hide');
                    $('#tgl').val(result['data']['tgl']);
                    $('#durasi').val(result['data']['durasi']);
                    $('#dtaktivitas').DataTable().ajax.reload();

                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Aktivitas telah ditambahkan."
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
                url  : "<?= site_url('lembur/aktivitas/realisasi/hapus') ?>",
                dataType : "JSON",
                data : {id:$('#id_lembur_hapus').val(), id_aktivitas:$('#id_aktivitas_hapus').val()},
                success: function(result){

                    $('#hapusAktivitas').modal('hide');
                    $('#tgl').val(result['data']['tgl']);
                    $('#durasi').val(result['data']['durasi']);
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

        $('#btn_ubah_tglmulai').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/ubah_jam/realisasi') ?>",
                dataType : "JSON",
                data : {id:$('#id_lembur_tglmulai').val(), jammulai:$('#jammulai').val()},
                success: function(result){

                    $('#ubahJam').modal('hide');
                    $('#tgl').val(result['data']['tgl']);

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


        $('#kategori').change(function(){
            var kategori = $('#kategori').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/ajax')?>",
                data: {kategori:kategori},
                success: function(data) {
                    $('#aktivitas_direct').html(data); 
                    $('#aktivitas_direct').selectpicker('refresh');
                    // if(kategori == 1){
                    //     $('#copro').prop('disabled', false);
                    //     $('#akt').prop('disabled', false);
                    //     $('#akt_lain').prop('disabled', true);
                    // }
                    // else if(kategori == 2){
                    //     $('#copro').prop('disabled', false);
                    //     $('#akt_lain').prop('disabled', false);
                    //     $('#akt_lain').selectpicker('refresh');
                    //     $('#akt').prop('disabled', true);
                    // }
                    // else if(kategori == 3){
                    //     $('#copro').prop('disabled', true);
                    //     $('#akt_lain').prop('disabled', false);
                    //     $('#akt_lain').selectpicker('refresh');
                    //     $('#akt').prop('disabled', true);
                    // }    
                }
            })
        });

        var checker = document.getElementById('check');
        var submitbtn = document.getElementById('submit');
        submitbtn.disabled = true;
        // when unchecked or checked, run the function
        checker.onchange = function() {
            if (this.checked) {
                submitbtn.disabled = false;
            } else {
                submitbtn.disabled = true;
            }
        }
    });        
    </script>