<script type="text/javascript">
    $(function() {
        $("#button_save_sports").on("click", function() {
            if ($("#input_sports_name").val().length == 0)
            {
                alert("Sports name is required.");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/application/create_sports",
                data: {
                    sports_name: $("#input_sports_name").val()
                },
                success: function(data) {
                    alert(data['message']);
                    if (data['status'] === 1)
                    {                        
                        $("#tbody_sports_list").html($("#tbody_sports_list").html()+tmpl("tmpl_sports_list",  data['sports_info']));
                        $("#modal_create_sports").modal('hide');
                    }
                }
            });
        });
    });

</script>
<div class="modal fade" id="modal_create_sports" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Sports</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Sports Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_sports_name" name="input_sports_name" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_save_sports" name="button_save_sports" value="" class="form-control btn button-custom pull-right">Create</button>
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
