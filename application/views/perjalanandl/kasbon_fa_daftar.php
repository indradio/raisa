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
                        <h4 class="card-title">Daftar Perjalanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dtkasbon" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No Perjalanan</th>
                                        <th>Waktu Berangkat</th>
                                        <th>Nama <small>(<i>Pemohon</i>)</small></th>
                                        <th>Nama <small>(<i>PIC</i>)</small></th>
                                        <th>e-Wallet</th>
                                        <th>Tujuan</th>
                                        <th>Kendaraan</th>
                                        <th>Biaya Perjalanan</th>
                                        <th>Kasbon <small>(<i>Out</i>)</small></th>
                                        <th>Kasbon <small>(<i>In</i>)</small></th>
                                        <th>Kasbon <small>(<i>Remains</i>)</small></th>
                                        <th>Status</th>
                                        <th>Proses GA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($perjalanan as $p) :
                                        $this->db->where('inisial', $p['pic_perjalanan']);
                                        $pic = $this->db->get('karyawan')->row_array();
                                        if (empty($pic['ewallet_1'])){
                                            $ewallet1 = '';
                                        }else{
                                            $ewallet1 = $pic['ewallet_1'];
                                        }
                                        if (empty($pic['ewallet_2'])){
                                            $ewallet2 = '';
                                        }else{
                                            $ewallet2 = $pic['ewallet_2'];
                                        }

                                        if ( $p['kasbon_status']=='REQUEST'){
                                            echo '<tr data-toggle="modal" data-target="#kasbon" data-id="'. $p['id'].'" data-phone="'. $pic['phone'].'" data-nama="'. $pic['nama'].'" data-ewallet1="'. $ewallet1 .'" data-ewallet2="'. $ewallet2.'" data-total="'. $p['total'].'" data-kasbon="'. $p['kasbon'].'">';
                                        }elseif ( $p['kasbon_status']=='OUTSTANDING'){
                                            echo '<tr class="table-danger" data-toggle="modal" data-target="#detailKasbon" data-id="'. $p['id'].'" data-phone="'. $pic['phone'].'" data-nama="'. $pic['nama'].'" data-ewallet="'. $p['kasbon_ewallet'].'" data-total="'. number_format($p['total'], 0, ',', '.').'" data-kasbon_out="'. number_format($p['kasbon_out'], 0, ',', '.').'"data-kasbon_in="'. number_format($p['kasbon_in'], 0, ',', '.').'"data-kasbon="'. number_format($p['kasbon'], 0, ',', '.').'"data-kasbon_by="'. $p['kasbon_by'].' at '.date("d-m-Y H:i", strtotime($p['kasbon_at'])).'">';
                                        } else {
                                            echo '<tr data-toggle="modal" data-target="#detailKasbon" data-id="'. $p['id'].'" data-phone="'. $pic['phone'].'" data-nama="'. $pic['nama'].'" data-ewallet1="'. $ewallet1 .'" data-ewallet2="'. $ewallet2.'" data-total="'. number_format($p['total'], 0, ',', '.').'" data-kasbon_out="'. number_format($p['kasbon_out'], 0, ',', '.').'"data-kasbon_in="'. number_format($p['kasbon_in'], 0, ',', '.').'"data-kasbon="'. number_format($p['kasbon'], 0, ',', '.').'"data-kasbon_by="'. $p['kasbon_by'].' at '.date("d-m-Y H:i", strtotime($p['kasbon_at'])).'">';
                                        }?>
                                        <td><?= $p['id'].' - '.$p['jenis_perjalanan']; ?></td>
                                        <td><?= date('d M', strtotime($p['tglberangkat'])) . ' - ' . date('H:i', strtotime($p['jamberangkat'])); ?></td>
                                        <td><?= $p['nama']; ?></td>
                                        <td><?= $pic['nama']; ?></td>
                                        <td><?= $pic['ewallet_1']; ?></td>
                                        <td><?= $p['tujuan']; ?></td>
                                        <td><?= $p['kepemilikan']; ?></td>
                                        <td><?= number_format($p['total'], 0, ',', '.'); ?></td>
                                        <td><?= number_format($p['kasbon_out'], 0, ',', '.'); ?></td>
                                        <td><?= number_format($p['kasbon_in'], 0, ',', '.'); ?></td>
                                        <td><?= number_format($p['kasbon'], 0, ',', '.'); ?></td>
                                        <td><?= $p['kasbon_status']; ?></td>
                                        <td><?= $p['admin_ga'].' - '.date("d-m-Y H:i", strtotime($p['tgl_ga'])); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No Perjalanan</th>
                                        <th>Waktu Berangkat</th>
                                        <th>Nama <small>(<i>Pemohon</i>)</small></th>
                                        <th>PIC</th>
                                        <th>e-Wallet</th>
                                        <th>Tujuan</th>
                                        <th>Kendaraan</th>
                                        <th>Total</th>
                                        <th>Kasbon</th>
                                        <th>Kasbon</th>
                                        <th>Kasbon</th>
                                        <th>Status</th>
                                        <th>Proses GA</th>
                                    </tr>
                                </tfoot>
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
<!-- Modal -->
<div class="modal fade" id="kasbon" tabindex="-1" role="dialog" aria-labelledby="kasbonLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kasbonLabel">Permintaan Kasbon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/kasbon/submit'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">PIC Perjalanan</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="hidden" class="form-control disabled" id="phone" name="phone" />
                                <input type="text" class="form-control disabled" id="nama" name="nama" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">GO-PAY</label>
                        <div class="col-md-5">
                            <div class="form-group has-default">
                                <input class="form-check-input d-inline-block ml-1" type="radio" name="ewallet" value="gopay" checked requierd/>
                                <input type="text" class="form-control bg-white ml-4" id="ewallet1" name="ewallet1" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">DANA</label>
                        <div class="col-md-5">
                            <div class="form-group has-default">
                                <input class="form-check-input d-inline-block ml-1" type="radio" name="ewallet" value="dana" requierd/>
                                <input type="text" class="form-control bg-white ml-4" id="ewallet2" name="ewallet2" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Total Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="total" name="total" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Kasbon</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="number" class="form-control" id="kasbon" name="kasbon" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">TRANSFER</button>
                </div>
                <div class="modal-footer">
                    <small>Tranfernya pake aplikasi e-Wallet di HP ya!</small>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="detailKasbon" tabindex="-1" role="dialog" aria-labelledby="detailKasbonLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailKasbonLabel">Permintaan Kasbon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="<?= base_url('perjalanandl/kasbon/submit'); ?>">
                <div class="modal-body">
                    <div class="form-group" hidden="true">
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">PIC Perjalanan</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="hidden" class="form-control disabled" id="phone" name="phone" />
                                <input type="text" class="form-control disabled" id="nama" name="nama" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">e-Wallet</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="ewallet" name="ewallet" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Total Biaya</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="total" name="total" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Kasbon Out</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="kasbon_out" name="kasbon_out" />
                                <input type="text" class="form-control disabled" id="kasbon_by" name="kasbon_by" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Kasbon In</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="kasbon_in" name="kasbon_in" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-5 col-form-label">Kasbon</label>
                        <div class="col-md-7">
                            <div class="form-group has-default">
                                <input type="text" class="form-control disabled" id="kasbon" name="kasbon" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#kasbon').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var phone = button.data('phone')
            var nama = button.data('nama')
            var ewallet1 = button.data('ewallet1')
            var ewallet2 = button.data('ewallet2')
            var total = button.data('total')
            var kasbon = button.data('kasbon')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="phone"]').val(phone)
            modal.find('.modal-body input[name="nama"]').val(nama)
            modal.find('.modal-body input[name="ewallet1"]').val(ewallet1)
            modal.find('.modal-body input[name="ewallet2"]').val(ewallet2)
            modal.find('.modal-body input[name="total"]').val(total)
            modal.find('.modal-body input[name="kasbon"]').val(kasbon)
        })

        $('#detailKasbon').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var phone = button.data('phone')
            var nama = button.data('nama')
            var ewallet = button.data('ewallet')
            var total = button.data('total')
            var kasbon_by = button.data('kasbon_by')
            var kasbon_out = button.data('kasbon_out')
            var kasbon_in = button.data('kasbon_in')
            var kasbon = button.data('kasbon')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="phone"]').val(phone)
            modal.find('.modal-body input[name="nama"]').val(nama)
            modal.find('.modal-body input[name="ewallet"]').val(ewallet)
            modal.find('.modal-body input[name="total"]').val(total)
            modal.find('.modal-body input[name="kasbon_by"]').val(kasbon_by)
            modal.find('.modal-body input[name="kasbon_out"]').val(kasbon_out)
            modal.find('.modal-body input[name="kasbon_in"]').val(kasbon_in)
            modal.find('.modal-body input[name="kasbon"]').val(kasbon)
        })

        $('#dtkasbon').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        order: [
            [11, 'desc']
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });
    });
</script>