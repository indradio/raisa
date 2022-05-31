<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <!-- <div class="container-fluid"> -->
        <!-- <div class="row">
            <label class="col-md-2 col-form-label">Catatan <p><small> *Opsional</small></p></label>
            <div class="col-md-5">
                <div class="form-group has-default">
                    <textarea rows="2" class="form-control" name="catatan"></textarea>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Kompetisi Banner Banner</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!-- Here you can write extra buttons/actions for the toolbar -->
                    <div id="accordion" role="tablist">
                        <div class="card-collapse">
                        <div class="card-header" role="tab" id="headingOne">
                            <h5 class="mb-0">
                            <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="collapsed">
                                <b>Syarat & Ketentuan Kompetisi Konten Banner</b>
                                <i class="material-icons">keyboard_arrow_down</i>
                            </a>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                            <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                    <th>No</th>
                                    <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td>1</td>
                                    <td>Konten banner bisa tentang motivasi, tips, etika kerja, dll selama terkait untuk perusahaan, professional dan hal positif</td>
                                    </tr>
                                    <tr>
                                    <td>2</td>
                                    <td>Tidak boleh konten SARA dan yang kontraproduktif</td>
                                    </tr>
                                    <tr>
                                    <td>3</td>
                                    <td>Ukuran banner menggunakan 1440x720 pixel</td>
                                    </tr>
                                    <tr>
                                    <td>4</td>
                                    <td>Pemilihan banner yang tampil sepenuhnya wewenang RAISA dan tidak bisa diganggu gugat</td>
                                    </tr>
                                    <tr>
                                    <td>5</td>
                                    <td>Banner yang sudah disubmit, baik yang tayang dan tidak tayang, sepenuhnya milik raisa dan tidak boleh diposting di media lain</td>
                                    </tr>
                                    <tr>
                                    <td>6</td>
                                    <td>Mengatur waktu pengerjaan ini sebaik-baiknya agar tidak mengganggu pekerjaan utama</td>
                                    </tr>
                                    <tr>
                                    <td>7</td>
                                    <td>Dengan mengirim banner ini ke raisa, berarti menyetujui semua ketentuan di atas</td>
                                    </tr>
                                    <tr>
                                    <td>8</td>
                                    <td>Bagi banner yang tampil, akan dapat reward saldo Astrapay Rp 20.000</td>
                                    </tr>
                                    <tr>
                                </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                            <a href="#" class="btn btn-info mb-2" role="button" aria-disabled="false" data-toggle="modal" data-target="#buatInformasi"> UPLOAD BANNER</a>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        foreach ($banner as $i) : ?>
                                            <tr>
                                                <td>
                                                    <div class="img-container">
                                                        <img src="<?= base_url(); ?>assets/img/info/<?= $i['gambar_banner']; ?>" alt="..." />
                                                    </div>
                                                </td>
                                                <td><?= $i['judul']; ?></td>
                                                <td><?= $i['deskripsi']; ?></td>
                                                <td><?= $i['status']; ?></td>
                                                <td class="text-right">
                                                    <?php if ($i['status']=='NEED A REVIEW'){
                                                        echo '<a href="#" class="btn btn-link btn-danger btn-just-icon" role="button" aria-disabled="false" data-toggle="modal" data-target="#deleteBanner" data-id="'.$i['id'].'"><i class="material-icons">close</i></a>';
                                                    }elseif ($i['status']=='PUBLISHED'){
                                                        echo 'Approved by '.$i['approved_by'];
                                                        echo '</br>Will be Expired on '.date('d M Y', strtotime( $i['berlaku']));
                                                    }elseif ($i['status']=='REJECTED'){
                                                        echo 'Rejected by '.$i['approved_by'];
                                                        echo '</br>Alasan : '.$i['deskripsi'];
                                                    }else{
                                                        echo 'N/A';
                                                    } ?>
                                                </td>
                                            </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        <!-- </div> -->
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<!-- <script>
    tinymce.init({
        selector: 'textarea'
    });
</script> -->

<!-- Modal Buat Informasi Baru-->
<div class="modal fade" id="buatInformasi" tabindex="-1" role="dialog" aria-labelledby="buatInformasiTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">BANNER</h4>
                    </div>
                </div>
                    <div class="modal-body">
                    <?= form_open_multipart('layanan/contest/add'); ?>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Title</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <input type="text" class="form-control" id="judul" name="judul" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Description</label>
                            <div class="col-md-7">
                                <div class="form-group has-default">
                                    <textarea rows="3" class="form-control" name="deskripsi"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Image</label>
                            <div class="col-md-7">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img src="<?= base_url(); ?>assets/img/info/blank-banner.jpg" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                        <span class="btn btn-round btn-rose btn-file btn-sm">
                                            <span class="fileinput-new">Pilih Gambar</span>
                                            <span class="fileinput-exists">Ganti</span>
                                            <input type="file" name="gambar_banner" />
                                        </span>
                                        <br />
                                        <a href="#" class="btn btn-danger btn-round fileinput-exists btn-sm" data-dismiss="fileinput"><i class="fa fa-times"></i>Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete Banner-->
<div class="modal fade" id="deleteBanner" tabindex="-1" role="dialog" aria-labelledby="deleteBannerTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-signup card-plain">
      <form class="form" id="formDeleteBanner" method="post" action="#">
          <div class="modal-body">
              <input type="hidden" class="form-control" id="id" name="id" />
              <h4 class="card-title text-center">Yakin ingin menghapus BANNER ini?</h4>
          </div>
          <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">KEMBALI</button>
              <button type="button" class="btn btn-danger" id="btn_delete" >YA, HAPUS!</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#deleteBanner').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        });

        $('#btn_delete').on('click',function(){
            var id=$('#id').val();
            $.ajax({
                type : "POST",
                url  : "<?= site_url('layanan/contest/delete') ?>",
                // dataType : "JSON",
                data : {id:$('#id').val()},
                success: function(result){
                    // result = JSON.parse(result)
                    // alert(result);

                    $('#deleteBanner').modal('hide');
                    window.location = '<?= base_url('layanan/contest'); ?>';
                }
            });
            return false;
        });
    });
</script>