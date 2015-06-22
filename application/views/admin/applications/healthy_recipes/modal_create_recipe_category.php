<script type="text/javascript">
    $(function() {
        $("#button_save_recipe_category").on("click", function() {
            if ($("#input_recipe_category_name").val().length == 0)
            {
                //alert("Recipe Category name is required.");
                var message = "Recipe Category name is required.";
                   print_common_message(message);
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_healthyrecipes/create_recipe_category",
                data: {
                    recipe_category_name: $("#input_recipe_category_name").val()
                },
                success: function(data) {
                   // alert(data['message']);
                   var message = data['message'];
                   print_common_message(message);
                    if (data['status'] === 1)
                    {                        
                        //$("#tbody_recipes_category_list").html($("#tbody_recipes_category_list").html()+tmpl("tmpl_recipes_category_list",  data['recipe_category_info']));
                        //$('#modal_create_recipe_category').modal('hide');
                        window.location.reload();
                    }
                    
                }
            });
        });
    });

</script>
<div class="modal fade" id="modal_create_recipe_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Recipe Category</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Recipe Category Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_recipe_category_name" name="input_recipe_category_name" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_save_recipe_category" name="button_save_recipe_category" value="" class="form-control btn button-custom pull-right">Create</button>
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
