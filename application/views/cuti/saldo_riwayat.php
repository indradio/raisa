<div class="content">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">weekend</i>
            </div>
            <p class="card-category">Saldo</p>
            <h3 class="card-title">Total <?=$saldo->saldo_awal; ?> hari</h3>
            <h5 class="card-title">Digunakan <?=$saldo->saldo_digunakan; ?> hari</h5>
            <h5 class="card-title">Sisa <?=$saldo->saldo; ?> hari</h5>
          </div>
          <div class="card-footer">
            <div class="stats"></div>
            <!-- <a href="#" id="btn_tambahCuti" class="btn btn-facebook btn-block" >Ajukan Cuti</a> -->
            <!-- data-toggle="modal" data-target="#tambahCuti" -->
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Riwayat</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
            
              <!--        Here you can write extra buttons/actions for the toolbar              -->
              
            </div>
            <div class="material-datatables">
              <table id="dtdesc" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Lama <small>(Hari)</small></th>
                    <th>Keterangan</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No. Cuti</th>
                    <th>Tanggal</th>
                    <th>Lama</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($cuti as $row) : 
                    $status = $this->db->get_where('cuti_status', ['id' => $row['status']])->row_array(); ?>
                    <tr>
                    <td><?= $row['kategori']. ' </br><small>('.$row['id'].')</small>'; ?></td>
                      <td><?= date('d M Y', strtotime($row['tgl1'])); ?></td>
                      <td><?= $row['lama']; ?></td>
                      <td><?= $row['keterangan']; ?></td>
                      <td><?= $status['nama']; ?> 
                      <?php if ($row['status'] == '0'): ?>
                          <a href="#" class="btn btn-link btn-danger btn-just-icon" role="button" aria-disabled="false"><i class="material-icons">close</i></a>
                          <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- end card body-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
  </div>
  <!-- end container-fluid -->
</div>
<!-- end content -->

<!-- script ajax Kategori-->
<script type="text/javascript">
  
    $(document).ready(function(){
   
    });
    </script>