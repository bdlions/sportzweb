<script type="text/javascript">
    $(function() {
        $('#text_match_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
            }).on('changeDate', function(ev) {
            $('#text_match_date').text($('#text_match_date').data('date'));
            $('#text_match_date').datepicker('hide');
        });
        $("#button_insert_match").on("click", function() {
            if( $('#team1').val() === $('#team2').val())
            {
                alert('Please select two different teams to set a match.');
                return;
            }
            if( $('#text_match_date').val() === '')
            {
                alert('Please select a date to set a match.');
                return;
            }
            if( $('#text_match_time').val() === '')
            {
                alert('Please assign time to set a match.');
                return;
            }
            var match_time = $('#text_match_time').val();
            var time_array = match_time.split(":");
            var match_time_error_message = 'Please assign time using the format hh:mm';
            if(time_array.length !== 2)
            {
                alert(match_time_error_message);
                return;
            }
            else
            {
                if(time_array[0] < 0 || time_array[0] > 23)
                {
                    alert(match_time_error_message);
                    return;
                }
                else if(time_array[1] < 0 || time_array[1] > 59)
                {
                    alert(match_time_error_message);
                    return;
                }
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/application/create_match",
                data: {
                    team1_id: $("#team1").val(),
                    team2_id: $("#team2").val(),
                    tournament_id: '<?php echo $tournament_id?>',
                    date: $("#text_match_date").val(),
                    time: $("#text_match_time").val(),
                },
                success: function(data) {
                    alert(data['message']);
                    if(data['status'] === 1)
                    {
                        window.location.reload();
                    }
                }
            });
        });
    });

</script>
<div class="modal fade" id="modal_create_match" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Match</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Team A:</label>
                        <div class ="col-sm-4">
                            <?php echo form_dropdown('team1', $team_list_match, '', 'class="form-control" id="team1"'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Team B:</label>
                        <div class ="col-sm-4">
                            <?php echo form_dropdown('team2', $team_list_match, '', 'class="form-control" id="team2"'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Date:</label>
                        <div class ="col-sm-4">
                            <input id="text_match_date" name="text_match_date" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Time:</label>
                        <div class ="col-sm-4">
                            <input id="text_match_time" name="text_match_time" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_insert_match" name="button_insert_match" value="" class="form-control btn button-custom pull-right">Create</button>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
