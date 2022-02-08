<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                        <i class="material-icons">emoji_transportation</i>
                        </div>
                        <p class="card-category">Perjalanan</p>
                        <h3 class="card-title"></h3>
                    </div>
                        <div class="card-footer">
                            <a href="#" id="btn_reservasi" class="btn btn-facebook btn-block">Reservasi</a>
                        </div>
                    </div>
                </div>
           
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header">
                  <h4 class="card-title">
                    <!-- <small class="description">PerjalananKu</small> -->
                </h4>
                </div>
                <div class="card-body ">
                <div class="table-responsive">
                    <div class="material-datatables">
                      <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                          <tr>
                            <!-- <th> -->
                            <ul class="nav nav-pills nav-pills-info" role="tablist" style="flex-wrap:unset">
                                <li class="nav-item">
                                <a class="nav-link active show" data-toggle="tab" href="#link1" role="tablist">
                                    Aktif
                                </a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link2" role="tablist">
                                    Perjalanan
                                </a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link3" role="tablist">
                                    Penyelesaian
                                </a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link4" role="tablist">
                                    Verifikasi
                                </a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link5" role="tablist">
                                    Payment
                                </a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link9" role="tablist">
                                    Selesai
                                </a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link0" role="tablist">
                                    Dibatalkan
                                </a>
                                </li>
                            </ul>
                            <!-- </th> -->
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                  <div class="tab-content tab-space">
                    <div class="tab-pane active show" id="link1">
                        <div class="material-datatables">
                            <table id="dtdesc1" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Status</th>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                                  $this->db->where('status >' , '0');
                                                  $this->db->where('status <' , '9');
                                    $perjalanan = $this->db->get_where('perjalanan', ['npk' => $this->session->userdata('npk')])->result_array();
                                    foreach ($perjalanan as $row) : ?>
                                            <tr>
                                                <?php $status = $this->db->get_where('perjalanan_status', ['id' => $row['status']])->row_array(); ?>
                                                <td>
                                                    <?= $status['nama']; ?>
                                                    <?php if ($row['status'] == 1) { ?>
                                                        <a href="<?= base_url('perjalanandl/tambahwaktudl/') . $row['id']; ?>" class="badge badge-warning">+1 JAM</a>
                                                        <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#batalDl" data-id="<?= $row['id']; ?>">BATALKAN</a>
                                                    <?php }; ?>
                                                </td>
                                                <td><?= $row['id'].'-'.$row['jenis_perjalanan']; ?></td>
                                                <td><?= date('d M Y', strtotime($row['tglberangkat'])); ?></td>
                                                <td><?= $row['tujuan']; ?></td>
                                                <td><?= $row['anggota']; ?></td>
                                                <td><?= $row['keperluan']; ?></td>
                                                <td><?= $row['kepemilikan']; ?></td>
                                            </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="link2">
                        <div class="material-datatables">
                            <table id="dtdesc2" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                                  $this->db->where('status >=' , '1');
                                                  $this->db->where('status <=' , '2');
                                    $perjalanan = $this->db->get_where('perjalanan', ['npk' => $this->session->userdata('npk')])->result_array();
                                    foreach ($perjalanan as $row) : ?>
                                            <tr>
                                                <td><?= $row['id'].'-'.$row['jenis_perjalanan']; ?></td>
                                                <td><?= date('d M Y', strtotime($row['tglberangkat'])); ?></td>
                                                <td><?= $row['tujuan']; ?></td>
                                                <td><?= $row['anggota']; ?></td>
                                                <td><?= $row['keperluan']; ?></td>
                                                <td><?= $row['kepemilikan']; ?></td>
                                            </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="link3">
                        <div class="material-datatables">
                            <table id="dtdesc3" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                                  $this->db->where('status' , '3');
                                    $perjalanan = $this->db->get_where('perjalanan', ['npk' => $this->session->userdata('npk')])->result_array();
                                    foreach ($perjalanan as $row) : ?>
                                            <tr onclick="window.location='<?= base_url('perjalanan/penyelesaian/' . $row['id']); ?>'">
                                                <td><?= $row['id'].'-'.$row['jenis_perjalanan']; ?></td>
                                                <td><?= date('d M Y', strtotime($row['tglberangkat'])); ?></td>
                                                <td><?= $row['tujuan']; ?></td>
                                                <td><?= $row['anggota']; ?></td>
                                                <td><?= $row['keperluan']; ?></td>
                                                <td><?= $row['kepemilikan']; ?></td>
                                            </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="link4">
                        <div class="material-datatables">
                            <table id="dtdesc4" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                                  $this->db->where('status' , '4');
                                    $perjalanan = $this->db->get_where('perjalanan', ['npk' => $this->session->userdata('npk')])->result_array();
                                    foreach ($perjalanan as $row) : ?>
                                            <tr>
                                                <td><?= $row['id'].'-'.$row['jenis_perjalanan']; ?></td>
                                                <td><?= date('d M Y', strtotime($row['tglberangkat'])); ?></td>
                                                <td><?= $row['tujuan']; ?></td>
                                                <td><?= $row['anggota']; ?></td>
                                                <td><?= $row['keperluan']; ?></td>
                                                <td><?= $row['kepemilikan']; ?></td>
                                            </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="link5">
                        <div class="material-datatables">
                            <table id="dtdesc5" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                                  $this->db->where('status' , '5');
                                    $perjalanan = $this->db->get_where('perjalanan', ['npk' => $this->session->userdata('npk')])->result_array();
                                    foreach ($perjalanan as $row) : ?>
                                            <tr>
                                                <td><?= $row['id'].'-'.$row['jenis_perjalanan']; ?></td>
                                                <td><?= date('d M Y', strtotime($row['tglberangkat'])); ?></td>
                                                <td><?= $row['tujuan']; ?></td>
                                                <td><?= $row['anggota']; ?></td>
                                                <td><?= $row['keperluan']; ?></td>
                                                <td><?= $row['kepemilikan']; ?></td>
                                            </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="link9">
                        <div class="material-datatables">
                            <table id="dtdesc9" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                                  $this->db->limit(100);
                                                  $this->db->order_by('tglberangkat', 'desc');
                                                  $this->db->where('status' , '9');
                                    $perjalanan = $this->db->get_where('perjalanan', ['npk' => $this->session->userdata('npk')])->result_array();
                                    foreach ($perjalanan as $row) : ?>
                                            <tr>
                                                <td><?= $row['id'].'-'.$row['jenis_perjalanan']; ?></td>
                                                <td><?= date('d M Y', strtotime($row['tglberangkat'])); ?></td>
                                                <td><?= $row['tujuan']; ?></td>
                                                <td><?= $row['anggota']; ?></td>
                                                <td><?= $row['keperluan']; ?></td>
                                                <td><?= $row['kepemilikan']; ?></td>
                                            </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="link0">
                        <div class="material-datatables">
                            <table id="dtdesc0" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Peserta</th>
                                        <th>Keperluan</th>
                                        <th>Kendaraan</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                                  $this->db->limit(50);
                                                  $this->db->where('status' , '0');
                                    $perjalanan = $this->db->get_where('perjalanan', ['npk' => $this->session->userdata('npk')])->result_array();
                                    foreach ($perjalanan as $row) : ?>
                                            <tr>
                                                <td><?= $row['id'].'-'.$row['jenis_perjalanan']; ?></td>
                                                <td><?= date('d M Y', strtotime($row['tglberangkat'])); ?></td>
                                                <td><?= $row['tujuan']; ?></td>
                                                <td><?= $row['anggota']; ?></td>
                                                <td><?= $row['keperluan']; ?></td>
                                                <td><?= $row['kepemilikan']; ?></td>
                                            </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<!-- Modal -->
