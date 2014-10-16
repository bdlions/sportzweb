<script type="text/javascript">
//    TANVEER
    function showmodal(browser_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/contact_us/get_browser_info",
            data: {
                browser_id: browser_id
            },
            success: function(data) {
                $('#input_browser_name_for_edit').val(data.browser_info['title']);
                $("#browser_id_data").val(browser_id);
                $('#modal_edit_browser').modal('show');
            }
        });        
    }
    function showmodaldel(del_item_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/contact_us/get_browser_info",
            data: {
                browser_id: del_item_id
            },
            success: function(data) {
                $('#delete_name').html(data.browser_info['title']);
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
                url: '<?php echo base_url(); ?>' + "admin/contact_us/delete_browser",
                data: {
                    del_id: $("#delete_id_data").val()
                },
                success: function(data) {
                    alert(data.message); 
                    $('#modal_delete').modal('hide');
                    window.location = '<?php echo base_url();?>admin/contact_us/manage_browser';
                }
            });
    }
    
//    <!-- Written by Omar -->
    $(function() {
        $("#button_save_browser_edit").on("click", function() {
            if ($("#input_browser_name_for_edit").val().length == 0)
            {
                alert("Browser name is required.");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/contact_us/edit_browser",
                data: {
                    new_browser_name: $("#input_browser_name_for_edit").val(),
                    browser_id: $("#browser_id_data").val()
                },
                success: function(data) {
                    alert(data.message); 
                    $('#modal_edit_browser').modal('hide');
                    window.location = '<?php echo base_url();?>admin/contact_us/manage_browser';
                }
            });
        });
    });
</script>
<!-- Written by Omar -->
<script type="text/javascript">
function openModal(val,id) {
    
}
</script> 
<div class="modal fade" id="modal_edit_browser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit Browser</h4>
                <input id="browser_id_data" type="hidden" value="">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Browser Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_browser_name_for_edit" name="input_browser_name_for_edit" value="" type="text" class="form-control"/>
                            <input id="input_browser_id" name="input_browser_id" value="" type="hidden" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_save_browser_edit" name="button_save_browser_edit" value="" class="form-control btn button-custom pull-right">
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
                <h4 class="modal-title" id="myModalLabel">Delete Browser: <span id="delete_name"></span></h4>
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