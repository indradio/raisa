<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">emoji_transportation</i>
                        </div>
                        <h4 class="card-title"><?= $reservasi['jenis_perjalanan'] .' - '. $reservasi['id']; ?></h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('perjalanan/ta/submit'); ?>" method="post">
                            <input type="hidden" class="form-control disabled" name="id" value="<?= $reservasi['id']; ?>">
                            <div class="row">
                                <label class="col-md-2 col-form-label">Nama</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nama" value="<?= $reservasi['nama']; ?>">
                                        <input type="text" class="form-control disabled" name="npk" value="<?= $reservasi['npk']; ?>" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Berangkat</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="berangkat" name="berangkat" value="<?= date("d M Y", strtotime($reservasi['tglberangkat'])) . ' - ' . date("H:i", strtotime($reservasi['jamberangkat'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Kembali</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="kembali" name="kembali" value="<?= date("d M Y", strtotime($reservasi['tglkembali'])) . ' - ' . date("H:i", strtotime($reservasi['jamkembali'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Tujuan</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="tujuan" value="<?= $reservasi['tujuan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Keperluan</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <textarea rows="2" class="form-control disabled" name="keperluan"><?= $reservasi['keperluan']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Akomodasi</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="akomodasi" value="<?= $reservasi['akomodasi']; ?>">
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($reservasi['kendaraan'])){ ?>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Kendaraan</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nopol" value="<?= $reservasi['nopol'] . ' (' . $reservasi['kendaraan'] . ')'; ?>">
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Penginapan/Hotel</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="penginapan" value="<?= $reservasi['penginapan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Lama Menginap</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="menginap" value="<?= $reservasi['lama_menginap']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Peserta</label>
                                <div class="col-md-8">
                                    <div class="toolbar">
                                        <a href="#" class="btn btn-facebook btn-sm" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahPeserta" data-id="<?= $reservasi['id']; ?>">Tambah</a>
                                    </div>
                                    <div class="material-datatables">
                                        <table id="dtasc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Inisial</th>
                                                    <th>Nama</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1; 
                                                $peserta = $this->db->get_where('perjalanan_anggota', ['reservasi_id' => $reservasi['id']])->result_array();
                                                foreach ($peserta as $row) : 
                                                $gol = $this->db->get_where('karyawan_gol', ['id' => $row['karyawan_gol']])->row_array();
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $row['karyawan_inisial']; ?></td>
                                                        <?php if ($reservasi['pic_perjalanan'] == $row['karyawan_inisial']){ ?>
                                                            <td><?= $row['karyawan_nama'].' <a href="#" class="btn btn-link btn-success btn-just-icon" data-toggle="tooltip" data-placement="top" title="PIC Perjalanan"><i class="material-icons">military_tech</i></a>'; ?></td>
                                                        <?php }else{ ?>
                                                            <td><?= $row['karyawan_nama']; ?></td>
                                                        <?php } ?>
                                                        <td class="text-right"><a href="#" class="btn btn-link btn-danger btn-just-icon remove" data-toggle="modal" data-target="#hapusPeserta" data-id="<?= $reservasi['id']; ?>" data-inisial="<?= $row['karyawan_inisial']; ?>" data-nama="<?= $row['karyawan_nama']; ?>"><i class="material-icons">close</i></a></td>                                                    
                                                    </tr>
                                                <?php 
                                                $no++;
                                                endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Jadwal Perjalanan</label>
                                <div class="col-md-8">
                                  <div class="toolbar">
                                  <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    <a href="#" class="btn btn-facebook btn-sm" role="button" aria-disabled="false" data-toggle="modal" data-target="#tambahPerjalanan" data-id="<?= $reservasi['id']; ?>">Tambah</a>
                                  </div>
                                  <div class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                      <thead>
                                        <tr>
                                          <th>No</th>
                                          <th>Waktu</th>
                                          <th>Berangkat Dari</th>
                                          <th>Tempat Tujuan</th>
                                          <th>Transportasi</th>
                                          <th>Keterangan</th>
                                          <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php
                                        $no = 1; 
                                        $jadwal = $this->db->get_where('perjalanan_jadwal', ['reservasi_id' => $reservasi['id']])->result_array();
                                        foreach ($jadwal as $j) : ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= date("d-m-Y H:i", strtotime($j['waktu'])); ?></td>
                                                <td><?= $j['berangkat']; ?></td>
                                                <td><?= $j['tujuan']; ?></td>
                                                <td><?= $j['transportasi']; ?></td>
                                                <td><?= $j['keterangan']; ?></td>
                                                <td class="text-right"><a href="#" class="btn btn-link btn-danger btn-just-icon remove" data-toggle="modal" data-target="#hapusPerjalanan" data-id="<?= $reservasi['id']; ?>" data-jadwal_id="<?= $j['id']; ?>"><i class="material-icons">close</i></a></td>                                                    
                                            </tr>
                                        <?php 
                                        $no++;
                                        endforeach; ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Catatan</label>
                                    <div class="col-md-8">
                                        <div class="form-group has-default">
                                            <textarea rows="3" class="form-control" name="catatan"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <div class="form-group has-default">
                                            <button type="submit" class="btn btn-fill btn-success">PROSES</button>
                                            <a href="<?= base_url('perjalanan/ta'); ?>" class="btn btn-link btn-default">Kembali</a>
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
<!-- Modal -->
<div class="modal fade" id="tambahPeserta" tabindex="-1" role="dialog" aria-labelledby="tambahPesertaTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Tambah Peserta</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('perjalanan/peserta/tambah/ta'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="hidden" class="form-control" id="id" name="id" />
                            <div class="row">
                                <label class="col-md-4 col-form-label">Peserta</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="peserta[]" data-style="select-with-transition" multiple title="Pilih Peserta" data-width="fit" data-live-search="true" data-size="7">
                                            <?php
                                            $queryKaryawan = "SELECT *
                                                FROM `karyawan`
                                                WHERE `is_active` = '1' AND `npk` != '1111'
                                                ORDER BY `nama` ASC
                                                ";
                                            $peserta = $this->db->query($queryKaryawan)->result_array();
                                            foreach ($peserta as $k) : ?>
                                                <option data-subtext="<?= $k['nama']; ?>" value="<?= $k['inisial']; ?>"><?= $k['inisial']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                                <button type="submit" class="btn btn-success">TAMBAH</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hapusPeserta" tabindex="-1" role="dialog" aria-labelledby="hapusPesertaTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form" method="post" action="<?= base_url('perjalanan/peserta/hapus/ta'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="hidden" class="form-control" id="id" name="id" />
                            <input type="hidden" class="form-control" id="inisial" name="inisial" />
                            <div class="row">
                                <div class="col-md-12 col-form-label text-center"><h4>Kamu yakin mau menghapus peserta ini?</h4></div>
                                <div class="col-md-12 col-form-label text-center" id="peserta"></div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                                <button type="submit" class="btn btn-danger">YA, HAPUS!</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Tambah Perjalanan-->
<div class="modal fade" id="tambahPerjalanan" tabindex="-1" role="dialog" aria-labelledby="tambahPerjalananTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">JADWAL PERJALANAN</h4>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('perjalanan/jadwal/tambah'); ?>">
                    <div class="modal-body">
                        <input type="hidden" class="form-control disabled" id="id" name="id">
                        <div class="row">
                          <label class="col-md-4 col-form-label">Waktu </br><small>Keberangkatan*</small></label>
                          <div class="col-md-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <input type="text" class="form-control datetimepicker" id="waktu" name="waktu" placeholder="YYYY-MM-DD HH:mm" required>
                                <span class="input-group-text">
                                    <i class="material-icons">event</i>
                                </span>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Berangkat </br><small>Dari*</small></label>
                            <div class="col-md-6">
                              <div class="form-group has-default">
                                <input type="text" class="form-control" id="berangkat" name="berangkat" required>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Tujuan </br><small>Ke*</small></label>
                            <div class="col-md-6">
                              <div class="form-group has-default">
                                <input type="text" class="form-control" id="tujuan" name="tujuan" required>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Transportasi*</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <select onchange="transportasiSelect(this);" class="selectpicker" name="transportasi" id="transportasi" title="Pilih" data-style="select-with-transition" data-size="5" data-width="fix" data-live-search="false" >
                                      <option value="Operasional">Operasional</option>
                                      <option value="Taksi">Taksi</option>
                                      <option value="Pribadi">Kendaraan Pribadi</option>
                                      <option value="Pesawat">Pesawat</option>
                                      <option value="Kereta Api">Kereta Api</option>
                                      <option value="Travel">Travel</option>
                                      <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label" id="lblTransportasi" style="display:none;"></label>
                            <div class="col-md-6" id="txtTransportasi" style="display:none;">
                              <div class="form-group has-default">
                                <input type="text" class="form-control" id="transportasi_lain" name="transportasi_lain">
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Keterangan</label>
                            <div class="col-md-6">
                              <div class="form-group has-default">
                              <textarea rows="2" class="form-control" name="keterangan"></textarea>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-success">TAMBAH</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hapusPerjalanan" tabindex="-1" role="dialog" aria-labelledby="hapusPerjalananTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <form class="form" method="post" action="<?= base_url('perjalanan/jadwal/hapus'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="hidden" class="form-control" id="id" name="id" />
                            <input type="hidden" class="form-control" id="jadwal_id" name="jadwal_id" />
                            <div class="row">
                                <div class="col-md-12 col-form-label text-center"><h4>Kamu yakin mau menghapus agenda ini?</h4></div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                                <button type="submit" class="btn btn-danger">YA, HAPUS!</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function transportasiSelect(nameSelect)
    {
        var val = nameSelect.options[nameSelect.selectedIndex].value;
        document.getElementById("lblTransportasi").style.display = val == 'Lainnya' ? "block" : 'none';
        document.getElementById("txtTransportasi").style.display = val == 'Lainnya' ? "block" : 'none';
    }

    $(document).ready(function() {
        $('#tambahPeserta').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        });

        $('#hapusPeserta').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var inisial = button.data('inisial')
            var nama = button.data('nama')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="inisial"]').val(inisial)
            $('#peserta').html(nama);
        });
        
        $('#tambahPerjalanan').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var nama = button.data('nama')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        });

        $('#hapusPerjalanan').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var jadwal_id = button.data('jadwal_id')
            var nama = button.data('nama')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="jadwal_id"]').val(jadwal_id)
        });

        $('#transportasi').change(function() {
                var Transportasi = $('#transportasi').val();
                if (Transportasi == 'Lainnya') {
                    $('#transportasi_lain').prop('disabled', false);
                    $('#transportasi_lain').prop('required', true);
                } else {
                    $('#transportasi_lain').prop('disabled', true);
                    $('#transportasi_lain').prop('required', false);
                }
            });
    });
</script>