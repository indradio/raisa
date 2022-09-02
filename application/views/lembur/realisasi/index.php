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
                        <h4 class="card-title">Realisasi Lembur</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                            <!-- <a href="#" class="btn btn-rose mb-2" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahLembur">Rencana Lembur Baru</a>
                        </div> -->
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mulai <small>Tanggal</small></th>
                                        <th>Selesai <small>Tanggal</small></th>
                                        <th>Durasi <small>(Jam)</small></th>
                                        <th>Lokasi</th>
                                        <th>Realisasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Durasi <small>(Jam)</small></th>
                                        <th>Lokasi</th>
                                        <th>Tgl Realisasi</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($lembur as $l) : ?>
                                        <tr onclick="window.location='<?= base_url('lembur/realisasi/aktivitas/') . $l['id']; ?>'" >
                                            <td><?= $l['id']; ?></td>
                                            <td><?= date('d-M H:i', strtotime($l['tglmulai'])); ?></td>
                                            <td><?= date('d-M H:i', strtotime($l['tglselesai'])); ?></td>
                                            <td><?= $l['durasi']; ?></td>
                                            <td><?= $l['lokasi']; ?></td>
                                            <?php $status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array(); ?>
                                            <td><?php if ($l['status'] > 4) {
                                                echo date('d-M H:i', strtotime($l['tglpengajuan_realisasi'])); 
                                            }?></td>
                                            <td><?= $status['nama']; ?></td>
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
<script type="text/javascript">
    $(document).ready(function(){
    <?php if ($this->session->flashdata('notify')=='error'){ ?>
       
       $.notify({
         icon: "add_alert",
         message: "Kamu belum mengisi jamkerja ya! atau waktu rencana lembur kamu belum selesai nih!."
       }, {
         type: "danger",
         timer: 3000,
         placement: {
           from: "top",
           align: "center"
         }
       });
 
      <?php } ?>
    });        
</script>
