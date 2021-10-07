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
                        <div class="toolbar"></div>
                        <div class="material-datatables">
                            <table id="exportdesc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Rencana Kunjungan</th>
                                        <th>Nama</th>
                                        <th>Warga Negara</th>
                                        <th>Perusahaan</th>
                                        <th>Keperluan</th>
                                        <th>PIC</th>
                                        <th>Kategori</th>
                                        <th>Point1</th>
                                        <th>Point2</th>
                                        <th>Point3</th>
                                        <th>Point4</th>
                                        <th>Point5</th>
                                        <th>Point6</th>
                                        <th>Suhu</th>
                                        <th>Hasil</th>
                                        <th>Pemeriksa</th>
                                        <th>Tgl Pemeriksaan</th>
                                        <th>Status</th>
                                        <!-- <th class="disabled-sorting">Actions</th> -->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Rencana Kunjungan</th>
                                        <th>Nama</th>
                                        <th>Warga Negara</th>
                                        <th>Perusahaan</th>
                                        <th>Keperluan</th>
                                        <th>PIC</th>
                                        <th>Kategori</th>
                                        <th>Point1</th>
                                        <th>Point2</th>
                                        <th>Point3</th>
                                        <th>Point4</th>
                                        <th>Point5</th>
                                        <th>Point6</th>
                                        <th>Suhu</th>
                                        <th>Hasil</th>
                                        <th>Pemeriksa</th>
                                        <th>Tgl Pemeriksaan</th>
                                        <th>Status</th>
                                        <!-- <th>Actions</th> -->
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($visit as $v) : 
                                    if ($v['warganegara']=='WNA' or $v['point1']=='YA' or $v['point2']=='YA' or $v['point3']=='YA' or $v['point4']=='YA' or $v['point5']=='YA' or $v['point6']=='YA')
                                    {
                                        echo '<tr class="text-white bg-danger">';
                                    }else{
                                        echo '<tr>';
                                    }
                                        ?>
                                            <td><?= date('Y-m-d H:i', strtotime($v['waktu_kunjungan'])); ?></td>
                                            <td><?= $v['nama']; ?></td>
                                            <td><?= $v['warganegara'].' - '.$v['negara']; ?></td>
                                            <td><?= $v['perusahaan']; ?></td>
                                            <td><?= $v['keperluan']; ?></td>
                                            <td><?= $v['pic']; ?></td>
                                            <td><?= $v['kategori']; ?></td>
                                            <td><?= $v['point1']; ?></td>
                                            <td><?= $v['point2']; ?></td>
                                            <td><?= $v['point3']; ?></td>
                                            <td><?= $v['point4']; ?></td>
                                            <td><?= $v['point5']; ?></td>
                                            <td><?= $v['point6']; ?></td>
                                            <?php if ($v['status']==1){ ?>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>Belum Berkunjung</td>
                                            <?php }elseif ($v['status']==2){ ?>
                                                <td><?= $v['suhu']; ?></td>
                                                <td>DI<?= $v['hasil']; ?></td>
                                                <td><?= $v['check_by']; ?></td>
                                                <td><?= date('d M H:i', strtotime($v['check_at'])); ?></td>
                                                <td>Sedang/Sudah Berkunjung</td>
                                            <?php }else{ ?>
                                                <td>-</td>
                                                <td><?= $v['hasil']; ?></td>
                                                <td><?= $v['check_by']; ?></td>
                                                <td><?= date('d M H:i', strtotime($v['check_at'])); ?></td>
                                                <td>Tidak jadi Berkunjung</td>
                                            <?php } ?>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    Point 1 : Apakah dalam 14 hari terakhir anda memiliki riwayat perjalanan ke Cina atau negara/wilayah terjangkit virus corona?
                    </br>
                    Point 2 : Dalam 14 hari terakhir pernah melakukan interaksi dengan Warga Negara Asing dari negara/wilayah terjangkit virus corona?
                    </br>
                    Point 3 : Pernah melakukan interaksi dengan keluarga/kerabat yang menjadi suspect bahkan positif terjangkit virus corona?
                    </br>
                    Point 4 : Dalam 3 hari terakhir mengalami demam dengan suhu tubuh >38°C?
                    </br>
                    Point 5 : Sedang batuk/pilek/nyeri tenggorokan?
                    </br>
                    Point 6 : Sedang pneumonia (sesak nafas) ringan hingga berat?
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
                                    <input type="text" class="form-control" id="identitas" name="identitas">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Perusahaan</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" id="perusahaan" name="perusahaan">
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
                                            <option value="WH">WAREHOUSE</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Kategori</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="kategori" id="kategori" onchange="kategoriSelect(this);" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <option value="CUSTOMER">CUSTOMER</option>
                                        <option value="SUPPLIER">SUPPLIER / KURIR</option>
                                        <option value="VENDOR">VENDOR</option>
                                        <option value="LAINNYA">LAINNYA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label" id="k1_lain" style="display:none;"></label>
                            <div class="col-md-7" id="k2_lain" style="display:none;">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" id="kategori_lain" name="kategori_lain">
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

        $('#exportdesc').DataTable({
        "pagingType": "full_numbers",
        scrollX: true,
        dom: 'Bfrtip',
        buttons: [
            'csv', 'print'
        ],
        order: [
            [0, 'desc']
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
        });

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

    function kategoriSelect(valueSelect)
    {
        var ktgr = valueSelect.options[valueSelect.selectedIndex].value;
        document.getElementById("k1_lain").style.display = ktgr == 'LAINNYA' ? "block" : 'none';
        document.getElementById("k2_lain").style.display = ktgr == 'LAINNYA' ? "block" : 'none';
    }

    $(document).ready(function() {
        $('#kategori').change(function() {
            var kategori = $('#kategori').val();
            if (kategori == 'LAINNYA') {
                $('#kategori_lain').prop('required', true);
            } else {
                $('#kategori_lain').prop('required', false);
            }
        });
    });
</script>