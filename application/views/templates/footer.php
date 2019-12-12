<footer class="footer">
    <div class="container-fluid">
        <!-- <div class="copyright float-center">
           Menemukan masalah? <a href="#" data-toggle="modal" data-target="#laporModal">LAPORKAN!</a>
        </div> -->
        <div class="copyright float-right">
            &copy;
            <script>
                document.write(new Date().getFullYear())
            </script>, made with <i class="material-icons">favorite</i> by Winteq Digitalization Team.
        </div>
    </div>
</footer>
</div>
<!-- end main-panel-->
<?php $this->load->view('modal/index'); ?>

</div>
<!-- end wrapper-->
<div class="fixed-plugin">
    <div class="dropdown show-dropdown">
        <a href="#" data-toggle="dropdown">
            <i class="fa fa-comments fa-2x"> </i>
        </a>
        <ul class="dropdown-menu">
        <li class="header-title">Butuh Bantuan?</li>
            <li class="button-container">
                      <a href="https://wa.me/6281373096232?text=Tanya%20tentang%20RAISA?%20" target="_blank" class="btn btn-rose btn-block btn-fill">RAISA +62813-7309-6232</a>
                      <a href="https://wa.me/6281311196988?text=Tanya%20tentang%20RAISA?%20" target="_blank" class="btn btn-info btn-block btn-fill">DIO +62813-1119-6988</a>
            </li>
            <!-- <li class="header-title"> Sidebar Filters</li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger active-color">
                    <div class="badge-colors ml-auto mr-auto">
                        <span class="badge filter badge-purple" data-color="purple"></span>
                        <span class="badge filter badge-azure" data-color="azure"></span>
                        <span class="badge filter badge-green" data-color="green"></span>
                        <span class="badge filter badge-warning" data-color="orange"></span>
                        <span class="badge filter badge-danger" data-color="danger"></span>
                        <span class="badge filter badge-rose active" data-color="rose"></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li> -->
            <!-- <li class="header-title">Sidebar Background</li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="ml-auto mr-auto">
                        <span class="badge filter badge-black active" data-background-color="black"></span>
                        <span class="badge filter badge-white" data-background-color="white"></span>
                        <span class="badge filter badge-red" data-background-color="red"></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li> -->
            <!-- <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                    <p>Sidebar Mini</p>
                    <label class="ml-auto">
                        <div class="togglebutton switch-sidebar-mini">
                            <label>
                                <input type="checkbox">
                                <span class="toggle"></span>
                            </label>
                        </div>
                    </label>
                    <div class="clearfix"></div>
                </a>
            </li> -->
            <!-- <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                    <p>Sidebar Images</p>
                    <label class="switch-mini ml-auto">
                        <div class="togglebutton switch-sidebar-image">
                            <label>
                                <input type="checkbox" checked="">
                                <span class="toggle"></span>
                            </label>
                        </div>
                    </label>
                    <div class="clearfix"></div>
                </a>
            </li> -->
            <!-- <li class="header-title">Images</li>
            <li class="active">
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="<?= base_url(); ?>assets/img/sidebar-1.jpg" alt="">
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="<?= base_url(); ?>assets/img/sidebar-2.jpg" alt="">
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="<?= base_url(); ?>assets/img/sidebar-3.jpg" alt="">
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="<?= base_url(); ?>assets/img/sidebar-4.jpg" alt="">
                </a>
            </li> -->
        </ul>
    </div>
