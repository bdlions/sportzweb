<script type="text/javascript">
    $(function() {
        $("#button_create_tournament").on("click", function() {
            if ($("#input_tournament_create_title").val().length == 0)
            {
                alert("Please assign Tournament name");
                return;
            }
            if ($("#input_tournament_create_season").val().length == 0)
            {
                alert("Please mension Season.");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_scoreprediction/create_tournament",
                data: {
                    tournament_id: '<?php echo $tournament_id?>',
                    title: $("#input_tournament_create_title").val(),
                    season: $("#input_tournament_create_season").val()
                },
                success: function(data) {
                    alert(data['message']);
                    $("#modal_tournament_create").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_tournament_create() {
        $("#modal_tournament_create").modal('show');
    }
</script>
<div class="modal fade" id="modal_tournament_create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create tournament</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Tournament name:</label>
                        <div class ="col-sm-4">
                            <input id="input_tournament_create_title" name="input_tournament_create_title" value="" type="text" class="form-control"/>
                            <!--<input id="input_tournament_id" name="input_tournament_id" value="" type="hidden" class="form-control"/>-->
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Tournament Season:</label>
                        <div class ="col-sm-4">
                            <input id="input_tournament_create_season" name="input_tournament_create_season" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_create_tournament" name="button_create_tournament" value="" class="form-control btn button-custom pull-right">Create</button>
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