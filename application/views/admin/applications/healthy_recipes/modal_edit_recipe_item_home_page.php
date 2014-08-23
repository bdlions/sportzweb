<script type="text/javascript">
    $(function() {
        $("#button_save_recipe").on("click", function() {
            var selected_array = Array();
            var recipe_id;
            $("#tbody_recipe_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {
                    if (this.checked == true)
                    {
                        selected_array.push(this.id);
                        recipe_id = this.id;
                    }
                });
            });

            if(selected_array.length == 1) {
                var present_value = $('#get_selected_id').val();

                var id = '#position_of_recipe_'+present_value;  
                var position = $(id+"").val(recipe_id);

                var value_top_left = $('#position_of_recipe_1').val();
                var value_top_right = $('#position_of_recipe_2').val();
                var value_bottom_left = $('#position_of_recipe_3').val();
                var value_bottom_right = $('#position_of_recipe_4').val();
                var value_bottom_up = $('#position_of_recipe_5').val();
                var value_bottom_down = $('#position_of_recipe_6').val();
                var value_bottom_down_extra = $('#position_of_recipe_7').val();
                
                if(present_value == 1 &&( recipe_id == value_top_right || recipe_id == value_bottom_left || recipe_id == value_bottom_right || recipe_id == value_bottom_up || recipe_id == value_bottom_down || recipe_id == value_bottom_down_extra)) {
                    alert('This item is already selected in one position');
                    return;
                } else if(present_value ==2 && (recipe_id == value_top_left || recipe_id == value_bottom_left || recipe_id == value_bottom_right || recipe_id == value_bottom_up || recipe_id == value_bottom_down || recipe_id == value_bottom_down_extra)) {
                   alert('This item is already selected in one position');
                   return;
                }else if(present_value ==3 && (recipe_id == value_top_left || recipe_id == value_top_right || recipe_id == value_bottom_right || recipe_id == value_bottom_up || recipe_id == value_bottom_down || recipe_id == value_bottom_down_extra)) {
                    alert('This item is already selected in one position');
                    return;
                }else if(present_value ==4 && (recipe_id == value_top_left || recipe_id == value_top_right || recipe_id == value_bottom_left || recipe_id == value_bottom_up || recipe_id == value_bottom_down || recipe_id == value_bottom_down_extra)){
                    alert('This item is already selected in one position');
                    return;
                }else if(present_value ==5 && (recipe_id == value_top_left || recipe_id == value_top_right || recipe_id == value_bottom_left || recipe_id == value_bottom_right || recipe_id == value_bottom_down || recipe_id == value_bottom_down_extra)){
                    alert('This item is already selected in one position');
                    return;
                }else if(present_value ==6 && (recipe_id == value_top_left || recipe_id == value_top_right || recipe_id == value_bottom_left || recipe_id == value_bottom_up || recipe_id == value_bottom_right || recipe_id == value_bottom_down_extra)){
                    alert('This item is already selected in one position');
                    return;
                }else if(present_value ==7 && (recipe_id == value_top_left || recipe_id == value_top_right || recipe_id == value_bottom_left || recipe_id == value_bottom_up || recipe_id == value_bottom_right || recipe_id == value_bottom_down)){
                    alert('This item is already selected in one position');
                    return;
                }
                
                
                
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "admin/healthyrecipes/get_selected_recipe_data",
                    data: {
                        recipe_id: recipe_id
                    },
                    success: function(data) {
                        var img_position = $("#image_position_" + present_value);
                        if(img_position != undefined){
                            img_position.attr("src", "<?php echo base_url().HEALTHY_RECIPES_IMAGE_PATH;?>" + data.main_picture.replace(/(\r\n|\n|\r)/gm,""));
                        }
                        
                        var title = $("#title_" + present_value);
                        if(title != undefined){
                            title.text(data.title);
                        }
                        
                        var description_ = $("#description_" + present_value);
                        if(description_ != undefined){
                            description_.text(data.description);
                        }
                    }
                });
                $('#modal_edit_recipe_item_home_page').modal('hide');
            } else {
                alert('You can only select one recipe for this position');
                return ;
            }
           
        });
    });
</script>
<div class="modal fade" id="modal_edit_recipe_item_home_page" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Recipe List</h4>
            </div>
            <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Check box</th>
                                    <th>Name</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            
                            <tbody id="tbody_recipe_list">
                            <?php foreach ($recipes_list as $key => $recipe) :?>
                                <tr>
                                    <td><input id="<?php echo $recipe['id'] ?>" name="checkbox[]" class="" type="checkbox" /></td>
                                    <td id="<?php echo $recipe['id'] ?>"><?php echo $recipe['title'] ?></td>
                                    <td id="<?php echo $recipe['id'] ?>"><?php echo $recipe['description'] ?></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row form-group">
                        
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button id="button_save_recipe" name="button_save_recipe" value="" class="btn button-custom">Save</button>
               
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
