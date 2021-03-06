<script type="text/javascript">
    $(function () {
        $("#button_update_sports").on("click", function () {
            var leagueArray = new Array();
            $("#league_table_option_list_update input:checkbox[name=type]:checked").each(function () {
                leagueArray.push($(this).val());
            });
            if ($("#input_sports_update_title").val().length == 0)
            {
                var message = "Please assign sports name";
                print_common_message(message);
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_scoreprediction/update_sports",
                data: {
                    title: $("#input_sports_update_title").val(),
                    table_title: $("#input_sports_table_title").val(),
                    order: $("#input_sports_order").val(),
                    sports_id: $("#input_sports_id").val(),
                    league_table_configuration: leagueArray
                },
                success: function (data) {
                    var message = data['message'];
                    print_common_message(message);
                    $("#modal_sports_update").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_sports_update(sports_id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_scoreprediction/get_sports_info",
            data: {
                sports_id: sports_id
            },
            success: function (data) {
                var langueTableArray = data.sports_info['league_tbl_conf'];
                $('#league_table_option_list_update input[name="type"]').each(function () {
                    $(this).prop("checked", ($.inArray($(this).val(), langueTableArray) != -1));
                });
                $('#input_sports_id').val(data.sports_info['sports_id']);
                $('#input_sports_update_title').val(data.sports_info['title']);
                $('#input_sports_table_title').val(data.sports_info['table_title']);
                $('#input_sports_order').val(data.sports_info['order']);
                $("#modal_sports_update").modal('show');
            }
        });
    }
</script>
<div class="modal fade" id="modal_sports_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Sports</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="league_table_option_list_update">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Sports Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_sports_update_title" name="input_sports_update_title" value="" type="text" class="form-control"/>
                            <input id="input_sports_id" name="input_sports_id" value="" type="hidden" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Table Title:</label>
                        <div class ="col-sm-4">
                            <input id="input_sports_table_title" name="input_sports_table_title" value="" type="text" class="form-control"/>                            
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Sports Order:</label>
                        <div class ="col-sm-4">
                            <input id="input_sports_order" name="input_sports_order" value="" type="text" class="form-control"/>                            
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
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_update_sports" name="button_update_sports" value="" class="form-control btn button-custom pull-right">Update</button>
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