<script type="text/javascript">
    $(function() {
        $("#button_save_recipe").on("click", function() {
            var selected_value = $( "#selected_recipes_category option:selected").val();
            if(selected_value== 0)
            {
                alert("Please select a recipe category name.");
                return;
            }
            if ($("#input_recipe_name").val().length == 0)
            {
                alert("Recipe name is required.");
                return;
            }
            
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/application/create_recipe",
                data: {
                    recipe_name: $("#input_recipe_name").val(),
                    recipes_category_id: selected_value
                },
                success: function(data) {
                    alert(data['message']);
                    if (data['status'] === 1)
                    {                        
                        $("#tbody_tournament_list").html($("#tbody_tournament_list").html()+tmpl("tmpl_tournament_list",  data['tournament_info']));
                        $("#modal_create_tournament").modal('hide');
                    }
                }
            });
        });
    });

</script>
<div class="modal fade" id="modal_create_recipe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Recipe</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Recipe Category:</label>
                        <div class ="col-sm-4">
                            <select class="form-control col-sm-12 " name="selected_recipes_category" id="selected_recipes_category">
                                <option selected="selected" value="0">Select</option>
                                <?php foreach($recipes_category_list as $recipes_category):?>
                                <option value="<?php echo $recipes_category['id']; ?>"><?php echo $recipes_category['description']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Recipe Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_recipe_name" name="input_recipe_name" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_save_recipe" name="button_save_recipe" value="" class="form-control btn button-custom pull-right">Create</button>
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