</div>
<!--   Core JS Files   -->
<script src="<?= base_url(); ?>assets/js/core/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/js/core/popper.min.js"></script>
<script src="<?= base_url(); ?>assets/js/core/bootstrap-material-design.min.js"></script>
<script src="<?= base_url(); ?>assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- Plugin for the momentJs  -->
<script src="<?= base_url(); ?>assets/js/plugins/moment.min.js"></script>
<!--  Plugin for Sweet Alert -->
<script src="<?= base_url(); ?>assets/js/plugins/sweetalert2.js"></script>
<script src="<?= base_url(); ?>assets/js/plugins/sweet-alert.js"></script>
<!-- Forms Validations Plugin -->
<script src="<?= base_url(); ?>assets/js/plugins/jquery.validate.min.js"></script>
<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="<?= base_url(); ?>assets/js/plugins/jquery.bootstrap-wizard.js"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="<?= base_url(); ?>assets/js/plugins/bootstrap-selectpicker.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="<?= base_url(); ?>assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
<!-- Plugin for the Modal  -->
<script src="<?= base_url(); ?>assets/js/plugins/bootstrap-modal.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
<script src="<?= base_url(); ?>assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/js/plugins/dataTables.js"></script>
<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="<?= base_url(); ?>assets/js/plugins/bootstrap-tagsinput.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?= base_url(); ?>assets/js/plugins/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="<?= base_url(); ?>assets/js/plugins/fullcalendar.min.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="<?= base_url(); ?>assets/js/plugins/jquery-jvectormap.js"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="<?= base_url(); ?>assets/js/plugins/nouislider.min.js"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="<?= base_url(); ?>assets/js/plugins/arrive.min.js"></script>
<!--  Google Maps Plugin    -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-ubIYpWmP5j_UGlt6B4xzUsjASRsmeo0"></script>
<!-- Chartist JS -->
<script src="<?= base_url(); ?>assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?= base_url(); ?>assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?= base_url(); ?>assets/js/material-dashboard.js?v=2.1.0" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $().ready(function() {
            $sidebar = $('.sidebar');

            $sidebar_img_container = $sidebar.find('.sidebar-background');

            $full_page = $('.full-page');

            $sidebar_responsive = $('body > .navbar-collapse');

            window_width = $(window).width();

            fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

            if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                    $('.fixed-plugin .dropdown').addClass('open');
                }

            }

            $('.fixed-plugin a').click(function(event) {
                // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                if ($(this).hasClass('switch-trigger')) {
                    if (event.stopPropagation) {
                        event.stopPropagation();
                    } else if (window.event) {
                        window.event.cancelBubble = true;
                    }
                }
            });

            $('.fixed-plugin .active-color span').click(function() {
                $full_page_background = $('.full-page-background');

                $(this).siblings().removeClass('active');
                $(this).addClass('active');

                var new_color = $(this).data('color');

                if ($sidebar.length != 0) {
                    $sidebar.attr('data-color', new_color);
                }

                if ($full_page.length != 0) {
                    $full_page.attr('filter-color', new_color);
                }

                if ($sidebar_responsive.length != 0) {
                    $sidebar_responsive.attr('data-color', new_color);
                }
            });

            $('.fixed-plugin .background-color .badge').click(function() {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');

                var new_color = $(this).data('background-color');

                if ($sidebar.length != 0) {
                    $sidebar.attr('data-background-color', new_color);
                }
            });

            $('.fixed-plugin .img-holder').click(function() {
                $full_page_background = $('.full-page-background');

                $(this).parent('li').siblings().removeClass('active');
                $(this).parent('li').addClass('active');


                var new_image = $(this).find("img").attr('src');

                if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                    $sidebar_img_container.fadeOut('fast', function() {
                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $sidebar_img_container.fadeIn('fast');
                    });
                }

                if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                    var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                    $full_page_background.fadeOut('fast', function() {
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                        $full_page_background.fadeIn('fast');
                    });
                }

                if ($('.switch-sidebar-image input:checked').length == 0) {
                    var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                    var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                    $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                    $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                }

                if ($sidebar_responsive.length != 0) {
                    $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                }
            });

            $('.switch-sidebar-image input').change(function() {
                $full_page_background = $('.full-page-background');

                $input = $(this);

                if ($input.is(':checked')) {
                    if ($sidebar_img_container.length != 0) {
                        $sidebar_img_container.fadeIn('fast');
                        $sidebar.attr('data-image', '#');
                    }

                    if ($full_page_background.length != 0) {
                        $full_page_background.fadeIn('fast');
                        $full_page.attr('data-image', '#');
                    }

                    background_image = true;
                } else {
                    if ($sidebar_img_container.length != 0) {
                        $sidebar.removeAttr('data-image');
                        $sidebar_img_container.fadeOut('fast');
                    }

                    if ($full_page_background.length != 0) {
                        $full_page.removeAttr('data-image', '#');
                        $full_page_background.fadeOut('fast');
                    }

                    background_image = false;
                }
            });

            $('.switch-sidebar-mini input').change(function() {
                $body = $('body');

                $input = $(this);

                if (md.misc.sidebar_mini_active == true) {
                    $('body').removeClass('sidebar-mini');
                    md.misc.sidebar_mini_active = false;

                    $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                } else {

                    $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                    setTimeout(function() {
                        $('body').addClass('sidebar-mini');

                        md.misc.sidebar_mini_active = true;
                    }, 300);
                }

                // we simulate the window Resize so the charts will get updated in realtime.
                var simulateWindowResize = setInterval(function() {
                    window.dispatchEvent(new Event('resize'));
                }, 180);

                // we stop the simulation of Window Resize after the animations are completed
                setTimeout(function() {
                    clearInterval(simulateWindowResize);
                }, 1000);

            });
        });
    });
