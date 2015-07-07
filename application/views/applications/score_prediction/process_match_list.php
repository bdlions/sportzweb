<script type="text/javascript">
    $(function () {
        sports_id = '<?php echo $sports_id ?>';
        date = '<?php echo $date ?>';
        match_id = '<?php echo $match_id ?>';
        var thisYear = new Date().getFullYear();
        setDate(new Date());
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
        get_match_list(date, sports_id, match_id);
        $('#vote_id').on('click', function () {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "<?php echo base_url() . 'applications/score_prediction/post_vote'; ?>",
                data: {
                    match_id: $("#match_id").val(),
                    predicted_match_status_id: $("#status_id").val()
                },
                success: function (data) {
                    $("#confirmModal").modal('hide');
                    $('#collapse_match_event' + $("#match_id").val()).empty();
                    $('#div_match_info_' + $("#match_id").val()).html(tmpl('tmpl_match_details', data.match_info));
                }
            });
        });
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
        get_match_list(formattedDate, sports_id, 0);
    }

    function prediction_modal(teamName, matchId, voteId, matchStatusId, statusId) {
        var matchSId = '<?php echo MATCH_STATUS_UPCOMING; ?>';
        if (matchStatusId == 0 && statusId == matchSId) {
            $('#team_name_id').html(teamName);
            $("#match_id").val(matchId);
            $("#status_id").val(voteId);
            $("#confirmModal").modal('show');

        }
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
                $('#home_page_sports_content').html(tmpl('tlmp_home_page_sports_content', data.sports_list));
//                $('#home_page_sports_content').html(tmpl('tlmp_home_page_sports_content_test', data.sports_list));
            }
        });
    }
