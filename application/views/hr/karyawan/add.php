<div class="content">
        <div class="container-fluid">
            <div class="col-md-12 col-12 mr-auto ml-auto">
            <!--      Wizard container        -->
            <div class="wizard-container">
              <div class="card card-wizard" data-color="blue" id="wizardProfile">
              <?= form_open_multipart('hr/tambah'); ?>
                  <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                  <div class="card-header text-center">
                    <h3 class="card-title">
                      Build Profile
                    </h3>
                    <h5 class="card-description">This information will let us know more about new employee.</h5>
                  </div>
                  <div class="wizard-navigation">
                    <ul class="nav nav-pills">
                      <li class="nav-item">
                        <a class="nav-link active" href="#about" data-toggle="tab" role="tab">
                          About
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#account" data-toggle="tab" role="tab">
                          Account
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#role" data-toggle="tab" role="tab">
                          Role
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="tab-pane active" id="about">
                        <h5 class="info-text"> Let's start with the basic information (with validation)</h5>
                        <div class="row justify-content-center">
                          <div class="col-sm-3 mt-3">
                            <div class="picture-container">
                              <div class="picture">
                                <img src="<?= base_url(); ?>assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title="" />
                                <input type="file" name="foto" id="wizard-picture">
                              </div>
                              <h6 class="description">Choose Picture</h6>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">pin</i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="npkLabel" class="bmd-label-floating">NPK (required)</label>
                                <input type="text" class="form-control" id="npk" name="npk" required>
                              </div>
                            </div>
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">face</i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="namaLabel" class="bmd-label-floating">Nama Lengkap (required)</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                              </div>
                            </div>
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">record_voice_over</i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="inisialLabel" class="bmd-label-floating">Inisial (required)</label>
                                <input type="text" class="form-control" id="inisial" name="inisial" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-8 mt-3">
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">email</i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="emailLabel" class="bmd-label-floating">Email (required)</label>
                                <input type="email" class="form-control" id="emalil" name="email" required>
                              </div>
                            </div>
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">whatsapp</i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="phoneLabel" class="bmd-label-floating">No HP (required)</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="account">
                        <h5 class="info-text"> What are Position? </h5>
                        <div class="row justify-content-center">
                            <div class="col-sm-10">
                                <div class="form-group select-wizard">
                                    <label class="bmd-label-static">Divisi (required)</label>
                                    <select class="selectpicker" name="div" id="div" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                    <?php
                                    $divisi = $this->db->get('karyawan_div')->result();
                                    foreach ($divisi as $row) :
                                        echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group select-wizard">
                                    <label class="bmd-label-static">Department (required)</label>
                                    <select class="selectpicker" name="dept" id="dept" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required></select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group select-wizard">
                                    <label class="bmd-label-static">Unit Organisasi (required)</label>
                                    <select class="selectpicker" name="sect" id="sect" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required></select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group select-wizard">
                                    <label class="bmd-label-static">Jabatan / Posisi (required)</label>
                                    <select class="selectpicker" name="posisi" id="posisi" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                    <?php $posisi = $this->db->get('karyawan_posisi')->result();
                                    foreach ($posisi as $row) :
                                        echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group select-wizard">
                                    <label class="bmd-label-static">Golongan (required)</label>
                                    <select class="selectpicker" name="gol" id="gol" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                    <?php $gol = $this->db->get('karyawan_gol')->result();
                                    foreach ($gol as $row) :
                                        echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group select-wizard">
                                    <label class="bmd-label-static">Fasilitas (required)</label>
                                    <select class="selectpicker" name="fasilitas" id="fasilitas" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                    <?php $fasilitas = $this->db->get('karyawan_fasilitas')->result();
                                    foreach ($fasilitas as $row) :
                                        echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group select-wizard">
                                    <label class="bmd-label-static">Work Contract (required)</label>
                                    <select class="selectpicker" name="work_contract" id="work_contract" title="Pilih" data-size="2" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                      <?php $caontract = $this->db->get('karyawan_caontract')->result();
                                      foreach ($caontract as $row) :
                                          echo '<option value="'.$row->nama.'">'.$row->nama.'</option>';
                                      endforeach; ?>
                                    </select>
                                    </div>
                                </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="costLabel" class="bmd-label-floating">Cost Center (required)</label>
                                    <input type="text" class="form-control" id="cost_center" name="cost_center" required>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="role">
                        <div class="row justify-content-center">
                          <div class="col-sm-12">
                            <h5 class="info-text"> Give some an access? </h5>
                          </div>
                          <div class="col-sm-4">
                                <div class="form-group select-wizard">
                                    <label class="bmd-label-static">Atasan 1 (required)</label>
                                    <select class="selectpicker" name="atasan1" id="atasan1" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                    <?php foreach ($posisi as $row) :
                                        echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                          <div class="col-sm-4">
                                <div class="form-group select-wizard">
                                    <label class="bmd-label-static">Atasan 2 (required)</label>
                                    <select class="selectpicker" name="atasan2" id="atasan2" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                    <?php foreach ($posisi as $row) :
                                        echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group select-wizard">
                                    <label class="bmd-label-static">Status (required)</label>
                                    <select class="selectpicker" name="status" id="status" title="Pilih" data-size="2" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                        <option value="1"> Karyawan </option>
                                        <option value="0"> Non Karyawan </option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                <div class="form-group select-wizard">
                                    <label class="bmd-label-static">User Akses (required)</label>
                                    <select class="selectpicker" name="role" id="role" title="Pilih" data-style="select-with-transition" data-size="5" data-width="100%" data-live-search="false" required>
                                    <?php $role = $this->db->get('user_role')->result();
                                    foreach ($role as $row) :
                                        echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="mr-auto">
                      <input type="button" class="btn btn-previous btn-fill btn-default btn-wd disabled" name="previous" value="Previous">
                    </div>
                    <div class="ml-auto">
                      <input type="button" class="btn btn-next btn-fill btn-rose btn-wd" name="next" value="Next">
                      <input type="submit" class="btn btn-finish btn-fill btn-success btn-wd" name="finish" value="Finish" style="display: none;">
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </form>
              </div>
            </div>
            <!-- wizard container -->
          </div>
    </div>
    <!-- end container-fluid-->
