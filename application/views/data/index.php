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
            <h4 class="card-title">Data</h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
            
              <!--        Here you can write extra buttons/actions for the toolbar              -->
              
            </div>
            <div class="material-datatables">
              <table id="dt-data" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Mobil</th>
                    <th>Tujuan</th>
                    <th>Kota</th>
                    <th>Taksi</th>
                    <th>Tol</th>
                    <th>lainnya</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                  <th>ID</th>
                  <th>Tanggal</th>
                    <th>Mobil</th>
                    <th>Tujuan</th>
                    <th>Kota</th>
                    <th>Taksi</th>
                    <th>Tol</th>
                    <th>lainnya</th>
                    <th>Total</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($perjalanan as $row) : 
                    $total = $row['taksi']+$row['tol']+$row['parkir']?>
                    <tr>
                      <td><?= $row['id']; ?></td>
                      <td><?= date('d M Y', strtotime($row['tglberangkat'])); ?></td>
                      <td><?= $row['kendaraan']; ?></td>
                      <td><?= $row['tujuan']; ?></td>
                      <td><?= $row['tujuan']; ?></td>
                      <td><?= $row['taksi']; ?></td>
                      <td><?= $row['tol']; ?></td>
                      <td><?= $row['parkir']; ?></td>
                      <td><?= $total; ?></td>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#dt-data').DataTable( {
            "pagingType": "full_numbers",
            scrollX: true,
            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'excelHtml5',
                    title: 'DATA OPNAME ASSET 2020',
                    text:'<i class="fa fa-table fainfo" aria-hidden="true" ></i>',
                    footer: true
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });
    });
</script>