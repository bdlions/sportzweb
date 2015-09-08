<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/healthy_recipe.css">
<script type="text/javascript">
    //    active a particular menu item
    $(function() {
        $('.nav a').filter(function() {
            return this.href == location.href
        }).parent().addClass('active_health_recipes_item').siblings().removeClass('active_health_recipes_item')
    });
</script>
<nav class="navbar navbar-default health_recipes_header_menu">
    <div class="container-fluid app_header_bg">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#health_recipes_header_menu_item" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse reciepe-menu" id="health_recipes_header_menu_item">
            <ul class="nav navbar-nav heading_medium_thin">
                <li><a href="<?php echo base_url() . 'applications/healthy_recipes' ?>">Home</a></li>

                <?php if (count($recipe_menu) > 0) : ?>
                    <?php foreach ($recipe_menu as $menu): ?>
                        <li
                        <?php
                        if (isset($recipe_item) && $recipe_item['recipe_category_id'] == $menu['id']) {
                            echo 'class="active_health_recipes_item"';
                        }
                        ?>
                            ><a 
                                style="padding-left: 15px; " href="<?php echo base_url() . 'applications/healthy_recipes/recipe_category/' . $menu['id']; ?>"><?php echo $menu['description']; ?></a> </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <li><a style="padding-left: 15px;" href="<?php echo base_url() . 'applications/healthy_recipes/recipe_category_letters' ?>">A-Z</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>