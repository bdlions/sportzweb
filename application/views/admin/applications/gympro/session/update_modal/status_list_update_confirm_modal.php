<script type="text/javascript">
    $(function() {
        $("#button_update").on("click", function() {
            if ($("#input_update_title").val().length == 0)
            {
               // alert("Please assign session status");
               var message = "Please assign session status";
               print_common_message(message);
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_gympro/update_session_status",
                data: {
                    status_id: $("#input_update_id").val(),
                    status_title: $("#input_update_title").val(),
                },
                success: function(data) {
                   // alert(data['message']);
                  var message = data['message'];
                  print_common_message(message);
                    $("#modal_update").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_update(id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_gympro/get_session_status_info",
            data: {
                status_id: id
            },
            success: function(data) {
                $('#input_update_id').val(data.status_info['id']);
                $('#input_update_title').val(data.status_info['title']);
                $("#modal_update").modal('show');
            }
        });
    }
</script>
<div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Status</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Title:</label>
                        <div class ="col-sm-4">
                            <input id="input_update_title" name="input_update_title" value="" type="text" class="form-control"/>
                            <input id="input_update_id" name="input_update_id" value="" type="hidden" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_update" name="button_update" value="" class="form-control btn button-custom pull-right">Update</button>
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