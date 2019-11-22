<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Data Lembur</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <form action="<?= base_url('lembur/cari_lembur_hr'); ?>" method="post">
                                <div class="row">
                                    <label class="col-md-1 col-form-label">Dari Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglmulai" name="tglmulai">
                                        </div>
                                    </div>
                                    <label class="col-md-1 col-form-label">Sampai Tanggal</label>
                                    <div class="col-md-2">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control datepicker" id="tglselesai" name="tglselesai">
                                        </div>
                                    </div>
                                    <!-- <label class="col-md-1 col-form-label">Section</label>
                                    <div class="col-md-2">
                                        <select class="selectpicker" name="section" id="section" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true">
                                        <?php
                                            $querySection = "SELECT * FROM karyawan_sect ";
                                            $section = $this->db->query($querySection)->result_array();
                                            foreach ($section as $s) : ?>
                                                <option data-subtext="<?= $s['nama']; ?>" value="<?= $s['id']; ?>"><?= $s['inisial']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div> -->
                                    <div class="col-md-1"></div>
                                    <a href="#" id="section" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#sectionModal">Pilih</a>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-rose">Cari</a>
                                    </div>
                                </div>
                            </form>
                            <table id="dtperjalanan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th>No. Lembur</th>
                                    <th>NPK</th>
                                    <th>Nama</th>
                                    <th>Tanggal/Jam Mulai</th>
                                    <th>Tanggal/Jam Selesai</th>
                                    <th>Durasi/Jam</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                    <th class="disabled-sorting"></th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>No. Lembur</th>
                                    <th>NPK</th>
                                    <th>Nama</th>
                                    <th>Tanggal/Jam Mulai</th>
                                    <th>Tanggal/Jam Selesai</th>
                                    <th>Durasi/Jam</th>
                                    <th class="text-right">Actions</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php foreach ($lembur as $l) : ?>
                                    <tr>
                                    <td><?= $l['id']; ?></td>
                                    <td><?= $l['npk']; ?></td>
                                    <td><?= $l['nama']; ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($l['tglmulai_aktual'])); ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($l['tglselesai_aktial'])); ?></td>
                                    <td><?= date('H', strtotime($l['durasi_aktual'])); ?> Jam <?= date('i', strtotime($l['durasi_aktual'])); ?> Menit</td>
                                    <td class="text-right">
                                        <?php if ($l['status'] == 9 ) { ?>
                                            <a href="<?= base_url('lembur/laporan_lembur/') . $l['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit" target="_blank"><i class="material-icons">dvr</i></a>
                                        <?php } else { ?>
                                            <a href="<?= base_url('lembur/laporan_lembur/') . $l['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit disabled"><i class="material-icons">dvr</i></a>
                                        <?php }; ?>
                                    </td>
                                    <td>
                                        <!-- <?php if ($l['status'] == 9 ) { ?>
                                            <a href="<?= base_url('lembur/laporan_lembur/') . $l['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit" target="_blank"><i class="material-icons">dvr</i></a>
                                        <?php } else { ?>
                                            <a href="<?= base_url('lembur/laporan_lembur/') . $l['id']; ?>" class="btn btn-link btn-warning btn-just-icon edit disabled"><i class="material-icons">dvr</i></a>
                                        <?php }; ?> -->
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
<!-- Modal Cari Section-->
<div class="modal fade" id="sectionModal" tabindex="-1" role="dialog" aria-labelledby="sectionModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">PILIH SECTION</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('lembur/report_lembur'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-ml-4 col-form-label">Tgl Mulai</label>
                                <div class="col-md-7">
                                    <div class="form-group has-default" id="tglmulai">
                                        <input type="text" class="form-control datetimepicker" id="tglmulai" name="tglmulai" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-ml-4 col-form-label">Tgl Selesai</label>
                                <div class="col-md-7">
                                    <div class="form-group has-default" id="tglmulai">
                                        <input type="text" class="form-control datetimepicker" id="tglselesai" name="tglselesai" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-ml-5 col-form-label">Pilih Section</label>
                                <div class="col-md-5">
                                    <div class="col-md-2">
                                        <select class="selectpicker" name="section" id="section" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true">
                                        <?php
                                            $querySection = "SELECT * FROM karyawan_sect ";
                                            $section = $this->db->query($querySection)->result_array();
                                            foreach ($section as $s) : ?>
                                                <option data-subtext="<?= $s['nama']; ?>" value="<?= $s['id']; ?>"><?= $s['inisial']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-success" target="_blank">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>