<!-- Written by Omar -->
<script type="text/javascript">
    $(function () {
        $("#button_save_recipe_category_edit").on("click", function () {
            if ($("#input_recipe_category_name_for_edit").val().length == 0)
            {
               // alert("Recipe Category name is required.");
               var message = data['message'];
               print_common_message(message);
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_healthyrecipes/edit_recipe_category",
                data: {
                    recipe_category_name: $("#input_recipe_category_name_for_edit").val(),
                    recipe_category_id: $("#input_recipe_category_id").val()
                },
                success: function (data) {
                    $("#content").html(data['message']);
                    $('#common_modal').modal('show');
//                     (data['message']);
                    if (data['status'] === 1)
                    {
                        $("#recipe_desc_" + data['recipe_category_info']['id']).text(data['recipe_category_info']['description']);
                        $("#modal_edit_recipe_category").modal('hide');
                    }
                }
            });
        });
    });
</script>

<script type="text/javascript">
    function open_modal_edit_recipe_category(recipe_category_id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_healthyrecipes/get_recipe_data",
            data: {
                recipe_category_id: recipe_category_id
            },
            success: function (data) {
                $('#input_recipe_category_id').val(data['id']);
                $('#input_recipe_category_name_for_edit').val(data['description']);
                $('#modal_edit_recipe_category').modal('show');
            }
        });
    }
</script> 
<div class="modal fade" id="modal_edit_recipe_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit Recipe Category</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Recipe Category Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_recipe_category_name_for_edit" name="input_recipe_category_name_for_edit" value="" type="text" class="form-control"/>
                            <input id="input_recipe_category_id" name="input_recipe_category_id" value="" type="hidden" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_save_recipe_category_edit" name="button_save_recipe_category_edit" value="" class="form-control btn button-custom pull-right">Update</button>
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
<?php $this->load->view("common/common_modal"); ?>
