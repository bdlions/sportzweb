<script type="text/javascript">
    $(function () {
        sports_id = '<?php echo $sports_id ?>';
        date = '<?php echo $date ?>';
        match_id = '<?php echo $match_id ?>';
        tournament_id = '<?php echo $tournament_id ?>';
        date_array = date.split("-");
        
        //var thisYear = new Date().getFullYear();
        //setDate(new Date());
        var thisYear = date_array[0];
        setDate( new Date(date_array[0], date_array[1] - 1, date_array[2]) );
        $("#from, #to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onSelect: function (selectedDate) {
                if (this.id == 'from') {
                    var dateMin = $('#from').datepicker("getDate");
                    thisYear = dateMin.getFullYear();
                    setDate(dateMin);
                }
            }
        });
        $(".input_custom_input").on("click", function () {
            var selectedDate = $(this).text();
            if (selectedDate == "Today") {
                selectedDate = $.datepicker.formatDate('D d M', new Date());
            }
            var dateParts = selectedDate.split(" ");
            var day = dateParts[ 1 ];
            var month = dateParts[ 2 ];
            selectedDate = new Date(month + " " + day + ", " + thisYear);
            setDate(selectedDate);
        });
        //get_match_list(date, sports_id, match_id);
    });
    function setDate(selectedDate) {
        var dateMin = selectedDate;
        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        for (var i = -2; i <= 2; i++) {
            var date = new Date(dateMin.getFullYear(), dateMin.getMonth(), dateMin.getDate() + i);
            var formatDate = $.datepicker.formatDate('D d M', new Date(date));

            if (today.getTime() === date.getTime()) {
                //when date is today
                formatDate = "Today";
            }

            var index = "#rMin" + (i + 3);
            $(index).html(formatDate);
        }
        var formattedMonth = '' + (selectedDate.getMonth() + 1);
        var formattedDay = '' + selectedDate.getDate();
        var formattedYear = selectedDate.getFullYear();
        if (formattedMonth.length < 2)
            formattedMonth = '0' + formattedMonth;
        if (formattedDay.length < 2)
            formattedDay = '0' + formattedDay;
        var formattedDate = formattedYear + '-' + formattedMonth + '-' + formattedDay;
        get_match_list(formattedDate, sports_id, match_id);
    }

    function get_match_list(date, sports_id, match_id)
    {
        //retrieving matches of all types of sports
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "<?php echo base_url() . 'applications/score_prediction/get_match_list'; ?>",
            data: {
                date: date,
                sports_id: sports_id,
                match_id: match_id
            },
            success: function (data) {
                if(data.sports_list.length > 0 && sports_id > 0 && tournament_id > 0)
                {
                    var tounament_list = data.sports_list[0].tournament_list;
                    if(tounament_list.length > 0)
                    {
                        var selected_tournament_id = tounament_list[0].tournament_id;
                        $('#tournament_list').val(selected_tournament_id);
                        populate_league_table(selected_tournament_id);
                    }                    
                }
                else if(sports_id > 0 && tournament_id > 0)
                {
                    $('#tournament_list').val(tournament_id);
                    populate_league_table(tournament_id);
                }
                $('#home_page_sports_content').html(tmpl('tlmp_home_page_sports_content', data.sports_list));
            }
        });
    }
</script>

