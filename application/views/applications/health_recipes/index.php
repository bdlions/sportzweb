<?php $this->load->view("applications/health_recipes/templates/header_row"); ?>
<?php if ($show_advertise) { ?>
    <div class="row">
        <div class="col-md-9">
        <?php } else { ?>
            <div class="advertise_border_top advertise_border_bottom advertise_border_left advertise_border_right pad_adjust">
                <div class="row">
                    <div class="col-md-12">
                    <?php } ?>
                    <div class="row">
                        <?php if ($show_advertise) { ?>
                            <div class="col-md-12">
                                <div class="advertise_border_top advertise_border_bottom advertise_border_left pad_adjust">
                                <?php } else { ?>
                                    <div class="col-md-9">
                                    <?php } ?>
                                    <div class="table_container">
                                        <?php if (count($recipe_view_list_item) > 1): ?>
                                            <div class="cell_1st_top" >
                                                <?php if (array_key_exists(0, $recipe_view_list_item)) : ?>
                                                    <?php if (!empty($recipe_view_list_item[0]['main_picture'])): ?>
                                                        <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe_view_list_item[0]['id']; ?>">
                                                            <img style="max-width:600px;max-height:330px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[0]['main_picture']; ?>" alt="<?php echo $recipe_view_list_item[0]['title']; ?>" class="img-responsive" style="width:100%; padding-right:12px;"/>
                                                        </a>
                                                    <?php endif; ?>
                                                    <p class="image-caption reciepe_title heading_medium_thin" style="color: #7092BE"><?php echo (!empty($recipe_view_list_item[0]['title'])) ? $recipe_view_list_item[0]['title'] : ''; ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="cell_1st_bottom">
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
                                    <div class="table_container">
                                        <?php if (count($recipe_view_list_item) >= 3): ?>
                                            <div class="cell" >
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
                                        <div class="cell">
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
                                        <div class="cell_last">
                                            <?php if (array_key_exists(3, $recipe_view_list_item)) : ?>
                                                <?php if (!empty($recipe_view_list_item[3]['main_picture'])): ?>
                                                    <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe_view_list_item[3]['id']; ?>">
                                                        <img style="max-width:450px;max-height:250px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[3]['main_picture']; ?>" alt="<?php echo $recipe_view_list_item[3]['title']; ?>" class="img-responsive"/>
                                                    </a>
                                                <?php endif; ?>
                                                <p class="reciepe_title heading_medium_thin custom_mg" style="color: #7092BE;"><?php echo (!empty($recipe_view_list_item[3]['title'])) ? $recipe_view_list_item[3]['title'] : ''; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>    
                                <?php if (!$show_advertise) { ?>
                                    <div class="col-md-3">
                                        <div class="cell_ads">
                                            <?php if (array_key_exists(4, $recipe_view_list_item)) : ?>
                                                <?php if (!empty($recipe_view_list_item[4]['main_picture'])): ?>
                                                    <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe_view_list_item[4]['id']; ?>">
                                                        <img class="img-responsive" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[4]['main_picture']; ?>" alt="<?php echo $recipe_view_list_item[4]['title']; ?>"/>
                                                        <span class="reciepe_title heading_medium_thin font_size"><?php echo (!empty($recipe_view_list_item[4]['title'])) ? $recipe_view_list_item[4]['title'] : ''; ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="cell_ads">
                                            <?php if (array_key_exists(5, $recipe_view_list_item)) : ?>
                                                <?php if (!empty($recipe_view_list_item[5]['main_picture'])): ?>
                                                    <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe_view_list_item[5]['id']; ?>">
                                                        <img class="img-responsive" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[5]['main_picture']; ?>" alt="<?php echo $recipe_view_list_item[5]['title']; ?>"/>
                                                        <span class="reciepe_title heading_medium_thin font_size"><?php echo (!empty($recipe_view_list_item[5]['title'])) ? $recipe_view_list_item[5]['title'] : ''; ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="cell_ads">
                                            <?php if (array_key_exists(6, $recipe_view_list_item)) : ?>
                                                <?php if (!empty($recipe_view_list_item[6]['main_picture'])): ?>
                                                    <a href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe_view_list_item[6]['id']; ?>">
                                                        <img class="img-responsive" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[6]['main_picture']; ?>" alt="<?php echo $recipe_view_list_item[6]['title']; ?>"/>
                                                        <span class="reciepe_title heading_medium_thin font_size"><?php echo (!empty($recipe_view_list_item[6]['title'])) ? $recipe_view_list_item[6]['title'] : ''; ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php } ?>        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row form-group"></div>

