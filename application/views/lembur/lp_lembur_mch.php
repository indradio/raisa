<div class="content">
    <?php date_default_timezone_set('asia/jakarta'); ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assessment</i>
                        </div>
                        <h4 class="card-title">Laporan Man Hour</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('lembur/laporan/mch'); ?>" method="post">
                        <!-- <div class="row">
                                <label class="col-md-2 col-form-label">Laporan Berdasarkan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="laporan" id="laporan" data-style="select-with-transition" title="Pilih Laporan" data-size="7">
                                            <option value="1">List per tiap laporan</option>
                                            <option value="2">Karyawan</option>
                                            <option value="5">COPRO</option>
                                            <option value="3">Pelembur</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <label class="col-md-2 col-form-label">Bulan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="bulan" id="bulan" data-style="select-with-transition" title="Pilih Bulan" data-size="7" required>
                                            <option value="01">Januari</option>
                                            <option value="02">Febuari</option>
                                            <option value="03">Maret</option>
                                            <option value="04">April</option>
                                            <option value="05">Mei</option>
                                            <option value="06">Juni</option>
                                            <option value="07">Juli</option>
                                            <option value="08">Agustus</option>
                                            <option value="09">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                                <label class="col-md-2 col-form-label">Tahun</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="tahun" id="tahun" data-style="select-with-transition" title="Pilih Tahun" data-size="7" required>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <button type="submit" class="btn btn-fill btn-success">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
            <div class="card-header card-header-primary card-header-icon">
                        <div class="card-text">
                            <h4 class="card-title">Laporan Lembur MCH</h4>
                            <p class="card-category">Berdasarkan periode <?= date('F Y', strtotime("$tahun-$bulan-01")); ?></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="dtperjalanan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th>No. Lembur</th>
                                    <th>NPK</th>
                                    <th>Nama</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Durasi</th>
                                    <th>TUL</th>
                                    <th>Lokasi</th>
                                    <th>Kategori</th>
                                    <th>Cell</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>No. Lembur</th>
                                    <th>NPK</th>
                                    <th>Nama</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Durasi</th>
                                    <th>TUL</th>
                                    <th>Lokasi</th>
                                    <th>Kategori</th>
                                    <th>Cell</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php foreach ($lembur as $l) : ?>
                                    <tr>
                                    <td><?= $l['id']; ?> - <?= $l['kategori']; ?></td>
                                    <td><?= $l['npk']; ?></td>
                                    <td><?= $l['nama']; ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($l['tglmulai'])); ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($l['tglselesai'])); ?></td>
                                    <td><?= $l['durasi']; ?></td>
                                    <td><?= $l['tul']; ?></td>
                                    <td><?= $l['lokasi']; ?></td>
                                    <td><?= $l['mch_kategori']; ?></td>
                                    <?php $sect = $this->db->get_where('karyawan_sect', ['id' => $l['sect_id']])->row_array(); ?>
                                    <td><?= $sect['nama']; ?></td>
                                    <td class="text-right">
                                        <a href="<?= base_url('lembur/cetak/') . $l['id']; ?>" class="btn btn-link btn-warning btn-just-icon" target="_blank"><i class="material-icons">dvr</i></a>
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
            </div>
          </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dt-report1').DataTable({
        "pagingType": "full_numbers",
        order: [
            [1, 'desc']
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });
    $('#dt-report2').DataTable({
        "pagingType": "full_numbers",
        order: [
            [4, 'desc']
        ],
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });
} );
</script>