<script type="text/x-tmpl" id="tlmp_home_page_sports_content">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    {% var sports_counter = 0, sports_list = ((o instanceof Array) ? o[sports_counter++] : o); %}
    {% while(sports_list){ %}
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading{%= sports_list.sports_id%}">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_sports_event{%= sports_list.sports_id%}" aria-expanded="false" aria-controls="collapse{%= sports_list.sports_id%}">
                <div class="row" style="padding: 0px; font-size: 20px;">
                    <div class="col-md-12">
                        <div class="heading blue_banner padding_collapse_header custom_heading text_align_left">
                            {%= sports_list.title%} 
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div id="collapse_sports_event{%= sports_list.sports_id%}" class="panel-collapse collapse {%= sports_counter === 1 ? 'in':'' %}" role="tabpanel" aria-labelledby="heading{%= sports_list.sports_id%}">

            {% var count = sports_list.tournament_list.length; %}
            {% for(var j=0; j<count; j++){ %}                
                <div class="well">
                    <div class="form-group heading blue_banner custom_heading tournament_background_color text_align_left">
                        <span ><?php echo '{%= sports_list.tournament_list[j].title%}'; ?> </span>
                    </div>
                    <div class="form-group" style="margin: 0 2.5%;">
                        <table class="table">
                            <div class="feed_predict_score row form-group table-hover text_align">
                                <div class="app_sp_time">
                                    Time
                                </div>
                                <div class="app_sp_team_home">
                                    Team A
                                </div>
                                <div class="app_sp_vs">
                                    vs
                                </div>
                                <div class="app_sp_team_away">
                                    Team B
                                </div>
                                <div class="app_sp_match_result">
                                    Match Result
                                </div>
                                <div class="app_sp_match_status">
                                    Match Status
                                </div>
                            </div>
                        </table>
                    </div>

                    <!-- Accordion here starts-->
                    {% var count1 = sports_list.tournament_list[j].match_list.length; %}
                    <div class="panel-group" id="accordion_match" role="tablist" aria-multiselectable="true">
                        {% for(var k=0; k<count1; k++){ %}
                            <div class="panel panel-default" id="div_match_info_{%= sports_list.tournament_list[j].match_list[k].match_id%}">
                                <div class="row panel-heading" role="tab">
                                    <a class="feed_predict_score anchor_text_style" role="button" data-toggle="collapse" data-parent="#accordion_match" href="#collapse_match_event{%= sports_list.tournament_list[j].match_list[k].match_id%}" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="app_sp_time">
                                            <?php echo '{%= sports_list.tournament_list[j].match_list[k].time %}'; ?>
                                        </div>
                                        <div class="app_sp_team_home">
                                            <?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_home %}'; ?></div>
                                        <div class="app_sp_vs">
                                            vs
                                        </div>
                                        <div class="app_sp_team_away">
                                            <?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_away %}'; ?>
                                        </div>
                                        <div class="app_sp_match_result">
                                            <?php echo '{%= sports_list.tournament_list[j].match_list[k].score_home %}' . ' - ' . '{%= sports_list.tournament_list[j].match_list[k].score_away %}'; ?>
                                        </div>
                                        <div class="app_sp_match_status">
                                            {% if(sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?>) { %}
                                            <span > Closed </span>
                                            {% }else if(sports_list.tournament_list[j].match_list[k].is_predicted == 1){ %}
                                            <span > Voted </span>
                                            {% }else{ %}
                                            <span>Vote </span>
                                            {% } %}
                                        </div>
                                    </a>
                                </div>
                                <div id="collapse_match_event{%= sports_list.tournament_list[j].match_list[k].match_id%}" class="panel-collapse collapse {%= k === 0 ? 'in':'' %}" role="tabpanel" aria-labelledby="div_match_info_{%= sports_list.tournament_list[j].match_list[k].match_id%}">
                                    <div class="panel-body">
                                        <div class="row form-group" onclick = "prediction_modal('<?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_home %}'; ?>', '<?php echo '{%= sports_list.tournament_list[j].match_list[k].match_id%}' ?>', '<?php echo MATCH_STATUS_WIN_HOME ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].is_predicted %}' ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].status_id %}' ?>', '<?php echo MATCH_PREDICTION_FROM_APPLICATION ?>')">
                                            <div class="col-md-12">
                                                <div class="progress_bar_backgraound" >
                                                    <span class="progress_bar_content"> 
                                                        {%= sports_list.tournament_list[j].match_list[k].team_title_home %}
                                                    </span>
                                                    <span class="progress_bar_percentage_text">
                                                        {%= sports_list.tournament_list[j].match_list[k].prediction_info.home %}
                                                    </span>
                                                     {% if(sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].my_prediction_id == sports_list.tournament_list[j].match_list[k].status_id && sports_list.tournament_list[j].match_list[k].my_prediction_id == <?php echo MATCH_STATUS_WIN_HOME; ?>){ %}
                                                    <div class="progress_bar_width_catulate bgcolor_green" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.home %}"/>
                                                     {% }else if(sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].is_predicted == 1 && sports_list.tournament_list[j].match_list[k].my_prediction_id != sports_list.tournament_list[j].match_list[k].status_id && sports_list.tournament_list[j].match_list[k].my_prediction_id == <?php echo MATCH_STATUS_WIN_HOME; ?>){ %}
                                                    <div class="progress_bar_width_catulate bgcolor_red" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.home %}"/>
                                                     {% }else if(sports_list.tournament_list[j].match_list[k].status_id == <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].is_predicted == 1 && sports_list.tournament_list[j].match_list[k].my_prediction_id == <?php echo MATCH_STATUS_WIN_HOME; ?>){ %}
                                                    <div class="progress_bar_width_catulate bgcolor_blue" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.home %}"/>
                                                    {% }else{ %}
                                                    <div class="progress_bar_width_catulate bgcolor_light_gray" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.home %}"/>
                                                    {% } %}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group" onclick = "prediction_modal('Draw', '<?php echo '{%= sports_list.tournament_list[j].match_list[k].match_id%}' ?>', '<?php echo MATCH_STATUS_DRAW ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].is_predicted %}' ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].status_id %}' ?>', '<?php echo MATCH_PREDICTION_FROM_APPLICATION ?>')">
                                            <div class="col-md-12">
                                                <div class="progress_bar_backgraound">
                                                    <span class="progress_bar_content">Draw</span>
                                                    <span class="progress_bar_percentage_text">
                                                        {%= sports_list.tournament_list[j].match_list[k].prediction_info.draw %}
                                                    </span>
                                                    {% if(sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].my_prediction_id == sports_list.tournament_list[j].match_list[k].status_id && sports_list.tournament_list[j].match_list[k].my_prediction_id == <?php echo MATCH_STATUS_DRAW; ?>){ %}
                                                    <div class="progress_bar_width_catulate bgcolor_green" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.draw %}">
                                                        {% }else if(sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].is_predicted == 1 && sports_list.tournament_list[j].match_list[k].my_prediction_id != sports_list.tournament_list[j].match_list[k].status_id && sports_list.tournament_list[j].match_list[k].my_prediction_id == <?php echo MATCH_STATUS_DRAW; ?>){ %}
                                                        <div class="progress_bar_width_catulate bgcolor_red" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.draw %}">
                                                         {% }else if(sports_list.tournament_list[j].match_list[k].status_id == <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].is_predicted == 1 && sports_list.tournament_list[j].match_list[k].my_prediction_id == <?php echo MATCH_STATUS_DRAW; ?>){ %}
                                                        <div class="progress_bar_width_catulate bgcolor_blue" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.draw %}">
                                                            {% }else{ %}
                                                            <div class="progress_bar_width_catulate bgcolor_light_gray" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.draw %}">
                                                                {% } %} 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group" onclick = "prediction_modal('<?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_away %}'; ?>', '<?php echo '{%= sports_list.tournament_list[j].match_list[k].match_id%}' ?>', '<?php echo MATCH_STATUS_WIN_AWAY ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].is_predicted %}' ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].status_id %}' ?>', '<?php echo MATCH_PREDICTION_FROM_APPLICATION ?>')">
                                                    <div class="col-md-12">
                                                        <div class="progress_bar_backgraound">
                                                            <span class="progress_bar_content">
                                                                {%= sports_list.tournament_list[j].match_list[k].team_title_away %}
                                                            </span>
                                                            <span class="progress_bar_percentage_text">
                                                                {%= sports_list.tournament_list[j].match_list[k].prediction_info.away %}
                                                            </span>
                                                            {% if(sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].my_prediction_id == sports_list.tournament_list[j].match_list[k].status_id && sports_list.tournament_list[j].match_list[k].my_prediction_id == <?php echo MATCH_STATUS_WIN_AWAY; ?>){ %}
                                                            <div class="progress_bar_width_catulate bgcolor_green" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.away %}">
                                                                {% }else if(sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].is_predicted == 1 && sports_list.tournament_list[j].match_list[k].my_prediction_id != sports_list.tournament_list[j].match_list[k].status_id && sports_list.tournament_list[j].match_list[k].my_prediction_id == <?php echo MATCH_STATUS_WIN_AWAY; ?>){ %}
                                                                <div class="progress_bar_width_catulate bgcolor_red" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.away %}">
                                                                {% }else if(sports_list.tournament_list[j].match_list[k].status_id == <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].is_predicted == 1 && sports_list.tournament_list[j].match_list[k].my_prediction_id == <?php echo MATCH_STATUS_WIN_AWAY; ?>){ %}
                                                                <div class="progress_bar_width_catulate bgcolor_blue" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.away %}">
                                                                    {% }else{ %}
                                                                    <div class="progress_bar_width_catulate bgcolor_light_gray" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.away %}">
                                                                        {% } %} 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div>    

                                            {% } %}
                                        </div>
                                        <!-- Accordion here ends-->
                                    </div>                 
                                    {% } %}
                                </div>
                            </div>    
                            {% sports_list = ((o instanceof Array) ? o[sports_counter++] : null); %}
                            {% } %}
                    </div>
                    </script> 
<div class="form-group">
    <div class="input_custom"> 
        <label class="input_custom_input" type="text" id="rMin1" name="to"></label>
        <label class="input_custom_input" type="text" id="rMin2" name="to"></label>
        <label class="input_custom_input input_active_class" type="text" id="rMin3" name="to"></label>
        <label class="input_custom_input" type="text" id="rMin4" name="to"></label>
        <label class="input_custom_input" type="text" id="rMin5" name="to"></label> 
        <input class="date_picker_img" type="image" id="from" src="<?php echo base_url(); ?>resources/images/calendar.png"/>
    </div>
    <div id="home_page_sports_content">
    </div>
</div>
<?php
$this->load->view("applications/score_prediction/process_prediction");
$this->load->view("applications/score_prediction/prediction_confirmation_modal");
                    