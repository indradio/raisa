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
                        <h4 class="card-title">Laporan Kesehatan Karyawan</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar"></div>
                        <div class="material-datatables">
                            <table id="exportdesc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Npk</th>
                                        <th>Nama</th>
                                        <th>A1</th>
                                        <th>A2</th>
                                        <th>A3</th>
                                        <th>B1</th>
                                        <th>B2</th>
                                        <th>B3</th>
                                        <th>B4</th>
                                        <th>B5</th>
                                        <th>B6</th>
                                        <th>B7</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th>Dibuat pada</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Npk</th>
                                        <th>Nama</th>
                                        <th>A1</th>
                                        <th>A2</th>
                                        <th>A3</th>
                                        <th>B1</th>
                                        <th>B2</th>
                                        <th>B3</th>
                                        <th>B4</th>
                                        <th>B5</th>
                                        <th>B6</th>
                                        <th>B7</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th>Dibuat pada</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($kesehatan as $k) :
                                        if ($k['status'] == 'BAHAYA') {
                                            echo '<tr class="text-white bg-danger">';
                                        } elseif ($k['status'] == 'SIAGA') {
                                            echo '<tr class="bg-warning">';
                                        } else {
                                            echo '<tr>';
                                        }
                                    ?>
                                        <td><?= $k['npk']; ?></td>
                                        <td><?= $k['nama']; ?></td>
                                        <td><?= $k['a1']; ?></td>
                                        <td><?= $k['a2']; ?></td>
                                        <td><?= $k['a3']; ?></td>
                                        <td><?= $k['b1']; ?></td>
                                        <td><?= $k['b2']; ?></td>
                                        <td><?= $k['b3']; ?></td>
                                        <td><?= $k['b4']; ?></td>
                                        <td><?= $k['b5']; ?></td>
                                        <td><?= $k['b6']; ?></td>
                                        <td><?= $k['b7']; ?></td>
                                        <td><?= $k['catatan']; ?></td>
                                        <td><?= $k['status']; ?></td>
                                        <td><?= date('d-m-Y H:i', strtotime($k['create_at'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <h4>A. Kondisi Kesehatan</h4>
                        A1. Kondisi kesehatan selama libur lebaran <b>(Demam/Pilek/Influenza)</b>
                        </br>
                        A2. Kondisi kesehatan selama libur lebaran <b>(Batuk/Suara serak/Demam)</b>
                        </br>
                        A3. Kondisi kesehatan selama libur lebaran <b>(Sesak nafas/Nafas pendek)</b>
                        </p>
                        <h4>B. Risiko Penularan</h4>
                        B1. Pernah berinteraksi dengan <b>Pasien Positif, PDP, ODP</b> ataupun <b>Orang yang sedang menjalani Isolasi Mandiri COVID-19</b>
                        </br>
                        B2. Pernah berkunjung ke rumah keluarga <b>Pasien Positif, PDP, ODP</b> ataupun <b>Orang yang sedang menjalani Isolasi Mandiri COVID-19</b>
                        </br>
                        B3. Penghuni satu rumah ada yang dinyatakan <b>Pasien Positif, PDP, ODP</b> ataupun <b>Orang yang sedang menjalani Isolasi Mandiri COVID-19</b>
                        </br>
                        B4. Kamu masuk dalam status <b>Pasien Positif, PDP, ODP</b> ataupun <b>Orang yang sedang menjalani Isolasi Mandiri COVID-19</b>
                        </br>
                        B5. Mengikuti pemerikasaan Rapid Test, PCR, ataupun Tes Kesehatan lainnya dengan hasil <b>"kemungkinan terinfeksi COVID-19"</b>
                        </br>
                        B6. Pergi dan kembali dari <b>luar kota / Kab</b>
                        </br>
                        B7. Beraktivitas jauh <b>(lebih dari 20KM)</b> dari rumah kediaman
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
<script>
    $(document).ready(function() {

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
    })
</script>