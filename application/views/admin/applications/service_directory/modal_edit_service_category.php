<!-- Written by Omar -->
<script type="text/javascript">
    $(function() {
        $("#button_save_service_category_edit").on("click", function() {
            if ($("#input_service_category_name_for_edit").val().length == 0)
            {
                alert("Service Category name is required.");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_servicedirectory/edit_service_category",
                data: {
                    service_category_name: $("#input_service_category_name_for_edit").val(),
                    service_category_id: $("#input_service_category_id").val()
                },
                success: function(data) {
                    alert(data['message']);
                    console.log(data);
                    if (data['status'] === 1)
                    {
                        $("#service_desc_" + data['service_category_info']['id']).text(data['service_category_info']['description']);
                        $("#modal_edit_service_category").modal('hide');
                    }
                }
            });
        });
    });
</script>
<!-- Written by Omar -->
<script type="text/javascript">
function openModal(val,id) {
    $.ajax({
        dataType: 'json',
        type: "POST",
        url: '<?php echo base_url(); ?>' + "admin/applications_servicedirectory/get_service_data",
        data: {
            service_category_id: id
        },
        success: function(data) {
            $('#input_service_category_id').val(data['id']);
            $('#input_service_category_name_for_edit').val(data['description']);
            $('#modal_edit_service_category').modal('show');
        }
    });
}
</script> 
<div class="modal fade" id="modal_edit_service_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit Service Category</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Service Category Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_service_category_name_for_edit" name="input_service_category_name_for_edit" value="" type="text" class="form-control"/>
                            <input id="input_service_category_id" name="input_service_category_id" value="" type="hidden" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_save_service_category_edit" name="button_save_service_category_edit" value="" class="form-control btn button-custom pull-right">Update</button>
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
