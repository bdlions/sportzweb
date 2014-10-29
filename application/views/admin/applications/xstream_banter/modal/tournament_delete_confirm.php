<script type="text/javascript">
    $(function() {
        $("#button_delete_tournament").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_xstreambanter/delete_tournament",
                data: {
                    tournament_id: $("#input_tournament_id").val()
                },
                success: function(data) {
                    alert(data['message']);
                    $("#modal_tournament_delete_confirm").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_tournament_delete_confirm(tournament_id) {
        $('#input_tournament_id').val(tournament_id);
        $("#modal_tournament_delete_confirm").modal('show');        
    }
</script>
<div class="modal fade" id="modal_tournament_delete_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Tournament</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-10 control-label">Are you sure to delete this tournament?</label>
                        <input id="input_tournament_id" name="input_tournament_id" value="" type="hidden" class="form-control"/>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <div class ="col-md-6">
                    
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" id="button_delete_tournament" name="button_delete_tournament" value="" class="form-control btn button-custom pull-right">Delete</button>
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" type="button" class="btn button-custom" data-dismiss="modal">Close</button>
                </div>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->