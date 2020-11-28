<div class="content">
    <?php date_default_timezone_set('asia/jakarta'); ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card ">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <h4 class="card-title"><?= $reservasi['jenis_perjalanan']; ?> - <?= $reservasi['id']; ?></h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?= base_url('cekdl/berangkatrsv'); ?>" method="post">
                            <div class="row" hidden>
                                <label class="col-md-2 col-form-label">No. Perjalanan DL</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="id" value="<?= $reservasi['id']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row" hidden>
                                <label class="col-md-2 col-form-label">Jenis Perjalanan DL</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="jenis" value="<?= $reservasi['jenis_perjalanan']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Nama</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nama" value="<?= $reservasi['nama']; ?>">
                                        <input type="text" class="form-control disabled" name="npk" value="<?= $reservasi['npk']; ?>" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Nomor Polisi</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="nopol" value="<?= $reservasi['nopol']; ?> (<?= $reservasi['kepemilikan']; ?>)">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Estimasi Keberangkatan</label>
                                <div class="col-md-3">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" id="tglberangkat" name="tglberangkat" value="<?= date("d-m-Y", strtotime($reservasi['tglberangkat'])).' ',date("H:i", strtotime($reservasi['jamberangkat'])); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Peserta</label>
                                <div class="col-md-8">
                                    <?php if ($reservasi['jenis_perjalanan'] != 'TA') { ?>
                                        <button type="button" class="btn btn-sm btn-facebook" data-toggle="modal" data-target="#tambahPesertaModal" data-id="<?= $reservasi['id']; ?>">Tambah Peserta</button>
                                    <?php } ?>
                                    <div class="material-datatables">
                                        <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Inisial</th>
                                                    <th>Nama</th>
                                                    <th class="disabled-sorting">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $peserta = $this->db->get_where('perjalanan_anggota', ['reservasi_id' =>  $reservasi['id']])->result_array();
                                                foreach ($peserta as $row) : ?>
                                                    <tr>
                                                        <td><?= $row['karyawan_inisial']; ?></td>
                                                        <td><?= $row['karyawan_nama']; ?></td>
                                                        <td><a href="<?= base_url('cekdl/removepesertarsv/') . $reservasi['id'] . '/' . $row['npk']; ?>" class="badge badge-danger">HAPUS</a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Pengemudi</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="supirberangkat" data-style="select-with-transition" title="Pilih Pengemudi" data-size="7" required>
                                            <option value="UMUM">Pengemudi Umum</option>
                                            <?php
                                            foreach ($peserta as $row) : ?>
                                                <option value="<?= $row['karyawan_inisial']; ?>"><?= $row['karyawan_nama']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Kilometer Awal*</label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <input type="number" class="form-control" name="kmberangkat" minLength="4" required="true" />
                                    </div>
                                    <label class="col-sm-12 label-on-right">
                                        <code>Kilometer yg diinput minimal 4 digit.</code>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">Catatan <p><small> Opsional</small></p></label>
                                <div class="col-md-5">
                                    <div class="form-group has-default">
                                        <textarea rows="3" class="form-control" name="catatan"></textarea>
                                        <small> Mohon mencantumkan nama jika memberikan catatan</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label"></label>
                                <div class="col-md-10">
                                    <div class="form-group has-default">
                                        <p class="mb-0">Perhatikan hal-hal berikut:</p>
                                        <p class="mb-0">1. Pengemudi dan peserta yang tertulis sudah benar </p>
                                        <p class="mb-0">2. Kendaraan yang berangkat sudah sesuai dengan yang dipesan</p>
                                        <p class="mb-0">3. Kendaraan dalam kondisi layak jalan</p>
                                        <p class="mb-0">4. Pengemudi dalam kondisi baik
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="check" name="check" value="1">
                                            Saya sudah memastikan hal-hal di atas semuanya benar.
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <div class="form-group has-default">
                                        <button type="submit" class="btn btn-fill btn-success" id="submit">BERANGKAT!</button>
                                        <a href="<?= base_url('cekdl/berangkat'); ?>" class="btn btn-fill btn-default">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card ">
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari disini..." id="search">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
                            </div>
                        </div>
                                    <div class="material-datatables">
                                        <table id="dt-karyawan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Inisial</th>
                                                    <th>Nama</th>
                                                    <th class="disabled-sorting">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $karyawan = $this->db->where('npk !=', '1111');
                                                $karyawan = $this->db->where('is_active', '1');
                                                $karyawan = $this->db->get('karyawan')->result_array();
                                                foreach ($karyawan as $row) : 
                                                    $exist = $this->db->where('npk', $row['npk']);
                                                    $exist = $this->db->get_where('perjalanan_anggota', ['reservasi_id' =>  $reservasi['id']])->row_array();?>
                                                    <tr>
                                                        <td><?= $row['inisial']; ?></td>
                                                        <td><?= $row['nama']; ?></td>
                                                        <?php
                                                        if (empty($exist)){ ?>
                                                            <td><a href="<?= base_url('cekdl/addpesertarsv/') . $reservasi['id'] . '/' . $row['npk']; ?>" class="badge badge-success">TAMBAH</a></td>
                                                        <?php } else { ?>
                                                            <td><a href="#" class="badge badge-danger disabled">PESERTA</a></td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                               
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Peserta -->
<div class="modal fade" id="tambahPesertaModal" tabindex="-1" role="dialog" aria-labelledby="tambahPesertaTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Peseta perjalanan</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('cekdl/tambahpeserta'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="hidden" class="form-control disabled" name="id" value="<?= $reservasi['id']; ?>">
                            <div class="row">
                                <label class="col-md-3 col-form-label">Peserta</label>
                                <div class="col-md-7">
                                    <div class="form-group has-default">
                                        <select class="selectpicker" name="anggota[]" data-style="select-with-transition" multiple title="Pilih Peserta" data-live-search="true" data-size="7">
                                            <?php
                                            $queryKaryawan = "SELECT *
                                                FROM `karyawan`
                                                WHERE `npk` != {$this->session->userdata('npk')} AND `npk` != '1111'
                                                ORDER BY `nama` ASC
                                                ";
                                            $Karyawan = $this->db->query($queryKaryawan)->result_array();
                                            foreach ($Karyawan as $k) : ?>
                                                <option value="<?= $k['inisial']; ?>"><?= $k['nama']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-success">TAMBAH PESERTA</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {

    $('#dt-karyawan').DataTable({
        "pagingType": "simple",
        "displayLength": 24,
        lengthChange: false,
        // "lengthMenu": [
        //     [10, 25, 50, -1],
        //     [10, 25, 50, "All"]
        // ],
        scrollX: true,
        "bInfo":     false,
        "dom":"lrtip",
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    var table = $('#dt-karyawan').DataTable();
    $('#search').on( 'keyup', function () {
            table.search( this.value ).draw();
        } );

    var checker = document.getElementById('check');
    var sendbtn = document.getElementById('submit');
    sendbtn.disabled = true;
    // when unchecked or checked, run the function
    checker.onchange = function() {
      if (this.checked) {
        sendbtn.disabled = false;
      } else {
        sendbtn.disabled = true;
      }
    }
    
  });
</script>