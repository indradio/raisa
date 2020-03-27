<div class="content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <div class="container-fluid">
    <div class="row">
            <div class="col-md-10 ml-auto mr-auto">
                <div class="card">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Kamu belum melaporkan <b>JAM KERJA? </b></h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <a href="#" class="btn btn-lg btn-block btn-youtube mb-2 disabled" role="button" data-toggle="modal" data-target="#jamkerjaModal" aria-disabled="false">LANGSUNG KLIK SAJA PADA TANGGAL DI KALENDER!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 ml-auto mr-auto">
                <div class="card card-calendar">
                    <div class="card-body ">
                        <div id="calendarJamkerja"></div>
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

<!-- Modal JamKerja -->
<div class="modal fade" id="jamkerjaModal" tabindex="-1" role="dialog" aria-labelledby="jamkerjaModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-danger text-center">
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="card-title">LAPORAN KERJA HARIAN</h4> -->
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="<?= base_url('jamkerja/pilihtanggal'); ?>">
                    <div class="modal-body">
                      <div class="form-group label-floating">
                        <div class="input-group date">
                          <input type="text" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Pilih Tanggal" required="true" />
                          <div class="input-group-append">
                            <span class="input-group-text">
                              <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                      <button type="submit" class="btn btn-success">BUAT LAPORAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>

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
            
            eventSources: [
            {
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
                color: 'red'   // an option!
            },
            ],
            eventLimit: true, // allow "more" link when too many events

            // dateClick: function(info) {
            //     alert('Date: ' + info.dateStr);
            //     alert('Resource ID: ' + info.resource.id);
            // },
            
            select: function(start, end, info) {
                
                window.location = 'https://raisa.winteq-astra.com/jamkerja/tanggal/' + start.format();
                // on select we show the Sweet Alert modal with an input
                // swal({
                //         title: 'Maaf, Fitur ini masih dalam pengembangan.',
                //         // html: '<div class="form-group">' +
                //         //     '<input class="form-control" placeholder="Event Title" id="input-field">' +
                //         //     '</div>',
                //         html: 'Silahkan gunakan tombol "laporkan sekarang!" di atas untuk memilih tanggal yang kamu inginkan.'+y,
                //         showCancelButton: false,
                //         confirmButtonClass: 'btn btn-success',
                //         cancelButtonClass: 'btn btn-danger',
                //         buttonsStyling: false
                //     }).then(function(result) {

                //         var eventData;
                //         event_title = $('#input-field').val();

                //         if (event_title) {
                //             eventData = {
                //                 title: event_title,
                //                 start: start,
                //                 end: end
                //             };
                //             $calendar.fullCalendar('renderEvent', eventData, true); // stick? = true
                //         }
                //         $calendar.fullCalendar('unselect');
                //     })
                //     .catch(swal.noop);
            },
            
            // eventClick: function(info) {
            //     alert('Date: ' + info.dateStr);
            //     alert('Resource ID: ' + info.resource.id);
            //     // $('#jamkerjaModal').modal("show");
            // }
        });
    });
</script>