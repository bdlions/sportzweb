<script type="text/javascript">
    $(function () {
        $("#button_create_sports").on("click", function () {
          var  sportArray = [];
        $("input:checkbox[name=type]:checked").each(function () {
            sportArray.push($(this).val());
        });
            if ($("#input_sports_create_title").val().length == 0)
            {
                //alert("Please assign sports name");
                var message = "Please assign sports name";
                print_common_message(message);
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_scoreprediction/create_sports",
                data: {
                    title: $("#input_sports_create_title").val(),
                    league_table_value : sportArray
                },
                success: function (data) {
                    //  alert(data['message']);
                    var message = data['message'];
                    print_common_message(message);
                    $("#modal_sports_create").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_sports_create() {
        $("#modal_sports_create").modal('show');
    }
</script>
<div class="modal fade" id="modal_sports_create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Sports</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class ="col-sm-2"></div>
                    <label class="col-sm-3 control-label">Sports Name:</label>
                    <div class ="col-sm-4">
                        <input id="input_sports_create_title" name="input_sports_create_title" value="" type="text" class="form-control"/>
                        <input id="input_sports_id" name="input_sports_id" value="" type="hidden" class="form-control"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-5 col-sm-4">
                        <input type="checkbox" name="type" id="position" value="<?php echo LEAGUE_TABLE_POSITION_ID; ?>"> 
                        <span style="vertical-align: top; font-size: 14px;">Position</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-5 col-sm-4">
                        <input type="checkbox" name="type" id="driver" value="<?php echo LEAGUE_TABLE_DRIVERS_ID; ?>"> 
                        <span style="vertical-align: top; font-size: 14px;">Drivers</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-5 col-sm-4">
                        <input type="checkbox" name="type" id="player" value="<?php echo LEAGUE_TABLE_PLAYERS_ID; ?>"> 
                        <span style="vertical-align: top; font-size: 14px;">Players</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-5 col-sm-4">
                        <input type="checkbox" name="type" id="team" value="<?php echo LEAGUE_TABLE_TEAMS_ID; ?>" > 
                        <span style="vertical-align: top; font-size: 14px;">Teams</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-5 col-sm-4">
                        <input type="checkbox" name="type" id="played" value="<?php echo LEAGUE_TABLE_PLAYED_ID; ?>" > 
                        <span style="vertical-align: top; font-size: 14px;">Played</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-5 col-sm-4">
                        <input type="checkbox" name="type" id="goal" value="<?php echo LEAGUE_TABLE_GOAL_DIFFERENCE_ID; ?>" > 
                        <span style="vertical-align: top; font-size: 14px;">Goal Difference</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-5 col-sm-4">
                        <input type="checkbox" name="type" id="point" value="<?php echo LEAGUE_TABLE_POINTS_ID; ?>" > 
                        <span style="vertical-align: top; font-size: 14px;">Points</span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class ="col-sm-8"></div>
                    <div class ="col-sm-2">
                        <button id="button_create_sports" name="button_create_sports" value="" class="form-control btn button-custom pull-right">Create</button>
                    </div>
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>