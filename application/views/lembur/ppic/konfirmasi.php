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
                    <form class="form-horizontal" method="post" action="#">
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
                                <a href="#" id="tambah_aktivitas" class="btn btn-facebook" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitasDirect" data-id="<?= $lembur['id']; ?>">Tambah Aktivitas</a>
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
                            <!-- Button KEMBALI -->
                            <a href="<?= base_url('lembur/konfirmasi/ppic') ?>" class="btn btn-link btn-default" role="button">Kembali</a>
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
                <form class="form-horizontal" method="post" action="<?= base_url('lembur/persetujuan_ppic'); ?>">
                    <div class="modal-body">
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
                                <label for="exampleDurasi" class="bmd-label-static">Durasi<small>(Jam)</small></label></br>
                                <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= $lembur['durasi']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleDurasi" class="bmd-label-static">Projek <small>(Jam)</small></label></br>
                                <input type="text" class="form-control disabled" id="durasi_projek" name="durasi_projek">
                            </div>
                            <div class="form-group">
                                <label for="exampleDurasi" class="bmd-label-static">Lain-Lain Projek <small>(Jam)</small></label></br>
                                <input type="text" class="form-control disabled" id="durasi_lain_projek" name="durasi_lain_projek">
                            </div>
                            <div class="form-group">
                                <label for="exampleDurasi" class="bmd-label-static">Non Projek <small>(Jam)</small></label></br>
                                <input type="text" class="form-control disabled" id="durasi_non_projek" name="durasi_non_projek">
                            </div>
                            <p id="errorText"></p>
                            
                            <div class="modal-footer justify-content-right">
                                <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                                <button type="submit" id="btn_submit_lembur" class="btn btn-success">PROSES</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateAktivitas1" tabindex="-1" role="dialog" aria-labelledby="updateAktivitas1Title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form" method="post" action="#">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id_lembur1" name="id_lembur1" />
                        <input type="hidden" class="form-control" id="id_aktivitas1" name="id_aktivitas1" />
                        <div class="col-md-12 align-content-start">
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Kategori</label></br>
                                <input type="text" class="form-control disabled" id="kategori" name="kategori" value="PROJEK"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Aktivitas</label></br>
                                <textarea rows="3" class="form-control" id="aktivitas1" name="aktivitas1" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Deskripsi*</label></br>
                                <textarea rows="5" class="form-control" id="deskripsi1" name="deskripsi1" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">COPRO</label></br>
                                    <select class="selectpicker" name="copro1" id="copro1" data-style="select-with-transition" data-size="7" data-width="fit" data-live-search="true" required></select>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Progres*</label></br>
                                <select class="selectpicker" name="progres1" id="progres1" data-style="select-with-transition" data-width="auto" data-size="5" required></select>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Durasi</label></br>
                                <select class="selectpicker" name="durasi1" id="durasi1" data-style="select-with-transition" data-width="auto" required></select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                                <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                                <button type="button" class="btn btn-success btn-block" id="btn_update1">SIMPAN</button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateAktivitas2" tabindex="-1" role="dialog" aria-labelledby="updateAktivitas2Title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form" method="post" action="#">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id_lembur2" name="id_lembur2" />
                        <input type="hidden" class="form-control" id="id_aktivitas2" name="id_aktivitas2" />
                        <div class="col-md-12 align-content-start">
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Kategori</label></br>
                                <input type="text" class="form-control disabled" id="kategori" name="kategori" value="LAIN-LAIN PROJEK"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Aktivitas</label></br>
                                    <select class="selectpicker" id="aktivitas2" name="aktivitas2" data-style="select-with-transition" data-size="7" data-width="fit" required></select>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Deskripsi*</label></br>
                                <textarea rows="5" class="form-control" id="deskripsi2" name="deskripsi2" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">COPRO</label></br>
                                    <select class="selectpicker" name="copro2" id="copro2" data-style="select-with-transition" data-size="7" data-width="fit" data-live-search="true" required></select>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Progres*</label></br>
                                <select class="selectpicker" name="progres2" id="progres2" data-style="select-with-transition" data-width="auto" data-size="5" required></select>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Durasi</label></br>
                                <select class="selectpicker" name="durasi2" id="durasi2" data-style="select-with-transition" data-width="auto" required></select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                                <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                                <button type="button" class="btn btn-success btn-block" id="btn_update2">SIMPAN</button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateAktivitas3" tabindex="-1" role="dialog" aria-labelledby="updateAktivitas3Title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form" method="post" action="#">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id_lembur3" name="id_lembur3" />
                        <input type="hidden" class="form-control" id="id_aktivitas3" name="id_aktivitas3" />
                        <div class="col-md-12 align-content-start">
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Kategori</label></br>
                                <input type="text" class="form-control disabled" id="kategori" name="kategori" value="NON PROJEK"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Aktivitas</label></br>
                                    <select class="selectpicker" id="aktivitas3" name="aktivitas3" data-style="select-with-transition" data-size="7" data-width="fit" required></select>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Deskripsi*</label></br>
                                <textarea rows="5" class="form-control" id="deskripsi3" name="deskripsi3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Progres*</label></br>
                                <select class="selectpicker" name="progres3" id="progres3" data-style="select-with-transition" data-width="auto" data-size="5" required></select>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Durasi</label></br>
                                <select class="selectpicker" name="durasi3" id="durasi3" data-style="select-with-transition" data-width="auto" required></select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                                <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                                <button type="button" class="btn btn-success btn-block" id="btn_update3">SIMPAN</button>
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
                                    <select class="selectpicker" name="kategori_direct" id="kategori_direct" title="Pilih" data-style="select-with-transition" data-size="5" data-width="fit" data-live-search="false" onchange="kategoriSelect(this);" required>
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
                                    <select class="selectpicker" name="copro_direct" id="copro_direct" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
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

