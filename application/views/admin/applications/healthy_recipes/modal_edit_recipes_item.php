<script type="text/javascript">
    $(function() {
        $("#button_save_recipes_list").on("click", function() {
            var selected_array = Array();
            $("#tbody_recipes_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {
                    if (this.checked == true)
                    {
                        selected_array.push(this.id);
                    }
                });
            });
            
            if(selected_array.length > 0) {
                $('#recipes_list_after_select').val(JSON.stringify(selected_array));
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "admin/applications_healthyrecipes/get_selected_recipes_list",
                    data: {
                        selected_recipes_item: JSON.stringify(selected_array),
                    },
                    success: function(data) {
                       var htmlText = "";
                        for(var i = 0; i < data.length; i ++){
                            var title = data[ i ].title;
                            htmlText += '<a class="recipe_a_list" >'+
                            title +
                            '</a>' +
                            '<br>';
                        }
                        
                        $("#show_recipes_after_select").html(htmlText);
                    }
                });
                $('#modal_edit_recipes').modal('hide');
            } else {
                alert('You have to select at least one item for your recipes');
                return ;
            }
           
        });
    });
</script>
<div class="modal fade" id="modal_edit_recipes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                            
                            <tbody id="tbody_recipes_list">
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
                    
                    <!--<div class="row form-group">
                        <div class ="col-sm-3 pull-right">
                            <button id="button_save_recipes_list" name="button_save_recipes_list" value="" class="form-control btn button-custom pull-right">Save</button>
                        </div>
                    </div>-->
                </div>                
            </div>
            <div class="modal-footer">
                 <button id="button_save_recipes_list" name="button_save_recipes_list" value="" class="btn button-custom">Save</button>
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
