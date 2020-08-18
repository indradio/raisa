<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
    <?php if ($sidesubmenu == 'Asset'){ ?>
        <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="fa fa-twitter"></i>
                    </div>
                    <p class="card-category">Total</p>
                    <h3 class="card-title"><?= $assetTotal; ?></h3>
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
                    <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">store</i>
                    </div>
                    <p class="card-category">Approved</p>
                    <h3 class="card-title"><?= $assetApproved; ?></h3>
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
                        <i class="material-icons">store</i>
                    </div>
                    <p class="card-category">Verified</p>
                    <h3 class="card-title"><?= $assetVerified; ?></h3>
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
                    <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">equalizer</i>
                    </div>
                    <p class="card-category">Opnamed</p>
                    <h3 class="card-title"><?= $assetRemains; ?></h3>
                    </div>
                    <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i> Just Updated
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <?php } ?>
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
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="disabled-sorting"></th>
                                        <th>Asset</th>
                                        <th class="th-description">Tgl Opname</th>
                                        <th class="disabled-sorting th-description text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($asset as $a) : 
                                        $opnamed = $this->db->get_where('asset_opnamed', ['id' => $a['id']])->row_array();
                                        if (empty($opnamed)){    
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="img-container" style="width:100px; height:100px;">
                                                    <img src="<?= base_url(); ?>assets/img/asset/sto-icon.jpg" alt="...">
                                                </div>
                                            </td>
                                            <td class="td-name">
                                                <?= $a['asset_deskripsi']; ?>
                                                <br />
                                                <small><?= $a['asset_no'] . '-' . $a['asset_sub_no']; ?> (<?= $a['kategori']; ?>)</small>
                                            </td>
                                            <td></td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-sm btn-fill btn-danger disabled">BELUM </br>DIOPNAME</a>
                                            </td>
                                        </tr>
                                    <?php }else{ ?>
                                        <tr>
                                            <td>
                                                <div class="img-container" style="width:100px; height:100px;">
                                                    <img src="<?= base_url(); ?>assets/img/asset/<?= $opnamed['asset_foto']; ?>" alt="...">
                                                </div>
                                            </td>
                                            <td class="td-name">
                                                <a><?= $a['asset_deskripsi']; ?></a>
                                                <br />
                                                <small><?= $a['asset_no'] . '-' . $a['asset_sub_no']; ?> (<?= $a['kategori']; ?>)</small>
                                            </td>
                                            <td><?= date('d M Y', strtotime($opnamed['opname_at'])); ?></td>
                                            <td class="text-right">
                                                <?php if ($a['status']==1){ ?>
                                                    <a href="<?= base_url('asset/verify/' . $a['id']); ?>" class="btn btn-sm btn-fill btn-danger">BELUM </br>DIVERIFIKASI</a>
                                                <?php } elseif ($a['status']==2){ ?>
                                                    <a href="<?= base_url('asset/id/' . $a['id']); ?>" class="btn btn-sm btn-fill btn-warning">BELUM </br>DIAPPROVE</a>
                                                <?php } elseif ($a['status']==9){ ?>
                                                    <a href="<?= base_url('asset/id/' . $a['id']); ?>" class="btn btn-sm btn-fill btn-success">SUDAH </br>DIOPNAME</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
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