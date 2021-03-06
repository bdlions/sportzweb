<script type="text/javascript">
    $(function(){
        $('#vote_id').on('click', function () {
            $("#confirmModal").modal('hide');
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "<?php echo base_url() . 'applications/score_prediction/post_vote'; ?>",
                data: {
                    match_id: $("#match_id").val(),
                    location_id: $("#location_id").val(),
                    predicted_match_status_id: $("#status_id").val()
                },
                success: function (data) {                    
                    $('#collapse_match_event' + $("#match_id").val()).empty();
                    $('#div_match_info_' + $("#match_id").val()).html(tmpl('tmpl_match_details', data.match_info));
                }
            });
        });
    });
    function prediction_modal(team_name, match_id, vote_id, is_predicted, status_id, location_id) {
        var match_status_upcoming_id = '<?php echo MATCH_STATUS_UPCOMING; ?>';
        if (is_predicted == 0 && status_id == match_status_upcoming_id) {
            $('#team_name_id').html(team_name);
            $("#match_id").val(match_id);
            $("#status_id").val(vote_id);
            $("#location_id").val(location_id);
            $("#confirmModal").modal('show');
        }
    }
</script>
<script type="text/x-tmpl" id="tmpl_match_details">
    {% var sports_counte = 0, match_info = ((o instanceof Array) ? o[sports_counter++] : o); %}
    {% while(match_info){ %}        
        <div class="row panel-heading sp_app_panel_heading_margin" role="tab">
            {% if(match_info.location_id == <?php echo MATCH_PREDICTION_FROM_NEWSFEED; ?>){ %}
            <?php 
                echo '<a class="score_prediction" href="'.base_url().'applications/score_prediction/index/{%= match_info.match_id%}">';                            
            ?>
            {% }else{ %}
            <a class="score_prediction anchor_text_style" role="button" data-toggle="collapse" data-parent="#accordion_match" href="#collapse_match_event{%= match_info.match_id%}" aria-expanded="true" aria-controls="">
            {% }%}
                <div class="app_sp_time">
                    <?php echo '{%= match_info.time %}'; ?>
                </div>
                <div class="app_sp_team_home">
                    <?php echo '{%= match_info.team_title_home %}'; ?>
                </div>
                {% if(match_info.status_id == <?php echo MATCH_STATUS_UPCOMING; ?>) { %}
                <div class="app_sp_vs">
                    vs
                </div>
                {% }else{ %}
                <div class="app_sp_match_result">
                    <?php echo '{%= match_info.score_home %}' . ' - ' . '{%= match_info.score_away %}'; ?>
                </div>
                {% } %}
                <div class="app_sp_team_away">
                    <?php echo '{%= match_info.team_title_away %}'; ?>
                </div>
                <div class="app_sp_match_status">
                    {% if(match_info.status_id != <?php echo MATCH_STATUS_UPCOMING; ?>) { %}
                    <div class="floating_right">Closed </div>
                    {% }else if(match_info.is_predicted == 1){ %}
                    <div class="floating_right">Voted </div>
                    {% }else{ %}
                    <div class="floating_right">Vote </div>
                    {% } %}
                </div>
            </a>            
            </div>
        </div>
        <div id="collapse_match_event{%= match_info.match_id%}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="div_match_info_{%= match_info.match_id%}">
            <div class="panel-body">
                <div class="row form-group" onclick = "prediction_modal('<?php echo '{%= match_info.team_title_home %}'; ?>', '<?php echo '{%= match_info.match_id%}' ?>', '<?php echo MATCH_STATUS_WIN_HOME ?>', '<?php echo'{%= match_info.is_predicted %}' ?>', '<?php echo'{%= match_info.status_id %}' ?>', '<?php echo MATCH_PREDICTION_FROM_APPLICATION ?>')">
                    <div class="col-md-12">
                        {% var home_percentage = match_info.prediction_info.home; %}
                        {% var home_css_class = ""; %}
                        {% if(match_info.status_id != '<?php echo MATCH_STATUS_UPCOMING ?>' && match_info.status_id == '<?php echo MATCH_STATUS_WIN_HOME ?>'){ %}
                        {%    home_css_class = "progress_bar_width_catulate bgcolor_green"; %}
                        {% }else if(match_info.status_id != '<?php echo MATCH_STATUS_UPCOMING ?>' && match_info.is_predicted == 1 && match_info.my_prediction_id != match_info.status_id && match_info.my_prediction_id == '<?php echo MATCH_STATUS_WIN_HOME ?>'){ %}
                        {%    home_css_class = "progress_bar_width_catulate bgcolor_red"; %}
                        {% }else if(match_info.status_id == '<?php echo MATCH_STATUS_UPCOMING ?>' && match_info.is_predicted == 1 && match_info.my_prediction_id == '<?php echo MATCH_STATUS_WIN_HOME ?>'){ %}
                        {%    home_css_class = "progress_bar_width_catulate bgcolor_blue"; %}
                        {% }else{ %}
                        {%    home_css_class = "progress_bar_width_catulate bgcolor_light_gray"; %}
                        {% } %}
                        <div class="progress_bar_backgraound" >
                            <span class="progress_bar_content"> <?php echo '{%= match_info.team_title_home %}'; ?></span>
                            <span class="progress_bar_percentage_text"><?php echo '{%= home_percentage %}'; ?></span>
                            <div class="{%= home_css_class %}" style="width:<?php echo '{%= home_percentage %}'; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                {% if(match_info.sports_id != <?php echo APP_SP_TENNIS_SPORTS_ID; ?>){ %}
                <div class="row form-group" onclick = "prediction_modal('Draw', '<?php echo '{%= match_info.match_id%}' ?>', '<?php echo MATCH_STATUS_DRAW ?>', '<?php echo'{%= match_info.is_predicted %}' ?>', '<?php echo'{%= match_info.status_id %}' ?>', '<?php echo MATCH_PREDICTION_FROM_APPLICATION ?>')">
                    <div class="col-md-12">
                        {% var draw_percentage = match_info.prediction_info.draw; %}
                        {% var draw_css_class = ""; %}
                        {% if(match_info.status_id != '<?php echo MATCH_STATUS_UPCOMING ?>' && match_info.status_id == '<?php echo MATCH_STATUS_DRAW ?>'){ %}
                        {%    draw_css_class = "progress_bar_width_catulate bgcolor_green"; %}
                        {% }else if(match_info.status_id != '<?php echo MATCH_STATUS_UPCOMING ?>' && match_info.is_predicted == 1 && match_info.my_prediction_id != match_info.status_id && match_info.my_prediction_id == '<?php echo MATCH_STATUS_DRAW ?>'){ %}
                        {%    draw_css_class = "progress_bar_width_catulate bgcolor_red"; %}
                        {% }else if(match_info.status_id == '<?php echo MATCH_STATUS_UPCOMING ?>' && match_info.is_predicted == 1 && match_info.my_prediction_id == '<?php echo MATCH_STATUS_DRAW ?>'){ %}
                        {%    draw_css_class = "progress_bar_width_catulate bgcolor_blue"; %}
                        {% }else{ %}
                        {%    draw_css_class = "progress_bar_width_catulate bgcolor_light_gray"; %}
                        {% } %}
                        <div class="progress_bar_backgraound">
                            <span class="progress_bar_content">Draw</span>
                            <span class="progress_bar_percentage_text"><?php echo '{%= draw_percentage %}'; ?></span>
                            <div class="{%= draw_css_class %}" style="width:<?php echo '{%= draw_percentage %}'; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                {% } %}
                <div class="row form-group" onclick = "prediction_modal('<?php echo '{%= match_info.team_title_away %}'; ?>', '<?php echo '{%= match_info.match_id%}' ?>', '<?php echo MATCH_STATUS_WIN_AWAY ?>', '<?php echo'{%= match_info.is_predicted %}' ?>', '<?php echo'{%= match_info.status_id %}' ?>', '<?php echo MATCH_PREDICTION_FROM_APPLICATION ?>')">
                    <div class="col-md-12">
                        {% var away_percentage = match_info.prediction_info.away; %}
                        {% var away_css_class = ""; %}
                        {% if(match_info.status_id != '<?php echo MATCH_STATUS_UPCOMING ?>' && match_info.status_id == '<?php echo MATCH_STATUS_WIN_AWAY ?>'){ %}
                        {%    away_css_class = "progress_bar_width_catulate bgcolor_green"; %}
                        {% }else if(match_info.status_id != '<?php echo MATCH_STATUS_UPCOMING ?>' && match_info.is_predicted == 1 && match_info.my_prediction_id != match_info.status_id && match_info.my_prediction_id == '<?php echo MATCH_STATUS_WIN_AWAY ?>'){ %}
                        {%    away_css_class = "progress_bar_width_catulate bgcolor_red"; %}
                        {% }else if(match_info.status_id == '<?php echo MATCH_STATUS_UPCOMING ?>' && match_info.is_predicted == 1 && match_info.my_prediction_id == '<?php echo MATCH_STATUS_WIN_AWAY ?>'){ %}
                        {%    away_css_class = "progress_bar_width_catulate bgcolor_blue"; %}
                        {% }else{ %}
                        {%    away_css_class = "progress_bar_width_catulate bgcolor_light_gray"; %}
                        {% } %}
                        <div class="progress_bar_backgraound">
                            <span class="progress_bar_content"><?php echo '{%= match_info.team_title_away %}'; ?></span>
                            <span class="progress_bar_percentage_text"><?php echo '{%= away_percentage %}'; ?></span>
                            <div class="{%= away_css_class %}" style="width:<?php echo '{%= away_percentage %}'; ?>">
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>        
    {% match_info = ((o instanceof Array) ? o[sports_counter++] : null); %}
    {% } %}
</script>