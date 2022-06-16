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
                    <div class="toolbar"></div>
                    <div class="material-datatables">
                        <table id="dtKaryawan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                            <tr>
                                <th>NPK</th>
                                <th>Inisial</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Tempat Lahir</th>
                                <th>Tgl Lahir</th>
                                <th>Phone</th>
                                <th>Alamat KTP</th>
                                <th>Prov</th>
                                <th>Kab/Kota</th>
                                <th>Kec</th>
                                <th>Desa</th>
                                <th>Alamat Domisili</th>
                                <th>Prov</th>
                                <th>Kab/Kota</th>
                                <th>Kec</th>
                                <th>Desa</th>
                                <!-- <th>Nama Kerabat (Darurat)</th>
                                <th>Alamat (Darurat)</th>
                                <th>Kontak (Darurat)</th>
                                <th>Hubungan Kerabat</th>
                                <th>Pernikahan</th>
                                <th>Memiliki Anak</th>
                                <th>Action</th> -->
                            </tr>
                            </thead>
                            <!-- <tfoot>
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
                            </tfoot> -->
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

<div class="modal fade" id="editKaryawan" tabindex="-1" role="dialog" aria-labelledby="editKaryawanTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
      <form class="form" id="formeditKaryawan" method="post" action="karyawan/edit">
          <div class="modal-body">
              <input type="hidden" class="form-control" id="npk" name="npk" />
              <h4 class="card-title text-center">Pastikan user tidak memiliki Outstanding?</h4>
          </div>
          <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
              <button type="submit" class="btn btn-success">LANJUTKAN</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dtKaryawan').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            // responsive: true,
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
            zeroRecords: "Oops!",
            },
            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'excelHtml5',
                    title: 'DATA KARYAWAN',
                    text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i>',
                    footer: true
                }
            ],
            processing: true,
            ajax: {
                    "url": "<?= site_url('hr/getDetails') ?>",
                    "type": "POST"
                },
            scrollX: true,
            order: [], //Initial no order.
            columnDefs: [
                {
                    "targets": [15], //first column / numbering column
                    "orderable": false, //set not orderable
                    "defaultContent": "<button type='button' rel='tooltip' class='btn btn-success btn-link btn-just-icon edit' id='btn_edit' data-original-title='' title=''><i class='material-icons'>edit</i></button>",
                }, 
            ],
            columns: [
                { "data": "npk" },
                { "data": "inisial" },
                { "data": "nama" },
                { "data": "nik" },
                { "data": "tmp_lahir" },
                { "data": "tgl_lahir" },
                { "data": "kontak" },
                { "data": "alamat_ktp" },
                { "data": "provinsi_ktp" },
                { "data": "kabupaten_ktp" },
                { "data": "kecamatan_ktp" },
                { "data": "desa_ktp" },
                { "data": "alamat" },
                { "data": "provinsi" },
                { "data": "kabupaten" },
                { "data": "kecamatan" },
                { "data": "desa" }
            ]
        });

        var table = $('#dtKaryawan').DataTable();

        // Edit record
        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');
            var data = table.row( $tr ).data();
            $('#editKaryawan').modal();
            $('#editKaryawan').find('.modal-body input[name="npk"]').val(data['npk']);
            // alert('You press on Row: ' + data['npk'] + '\'s row.');
        });

    });
</script>