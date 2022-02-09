<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header">
                    <h4 class="card-title">
                    <!-- <small class="description">PerjalananKu</small> -->
                    </h4>
                </div>
                <div class="card-body"> 
                    <div class="toolbar">
                    <a href="#" class="btn btn-facebook" data-toggle="modal" data-target="#tambahKeluarga"><i class="material-icons">person_add</i> Tambah</a>
                    </div>
                    <div class="material-datatables">
                    <table id="dt_keluarga" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th>Status</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat <small> lahir </small></th>
                            <th>Tanggal <small> lahir </small></th>
                            <th>Jenis <small> Kelamin </small></th>
                            <th>Pekerjaan</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Status</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat <small> lahir </small></th>
                            <th>Tanggal <small> lahir </small></th>
                            <th>Jenis <small> Kelamin </small></th>
                            <th>Pekerjaan</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        
                        </tbody>
                    </table>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahKeluarga" tabindex="-1" role="dialog" aria-labelledby="tambahKeluargaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKeluargaLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form class="form" method="post" action="<?= base_url(''); ?>"> -->
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">NIK*</label></br>
                              <input type="text" class="form-control" name="nik" id="nik" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Nama Lengkap*</label></br>
                              <input type="text" class="form-control" name="nama" id="nama" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Tempat Lahir*</label></br>
                              <input type="text" class="form-control" name="lahir_tempat" id="lahir_tempat" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Tanggal Lahir*</label></br>
                              <input type="text" class="form-control datepicker" name="lahir_tanggal" id="lahir_tanggal" required/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Jenis Kelamin*</label></br>
                              <select class="selectpicker" name="jenis_kelamin" id="jenis_kelamin" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                  <option value="Laki-Laki">Laki-Laki</option>
                                  <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label">Hubungan*</label></br>
                                  <select class="selectpicker" name="hubungan" id="hubungan" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                          <option value="ISTRI">ISTRI</option>
                                          <option value="SUAMI">SUAMI</option>
                                          <option value="ANAK1">ANAK1</option>
                                          <option value="ANAK2">ANAK2</option>
                                          <option value="ANAK3">ANAK3</option>
                                  </select>
                            </div>
                        </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Pekerjaan*</label></br>
                                <select class="selectpicker" name="pekerjaan" id="pekerjaan" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                        <option value="IRT">Ibu rumah Tangga</option>
                                        <option value="PENGAJAR">Pengajar (Guru, Dosen Dll)</option>
                                        <option value="NAKES">Tenaga kesehatan</option>
                                        <option value="PEKERJA">Pekerja</option>
                                        <option value="PNS">Pegawai Negeri Sipil</option>
                                        <option value="ENTERPRENEUR">Enterpreneur</option>
                                        <option value="ARTIS">Artis, Designer, Youtuber Dll</option>
                                        <option value="PELAJAR">Pelajar</option>
                                        <option value="BALITA">Balita (Pra Sekolah)</option>
                                </select>
                          </div>
                      </div>
                      <!-- <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Vaksin*</label></br>
                              <select class="selectpicker show-tick" name="vaksin_nama" id="vaksin_nama" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required="true">
                                    <option value="Belum Vaksin">Belum Vaksin</option>
                                    <option value="Sinovac">Sinovac</option>
                                    <option value="Sinopharm">Sinopharm</option>
                                    <option value="AstraZeneca">AstraZeneca</option>
                                    <option value="Moderna">Moderna</option>
                                    <option value="Pfizer">Pfizer</option>
                                </select>
                          </div>
                      </div>
                      <div class="col-md-12" id="vaksin">
                          <div class="form-group">
                              <label class="bmd-label">Dosis*</label></br>
                              <select class="selectpicker show-tick" name="vaksin_dosis" id="vaksin_dosis" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required="true">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                          </div>
                      </div> -->
                    </div>
                    <p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                      <div class="col-md-12 mr-1">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                        <button type="button" id="btn_save" class="btn btn-success">TAMBAH</button>
                      </div>
                    </div>
                </div>
              <!-- </form> -->
        </div>
    </div>
