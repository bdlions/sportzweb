<script type="text/javascript">
    $(function() {
        $("#button_save_team").on("click", function() {
            if ($("#input_team_name").val().length == 0)
            {
                alert("Team name is required.");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_xstreambanter/create_team",
                data: {
                    team_name: $("#input_team_name").val(),
                },
                success: function(data) {
                    alert(data['message']);
                    if (data['status'] === 1)
                    {                        
                        $("#tbody_team_list").html($("#tbody_team_list").html()+tmpl("tmpl_team_list",  data['team_info']));
                        $("#modal_create_team").modal('hide');
                    }
                }
            });
        });
    });

</script>
<div class="modal fade" id="modal_create_team" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Team</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Team Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_team_name" name="input_team_name" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_save_team" name="button_save_team" value="" class="form-control btn button-custom pull-right">Create</button>
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