</script>
<script type="text/x-tmpl" id="tmpl_match_details">
    {% var sports_counte = 0, match_info = ((o instanceof Array) ? o[sports_counter++] : o); %}
    {% while(match_info){ %}
    <div class="panel panel-default">
    <div class=" row form-group panel-heading " role="tab" id="div_match_info_{%= match_info.match_id%}">
    <a role="button" data-toggle="collapse" data-parent="#accordion_match" href="#collapse_match_event{%= match_info.match_id%}" aria-expanded="true" aria-controls="">
    <div class="col-md-2">
    <?php echo '{%= match_info.time %}'; ?>
    </div>
    <div class="col-md-2">
    <?php echo '{%= match_info.team_title_home %}'; ?>
    </div>
    <div class="col-md-2">
    vs
    </div>
    <div class="col-md-2">
    <?php echo '{%= match_info.team_title_away %}'; ?>
    </div>
    <div class="col-md-2">
    <?php echo '{%= match_info.score_home %}' . ' - ' . '{%= match_info.score_away %}'; ?>
    </div>
    <div class="col-md-2">
    {% if(match_info.status_id != <?php echo MATCH_STATUS_UPCOMING; ?>) { %}
    <span > Closed </span>
    {% }else if(match_info.is_predicted == 1){ %}
    <span > Prdicted </span>
    {% }else{ %}
    <span>predict </span>
    {% } %}
    </div>
    </a>
    </div>
    </div>

    <div id="collapse_match_event{%= match_info.match_id%}" class="panel-collapse collapse {%= sports_counte === 0 ? 'in':'' %}" role="tabpanel" aria-labelledby="div_match_info_{%= match_info.match_id%}">
    <div class="panel-body">
    <div class="row form-group" onclick = "prediction_modal('<?php echo '{%= match_info.team_title_home %}'; ?>', '<?php echo '{%= match_info.match_id%}' ?>', '<?php echo MATCH_STATUS_WIN_HOME ?>', '<?php echo'{%= match_info.is_predicted %}' ?>')">
    <div class="col-md-12">
    <div class="progress_bar_backgraound" >
    <span class="progress_bar_content"> <?php echo '{%= match_info.team_title_home %}'; ?></span>
    <span class="progress_bar_percentage_text"><?php echo '{%= match_info.prediction_info.home %}'; ?></span>
    <div class="progress_bar_width_catulate" style="width:<?php echo '{%= match_info.prediction_info.home %}'; ?>">
    </div>
    </div>
    </div>
    </div>
    <div class="row form-group" onclick = "prediction_modal('Draw', '<?php echo '{%= match_info.match_id%}' ?>', '<?php echo MATCH_STATUS_DRAW ?>', '<?php echo'{%= match_info.is_predicted %}' ?>')">
    <div class="col-md-12">
    <div class="progress_bar_backgraound">
    <span class="progress_bar_content">Draw</span>
    <span class="progress_bar_percentage_text"><?php echo '{%= match_info.prediction_info.draw %}'; ?>`</span>
    <div class="progress_bar_width_catulate" style="width:<?php echo '{%= match_info.prediction_info.draw %}'; ?>">
    </div>
    </div>
    </div>
    </div>
    <div class="row form-group" onclick = "prediction_modal('<?php echo '{%= match_info.team_title_away %}'; ?>', '<?php echo '{%= match_info.match_id%}' ?>', '<?php echo MATCH_STATUS_WIN_AWAY ?>', '<?php echo'{%= match_info.is_predicted %}' ?>')">
    <div class="col-md-12">
    <div class="progress_bar_backgraound">
    <span class="progress_bar_content"><?php echo '{%= match_info.team_title_away %}'; ?></span>
    <span class="progress_bar_percentage_text"><?php echo '{%= match_info.prediction_info.away %}'; ?></span>
    <div class="progress_bar_width_catulate" style="width:<?php echo '{%= match_info.prediction_info.away %}'; ?>">
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    {% match_info = ((o instanceof Array) ? o[sports_counter++] : null); %}
    {% } %}
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
                        </table>
                    </div>

                    <!-- Accordion here starts-->
                    {% var count1 = sports_list.tournament_list[j].match_list.length; %}
                    <div class="panel-group" id="accordion_match" role="tablist" aria-multiselectable="true">
                        {% for(var k=0; k<count1; k++){ %}
                            <div class="panel panel-default">
                                <div class=" row panel-heading " role="tab" id="div_match_info_{%= sports_list.tournament_list[j].match_list[k].match_id%}">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion_match" href="#collapse_match_event{%= sports_list.tournament_list[j].match_list[k].match_id%}" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="col-md-2">
                                            <?php echo '{%= sports_list.tournament_list[j].match_list[k].time %}'; ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_home %}'; ?></div>
                                        <div class="col-md-2">
                                            vs
                                        </div>
                                        <div class="col-md-2">
                                            <?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_away %}'; ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?php echo '{%= sports_list.tournament_list[j].match_list[k].score_home %}' . ' - ' . '{%= sports_list.tournament_list[j].match_list[k].score_away %}'; ?>
                                        </div>
                                        <div class="col-md-2">
                                            {% if(sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?>) { %}
                                            <span > Closed </span>
                                            {% }else if(sports_list.tournament_list[j].match_list[k].is_predicted == 1){ %}
                                            <span > Prdicted </span>
                                            {% }else{ %}
                                            <span>predict </span>
                                            {% } %}
                                        </div>
                                    </a>
                                </div>
                                <div id="collapse_match_event{%= sports_list.tournament_list[j].match_list[k].match_id%}" class="panel-collapse collapse {%= k === 0 ? 'in':'' %}" role="tabpanel" aria-labelledby="div_match_info_{%= sports_list.tournament_list[j].match_list[k].match_id%}">
                                    <div class="panel-body">
                                        <div class="row form-group" onclick = "prediction_modal('<?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_home %}'; ?>', '<?php echo '{%= sports_list.tournament_list[j].match_list[k].match_id%}' ?>', '<?php echo MATCH_STATUS_WIN_HOME ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].is_predicted %}' ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].status_id %}' ?>')">
                                            <div class="col-md-12">
                                                <div class="progress_bar_backgraound" >
                                                    <span class="progress_bar_content"> 
                                                        {%= sports_list.tournament_list[j].match_list[k].team_title_home %}
                                                    </span>
                                                    <span class="progress_bar_percentage_text">
                                                        {%= sports_list.tournament_list[j].match_list[k].prediction_info.home %}
                                                    </span>
                                                    {% if((sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].my_prediction_id == sports_list.tournament_list[j].match_list[k].status_id)|| (sports_list.tournament_list[j].match_list[k].status_id == <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].is_predicted == 1)){ %}
                                                    <div class="progress_bar_width_catulate" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.home %}"/>
                                                    {% }else if(sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].is_predicted == 1 && sports_list.tournament_list[j].match_list[k].my_prediction_id != sports_list.tournament_list[j].match_list[k].status_id){ %}
                                                    <div class="progress_bar_width_catulate bgcolor_red" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.home %}"/>
                                                    {% }else{ %}
                                                    <div class="progress_bar_width_catulate" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.home %}"/>
                                                    {% } %}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group" onclick = "prediction_modal('Draw', '<?php echo '{%= sports_list.tournament_list[j].match_list[k].match_id%}' ?>', '<?php echo MATCH_STATUS_DRAW ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].is_predicted %}' ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].status_id %}' ?>')">
                                            <div class="col-md-12">
                                                <div class="progress_bar_backgraound">
                                                    <span class="progress_bar_content">Draw</span>
                                                    <span class="progress_bar_percentage_text">
                                                        {%= sports_list.tournament_list[j].match_list[k].prediction_info.draw %}
                                                    </span>
                                                    {% if((sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].my_prediction_id == sports_list.tournament_list[j].match_list[k].status_id)|| (sports_list.tournament_list[j].match_list[k].status_id == <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].is_predicted == 1)){ %}
                                                    <div class="progress_bar_width_catulate" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.draw %}">
                                                        {% }else if(sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].is_predicted == 1 && sports_list.tournament_list[j].match_list[k].my_prediction_id != sports_list.tournament_list[j].match_list[k].status_id){ %}
                                                        <div class="progress_bar_width_catulate bgcolor_red" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.draw %}">
                                                            {% }else{ %}
                                                            <div class="progress_bar_width_catulate" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.draw %}">
                                                                {% } %} 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-group" onclick = "prediction_modal('<?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_away %}'; ?>', '<?php echo '{%= sports_list.tournament_list[j].match_list[k].match_id%}' ?>', '<?php echo MATCH_STATUS_WIN_AWAY ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].is_predicted %}' ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].status_id %}' ?>')">
                                                    <div class="col-md-12">
                                                        <div class="progress_bar_backgraound">
                                                            <span class="progress_bar_content">
                                                                {%= sports_list.tournament_list[j].match_list[k].team_title_away %}
                                                            </span>
                                                            <span class="progress_bar_percentage_text">
                                                                {%= sports_list.tournament_list[j].match_list[k].prediction_info.away %}
                                                            </span>
                                                            {% if((sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].my_prediction_id == sports_list.tournament_list[j].match_list[k].status_id)|| (sports_list.tournament_list[j].match_list[k].status_id == <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].is_predicted == 1)){ %}
                                                            <div class="progress_bar_width_catulate" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.away %}">
                                                                {% }else if(sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> && sports_list.tournament_list[j].match_list[k].is_predicted == 1 && sports_list.tournament_list[j].match_list[k].my_prediction_id != sports_list.tournament_list[j].match_list[k].status_id){ %}
                                                                <div class="progress_bar_width_catulate bgcolor_red" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.away %}">
                                                                    {% }else{ %}
                                                                    <div class="progress_bar_width_catulate" style="width:{%= sports_list.tournament_list[j].match_list[k].prediction_info.away %}">
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
                    $this->load->view("applications/score_prediction/prediction_confirmation_modal");
                    