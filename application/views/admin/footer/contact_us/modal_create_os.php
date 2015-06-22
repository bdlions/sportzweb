<script type="text/javascript">
    $(function() {
        $("#button_save_os").on("click", function() {
            if ($("#input_os_name").val().length == 0)
            {
                //alert("Operating System name is required.");
                var message = "Operating System name is required.";
                print_common_message(message);
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/contact_us/create_os",
                data: {
                    new_os_name: $("#input_os_name").val()
                },
                success: function(data) {
                    //alert(data.message);
                    var message = data.message;
                print_common_message(message);
                    $('#modal_create_os').modal('hide');
                    window.location = '<?php echo base_url();?>admin/contact_us/manage_os';
                }
            });
        });
    });

</script>
<div class="modal fade" id="modal_create_os" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Operating System</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Operating System Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_os_name" name="input_os_name" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_save_os" name="button_save_os" value="" class="form-control btn button-custom pull-right">Create</button>
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
