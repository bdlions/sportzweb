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
                right: 'month,basicWeek,basicDay,Tasks'
            },
            eventColor: '#75B3E6',
            timeFormat: 'h:mm a',
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
                //$('#modalTitle').html(event.session_info.title);
                $('#session_client_group').html(event.session_info.created_for);
                $('#session_title').html(event.session_info.title);
                $('#session_location').html(event.session_info.location);
                $('#session_cost').html(event.session_info.currency_title+' '+event.session_info.cost);
                //$('#session_currency_id').html(event.session_info.currency_title);
                $('#session_status').html(event.session_info.status_title);
                status_id = event.session_info.status_id;
                if (status_id == '<?php echo GYMPRO_SESSION_STATUS_UNPAID_ID ?>') {
                    $('#pay_session_button').show();
                }
                else
                {
                    $('#pay_session_button').hide();
                }
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

        $("#delete_prompt_btn").on('click', function() {
            $('#session_view_modal').modal('hide');
            $('#delete_confirm_modal').modal();
        });
        $("#delete_confirmed_btn").on('click', function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "<?php echo base_url() . 'applications/gympro/delete_session'; ?>",
                data: {
                    session_id: $("#selected_session").val()
                },
                success: function(data) {
                   // alert(data['message']);
                    var message = data['message'];
                    print_common_message(message);
                    window.location.reload();
                }
            });
        });

    });

    function show_session() {
        window.location.replace("<?php echo base_url() . 'applications/gympro/show_session/'; ?>" + $("#selected_session").val());
    }

    function pay_session() {
        window.location.replace(
                "<?php echo base_url() . 'payment/pay_ptpro/'; ?>"
                + $("#selected_session").val());
    }

</script>
<div class="container-fluid">
    <div class="row top_margin">
        <?php
        if ($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) {
            $this->load->view("applications/gympro/template/sections/client_left_pane");
            echo
            '<div class="col-md-9">';
        } else {
            $this->load->view("applications/gympro/template/sections/pt_left_pane");
            echo
            '<div class="col-md-10">' .
            '<div class="row form-group">' .
            '<div class="col-md-2">' .
            '<a href="' . base_url() . 'applications/gympro/create_session">' .
            '<button class="btn button-custom btn_gympro">New Session</button>' .
            '</a>' .
            '</div>' .
            '</div>';
        }
        ?>

        <div class="row col-md-12" style="color:blue; font-size:16px;">
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <span class="text_size_14px">Schedule PT sessions for your clients. Client's can then instantly see these sessions and make payments to your online account</span>
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
                <h4 id="modalTitle" class="modal-title">Session</h4>
            </div>
            <div id="modalBody" class="modal-body">
                <div class="row">
                    <div class="col-sm-offset-2 col-sm-8" style="font-size: 16px;">
                        <div class="row form-group">
                            <div class="col-sm-4">Client/Group:</div>
                            <div class="col-sm-8">
                                <div id="session_client_group"></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4">Session:</div>
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
                            <div class="col-sm-4">Cost:</div>
                            <div class="col-sm-5">
                                <div id="session_cost"></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4">Status:</div>
                            <div class="col-sm-8">
                                <div id="session_status"></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!--FOR PTPRO-->
            <div class="modal-footer" style="display: <?php echo ($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) ? 'none' : 'block'; ?>">
                <a id="session_edit" href="<?php echo base_url() . 'applications/gympro/update_session/'; ?>"><button class="btn btn_gympro button-custom">Edit Session</button></a>
                <button id="delete_prompt_btn" class="btn btn_gympro button-custom">Delete Session</button>
                <button type="button" class="btn btn_gympro button-custom" data-dismiss="modal">Close</button>
            </div>

            <!--FOR CLIENT-->
            <div class="modal-footer" style="display: <?php echo ($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) ? 'block' : 'none'; ?>">
                <button class="btn btn_gympro button-custom" onclick="show_session()">Show Session Details</button>
                <button id="pay_session_button" class="btn btn_gympro button-custom" onclick="pay_session()" style="display: none">Pay Session</button>
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



