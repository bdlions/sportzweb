<script type="text/javascript">
    $(function () {
        setDate(new Date());
        $("#from, #to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onSelect: function (selectedDate) {
                if (this.id == 'from') {
                    var dateMin = $('#from').datepicker("getDate");
                    setDate(dateMin);
                }
            }            
        });
        sports_id = '<?php echo $sports_id?>';
        date = '2015-06-28';
        get_match_list(date, sports_id);
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
            while (today.getTime()+3 === date.getTime()) {
                //when date is today
                formatDate = "Today";
            }
            var index = "#rMin" + (i + 3);
            $(index).val(formatDate);
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
                sports_id:sports_id
            },
            success: function(data) {
                console.dir(data.sports_list);
                $('#home_page_sports_content').append(tmpl('tlmp_home_page_sports_content', data.sports_list));
                //generate the leader board content based on the ajax response using template
            }
        });
    }
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
                                    <a><?php echo '{%= sports_list.tournament_list[j].match_list[k].is_predicted %}</a>'; ?>
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
        <input type="text" id="rMin1" name="to"/>
        <input type="text" id="rMin2" name="to"/>
        <input class="input_active_class" type="text" id="rMin3" name="to">
        <input type="text" id="rMin4" name="to"/>
        <input type="text" id="rMin5" name="to"/> 
        <input type="text" id="from" value="Select A date"/>
    </div>
    <div id="home_page_sports_content">
    </div>
</div>
