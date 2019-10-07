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
                        <h4 class="card-title">Laporan Kerja Harian</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                        </div>
                        <div class="material-datatables">
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aktivitas</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Aktivitas</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($aktivitas as $a) : ?>
                                <tr>
                                    <td><?= $a['no']; ?></td>
                                    <td><?= $a['aktivitas']; ?></td>
                                    <td class="text-right">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#aktivitasModal" data-kategori="<?= $kategori; ?>" data-copro="<?= $copro; ?>" data-aktivitas="<?= $a['aktivitas']; ?>">PILIH</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <i class="fa fa-circle text-danger"></i> Perjalanan yang tanggal keberangkatan sudah lewat -->
                            </div>
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