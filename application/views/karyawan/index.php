<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">account_box</i>
                        </div>
                        <h4 class="card-title">Data Karyawan</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!-- Here you can write extra buttons/actions for the toolbar -->
                            <a href="#" class="btn btn-facebook mb-2" role="button" aria-disabled="false" data-toggle="modal" data-target="#karyawanAdd">Tambah Karyawan Baru</a>
                            <a href="<?= base_url('hr/qrc/'); ?>" class="btn btn-warning disabled">Generate QR CODE</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Foto</th>
                                        <th>NPK</th>
                                        <th>Inisial</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No. HP</th>
                                        <th>Golongan</th>
                                        <th>Fasilitas</th>
                                        <th>Posisi</th>
                                        <th>Divisi</th>
                                        <th>Departemen</th>
                                        <th>Seksi</th>
                                        <th>Atasan 1</th>
                                        <th>Atasan 2</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>QR Code</th>
                                        <th>Foto</th>
                                        <th>NPK</th>
                                        <th>Inisial</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No. HP</th>
                                        <th>Golongan</th>
                                        <th>Fasilitas</th>
                                        <th>Posisi</th>
                                        <th>Divisi</th>
                                        <th>Departemen</th>
                                        <th>Seksi</th>
                                        <th>Atasan 1</th>
                                        <th>Atasan 2</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($datakaryawan as $kry) :
                                        $golongan = $this->db->get_where('karyawan_gol', ['id' =>  $kry['gol_id']])->row_array();
                                        $fasilitas = $this->db->get_where('karyawan_fasilitas', ['id' =>  $kry['fasilitas_id']])->row_array();
                                        $posisi = $this->db->get_where('karyawan_posisi', ['id' =>  $kry['posisi_id']])->row_array();
                                        $divisi = $this->db->get_where('karyawan_div', ['id' =>  $kry['div_id']])->row_array();
                                        $departemen = $this->db->get_where('karyawan_dept', ['id' =>  $kry['dept_id']])->row_array();
                                        $seksi = $this->db->get_where('karyawan_sect', ['id' =>  $kry['sect_id']])->row_array();
                                        $atasan1 = $this->db->get_where('karyawan_posisi', ['id' =>  $kry['atasan1']])->row_array();
                                        $atasan2 = $this->db->get_where('karyawan_posisi', ['id' =>  $kry['atasan2']])->row_array();
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="img-container">
                                                    <img src="<?= base_url(); ?>assets/img/qrcode/<?= $kry['qrcode'] . '.png'; ?>" alt="...">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="img-container">
                                                    <img src="<?= base_url(); ?>assets/img/faces/<?= $kry['foto']; ?>" alt="...">
                                                </div>
                                            </td>
                                            <td><?= $kry['npk']; ?></td>
                                            <td><?= $kry['inisial']; ?></td>
                                            <td><?= $kry['nama']; ?></td>
                                            <td><?= $kry['email']; ?></td>
                                            <td><?= $kry['phone']; ?></td>
                                            <td><?= (!empty($golongan)) ? $golongan['nama'] : 'TIDAK ADA'; ?></td>
                                            <td><?= (!empty($fasilitas)) ? $fasilitas['nama'] : 'TIDAK ADA'; ?></td>
                                            <td><?= $posisi['nama']; ?></td>
                                            <td><?= $divisi['nama']; ?></td>
                                            <td><?= $departemen['nama']; ?></td>
                                            <td><?= $seksi['nama']; ?></td>
                                            <td><?= $atasan1['nama']; ?></td>
                                            <td><?= $atasan2['nama']; ?></td>
                                            <td><?= ($kry['is_active'] == 1) ? 'AKTIF' : 'TIDAK AKTIF'; ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('hr/ubah/') . $kry['npk']; ?>" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">dvr</i></a>
                                                <a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<!-- Modal Tambah Karyawan -->
<div class="modal fade" id="karyawanAdd" tabindex="-1" role="dialog" aria-labelledby="karyawanAddTitle" aria-hidden="true">
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
                    <div class="card-body">
                        <div class="row">
                            <label class="col-md-3 col-form-label">NPK</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="npk" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Inisial</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="inisial" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="nama" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Email</label>
                            <div class="col-md-9">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">No HP</label>
                            <div class="col-md-9">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" name="phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Divisi</label>
                            <div class="col-md-9">
                                <select class="selectpicker" id="div" name="div" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $divisi = $this->db->get('karyawan_div')->result_array();
                                    foreach ($divisi as $div) : ?>
                                        <option value="<?= $div['id']; ?>"><?= $div['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Departemen</label>
                            <div class="col-md-9">
                                <select class="selectpicker" id="dept" name="dept" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required></select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Unit Organisasi</label>
                            <div class="col-md-9">
                                <select class="selectpicker" id="sect" name="sect" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required></select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Posisi</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="posisi" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $posisi = $this->db->get('karyawan_posisi')->result_array();
                                    foreach ($posisi as $po) : ?>
                                        <option value="<?= $po['id']; ?>"><?= $po['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Golongan</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="gol" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $golongan = $this->db->get('karyawan_gol')->result_array();
                                    foreach ($golongan as $gol) : ?>
                                        <option value="<?= $gol['id']; ?>"><?= $gol['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Fasilitas</label>
                            <div class="col-md-9">
                                <select class="selectpicker" name="fasilitas" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" required>
                                    <?php
                                    $fasilitas = $this->db->get('karyawan_fasilitas')->result_array();
                                    foreach ($fasilitas as $f) : ?>
                                        <option value="<?= $f['id']; ?>"><?= $f['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary btn-link btn-wd btn-lg">TAMBAH</button>
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
    });
</script>