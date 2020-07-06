<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ml-auto mr-auto">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Laporan Kerja Harian</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            </br>
                            <form class="form" id="formDate" method="post" action="<?= base_url('jamkerja/pilihtanggal'); ?>">
                                <div class="form-group label-floating">
                                    <div class="input-group date">
                                        <input type="text" id="tanggal" name="tanggal" class="form-control datepicker" value="<?= date('d-m-y');?>" placeholder="Pilih Tanggal" required="true" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success"> Submit <i class="material-icons">keyboard_return</i></button>
                            </form>
                        </div>
                    </div>
                    <div class="card card-calendar">
                        <div class="card-body ">
                            <div id="calendarJamkerja"></div>
                        </div>
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

<script type="text/javascript">
    $(document).ready(function() {
        var cJamkerja = $('#calendarJamkerja');

        today = new Date();
        y = today.getFullYear();
        m = today.getMonth();
        d = today.getDate();

        cJamkerja.fullCalendar({
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
                dow: [1, 2, 3, 4, 5], // Monday - Friday
                start: '07:30', // a start time 
                end: '16:30' // an end time 
            }],

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
                            url: '<?php echo base_url() ?>jamkerja/GET_MY_jamkerja',
                            dataType: 'json',
                            success: function(msg) {
                                var events = msg.events;
                                callback(events);
                            }
                        });
                    }
                },
                {
                    events: function(start, end, timezone, callback) {
                        $.ajax({
                            url: '<?php echo base_url() ?>jamkerja/GET_MY_lembur',
                            dataType: 'json',
                            success: function(msg) {
                                var events = msg.events;
                                callback(events);
                            }
                        });
                    },
                    color: 'red' // an option!
                },
            ],
            eventLimit: true, // allow "more" link when too many events

            select: function(start, end, info) {

                window.location = '<?= base_url('jamkerja/checktanggal/'); ?>' + start.format();
            },

            // select: function (start, end) {
            //     // on select we show the Sweet Alert modal with an input
            //     swal({
            //         title: 'Maaf untuk sementara fitur ini di-nonaktifkan, silahkan gunakan tombol yang ada di atas.',
            //     })
            //     .catch(swal.noop);
            // },

        });
    });
</script>