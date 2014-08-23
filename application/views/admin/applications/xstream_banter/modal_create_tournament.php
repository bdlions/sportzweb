<script type="text/javascript">
    $(function() {
        $("#button_save_tournament").on("click", function() {
            if ($("#input_tournament_name").val().length == 0)
            {
                alert("Tournament name is required.");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/application/create_tournament",
                data: {
                    tournament_name: $("#input_tournament_name").val(),
                    sports_id: '<?php echo $sports_id?>'
                },
                success: function(data) {
                    alert(data['message']);
                    if (data['status'] === 1)
                    {                        
                        $("#tbody_tournament_list").html($("#tbody_tournament_list").html()+tmpl("tmpl_tournament_list",  data['tournament_info']));
                        $("#modal_create_tournament").modal('hide');
                    }
                }
            });
        });
    });

</script>
<div class="modal fade" id="modal_create_tournament" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Tournament</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Tournament Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_tournament_name" name="input_tournament_name" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_save_tournament" name="button_save_tournament" value="" class="form-control btn button-custom pull-right">Create</button>
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
