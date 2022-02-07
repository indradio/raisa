<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">medical_services</i>
                    </div>
                    <h4 class="card-title">Riwayat Vaksin</h4>
                </div>
                <div class="card-body"> 
                    <div class="material-datatables">
                    <table id="dt_vaksin" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Vaksin <small> Ke-1 </small></th>
                                <th>Vaksin <small> Ke-2 </small></th>
                                <th>Vaksin <small> Ke-3 </small></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Status</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Vaksin <small> Ke-1 </small></th>
                                <th>Vaksin <small> Ke-2 </small></th>
                                <th>Vaksin <small> Ke-3 </small></th>
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
<div class="modal fade" id="updateVaksin" tabindex="-1" role="dialog" aria-labelledby="updateVaksinLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateVaksinLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form class="form" method="post" action="<?= base_url(''); ?>"> -->
                <div class="modal-body">
                    <div class="row">
                        <!-- <input type="hidden" class="form-control" name="nik" id="nik"/>
                        <input type="hidden" class="form-control" name="nama" id="nama"/> -->
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">NIK*</label></br>
                              <input type="text" class="form-control disabled" name="nik" id="nik" />
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Nama Lengkap*</label></br>
                              <input type="text" class="form-control disabled" name="nama" id="nama" />
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Vaksin Ke-1</label></br>
                                <select class="selectpicker" name="vaksin1" id="vaksin1" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" onchange="vaksin1Select(this);" required>
                                    <option value="YA">YA, SUDAH VAKSIN</option>
                                    <option value="TIDAK">TIDAK/BELUM</option>
                                </select>
                          </div>
                        </div>
                        <div class="col-md-12" id="col_vaksin1_nama">
                          <div class="form-group">
                              <label class="bmd-label">Jenis Vaksin*</label></br>
                                <select class="selectpicker" name="vaksin1_nama" id="vaksin1_nama" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="true">
                                    <option value="Sinovac">Sinovac</option>
                                    <option value="Sinopharm">Sinopharm</option>
                                    <option value="AstraZeneca">AstraZeneca</option>
                                    <option value="Moderna">Moderna</option>
                                    <option value="Pfizer">Pfizer</option>
                                </select>
                          </div>
                        </div>
                      <div class="col-md-12" id="col_vaksin1_tanggal">
                          <div class="form-group">
                              <label class="bmd-label">Tanggal Vaksin*</label></br>
                              <input type="text" class="form-control datepicker" name="vaksin1_tanggal" id="vaksin1_tanggal"/>
                            </div>
                        </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Vaksin Ke-2</label></br>
                                <select class="selectpicker" name="vaksin2" id="vaksin2" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" onchange="vaksin2Select(this);" required>
                                    <option value="YA">YA, SUDAH VAKSIN</option>
                                    <option value="TIDAK">TIDAK/BELUM</option>
                                </select>
                          </div>
                        </div>
                        <div class="col-md-12" id="col_vaksin2_nama">
                          <div class="form-group">
                              <label class="bmd-label">Jenis Vaksin*</label></br>
                                <select class="selectpicker" name="vaksin2_nama" id="vaksin2_nama" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="true">
                                    <option value="Sinovac">Sinovac</option>
                                    <option value="Sinopharm">Sinopharm</option>
                                    <option value="AstraZeneca">AstraZeneca</option>
                                    <option value="Moderna">Moderna</option>
                                    <option value="Pfizer">Pfizer</option>
                                </select>
                          </div>
                        </div>
                      <div class="col-md-12" id="col_vaksin2_tanggal">
                          <div class="form-group">
                              <label class="bmd-label">Tanggal Vaksin*</label></br>
                              <input type="text" class="form-control datepicker" name="vaksin2_tanggal" id="vaksin2_tanggal"/>
                            </div>
                        </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label">Vaksin Ke-3</label></br>
                                <select class="selectpicker" name="vaksin3" id="vaksin3" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" onchange="vaksin3Select(this);" required>
                                    <option value="YA">YA, SUDAH VAKSIN</option>
                                    <option value="TIDAK">TIDAK/BELUM</option>
                                </select>
                          </div>
                        </div>
                        <div class="col-md-12" id="col_vaksin3_nama">
                          <div class="form-group">
                              <label class="bmd-label">Jenis Vaksin*</label></br>
                                <select class="selectpicker" name="vaksin3_nama" id="vaksin3_nama" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="true">
                                    <option value="Sinovac">Sinovac</option>
                                    <option value="Sinopharm">Sinopharm</option>
                                    <option value="AstraZeneca">AstraZeneca</option>
                                    <option value="Moderna">Moderna</option>
                                    <option value="Pfizer">Pfizer</option>
                                </select>
                          </div>
                        </div>
                      <div class="col-md-12" id="col_vaksin3_tanggal">
                          <div class="form-group">
                              <label class="bmd-label">Tanggal Vaksin*</label></br>
                              <input type="text" class="form-control datepicker" name="vaksin3_tanggal" id="vaksin3_tanggal"/>
                            </div>
                        </div>
                        <div class="col-md-12" id="col_vaksin3_tiket">
                          <div class="form-group">
                              <label class="bmd-label">Apakah sudah ada tiket vaksin booster pedulilindungi ?</label></br>
                                <select class="selectpicker" name="vaksin3_tiket" id="vaksin3_tiket" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                    <option value="YA">YA, SUDAH DAPAT</option>
                                    <option value="TIDAK">TIDAK DAPAT</option>
                                </select>
                          </div>
                        </div>
                    </div>
                    <p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                      <div class="col-md-12 mr-1">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                        <button type="button" id="btn_update" class="btn btn-success">UPDATE</button>
                      </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<script>
    function vaksin1Select(valueSelect)
            {
                var val = valueSelect.options[valueSelect.selectedIndex].value;
                document.getElementById("col_vaksin1_nama").style.display = val != 'YA' ? 'none' : '';
                document.getElementById("col_vaksin1_tanggal").style.display = val != 'YA' ? 'none' : '';
            }
    function vaksin2Select(valueSelect)
            {
                var val = valueSelect.options[valueSelect.selectedIndex].value;
                document.getElementById("col_vaksin2_nama").style.display = val != 'YA' ? 'none' : '';
                document.getElementById("col_vaksin2_tanggal").style.display = val != 'YA' ? 'none' : '';
            }
    function vaksin3Select(valueSelect)
            {
                var val = valueSelect.options[valueSelect.selectedIndex].value;
                document.getElementById("col_vaksin3_nama").style.display = val != 'YA' ? 'none' : '';
                document.getElementById("col_vaksin3_tanggal").style.display = val != 'YA' ? 'none' : '';
                document.getElementById("col_vaksin3_tiket").style.display = val != 'YA' ? '' : 'none';
            }

    $(document).ready(function() {

        setFormValidation('#dataKaryawanForm');

        $('#dt_vaksin').DataTable({
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
                    "url": "<?= site_url('profil/vaksin/get') ?>",
                    "type": "POST"
                },
            columns: [
                { "data": "hubungan" },
                { "data": "nik" },
                { "data": "nama" },
                { "data": "vaksin1" },
                { "data": "vaksin2" },
                { "data": "vaksin3" }
            ]
        });

        $('#dt_vaksin').on('click', 'tr', function () {
            $('#updateVaksin').modal("show");


            var vaksin1 = $('td', this).eq(3).text();
            if (vaksin1 == 'YA'){
                document.getElementById("col_vaksin1_nama").style.display = '';
                document.getElementById("col_vaksin1_nama").style.display = '';
            }else{
                document.getElementById("col_vaksin1_tanggal").style.display = 'none';
                document.getElementById("col_vaksin1_tanggal").style.display = 'none';
            }
            var vaksin2 = $('td', this).eq(4).text();
            if (vaksin2 == 'YA'){
                document.getElementById("col_vaksin2_nama").style.display = '';
                document.getElementById("col_vaksin2_nama").style.display = '';
            }else{
                document.getElementById("col_vaksin2_tanggal").style.display = 'none';
                document.getElementById("col_vaksin2_tanggal").style.display = 'none';
            }
            var vaksin3 = $('td', this).eq(5).text();
            if (vaksin3 == 'YA'){
                document.getElementById("col_vaksin3_nama").style.display = '';
                document.getElementById("col_vaksin3_nama").style.display = '';
                document.getElementById("col_vaksin3_tiket").style.display = 'none';
            }else{
                document.getElementById("col_vaksin3_tanggal").style.display = 'none';
                document.getElementById("col_vaksin3_tanggal").style.display = 'none';
                document.getElementById("col_vaksin3_tiket").style.display = '';
            }

            var nik = $('td', this).eq(1).text();
            var nama = $('td', this).eq(2).text();
            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('profil/vaksin/getbyname') ?>",
                data: {
                    nik: nik, nama:nama
                },
                success: function(data) {
                    var myObj = JSON.parse(data);
                    $('#updateVaksin').find('.modal-body input[name="nik"]').val(myObj.data['nik']);
                    $('#updateVaksin').find('.modal-body input[name="nama"]').val(myObj.data['nama']);
                  
                    $('#vaksin1').selectpicker('val', myObj.data['vaksin1']);
                    $('#vaksin1_nama').selectpicker('val', myObj.data['vaksin1_nama']);
                    $('#updateVaksin').find('.modal-body input[name="vaksin1_tanggal"]').val(myObj.data['vaksin1_tanggal']);
                    
                    $('#vaksin2').selectpicker('val', myObj.data['vaksin2']);
                    $('#vaksin2_nama').selectpicker('val', myObj.data['vaksin2_nama']);
                    $('#updateVaksin').find('.modal-body input[name="vaksin2_tanggal"]').val(myObj.data['vaksin2_tanggal']);
                    
                    $('#vaksin3').selectpicker('val', myObj.data['vaksin3']);
                    $('#vaksin3_nama').selectpicker('val', myObj.data['vaksin3_nama']);
                    $('#updateVaksin').find('.modal-body input[name="vaksin3_tanggal"]').val(myObj.data['vaksin3_tanggal']);
                    $('#vaksin3_tiket').selectpicker('val', myObj.data['vaksin3_tiket']);
                }
            });
        });

        $('#btn_update').on('click',function(){
            var nik=$('#nik').val();
            var nama=$('#nama').val();
            var vaksin1=$('#vaksin1').val();
            var vaksin1_nama=$('#vaksin1_nama').val();
            var vaksin1_tanggal=$('#vaksin1_tanggal').val();
            var vaksin2=$('#vaksin2').val();
            var vaksin2_nama=$('#vaksin2_nama').val();
            var vaksin2_tanggal=$('#vaksin2_tanggal').val();
            var vaksin3=$('#vaksin3').val();
            var vaksin3_nama=$('#vaksin3_nama').val();
            var vaksin3_tanggal=$('#vaksin3_tanggal').val();
            var vaksin3_tiket=$('#vaksin3_tiket').val();
            $.ajax({
                type : "POST",
                url  : "<?= site_url('profil/vaksin/update') ?>",
                // dataType : "JSON",
                data : {nik:nik, nama:nama, vaksin1:vaksin1, vaksin1_nama:vaksin1_nama, vaksin1_tanggal:vaksin1_tanggal, vaksin2:vaksin2, vaksin2_nama:vaksin2_nama, vaksin2_tanggal:vaksin2_tanggal, vaksin3:vaksin3, vaksin3_nama:vaksin3_nama, vaksin3_tanggal:vaksin3_tanggal, vaksin3_tiket:vaksin3_tiket},
                success: function(result){
                    // result = JSON.parse(result)
                    // alert(result);

                    $('#updateVaksin').modal('hide');
                    $('#dt_vaksin').DataTable().ajax.reload();
                    
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