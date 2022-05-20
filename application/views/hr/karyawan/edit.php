    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                    <h4 class="card-title"><?= $data->nama; ?> -
                        <small class="description"><?= $data->inisial; ?></small>
                    </h4>
                    </div>
                    <div class="card-body ">
                    <div class="row">
                        <div class="col-md-3">
                        <ul class="nav nav-pills nav-pills-rose flex-column" role="tablist">
                            <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#linkProfile" role="tablist">
                                Profile
                            </a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#linkStucture" role="tablist">
                                Structure
                            </a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#link6" role="tablist">
                                Options
                            </a>
                            </li>
                        </ul>
                        </div>
                        <div class="col-md-8">
                        <div class="tab-content">
                            <div class="tab-pane active" id="linkProfile">
                                <form class="form" id="formeditProfile" method="post" action="karyawan/edit">
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="form-group">
                                                <label class="bmd-label-static">NPK*</label></br>
                                                <input type="text" class="form-control" id="npk" name="npk" value="<?= $data->npk; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Nama Lengkap*</label></br>
                                                <input type="text" class="form-control" id="nama" name="nama"  value="<?= $data->nama; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Inisial*</label></br>
                                                <input type="text" class="form-control" id="inisial" name="inisial"  value="<?= $data->inisial; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Email*</label></br>
                                                <input type="text" class="form-control" id="email" name="email"  value="<?= $data->email; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Kontak*</label></br>
                                                <input type="text" class="form-control" id="phone" name="phone"  value="<?= $data->phone; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-success" id="btn_save_profile">UPDATE</button>
                                            <a href="<?= base_url('hr/karyawan') ?>" class="btn btn-link btn-default" role="button">Kembali</a>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                            <div class="tab-pane" id="linkStucture">
                                <form class="form" id="formeditStucture" method="post" action="karyawan/edit">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Posisi / Jabatan*</label></br>
                                                <select class="selectpicker" id="posisi_id" name="posisi_id" data-style="select-with-transition" data-width="auto" title="Select Position" required>
                                                    <?php
                                                    $posisi = $this->db->get('karyawan_posisi')->result();
                                                    foreach ($posisi as $row) : echo '<option value="' . $row->id . '"';
                                                        if ($row->id == $data->posisi_id) {
                                                            echo 'selected';
                                                        }
                                                        echo '>' . $row->nama . '</option>' . "\n";
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Divisi*</label></br>
                                                <select class="selectpicker" id="div_id" name="div_id" data-style="select-with-transition" data-width="auto" title="Select Divisi" required>
                                                    <?php
                                                    $div = $this->db->get('karyawan_div')->result();
                                                    foreach ($div as $row) : echo '<option value="' . $row->id . '"';
                                                        if ($row->id == $data->div_id) {
                                                            echo 'selected';
                                                        }
                                                        echo '>' . $row->nama . '</option>' . "\n";
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Departemen*</label></br>
                                                <select class="selectpicker" id="dept_id" name="dept_id" data-style="select-with-transition" data-width="auto" title="Select Dept" required>
                                                    <?php
                                                    $dept = $this->db->get_where('karyawan_dept', ['div_id' => $data->div_id])->result();
                                                    foreach ($dept as $row) : echo '<option value="' . $row->id . '"';
                                                        if ($row->id == $data->dept_id) {
                                                            echo 'selected';
                                                        }
                                                        echo '>' . $row->nama . '</option>' . "\n";
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Section*</label></br>
                                                <select class="selectpicker" id="sect_id" name="sect_id" data-style="select-with-transition" data-width="auto" title="Select Sect" required>
                                                    <?php
                                                    $sect = $this->db->get_where('karyawan_sect', ['dept_id' => $data->dept_id])->result();
                                                    foreach ($sect as $row) : echo '<option value="' . $row->id . '"';
                                                        if ($row->id == $data->sect_id) {
                                                            echo 'selected';
                                                        }
                                                        echo '>' . $row->nama . '</option>' . "\n";
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Golongan*</label></br>
                                                <select class="selectpicker" id="gol_id" name="gol_id" data-style="select-with-transition" data-width="auto" title="Select Gol" required>
                                                    <?php
                                                    $gol = $this->db->get('karyawan_gol')->result();
                                                    foreach ($gol as $row) : echo '<option value="' . $row->id . '"';
                                                        if ($row->id == $data->gol_id) {
                                                            echo 'selected';
                                                        }
                                                        echo '>' . $row->nama . '</option>' . "\n";
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Fasilitas*</label></br>
                                                <select class="selectpicker" id="fasilitas_id" name="fasilitas_id" data-style="select-with-transition" data-width="auto" title="Select Fasilitas" required>
                                                    <?php
                                                    $fasilitas = $this->db->get('karyawan_fasilitas')->result();
                                                    foreach ($fasilitas as $row) : echo '<option value="' . $row->id . '"';
                                                        if ($row->id == $data->fasilitas_id) {
                                                            echo 'selected';
                                                        }
                                                        echo '>' . $row->nama . '</option>' . "\n";
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Work Contract*</label></br>
                                                <select class="selectpicker" id="work_contract" name="work_contract" data-style="select-with-transition" data-width="fix" title="Select Contract" required>
                                                    <?php
                                                    $contract = $this->db->get('karyawan_contract')->result();
                                                    foreach ($contract as $row) : echo '<option value="' . $row->nama . '"';
                                                        if ($row->nama == $data->work_contract) {
                                                            echo 'selected';
                                                        }
                                                        echo '>' . $row->nama . '</option>' . "\n";
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Cost Center*</label></br>
                                                <select class="selectpicker" id="cost_center" name="cost_center" data-style="select-with-transition" data-width="fix" title="Select Cost Center" required>
                                                    <?php
                                                    $cost = $this->db->get('karyawan_cost')->result();
                                                    foreach ($cost as $row) : echo '<option value="' . $row->nama . '"';
                                                        if ($row->nama == $data->cost_center) {
                                                            echo 'selected';
                                                        }
                                                        echo '>' . $row->nama . '</option>' . "\n";
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Atasan 1</label></br>
                                                <select class="selectpicker" id="atasan1" name="atasan1" data-style="select-with-transition" data-width="auto" title="Select Atasan 1" required>
                                                    <?php
                                                    foreach ($posisi as $row) : echo '<option value="' . $row->id . '"';
                                                        if ($row->id == $data->atasan1) {
                                                            echo 'selected';
                                                        }
                                                        echo '>' . $row->nama . '</option>' . "\n";
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-static">Atasan 2</label></br>
                                                <select class="selectpicker" id="atasan2" name="atasan2" data-style="select-with-transition" data-width="auto" title="Select Atasan 2" required>
                                                    <?php
                                                    foreach ($posisi as $row) : echo '<option value="' . $row->id . '"';
                                                        if ($row->id == $data->atasan2) {
                                                            echo 'selected';
                                                        }
                                                        echo '>' . $row->nama . '</option>' . "\n";
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-success" id="btn_save_structure">UPDATE</button>
                                            <a href="<?= base_url('hr/karyawan') ?>" class="btn btn-link btn-default" role="button">Kembali</a>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                            <div class="tab-pane" id="link6">
                            Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                            <br>
                            <br>Dynamically innovate resource-leveling customer service for state of the art customer service.
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    $(document).ready(function() {

        setFormValidation('#formeditProfile');
        setFormValidation('#formeditStucture');

        $('#btn_save_profile').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('hr/modify_karyawan/profile') ?>",
                // dataType : "JSON",
                data : {npk:$('#npk').val(), nama:$('#nama').val(), inisial:$('#inisial').val(), email:$('#email').val(), phone:$('#phone').val()},
                success: function(result){
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

        $('#btn_save_structure').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?= site_url('hr/modify_karyawan/structure') ?>",
                // dataType : "JSON",
                data : {
                    npk:$('#npk').val(), 
                    posisi_id:$('#posisi_id').val(), 
                    div_id:$('#div_id').val(), 
                    dept_id:$('#dept_id').val(), 
                    sect_id:$('#sect_id').val(), 
                    gol_id:$('#gol_id').val(), 
                    fasilitas_id:$('#fasilitas_id').val(), 
                    work_contract:$('#work_contract').val(),
                    cost_center:$('#cost_center').val(),
                    atasan1:$('#atasan1').val(),
                    atasan2:$('#atasan2').val()
                },

                success: function(result){
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

        $('#div_id').change(function() {
            var div = $('#div_id').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('hr/dept') ?>",
                data: {
                    div: div
                },
                success: function(data) {
                    // alert(data)
                    $('#dept_id').html(data);
                    $('#dept_id').selectpicker('refresh');
                    $('#sect_id').selectpicker('val', '');
                    $('#sect_id').selectpicker('refresh');
                }
            })
        });

        $('#dept_id').change(function() {
            var dept = $('#dept_id').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('hr/sect') ?>",
                data: {
                    dept: dept
                },
                success: function(data) {
                    // alert(data)
                    $('#sect_id').html(data);
                    $('#sect_id').selectpicker('refresh');
                }
            })
        });

        $('#updateEwallet').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var ewallet = button.data('ewallet')
            var rek = button.data('rek')
            var modal = $(this)
            modal.find('.modal-body input[name="ewallet"]').val(ewallet)
            modal.find('.modal-body input[name="rek"]').val(rek)
        })  
    });
</script>