</script>
<!-- javascript for init -->
<script>
    $('.datetimepicker').datetimepicker({
        format: 'Y-M-D HH:mm',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        }
    });
    $('.datepicker').datetimepicker({
        format: 'DD-MM-YYYY',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        }
    });
    $('.timepicker').datetimepicker({
        format: 'HH:mm',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        }
    });

    function setFormValidation(id) {
        $(id).validate({
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
                $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
                $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').append(error);
            },
        });
    }

    $(document).ready(function() {
        setFormValidation('#Aktivitas');
        setFormValidation('#TypeValidation');
        setFormValidation('#LoginValidation');
        setFormValidation('#RangeValidation');
    });
</script>
<!-- JS fullcalendar -->
<script>
    $(document).ready(function() {
        $cJamkerja = $('#calendarJamkerja');

        today = new Date();
        y = today.getFullYear();
        m = today.getMonth();
        d = today.getDate();

        $cJamkerja.fullCalendar({
            timeZone: 'asia/jakarta', // the default (unnecessary to specify)
            viewRender: function(view, element) {
                // We make sure that we activate the perfect scrollbar when the view isn't on Month
                if (view.name != 'month') {
                    $(element).find('.fc-scroller').perfectScrollbar();
                }
            },
            header: {
                left: 'month,agendaWeek,agendaDay',
                center: 'title',
                right: 'prev,next,today'
            },

            firstDay: 1,
            defaultDate: today,
            businessHours: [{
                    default: false,
                    // days of week. an array of zero-based day of week integers (0=Sunday)
                    dow: [1, 2, 3, 4], // Monday - Friday
                    start: '07:30', // a start time 
                    end: '16:30' // an end time 
                },
                {
                    default: false,
                    // days of week. an array of zero-based day of week integers (0=Sunday)
                    dow: [5], // Monday - Friday
                    start: '07:00', // a start time 
                    end: '16:00' // an end time 
                },
            ],

            views: {
                month: { // name of view
                    titleFormat: 'MMMM YYYY'
                    // other view-specific options here
                },
                week: {
                    titleFormat: " MMMM D YYYY"
                },
                day: {
                    titleFormat: 'D MMM, YYYY'
                }
            },

            selectable: true,
            selectHelper: true,
            editable: true,

            eventSources: [{
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: '<?php echo base_url() ?>jamkerja/get_events',
                        dataType: 'json',
                        success: function(msg) {
                            var events = msg.events;
                            callback(events);
                        }
                    });
                }
            }, ],
            eventLimit: true, // allow "more" link when too many events

            select: function(start, end) {

                // on select we show the Sweet Alert modal with an input
                swal({
                        title: 'Create an Event',
                        html: '<div class="form-group">' +
                            '<input class="form-control" placeholder="Event Title" id="input-field">' +
                            '</div>',
                        showCancelButton: true,
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false
                    }).then(function(result) {

                        var eventData;
                        event_title = $('#input-field').val();

                        if (event_title) {
                            eventData = {
                                title: event_title,
                                start: start,
                                end: end
                            };
                            $calendar.fullCalendar('renderEvent', eventData, true); // stick? = true
                        }
                        $calendar.fullCalendar('unselect');
                    })
                    .catch(swal.noop);
            },
            eventClick: function(info) {
                $('#rsvBatal').modal("show");
            }

        });
    });
</script>
<!-- script ajax Kategori-->
<script type="text/javascript">
    function kategoriSelect(valueSelect)
            {
                var val = valueSelect.options[valueSelect.selectedIndex].value;
                document.getElementById("admWbs").style.display = val != '1' ? "block" : 'none';
                document.getElementById("admCopro").style.display = val != '3' ? "block" : 'none';
            }
        $('#kategori').change(function(){
            var kategori = $('#kategori').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('lembur/ajax')?>",
                data: {kategori:kategori},
                success: function(data) {
                    // alert(data)
                    $('#wbs').html(data); 
                if(kategori == 1){
                    $('#wbs').prop('disabled', true);
                }
                else if(kategori == 3){
                    $('#copro').prop('disabled', true);
                }
                else{
                    $('#copro').prop('disabled', false);
                    $('#wbs').prop('disabled', false);
                }    
                }
            })
        })
        
    </script>

</body>

</html>