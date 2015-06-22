<script type="text/javascript">
    $(function() {
        $("#button_save_topic").on("click", function() {
            if ($("#input_topic_name").val().length == 0)
            {
                //alert("Topic name is required.");
                var message = "Topic name is required.";
            print_common_message(message);
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/contact_us/create_topic",
                data: {
                    input_topic_name: $("#input_topic_name").val()
                },
                success: function(data) {
                    //alert(data.message);
                     var message = data.message;
                    print_common_message(message);
                    window.location = '<?php echo base_url();?>admin/contact_us/manage_topic';
                }
            });
        });
    });

</script>
<div class="modal fade" id="modal_create_topic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Topic</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Topic Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_topic_name" name="input_topic_name" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_save_topic" name="button_save_topic" value="" class="form-control btn button-custom pull-right">Create</button>
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
