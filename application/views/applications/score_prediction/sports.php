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
                alert(data.message);
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
    month = +ddate.getMonth() < 10 ? '0' + ddate.getMonth() : ddate.getMonth() ,
    day = +ddate.getDate() < 10 ? '0' + ddate.getDate() : ddate.getDate(),
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
    match_over = (mch_date>=tdy_date) ? 0 : 1,
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
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<style>
    .blue_banner{
        color: white;
        background-color:#3F48CC;
    }
    .title{
        font-size: 20px;
        text-align: center;
    }
    .heading{
        padding: 15px;
        font-size: 25px;
        text-align: center;
    }
    .lr_image{
        height: 18px;
        padding: 4px 0px 0px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <h1>Fixtures & Results</h1>
        <?php $this->load->view("applications/score_prediction/templates/header_menu"); ?>
        <div class="col-md-7 pull-left">
            <!--            <div class="col-md-12 well">
                            <div class="form-group heading blue_banner custom_heading">
                                <span id="pred_table_title"></span>
                            </div>
                            <div style="height: 50px">
                                <input onclick="month_decrim()" class="lr_image" type="image" src="<?php echo base_url(); ?>resources/images/caret_l20.png">
                                <span class="heading custom_heading" id="current_month_heading"></span><input type="hidden" id="current_month"><input type="hidden" id="next_month">
                                <input onclick="month_incrim()" class="lr_image" type="image" src="<?php echo base_url(); ?>resources/images/caret_r20.png">
                            </div>
                            <div>
                                <table class="table-responsive table ">
                                    <tbody id="tbl_predictions">
                                    </tbody>
                                </table>
                            </div>
                        </div>-->


            <div class="form-group">
                <div class="">
                    <!--                    <a data-toggle="collapse" href="#collapse_sports_id_01" aria-expanded="false" >
                                            <div class="row" style="padding: 0px; font-size: 20px;">
                                                <div class="col-md-12">
                                                    <div class="heading blue_banner padding_collapse_header custom_heading">
                                                        Football
                                                    </div>
                                                </div>
                                            </div>
                                        </a>-->
                    <div class="form-group " id="">
                        <div class="well">
                            <div class="form-group heading blue_banner custom_heading tournament_background_color text_align_left">
                                <span >Barclays premier league 2014/15</span>
                            </div>
                            <div style="height: 50px">
<!--                                <input onclick="month_decrim()" class="lr_image" type="image" src="<?php echo base_url(); ?>resources/images/caret_l20.png">
                                <span class="heading custom_heading" id="current_month_heading"></span><input type="hidden" id="current_month"><input type="hidden" id="next_month">
                                <input onclick="month_incrim()" class="lr_image" type="image" src="<?php echo base_url(); ?>resources/images/caret_r20.png">-->
                                <input  class="lr_image" type="image" src="<?php echo base_url(); ?>resources/images/caret_l20.png">
                                <span class="custom_heading">June, 2015</span>
                                <input  class="lr_image" type="image" src="<?php echo base_url(); ?>resources/images/caret_r20.png">
                            </div>
                            <div>
<!--                                <table class="table-responsive table ">
                                    <tbody id="tbl_predictions">
                                    </tbody>
                                </table>-->
                            </div>
                        </div>


                        <div>
                            <div>
                                <div class="form-group">
                                    <div class="">
                                        <table class="table">
                                            <div class="row form-group table-hover text_align row_non_hover">
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
                                            <div class="row form-group text_align row_hover">
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
                                            <div class="row form-group text_align row_hover">
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
                                                    <a id="Predicted_id_01" >Predicted</a>
                                                </div>
                                            </div>
                                            <div id="predicted_row_title_01" class="row form-group text_align title_row_hidden" style="display: none;">
                                                <div class="col-md-4">
                                                    Tottenham
                                                </div>
                                                <div class="col-md-4">
                                                    Draw
                                                </div>
                                                <div class="col-md-4">
                                                    Chelsea
                                                </div>
                                            </div>
                                            <div id="predicted_row_box_01" class="row form-group text_align" style="display: none;">
                                                <div class="col-md-4">
                                                    <div class="prediction_box">
                                                        <div class="prediction_box_content">0.00 %</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="prediction_box">
                                                        <div class="prediction_box_content">0.00 %</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="prediction_box predited_color">
                                                        <div class="prediction_box_content">100.00 %</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row form-group text_align row_hover">
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
                                                    <a id="Predict_id_01">Predict</a>
                                                </div>
                                            </div>
                                            <div id="to_predict_row_title_01" class="row form-group text_align title_row_hidden" style="display: none;">
                                                <div class="col-md-4">
                                                    Arsenal
                                                </div>
                                                <div class="col-md-4">
                                                    Draw
                                                </div>
                                                <div class="col-md-4">
                                                    Swansea
                                                </div>
                                            </div>
                                            <div id="to_predict_row_box_01" class="row form-group text_align" style="display: none;">
                                                <div id="to_predict_row_box_01_col_01" class="col-md-4">
                                                    <div class="prediction_box to_predict_box">
                                                        <div class="prediction_box_content">0.00 %</div>
                                                    </div>
                                                </div>
                                                <div id="to_predict_row_box_01_col_02" class="col-md-4">
                                                    <div class="prediction_box to_predict_box">
                                                        <div class="prediction_box_content">0.00 %</div>
                                                    </div>
                                                </div>
                                                <div id="to_predict_row_box_01_col_03" class="col-md-4">
                                                    <div class="prediction_box to_predict_box">
                                                        <div class="prediction_box_content">0.00 %</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group padding_over_row_10px"></div>
                        <div class="well">
                            <div class="form-group heading blue_banner custom_heading tournament_background_color text_align_left">
                                <span >Championship 2014/15</span>
                            </div>
                            <div style="height: 50px">
<!--                                <input onclick="month_decrim()" class="lr_image" type="image" src="<?php echo base_url(); ?>resources/images/caret_l20.png">
                                <span class="heading custom_heading" id="current_month_heading"></span><input type="hidden" id="current_month"><input type="hidden" id="next_month">
                                <input onclick="month_incrim()" class="lr_image" type="image" src="<?php echo base_url(); ?>resources/images/caret_r20.png">-->
                                <input  class="lr_image" type="image" src="<?php echo base_url(); ?>resources/images/caret_l20.png">
                                <span class="custom_heading">June, 2015</span>
                                <input  class="lr_image" type="image" src="<?php echo base_url(); ?>resources/images/caret_r20.png">
                            </div>
                            <div>
<!--                                <table class="table-responsive table ">
                                    <tbody id="tbl_predictions">
                                    </tbody>
                                </table>-->
                            </div>
                        </div>
                        <div>
                            <div>
                                <div class="form-group">
                                    <div class="">
                                        <table class="table">
                                            <div class="row form-group table-hover text_align row_non_hover">
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
                                            <div class="row form-group text_align row_hover">
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
                                            <div class="row form-group text_align row_hover">
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

                                            <div class="row form-group text_align row_hover">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 pull-right">
            <?php $this->load->view("applications/score_prediction/league_table"); ?>

        </div>
    </div>
</div>

<div class="row form-group"></div>
<div class="row form-group"></div>
<div class="row form-group"></div>
<div class="row form-group"></div>

