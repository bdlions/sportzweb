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
            eventColor: '#75B3E6',
            timeFormat: 'h.mm a',
            defaultDate: moment().format("YYYY-MM-DD"),
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: JSON.parse('<?php echo $events ?>'),
            firstDay: 1,
            selectable: true,
            selectHelper: true,
            slotMinutes: 60,
            aspectRatio: 2.5,
            eventClick: function(event, jsEvent, view) { 
                $('#modalTitle').html(event.session_info.title);
                $('#session_title').html(event.session_info.title);
                $('#session_location').html(event.session_info.location);
                var edit_href = document.getElementById('session_edit');
                edit_href.href += event.session_info.id;
                $("#selected_session").val(event.session_info.id);
                $('#session_view_modal').modal();
            },
            dayClick: function(date, jsEvent, view) {
                $('#calendar').fullCalendar('changeView', 'agendaDay');
                $('#calendar').fullCalendar('gotoDate', date);
            }
        });
        
        $("#delete_prompt_btn").on('click', function(){
            $('#session_view_modal').modal('hide');
            $('#delete_confirm_modal').modal();
        });
        $("#delete_confirmed_btn").on('click', function(){
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "<?php echo base_url().'applications/gympro/delete_session';?>",
                data: {
                    session_id : $("#selected_session").val()
                },
                success: function(data) {
                    alert(data['message']);
                    window.location.reload();
                }
            });
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
                </div>
            </div>
        </div>
    </div>
</div>

<div id="session_view_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body">
                <div class="row">
                    <div class="col-sm-offset-2 col-sm-8" style="font-size: 16px;">
                        <div class="row form-group">
                            <div class="col-sm-4">Title:</div>
                            <div class="col-sm-8">
                                <div id="session_title"></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4">Location:</div>
                            <div class="col-sm-8">
                                <div id="session_location"></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="session_edit" href="<?php echo base_url() . 'applications/gympro/update_session/'; ?>"><button class="btn btn_gympro button-custom">Edit Session</button></a>
                <button id="delete_prompt_btn" class="btn btn_gympro button-custom">Delete Session</button>
                <button type="button" class="btn btn_gympro button-custom" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div id="delete_confirm_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Delete Session</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
            </div>
            <div id="modalBody" class="modal-body">
                <div class="row">
                    <div class="col-sm-offset-2 col-sm-8" style="font-size: 16px;">
                        <h3>Are you sure?</h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="selected_session">
                <button id="delete_confirmed_btn" class="btn btn_gympro button-custom">Delete Session</button>
                <button type="button" class="btn btn_gympro button-custom" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>