</div>
<!-- end content-->
<script>
    $(document).ready(function() {
      // Initialise the wizard

    // Code for the Validator
    var $validator = $('.card-wizard form').validate({
      rules: {
        firstname: {
          required: true,
          minlength: 3
        },
        lastname: {
          required: true,
          minlength: 3
        },
        email: {
          required: true,
          minlength: 3,
        }
      },

      highlight: function (element) {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
      },
      success: function (element) {
        $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
      },
      errorPlacement: function (error, element) {
        $(element).append(error);
      }
    });



    // Wizard Initialization
    $('.card-wizard').bootstrapWizard({
      'tabClass': 'nav nav-pills',
      'nextSelector': '.btn-next',
      'previousSelector': '.btn-previous',

      onNext: function (tab, navigation, index) {
        var $valid = $('.card-wizard form').valid();
        if (!$valid) {
          $validator.focusInvalid();
          return false;
        }
      },

      onInit: function (tab, navigation, index) {
        //check number of tabs and fill the entire row
        var $total = navigation.find('li').length;
        var $wizard = navigation.closest('.card-wizard');

        $first_li = navigation.find('li:first-child a').html();
        $moving_div = $('<div class="moving-tab">' + $first_li + '</div>');
        $('.card-wizard .wizard-navigation').append($moving_div);

        refreshAnimation($wizard, index);

        $('.moving-tab').css('transition', 'transform 0s');
      },

      onTabClick: function (tab, navigation, index) {
        var $valid = $('.card-wizard form').valid();

        if (!$valid) {
          return false;
        } else {
          return true;
        }
      },

      onTabShow: function (tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index + 1;

        var $wizard = navigation.closest('.card-wizard');

        // If it's the last tab then hide the last button and show the finish instead
        if ($current >= $total) {
          $($wizard).find('.btn-next').hide();
          $($wizard).find('.btn-finish').show();
        } else {
          $($wizard).find('.btn-next').show();
          $($wizard).find('.btn-finish').hide();
        }

        button_text = navigation.find('li:nth-child(' + $current + ') a').html();

        setTimeout(function () {
          $('.moving-tab').text(button_text);
        }, 150);

        var checkbox = $('.footer-checkbox');

        if (!index == 0) {
          $(checkbox).css({
            'opacity': '0',
            'visibility': 'hidden',
            'position': 'absolute'
          });
        } else {
          $(checkbox).css({
            'opacity': '1',
            'visibility': 'visible'
          });
        }

        refreshAnimation($wizard, index);
      }
    });


    // Prepare the preview for profile picture
    $("#wizard-picture").change(function () {
      readURL(this);
    });

    $('[data-toggle="wizard-radio"]').click(function () {
      wizard = $(this).closest('.card-wizard');
      wizard.find('[data-toggle="wizard-radio"]').removeClass('active');
      $(this).addClass('active');
      $(wizard).find('[type="radio"]').removeAttr('checked');
      $(this).find('[type="radio"]').attr('checked', 'true');
    });

    $('[data-toggle="wizard-checkbox"]').click(function () {
      if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        $(this).find('[type="checkbox"]').removeAttr('checked');
      } else {
        $(this).addClass('active');
        $(this).find('[type="checkbox"]').attr('checked', 'true');
      }
    });

    $('.set-full-height').css('height', 'auto');

    //Function to show image before upload

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $(window).resize(function () {
      $('.card-wizard').each(function () {
        $wizard = $(this);

        index = $wizard.bootstrapWizard('currentIndex');
        refreshAnimation($wizard, index);

        $('.moving-tab').css({
          'transition': 'transform 0s'
        });
      });
    });

    function refreshAnimation($wizard, index) {
      $total = $wizard.find('.nav li').length;
      $li_width = 100 / $total;

      total_steps = $wizard.find('.nav li').length;
      move_distance = $wizard.width() / total_steps;
      index_temp = index;
      vertical_level = 0;

      mobile_device = $(document).width() < 600 && $total > 3;

      if (mobile_device) {
        move_distance = $wizard.width() / 2;
        index_temp = index % 2;
        $li_width = 50;
      }

      $wizard.find('.nav li').css('width', $li_width + '%');

      step_width = move_distance;
      move_distance = move_distance * index_temp;

      $current = index + 1;

      if ($current == 1 || (mobile_device == true && (index % 2 == 0))) {
        move_distance -= 8;
      } else if ($current == total_steps || (mobile_device == true && (index % 2 == 1))) {
        move_distance += 8;
      }

      if (mobile_device) {
        vertical_level = parseInt(index / 2);
        vertical_level = vertical_level * 38;
      }

      $wizard.find('.moving-tab').css('width', step_width);
      $('.moving-tab').css({
        'transform': 'translate3d(' + move_distance + 'px, ' + vertical_level + 'px, 0)',
        'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'

      });
    };
    setTimeout(function() {
        $('.card.card-wizard').addClass('active');
      }, 600);
    });
    $(document).ready(function() {
        $('#div').change(function() {
            var div = $('#div').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('hr/dept') ?>",
                data: {
                    div: div
                },
                success: function(data) {
                    // alert(data)
                    $('#dept').html(data);
                    $('#dept').selectpicker('refresh');
                    $('#sect').selectpicker('val', '');
                    $('#sect').selectpicker('refresh');
                }
            })
        })
        $('#dept').change(function() {
            var dept = $('#dept').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('hr/sect') ?>",
                data: {
                    dept: dept
                },
                success: function(data) {
                    // alert(data)
                    $('#sect').html(data);
                    $('#sect').selectpicker('refresh');
                }
            })
        })
    });
  </script>