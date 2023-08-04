<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <table id="dt-asset" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="disabled-sorting">No</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Room</th>
                                        <th class="disabled-sorting th-description text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Room</th>
                                        <th class="th-description text-right">Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div> 
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->

<div class="modal fade" id="opname" tabindex="-1" role="dialog" aria-labelledby="opnameLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="opnameLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?= form_open_multipart('asset/opname'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="status" name="status" required="true" />
                        <input type="hidden" class="form-control" id="id" name="id" required="true" />
                    </div>
                    <div class="row col-md-6 ml-auto mr-auto">
                        <div class="fileinput fileinput-new text-center" style="margin:auto;" data-provides="fileinput" >
                            <div class="fileinput-new thumbnail">
                                <img src="<?= base_url(); ?>assets/img/asset/sto-photo.jpg" alt="foto" name="foto">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div>
                                    <span class="btn btn-round btn-sm btn-facebook btn-file">
                                        <span class="fileinput-new">Upload</span>
                                        <span class="fileinput-exists">Ganti</span>
                                        <input type="file" name="foto" required="true"/> 
                                    </span>
                                    <!-- <br />
                                    <a href="#" class="btn btn-youtube btn-round fileinput-exists" data-dismiss="fileinput"></i>Hapus</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 ml-auto mr-auto">
                        <div class="form-group has-default">  
                            <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-default" id="labelOption1" style="width: 100%;">
                                <input type="radio" name="options" id="option1" autocomplete="off" value="1" required>BAIK-ADA-DIGUNAKAN
                            </label>
                            <label class="btn btn-default" id="labelOption2" style="width: 100%;">
                                <input type="radio" name="options" id="option2" autocomplete="off" value="2" required>BAIK-TIDAK SESUAI
                            </label>
                            <label class="btn btn-default" id="labelOption3" style="width: 100%;">
                                <input type="radio" name="options" id="option3" autocomplete="off" value="3" required>RUSAK
                            </label>
                            <label class="btn btn-default" id="labelOption4" style="width: 100%;">
                                <input type="radio" name="options" id="option4" autocomplete="off" value="4" required>HILANG
                            </label>
                            </div>   
                        </div>
                    </div>
                    <div class="col-md-10 ml-auto mr-auto" id="pic">
                        <div class="form-group">
                            <label class="col-form-label"><small>PIC*</small></label>
                            <select class="selectpicker" name="pic" id="selectpic" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" data-live-search="true">
                                <?php               $this->db->where('is_active','1');
                                                    $this->db->where('status','1');
                                        $karyawan = $this->db->get('karyawan')->result_array();
                                foreach ($karyawan as $row) :
                                    echo '<option value="' . $row['npk'] . '">' . $row['nama'] . '</option>' . "\n";
                                endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-10 ml-auto mr-auto"  id="lokasi">
                        <div class="form-group">
                            <label class="col-form-label"><small>LOKASI*</small></label>
                            <select class="selectpicker" name="lokasi" id="selectlokasi" data-style="select-with-transition" data-size="7" title="Silahkan Pilih" data-live-search="true">
                                <?php $lokasi = $this->db->get('asset_lokasi')->result_array();
                                foreach ($lokasi as $row) :
                                    echo '<option value="' . $row['id'] . '">' . $row['id'] . '</option>' . "\n";
                                endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-10 ml-auto mr-auto">
                        <div class="form-group">
                            <label for="note" class="bmd-label-floating"> Keterangan*<small><i>(jika rusak/hilang harus memberikan keterangan)</i></small></label>
                            <textarea rows="5" class="form-control" id="note" name="note"></textarea>
                        </div>
                    </div>
                    </p>
                    <div class="modal-footer">
                        <div class="ml-auto">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                          <button type="submit" id="submit" class="btn btn-success">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


<script>
    $(document).ready(function() {

        $('#dt-asset').DataTable({
            "pagingType": "full_numbers",
            scrollX: true,
            scrollCollapse: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            serverSide: false,
            processing: true,
            ajax: {
                    "url"   : "<?= site_url('asset/get/id') ?>",
                    "type"  : "POST"
                },
            columns: [
                { "data": "no" },
                { "data": "description" },
                { "data": "category" },
                { "data": "room" },
                { "data": "action", className: "text-right" }
            ],
        });

        $('#opname').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
        })

        document.getElementById("pic").style.display = "none";
        document.getElementById("lokasi").style.display = "none";

        var labelOption1 = document.getElementById('labelOption1');
        var labelOption2 = document.getElementById('labelOption2');
        var labelOption3 = document.getElementById('labelOption3');
        var labelOption4 = document.getElementById('labelOption4');

        var option1 = document.getElementById('option1');
        // when unchecked or checked, run the function
        option1.onchange = function() {
            if (this.checked) {
                document.getElementById('status').value = '1';
                labelOption1.style.background = '#00aec5';
                labelOption2.style.background = '#999999';
                labelOption3.style.background = '#999999';
                labelOption4.style.background = '#999999';
                document.getElementById("pic").style.display = "none";
                document.getElementById("lokasi").style.display = "none";
                document.getElementById("selectpic").required = false;
                document.getElementById("selectlokasi").required = false;
                document.getElementById("note").required = false;
            }
        }

        var option2 = document.getElementById('option2');
        // when unchecked or checked, run the function
        option2.onchange = function() {
            if (this.checked) {
                document.getElementById('status').value = '2';
                labelOption1.style.background = '#999999';
                labelOption2.style.background = '#00aec5';
                labelOption3.style.background = '#999999';
                labelOption4.style.background = '#999999';
                document.getElementById("pic").style.display = "block";
                document.getElementById("lokasi").style.display = "block";
                document.getElementById("selectpic").required = true;
                document.getElementById("selectlokasi").required = true;
                document.getElementById("note").required = false;
            }
        }

        var option3 = document.getElementById('option3');
        // when unchecked or checked, run the function
        option3.onchange = function() {
            if (this.checked) {
                document.getElementById('status').value = '3';
                labelOption1.style.background = '#999999';
                labelOption2.style.background = '#999999';
                labelOption3.style.background = '#00aec5';
                labelOption4.style.background = '#999999';
                document.getElementById("pic").style.display = "none";
                document.getElementById("lokasi").style.display = "none";
                document.getElementById("selectpic").required = false;
                document.getElementById("selectlokasi").required = false;
                document.getElementById("note").required = true;
            }
        }

        var option4 = document.getElementById('option4');
        // when unchecked or checked, run the function
        option4.onchange = function() {
            if (this.checked) {
                document.getElementById('status').value = '4';
                labelOption1.style.background = '#999999';
                labelOption2.style.background = '#999999';
                labelOption3.style.background = '#999999';
                labelOption4.style.background = '#00aec5';
                document.getElementById("pic").style.display = "none";
                document.getElementById("lokasi").style.display = "none";
                document.getElementById("selectpic").required = false;
                document.getElementById("selectlokasi").required = false;
                document.getElementById("note").required = true;
            }
        }
    });
</script>