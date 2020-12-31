<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-rose alert-with-icon" data-notify="container">
                    <i class="material-icons" data-notify="icon">notifications</i>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span data-notify="message">Silahkan pilih <strong>PIC PERJALANAN</strong> terlebih dahulu.</span>
                  </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title">#<?= $perjalanan['id'] .' - '.$perjalanan['jenis_perjalanan']; ?></h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('perjalanan/penyelesaian/submit'); ?>" method="post">
                            <div class="row" hidden="true">
                                <label class="col-md-2 col-form-label">No Perjalanan</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id" value="<?= $perjalanan['id']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Peserta</label>
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $queryAnggota = "SELECT *
                                                        FROM `perjalanan_anggota`
                                                        WHERE `perjalanan_id` = '{$perjalanan['id']}'
                                                        ";
                                                $anggota = $this->db->query($queryAnggota)->result_array();
                                                $totalTunj = 0;
                                                foreach ($anggota as $a) : ?>
                                                    <tr>
                                                        <td><?= $a['karyawan_inisial']; ?></td>
                                                        <td><?= $a['karyawan_nama']; ?></td>
                                                        <td><?= '<a href="'. base_url('perjalanan/change_pic/'.$perjalanan['id'].'/'.$a['karyawan_inisial']).'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Jadikan PIC"><i class="material-icons">push_pin</i></a>'; ?></td>
                                                    </tr>
                                                <?php 
                                                endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>