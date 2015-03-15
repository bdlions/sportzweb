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
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/common_styles.css">

<?php $recipe_id = $recipe_item['id'];?>
<div class="col-md-9">
    <div class="row grayborderbottom grayborderleft grayborderright" >
        <span style="color: #333333;"><h1 class="heading_big"><?php echo $recipe_item['title']; ?></h1></span>
    </div>
    <div class="row grayborderbottom grayborderleft grayborderright">
        <div class="col-md-9 grayborderright">
            <img src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_item['main_picture']; ?>" class="img-responsive" style="margin: 20px; margin-left: 0px;" alt="<?php echo $recipe_item['title']; ?>"/>
        </div>
        <div class="col-md-3 ">
            <h2 style="color: #333333;" class="heading_medium">Durations</h2>
            <span class="content_text"><?php echo html_entity_decode(html_entity_decode($recipe_item['duration'])); ?> </span>
        </div>
    </div>
    <div class="row grayborderbottom grayborderleft grayborderright">
        <div class="col-md-4 grayborderright">
            <h2 style="color: #333333;" class="heading_medium">Ingredients</h2>
            <span class="content_text"><?php echo html_entity_decode(html_entity_decode($recipe_item['ingredients'])); ?> </span>
        </div>
        <div class="col-md-8">
            <h2 style="color: #333333;" class="heading_medium">Preparation method</h2>            
            <span class="content_text"><?php echo html_entity_decode(html_entity_decode($recipe_item['preparation_method'])); ?>  </span>
        </div>
    </div>
    <div class="row grayborderbottom grayborderleft grayborderright">
        <div class="col-md-12">
            <h2 style="color: #333333;" class="heading_medium">Recommend Desserts</h2>
            <?php if (!empty($recommend_desserts_item)): ?>
                <?php foreach ($recommend_desserts_item as $recommend_item): ?>
                    <!--<h4>
                        <a style="font-size:16px;color:#B97A57;text-decoration:underline;" href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recommend_item['id']; ?>">
                    <?php echo $recommend_item['title']; ?>
                        </a>
                    </h4>-->
                    <div class="cookbook-recommend">
                        <a href="<?php echo base_url() . 'admin/applications_healthyrecipes/recipes/' . $recommend_item['id']; ?>">
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
            <h2 style="color: #333333;" class="heading_medium">Alternative Recipes</h2>

            <?php if (!empty($alternative_recipes_item)): ?>
                <?php foreach ($alternative_recipes_item as $alternative_item): ?>
                    <div class="cookbook-recommend">
                        <a href="<?php echo base_url() . 'admin/applications_healthyrecipes/recipes/' . $alternative_item['id']; ?>">
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
     <?php $this->load->view("admin/applications/comments"); ?>
</div>
<div class="col-md-3">

</div>
