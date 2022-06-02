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
                        <h4 class="card-title">Persetujuan Rencana</h4>
                    </div>
                    <form class="form-horizontal" method="post" action="<?= base_url('lembur/setujui_rencana'); ?>">
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
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-floating">Tanggal & Jam</label>
                                <input type="text" class="form-control disabled" id="tgl" name="tgl" value="<?= date('d M H:i', strtotime($lembur['tglmulai_rencana'])).date(' - H:i', strtotime($lembur['tglselesai_rencana'])); ?>">
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
                            <div class="toolbar">
                            <?php if($this->session->userdata('posisi_id')>4){ ?>
                                <!-- <a href="#" id="tambah_aktivitas" class="btn btn-facebook" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">TAMBAH AKTIVITAS</a> -->
                            <?php } ?>
                            </div>
                            <div class="material-datatables">
                                <table id="dtaktivitas" class="table table-striped table-no-bordered table-hover"  cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Aktivitas</th>
                                            <th>Durasi <small>(Jam)</small></th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Aktivitas</th>
                                            <th>Durasi <small>(Jam)</small></th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            </p>
                            <?php 
                            $this->db->distinct();
                            $this->db->select('copro');
                            $this->db->where('link_aktivitas', $lembur['id']);
                            $copro = $this->db->get('aktivitas')->result_array();
                            foreach ($copro as $row) : 
                                if ($row['copro']){
                                    $project = $this->db->get_where('project', ['copro' => $row['copro']])->row_array();
                                    echo '<b>'.$project['copro']. '</b> : '. $project['deskripsi'] . '<br>';  
                                }
                            endforeach;
                             ?>
                            </p>
                            <?php if ($this->session->userdata('dept_id')==13 AND $this->session->userdata('posisi_id')==3){ ?>
                            <div class="row col-md-12">
                                <label class="col-ml-1 col-form-label">Kategori</label>
                                <div class="col-md-7">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="mch_kategori" id="mch_kategori" data-style="select-with-transition" title="Pilih" data-size="3" required>
                                            <option value="Claim dan Servis">Claim dan Servis</option>
                                            <option value="Sesuai Jadwal WBS">Sesuai Jadwal WBS</option>
                                            <option value="Actual Fail">Actual Fail</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="exampleCatatan" class="bmd-label-floating">Catatan</label>
                                <textarea rows="3" class="form-control" name="catatan" id="catatan"><?= $lembur['catatan']; ?></textarea>
                            </div> 
                            <!-- Button SUBMIT -->
                            <button type="submit"  id="setujui" class="btn btn-sm btn-success">SETUJUI</button>
                            <a href="#" id="batalAktivitas" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                            <a href="<?= base_url('lembur/persetujuan') ?>" class="btn btn-sm btn-default" role="button">Kembali</a>
                        </div>
                    </form>   
                </div>
                <!--  end card Body -->
            </div>
            <!--  end card  -->
        </div>
        <!-- end col-md-12 -->
    </div>
    <!-- end row -->
</div>
<!-- end content-->

<!-- Modal Tambah aktivitas-->
<div class="modal fade" id="tambahAktivitas" tabindex="-1" role="dialog" aria-labelledby="tambahAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">AKTIVITAS</h4>
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
                                        $queyCopro = "SELECT * FROM project where `status`='open' or `status`='teco' ";
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
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required >
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
<!-- Modal Update aktivitas-->
<div class="modal fade" id="ubahAktivitas" tabindex="-1" role="dialog" aria-labelledby="ubahAktivitas" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title"> UBAH AKTIVITAS LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/update_aktivitas'); ?>">
                <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Aktivitas ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id" value="<?= $a['id']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Lembur ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $a['link_aktivitas']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" id="aktivitas" name="aktivitas" required><?= $a['aktivitas']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" value="<?= $a['durasi']; ?>" required >
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

<!-- Modal Update Durasi-->
<div class="modal fade" id="ubahDurasi" tabindex="-1" role="dialog" aria-labelledby="ubahDurasiTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form" method="post" action="#">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id_lembur_durasi" name="id_lembur_durasi">
                        <input type="hidden" class="form-control" id="id_aktivitas_durasi" name="id_aktivitas_durasi">
                        <div class="col-md-12 align-content-start">
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Aktivitas</label></br>
                                <textarea rows="3" class="form-control disabled" id="aktivitas" name="aktivitas" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-static">Durasi</label></br>
                                <select class="selectpicker" name="durasi_aktivitas" id="durasi_aktivitas" data-style="select-with-transition" data-width="auto" required></select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                            <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                            <button type="button" class="btn btn-success" id="btn_update_durasi">UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Aktivitas-->
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
                        "url"   : "<?= site_url('lembur/get_aktivitas/rencana_persetujuan') ?>",
                        "type"  : "POST",
                        "data"  : {id:$('#id').val()}
                    },
                columns: [
                    { "data": "aktivitas" },
                    { "data": "durasi" },
                    { "data": "action", className: "text-right" }
                ],
            });
            
            $('#ubahDurasi').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id_lembur = button.data('id_lembur') 
                var id_aktivitas = button.data('id_aktivitas') 
                var aktivitas = button.data('aktivitas') 
                var modal = $(this)
                modal.find('.modal-body input[name="id_lembur_durasi"]').val(id_lembur);
                modal.find('.modal-body input[name="id_aktivitas_durasi"]').val(id_aktivitas)
                modal.find('.modal-body textarea[name="aktivitas"]').val(aktivitas)

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

            $('#btn_update_durasi').on('click',function(){
                $.ajax({
                    type : "POST",
                    url  : "<?= site_url('lembur/aktivitas/rencana/ubah_durasi') ?>",
                    dataType : "JSON",
                    data : {id:$('#id_lembur_durasi').val(), id_aktivitas:$('#id_aktivitas_durasi').val(), durasi:$('#durasi_aktivitas').val()},
                    success: function(result){

                        $('#ubahDurasi').modal('hide');
                        $('#tgl').val(result['data']['tgl']);
                        $('#durasi').val(result['data']['durasi']);
                        $('#dtaktivitas').DataTable().ajax.reload();

                        $.notify({
                            icon: "add_alert",
                            message: "<b>BERHASIL!</b> Durasi Aktivitas telah diubah."
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
                    url  : "<?= site_url('lembur/aktivitas/rencana/hapus') ?>",
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

        });  
    </script>