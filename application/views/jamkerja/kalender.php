<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
        <div class="header text-center">
            <h3 class="title">Jam Kerja</h3>
        </div>
        <div class="row">
            <div class="col-md-10 ml-auto mr-auto">
                <div class="card card-calendar">
                    <div class="card-body ">
                        <div id="calendarJamkerja"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end content -->
<!-- Modal View JamKerja -->
<div class="modal fade" id="jamkerjaModal" tabindex="-1" role="dialog" aria-labelledby="jamkerjaModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-info text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">Jam Kerja</h4>
                    </div>
                </div>
                <form class="form" method="post" action="<?= base_url('project/wbs'); ?>">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">COPRO</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="copro">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">No Material</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="no_material">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Deskripsi</label>
                                <div class="col-md-8">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="deskripsi">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Status</label>
                                <div class="col-md-4">
                                    <div class="form-group has-default">
                                        <input type="text" class="form-control disabled" name="status">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-info btn-round">WBS</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
                    dow: [1, 2, 3, 4, 5], // Monday - Friday
                    start: '07:30', // a start time 
                    end: '16:30' // an end time 
                }
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