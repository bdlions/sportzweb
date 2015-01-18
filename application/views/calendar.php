<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/fullcalendar.css">
<script type="text/javascript" src="<?php echo base_url() ?>resources/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>resources/js/fullcalendar.js"></script>

<script>

    $(document).ready(function() {

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            defaultDate: '2014-11-12',
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: JSON.parse('<?php echo $events?>'),
            eventClick:  function(event, jsEvent, view) {
                $('#modalTitle').html(event.title);
                $('#modalBody').html(event.description);
                $('#fullCalModal').modal();
            },
            dayClick: function(date, jsEvent, view) {
                $('#calendar').fullCalendar('gotoDate', date);
                $('#calendar').fullCalendar('changeView', 'agendaDay');
            }
        });

    });

</script>

<div id='calendar'></div>
<div id="fullCalModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body">
                <a href="#">Edit</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Save</button>
                <button class="btn btn-default">Delete</button>
            </div>
        </div>
    </div>
</div>