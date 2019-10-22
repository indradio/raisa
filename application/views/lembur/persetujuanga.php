<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
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
                        <h4 class="card-title">Konfirmasi Lembur </h4>
                            <br>
                            <br>
                            <div class="badge badge-rose mb-2" hidden><input type="checkbox" id="check-all" name="check-all"> Check All</div>
                        </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Lembur</th>
                                        <th>Nama</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Jam Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                        <th class="disabled-sorting"></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>No. Lembur</th>
                                        <th>Nama</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Jam Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Jam Selesai</th>
                                        <th>Durasi/Jam</th>
                                        <th class="text-right">Actions</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($lembur as $l) : ?>
                                        <tr>
                                            <td><?= $l['id']; ?></td>
                                            <td><?= $l['nama']; ?></td>
                                            <td><?= date('d/m/Y', strtotime($l['tglmulai'])); ?></td>
                                            <td><?= date('H:i', strtotime($l['tglmulai'])); ?></td>
                                            <td><?= date('d/m/Y', strtotime($l['tglselesai'])); ?></td>
                                            <td><?= date('H:i', strtotime($l['tglselesai'])); ?></td>
                                            <td><?= date('H', strtotime($l['durasi'])); ?> Jam <?= date('i', strtotime($l['durasi'])); ?> Menit</td>
                                            <?php echo form_open('lembur/setujui_ga/'); ?>
                                            <td>
                                                <input type="checkbox" class='check-item' name="checkbox[]" value="<?= $l['id']; ?>" required>
                                            </td>
                                            <script>
                                                 $(document).ready(function(){ 
                                                    $("#check-all").click(function(){
                                                        if($(this).is(":checked")) 
                                                            $(".check-item").prop("checked", true); 
                                                        else
                                                            $(".check-item").prop("checked", false); 
                                                            $("#setujuiall").prop("hidden", false);
                                                            $("#setujui").prop("hidden", true);
                                                        });
                                                });
                                            </script>
                                            <td>
                                                <a href="<?= base_url('lembur/setujui_all/'). $l['id']; ?>" id="setujuiall" class="badge badge-pill badge-warning" hidden>Setujui Semua</a>
                                                <button type="submit" id="setujui" name="setujui" class="badge badge-pill badge-success">Setujui</button> 
                                            </td>
                                            <?php echo form_close(); ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
</div>