<div class="modal fade" id="batalDl" tabindex="-1" role="dialog" aria-labelledby="batalDlTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">ALASAN PEMBATALAN</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('perjalanandl/batal_perjalanan'); ?>">
                    <div class="modal-body">
                        <input type="text" class="form-control disabled" name="id" hidden>
                        <textarea rows="3" class="form-control" name="catatan" placeholder="Contoh : Tidak jadi berangkat" required></textarea>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-danger">BATALKAN!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#dtdesc1').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            order: [
                [1, 'desc']
            ],
            scrollX: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });

        $('#dtdesc2').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            order: [
                [0, 'desc']
            ],
            scrollX: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });

        $('#dtdesc3').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            order: [
                [0, 'desc']
            ],
            scrollX: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });
        $('#dtdesc4').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            order: [
                [0, 'desc']
            ],
            scrollX: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });
        $('#dtdesc5').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            order: [
                [0, 'desc']
            ],
            scrollX: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });
        $('#dtdesc9').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            order: [
                [0, 'desc']
            ],
            scrollX: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });
        $('#dtdesc0').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            order: [
                [0, 'desc']
            ],
            scrollX: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });

        $('#btn_reservasi').on('click',function(){
    
            var now_d = '<?= date('D') ?>';
            let now_t = <?= strtotime(date('H:i:s')) ?>;
            let min_t = <?= strtotime(date('07:30:00')) ?>;
            let max_t = <?= strtotime(date('16:30:00')) ?>;

            if (now_d == 'Sat' || now_d == 'Sun' || now_t < min_t || now_t > max_t) {

                Swal.fire({
                title: 'Perhatian!',
                icon: 'warning',
                html:
                'Kamu mengajukan permohonan di luar jam kerja, untuk itu harap kontak langsung pimpinan-pimpinan kamu dan pihak yang berkepentingan untuk merelease permohonan kamu.</p> ' +
                'Sudah mengajukan di RAISA tidak berarti menyerahkan tanggung jawab kamu ke RAISA, RAISA tidak bertanggung jawab atas permohonan kamu yang tidak kunjung disetujui, kamu tetap harus proaktif.',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Saya Mengerti',
                showClass: {
                    popup: 'animate__animated animate__heartBeat'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut'
                }
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('reservasi/dl'); ?>";
                }
                });

            }else{

                window.location.href = "<?= base_url('reservasi/dl'); ?>";

            }
        });
    });
</script>