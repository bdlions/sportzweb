<?php $this->load->view("applications/health_recipes/templates/header_row"); ?>
<?php if ($show_advertise) { ?>
    <div class="col-md-9 grayborderbottom" style="border-left: 2px solid #E7E7E7; border-right: 2px solid #E7E7E7; ">
    <?php } else { ?>
        <div class="col-md-12 grayborderbottom" style="border-left: 2px solid #E7E7E7; border-right: 2px solid #E7E7E7; ">
        <?php } ?>
        <div class="row">
            <?php if ($show_advertise) { ?>
                <div class="col-md-12">
                <?php } else { ?>
                    <div class="col-md-9">
                    <?php } ?>
                    <div class="row">
                        <?php if (count($recipe_view_list_item) > 1): ?>
                            <div class="col-md-8 grayborderbottom grayborderright">
                                <?php if (array_key_exists(0, $recipe_view_list_item)) : ?>
                                    <?php if (!empty($recipe_view_list_item[0]['main_picture'])): ?>
                                        <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe_view_list_item[0]['id']; ?>">
                                            <img src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[0]['main_picture']; ?>" alt="<?php echo $recipe_view_list_item[0]['title']; ?>" class="img-responsive" style="width:100%; padding-right:12px;"/>
                                        </a>
                                    <?php endif; ?>
                                    <p class="image-caption reciepe_title heading_medium_thin" style="color: #7092BE"><?php echo (!empty($recipe_view_list_item[0]['title'])) ? $recipe_view_list_item[0]['title'] : ''; ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <img src="<?php echo base_url(); ?>resources/images/quote.png" class="img-responsive" alt=""/>
                                <?php if (array_key_exists(1, $recipe_view_list_item)) : ?>
                                    <a style="color: red" href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe_view_list_item[1]['id']; ?>">
                                        <h2 class="reciepe_title heading_medium_thin"><?php echo (!empty($recipe_view_list_item[1]['title'])) ? $recipe_view_list_item[1]['title'] : ''; ?></h2>
                                    </a>

                                    <span class="recipe_description content_text">
                                        <?php echo $recipe_view_list_item[1]['description']; ?>
                                    </span>

                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <?php if (count($recipe_view_list_item) >= 3): ?>
                            <div class="col-md-3 grayborderbottom">
                                <?php if (array_key_exists(2, $recipe_view_list_item)) : ?>
                                    <img src="<?php echo base_url(); ?>resources/images/quote.png" class="img-responsive" alt=""/>
                                    <a style="color: red" href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe_view_list_item[2]['id']; ?>">
                                        <h4 class="reciepe_title heading_medium_thin"><?php echo (!empty($recipe_view_list_item[2]['title'])) ? $recipe_view_list_item[2]['title'] : ''; ?></h4>
                                    </a>
                                    <span class="recipe_description content_text">
                                        <?php echo $recipe_view_list_item[2]['description']; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-4 grayborderbottom grayborderleft">
                            <div class="purp_style_header purp_style_header_custom">
                                <div class="col-md-12 purp_style heading_medium_thin">
                                    Recipes
                                </div>
                            </div>  
                            <?php if (count($recipe_list_item) > 0): ?>
                                <?php foreach ($recipe_list_item as $key => $value): ?>
                                    <a class="reciepe_title content_text" href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $value['id']; ?>">
                                        <?php echo $value['title']; ?>
                                    </a>
                                    <br>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                        <div class="col-md-5 graybordertop grayborderbottom grayborderleft">
                            <?php if (array_key_exists(3, $recipe_view_list_item)) : ?>
                                <?php if (!empty($recipe_view_list_item[3]['main_picture'])): ?>
                                    <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe_view_list_item[3]['id']; ?>">
                                        <img src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[3]['main_picture']; ?>" alt="<?php echo $recipe_view_list_item[3]['title']; ?>" class="img-responsive" style="position: relative; top:5px;"/>
                                    </a>
                                <?php endif; ?>
                                <p class="reciepe_title heading_medium_thin" style="color: #7092BE; margin: 10px 0 15px 0;"><?php echo (!empty($recipe_view_list_item[3]['title'])) ? $recipe_view_list_item[3]['title'] : ''; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if (!$show_advertise) { ?>
                    <div class="col-md-3 grayborderleft" style="padding-left: 20px; padding-right: 0px;">
                        <div class="row col-md-12" style="padding-right: 0px;">
                            <?php if (array_key_exists(4, $recipe_view_list_item)) : ?>
                                <?php if (!empty($recipe_view_list_item[4]['main_picture'])): ?>
                                    <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe_view_list_item[4]['id']; ?>">
                                        <img class="img-responsive" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[4]['main_picture']; ?>" alt="<?php echo $recipe_view_list_item[4]['title']; ?>"/>
                                        <p class="reciepe_title heading_medium_thin" style="margin: 5px 0 20px 0;"><?php echo (!empty($recipe_view_list_item[4]['title'])) ? $recipe_view_list_item[4]['title'] : ''; ?></p>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="row col-md-12" style="padding-right: 0px;">
                            <?php if (array_key_exists(5, $recipe_view_list_item)) : ?>
                                <?php if (!empty($recipe_view_list_item[5]['main_picture'])): ?>
                                    <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe_view_list_item[5]['id']; ?>">
                                        <img class="img-responsive" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[5]['main_picture']; ?>" alt="<?php echo $recipe_view_list_item[5]['title']; ?>"/>
                                        <p class="reciepe_title heading_medium_thin" style="margin: 10px 0 15px 0;"><?php echo (!empty($recipe_view_list_item[5]['title'])) ? $recipe_view_list_item[5]['title'] : ''; ?></p>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="row col-md-12" style="padding-right: 0px;">
                            <?php if (array_key_exists(6, $recipe_view_list_item)) : ?>
                                <?php if (!empty($recipe_view_list_item[6]['main_picture'])): ?>
                                    <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe_view_list_item[6]['id']; ?>">
                                        <img class="img-responsive" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[6]['main_picture']; ?>" alt="<?php echo $recipe_view_list_item[6]['title']; ?>"/>
                                        <p class="reciepe_title heading_medium_thin" style="margin: 10px 0 16px 0;"><?php echo (!empty($recipe_view_list_item[6]['title'])) ? $recipe_view_list_item[6]['title'] : ''; ?></p>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php } ?>        
            </div>    
        </div>