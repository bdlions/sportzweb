<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/healthy_recipe.css">
<div class="row top-row-padding  top-row-design">
    <div class="col-md-12">
        <div class="reciepe-menu heading_medium_thin">
            <a href="<?php echo base_url() . 'applications/healthy_recipes' ?>">Home</a>
            <?php if (count($recipe_menu) > 0) : ?>
                <?php foreach ($recipe_menu as $menu): ?>
                    <a style="padding-left: 15px;" href="<?php echo base_url() . 'applications/healthy_recipes/recipe_category/' . $menu['id']; ?>"><?php echo $menu['description']; ?></a> 
                <?php endforeach; ?>
            <?php endif; ?>
            <a style="padding-left: 15px;" href="<?php echo base_url() . 'applications/healthy_recipes/recipe_category_letters' ?>">A-Z</a>
        </div>
    </div>
</div>