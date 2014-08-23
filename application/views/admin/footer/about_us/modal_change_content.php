<script type="text/javascript">
    $(function() {
        $("#button_save_text").on("click", function() {
            $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "admin/footer/update_about_us",
                    data: {
                        region_id: $('#region_id').val(),
                        text: $('#input_text').val(),
                    },
                    success: function(data) {
                        window.location.reload();
                    }
                });
            $('#modal_chnage_content').modal('hide');            
        });
    });
</script>
<div class="modal fade" id="modal_chnage_content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Change content </h4>
            </div>
            <div class="modal-body" style="max-height: 300px; ">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-1"></div>
                        <label class="col-sm-2 control-label">Text:</label>
                        <div class ="col-sm-8">
                            <input type="hidden" id="region_id" name="region_id" value=""/>
                            <textarea rows="6" cols="50" id="input_text" name="input_text" value="" type="text" class="form-control">
                                
                            </textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-3 pull-right">
                            
                        </div>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button id="button_save_text" name="button_save_text" value="" class="btn button-custom ">Save</button>
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
