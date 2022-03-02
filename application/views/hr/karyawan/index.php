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
                        <a href="<?= site_url('hr/addKaryawan'); ?>" class="btn btn-facebook"><i class="material-icons">person_add</i> Tambah</a>
                    </div>
                    <div class="material-datatables">
                        <table id="dtKaryawan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                            <tr>
                                <th>NPK</th>
                                <th>Inisial</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Divisi</th>
                                <th>Department</th>
                                <th>Section</th>
                                <th>Posisi</th>
                                <th>Golongan</th>
                                <th>Fasilitas</th>
                                <th>Cost Center</th>
                                <th>Work</th>
                                <th>Status</th>
                                <th>Aktif</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>NPK</th>
                                <th>Inisial</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Divisi</th>
                                <th>Department</th>
                                <th>Section</th>
                                <th>Posisi</th>
                                <th>Golongan</th>
                                <th>Fasilitas</th>
                                <th>Cost Center</th>
                                <th>Work</th>
                                <th>Status</th>
                                <th>Aktif</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>
            <!-- end col-md-12 --> 
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<!-- Modal Tambah Karyawan -->
<div class="modal fade" id="addKaryawan" tabindex="-1" role="dialog" aria-labelledby="addKaryawanTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Tambah Karyawan Baru</h4>
                    </div>
                </div>
                <?= form_open_multipart('hr/tambah'); ?>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label">NPK*</label></br>
                                    <input type="text" class="form-control" name="npk" id="npk" required/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label">Inisial*</label></br>
                                    <input type="text" class="form-control" name="inisial" id="inisial" required/>
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
                                    <label class="bmd-label">E-Mail*</label></br>
                                    <input type="email" class="form-control" name="email" id="email" required/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label">No. HP*</label></br>
                                    <input type="email" class="form-control" name="phone" id="phone" required/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label">Divisi*</label></br>
                                    <select class="selectpicker" name="div" id="div" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                    <?php
                                    $divisi = $this->db->get('karyawan_div')->result();
                                    foreach ($divisi as $row) :
                                        echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label">Department*</label></br>
                                    <select class="selectpicker" name="dept" id="dept" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required></select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label">Unit Organisasi*</label></br>
                                    <select class="selectpicker" name="sect" id="sect" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required></select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label">Posisi*</label></br>
                                    <select class="selectpicker" name="posisi" id="posisi" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                    <?php
                                    $posisi = $this->db->get('karyawan_posisi')->result();
                                    foreach ($posisi as $row) :
                                        echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label">Golongan*</label></br>
                                    <select class="selectpicker" name="gol" id="gol" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                    <?php
                                    $gol = $this->db->get('karyawan_gol')->result();
                                    foreach ($gol as $row) :
                                        echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label">Fasilitas*</label></br>
                                    <select class="selectpicker" name="fasilitas" id="fasilitas" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                    <?php
                                    $fasilitas = $this->db->get('karyawan_fasilitas')->result();
                                    foreach ($fasilitas as $row) :
                                        echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Atasan 1</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="atasan1" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $posisi = $this->db->get('karyawan_posisi')->result_array();
                                    foreach ($posisi as $po) : ?>
                                        <option value="<?= $po['id']; ?>"><?= $po['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Atasan 2</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="atasan2" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $posisi = $this->db->get('karyawan_posisi')->result_array();
                                    foreach ($posisi as $po) : ?>
                                        <option value="<?= $po['id']; ?>"><?= $po['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Role (Hanya untuk menu RAISA)</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="role" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $role = $this->db->order_by('id', "ASC");
                                    $role = $this->db->get('user_role')->result_array();
                                    foreach ($role as $ro) : ?>
                                        <option value="<?= $ro['id']; ?>"><?= $ro['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Foto</label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail img-circle">
                                        <img src="<?= base_url(); ?>assets/img/default-avatar.png" alt="foto">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                                    <div>
                                        <span class="btn btn-round btn-rose btn-file">
                                            <span class="fileinput-new">Pilih Foto</span>
                                            <span class="fileinput-exists">Ganti</span>
                                            <input type="file" name="foto" />
                                        </span>
                                        <br />
                                        <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i>Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary btn-link btn-wd btn-lg">SIMPAN</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#div').change(function() {
            var div = $('#div').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('hr/dept') ?>",
                data: {
                    div: div
                },
                success: function(data) {
                    // alert(data)
                    $('#dept').html(data);
                    $('#dept').selectpicker('refresh');
                    $('#sect').selectpicker('val', '');
                    $('#sect').selectpicker('refresh');
                }
            })
        })
        $('#dept').change(function() {
            var dept = $('#dept').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('hr/sect') ?>",
                data: {
                    dept: dept
                },
                success: function(data) {
                    // alert(data)
                    $('#sect').html(data);
                    $('#sect').selectpicker('refresh');
                }
            })
        })

        $('#dtKaryawan').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            // responsive: true,
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
            zeroRecords: "Oops!",
            },
            processing: true,
            ajax: {
                    "url": "<?= site_url('hr/getData') ?>",
                    "type": "POST"
                },
            scrollX: true,
            order: [], //Initial no order.
            columnDefs: [
                {
                    "targets": [15], //first column / numbering column
                    "orderable": false, //set not orderable
                    "defaultContent": "<button type='button' rel='tooltip' class='btn btn-success btn-link btn-just-icon' data-original-title='' title=''><i class='material-icons'>edit</i></button>",
                }, 
            ],
            columns: [
                { "data": "npk" },
                { "data": "inisial" },
                { "data": "nama" },
                { "data": "email" },
                { "data": "phone" },
                { "data": "div" },
                { "data": "dept" },
                { "data": "sect" },
                { "data": "posisi" },
                { "data": "gol" },
                { "data": "fasilitas" },
                { "data": "cost_center" },
                { "data": "work_contract" },
                { "data": "status" },
                { "data": "is_active" }
            ],
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
    
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        });
    });
</script>