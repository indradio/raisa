<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
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
                        <h4 class="card-title">WBS Project</h4>
                    </div>
                    <form class="form" method="post" action="<?= base_url('lembur/ajukan_rencana'); ?>">
                        <div class="card-body">
                            <div class="row" hidden>
                                <label class="col-md-5 col-form-label">Copro</label>
                                <div class="col-md-7">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="copro" name="copro" value="<?= $project['copro']; ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <a href="#" id="tambah_milestone" class="btn btn-info" role="button" aria-disabled="false" data-toggle="modal" data-target="#milestoneModal">Buat Milestone</a>
                            <a href="#" id="tambah_aktivitas" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#aktivitasModal" data-copro="<?= $project['copro']; ?>">Tambah Aktivitas</a>
                            <a href="<?= base_url('pmd/project/') ?>" class="btn btn-default" role="button">Project Lain</a>
                        </div>
                        <div class="material-datatables">
                            <table id="dtwbs" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No WBS</th>
                                        <th>Milestone</th>
                                        <th>Aktivitas</th>
                                        <th>Tgl Mulai WBS</th>
                                        <th>Tgl Selesai WBS</th>
                                        <th>Durasi WBS</th>
                                        <th>Aktual Mulai</th>
                                        <th>Aktual Selesai</th>
                                        <th>Aktual Durasi</th>
                                        <th>Man Power</th>
                                        <th>Progres</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($wbs as $wbs) : ?>
                                        <tr>
                                            <td><?= $wbs['id']; ?></td>
                                            <td><?= $wbs['milestone']; ?></td>
                                            <td><?= $wbs['aktivitas']; ?></td>
                                            <td><?= date('d-M-Y', strtotime($wbs['tglmulai_wbs'])); ?></td>
                                            <td><?= date('d-M-Y', strtotime($wbs['tglselesai_wbs'])); ?></td>
                                            <td><?= $wbs['durasi_wbs']; ?></td>
                                            <td><?= date('d-M-Y', strtotime($wbs['tglmulai'])); ?></td>
                                            <td><?= date('d-M-Y', strtotime($wbs['tglselesai'])); ?></td>
                                            <td><?= $wbs['durasi']; ?></td>
                                            <td><?= $wbs['manpower']; ?></td>
                                            <td><?= $wbs['progres']; ?></td>
                                            <td><?= $wbs['status']; ?></td>
                                            <td class="text-right">
                                                <?php if ($wbs['tglselesai_wbs'] < date('Y-m-d')) { ?>
                                                    <a href="#" class="btn btn-round btn-danger btn-sm disabled">LATE</a>
                                                <?php } elseif ($wbs['tglselesai_wbs'] == date('Y-m-d')) { ?>
                                                    <a href="#" class="btn btn-round btn-warning btn-sm disabled">LAST MINUTE</a>
                                                <?php } else if ($wbs['tglselesai_wbs'] > date('Y-m-d')) { ?>
                                                    <a href="#" class="btn btn-round btn-success btn-sm disabled">ON GOING</a>
                                                <?php }; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No WBS</th>
                                        <th>Milestone</th>
                                        <th>Aktivitas</th>
                                        <th>Tgl Mulai WBS</th>
                                        <th>Tgl Selesai WBS</th>
                                        <th>Durasi WBS</th>
                                        <th>Aktual Mulai</th>
                                        <th>Aktual Selesai</th>
                                        <th>Aktual Durasi</th>
                                        <th>Man Power</th>
                                        <th>Progres</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- end card-body-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end content -->

<!-- Modal MileStone -->
<div class="modal fade" id="milestoneModal" tabindex="-1" role="dialog" aria-labelledby="milestoneModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-success text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">MileStone</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('project/tmbahMilestone'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" hidden>
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" id="copro" name="copro" value="<?= $project['copro']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-3 col-form-label">ID</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" id="id" name="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Milestone</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea rows="3" class="form-control" id="milestone" name="milestone" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Tgl Mulai</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control datetimepicker" id="tglmulai" name="tglmulai" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Tgl Selesai</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control datetimepicker" id="tglselesai" name="tglselesai" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success btn-round">SIMPAN</button>
                                <br>
                                <button type="button" class="btn btn-default btn-round" data-dismiss="modal">TUTUP</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Aktivitas -->
<div class="modal fade" id="aktivitasModal" tabindex="-1" role="dialog" aria-labelledby="aktivitasModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-success text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Tambah Aktivitas</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('project/tmbahAkt'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row" hidden>
                                <label class="col-md-3 col-form-label">Copro</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="copro" value="<?= $project['copro']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-3 col-form-label">ID</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control" id="id" name="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Pilih Milestone</label>
                                <div class="col-md-4">
                                    <div class="form-group has-default">
                                       <select class="selectpicker" name="milestone" id="milestone" data-style="select-with-transition" title="Pilih" data-size="4" required>
                                       <?php 
                                            $queryWbs = "SELECT * FROM wbs WHERE copro = {$project['copro']} ";
                                            $wbs = $this->db->query($queryWbs)->result_array();
                                            foreach ($wbs as $wbs) : ?>
                                                <option value="<?= $wbs['id']; ?>"><?= $wbs['milestone']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Aktivitas</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea rows="3" class="form-control" id="aktivitas" name="aktivitas" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Tgl Mulai</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control datetimepicker" id="tglmulai" name="tglmulai" required>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $(function () {
                                     $('#tglmulai').datetimepicker({  
                                     minDate:new Date(),
                                     disabledDates: [new Date()]
                                    });
                                });
                            </script>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Tgl Selesai</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control datetimepicker" id="tglselesai" name="tglselesai" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <label class="col-md-3 col-form-label">Durasi</label>
                            <div class="col-md-8">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                        <?php 
                                            $queryJam = "SELECT * FROM jam ";
                                            $jam = $this->db->query($queryJam)->result_array();
                                            foreach ($jam as $jam) : ?>
                                                <option value="<?= $jam['id']; ?>"><?= $jam['jam']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success btn-round">SIMPAN</button>
                                <br>
                                <button type="button" class="btn btn-default btn-round" data-dismiss="modal">TUTUP</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>