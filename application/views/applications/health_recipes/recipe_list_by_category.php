<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
    <?php $this->load->view("applications/health_recipes/templates/header_row"); ?>
<script type="text/javascript">
    //    active a particular menu item
    $(function() {
        $('.nav a').filter(function() {
            return this.href == location.href
        }).parent().addClass('active_health_recipes_item').siblings().removeClass('active_health_recipes_item')
    });
</script>
<div class="col-md-9">
    <div class="row graybordertop grayborderbottom grayborderleft grayborderright" >
        <h3><?php echo isset($recipe_category_info['description']) ? $recipe_category_info['description'] : ''; ?></h3>
    </div>
    <?php if (count($results) > 0) : ?>
        <?php foreach ($results as $result) : ?>
            <div class="row graybordertop grayborderbottom grayborderleft grayborderright">        
                <!--Dynamic contents-->
                <div class="col-md-3 grayborderright">
                    <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $result['id']; ?>">
                        <img style="width: 180px;height: 100px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $result['main_picture']; ?>" class="img-responsive" alt="<?php echo $result['title']; ?>"/>
                    </a>
                </div>
                <div class="col-md-9 health_recipes_sub_menu_item">
                    <div class="row form-group"></div>
                    <a class="reciepe_title heading_small" href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $result['id']; ?>">
                        <?php echo $result['title']; ?>
                    </a>
                    <div class="row form-group"></div>
                    <div class="content_text">
                        <?php echo substr($result['description'], 0, RECIPE_BY_CATEGORY_DESCRIPTION_LENGTH); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</div>
<div class="col-md-3">

</div>