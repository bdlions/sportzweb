<script type="text/javascript">
    $(function() {
        $("#button_delete_product_feature").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_shop/delete_feature",
                data: {
                    id: $("#input_feature_id").val()
                },
                success: function(data) {
                    alert(data['message']);
                    $("#modal_feature_delete_confirm").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_feature_delete_confirm(id) {
        $('#input_feature_id').val(id);
        $("#modal_feature_delete_confirm").modal('show');        
    }
</script>
<div class="modal fade" id="modal_feature_delete_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Product Feature</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-10 control-label">Are you sure to delete this Product Feature?</label>
                        <input id="input_feature_id" name="input_feature_id" value="" type="hidden" class="form-control"/>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <div class ="col-md-6">
                    
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" id="button_delete_product_feature" name="button_delete_product_feature" value="" class="form-control btn button-custom pull-right">Delete</button>
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" type="button" class="btn form-control button-custom" data-dismiss="modal">Cancel</button>
                </div>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->