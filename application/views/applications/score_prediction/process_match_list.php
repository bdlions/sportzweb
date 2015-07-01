<script type="text/javascript">
    $(function () {
        sports_id = '<?php echo $sports_id ?>';
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
            var selectedDate = $("#rMin1").val();
            var dateParts = selectedDate.split(" ");
            var day = dateParts[ 1 ];
            var month = dateParts[ 2 ];
            selectedDate = new Date(month + " " + day + ", " + thisYear);
            setDate(selectedDate);
//            get_match_list(selectedDate, sports_id);

        });


        date = '2015-06-28';
        get_match_list(date, sports_id);

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
                    $('#collapse_match_event'+$("#match_id").val()).empty().append(tmpl('tmpl_update_predicted_score'),data.match_info);
                    
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
            $(index).val(formatDate);
        }
    }

    function prediction_modal(teamName, matchId, statusId, matchStatusId) {
        if (matchStatusId == 0) {
            $('#team_name_id').html(teamName);
            $("#match_id").val(matchId);
            $("#status_id").val(statusId);
            $("#confirmModal").modal('show');

        }
    }
    function get_match_list(date, sports_id)
    {
        //retrieving matches of all types of sports
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "<?php echo base_url() . 'applications/score_prediction/get_match_list'; ?>",
            data: {
                date: date,
                sports_id: sports_id
            },
            success: function (data) {
                $('#home_page_sports_content').append(tmpl('tlmp_home_page_sports_content', data.sports_list));
                //generate the leader board content based on the ajax response using template
            }
        });
    }
</script>
<script type="text/x-tmpl" id="tmpl_update_predicted_score">
Template add here....
            
</script>

<script type="text/x-tmpl" id="tlmp_home_page_sports_content">
{% var sports_counter = 0, sports_list = ((o instanceof Array) ? o[sports_counter++] : o); %}
{% while(sports_list){ %}
<div class="form-group">
    <a role="button" data-toggle="collapse" href="#collapse_sports_event{%= sports_list.sports_id%}">
        <div class="row" style="padding: 0px; font-size: 20px;">
            <div class="col-md-12">
                <div class="heading blue_banner padding_collapse_header custom_heading text_align_left">
                    {%= sports_list.title%} 
                </div>
            </div>
        </div>
    </a>
    <div class="collapse" id="collapse_sports_event{%= sports_list.sports_id%}">
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
                {% var count1 = sports_list.tournament_list[j].match_list.length; %}
                {% for(var k=0; k<count1; k++){ %}
                    <div class="row form-group text_align ">
                        <div class="col-md-2">
                            <?php echo '{%= sports_list.tournament_list[j].match_list[k].time %}'; ?>
                        </div>
                        <div class="col-md-2">
                            <?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_home %}'; ?>
                        </div>
                        <div class="col-md-2">
                            vs
                        </div>
                        <div class="col-md-2">
                            <?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_away %}'; ?>
                        </div>
                        <div class="col-md-2">
                            2 - 0
                        </div>
                        <div class="col-md-2">
                            {% if(sports_list.tournament_list[j].match_list[k].status_id != <?php echo MATCH_STATUS_UPCOMING; ?> ) { %}
                            <span>Closed</span>
                            {% }else if(sports_list.tournament_list[j].match_list[k].is_predicted == 1){ %}
                            <span data-toggle="collapse" href="#collapse_match_event{%= sports_list.tournament_list[j].match_list[k].match_id%}" >predicted</span>
                            {% }else{ %}
                            <span data-toggle="collapse" href="#collapse_match_event{%= sports_list.tournament_list[j].match_list[k].match_id%}" > predict </span>
                            {% } %}
                        </div>
                    </div>
                    <div class="collapse" id="collapse_match_event{%= sports_list.tournament_list[j].match_list[k].match_id%}">
                        <div class="row form-group" onclick = "prediction_modal('<?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_home %}'; ?>', '<?php echo '{%= sports_list.tournament_list[j].match_list[k].match_id%}' ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].status_id %}' ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].is_predicted %}' ?>')">
                            <div class="col-md-12">
                                <div class="progress_bar_backgraound" >
                                    <span class="progress_bar_percentage_text"><?php echo '{%= sports_list.tournament_list[j].match_list[k].prediction_info.home %}'; ?></span>
                                    <div class="progress_bar_width_catulate" style="width:<?php echo '{%= sports_list.tournament_list[j].match_list[k].prediction_info.home %}'; ?>">
                                        <span class="progress_bar_content"> <?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_home %}'; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" onclick = "prediction_modal('Draw', '<?php echo '{%= sports_list.tournament_list[j].match_list[k].match_id%}' ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].status_id %}' ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].is_predicted %}' ?>')">
                            <div class="col-md-12">
                                <div class="progress_bar_backgraound">
                                    <span class="progress_bar_percentage_text"><?php echo '{%= sports_list.tournament_list[j].match_list[k].prediction_info.draw %}'; ?>`</span>
                                    <div class="progress_bar_width_catulate" style="width:<?php echo '{%= sports_list.tournament_list[j].match_list[k].prediction_info.draw %}'; ?>">
                                        <span class="progress_bar_content">Draw</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" onclick = "prediction_modal('<?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_away %}'; ?>', '<?php echo '{%= sports_list.tournament_list[j].match_list[k].match_id%}' ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].status_id %}' ?>', '<?php echo'{%= sports_list.tournament_list[j].match_list[k].is_predicted %}' ?>')">
                            <div class="col-md-12">
                                <div class="progress_bar_backgraound">
                                    <span class="progress_bar_percentage_text"><?php echo '{%= sports_list.tournament_list[j].match_list[k].prediction_info.away %}'; ?></span>
                                    <div class="progress_bar_width_catulate" style="width:<?php echo '{%= sports_list.tournament_list[j].match_list[k].prediction_info.away %}'; ?>">
                                        <span class="progress_bar_content"><?php echo '{%= sports_list.tournament_list[j].match_list[k].team_title_away %}'; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {% } %}
            </div>                 
            {% } %}
    </div>
</div>    
{% sports_list = ((o instanceof Array) ? o[sports_counter++] : null); %}
{% } %}
</script> 

<div class="form-group">
    <div class="input_custom"> 
        <input class="input_custom_input" type="text" id="rMin1" name="to"/>
        <input class="input_custom_input" type="text" id="rMin2" name="to"/>
        <input class="input_custom_input input_active_class" type="text" id="rMin3" name="to">
        <input class="input_custom_input" type="text" id="rMin4" name="to"/>
        <input class="input_custom_input" type="text" id="rMin5" name="to"/> 
        <input class="date_picker_img" type="image" id="from" src="<?php echo base_url(); ?>resources/images/calendar.png"/>
    </div>
    <div id="home_page_sports_content">
    </div>
</div>

<?php $this->load->view("applications/score_prediction/prediction_confirmation_modal"); ?>+


