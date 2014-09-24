<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
<?php $this->load->view("applications/health_recipes/templates/header_row"); ?>
<div class="col-md-9">
    <div class="row grayborderbottom grayborderleft grayborderright" >
        <h3><?php echo isset($recipe_category_info['description']) ? $recipe_category_info['description'] : ''; ?></h3>
    </div>
    <?php if (count($results) > 0) : ?>
        <?php foreach ($results as $result) : ?>
            <div class="row grayborderbottom grayborderleft grayborderright">        
                <!--Dynamic contents-->
                <div class="col-md-3 grayborderright">
                    <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $result['id']; ?>">
                        <img style="width: 180px;height: 100px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $result['main_picture']; ?>" class="img-responsive" alt="<?php echo $result['title']; ?>"/>
                    </a>
                </div>
                <div class="col-md-9">
                    <a style="font-size:16px;color:#B97A57;text-decoration:underline;" href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $result['id']; ?>">
                        <?php echo $result['title']; ?>
                    </a>
                    <div style="margin-top:10px;font-size:14px;line-height:120%;">
                        <?php echo $result['description']; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</div>
<div class="col-md-3">

</div>