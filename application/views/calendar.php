<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/fullcalendar.css">
<script type="text/javascript" src="<?php echo base_url() ?>resources/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>resources/js/fullcalendar.js"></script>

<script>

    $(document).ready(function() {

        $('#calendar').fullCalendar({
            defaultDate: '2014-11-12',
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: JSON.parse('<?php echo $events?>')
        });

    });

</script>

<div id='calendar'></div>