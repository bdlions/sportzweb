<script type="text/javascript">
    $(function() {
        $('#match_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#match_date').text($('#match_date').data('date'));
            $('#match_date').datepicker('hide');
        });
        $('#submit_update_match').click(function(){
            var match_time = $('#match_time').val();
            //if(/^([01][0-9]|2[0-3]):[0-5][0-9]$/.test(match_time)){
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url().'admin/applications_scoreprediction/update_match/'.$match_id;?>',
                    data: $("#form_update_match").serializeArray(),
                    success: function(data) {
                        print_common_message(data.message);
                        window.location = '<?php echo base_url(); ?>admin/applications_scoreprediction/manage_matches/<?php echo $tournament_id; ?>';
                    }
                });
            //}
        });
    });
    
</script>
<div class="panel panel-default">
    <div class="panel-heading">Update Match</div>
    <div class="panel-body">
        <div class="form-background top-bottom-padding">
            <div class="row">
                <div class ="col-md-8 margin-top-bottom">
                    <?php echo form_open("admin/applications_scoreprediction/update_match/".$match_id, array('id' => 'form_update_match', 'class' => 'form-horizontal', 'onsubmit' => 'return false;')); ?>
                        <div class ="row">
                            <div class="col-md-4"></div>
                            <!--<div class="col-md-8"><?php echo $message; ?></div>-->
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-6 control-label requiredField">
                                Home Team: 
                            </label>
                            <div class ="col-md-6" id="unit_dropdown">
                                <?php echo form_dropdown('home_team_list', $team_list, $selected_home_team, 'class=form-control id=home_team_list'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-6 control-label requiredField">
                                Away Team: 
                            </label>
                            <div class ="col-md-6" id="unit_dropdown">
                                <?php echo form_dropdown('away_team_list', $team_list, $selected_away_team, 'class=form-control id=away_team_list'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="match_date" class="col-md-6 control-label requiredField">
                                Date:
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($match_date + array('class' => 'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="match_time" class="col-md-6 control-label requiredField">
                                Time HH:MM (24HR):
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($match_time + array('class' => 'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="score_home" class="col-md-6 control-label requiredField">
                                Home Score:
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($score_home + array('class' => 'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="score_away" class="col-md-6 control-label requiredField">
                                Away Score:
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($score_away + array('class' => 'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="point_home" class="col-md-6 control-label requiredField">
                                Home Point:
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($point_home + array('class' => 'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="point_away" class="col-md-6 control-label requiredField">
                                Away Point:
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($point_away + array('class' => 'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-6 control-label requiredField">
                                Match status: 
                            </label>
                            <div class ="col-md-6" id="unit_dropdown">
                                <?php echo form_dropdown('match_status_list', $match_status_list, $match_status, 'class=form-control id=match_status_list'); ?>
                            </div>
                        </div>                    
                        <div class="form-group">
                            <label for="submit_update_match" class="col-md-6 control-label requiredField">

                            </label>
                            <div class ="col-md-3 pull-right">
                                <?php echo form_input($submit_update_match+array('class'=>'form-control button-custom')); ?>
                            </div> 
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
            </div>
        </div>
    </div>
</div>