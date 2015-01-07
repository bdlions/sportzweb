<script type="text/javascript">
    $(function() {
        $("#button_delete").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_healthyrecipes/delete_recipe",
                data: {
                    recipe_id: $("#input_recipe_id").val()
                },
                success: function(data) {
                    alert(data['message']);
                    $("#modal_delete_confirm").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_delete_recipe(recipe_id) {
        $('#input_recipe_id').val(recipe_id);
        $("#modal_delete_confirm").modal('show');
    }
</script>
<div class="modal fade" id="modal_delete_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Recipe</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class ="col-md-offset-2 col-md-10">
                        <span style="font-size: 16px">Are you sure to delete this recipe?</span>
                        <input id="input_recipe_id" name="input_recipe_id" value="" type="hidden" class="form-control"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class ="col-md-6">
                    
                </div>
                <div class="col-md-3">
                    <button style="width:100%" id="button_delete" name="button_delete" value="" class="btn button-custom">Delete</button>
                </div>
                <div class="col-md-3">
                    <button style="width:100%" type="button" class="btn button-custom" data-dismiss="modal">Cancel</button>
                </div>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->