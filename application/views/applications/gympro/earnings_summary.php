<script>
    function fetch_session_data()
    {
        $("#sessions_tmpl_place").html(null);
        $("#earnings_summary").html(null);
        var st_date = $('#st_date').val();
        var fin_date = $('#fin_date').val();
        var status_id = $('#status_id').val();
        if (fin_date == '' || st_date == '') {
            var message = "Please select the dates.";
            print_common_message(message);
            return;
        }
        var gr_or_cl = $("#group_client").val();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "<?php echo base_url() . 'applications/gympro/get_earning_summary'; ?>",
            data: {
                select_all:gr_or_cl,
                created_for_type_id: gr_or_cl.charAt(0),
                gr_cl_id: gr_or_cl.substring(2),
                start: st_date,
                end: fin_date,
                status_id: status_id
            },
            success: function (data) {
                $("#sessions_tmpl_place").html(tmpl("tmpl_sessions_summery", data));
                $("#earnings_summary").html(tmpl("tmpl_earnings_summary", data));
            }
        });
    }
    $(function () {
        $("#mark_status_dropdown").on('change', function () {
            var session_id_array = Array();
            var cb_name;
            $('input[name^="session_select_"]:checked').each(function () {
                cb_name = $(this).prop("name");
                cb_name = cb_name.substring(15);
                session_id_array.push(cb_name);
            });
            if (session_id_array.length == 0)
            {
                var message = "Please select atlest 1 session";
                print_common_message(message);
                return;
            }
            if ($(this).val() != '0') {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: "<?php echo base_url() . 'applications/gympro/update_sessions'; ?>",
                    data: {
                        session_id_array: session_id_array,
                        status_id: $("#mark_status_dropdown").val()
                    },
                    success: function (data) {
                        var message = data['message'];
                        print_common_message(message);
                        $('#mark_status_dropdown>option:eq(0)').prop('selected', true);
                        fetch_session_data();
                    }
                });
            }
        });
        $("#group_client, #fin_date, #st_date, #status_id").on('change', function () {
            fetch_session_data();
        });
        fetch_session_data();
        $("#datepicker").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>resources/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select date",
            dateFormat: 'dd-mm-yy'
        });
        $("#st_date").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>resources/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select start date",
            dateFormat: 'dd-mm-yy'
        });
        $("#fin_date").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>resources/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select end date",
            dateFormat: 'dd-mm-yy'
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_sessions_summery">
    {% var i=0, sessions_array = ((o instanceof Array) ? o[i++] : o); %}
    {% while(sessions_array){ %}

    <div class="row form-group">
    <div class="col-md-4" style="color: red; border-bottom: 2px solid darkred; padding: 0px 0px 5px 0px">
    {%=sessions_array['date']%}
    </div>
    </div>

    {% var sessions = sessions_array['sessions']; %}
    {% var j=0, session = ((sessions instanceof Array) ? sessions[j++] : sessions); %}
    {% while(session){ %}
    <div class="row form-group" style="border-bottom: 1px solid lightgray; padding-bottom: 10px">
    <div class="row">
    <div class="col-md-2">{%= session['start']%} - {%= session['end']%}</div>
    <div class="col-md-2">{%= session['created_for']%}</div>
    <div class="col-md-3">{%= session['title']%}</div>
    <div class="col-md-2">{%= session['cost']%}&nbsp;&nbsp;{%= session['currency_title']%}</div>
    <div class="col-md-2">{%= session['status_title']%}</div>
    <div class="col-md-1"><input name="session_select_<?php echo '{%= session["id"]%}'; ?>" type="checkbox"></div>
    </div>
    </div>
    {% session = ((sessions instanceof Array) ? sessions[j++] : sessions); %}
    {% } %}
    {% sessions_array = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<script type="text/x-tmpl" id="tmpl_earnings_summary">
    {% var total_unpaid_session_cost = 0; %}
    {% var total_paid_session_cost = 0; %}
    {% var total_cancelled_session_cost = 0; %}
    {% var unpaid_session_counter = 0; %}
    {% var paid_session_counter = 0; %}
    {% var cancelled_session_counter = 0; %}
    {% var i=0, sessions_array = ((o instanceof Array) ? o[i++] : o); %}
    {% while(sessions_array){ %}
    {% var sessions = sessions_array['sessions']; %}
    {% var j=0, session = ((sessions instanceof Array) ? sessions[j++] : sessions); %}
    {% while(session){ %}
    {% if( session['status_id']== <?php echo GYMPRO_SESSION_STATUS_UNPAID_ID; ?> ){ %}
    {% unpaid_session_counter++ ;%}
    {% total_unpaid_session_cost = total_unpaid_session_cost+ +session['cost'];%}
    {%}%}
    {% if( session['status_id']== <?php echo GYMPRO_SESSION_STATUS_PAY_CASH_ID; ?>|| session['status_id']== <?php echo GYMPRO_SESSION_STATUS_PAY_PT_PRO_ID; ?>){ %}
    {% paid_session_counter++ ;%}
    {% total_paid_session_cost = total_paid_session_cost+ +session['cost'];%}
    {%}%}
    {% if( session['status_id']== <?php echo GYMPRO_SESSION_STATUS_CANCELLED_ID; ?> ){ %}
    {% cancelled_session_counter++ ;%}
    {% total_cancelled_session_cost = total_cancelled_session_cost+ +session['cost'];%}
    {%}%}
    {% session = ((sessions instanceof Array) ? sessions[j++] : sessions); %}
    {% } %}
    {% sessions_array = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
    {%var total_session_cost = total_unpaid_session_cost+total_paid_session_cost+total_cancelled_session_cost ;%}
    {%var total_session_counter = unpaid_session_counter+paid_session_counter+cancelled_session_counter ;%}
    <div class="col-md-3" style="background-color: lightblue; padding: 10px 0px 10px 0px">
    <div style="font-size: 15px">
    Unpaid
    </div>
    <div style="font-size: 20px">
    {%= total_unpaid_session_cost %}
    </div>
    <div style="font-size: 12px">
    {%= unpaid_session_counter %} Session
    </div>
    </div>
    <div class="col-md-3" style="background-color: lightgreen; padding: 10px 0px 10px 0px" >
    <div style="font-size: 15px">
    Paid
    </div>
    <div style="font-size: 20px">
    {%= total_paid_session_cost %}
    </div>
    <div style="font-size: 12px">
    {%= paid_session_counter %} Session
    </div>
    </div>
    <div class="col-md-3" style="background-color: lightsalmon; padding: 10px 0px 10px 0px" >
    <div style="font-size: 15px">
    Cancelled
    </div>
    <div style="font-size: 20px">
    {%= total_cancelled_session_cost %}
    </div>
    <div style="font-size: 12px">
    {%= cancelled_session_counter %} session
    </div>
    </div>
    <div class="col-md-3" style="background-color: #ff9; padding: 10px 0px 10px 0px" >
    <div style="font-size: 15px">
    Total
    </div>
    <div style="font-size: 20px">
    {%= total_session_cost %}
    </div>
    <div style="font-size: 12px">
    {%= total_session_counter %} session
    </div>
    </div>
</script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
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
            <div class="row">
                <div class="row form-group">
                    <div class="col-md-6" style="font-size: 20px; color: maroon">
                        <span>Earnings Summary</span>
                    </div>
                </div>
                <div style="border-top: 2px solid lightgray; padding-bottom:10px;"></div>
                <div class="col-md-4">
                    <div class="row form-group">
                        <div class="col-md-4 content_text" style="padding-right: 0">Group and Client:</div>
                        <div class="col-md-7">
                            <select class="form-control" id="group_client">
                                <!--<option>-- Select --</option>-->
                                <optgroup label=""></optgroup>
                                <option value="<?php echo SESSION_CREATED_FOR_ALL_TYPE ;?>"><span>Select all</span></option>
                                <optgroup label="Groups">
                                    <?php foreach ($group_list as $group_info): ?>
                                        <option value="<?php echo SESSION_CREATED_FOR_GROUP_TYPE_ID ;?>_<?php echo $group_info['group_id']; ?>"><?php echo $group_info['title']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="Clients">
                                    <?php foreach ($client_list as $client_info): ?>
                                    <option value="<?php echo SESSION_CREATED_FOR_CLIENT_TYPE_ID ;?>_<?php echo $client_info['client_id']; ?>"><?php echo $client_info['first_name'] . ' ' . $client_info['last_name']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 content_text">Start:</div>
                        <div class="col-md-8">
                            <input id="st_date" style="margin-right: 5px;" value="<?php echo $start_date; ?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 content_text">Finish:</div>
                        <div class="col-md-8">
                            <input id="fin_date" style="margin-right: 5px;" value="<?php echo $end_date; ?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 content_text">Session:</div>
                        <div class="col-md-7">
                            <select class="form-control" id="status_id">
                                <option value="0">All</option>
                                <?php foreach ($status_list as $status): ?>
                                    <option value="<?php echo $status['id']; ?>"><?php echo $status['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>                        
                </div>
                <div class="col-md-8">
                    <div class="row form-group" style="text-align: center">
                        <div id="earnings_summary">
                        </div>
                    </div>
                    <div class="row form-group" style="border-bottom: 1px solid lightgray; padding-bottom: 10px">
                        <div class="col-md-9" style="font-size: 15px; font-weight: bold; padding-left: 0px">
                            Schedule Session
                        </div>
                        <div class="col-md-3" style="padding-right: 0px">
                            <select class="form-control" id="mark_status_dropdown">
                                <option value="0">Mark as</option>
                                <?php foreach ($status_list as $status): ?>
                                    <option value="<?php echo $status['id']; ?>"><?php echo $status['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="sessions_tmpl_place"></div>
                </div>
            </div>
        </div>
        <div class="row form-group"></div>
        <div class="row form-group"></div>
        <div class="row form-group"></div>
        <div class="row form-group"></div>
        <div class="row form-group"></div>
        <div class="row form-group"></div>
    </div>
</div>