</div>
<div class="modal fade" id="hapusKeluarga" tabindex="-1" role="dialog" aria-labelledby="hapusKeluargaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusKeluargaLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form class="form" method="post" action="<?= base_url(''); ?>"> -->
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" name="nik1" id="nik1"/>
                        <input type="hidden" class="form-control" name="nama1" id="nama1"/>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">NIK*</label></br>
                              <input type="text" class="form-control" name="nik" id="nik" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Nama Lengkap*</label></br>
                              <input type="text" class="form-control" name="nama" id="nama" disabled/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Tempat Lahir*</label></br>
                              <input type="text" class="form-control" name="lahir_tempat1" id="lahir_tempat1"/>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Tanggal Lahir*</label></br>
                              <input type="text" class="form-control datepicker" name="lahir_tanggal1" id="lahir_tanggal1"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label">Jenis Kelamin*</label></br>
                                <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" disabled/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label">Status Hubungan*</label></br>
                                <input type="text" class="form-control" name="hubungan" id="hubungan" disabled/>
                            </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Pekerjaan*</label></br>
                                <select class="selectpicker" name="pekerjaan1" id="pekerjaan1" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required></select>
                          </div>
                      </div>
                    </div>
                    <p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                      <div class="col-md-12 mr-1">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button> -->
                        <button type="button" id="btn_delete" class="btn btn-danger btn-link">HAPUS</button>
                        <button type="button" id="btn_edit" class="btn btn-success">UPDATE</button>
                      </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<script>
    $(window).load(function() {
        <?php if ($details['domisili_ktp']=='1'){ ?>

            $('#checkdomisili').prop('checked',true)
            $('#domisili1').prop('style').display='none';
            $('#domisili2').prop('style').display='none';
            $('#domisili3').prop('style').display='none';
            $('#domisili4').prop('style').display='none';
            $('#domisili5').prop('style').display='none';

        <?php }else{ ?>

            $('#checkdomisili').prop('checked',false)
            $('#domisili1').prop('style').display='';
            $('#domisili2').prop('style').display='';
            $('#domisili3').prop('style').display='';
            $('#domisili4').prop('style').display='';
            $('#domisili5').prop('style').display='';

        <?php } ?>

        <?php if ($details['vaksin_nama']=='Belum Vaksin'){ ?>

            $('#vaksin').prop('style').display='none';

        <?php }else{ ?>

            $('#vaksin').prop('style').display='';

        <?php } ?>

    });

    $(document).ready(function() {

        setFormValidation('#dataKaryawanForm');

        $('#dt_keluarga').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
            zeroRecords: "Oops!",
            },
            serverSide: true,
            processing: true,
            ajax: {
                    "url": "<?= site_url('profil/keluarga/get') ?>",
                    "type": "POST"
                },
            columns: [
                { "data": "hubungan" },
                { "data": "nik" },
                { "data": "nama" },
                { "data": "lahir_tempat" },
                { "data": "lahir_tanggal" },
                { "data": "jenis_kelamin" },
                { "data": "pekerjaan" }
            ]
        });

        $('#dt_keluarga').on('click', 'tr', function () {
            var nik = $('td', this).eq(1).text();
            var nama = $('td', this).eq(2).text();
            var tempat = $('td', this).eq(3).text();
            var tanggal = $('td', this).eq(4).text();
            var jenis_kelamin = $('td', this).eq(5).text();
            var hubungan = $('td', this).eq(0).text();
            var pekerjaan = $('td', this).eq(6).text();
            $('#hapusKeluarga').modal("show");
            $('#hapusKeluarga').find('.modal-body input[name="nik1"]').val(nik);
            $('#hapusKeluarga').find('.modal-body input[name="nama1"]').val(nama);
            $('#hapusKeluarga').find('.modal-body input[name="nik"]').val(nik);
            $('#hapusKeluarga').find('.modal-body input[name="nama"]').val(nama);
            $('#hapusKeluarga').find('.modal-body input[name="lahir_tempat1"]').val(tempat);
            $('#hapusKeluarga').find('.modal-body input[name="lahir_tanggal1"]').val(tanggal);
            $('#hapusKeluarga').find('.modal-body input[name="jenis_kelamin"]').val(jenis_kelamin);
            $('#hapusKeluarga').find('.modal-body input[name="hubungan"]').val(hubungan);

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('profil/select_pekerjaan') ?>",
                data: {
                    nik: nik
                },
                success: function(data) {
                    // alert(data)
                    $('#pekerjaan1').html(data);
                    $('#pekerjaan1').selectpicker('refresh');
                    $('#pekerjaan1').selectpicker('val', pekerjaan);
                }
            })
        });

        $('#refresh_ktp').click(function() {
            $('#prov_ktp').selectpicker('val', '');
            $('#prov_ktp').selectpicker('refresh');
            $('#kab_ktp').selectpicker('val', '');
            $('#kab_ktp').selectpicker('refresh');
            $('#kec_ktp').selectpicker('val', '');
            $('#kec_ktp').selectpicker('refresh');
            $('#desa_ktp').selectpicker('val', '');
            $('#desa_ktp').selectpicker('refresh');
        });

        $('#prov_ktp').change(function() {
            var prov = $('#prov_ktp').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('wilayah/kab') ?>",
                data: {
                    prov: prov
                },
                success: function(data) {
                    // alert(data)
                    $('#kab_ktp').html(data);
                    $('#kab_ktp').selectpicker('refresh');
                    $('#kec_ktp').selectpicker('val', '');
                    $('#kec_ktp').selectpicker('refresh');
                    $('#desa_ktp').selectpicker('val', '');
                    $('#desa_ktp').selectpicker('refresh');
                }
            })
        });

        $('#kab_ktp').change(function() {
            var kab = $('#kab_ktp').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('wilayah/kec') ?>",
                data: {
                    kab: kab
                },
                success: function(data) {
                    // alert(data)
                    $('#kec_ktp').html(data);
                    $('#kec_ktp').selectpicker('refresh');
                    $('#desa_ktp').selectpicker('val', '');
                    $('#desa_ktp').selectpicker('refresh');
                }
            })
        });

        $('#kec_ktp').change(function() {
            var kec = $('#kec_ktp').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('wilayah/desa') ?>",
                data: {
                    kec: kec
                },
                success: function(data) {
                    // alert(data)
                    $('#desa_ktp').html(data);
                    $('#desa_ktp').selectpicker('refresh');
                }
            })
        });

        $('#refresh').click(function() {
            $('#prov').selectpicker('val', '');
            $('#prov').selectpicker('refresh');
            $('#kab').selectpicker('val', '');
            $('#kab').selectpicker('refresh');
            $('#kec').selectpicker('val', '');
            $('#kec').selectpicker('refresh');
            $('#desa').selectpicker('val', '');
            $('#desa').selectpicker('refresh');
        });

        $('#prov').change(function() {
            var prov = $('#prov').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('wilayah/kab') ?>",
                data: {
                    prov: prov
                },
                success: function(data) {
                    // alert(data)
                    $('#kab').html(data);
                    $('#kab').selectpicker('refresh');
                    $('#kec').selectpicker('val', '');
                    $('#kec').selectpicker('refresh');
                    $('#desa').selectpicker('val', '');
                    $('#desa').selectpicker('refresh');
                }
            })
        });

        $('#kab').change(function() {
            var kab = $('#kab').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('wilayah/kec') ?>",
                data: {
                    kab: kab
                },
                success: function(data) {
                    // alert(data)
                    $('#kec').html(data);
                    $('#kec').selectpicker('refresh');
                    $('#desa').selectpicker('val', '');
                    $('#desa').selectpicker('refresh');
                }
            })
        });

        $('#kec').change(function() {
            var kec = $('#kec').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('wilayah/desa') ?>",
                data: {
                    kec: kec
                },
                success: function(data) {
                    // alert(data)
                    $('#desa').html(data);
                    $('#desa').selectpicker('refresh');
                }
            })
        });

        // when unchecked or checked, run the function
        $('#checkdomisili').change(function() {
            if (this.checked) {
                $('#domisili1').prop('style').display='none';
                $('#domisili2').prop('style').display='none';
                $('#domisili3').prop('style').display='none';
                $('#domisili4').prop('style').display='none';
                $('#domisili5').prop('style').display='none';
                $('#alamat').prop('disabled', true);
                $('#prov').prop('disabled', true);
                $('#kab').prop('disabled', true);
                $('#kec').prop('disabled', true);
                $('#desa').prop('disabled', true);
                
            } else {
                $('#domisili1').prop('style').display='';
                $('#domisili2').prop('style').display='';
                $('#domisili3').prop('style').display='';
                $('#domisili4').prop('style').display='';
                $('#domisili5').prop('style').display='';
                $('#alamat').prop('disabled', false);
                $('#prov').prop('disabled', false);
                $('#kab').prop('disabled', false);
                $('#kec').prop('disabled', false);
                $('#desa').prop('disabled', false);
            }
        });

        $('#vaksin_nama').change(function() {
            var vaksin = $('#vaksin_nama').val();
            if (vaksin == 'Belum Vaksin'){
                $('#vaksin').prop('style').display='none';
                $('#vaksin_dosis').val('');
                $('#vaksin_dosis').prop('disabled', true);
                $('#vaksin_dosis').prop('required', false);
                $('#vaksin_tanggal').val('');
                $('#vaksin_tanggal').prop('disabled', true);
                $('#vaksin_tanggal').prop('required', false);
            }else{
                $('#vaksin').prop('style').display='';
                $('#vaksin_dosis').prop('disabled', false);
                $('#vaksin_dosis').prop('required', true);
                $('#vaksin_tanggal').prop('disabled', false);
                $('#vaksin_tanggal').prop('required', true);
            }

        });

        // when unchecked or checked, run the function
        $('#checkConfirm').change(function() {
            if (this.checked) {
                $('#submit').prop('disabled', false);
            } else {
                $('#submit').prop('disabled', true);
            }
        });

        $('#btn_save').on('click',function(){
            var hubungan=$('#hubungan').val();
            var nik=$('#nik').val();
            var nama=$('#nama').val();
            var jenis_kelamin=$('#jenis_kelamin').val();
            var lahir_tempat=$('#lahir_tempat').val();
            var lahir_tanggal=$('#lahir_tanggal').val();
            var pekerjaan=$('#pekerjaan').val();
            $.ajax({
                type : "POST",
                url  : "<?= site_url('profil/keluarga/add') ?>",
                // dataType : "JSON",
                data : {hubungan:hubungan, nik:nik, nama:nama, lahir_tempat:lahir_tempat, lahir_tanggal:lahir_tanggal, jenis_kelamin:jenis_kelamin, pekerjaan:pekerjaan},
                success: function(result){
                    // result = JSON.parse(result)
                    // alert(result);

                    $('#tambahKeluarga').modal('hide');
                    $('#dt_keluarga').DataTable().ajax.reload();
                    
                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Data telah tersimpan."
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
                    $('#tambahKeluarga').modal('hide');
                    $.notify({
                            icon: "add_alert",
                            message: "<b>GAGAL!</b> Anggota keluarga ini sudah ada."
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

        $('#btn_edit').on('click',function(){
            var hubungan=$('#hubungan').val();
            var nik=$('#nik1').val();
            var nama=$('#nama1').val();
            var jenis_kelamin=$('#jenis_kelamin').val();
            var lahir_tempat=$('#lahir_tempat1').val();
            var lahir_tanggal=$('#lahir_tanggal1').val();
            var pekerjaan=$('#pekerjaan1').val();
            $.ajax({
                type : "POST",
                url  : "<?= site_url('profil/keluarga/edit') ?>",
                // dataType : "JSON",
                data : {hubungan:hubungan, nik:nik, nama:nama, lahir_tempat:lahir_tempat, lahir_tanggal:lahir_tanggal, jenis_kelamin:jenis_kelamin, pekerjaan:pekerjaan},
                success: function(result){
                    // result = JSON.parse(result)
                    // alert(result);

                    $('#hapusKeluarga').modal('hide');
                    $('#dt_keluarga').DataTable().ajax.reload();
                    
                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Data telah tersimpan."
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
                    $('#tambahKeluarga').modal('hide');
                    $.notify({
                            icon: "add_alert",
                            message: "<b>GAGAL!</b> Anggota keluarga ini sudah ada."
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
        
        $('#btn_delete').on('click',function(){
            var nik=$('#nik1').val();
            var nama=$('#nama1').val();
            $.ajax({
                type : "POST",
                url  : "<?= site_url('profil/keluarga/delete') ?>",
                // dataType : "JSON",
                data : {nik:nik, nama:nama},
                success: function(result){
                    // result = JSON.parse(result)
                    // alert(result);

                    $('#hapusKeluarga').modal('hide');
                    $('#dt_keluarga').DataTable().ajax.reload();
                    
                    $.notify({
                        icon: "add_alert",
                        message: "<b>BERHASIL!</b> Data berhasil dihapus."
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
                    $('#hapusKeluarga').modal('hide');
                    $.notify({
                            icon: "add_alert",
                            message: "<b>GAGAL!</b> Data gagal dihapus."
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

        <?php if ($this->session->flashdata('notify')=='success'){ ?>
       
       $.notify({
            icon: "add_alert",
            message: "<b>Berhasil!</b> Data telah tersimpan."
        }, {
            type: "success",
            timer: 2000,
            placement: {
                from: "top",
                align: "center"
            }
        });
      
       <?php } ?>
    });
</script>