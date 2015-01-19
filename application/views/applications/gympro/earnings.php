<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/fullcalendar.css">
<script type="text/javascript" src="<?php echo base_url() ?>resources/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>resources/js/fullcalendar.js"></script>

<style>
    .calender_cell:hover
    {
        background-color: #aaa;
        color: white;
    }
    .calender_cell
    {
        background-color: #ddd;
        padding: 10px;
        width: 13.5%;
        height: 60px;
        overflow: hidden;
        float: left;
        margin: 1px;
        font-size: 12px;
    }
    body {
        overflow-x:hidden;
    }
</style>
<script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            defaultDate: moment().format("YYYY-MM-DD"),
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: JSON.parse('<?php echo $events ?>'),
            firstDay: 0,
            eventClick: function(event, jsEvent, view) {
                $('#modalTitle').html(event.title);
                $('#modalBody').html(event.description);
                $('#fullCalModal').modal();
            },
            dayClick: function(date, jsEvent, view) {
                $('#calendar').fullCalendar('changeView', 'agendaDay');
                $('#calendar').fullCalendar('gotoDate', date);
            }
        });

    });

</script>
<div class="container-fluid">
    <div class="row top_margin">
        <?php
        if ($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) {
            $this->load->view("applications/gympro/template/sections/client_left_pane");
        } else {
            $this->load->view("applications/gympro/template/sections/pt_left_pane");
        }
        ?>
        <div class="col-md-10">
            <div class="row form-group">
                <div class="col-md-2">
                    <a href="<?php echo base_url() ?>applications/gympro/create_session"><button class="btn button-custom btn_gympro">New Session</button></a>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
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
                </div>
            </div>
        </div>
    </div>
</div>