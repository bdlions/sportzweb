<script type="text/javascript">
    $(function() {
        $("#button_create_team").on("click", function() {
            if ($("#input_team_create_title").val().length == 0)
            {
                alert("Please assign team name");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_xstreambanter/create_team",
                data: {
                    title: $("#input_team_create_title").val(),
                    sports_id:'<?php echo $sports_id?>'
                },
                success: function(data) {
                    alert(data['message']);
                    $("#modal_team_create").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_team_create() {
        $("#modal_team_create").modal('show');
    }
</script>
<div class="modal fade" id="modal_team_create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                            <input id="input_team_create_title" name="input_team_create_title" value="" type="text" class="form-control"/>
                            <input id="input_team_id" name="input_team_id" value="" type="hidden" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_create_team" name="button_create_team" value="" class="form-control btn button-custom pull-right">Create</button>
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