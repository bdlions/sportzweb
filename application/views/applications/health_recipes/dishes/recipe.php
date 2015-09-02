<style>
    .cookbook-recommend {
        float: left;
        padding: 5px;
        text-align: left;
        width: 180px;
        color: #000000;
        font-size: 1.5em;
        line-height: 1em;
    }
</style>

<script>
    $(function() {
        $("#button_share_recipe").on("click", function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "share/share_application",
                dataType: 'json',
                data: {
                    status_category_id: '<?php echo STATUS_CATEGORY_USER_NEWSFEED ?>',
                    description: $("#text_share").val(),
                    shared_type_id: '<?php echo STATUS_SHARE_HEALTHY_RECIPE ?>',
                    reference_id: <?php echo $recipe_item['id'] ?>
                },
                success: function(data) {
                    window.location = '<?php echo base_url() ?>';
                }
            });
        });
    });
</script>


<!-- Modal -->
<div class="modal fade" id="share_recipe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalLabel">Share this recipe</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6"><img src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_item['main_picture']; ?>" class="img-responsive" alt="<?php echo $recipe_item['title']; ?>"/></div>
                    <div class="col-md-6"><h4><?php echo $recipe_item['title']; ?></h4><?php echo $recipe_item['title']; ?></div>
                    <div class="col-md-12" style="padding-top: 24px; padding-bottom: 0px"><textarea id="text_share" name="text_share" style="height: 128px; width: 100%; resize: none;"></textarea></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="button_share_recipe" name="button_share_recipe" class="btn btn-primary" data-dismiss="modal"><b>Share</b></button>
            </div>
        </div>
    </div>
</div>
<?php $recipe_id = $recipe_item['id']; ?>
<?php $this->load->view("applications/health_recipes/templates/header_row"); ?>
<div class="col-md-9">
    <div class="row grayborderbottom grayborderleft grayborderright" >
        <?php if(isset($recipe_item['reference_id'])){?>
        <div class="col-md-2">
            <div class="row">
                <div class="col-md-12">
                    <img class="recipe_item_logo" src="<?php echo base_url().APP_ITEM_REFERENCE_IMAGE_PATH.$recipe_item['reference_image']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php echo $recipe_item['reference_link'];?>                    
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="col-md-10 heading_big heading_big_alignment">
            <?php echo $recipe_item['title']; ?>
        </div>
    </div>
    <div class="row grayborderbottom grayborderleft grayborderright">
        <div class="col-md-9 grayborderright">
            <img src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_item['main_picture']; ?>" class="img-responsive" style="margin: 20px; margin-left: 0px;" alt="<?php echo $recipe_item['title']; ?>"/>
        </div>
        <div class="col-md-3 ">
            <div class="row cus_command_buttons">
                <a data-toggle="modal" data-target="#share_recipe">
                    <img style="width:40px;height:40px;" src="<?php echo base_url(); ?>resources/images/share.png">
                </a>
                <a onclick="javascript:window.print();" href="">
                    <img style="width:40px;height:40px;" src="<?php echo base_url(); ?>resources/images/print.png">
                </a>
            </div>

            <h2 class="heading_medium">Durations</h2>
            <div class="content_text"><?php echo html_entity_decode(html_entity_decode($recipe_item['duration'])); ?></div>
        </div>
    </div>
    <div class="row grayborderbottom grayborderleft grayborderright">
        <div class="col-md-4 grayborderright">
            <h2  class="heading_medium">Ingredients</h2>
            <div class="content_text">
                <?php echo html_entity_decode(html_entity_decode($recipe_item['ingredients'])); ?>
            </div>
        </div>
        <div class="col-md-8">
            <h2  class="heading_medium">Preparation method</h2>            
            <div class="content_text">
                <?php echo html_entity_decode(html_entity_decode($recipe_item['preparation_method'])); ?> 
            </div>
        </div>
    </div>
    <div class="row grayborderbottom grayborderleft grayborderright">
        <div class="col-md-12">
            <h2 style="color: #333333;">Recommend Desserts</h2>
            <?php if (!empty($recommend_desserts_item)): ?>
                <?php foreach ($recommend_desserts_item as $recommend_item): ?>
                    <!--<h4>
                        <a style="font-size:16px;color:#B97A57;text-decoration:underline;" href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recommend_item['id']; ?>">
                    <?php echo $recommend_item['title']; ?>
                        </a>
                    </h4>-->
                    <div class="cookbook-recommend">
                        <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recommend_item['id']; ?>">
                            <?php if (!empty($recommend_item['main_picture'])): ?>
                                <img style="padding-top:15px;padding-bottom:10px;width: 160px;height: 120px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recommend_item['main_picture']; ?>" class="img-responsive" alt="<?php echo $recommend_item['title']; ?>"/>
                                <?php echo $recommend_item['title']; ?>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row grayborderbottom grayborderleft grayborderright">
        <div class="col-md-12">
            <h2 class="heading_medium">Alternative Recipes</h2>

            <?php if (!empty($alternative_recipes_item)): ?>
                <?php foreach ($alternative_recipes_item as $alternative_item): ?>
                    <div class="cookbook-recommend">
                        <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $alternative_item['id']; ?>">
                            <?php if (!empty($alternative_item['main_picture'])): ?>
                                <img style="padding-top:15px;padding-bottom:10px;width: 160px;height: 120px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $alternative_item['main_picture']; ?>" class="img-responsive" alt="<?php echo $recommend_item['title']; ?>"/>
                                <?php echo $alternative_item['title']; ?>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php $this->load->view("applications/comments"); ?>
</div>
<div class="col-md-3">

</div>
