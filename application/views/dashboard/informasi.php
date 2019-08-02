<div class="content">
    <div class="container-fluid">
        <!-- Banner -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-product">
                    <div class="card-header card-header-image" data-header-animation="false">
                        <img class="img" src="<?= base_url(); ?>assets/img/info/<?= $info['gambar']; ?>">
                    </div>
                    <div class="card-body">
                        <div class="card-actions"> </div>
                        <h2 class="card-title text-left">
                            <?= $info['judul']; ?>
                        </h2>
                        <div class="card-description text-justify text-dark ">
                            <?= $info['deskripsi_lengkap']; ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="price">
                            <h4><?= $info['sect_nama']; ?></h4>
                        </div>
                        <div class="stats">
                            <p class="card-category"><i class="material-icons">time</i> Berlaku sampai <?= $info['berlaku']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end banner -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end content -->