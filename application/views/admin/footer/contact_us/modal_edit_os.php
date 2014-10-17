<script type="text/javascript">
    function showmodal(os_id)
    {
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: '<?php echo base_url(); ?>' + "admin/contact_us/get_os_info",
            data: {
                os_id: os_id
            },
            success: function(data) {
                $('#input_os_name_for_edit').val(data.os_info['title']);
                $("#os_id_data").val(os_id);
                $('#modal_edit_os').modal('show');
            }
        });
    }
    function showmodaldel(del_item_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/contact_us/get_os_info",
            data: {
                os_id: del_item_id
            },
            success: function(data) {
                $('#delete_name').html(data.os_info['title']);
                $("#delete_id_data").val(del_item_id);
                $('#modal_delete').modal('show');
            }
        });        
    }
    function delete_item()
    {
        $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/contact_us/delete_operaging_system",
                data: {
                    del_id: $("#delete_id_data").val()
                },
                success: function(data) {
                    alert(data.message); 
                    $('#modal_delete').modal('hide');
                    window.location = '<?php echo base_url();?>admin/contact_us/manage_os';
                }
            });
    }
            
//            <!-- Written by Omar -->
    $(function() {
        $("#button_save_os_edit").on("click", function() {
            if ($("#input_os_name_for_edit").val().length == 0)
            {
                alert("Topic name is required.");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/contact_us/edit_os",
                data: {
                    new_os_name: $("#input_os_name_for_edit").val(),
                    os_id: $("#os_id_data").val()
                },
                success: function(data) {
                    
                }
            });
        });
    });
</script>

<div class="modal fade" id="modal_edit_os" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit Operating System</h4>
                <input id="os_id_data" type="hidden" value="">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Operating System Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_os_name_for_edit" name="input_os_name_for_edit" value="" type="text" class="form-control"/>
                            <!--<input id="input_os_id" name="input_os_id" value="" type="hidden" class="form-control"/>-->
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_save_os_edit" name="button_save_os_edit" value="" class="form-control btn button-custom pull-right">
                                Update
                            </button>
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




<div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete OS: <span id="delete_name"></span></h4>
                <input id="delete_id_data" type="hidden" value="">
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class ="col-sm-6">
                        Are you sure you want to delete?
                    </div>
                    <div class ="col-sm-3">
                        <button onclick="delete_item()" value="" class="btn button-custom pull-right">
                            Delete
                        </button>
                    </div>
                    <div class ="col-sm-3">
                        
                        <button type="button" class="btn button-custom" data-dismiss="modal">Cancel</button>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->