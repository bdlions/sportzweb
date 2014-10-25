<script type="text/javascript">
    $(function() {
        $("#button_update_team").on("click", function() {
            if ($("#input_team_update_title").val().length == 0)
            {
                alert("Please assign team name");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_scoreprediction/update_team",
                data: {
                    title: $("#input_team_update_title").val(),
                    team_id: $("#input_team_id").val()
                },
                success: function(data) {
                    alert(data['message']);
                    $("#modal_team_update").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_team_update(team_id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_scoreprediction/get_team_info",
            data: {
                team_id: team_id
            },
            success: function(data) {
                $('#input_team_id').val(data.team_info['team_id']);
//                $('#input_team_id').val(team_id);
                $('#input_team_update_title').val(data.team_info['title']);
                $("#modal_team_update").modal('show');
            }
        });
    }
</script>
<div class="modal fade" id="modal_team_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update team</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Team Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_team_update_title" name="input_team_update_title" value="" type="text" class="form-control"/>
                            <input id="input_team_id" name="input_team_id" value="" type="hidden" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_update_team" name="button_update_team" value="" class="form-control btn button-custom pull-right">Update</button>
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