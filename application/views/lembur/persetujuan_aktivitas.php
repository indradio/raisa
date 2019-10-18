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
                    <form class="form" method="post" action="<?= base_url('lembur/setujui_aktivitas'); ?>">
                    <div class="card-body">
                        <div class="row" hidden>
                            <label class="col-md-1 col-form-label">Lembur ID</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id" value="<?= $lembur['id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Tanggal Mulai</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datetimepicker disabled" id="tglmulai" name="tglmulai" value="<?= $lembur['tglmulai']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Tanggal Selesai</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control datetimepicker disabled" id="tglselesai" name="tglselesai" value="<?= $lembur['tglselesai']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Status</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                <?php $status = $this->db->get_where('lembur_status', ['id' => $lembur['status']])->row_array(); ?>
                                    <input type="text" class="form-control disabled" id="status" name="status" value="<?= $status['nama']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-1 col-form-label">Total Aktivitas</label>
                            <div class="col-md-3">
                                <div class="form-group has-default">
                                <?php
                                    $lid = $lembur['id'];
                                    $queryLembur = "SELECT COUNT(*)
                                            FROM `aktivitas`
                                            WHERE `link_aktivitas` = '$lid' ";
                                            $totalLembur = $this->db->query($queryLembur)->row_array();
                                            $totalAktivitas = $totalLembur['COUNT(*)'];
                                ;?>
                                    <input type="text" class="form-control disabled" id="total_aktivitas" name="total_aktivitas" value="<?= $totalAktivitas; ?>">
                                </div>
                            </div>
                        </div>
                        </form>
                        <br>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover"  cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Aktivitas</th>
                                        <th>jenis Aktivitas</th>
                                        <th>Kategori</th>
                                        <th>COPRO</th>
                                        <!-- <th>WBS</th> -->
                                        <th>Rencana Aktivitas</th>
                                        <th>Durasi/Jam</th>
                                        <!-- <th>Durasi Estimasi</th> -->
                                        <th>Hasil</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No. Aktivitas</th>
                                        <th>jenis Aktivitas</th>
                                        <th>Kategori</th>
                                        <th>COPRO</th>
                                        <!-- <th>WBS</th> -->
                                        <th>Rencana Aktivitas</th>
                                        <th>Durasi/Jam</th>
                                        <!-- <th>Durasi Estimasi</th> -->
                                        <th>Hasil</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($aktivitas as $a) : ?>
                                        <tr>
                                            <td><?= $a['id']; ?></td>
                                            <td><?= $a['jenis_aktivitas']; ?></td>
                                            <?php $k = $this->db->get_where('jamkerja_kategori', ['id' => $a['kategori']])->row_array(); ?>
                                                <td><?= $k['nama']; ?></td>
                                            <td><?= $a['copro']; ?></td>
                                            <!-- <td><?= $a['wbs']; ?></td> -->
                                            <td><?= $a['aktivitas']; ?></td>
                                            <td><?= $a['durasi']; ?> Jam</td>
                                            <!-- <td><?= date('d/m/Y', strtotime($a['waktu_mulai'])); ?></td> -->
                                            <td><?= $a['deskripsi_hasil']; ?> %</td>
                                            <?php $status = $this->db->get_where('aktivitas_status', ['id' => $a['status']])->row_array(); ?>
                                                <td><?= $status['nama']; ?></td>
                                            <td>
                                            <?php if ($lembur['status'] !='3'){ ?>
                                                <a href="#" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons" data-toggle="modal" data-target="#ubahAktivitas" data-id="<?= $a['id']; ?>" data-kategori="<?= $a['kategori']; ?>" data-copro="<?= $a['copro']; ?>" data-aktivitas="<?= $a['aktivitas']; ?>">dvr</i></a>
                                                <a href="<?= base_url('lembur/hapus/'). $a['id']; ?>" class="btn-bataldl"><i class="material-icons">delete</i></a> 
                                            <?php }else{ ?>
                                                <a href="#" class="btn btn-link btn-warning btn-just-icon edit disabled"><i class="material-icons" data-toggle="modal" data-target="#ubahAktivitas" data-id="<?= $a['id']; ?>">dvr</i></a>
                                                <a href="<?= base_url('lembur/hapus/'). $a['id']; ?>" class="btn-bataldl disabled"><i class="material-icons">delete</i></a> 
                                            <?php }; ?>   
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    <?php if ($this->session->userdata['posisi_id'] == '3' and $lembur['status'] == '3'){ ?>
                                        <!-- <a href="#" id="tambah_aktivitas" class="btn btn-primary disabled" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">Tambah Aktivitas</a> -->
                                        <button type="submit"  id="setujui" class="btn btn-success">SETUJUI</button>
                                        <a href="#" id="batalAktivitas" class="btn btn-rose mb" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                                    <?php }else if ($this->session->userdata['posisi_id'] == '5' and $lembur['status'] == '2'){ ?>
                                        <a href="#" id="tambah_aktivitas" class="btn btn-primary" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahAktivitas">Tambah Aktivitas</a>
                                        <button type="submit"  id="setujui" class="btn btn-success">SETUJUI</button>
                                        <a href="#" id="batalAktivitas" class="btn btn-rose mb" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                                    <?php } else if ($this->session->userdata['posisi_id'] == '3' and $lembur['status'] == '1' or $lembur['status'] == '2') { ?>
                                        <a href="#" id="batalAktivitas" class="btn btn-rose" role="button" aria-disabled="false" data-toggle="modal" data-target="#batalRsv" data-id="<?= $lembur['id']; ?>">BATALKAN</a>
                                        <button type="submit"  id="setujui" class="btn btn-success">SETUJUI</button>
                                    <?php  }; ?>
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
                                    <select class="selectpicker" name="kategori" id="kategori" data-style="select-with-transition" title="Pilih" data-size="3" required>
                                        <?php foreach ($kategori as $k) : ?>
                                            <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">COPRO</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="copro" id="copro" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required >
                                        <?php
                                        $queyCopro = "SELECT *
                                                                    FROM `project`
                                                                    ORDER BY `status` ASC
                                                                    ";
                                        $copro = $this->db->query($queyCopro)->result_array();
                                        foreach ($copro as $c) : ?>
                                            <option data-subtext="<?= $c['deskripsi']; ?>"value="<?= $c['copro']; ?>"><?= $c['copro']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                            <script>
                                $(document).ready(function(){
                                    $('#kategori').change(function(){
                                    var kategori = $('#kategori').val();
                                    if(kategori==3){
                                        $('#copro').prop('disabled', true);
                                        }else{
                                        $('#copro').prop('disabled', false);
                                        }
                                    });
                                });
                            </script>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="aktivitas"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Durasi</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="durasi" id="durasi" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required >
                                            <option value="+1 hour">01 - Jam</option>
                                            <option value="+2 hour">02</option>
                                            <option value="+3 hour">03</option>
                                            <option value="+4 hour">04</option>
                                            <option value="+5 hour">05</option>
                                            <option value="+6 hour">06</option>
                                            <option value="+7 hour">07</option>
                                            <option value="+8 hour">08</option>
                                            <option value="+9 hour">09</option>
                                            <option value="+10 hour">10</option>
                                            <option value="+11 hour">11</option>
                                            <option value="+12 hour">12</option>
                                            <option value="+13 hour">13</option>
                                            <option value="+14 hour">14</option>
                                            <option value="+15 hour">15</option>
                                            <option value="+16 hour">16</option>
                                            <option value="+17 hour">17</option>
                                            <option value="+18 hour">18</option>
                                            <option value="+19 hour">19</option>
                                            <option value="+20 hour">20</option>
                                            <option value="+21 hour">21</option>
                                            <option value="+22 hour">22</option>
                                            <option value="+23 hour">23</option>
                                            <option value="+24 hour">24</option>
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
                        <div class="row">
                            <label class="col-md-4 col-form-label">Ativitas ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="id" name="id" value="<?= $a['id']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <label class="col-md-4 col-form-label">Ativitas ID</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control disabled" id="link_aktivitas" name="link_aktivitas" value="<?= $a['link_aktivitas']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Kategori</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="kategori" id="kategori" data-style="select-with-transition" title="Pilih" data-size="3" required>
                                    <?php
                                    $kategori = $this->db->get('jamkerja_kategori')->result_array();
                                    foreach ($kategori as $k) :
                                        echo '<option value="' . $k['id'] . '"';
                                        if ($k['id'] == $a['kategori']) {
                                            echo 'selected';
                                        }
                                        echo '>' . $k['nama'] . '</option>' . "\n";
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">COPRO</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select class="selectpicker" name="copro" id="copro" data-style="select-with-transition" title="Pilih" data-size="7" data-width="fit" data-live-search="true" required >
                                        <?php
                                        $queyCopro = "SELECT *
                                                                    FROM `project`
                                                                    ORDER BY `status` ASC
                                                                    ";
                                        $copro = $this->db->query($queyCopro)->result_array();
                                        foreach ($copro as $c) : 
                                            echo '<option value="' .$c['copro']. '"';
                                            if ($c['copro']== $a['copro']) {
                                                echo 'selected';
                                            }
                                            echo '>' .$c['copro']. '</option>' ."\n";
                                        endforeach; ?>   
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Aktivitas</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" id="aktivitas" name="aktivitas" value="<?= $a['aktivitas']; ?>" required>
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
<script>
    $(document).ready(function(){
        $('#kategori').change(function(){
        var kategori = $('#kategori').val();
        if(kategori==3){
            $('#copro').prop('disabled', true);
            }else{
            $('#copro').prop('disabled', false);
            }
        });
    });
</script>
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
            <button type="submit" class="btn btn-rose mb-2">BATALKAN LEMBUR INI!</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>