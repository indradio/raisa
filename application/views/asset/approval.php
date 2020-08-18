<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                    <i class="material-icons">done_all</i>
                    </div>
                    <p class="card-category">BAIK-ADA-DIGUNAKAN</p>
                    <h3 class="card-title"><?= $assetStats1; ?></h3>
                    </div>
                    <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i> Just Updated
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">warning</i>
                    </div>
                    <p class="card-category">BAIK-TIDAK SESUAI</p>
                    <h3 class="card-title"><?= $assetStats2; ?></h3>
                    </div>
                    <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i> Just Updated
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">delete_forever</i>
                    </div>
                    <p class="card-category">RUSAK</p>
                    <h3 class="card-title"><?= $assetStats3; ?></h3>
                    </div>
                    <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i> Just Updated
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-github card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">visibility_off</i>
                    </div>
                    <p class="card-category">HILANG</p>
                    <h3 class="card-title"><?= $assetStats4; ?></h3>
                    </div>
                    <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i> Just Updated
                    </div>
                    </div>
                </div>
                </div>
            </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Data Asset</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="<?= base_url('asset/approve'); ?>" class="btn btn-wd btn-fill btn-facebook">APPROVE ALL</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="disabled-sorting"></th>
                                        <th>Asset</th>
                                        <th class="th-description">Tgl Opname</th>
                                        <th class="disabled-sorting th-description text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($asset as $a) : 
                                    ?>
                                        <tr onclick="window.location='<?= base_url('asset/asset/' . $a['id']); ?>'">
                                            <td>
                                                <div class="img-container" style="width:100px; height:100px;">
                                                    <img src="<?= base_url(); ?>assets/img/asset/<?= $a['asset_foto']; ?>" alt="...">
                                                </div>
                                            </td>
                                            <td class="td-name">
                                                <a><?= $a['asset_deskripsi']; ?></a>
                                                <br />
                                                <small><?= $a['asset_no'] . '-' . $a['asset_sub_no']; ?> (<?= $a['kategori']; ?>)</small>
                                            </td>
                                            <td><?= date('d M Y', strtotime($a['opname_at'])); ?></td>
                                            <td class="text-right">
                                            <?php if ($a['status']==1){ ?>
                                                <a href="#" class="btn btn-sm btn-wd btn-fill btn-success" style="width: 120px;">BAIK</br>ADA-DIGUNAKAN</a>
                                            <?php } elseif ($a['status']==2){ ?>
                                                <a href="#" class="btn btn-sm btn-wd btn-fill btn-warning" style="width: 120px;">BAIK</br>TIDAK SESUAI</a>
                                            <?php } elseif ($a['status']==3){ ?>
                                                <a href="#" class="btn btn-sm btn-wd btn-fill btn-danger" style="width: 120px;">RUSAK</a>
                                            <?php } elseif ($a['status']==4){ ?>
                                                <a href="#" class="btn btn-sm btn-wd btn-fill btn-github" style="width: 120px;">HILANG</a>
                                            <?php } ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Asset</th>
                                        <th class="th-description">Tgl Opname</th>
                                        <th class="th-description text-right">Actions</th>
                                    </tr>
                                </tfoot>
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