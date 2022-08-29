<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
    <?php if ($lembur['life']=='1'){ ?>
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger alert-with-icon" data-notify="container">
            <i class="material-icons" data-notify="icon">notifications</i>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
            <span data-notify="message">Terdapat penyimpangan dalam LEMBURAN ini.</span>
        </div>
      </div>
    </div>
    <?php } ?>
        <div class="row">
            <div class="col-md-12 align-content-start">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">update</i>
                        </div>
                        <h4 class="card-title">Persetujuan Realisasi</h4>
                    </div>
                    <form class="form-horizontal" method="post" action="<?= base_url('lembur/setujui_realisasi'); ?>">
                        <div class="card-body">
                        </br>
                            <div class="form-group" hidden>
                                <label for="exampleID" class="bmd-label-floating">ID</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?= $lembur['id']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleNama" class="bmd-label-floating">Nama</label>
                                <input type="text" class="form-control disabled" id="nama" name="nama" value="<?= $lembur['nama']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleDate" class="bmd-label-floating">Tanggal & Jam</label>
                                <input type="text" class="form-control disabled" id="tgl" name="tgl" value="<?= date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($lembur['tglselesai'])); ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleDurasi" class="bmd-label-floating">Durasi</label>
                                <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= $lembur['durasi']; ?> Jam">
                            </div>
                            <div class="form-group">
                                <label for="exampleLokasi" class="bmd-label-floating">Lokasi</label>
                                <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="<?= $lembur['lokasi']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleKategori" class="bmd-label-floating">Kategori</label>
                                <?php if ($lembur['kategori']=='OT'){
                                    echo '<input type="text" class="form-control disabled" id="kategori_lembur" name="kategori_lembur" value="LEMBUR">';
                                } elseif ($lembur['kategori']=='GH'){
                                    echo '<input type="text" class="form-control disabled" id="kategori_lembur" name="kategori_lembur" value="GANTI HARI">';
                                } elseif ($lembur['kategori']=='TC'){
                                    echo '<input type="text" class="form-control disabled" id="kategori_lembur" name="kategori_lembur" value="TABUNGAN CUTI">';
                                } ?>
                            </div>
                            <?php if ($lembur['mch_kategori']){ ?>
                            <div class="form-group">
                                <label for="exampleKategori" class="bmd-label-floating">MCH Kategori</label>
                                            <input type="text" class="form-control disabled" id="mch_kategori_lembur" name="mch_kategori_lembur" value="<?= $lembur['mch_kategori']; ?>">
                            </div>
                            <?php } ?>
                            <div class="toolbar"></div>
                            <div class="material-datatables">
                                <table id="dtaktivitas" class="table table-striped table-no-bordered table-hover"  cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Aktivitas</th>
                                            <th>Deskripsi</th>
                                            <th>Durasi <small>(Jam)</small></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Aktivitas</th>
                                            <th>Deskripsi</th>
                                            <th>Durasi <small>(Jam)</small></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <blockquote class="blockquote">
                                <small><cite title="Source Title">*Tidak ada rencana : Tambahan aktivitas saat realisasi.</cite></small>
                            </blockquote>
                            
                            </p>
                            <?php 
                            $this->db->distinct();
                            $this->db->select('copro');
                            $this->db->where('link_aktivitas', $lembur['id']);
                            $copro = $this->db->get('aktivitas')->result_array();
                            foreach ($copro as $row) : 
                                if ($row['copro']){
                                    $project = $this->db->get_where('project', ['copro' => $row['copro']])->row_array();
                                    echo '<b>'.$project['copro']. '</b> : '. $project['deskripsi'] . '<br>';  
                                }
                            endforeach;
                             ?>
                            </p>
                            <div class="form-group">
                                <label for="exampleCatatan" class="bmd-label-floating">Catatan</label>
                                <textarea rows="3" class="form-control disabled" name="catatan" id="catatan"><?= $lembur['catatan']; ?></textarea>
                            </div> 
                            <!-- Button SUBMIT -->
                            <button type="submit" id="setujui" class="btn btn-sm btn-success">SETUJUI</button>
                            <a href="#" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalLembur" data-id_lembur="<?= $lembur['id']; ?>">BATALKAN</a>
                            <a href="<?= base_url('lembur/persetujuan') ?>" class="btn btn-sm btn-default" role="button">Kembali</a>
                        </div>
                    </form>   
                </div>
                <!--  end card Body -->
            </div>
            <!--  end card  -->
        </div>
        <!-- end col-md-12 -->
    </div>
    <!-- end row -->
</div>
<!-- end content-->

