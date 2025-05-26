<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Data Reservasi</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
              <a href="#" id="btn_reservasi" class="btn btn-facebook mb-2" role="button" aria-disabled="false">Reservasi Perjalanan Baru</a>
            </div>
            <div class="material-datatables">
              <table id="dtdesc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No. Reservasi</th>
                    <th>Tgl Reservasi</th>
                    <th>Jenis DL</th>
                    <th>Nomor Polisi</th>
                    <th>Kendaraan</th>
                    <th>Tujuan</th>
                    <th>Keperluan</th>
                    <th>Peserta</th>
                    <th>Berangkat</th>
                    <th>Kembali</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="disabled-sorting text-right">Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No. Reservasi</th>
                    <th>Tgl Reservasi</th>
                    <th>Jenis DL</th>
                    <th>Nomor Polisi</th>
                    <th>Kendaraan</th>
                    <th>Tujuan</th>
                    <th>Keperluan</th>
                    <th>Peserta</th>
                    <th>Berangkat</th>
                    <th>Kembali</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($reservasi as $rsv) : ?>
                    <tr>
                      <td><?= $rsv['id']; ?></td>
                      <td><?= date('d/m/Y', strtotime($rsv['tglreservasi'])); ?></td>
                      <td><?= $rsv['jenis_perjalanan']; ?></td>
                      <td><?= $rsv['nopol']; ?></td>
                      <td><?= $rsv['kepemilikan']; ?></td>
                      <td><?= $rsv['tujuan']; ?></td>
                      <td><?= $rsv['keperluan']; ?></td>
                      <td><?= $rsv['anggota']; ?></td>
                      <td><?= date('d/m/Y', strtotime($rsv['tglberangkat'])); ?> <?= date('H:i', strtotime($rsv['jamberangkat'])); ?></td>
                      <td><?= date('d/m/Y', strtotime($rsv['tglkembali'])); ?> <?= date('H:i', strtotime($rsv['jamkembali'])); ?></td>
                      <td><?= $rsv['catatan']; ?></td>
                      <?php $status = $this->db->get_where('reservasi_status', ['id' => $rsv['status']])->row_array(); ?>
                      <td><?= $status['nama']; ?></td>
                      <td class="text-right">
                        <?php date_default_timezone_set('asia/jakarta'); ?>
                        <?php if ($rsv['status'] >= 1 and $rsv['status'] <= 6) { ?>
                          <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#batalRsv" data-id="<?= $rsv['id']; ?>">BATALKAN</a>
                        <?php }; ?>
                      </td>
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
<!-- Modal -->
<div class="modal fade" id="batalRsv" tabindex="-1" role="dialog" aria-labelledby="batalRsvTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
        <div class="modal-header">
          <div class="card-header card-header-info text-center">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  <i class="material-icons">clear</i>
              </button>
              <h4 class="card-title">ALASAN PEMBATALAN</h4>
          </div>
      </div>
      <form class="form" method="post" action="<?= base_url('reservasi/batalrsv'); ?>">
          <div class="modal-body">
              <input type="hidden" class="form-control disabled" name="id" >
              <textarea rows="3" class="form-control" name="catatan" placeholder="Contoh : Tidak jadi berangkat" required></textarea>
          </div>
          <div class="modal-footer justify-content-right">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
              <button type="submit" class="btn btn-danger">BATALKAN!</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#btn_reservasi').on('click',function(){
    
      var now_d = '<?= date('D') ?>';
      let now_t = <?= strtotime(date('H:i:s')) ?>;
      let min_t = <?= strtotime(date('07:00:00')) ?>;
      let max_t = <?= strtotime(date('16:00:00')) ?>;

      if (now_d == 'Sat' || now_d == 'Sun' || now_t < min_t || now_t > max_t) {

      Swal.fire({
        title: 'Perhatian!',
        icon: 'warning',
        html:
        'Kamu mengajukan permohonan di luar jam kerja, untuk itu harap kontak langsung pimpinan-pimpinan kamu dan pihak yang berkepentingan untuk merelease permohonan kamu.</p> ' +
        'Sudah mengajukan di RAISA tidak berarti menyerahkan tanggung jawab kamu ke RAISA, RAISA tidak bertanggung jawab atas permohonan kamu yang tidak kunjung disetujui, kamu tetap harus proaktif.',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Saya Mengerti',
        showClass: {
          popup: 'animate__animated animate__heartBeat'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOut'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url('reservasi/dl'); ?>";
        }
      });

      }else{

        window.location.href = "<?= base_url('reservasi/dl'); ?>";

      }
    });
  });
</script>