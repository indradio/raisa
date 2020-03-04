<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Daftar Tamu</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <a href="<?= base_url('visit/guest'); ?>" class="btn btn-lg btn-block btn-facebook mb-2" role="button" aria-disabled="false">KLIK UNTUK REFRESH</a>
                        <p>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Perusahaan</th>
                                        <th>Keperluan</th>
                                        <th>PIC yg dituju</th>
                                        <th>Waktu Kunjungan</th>
                                        <th class="disabled-sorting">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>ID</th>
                                        <th>Nama</th>
                                        <th>Perusahaan</th>
                                        <th>Keperluan</th>
                                        <th>PIC yg dituju</th>
                                        <th>Waktu Kunjungan</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($visit as $v) : ?>
                                            <td><?= $v['id']; ?></td>
                                            <td><?= $v['nama']; ?></td>
                                            <td><?= $v['perusahaan']; ?></td>
                                            <td><?= $v['keperluan']; ?></td>
                                            <td><?= $v['pic']; ?></td>
                                            <td><?= date('d M H:i', strtotime($v['waktu_kunjungan'])); ?></td>
                                            <td>
                                                <a href="#" class="btn btn-round btn-success" data-toggle="modal" data-target="#cekVisit" 
                                                data-id="<?= $v['id']; ?>"
                                                data-kunjungan="<?= date('d M H:i', strtotime($v['waktu_kunjungan'])); ?>"
                                                data-nama="<?= $v['nama']; ?>"
                                                data-identitas="<?= $v['identitas']; ?>"
                                                data-perusahaan="<?= $v['perusahaan']; ?>"
                                                data-keperluan="<?= $v['keperluan']; ?>"
                                                data-pic="<?= $v['pic']; ?>"
                                                data-point1="<?= $v['point1']; ?>"
                                                data-point2="<?= $v['point2']; ?>"
                                                data-point3="<?= $v['point3']; ?>"
                                                data-point4="<?= $v['point4']; ?>"
                                                data-point5="<?= $v['point5']; ?>"
                                                data-point6="<?= $v['point6']; ?>"
                                                >Proses</a>
                                            </td>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
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
<div class="modal fade" id="cekVisit" tabindex="-1" role="dialog" aria-labelledby="cekVisitTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">DATA TAMU</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('visit/check'); ?>">
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-md-4 col-form-label">ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Waktu Kunjungan</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="kunjungan" name="kunjungan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Nama</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="nama" name="nama">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">No. Identitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="identitas" name="identitas">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Perusahaan</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="perusahaan" name="perusahaan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Keperluan</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control disabled" id="keperluan" name="keperluan"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Pihak yg dituju</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="pic_dituju" name="pic_dituju">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-10 col-form-label">Apakah dalam 14 hari terakhir anda memiliki riwayat perjalanan ke Cina atau negara/wilayah terjangkit virus corona?</label>
                            <div class="col-md-2">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="point1" name="point1">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-10 col-form-label">Dalam 14 hari terakhir pernah melakukan interaksi dengan Warga Negara Asing dari negara/wilayah terjangkit virus corona?</label>
                            <div class="col-md-2">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="point2" name="point2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-10 col-form-label">Pernah melakukan interaksi dengan keluarga/kerabat yang menjadi suspect bahkan positif terjangkit virus corona?</label>
                            <div class="col-md-2">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="point3" name="point3">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-10 col-form-label">Dalam 3 hari terakhir mengalami demam dengan suhu tubuh >38°C?</label>
                            <div class="col-md-2">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="point4" name="point4">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-10 col-form-label">Sedang batuk/pilek/nyeri tenggorokan?</label>
                            <div class="col-md-2">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="point5" name="point5">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-10 col-form-label">Sedang pneumonia (sesak nafas) ringan hingga berat?</label>
                            <div class="col-md-2">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="point6" name="point6">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">PIC</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="pic" id="pic" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <?php
                                        $this->db->where('is_active', '1');
                                        $krywn = $this->db->get_where('karyawan', ['status' => '1'])->result_array();
                                        foreach ($krywn as $k) : ?>
                                            <option value="<?= $k['inisial']; ?>"><?= $k['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Suhu Tubuh</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="number" class="form-control" id="suhu" name="suhu" required>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                      <label class="col-sm-3 col-form-label label-checkbox">Hasil</label>
                      <div class="col-sm-9 checkbox-radios">
                        <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="hasil" value="TERIMA" checked> TERIMA
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="hasil" value="TOLAK"> TOLAK
                            <span class="circle">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </div>
                    </div>
                        <div class="modal-footer justify-content-right">
                            <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</a>
                            <button type="submit" class="btn btn-success">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
      $('#cekVisit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var kunjungan = button.data('kunjungan') 
        var nama = button.data('nama') // Extract info from data-* attributes
        var identitas = button.data('identitas') 
        var perusahaan = button.data('perusahaan') 
        var keperluan = button.data('keperluan') 
        var pic = button.data('pic') 
        var point1 = button.data('point1') 
        var point2 = button.data('point2') 
        var point3 = button.data('point3') 
        var point4 = button.data('point4') 
        var point5 = button.data('point5') 
        var point6 = button.data('point6') 
        var modal = $(this)
        modal.find('.modal-body input[name="id"]').val(id)
        modal.find('.modal-body input[name="kunjungan"]').val(kunjungan)
        modal.find('.modal-body input[name="nama"]').val(nama)
        modal.find('.modal-body input[name="identitas"]').val(identitas)
        modal.find('.modal-body input[name="perusahaan"]').val(perusahaan)
        modal.find('.modal-body textarea[name="keperluan"]').val(keperluan)
        modal.find('.modal-body input[name="pic_dituju"]').val(pic)
        modal.find('.modal-body input[name="point1"]').val(point1)
        modal.find('.modal-body input[name="point2"]').val(point2)
        modal.find('.modal-body input[name="point3"]').val(point3)
        modal.find('.modal-body input[name="point4"]').val(point4)
        modal.find('.modal-body input[name="point5"]').val(point5)
        modal.find('.modal-body input[name="point6"]').val(point6)
      
        });
    })
</script>