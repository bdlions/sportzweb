<script type="text/javascript">
    $(function() {
        $("#button_save_related_blogs").on("click", function() {
            var selected_array = Array();
            $("#tbody_related_blog_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {
                    if (this.checked == true)
                    {
                        selected_array.push(this.id);
                    }
                });
            });
            $('#related_blogs').val(selected_array);
            $('#modal_related_blogs').modal('hide');
        });
    });
</script>
<div class="modal fade" id="modal_related_blogs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Related Blogs </h4>
            </div>
            <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Check box</th>
                                    <th>Blog Title</th>
                                </tr>
                            </thead>
                            
                            <tbody id="tbody_related_blog_list">
                            <?php foreach ($all_blog_lists as $key => $blog) :?>
                                <tr>
                                    <?php if(!empty($selected_blog_data_array)) :?>
                                        <?php if(in_array($blog['id'], $selected_blog_data_array)) : ?>
                                            <td><input id="<?php echo $blog['id'] ?>" checked="true" name="checkbox[]" class="" type="checkbox" /></td>
                                        <?php else: ?>
                                            <td><input id="<?php echo $blog['id'] ?>" name="checkbox[]" class="" type="checkbox" /></td>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <td><input id="<?php echo $blog['id'] ?>" name="checkbox[]" class="" type="checkbox" /></td>
                                    <?php endif; ?>
                                    
                                    <td id="<?php echo $blog['id'] ?>"><?php echo html_entity_decode(html_entity_decode($blog['title'])); ?></td>
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
                        <button id="button_save_related_blogs" name="button_save_related_blogs" value="" class="form-control btn button-custom pull-right">Save</button>
                    </div>
                    <div class ="col-sm-3">
                        <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
                    </div>
                </div>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
