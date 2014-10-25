<script type="text/javascript">
    $(function() {
        $("#button_update_tournament").on("click", function() {
            if ($("#input_tournament_update_title").val().length == 0)
            {
                alert("Please assign tournament name");
                return;
            }
            if ($("#input_tournament_update_season").val().length == 0)
            {
                alert("Please mension Season.");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_scoreprediction/update_tournament",
                data: {
                    season: $("#input_tournament_update_season").val(),
                    title: $("#input_tournament_update_title").val(),
                    tournament_id: $("#input_tournament_id").val()
                },
                success: function(data) {
                    alert(data['message']);
                    $("#modal_tournament_update").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_tournament_update(tournament_id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_scoreprediction/get_tournament_info",
            data: {
                tournament_id: tournament_id
            },
            success: function(data) {
                $('#input_tournament_id').val(data.tournament_info['tournament_id']);
                $('#input_tournament_update_title').val(data.tournament_info['title']);
                $('#input_tournament_update_season').val(data.tournament_info['season']);
                $("#modal_tournament_update").modal('show');
            }
        });
    }
</script>
<div class="modal fade" id="modal_tournament_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update tournament</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Tournament Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_tournament_update_title" name="input_tournament_update_title" value="" type="text" class="form-control"/>
                            <input id="input_tournament_id" name="input_tournament_id" value="" type="hidden" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Tournament Season:</label>
                        <div class ="col-sm-4">
                            <input id="input_tournament_update_season" name="input_tournament_update_season" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_update_tournament" name="button_update_tournament" value="" class="form-control btn button-custom pull-right">Update</button>
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