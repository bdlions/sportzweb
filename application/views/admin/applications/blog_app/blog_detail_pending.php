<div class="panel panel-default">
    <div class="panel-heading"><?php echo html_entity_decode(html_entity_decode($blog_detail['title'])); ?></div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row">
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                        <div class="col-sm-6"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6">
                            <h4><div class="pull-right">
                                Category: 
                            </div></h4>
                        </label>
                        <div class="col-sm-2">
                                <?php echo form_dropdown('category_id', $category_id, $selected_category_id, 'class=form-control id=dropdown'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <h3><label class="col-sm-6"><div class="pull-right">Title : </div></label>
                        <div class="col-sm-6"><?php echo html_entity_decode(html_entity_decode($blog_detail['title'])); ?></div></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <h4><label class="col-sm-6"><div class="pull-right">Description : </div></label>
                        <div class="col-sm-6"><?php echo html_entity_decode(html_entity_decode($blog_detail['description'])); ?></div></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <h4><label class="col-sm-6"><div class="pull-right">Picture : </div></label></h4>
                        <div class="col-sm-6">
                            <img style="width: 150px; height: 150px;" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_detail['picture']; ?>" class="img-responsive"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <h4><label class="col-sm-6"><div class="pull-right">Created : </div></label>
                            <div class="col-sm-6"><?php echo unix_to_human($blog_detail['created_on']); ?></div></h4>
                    </div>
                </div>
                <div class="btn-group" style="padding-left: 25px;">
                    <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    $(function() {
        $("#dropdown").on("change", function() {
            
            var category_id = $("#dropdown").val();
            var blog_id = <?php echo $blog_id;?>;
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + 'admin/applications_blogs/update_pending_blog',
                data: { 
                    category_id : category_id, 
                    blog_id : blog_id
                },
                success: function(data) {
                 //   alert('Category updated successfully');
                   var message = "Category updated successfully";
                   print_common_message(message);
                }
            });
        });
    });
</script>