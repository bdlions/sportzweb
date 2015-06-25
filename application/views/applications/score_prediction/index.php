<script type="text/javascript">
    var today_ymd_str;
    function bring_tournament_info() {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/score_prediction/get_team_standings",
            data: {
                tournament_id: $("#dd_tournaments").val()
            },
            success: function (data) {
                $('#pred_table_title').html($("#dd_tournaments option:selected").text());
                $('#tbl_team_standings').html(tmpl('tmpl_table_header'));
                $('#tbl_team_standings').append(tmpl('tmpl_team_standings', data.team_standings));
                //bring_prediction_info();
            }
        });
    }
    function bring_prediction_info() {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/score_prediction/get_predictions_for_month",
            data: {
                tournament_id: $("#dd_tournaments").val(),
                current_month: $('#current_month').val(),
                next_month: $('#next_month').val()
            },
            success: function (data) {
                $('#tbl_predictions').html(tmpl('tmpl_predictions', data));
//                console.log(data);
            }
        });
    }

    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    function month_incrim() {
        var in_date = $('#current_month').val();
        var date = new Date(in_date);
        var dd = date.getDate();
        var mm = date.getMonth();
        var yyyy = date.getFullYear();
        mm++;//increment
        if (mm > 11) {
            mm = 0;
            yyyy++
        }
        $('#current_month_heading').html(monthNames[mm] + ", " + yyyy);
        mm++;//inc for date
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var out_date = yyyy + '-' + mm + '-' + dd;
        $('#current_month').val(out_date);
        mm++;//inc for next month
        if (mm > 12) {
            mm = 1;
            yyyy++;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var out_date = yyyy + '-' + mm + '-' + dd;
        $('#next_month').val(out_date);
        bring_prediction_info();
    }
    function month_decrim() {
        var in_date = $('#current_month').val();
        var out_date;
        var date = new Date(in_date);
        var dd = date.getDate();
        var mm = date.getMonth();
        var yyyy = date.getFullYear();
        mm--;
        if (mm < 0) {
            mm = 11;
            yyyy--
        }
        $('#current_month_heading').html(monthNames[mm] + ", " + yyyy);
        mm++;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var out_date = yyyy + '-' + mm + '-' + dd;
        $('#current_month').val(out_date);
        mm++;//inc for next month
        if (mm > 12) {
            mm = 1;
            yyyy++;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var out_date = yyyy + '-' + mm + '-' + dd;
        $('#next_month').val(out_date);
        bring_prediction_info();
    }
    function date_manage() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        $('#current_month_heading').html(monthNames[mm - 1] + ", " + yyyy);
        dd = 1;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        today_ymd_str = yyyy + '-' + mm + '-' + dd;
        $('#current_month').val(today_ymd_str);
        mm++;//inc for next month
        if (mm > 12) {
            mm = 1;
            yyyy++;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
//        today_ymd_str = yyyy+'-'+mm+'-'+dd;
        $('#next_month').val(yyyy + '-' + mm + '-' + dd);
    }

    function confirmation_vote(match_id, match_status_id) {
        $("#match_id").val(match_id);
        $("#match_status_id").val(match_status_id);
        $("#confirmModal").modal("show");
    }
    function post_vote() {
        var match_id = $("#match_id").val();
        var match_status_id = $("#match_status_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>' + "applications/score_prediction/post_vote",
            dataType: 'json',
            data: {
                match_id: match_id,
                match_status_id: match_status_id
            },
            success: function (data) {
                //alert(data.message);
                var message = data.message;
                print_common_message(message);
                location.reload();
            }
        });
    }
    function pred_pressed(pred_butn) {
        var match_id = ($(pred_butn).data('match_id'));
        $(pred_butn).parent().parent().siblings('tr[id=prediction_' + match_id + ']').toggle("fade", {}, 600);
    }
    function result_pred_pressed(pred_butn) {
        $(pred_butn).parent().parent().next().next().toggle("fade", {}, 600);
//        $(pred_butn).parent().parent().siblings('tr[class=result_prediction]').toggle("fade", {}, 600);
    }
    $(function () {
        date_manage();
        bring_tournament_info();
        bring_prediction_info();
        $("#dd_tournaments").change(function () {
            bring_tournament_info();
            bring_prediction_info();
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_predictions">
    {% for(var date in o){
    var date_group = o[date];
    %}
    <tr style="background-color: #EAEAEA">
    <th class="title" colspan="4">
    {% 
    var ddate = new Date(date),
    yr = ddate.getFullYear(),
    month = +ddate.getMonth() < 10? '0' + ddate.getMonth() : ddate.getMonth() ,
    day = +ddate.getDate() < 10? '0' + ddate.getDate() : ddate.getDate(),
    newDate = day + ' ' + monthNames[month-0] + ', ' + yr;
    %}{%=newDate%}
    </th>
    </tr>
    {%  for(var index in date_group){  
    var prediction = date_group[index];
    %}
    <tr>
    <td style="text-align: right">{%= prediction['team_title_home']%}</td>
    <td style="text-align: center"> {%= prediction['time']%}</td>
    <td style="text-align: left">{%= prediction['team_title_away']%}</td>
    <td>
    {%
    var mch_date = Date.parse(prediction['date']),
    tdy_date = Date.parse(new Date()),
    match_over = (mch_date>=tdy_date) ? 0: 1,
    mch_time = prediction['time'],
    now_time = new Date().getHours() + ":" + new Date().getMinutes(),match_over;
    if(mch_date>tdy_date){match_over=0}
    else if(mch_date<tdy_date){match_over=1}
    else if(mch_date==tdy_date){if(mch_time > now_time){match_over=0}else{match_over=1}}
    //                    match_over = 0;
    %}
    {% if ( (prediction['can_predict'] == 1) && (match_over==0) ){ %}
    {%=mch_date %} {%="T"+tdy_date %} {%=mch_time %} {%=now_time %}<a data-match_id="{%= prediction['match_id']%}" class="prediction_button" onclick="pred_pressed(this)" style="float: right">Predict<!--<img src="<?php echo base_url(); ?>resources/images/predict_button.png">--></a>
    {% } else { %}
    {%=mch_date %} {%="t"+tdy_date %} {%=mch_time %} {%=now_time %}<a class="prediction_button" onclick="result_pred_pressed(this)" style="float: right"><img src="<?php echo base_url(); ?>resources/images/predict_result_button.png"></a>
    {% } %}
    </td>
    </tr>
    <tr style="display: none" id="prediction_{%= prediction['match_id']%}">
    <td colspan="4">
    <div class="col-md-4">
    <div class="title">{%= prediction['team_title_home']%}</div>
    <div onclick="confirmation_vote({%= prediction['match_id']%}, <?php echo MATCH_STATUS_WIN_HOME ?>)" style="height: 100px; border: 1px solid blue; margin: 20px; background-color: #75B3E6">
    <div style="background-color: white; height: {%= ((1 - prediction['win_home_chance'])*100).toFixed(1) %}%">
    <div class="title" style="padding-top: 25%">{%= ((prediction['win_home_chance'])*100).toFixed(2)  %} %</div>
    </div>
    </div>
    <input type="hidden" id=""value="">
    </div>
    <div class="col-md-4">
    <div class="title">Draw</div>
    <div onclick="confirmation_vote({%= prediction['match_id']%}, <?php echo MATCH_STATUS_DRAW ?>)" style="height: 100px; border: 1px solid blue; margin: 20px; background-color: #75B3E6">
    <div style="background-color: white; height: {%= ((1 - prediction['draw_game_chance'])*100).toFixed(1) %}%">
    <div class="title" style="padding-top: 25%">{%= ((prediction['draw_game_chance'])*100).toFixed(2)  %}%</div>
    </div>
    </div>
    <input type="hidden" id=""value="">
    </div>
    <div class="col-md-4">
    <div class="title">{%= prediction['team_title_away']%}</div>
    <div onclick="confirmation_vote({%= prediction['match_id']%}, <?php echo MATCH_STATUS_WIN_AWAY ?>)" style="height: 100px; border: 1px solid blue; margin: 20px; background-color: #75B3E6">
    <div style="background-color: white; height: {%= ((1 - prediction['win_away_chance'])*100).toFixed(1) %}%">
    <div class="title" style="padding-top: 25%">{%= ((prediction['win_away_chance'])*100).toFixed(2)  %}%</div>
    </div>
    </div>
    <input type="hidden" id=""value="">
    </div>
    </td>
    </tr>

    <!--RESULT SHOW-->
    <tr style="display: none" class="result_prediction">
    <td colspan="4">
    <div class="col-md-4">
    <div class="title">{%= prediction['team_title_home']%}</div>
    <div style="height: 100px; border: 1px solid blue; margin: 20px; background-color: #75B3E6">
    <div style="background-color: white; height: {%= ((1-prediction['win_home_chance'])*100).toFixed(1) %}%">
    <div class="title" style="padding-top: 25%">{%= ((prediction['win_home_chance'])*100).toFixed(2) %} %</div>
    </div>
    </div>
    <input type="hidden" id=""value="">
    </div>
    <div class="col-md-4">
    <div class="title">Draw</div>
    <div style="height: 100px; border: 1px solid blue; margin: 20px; background-color: #75B3E6">
    <div style="background-color: white; height: {%= ((1-prediction['draw_game_chance'])*100).toFixed(1) %}%">
    <div class="title" style="padding-top: 25%">{%= ((prediction['draw_game_chance'])*100).toFixed(2) %}%</div>
    </div>
    </div>
    <input type="hidden" id=""value="">
    </div>
    <div class="col-md-4">
    <div class="title">{%= prediction['team_title_away']%}</div>
    <div style="height: 100px; border: 1px solid blue; margin: 20px; background-color: #75B3E6">
    <div style="background-color: white; height: {%= ((1-prediction['win_away_chance'])*100).toFixed(1) %}%">
    <div class="title" style="padding-top: 25%">{%= ((prediction['win_away_chance'])*100).toFixed(2) %}%</div>
    </div>
    </div>
    <input type="hidden" id=""value="">
    </div>
    </td>
    </tr>

    {%
    }
    }
    %}

</script>
<script type="text/x-tmpl" id="tmpl_table_header">
    <tr style="font-size: 15px; color: whitesmoke; background-color: #000">
    <th>POS</th>
    <th>Team </th>
    <th>P</th>
    <th>GD</th>
    <th>Pts</th>
    </tr>
</script>
<script type="text/x-tmpl" id="tmpl_team_standings">
    {% var i=0, team = ((o instanceof Array) ? o[i++] : o); %}
    {% while(team){ %}
    <tr style="background-color: whitesmoke">
    <td> {%= i%} </td>
    <td> {%= team['team_name']%} </td>
    <td> {%= team['played']%} </td>
    <td> {%= team['gd']%} </td>
    <td> {%= team['point']%} </td>
    </tr>
    {% team = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<script>
    $(function () {
        $('#predicted_id_01').on('click', function () {
            $('#predicted_football_game_01').toggle();
        });
        $('#predict_id_01').on('click', function () {
            $('#predict_football_game_01').toggle();
        });
        $('#predict_football_game_01_team_a_win').on('click', function () {
            $('#team_name').html("Arsenal");
            $('#confirmModal').modal('show');
            $('#vote_id').on('click', function () {
                $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_team_a").removeClass("team_a_previous_width_on_click_team_a");
                $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_draw").removeClass("team_a_previous_width_on_click_draw");
                $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_team_b").removeClass("team_a_previous_width_on_click_team_b");
                $("#predict_football_game_01_team_a_win").find(".progress_bar_width_catulate").addClass("team_a_present_width_on_click_team_a");
                $("#predict_football_game_01_team_a_win").find(".progress_bar_percentage_text").text('60%');
                
                $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_team_a").removeClass("draw_previous_width_on_click_team_a");
                $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_draw").removeClass("draw_previous_width_on_click_draw");
                $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_team_b").removeClass("draw_previous_width_on_click_team_b");
                $("#predict_football_game_01_draw").find(".progress_bar_width_catulate").addClass("draw_present_width_on_click_team_a");
                $("#predict_football_game_01_draw").find(".progress_bar_percentage_text").text('25%');
                
                $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_team_a").removeClass("team_b_previous_width_on_click_team_a");
                $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_draw").removeClass("team_b_previous_width_on_click_draw");
                $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_team_b").removeClass("team_b_previous_width_on_click_team_b");
                $("#predict_football_game_01_team_b_win").find(".progress_bar_width_catulate").addClass("team_b_present_width_on_click_team_a");
                $("#predict_football_game_01_team_b_win").find(".progress_bar_percentage_text").text('15%');
               
                $('#confirmModal').modal('hide');
                $("#predict_football_game_01_team_a_win").off('click');
                $("#predict_football_game_01_draw").off('click');
                $("#predict_football_game_01_team_b_win").off('click');
            });
            $('#vote_ignore_id').on('click', function () {
                $('#confirmModal').modal('hide');
            });
        });
        $('#predict_football_game_01_draw').on('click', function () {
            $('#team_name').html("Draw");
            $('#confirmModal').modal('show');
            $('#vote_id').on('click', function () {
               $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_team_a").removeClass("team_a_previous_width_on_click_team_a");
                $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_draw").removeClass("team_a_previous_width_on_click_draw");
                $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_team_b").removeClass("team_a_previous_width_on_click_team_b");
                $("#predict_football_game_01_team_a_win").find(".progress_bar_width_catulate").addClass("team_a_present_width_on_click_draw");
                $("#predict_football_game_01_team_a_win").find(".progress_bar_percentage_text").text('45%');
                
                $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_team_a").removeClass("draw_previous_width_on_click_team_a");
                $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_draw").removeClass("draw_previous_width_on_click_draw");
                $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_team_b").removeClass("draw_previous_width_on_click_team_b");
                $("#predict_football_game_01_draw").find(".progress_bar_width_catulate").addClass("draw_present_width_on_click_draw");
                $("#predict_football_game_01_draw").find(".progress_bar_percentage_text").text('40%');
                
                $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_team_a").removeClass("team_b_previous_width_on_click_team_a");
                $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_draw").removeClass("team_b_previous_width_on_click_draw");
                $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_team_b").removeClass("team_b_previous_width_on_click_team_b");
                $("#predict_football_game_01_team_b_win").find(".progress_bar_width_catulate").addClass("team_b_present_width_on_click_draw");
                $("#predict_football_game_01_team_b_win").find(".progress_bar_percentage_text").text('15%');
                
                $('#confirmModal').modal('hide');
               $("#predict_football_game_01_team_a_win").off('click');
                $("#predict_football_game_01_draw").off('click');
                $("#predict_football_game_01_team_b_win").off('click');
            });
            $('#vote_ignore_id').on('click', function () {
                $('#confirmModal').modal('hide');
            });
        });
        $('#predict_football_game_01_team_b_win').on('click', function () {
            $('#team_name').html("Swansea");
            $('#confirmModal').modal('show');
            $('#vote_id').on('click', function () {
                $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_team_a").removeClass("team_a_previous_width_on_click_team_a");
                $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_draw").removeClass("team_a_previous_width_on_click_draw");
                $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_team_b").removeClass("team_a_previous_width_on_click_team_b");
                $("#predict_football_game_01_team_a_win").find(".progress_bar_width_catulate").addClass("team_a_present_width_on_click_team_b");
                $("#predict_football_game_01_team_a_win").find(".progress_bar_percentage_text").text('45%');
                
                $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_team_a").removeClass("draw_previous_width_on_click_team_a");
                $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_draw").removeClass("draw_previous_width_on_click_draw");
                $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_team_b").removeClass("draw_previous_width_on_click_team_b");
                $("#predict_football_game_01_draw").find(".progress_bar_width_catulate").addClass("draw_present_width_on_click_team_b");
                $("#predict_football_game_01_draw").find(".progress_bar_percentage_text").text('25%');
                
                $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_team_a").removeClass("team_b_previous_width_on_click_team_a");
                $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_draw").removeClass("team_b_previous_width_on_click_draw");
                $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_team_b").removeClass("team_b_previous_width_on_click_team_b");
                $("#predict_football_game_01_team_b_win").find(".progress_bar_width_catulate").addClass("team_b_present_width_on_click_team_b");
                $("#predict_football_game_01_team_b_win").find(".progress_bar_percentage_text").text('30%');
                $('#confirmModal').modal('hide');
               $("#predict_football_game_01_team_a_win").off('click');
                $("#predict_football_game_01_draw").off('click');
                $("#predict_football_game_01_team_b_win").off('click');
            });
            $('#vote_ignore_id').on('click', function () {
                $('#confirmModal').modal('hide');
            });
        });
    });
</script>
<script>
    $(function () {
        $("#datepicker").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>resources/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select a date"
        });
    });
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />


<div class="container-fluid">
    <div class="row">
        <h1>Fixtures & Results</h1>
        <?php $this->load->view("applications/score_prediction/templates/header_menu"); ?>
        <div class="col-md-7 col-sm-7 col-xs-12 form-group">
            <div class="form-group">
                <ul class="datePicker_data_list">
                    <li><a>Thu 18 Jun</a></li>
                    <li><a>Fri 19 Jun</a></li>
                    <li class="active_item"><a>Today</a></li>
                    <li><a>Sun 21 Jun</a></li>
                    <li><a>Mon 21 Jun</a></li>
                    <li style="background-color: #fff;"><input type="text" id="datepicker" class="hidden"></li>
                </ul>
            </div>
            <div class="form-group">
                <a data-toggle="collapse" href="#collapse_sports_id_01" aria-expanded="false" >
                    <div class="row" style="padding: 0px; font-size: 20px;">
                        <div class="col-md-12">
                            <div class="heading blue_banner padding_collapse_header custom_heading text_align_left">
                                Football
                            </div>
                        </div>
                    </div>
                </a>
                <div class="form-group collapse" id="collapse_sports_id_01">
                    <div class="well">
                        <div class="form-group heading blue_banner custom_heading tournament_background_color text_align_left">
                            <span >Barclays premier league 2014/15</span>
                        </div>

                        <div class="form-group">
                            <table class="table">
                                <div class="row form-group table-hover text_align">
                                    <div class="col-md-2">
                                        Time
                                    </div>
                                    <div class="col-md-2">
                                        Team A
                                    </div>
                                    <div class="col-md-2">
                                        vs
                                    </div>
                                    <div class="col-md-2">
                                        Team B
                                    </div>
                                    <div class="col-md-2">
                                        Match Result
                                    </div>
                                    <div class="col-md-2">
                                        Match Status
                                    </div>
                                </div>
                                <div class="row form-group text_align ">
                                    <div class="col-md-2">
                                        13:00
                                    </div>
                                    <div class="col-md-2">
                                        Chelsea
                                    </div>
                                    <div class="col-md-2">
                                        vs
                                    </div>
                                    <div class="col-md-2">
                                        Arsenal
                                    </div>
                                    <div class="col-md-2">
                                        2 - 0
                                    </div>
                                    <div class="col-md-2">
                                        <a>Closed</a>
                                    </div>
                                </div>
                                <div class="row form-group text_align ">
                                    <div class="col-md-2">
                                        14:00
                                    </div>
                                    <div class="col-md-2">
                                        Tottenham
                                    </div>
                                    <div class="col-md-2">
                                        vs
                                    </div>
                                    <div class="col-md-2">
                                        Chelsea
                                    </div>
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-2">
                                        <a id="predicted_id_01" >Predicted</a>
                                    </div>
                                </div>
                                <div id="predicted_football_game_01" style="display: none;">
                                <div class="row form-group" >
                                    <div class="col-md-12">
                                        <div class="progress_bar_backgraound">
                                            <span class="progress_bar_percentage_text">20%</span>
                                            <div class="progress_bar_width_catulate" style="width: 20%;">
                                                <span class="progress_bar_content">Tottenham</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group" >
                                    <div class="col-md-12">
                                        <div class="progress_bar_backgraound">
                                            <span class="progress_bar_percentage_text">0%</span>
                                            <div class="progress_bar_width_catulate" style="width:0%;">
                                                <span class="progress_bar_content">Draw</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group" >
                                    <div class="col-md-12">
                                        <div class="progress_bar_backgraound">
                                            <span class="progress_bar_percentage_text">80%</span>
                                            <div class="progress_bar_width_catulate" style="width: 80%;">
                                                <span class="progress_bar_content">Chelsea</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>

                                <div class="row form-group text_align ">
                                    <div class="col-md-2">
                                        15:00
                                    </div>
                                    <div class="col-md-2">
                                        Arsenal
                                    </div>
                                    <div class="col-md-2">
                                        vs
                                    </div>
                                    <div class="col-md-2">
                                        Swansea
                                    </div>
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-2">
                                        <a id="predict_id_01">Predict</a>
                                    </div>
                                </div>
                                <div id="predict_football_game_01" style="display: none;">
                                    <div id="predict_football_game_01_team_a_win" class="row form-group" >
                                    <div class="col-md-12">
                                        <div class="progress_bar_backgraound">
                                            <span class="progress_bar_percentage_text">50%</span>
                                            <div class="progress_bar_width_catulate team_a_previous_width_on_click_team_a team_a_previous_width_on_click_draw team_a_previous_width_on_click_team_b" >
                                                <span class="progress_bar_content">Arsenal</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div id="predict_football_game_01_draw" class="row form-group" >
                                    <div class="col-md-12">
                                        <div class="progress_bar_backgraound">
                                            <span class="progress_bar_percentage_text">30%</span>
                                            <div class="progress_bar_width_catulate draw_previous_width_on_click_team_a draw_previous_width_on_click_draw draw_previous_width_on_click_team_b" >
                                                <span class="progress_bar_content">Draw</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div id="predict_football_game_01_team_b_win" class="row form-group" >
                                    <div class="col-md-12">
                                        <div class="progress_bar_backgraound">
                                            <span class="progress_bar_percentage_text">20%</span>
                                            <div class="progress_bar_width_catulate team_b_previous_width_on_click_team_a team_b_previous_width_on_click_draw team_b_previous_width_on_click_team_b">
                                                <span class="progress_bar_content">Swansea</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </table>
                        </div>
                    </div>
                    <div class="form-group padding_over_row_10px"></div>
                    <div class="well">
                        <div class="form-group heading blue_banner custom_heading tournament_background_color text_align_left">
                            <span >Championship 2014/15</span>
                        </div>
                        <div class="form-group">
                            <table class="table">
                                <div class="row form-group table-hover text_align">
                                    <div class="col-md-2">
                                        Time
                                    </div>
                                    <div class="col-md-2">
                                        Team A
                                    </div>
                                    <div class="col-md-2">
                                        vs
                                    </div>
                                    <div class="col-md-2">
                                        Team B
                                    </div>
                                    <div class="col-md-2">
                                        Match Result
                                    </div>
                                    <div class="col-md-2">
                                        Match Status
                                    </div>
                                </div>
                                <div class="row form-group text_align ">
                                    <div class="col-md-2">
                                        16:00
                                    </div>
                                    <div class="col-md-2">
                                        Hull
                                    </div>
                                    <div class="col-md-2">
                                        vs
                                    </div>
                                    <div class="col-md-2">
                                        Aston Villa
                                    </div>
                                    <div class="col-md-2">
                                        2 - 3
                                    </div>
                                    <div class="col-md-2">
                                        <a>Closed</a>
                                    </div>
                                </div>
                                <div class="row form-group text_align ">
                                    <div class="col-md-2">
                                        17:00
                                    </div>
                                    <div class="col-md-2">
                                        Aston Villa
                                    </div>
                                    <div class="col-md-2">
                                        vs
                                    </div>
                                    <div class="col-md-2">
                                        Man City
                                    </div>
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-2">
                                        <a id="" >Predicted</a>
                                    </div>
                                </div>

                                <div class="row form-group text_align ">
                                    <div class="col-md-2">
                                        18:00
                                    </div>
                                    <div class="col-md-2">
                                        Man City
                                    </div>
                                    <div class="col-md-2">
                                        vs
                                    </div>
                                    <div class="col-md-2">
                                        Hull
                                    </div>
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-2">
                                        <a id="">Predict</a>
                                    </div>
                                </div>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <a data-toggle="collapse" href="#collapse_sports_id_07" aria-expanded="false" >
                        <div class="row" style="padding: 0px; font-size: 20px;">
                            <div class="col-md-12">
                                <div class="heading blue_banner padding_collapse_header custom_heading text_align_left">
                                    Cricket
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="collapse" id="collapse_sports_id_07">
                        <div class="well">
                            <div class="form-group heading blue_banner custom_heading tournament_background_color text_align_left">
                                <span >Bangladesh vs India Series 2015</span>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover text_align_left">
                                        <tr>
                                            <td>Time</td>
                                            <td>Team A</td>
                                            <td>vs</td>
                                            <td>Team B</td>
                                            <td>Match Result</td>
                                            <td>Match Status</td>
                                        </tr>
                                        <tr>
                                            <td>09:30</td>
                                            <td>Bangladesh</td>
                                            <td>vs</td>
                                            <td>India</td>
                                            <td>Drawn</td>
                                            <td><a>Closed</a></td>
                                        </tr>
                                        <tr>
                                            <td>15:00</td>
                                            <td>Bangladesh</td>
                                            <td>vs</td>
                                            <td>India</td>
                                            <td></td>
                                            <td><a>Predict</a></td>
                                        </tr>
                                        <tr>
                                            <td>10:00</td>
                                            <td>Bangladesh</td>
                                            <td>vs</td>
                                            <td>India </td>
                                            <td></td>
                                            <td><a>Predicted</a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12 form-group pull-right">
            <?php $this->load->view("applications/score_prediction/leader_board"); ?>
        </div>
    </div>
</div>
<?php $this->load->view("applications/score_prediction/prediction_confirmation_modal"); ?>

<div class="row form-group"></div>
<div class="row form-group"></div>
<div class="row form-group"></div>
<div class="row form-group"></div>