<script>
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
                    "url"   : "<?= site_url('lembur/get_aktivitas/ppic') ?>",
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

        $('#updateAktivitas1').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id_lembur = button.data('id_lembur') 
            var id_aktivitas = button.data('id_aktivitas') 
            var deskripsi_hasil = button.data('deskripsi_hasil')
            var modal = $(this)
            modal.find('.modal-body input[name="id_lembur1"]').val(id_lembur)
            modal.find('.modal-body input[name="id_aktivitas1"]').val(id_aktivitas)
            modal.find('.modal-body textarea[name="deskripsi1"]').val(deskripsi_hasil)
            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/direct_aktivitas/1') ?>",
                dataType : "JSON",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    modal.find('.modal-body textarea[name="aktivitas1"]').val(data['data']['aktivitas'])
                }
            });

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/copro_aktivitas') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#copro1').html(data);
                    $('#copro1').selectpicker('refresh');
                }
            });

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/progres_aktivitas') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#progres1').html(data);
                    $('#progres1').selectpicker('refresh');
                }
            });

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/durasi_aktivitas') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#durasi1').html(data);
                    $('#durasi1').selectpicker('refresh');
                }
            });
        });

        $('#btn_update1').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/aktivitas/realisasi/update_ppic') ?>",
                dataType : "JSON",
                data : {
                    id:$('#id_lembur1').val(), 
                    id_aktivitas:$('#id_aktivitas1').val(), 
                    kategori:'1',
                    aktivitas:$('#aktivitas1').val(), 
                    deskripsi:$('#deskripsi1').val(), 
                    copro:$('#copro1').val(), 
                    progres:$('#progres1').val(), 
                    durasi:$('#durasi1').val()
                },
                success: function(result){

                    $('#updateAktivitas1').modal('hide');
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

        $('#updateAktivitas2').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id_lembur = button.data('id_lembur') 
            var id_aktivitas = button.data('id_aktivitas') 
            var deskripsi_hasil = button.data('deskripsi_hasil')
            var modal = $(this)
            modal.find('.modal-body input[name="id_lembur2"]').val(id_lembur)
            modal.find('.modal-body input[name="id_aktivitas2"]').val(id_aktivitas)
            modal.find('.modal-body textarea[name="deskripsi2"]').val(deskripsi_hasil)
            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/direct_aktivitas/2') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#aktivitas2').html(data);
                    $('#aktivitas2').selectpicker('refresh');
                }
            });

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/copro_aktivitas') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#copro2').html(data);
                    $('#copro2').selectpicker('refresh');
                }
            });

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/progres_aktivitas') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#progres2').html(data);
                    $('#progres2').selectpicker('refresh');
                }
            });

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/durasi_aktivitas') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#durasi2').html(data);
                    $('#durasi2').selectpicker('refresh');
                }
            });
        });

        $('#btn_update2').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/aktivitas/realisasi/update_ppic') ?>",
                dataType : "JSON",
                data : {
                    id:$('#id_lembur2').val(), 
                    id_aktivitas:$('#id_aktivitas2').val(), 
                    kategori:'2',
                    aktivitas:$('#aktivitas2').val(), 
                    deskripsi:$('#deskripsi2').val(), 
                    copro:$('#copro2').val(), 
                    progres:$('#progres2').val(), 
                    durasi:$('#durasi2').val()
                },
                success: function(result){

                    $('#updateAktivitas2').modal('hide');
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

        $('#updateAktivitas3').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id_lembur = button.data('id_lembur') 
            var id_aktivitas = button.data('id_aktivitas') 
            var deskripsi_hasil = button.data('deskripsi_hasil')
            var modal = $(this)
            modal.find('.modal-body input[name="id_lembur3"]').val(id_lembur)
            modal.find('.modal-body input[name="id_aktivitas3"]').val(id_aktivitas)
            modal.find('.modal-body textarea[name="deskripsi3"]').val(deskripsi_hasil)
            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/direct_aktivitas/3') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#aktivitas3').html(data);
                    $('#aktivitas3').selectpicker('refresh');
                }
            });

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/progres_aktivitas') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#progres3').html(data);
                    $('#progres3').selectpicker('refresh');
                }
            });

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/durasi_aktivitas') ?>",
                data: {
                    id: id_aktivitas
                },
                success: function(data) {
                    // alert(data)
                    $('#durasi3').html(data);
                    $('#durasi3').selectpicker('refresh');
                }
            });
        });

        $('#btn_update3').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('lembur/aktivitas/realisasi/update_ppic') ?>",
                dataType : "JSON",
                data : {
                    id:$('#id_lembur3').val(), 
                    id_aktivitas:$('#id_aktivitas3').val(), 
                    kategori:'3',
                    aktivitas:$('#aktivitas3').val(), 
                    deskripsi:$('#deskripsi3').val(), 
                    progres:$('#progres3').val(), 
                    durasi:$('#durasi3').val()
                },
                success: function(result){

                    $('#updateAktivitas3').modal('hide');
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

        $('#tambahAktivitasDirect').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') 
            var modal = $(this)
            modal.find('.modal-body input[name="id_lembur_direct"]').val(id)
        });

        $('#tambahAktivitasDirect').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
            $('#kategori_direct').selectpicker('refresh');
            $('#aktivitas_direct').selectpicker('refresh');
            $('#deskripsi_direct').selectpicker('refresh');
            $('#copro_direct').selectpicker('refresh');
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
                url  : "<?= site_url('lembur/aktivitas/realisasi/tambah_ppic') ?>",
                dataType : "JSON",
                data : {
                    id:$('#id_lembur_direct').val(), 
                    kategori:$('#kategori_direct').val(), 
                    aktivitas_direct:$('#aktivitas_direct').val(), 
                    aktivitas_projek:$('#aktivitas_projek').val(), 
                    deskripsi:$('#deskripsi_direct').val(), 
                    copro:$('#copro_direct').val(), 
                    progres:$('#progres_direct').val(),
                    durasi:$('#durasi_aktivitas_direct').val()},

                success: function(result){

                    $('#tambahAktivitasDirect').modal('hide');
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
                url  : "<?= site_url('lembur/aktivitas/realisasi/hapus_ppic') ?>",
                dataType : "JSON",
                data : {id:$('#id_lembur_hapus').val(), id_aktivitas:$('#id_aktivitas_hapus').val()},
                success: function(result){

                    $('#hapusAktivitas').modal('hide');
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
                url: "<?php echo site_url('lembur/count/jamkerja') ?>",
                dataType : "JSON",
                data: {
                    id:$('#id').val()
                },
                success: function(result) {
                    // alert(data)
                    modal.find('.modal-body input[name="durasi_projek"]').val(result['data']['durasi1']);
                    modal.find('.modal-body input[name="durasi_lain_projek"]').val(result['data']['durasi2']);
                    modal.find('.modal-body input[name="durasi_non_projek"]').val(result['data']['durasi3']);
                    document.getElementById("errorText").innerHTML = result['data']['error'];

                    var submitbtn = document.getElementById('btn_submit_lembur');
                    if (result['data']['error']=='') {
                        submitbtn.disabled = false;
                    } else {
                        submitbtn.disabled = true;
                    }
                }
            });
        });

        $('#kategori_direct').change(function(){
            var id = $('#id_lembur_direct').val();
            var kategori = $('#kategori_direct').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/kategori_aktivitas')?>",
                data: {id:id, kategori:kategori},
                success: function(data) {
                    $('#aktivitas_direct').html(data); 
                    $('#aktivitas_direct').selectpicker('refresh');
                }
            })
        });
    });
</script>