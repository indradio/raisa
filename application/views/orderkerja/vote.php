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
                        <h4 class="card-title">Hasil Vote</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Ocean Dream Samudra</th>
                                        <th>Taman Safari Indonesia</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ODS</th>
                                        <th>TSI</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <?php
                                        $vote1 = $this->db->query('SELECT * FROM famday_vote WHERE `ocean` =  1');
                                        $vote2 = $this->db->query('SELECT * FROM famday_vote WHERE `safari` =  1');
                                        $osd = $vote1->num_rows();
                                        $tsi = $vote2->num_rows();
                                        ?>
                                        <td><?= $osd; ?></td>
                                        <td><?= $tsi; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($this->session->userdata('npk') == '1111' or  $this->session->userdata('npk') == '0075') { ?>
                            <div class="material-datatables">
                                <table id="dtperjalanan" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Vote</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Vote</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            foreach ($kary as $k) : ?>
                                            <tr>
                                                <td><?= $k['nama']; ?></td>
                                                <?php $vote = $this->db->get_where('famday_vote', ['npk' =>  $k['npk']])->row_array();
                                                        if ($vote['ocean'] == 1) {
                                                            echo " <td>Ocean Dream Samudra</td>";
                                                        } elseif ($vote['safari'] == 1) {
                                                            echo " <td>Taman Safari Indonesia</td>";
                                                        } else {
                                                            echo " <td>Belum Vote</td>";
                                                        }
                                                        ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php }; ?>
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