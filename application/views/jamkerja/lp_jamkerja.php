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
            <h4 class="card-title">Laporan Jam Kerja</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
            <form class="form" method="POST" action="<?= base_url('jamkerja/laporan/jk'); ?>">
                <div class="form-group label-floating">
                  <div class="input-group date">
                    <input type="text" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Pilih Tanggal" required="true" />
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">date_range</i>
                        </span>
                      </div>
                  </div>
                    <button type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="dt-persetujuan" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Cetak</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Cetak</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($jamkerja as $jk) : ?>
                    <tr>
                      <td><?= date('d M Y', strtotime($jk['tglmulai'])); ?></td>
                      <td><?=$jk['nama']; ?> <small>(<?=$jk['id']; ?>)</small></td>
                      <td class="text-right">
                        <a href="<?= base_url('jamkerja/cetak/') .$jk['id']; ?>" class="btn btn-link btn-info btn-just-icon" target="_blank"><i class="material-icons">print</i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-circle text-danger"></i> Durasi Jam Kerja kurang dari 8 JAM. 
                            </div>
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

<script>
$(document).ready(function() {
    $('#dt-persetujuan').DataTable( {
        order: [[0, 'asc']],
        rowGroup: {
            dataSrc: 0
        }
    } );
} );
</script>