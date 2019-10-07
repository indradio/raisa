<div class="content">
    <?php date_default_timezone_set('asia/jakarta'); ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">insert_chart</i>
                        </div>
                        <h4 class="card-title">Daftar Project</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('jamkerja/aktivitas_wbs'); ?>" method="post">
                            <div class="form-group input-group-lg">
                                <div class="row justify-content-center">
                                    <select class="selectpicker" id="kategori" name="kategori" data-style="select-with-transition" title="Pilih Kategori" data-size="7" data-width="75%" data-live-search="false">
                                        <option value="1">Project</option>
                                        <option value="2">Lain-lain Project</option>
                                        <option value="3">Lain-lain Non Project</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group input-group-lg">
                                <div class="row justify-content-center">
                                    <select class="selectpicker" id="copro" name="copro" data-style="select-with-transition" title="Pilih Project" data-size="7" data-width="75%" data-live-search="true">
                                        <?php
                                        foreach ($project as $row) {
                                            echo '<option data-subtext="' . $row->deskripsi . '" value="' . $row->copro . '">' . $row->copro . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="form-group has-default">
                                    <button type="submit" class="btn btn-fill btn-info">CARI</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>