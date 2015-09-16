<script type="text/javascript">
    $(function() {
        $("#button_save_recommend_recipe").on("click", function() {
            var selected_array = Array();
            $("#tbody_recommend_resserts_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {

                    if (this.checked == true)
                    {
                        selected_array.push(this.id);
                    }
                });
            });
            $('#recommend_resserts').val(selected_array);
            $('#modal_recommand_recipe').modal('hide');
        });
    });
</script>
<div class="modal fade" id="modal_recommand_recipe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Recommend Desserts </h4>
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
                            
                            <tbody id="tbody_recommend_resserts_list">
                            <?php foreach ($recipes_list as $key => $recipe) :?>
                                <tr>
                                    <?php if(!empty($recommend_desserts_data_array)) :?>
                                        <?php if(in_array($recipe['id'], $recommend_desserts_data_array)) : ?>
                                        <td><input id="<?php echo $recipe['id'] ?>" checked="true" name="checkbox[]" class="" type="checkbox" /></td>
                                        <?php else: ?>
                                        <td><input id="<?php echo $recipe['id'] ?>" name="checkbox[]" class="" type="checkbox" /></td>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <td><input id="<?php echo $recipe['id'] ?>" name="checkbox[]" class="" type="checkbox" /></td>
                                    <?php endif; ?>
                                    
                                    <td id="<?php echo $recipe['id'] ?>"><?php echo $recipe['title'] ?></td>
                                    <td id="<?php echo $recipe['id'] ?>"><?php echo $recipe['description'] ?></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <div class="row form-group">
                    <div class ="col-sm-6"></div>
                    <div class ="col-sm-3">
                        <button id="button_save_recommend_recipe" name="button_save_recommend_recipe" value="" class="form-control btn button-custom pull-right">Save</button>
                    </div>
                    <div class ="col-sm-3">
                        <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
                    </div>
                </div>                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
