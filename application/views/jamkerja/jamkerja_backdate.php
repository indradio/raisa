<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <!-- gunakan if -->
    <!-- <div class="alert alert-rose alert-dismissible fade show" role="alert">
        <strong>Catatan dari atasan kamu</strong> <?= floor($jamkerja['respon_create'] / (60 * 60 * 24)); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div> -->
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
                        <?php if ($jamkerja['id']) {
                            if ($jamkerja['status'] != 9) {
                                $link = $jamkerja['id'];
                                $durasi = $jamkerja['durasi'];

                                $this->db->select_sum('durasi');
                                $this->db->where('link_aktivitas', $link);
                                $this->db->where('kategori', '1');
                                $query1 = $this->db->get('aktivitas');
                                $kategori1 = $query1->row()->durasi;
                                $bar1 = $kategori1 * 12.5;

                                $this->db->select_sum('durasi');
                                $this->db->where('link_aktivitas', $link);
                                $this->db->where('kategori', '2');
                                $query2 = $this->db->get('aktivitas');
                                $kategori2 = $query2->row()->durasi;
                                $bar2 = $kategori2 * 12.5;

                                $this->db->select_sum('durasi');
                                $this->db->where('link_aktivitas', $link);
                                $this->db->where('kategori', '3');
                                $query3 = $this->db->get('aktivitas');
                                $kategori3 = $query3->row()->durasi;
                                $bar3 = $kategori3 * 12.5;

                                if ($durasi == '0') {
                                    $sisadurasi = 8;
                                } else {
                                    $sisadurasi = 8 - $durasi;
                                }
                                $jam = $this->db->get_where('jam', ['id <=' =>  $sisadurasi])->result();
                                ?>
                                <div class="progress" style="width: 100%">
                                    <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $bar1; ?>%" aria-valuenow="<?= $kategori1; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                                    <div class="progress-bar progress-bar-warning" role="progressbar" style="width: <?= $bar2; ?>%" aria-valuenow="<?= $kategori2; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                                    <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $bar3; ?>%" aria-valuenow="<?= $kategori3; ?>" aria-valuemin="0" aria-valuemax="8"></div>
                                </div>
                                <?php if ($durasi < 8.0) { ?>
                                    <a href="#" class="btn btn-facebook mb-2" role="button" data-toggle="modal" data-target="#aktivitasModal" data-id="<?= $jamkerja['id']; ?>" aria-disabled="false">TAMBAH LAPORAN JAM KERJA</a>
                                <?php }; ?>
                            </div>
                            <div class="material-datatables">
                            <?php } else { ?>
                                </div>
                            <div class="material-datatables disabled">
                            <?php }; ?>
                        <?php } else { ?>
                            <form class="form" method="post" action="<?= base_url('jamkerja/add_jamkerja_tanggal'); ?>">
                                <input type="text" id="tanggal" name="tanggal" class="form-control" value="<?php $tanggal; ?>" />
                                <button type="submit" class="btn btn-lg btn-block btn-youtube mb-2" role="button" aria-disabled="false"><?php $tanggal; ?>BUAT LAPORAN JAM KERJA</button>
                            </form>
                            </div>
                            <div class="material-datatables disabled">
                        <?php }; ?>
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Aktivitas</th>
                                    <th>Deskripsi</th>
                                    <th>Durasi (Jam)</th>
                                    <th>Hasil (%)</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Aktivitas</th>
                                    <th>Deskripsi</th>
                                    <th>Durasi</th>
                                    <th>Hasil</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $aktivitas = $this->db->get_where('aktivitas', ['link_aktivitas' => $jamkerja['id']])->result_array();
                                foreach ($aktivitas as $a) : ?>
                                    <tr>
                                        <?php $katgr = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                        <td><?= $katgr['nama']; ?> <small>(<?= $a['copro']; ?>)</small></td>
                                        <td><?= $a['aktivitas']; ?></td>
                                        <td><?= $a['deskripsi_hasil']; ?></td>
                                        <td><?= $a['durasi']; ?></td>
                                        <td><?= $a['progres_hasil']; ?></td>
                                        <td class="text-right">
                                            <a href="#" class="badge badge-pill badge-danger" data-toggle="modal" data-target="#batalAktivitasModal" data-id="<?= $a['id']; ?>">BATAL</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <!-- <div class="row"> -->
                            <p> Perhatikan hal-hal berikut :
                            </br> 1. Laporan Kerja Harian kamu akan otomatis ter-submit jika durasi sudah 8 Jam Kerja.
                            </br> 2. Istirahat Siang hanya untuk aktivitas lembur, tidak untuk Laporan Kerja Harian.
                        <!-- </div> -->
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
<!-- Modal -->
<div class="modal fade" id="aktivitasModal" tabindex="-1" role="dialog" aria-labelledby="aktivitasModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Aktivitas Kerja</h4>
                    </div>
                </div>
                <form id="Aktivitas" class="form" method="post" action="<?= base_url('jamkerja/add_aktivitas'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group" hidden="true">
                                <label for="id">id</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?= $jamkerja['id']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori*</label>
                                <select class="form-control selectpicker" name="kategori" id="kategori" title="Pilih Kategori" data-style="btn btn-link" data-size="3" data-live-search="false" onchange="kategoriSelect(this);" required>
                                        <?php foreach ($kategori as $row) 
                                        {
                                            echo '<option value="' . $row->id . '">' . $row->nama . '</option>';
                                        }
                                        ?>
                                    </select>
                            </div>
                            <div class="form-group" id="copro_0" style="display:none;">
                                <label for="copro">Project*</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="copro" name="copro" title="Pilih Project" data-size="5" data-live-search="true" required>
                                    <?php
                                    foreach ($project as $row) {
                                        echo '<option data-subtext="' . $row->deskripsi . '" value="' . $row->copro . '">' . $row->copro . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group" id="aktivitas_23" style="display:none;">
                                <label for="aktivitas">Aktivitas*</label>
                                <!-- Aktivitas Lain-lain Project & Non Project -->
                                <select class="form-control selectpicker" id="aktivitas_lain" name="aktivitas" data-style="btn btn-link" title="Pilih Aktivitas" data-size="7"></select>
                            </div>
                            <div class="form-group" id="aktivitas_1" style="display:none;">
                                <label for="aktivitas">Aktivitas*</label>
                                <!-- Aktivitas Project -->
                                <textarea class="form-control has-success" id="aktivitas" name="aktivitas" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi <small><i>(Opsional)</i></small></label>
                                    <textarea class="form-control has-success" id="deskripsi" name="deskripsi" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="durasi">Durasi*</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="durasi" name="durasi" title="Pilih Durasi" data-size="5" required>
                                    <?php
                                    foreach ($jam as $row) {
                                        echo '<option value="' . $row->id . '">' . $row->nama . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="progres_hasil">Hasil*</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="progres_hasil" name="progres_hasil" title="Pilih Hasil" required>
                                    <option value="100">100%</option>
                                    <option value="90">90%</option>
                                    <option value="75">75%</option>
                                    <option value="50">50%</option>
                                    <option value="25">25%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button class="btn btn-default btn-link" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-facebook btn-round">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="batalAktivitasModal" tabindex="-1" role="dialog" aria-labelledby="batalAktivitasModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="batalAktivitasModalLabel">Kamu yakin ingin membatalkan aktivitas ini?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" action="<?= base_url('jamkerja/batal_aktivitas'); ?>">
      <div class="modal-body">
        <div class="form-group" hidden="true">
            <label for="id">id</label>
            <input type="text" class="form-control" id="id" name="id">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
        <button type="submit" class="btn btn-danger">YA, BATALKAN!</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
        function kategoriSelect(valueSelect)
            {
                var val = valueSelect.options[valueSelect.selectedIndex].value;
                document.getElementById("aktivitas_1").style.display = val == '1' ? "block" : 'none';
                document.getElementById("aktivitas_23").style.display = val != '1' ? "block" : 'none';
                document.getElementById("copro_0").style.display = val != '3' ? "block" : 'none';
            }
            $('#kategori').change(function(){
                var kategori = $('#kategori').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('jamkerja/ajax')?>",
                    data: {kategori:kategori},
                    success: function(data) {
                        // alert(data)
                        $('#aktivitas_lain').html(data); 
                        if(kategori == 1){
                            $('#copro').prop('disabled', false);
                            $('#copro').prop('required', true);
                            $('#aktivitas').prop('disabled', false);
                            $('#aktivitas').prop('required', true);
                            $('#aktivitas_lain').prop('disabled', true);
                        }
                        else if(kategori == 2){
                            $('#copro').prop('disabled', false);
                            $('#copro').prop('required', true);
                            $('#aktivitas_lain').prop('disabled', false);
                            $('#aktivitas_lain').selectpicker('refresh');
                            $('#aktivitas_lain').prop('required', true);
                            $('#aktivitas').prop('disabled', true);
                        }
                        else if(kategori == 3){
                            $('#copro').prop('disabled', true);
                            $('#aktivitas_lain').prop('disabled', false);
                            $('#aktivitas_lain').selectpicker('refresh');
                            $('#aktivitas_lain').prop('required', true);
                            $('#aktivitas').prop('disabled', true);
                        }    
                    }
                })
            })
  
        $(document).ready(function(){
            $('#aktivitasModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var id = button.data('id') 
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            })  
            
            $('#batalAktivitasModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) 
                var id = button.data('id') 
                var modal = $(this)
                modal.find('.modal-body input[name="id"]').val(id)
            })
        });  
    </script>