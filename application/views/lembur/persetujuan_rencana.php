<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 align-content-start">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">update</i>
                        </div>
                        <h4 class="card-title">Persetujuan Rencana Lembur</h4>
                    </div>
                    <form class="form-horizontal" method="post" action="<?= base_url('lembur/setujui_rencana'); ?>">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="row col-md-12" hidden>
                                    <label class="col-ml-3 col-form-label">Lembur ID</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="id" name="id" value="<?= $lembur['id']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label class="col-md-1 col-form-label">Nama</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="nama" name="nama" value="<?= $lembur['nama']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label class="col-md-1 col-form-label">Tanggal</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="nama" name="nama" value="<?= date('d-M H:i', strtotime($lembur['tglmulai'])); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label class="col-md-1 col-form-label">Durasi</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="durasi" name="durasi" value="<?= date('H', strtotime($lembur['durasi_rencana'])).' Jam '. date('i', strtotime($lembur['durasi_rencana'])).' Menit / ' . $lembur['aktivitas_rencana']; ?> Aktivitas">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                <label class="col-md-1 col-form-label">Lokasi</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                            <input type="text" class="form-control disabled" id="lokasi" name="lokasi" value="<?= $lembur['lokasi']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php if ($this->session->userdata('dept_id')==13 AND $this->session->userdata('posisi_id')==3){ ?>

                                <div class="row col-md-12">
                                        <label class="col-md-1 col-form-label">Kategori</label>
                                        <div class="col-md-7">
                                            <div class="form-group has-default">
                                                <select class="selectpicker" name="kategori" id="kategori" data-style="select-with-transition" title="Pilih" data-size="3" required>
                                                    <option value="Claim dan Servis">Claim dan Servis</option>
                                                    <option value="Sesuai Jadwal WBS">Sesuai Jadwal WBS</option>
                                                    <option value="Actual Fail">Actual Fail</option>
                                                </select>
                                            </div>
                                        </div>
                                </div>

                                <?php } ?>
                                <div class="row col-md-12">
                                <label class="col-md-1 col-form-label">Catatan</label>
                                    <div class="col-md-7">
                                        <div class="form-group has-default">
                                        <textarea rows="3" class="form-control" name="catatan" id="catatan"><?= $lembur['catatan']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </form>
                        <br>
                        <div class="toolbar">
                        <?php if($this->session->userdata('posisi_id')>4){ ?>
                            <a href="#" id="tambah_aktivitas" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">TAMBAH AKTIVITAS</a>
                        <?php } ?>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover"  cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Aktivitas</th>
                                        <th>Durasi/Jam</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Aktivitas</th>
                                        <th>Durasi/Jam</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($aktivitas as $a) : ?>
                                        <tr>
                                            <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                            <td><?= $k['nama']; ?>  <small>(<?= $a['copro']; ?>)</small></td>
                                            <td><?= $a['aktivitas']; ?></td>
                                            <td><?= $a['durasi']; ?> Jam</td>
                                            <td class="text-right">
                                            <?php if ($lembur['status'] !='7'){ 
                                                if ($a['kategori']==1){?>
                                                    <a href="#" class="btn btn-sm btn-round btn-warning btn-sm" data-toggle="modal" data-target="#ubahAktivitas" data-id="<?= $a['id']; ?>" data-aktivitas="<?= $a['aktivitas']; ?>" data-durasi="<?= $a['durasi']; ?>">UBAH</a>
                                            <?php }else{ ?>
                                                    <a href="#" class="btn btn-sm btn-round btn-warning btn-sm" data-toggle="modal" data-target="#ubahDurasi" data-id="<?= $a['id']; ?>" data-aktivitas="<?= $a['aktivitas']; ?>" data-durasi="<?= $a['durasi']; ?>">UBAH</a>
                                                <?php }; ?>   
                                                <a href="<?= base_url('lembur/hapus_aktivitas/') . $a['id']; ?>" class="btn btn-sm btn-round btn-danger btn-sm btn-bataldl">HAPUS</a> 
                                            <?php }else{ 
                                                if ($a['kategori']==1){ ?>
                                                <a href="#" class="btn btn-sm btn-round btn-warning btn-sm disabled" data-toggle="modal" data-target="#ubahAktivitas" data-id="<?= $a['id']; ?>">UBAH</a>
                                                    <?php }else{ ?>
                                                            <a href="#" class="btn btn-sm btn-round btn-warning btn-sm" data-toggle="modal" data-target="#ubahDurasi" data-id="<?= $a['id']; ?>" data-aktivitas="<?= $a['aktivitas']; ?>" data-durasi="<?= $a['durasi']; ?>">UBAH</a>
                                                <?php }; ?>   
                                                <a href="<?= base_url('lembur/hapus/') . $a['id']; ?>" class="btn btn-sm btn-round btn-danger btn-sm disabled">HAPUS</a> 
                                            <?php }; ?>   
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            </p>
                            <?php 
                            $this->db->distinct();
                            $this->db->select('copro');
                            $this->db->where('link_aktivitas', $lembur['id']);
                            $aktivitas_copro = $this->db->get('aktivitas')->result_array();
                            foreach ($aktivitas_copro as $ac) : 
                                if (!empty($ac['copro'])){
                                    $nama = $this->db->get_where('project', ['copro' =>  $ac['copro']])->row_array();
                                    echo  $ac['copro'] . ' = '. $nama['deskripsi'] . '<br>';  
                                }
                            endforeach; ?>
                                </p>
                                <!-- Button SUBMIT -->
                                <?php if ($lembur['aktivitas_rencana'] == 0) {
                                    echo '<button type="submit"  id="setujui" class="btn btn-sm btn-success disabled">SETUJUI</button>';
                                } else {
                                    echo '<button type="submit"  id="setujui" class="btn btn-sm btn-success">SETUJUI</button>';
                                }; ?>

                                <a href="#" id="batalAktivitas" class="btn btn-sm btn-danger" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                                <a href="<?= base_url('lembur/persetujuan_lembur/') ?>" class="btn btn-sm btn-default" role="button">Kembali</a>
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
<!-- Modal Tambah aktivitas-->
<div class="modal fade" id="tambahAktivitas" tabindex="-1" role="dialog" aria-labelledby="tambahAktivitasTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">RENCANA LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/tambah_aktivitas'); ?>">
                <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Lembur ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $lembur['id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Kategori</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="kategori" id="kategori" title="Pilih" data-style="select-with-transition" data-size="5" data-width="fit" data-live-search="false" onchange="kategoriSelect(this);" required>
                                        <?php foreach ($kategori as $k) : ?>
                                            <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label" id="lblCopro" style="display:none;">Copro</label>
                            <div class="col-md-7" id="admCopro" style="display:none;">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="copro" id="copro" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required>
                                    <?php
                                        $queyCopro = "SELECT * FROM project where status='open' or status='teco' ";
                                        $copro = $this->db->query($queyCopro)->result_array();
                                        foreach ($copro as $c) : ?>
                                            <option data-subtext="<?= $c['deskripsi']; ?>" value="<?= $c['copro']; ?>"><?= $c['copro']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label" id="lblAkt" style="display:none;">Aktivitas</label>
                            <div class="col-md-7" id="admLain" style="display:none;">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="aktivitas" id="akt_lain" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" required></select>
                                </div>
                            </div>
                            <!-- <div class="col-md-7" id="admAkt" style="display:none;"> -->
                            <div class="col-md-7" id="admAkt" style="display:none;">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="aktivitas" id="akt" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required >
                                    <?php
                                        $queryJam = "SELECT * FROM `jam`";
                                        $jam = $this->db->get_where('jam', ['id <=' => 4])->result_array();
                                        foreach ($jam as $j) : ?>
                                            <option value="+<?= $j['menit']; ?> minute"><?= $j['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                            <br>
                            <button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update aktivitas-->
<div class="modal fade" id="ubahAktivitas" tabindex="-1" role="dialog" aria-labelledby="ubahAktivitas" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-warning text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title"> UBAH AKTIVITAS LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/update_aktivitas'); ?>">
                <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Aktivitas ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id" value="<?= $a['id']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Lembur ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $a['link_aktivitas']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" id="aktivitas" name="aktivitas" required><?= $a['aktivitas']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" value="<?= $a['durasi']; ?>" required >
                                    <?php
                                        $queryJam = "SELECT * FROM `jam`";
                                        $jam = $this->db->get_where('jam', ['id <=' => 4])->result_array();
                                        foreach ($jam as $j) : ?>
                                            <option value="+<?= $j['menit']; ?> minute"><?= $j['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-warning">SIMPAN</button>
                            <br>
                            <button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update Durasi-->
<div class="modal fade" id="ubahDurasi" tabindex="-1" role="dialog" aria-labelledby="ubahDurasi" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-warning text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title"> UBAH AKTIVITAS LEMBUR</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('lembur/update_aktivitas'); ?>">
                <div class="modal-body">
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Aktivitas ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id" value="<?= $a['id']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Lembur ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $a['link_aktivitas']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control disabled" id="aktivitas" name="aktivitas"><?= $a['aktivitas']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" value="<?= $a['durasi']; ?>" required >
                                    <?php
                                        $queryJam = "SELECT * FROM `jam`";
                                        $jam = $this->db->get_where('jam', ['id <=' => 4])->result_array();
                                        foreach ($jam as $j) : ?>
                                            <option value="+<?= $j['menit']; ?> minute"><?= $j['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-warning">SIMPAN</button>
                            <br>
                            <button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Batal Aktivitas-->
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalAktivitasTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-primary text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
            <h4 class="card-title">ALASAN PEMBATALAN</h4>
          </div>
        </div>
        <form class="form" method="post" action="<?= base_url('lembur/batal_lembur'); ?>">
          <div class="modal-body">
            <input type="text" class="form-control disabled" name="id">
            <textarea rows="2" class="form-control" name="catatan" id="catatan" placeholder="Keterangan Pembatalan Lembur" required></textarea>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-rose">BATALKAN LEMBUR INI!</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- script ajax Kategori-->
<script type="text/javascript">
    function kategoriSelect(valueSelect)
            {
                var val = valueSelect.options[valueSelect.selectedIndex].value;
                document.getElementById("admLain").style.display = val != '1' ? "block" : 'none';
                document.getElementById("admCopro").style.display = val != '3' ? "block" : 'none';
                document.getElementById("admAkt").style.display = val == '1' ? "block" : 'none';
                document.getElementById("lblCopro").style.display = val != '3' ? "block" : 'none';
                document.getElementById("lblAkt").style.display = val != '0' ? "block" : 'none';
            }
        $('#kategori').change(function(){
            var kategori = $('#kategori').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/ajax')?>",
                data: {kategori:kategori},
                success: function(data) {
                    // alert(data)
                    $('#akt_lain').html(data); 
                    if(kategori == 1){
                        $('#copro').prop('disabled', false);
                        $('#akt').prop('disabled', false);
                        $('#akt_lain').prop('disabled', true);
                    }
                    else if(kategori == 2){
                        $('#copro').prop('disabled', false);
                        $('#akt_lain').prop('disabled', false);
                        $('#akt_lain').selectpicker('refresh');
                        $('#akt').prop('disabled', true);
                    }
                    else if(kategori == 3){
                        $('#copro').prop('disabled', true);
                        $('#akt_lain').prop('disabled', false);
                        $('#akt_lain').selectpicker('refresh');
                        $('#akt').prop('disabled', true);
                    }    
                }
            })
        })
        
        $(document).ready(function(){
            $('#ubahDurasi').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes
            var aktivitas = button.data('aktivitas')
            var durasi = button.data('durasi')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body textarea[name="aktivitas"]').val(aktivitas)
            modal.find('.modal-body select[name="durasi"]').val(durasi)

            })
        });  
    </script>