<!-- Modal Hapus Aktivitas-->
<div class="modal fade" id="hapusAktivitas" tabindex="-1" role="dialog" aria-labelledby="hapusAktivitasTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
      <form class="form" id="formhapusAktivitas" method="post" action="#">
          <div class="modal-body">
              <input type="hidden" class="form-control" id="id_lembur_hapus" name="id_lembur_hapus" />
              <input type="hidden" class="form-control" id="id_aktivitas_hapus" name="id_aktivitas_hapus" />
              <h4 class="card-title text-center">Yakin ingin membatalkan Aktivitas ini?</h4>
          </div>
          <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
              <button type="button" class="btn btn-danger" id="btn_hapus_aktivitas" >YA, BATALKAN!</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="batalLembur" tabindex="-1" role="dialog" aria-labelledby="batalLemburTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
      <form class="form" id="formbatalLembur" method="post" action="<?= base_url('lembur/reject/realisasi'); ?>">
          <div class="modal-body">
              <input type="hidden" class="form-control" id="id_lembur_batal" name="id_lembur_batal" value="<?= $lembur['id']; ?>"/>
              <h4 class="card-title text-center">Yakin ingin membatalkan lembur ini?</h4>
              <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating"><small>Alasan</small></label></br>
                              <textarea class="form-control has-success" id="catatan" name="catatan" rows="3" required="true"></textarea>
                          </div>
                      </div>
                    </div>
          </div>
          <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
              <button type="submit" class="btn btn-danger" id="btn_batal_aktivitas" >YA, BATALKAN!</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- script ajax Kategori-->
<script type="text/javascript">        
        $(document).ready(function(){
            
            $('#dtaktivitas').DataTable({
                "pagingType": "full_numbers",
                scrollX: true,
                scrollCollapse: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                },
                serverSide: false,
                processing: true,
                ajax: {
                        "url"   : "<?= site_url('lembur/get_aktivitas/realisasi_persetujuan') ?>",
                        "type"  : "POST",
                        "data"  : {id:$('#id').val()}
                    },
                columns: [
                    { "data": "aktivitas" },wd
                    { "data": "deskripsi" },
                    { "data": "durasi" }
                ],
            });
            
            $('#ubahDurasi').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id_lembur = button.data('id_lembur') 
                var id_aktivitas = button.data('id_aktivitas') 
                var aktivitas = button.data('aktivitas') 
                var modal = $(this)
                modal.find('.modal-body input[name="id_lembur_durasi"]').val(id_lembur);
                modal.find('.modal-body input[name="id_aktivitas_durasi"]').val(id_aktivitas)
                modal.find('.modal-body textarea[name="aktivitas"]').val(aktivitas)

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('lembur/durasi_aktivitas') ?>",
                    data: {
                        id: id_aktivitas
                    },
                    success: function(data) {
                        // alert(data)
                        $('#durasi_aktivitas').html(data);
                        $('#durasi_aktivitas').selectpicker('refresh');
                    }
                })
            });

            $('#btn_update_durasi').on('click',function(){
                $.ajax({
                    type : "POST",
                    url  : "<?= site_url('lembur/aktivitas/rencana/ubah_durasi') ?>",
                    dataType : "JSON",
                    data : {id:$('#id_lembur_durasi').val(), id_aktivitas:$('#id_aktivitas_durasi').val(), durasi:$('#durasi_aktivitas').val()},
                    success: function(result){

                        $('#ubahDurasi').modal('hide');
                        $('#tgl').val(result['data']['tgl']);
                        $('#durasi').val(result['data']['durasi']);
                        $('#dtaktivitas').DataTable().ajax.reload();

                        $.notify({
                            icon: "add_alert",
                            message: "<b>BERHASIL!</b> Durasi Aktivitas telah diubah."
                        }, {
                            type: "success",
                            timer: 2000,
                            placement: {
                            from: "top",
                            align: "center"
                            }
                        });
                    },
                    error: function(result){
                        $.notify({
                                icon: "add_alert",
                                message: "<b>GAGAL!</b> Data gagal tersimpan."
                            }, {
                                type: "danger",
                                timer: 2000,
                                placement: {
                                from: "top",
                                align: "center"
                                }
                            });
                    }
                });
                return false;
            });

            $('#hapusAktivitas').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id_lembur = button.data('id_lembur') 
                var id_aktivitas = button.data('id_aktivitas') 
                var modal = $(this)
                modal.find('.modal-body input[name="id_lembur_hapus"]').val(id_lembur);
                modal.find('.modal-body input[name="id_aktivitas_hapus"]').val(id_aktivitas);
            });

            $('#btn_hapus_aktivitas').on('click',function(){
                $.ajax({
                    type : "POST",
                    url  : "<?= site_url('lembur/aktivitas/rencana/hapus') ?>",
                    dataType : "JSON",
                    data : {id:$('#id_lembur_hapus').val(), id_aktivitas:$('#id_aktivitas_hapus').val()},
                    success: function(result){

                        $('#hapusAktivitas').modal('hide');
                        $('#tgl').val(result['data']['tgl']);
                        $('#durasi').val(result['data']['durasi']);
                        $('#dtaktivitas').DataTable().ajax.reload();

                        $.notify({
                            icon: "add_alert",
                            message: "<b>BERHASIL!</b> Aktivitas telah dihapus."
                        }, {
                            type: "success",
                            timer: 2000,
                            placement: {
                            from: "top",
                            align: "center"
                            }
                        });
                    },
                    error: function(result){
                        $.notify({
                                icon: "add_alert",
                                message: "<b>GAGAL!</b> Data gagal tersimpan."
                            }, {
                                type: "danger",
                                timer: 2000,
                                placement: {
                                from: "top",
                                align: "center"
                                }
                            });
                    }
                });
                return false;
            });
        });  
    </script>