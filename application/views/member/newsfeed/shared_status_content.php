<?php if ($newsfeed['shared_type_id'] == STATUS_SHARE_OTHER_STATUS && isset($newsfeed['reference_info'])) { ?>
    <?php
    if (strpos($newsfeed['reference_info']['description'], 'youtube.com') !== false) {
        echo '<div class="row col-md-12">';
    } else {
        echo '<div class="row col-md-12 feed_shared_status" style="font-size:15px;">';
    }
    ?>
    <?php echo $newsfeed['reference_info']['description'] ?>
    </div>
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_HEALTHY_RECIPE && isset($newsfeed['reference_info'])) { ?>
    <div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
    <?php if (isset($newsfeed['reference_info']['main_picture'])) { ?>
            <div class="col-md-4" style="padding:0px;">
                <a href="<?php echo base_url() . APPLICATION_HEALTHY_RECIPE_PATH . $newsfeed['reference_info']['id'] ?>">
                    <img class="img-responsive" style="height: 128px" 
                         src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $newsfeed['reference_info']['main_picture']; ?>">
                </a>
            </div>
    <?php } ?>
        <div class="col-md-8">
            <div class="row col-md-12">
                <a href="<?php echo base_url() . APPLICATION_HEALTHY_RECIPE_PATH . $newsfeed['reference_info']['id'] ?>">
                    <h4 class="content_text"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['title'])); ?></h4>
                </a>
            </div>
            <div class="row col-md-12">
                <span class="small_text_pale"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['description'])); ?></span>
            </div>
        </div>
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_SERVICE_DIRECTORY && isset($newsfeed['reference_info'])) { ?>
    <div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
    <?php if (isset($newsfeed['reference_info']['picture'])) { ?>
            <div class="col-md-4" style="padding:0px;">        
                <a href="<?php echo base_url() . APPLICATION_SERVICE_PATH . $newsfeed['reference_info']['id'] ?>">
                    <img class="img-responsive" style="height: 128px" 
                         src="<?php echo base_url() . SERVICE_IMAGE_PATH . $newsfeed['reference_info']['picture']; ?>">
                </a>        
            </div>
    <?php } ?>
        <div class="col-md-8">
            <div class="row col-md-12">
                <a href="<?php echo base_url() . APPLICATION_SERVICE_PATH . $newsfeed['reference_info']['id'] ?>">
                    <h4 class="content_text"><?php echo $newsfeed['reference_info']['title']; ?></h4>
                </a>
            </div>
            <div class="row col-md-12">
                <span class="small_text_pale"><?php echo $newsfeed['reference_info']['address']; ?></span>
            </div>
            <div class="row col-md-12">
                <span class="small_text_pale"><?php echo $newsfeed['reference_info']['city']; ?></span>
            </div>
            <div class="row col-md-12">
                <span class="small_text_pale"><?php echo $newsfeed['reference_info']['post_code']; ?></span>
            </div> 
            <div class="row col-md-12">
                <span class="small_text_pale">Tel:<?php echo $newsfeed['reference_info']['telephone']; ?></span>
            </div>
        </div>
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_NEWS && isset($newsfeed['reference_info'])) { ?>
    <div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
    <?php if (isset($newsfeed['reference_info']['picture'])) { ?>
            <div class="col-md-4" style="padding:0px;">
                <a href="<?php echo base_url() . APPLICATION_NEWS_PATH . $newsfeed['reference_info']['id'] ?>">
                    <img class="img-responsive" style="height: 128px" 
                         src="<?php echo base_url() . NEWS_IMAGE_PATH . $newsfeed['reference_info']['picture']; ?>">
                </a>
            </div>
    <?php } ?>
        <div class="col-md-8">
            <div class="row col-md-12">
                <a href="<?php echo base_url() . APPLICATION_NEWS_PATH . $newsfeed['reference_info']['id'] ?>">
                    <h4 class="content_text"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['headline'])); ?></h4>
                </a>
            </div>
            <div class="row col-md-12">
                <span  class="small_text_pale"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['summary'])); ?></span>
            </div>
        </div>
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_BLOG && isset($newsfeed['reference_info'])) { ?>
    <div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
    <?php if (isset($newsfeed['reference_info']['picture'])) { ?>
            <div class="col-md-4" style="padding:0px;">
                <a href="<?php echo base_url() . APPLICATION_BLOG_PATH . $newsfeed['reference_info']['id'] ?>">
                    <img class="img-responsive" style="height: 128px" 
                         src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $newsfeed['reference_info']['picture']; ?>">
                </a>
            </div>
    <?php } ?>
        <div class="col-md-8">
            <div class="row col-md-12">
                <a href="<?php echo base_url() . APPLICATION_BLOG_PATH . $newsfeed['reference_info']['id'] ?>">
                    <h4 class="content_text"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['title'])); ?></h4>
                </a>
            </div>
            <div class="row col-md-12">
                <span class="small_text_pale"><?php echo substr(html_entity_decode(html_entity_decode($newsfeed['reference_info']['description'])), 0, NEWSFEED_BLOG_DESCRIPTION_TOTAL_CHARACTERS) . ' ...'; ?></span>
            </div>
        </div>
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_PHOTO && isset($newsfeed['reference_info'])) { ?>
    <div class="row col-md-12" style="padding-top: 10px; padding-bottom:10px;">               
        <div class="list-inline list-unstyled row col-md-12">
            <li class="col-md-12">
                <img src="<?php echo base_url() . ALBUM_IMAGE_PATH . $newsfeed['reference_info']['img'] ?>" class="img-responsive" 
                     onclick="mediaDisplay('<?php echo base_url() . ALBUM_IMAGE_PATH . $newsfeed['reference_info']['img'] ?>', <?php echo $newsfeed['reference_info']['photo_id'] ?>)"/> 
            </li>
        </div>
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_SERVICE_DIRECTORY) { ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <img class="img-responsive" src="<?php echo base_url() . SERVICE_HOME_LOGO_PATH ?>">
            </div>
    <?php echo form_open("applications/service_directory/service_directory_map", array('id' => 'form_service_directory', 'class' => 'form-vertical')); ?>
            <div class="form-group">
                <input placeholder="Enter your location here" class="sd_home_input" name="towncode">
            </div>
            <div class="form-group">
                <input class="btn pull-right" name="submit_service_directory" type="submit" value="Find" id="submit_service_directory">
            </div>
    <?php echo form_close(); ?>
        </div>
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_PTPRO) { ?>
    <div class="row">
        <div class="col-sm-12">
            <a href="<?php echo base_url() . GYMPRO_HOME_PAGE_PATH ?>">
                <img class="img-responsive" style="width: 100%" 
                     src="<?php echo base_url() . GYMPRO_IMAGES_DEFAULT_PATH . GYMPRO_ADDVERT_PICTURE_NAME ?>"/>
            </a>
        </div>
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_BMI_CALCULATOR) { ?>
    <div class="row">
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_FIXTURES_RESULTS) { ?>
    <div class="row">
    </div>
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_PHOTOGRAPHY) { ?>
    <div class="form-group">
        <div class="row form-group">
            <a href="<?php echo base_url() . PHOTOGRAPHY_HOME_PAGE_PATH ?>">
                <div class="col-sm-2">
                    <img class="img-responsive" style="width: 100%" 
                         src="<?php echo base_url() . APPLICATION_ICON_PATH . PHOTOGRAPHY_ICON_512X512 ?>">
                </div>
                <div class="col-sm-10">
                    <div class="form-group" style="color: black">
                        <h3>
    <?php
    //right now aplication title is hardcoded. Make it dynamic
    echo "Photography";
    ?>
                        </h3>
                    </div>
                </div>
            </a>
        </div>
    <?php if (!empty($newsfeed['reference_info'])) { ?>
            <div class="row col-md-12">
                <img class="img-responsive" style="width: 100%" 
                     src="<?php echo base_url() . PHOTOGRAPHY_IMAGE_PATH . $newsfeed['reference_info']['img'] ?>">
            </div>
    <?php } ?>
    </div> 
    <?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_LATEST_MAIN_RECIPE && isset($newsfeed['reference_info'])) { ?>
    <div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
        <div class="col-md-4" style="padding:0px;">
            <a href="<?php echo base_url() . APPLICATION_HEALTHY_RECIPE_PATH . $newsfeed['reference_info']['id'] ?>">
                <img class="img-responsive" style="height: 128px" 
                     src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $newsfeed['reference_info']['main_picture']; ?>">
            </a>
        </div>
        <div class="col-md-8">
            <div class="row col-md-12">
                <a href="<?php echo base_url() . APPLICATION_HEALTHY_RECIPE_PATH . $newsfeed['reference_info']['id'] ?>">
                    <h4 class="content_text"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['title'])); ?></h4>
                </a>
            </div>
            <div class="row col-md-12">
                <span class="small_text_pale"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['description'])); ?></span>
            </div>
        </div>
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_LATEST_BLOG1 && isset($newsfeed['reference_info'])) { ?>
    <div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
        <div class="col-md-4" style="padding:0px;">
            <a href="<?php echo base_url() . APPLICATION_BLOG_PATH . $newsfeed['reference_info']['id'] ?>">
                <img class="img-responsive" style="height: 128px" 
                     src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $newsfeed['reference_info']['picture']; ?>">
            </a>
        </div>
        <div class="col-md-8">
            <div class="row col-md-12">
                <a href="<?php echo base_url() . APPLICATION_BLOG_PATH . $newsfeed['reference_info']['id'] ?>">
                    <h4 class="content_text"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['title'])); ?></h4>
                </a>
            </div>
            <div class="row col-md-12">
                <span class="small_text_pale"><?php echo substr(html_entity_decode(html_entity_decode($newsfeed['reference_info']['description'])), 0, NEWSFEED_BLOG_DESCRIPTION_TOTAL_CHARACTERS) . ' ...'; ?></span>
            </div>
        </div>
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == 1000 && isset($newsfeed['reference_info'])) { ?>
    <div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
        <div class="col-md-4" style="padding:0px;">
            <a href="<?php echo base_url() . APPLICATION_BLOG_PATH . $newsfeed['reference_info']['id'] ?>">
                <img class="img-responsive" style="height: 128px" 
                     src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $newsfeed['reference_info']['picture']; ?>">
            </a>
        </div>
        <div class="col-md-8">
            <div class="row col-md-12">
                <a href="<?php echo base_url() . APPLICATION_BLOG_PATH . $newsfeed['reference_info']['id'] ?>">
                    <h4 class="content_text"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['title'])); ?></h4>
                </a>
            </div>
            <div class="row col-md-12">
                <span class="small_text_pale"><?php echo substr(html_entity_decode(html_entity_decode($newsfeed['reference_info']['description'])), 0, NEWSFEED_BLOG_DESCRIPTION_TOTAL_CHARACTERS) . ' ...'; ?></span>
            </div>
        </div>
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_LATEST_BLOG3 && isset($newsfeed['reference_info'])) { ?>
    <div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
        <div class="col-md-4" style="padding:0px;">
            <a href="<?php echo base_url() . APPLICATION_BLOG_PATH . $newsfeed['reference_info']['id'] ?>">
                <img class="img-responsive" style="height: 128px" 
                     src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $newsfeed['reference_info']['picture']; ?>">
            </a>
        </div>
        <div class="col-md-8">
            <div class="row col-md-12">
                <a href="<?php echo base_url() . APPLICATION_BLOG_PATH . $newsfeed['reference_info']['id'] ?>">
                    <h4 class="content_text"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['title'])); ?></h4>
                </a>
            </div>
            <div class="row col-md-12">
                <span class="small_text_pale"><?php echo substr(html_entity_decode(html_entity_decode($newsfeed['reference_info']['description'])), 0, NEWSFEED_BLOG_DESCRIPTION_TOTAL_CHARACTERS) . ' ...'; ?></span>
            </div>
        </div>
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_LATEST_BLOG4 && isset($newsfeed['reference_info'])) { ?>
    <div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
        <div class="col-md-4" style="padding:0px;">
            <a href="<?php echo base_url() . APPLICATION_BLOG_PATH . $newsfeed['reference_info']['id'] ?>">
                <img class="img-responsive" style="height: 128px" 
                     src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $newsfeed['reference_info']['picture']; ?>">
            </a>
        </div>
        <div class="col-md-8">
            <div class="row col-md-12">
                <a href="<?php echo base_url() . APPLICATION_BLOG_PATH . $newsfeed['reference_info']['id'] ?>">
                    <h4 class="content_text"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['title'])); ?></h4>
                </a>
            </div>
            <div class="row col-md-12">
                <span class="small_text_pale"><?php echo substr(html_entity_decode(html_entity_decode($newsfeed['reference_info']['description'])), 0, NEWSFEED_BLOG_DESCRIPTION_TOTAL_CHARACTERS) . ' ...'; ?></span>
            </div>
        </div>
    </div> 
<?php } else if ($newsfeed['shared_type_id'] == STATUS_SHARE_FIXTURES_RESULTS && isset($newsfeed['reference_info'])) { ?>
    <div class="row feed-description">
        <div class="col-md-12">
            <div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
                <div class="panel-group" aria-multiselectable="true" role="tablist">
                    <div class="panel panel-default" id="div_match_info_<?php echo $newsfeed['reference_info']['match_id']; ?>">
                        <div class="row panel-heading sp_app_panel_heading_margin" role="tab">
                            <a class="score_prediction" href="<?php echo base_url() . 'applications/score_prediction/index/' . $newsfeed['reference_id']; ?>">
                                <div class="app_sp_time">
                                    <?php echo $newsfeed['reference_info']['time']; ?>
                                </div>
                                <div class="app_sp_team_home">
                                    <?php echo $newsfeed['reference_info']['team_title_home']; ?>
                                </div>
                                <?php if($newsfeed['reference_info']['status_id'] == MATCH_STATUS_UPCOMING){ ?>
                                <div class="app_sp_vs">
                                    vs
                                </div>
                                <?php }else{?>
                                <div class="app_sp_match_result">
                                    <?php echo $newsfeed['reference_info']['score_home'] . ' - ' . $newsfeed['reference_info']['score_away']; ?>
                                </div>
                                <?php }?>
                                <div class="app_sp_team_away">
                                    <?php echo $newsfeed['reference_info']['team_title_away']; ?>
                                </div>                                
                                <div class="app_sp_match_status">
                                    <?php if ($newsfeed['reference_info']['status_id'] != MATCH_STATUS_UPCOMING) { ?>
                                       <div class="floating_right">Closed </div>  
                                    <?php } else if ($newsfeed['reference_info']['is_predicted'] == 1) { ?>
                                        <div class="floating_right">Voted </div>
                                    <?php } else { ?>
                                        <div class="floating_right">Vote </div>
                                    <?php } ?>
                                </div>
                            </a>
                        </div>
                        <div id="collapse_match_event<?php echo $newsfeed['reference_info']['match_id'] . '_' . $newsfeed['id']; ?>" role="tabpanel" aria-labelledby="div_match_info_<?php echo $newsfeed['reference_info']['match_id']; ?>">
                            <div class="panel-body">
                                <div class="row form-group" onclick = "prediction_modal('<?php echo $newsfeed['reference_info']['team_title_home']; ?>', '<?php echo $newsfeed['reference_info']['match_id'] ?>', '<?php echo MATCH_STATUS_WIN_HOME ?>', '<?php echo $newsfeed['reference_info']['is_predicted'] ?>', '<?php echo $newsfeed['reference_info']['status_id'] ?>', '<?php echo MATCH_PREDICTION_FROM_NEWSFEED ?>')">
                                    <div class="col-md-12">
    <?php
    $home_percentage = $newsfeed['reference_info']['prediction_info']['home'];
    $home_css_class = "";
    if ($newsfeed['reference_info']['status_id'] != MATCH_STATUS_UPCOMING && $newsfeed['reference_info']['status_id'] == MATCH_STATUS_WIN_HOME) {
        $home_css_class = "progress_bar_width_catulate bgcolor_green";
    } else if ($newsfeed['reference_info']['status_id'] != MATCH_STATUS_UPCOMING && $newsfeed['reference_info']['is_predicted'] == 1 && $newsfeed['reference_info']['my_prediction_id'] != $newsfeed['reference_info']['status_id'] && $newsfeed['reference_info']['my_prediction_id'] == MATCH_STATUS_WIN_HOME) {
        $home_css_class = "progress_bar_width_catulate bgcolor_red";
    } else if ($newsfeed['reference_info']['status_id'] == MATCH_STATUS_UPCOMING && $newsfeed['reference_info']['is_predicted'] == 1 && $newsfeed['reference_info']['my_prediction_id'] == MATCH_STATUS_WIN_HOME) {
        $home_css_class = "progress_bar_width_catulate bgcolor_blue";
    } else {
        $home_css_class = "progress_bar_width_catulate bgcolor_light_gray";
    }
    ?>
                                        <div class="progress_bar_backgraound">                                    
                                            <span class="progress_bar_content"> <?php echo $newsfeed['reference_info']['team_title_home']; ?> </span>
                                            <span class="progress_bar_percentage_text"> <?php echo $home_percentage; ?> </span>
                                            <div class="<?php echo $home_css_class; ?>" style="width:<?php echo $home_percentage; ?>"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group" onclick = "prediction_modal('Draw', '<?php echo $newsfeed['reference_info']['match_id'] ?>', '<?php echo MATCH_STATUS_DRAW ?>', '<?php echo $newsfeed['reference_info']['is_predicted'] ?>', '<?php echo $newsfeed['reference_info']['status_id'] ?>', '<?php echo MATCH_PREDICTION_FROM_NEWSFEED ?>')">
                                    <div class="col-md-12">
    <?php
    $draw_percentage = $newsfeed['reference_info']['prediction_info']['draw'];
    $draw_css_class = "";
    if ($newsfeed['reference_info']['status_id'] != MATCH_STATUS_UPCOMING && $newsfeed['reference_info']['status_id'] == MATCH_STATUS_DRAW) {
        $draw_css_class = "progress_bar_width_catulate bgcolor_green";
    } else if ($newsfeed['reference_info']['status_id'] != MATCH_STATUS_UPCOMING && $newsfeed['reference_info']['is_predicted'] == 1 && $newsfeed['reference_info']['my_prediction_id'] != $newsfeed['reference_info']['status_id'] && $newsfeed['reference_info']['my_prediction_id'] == MATCH_STATUS_DRAW) {
        $draw_css_class = "progress_bar_width_catulate bgcolor_red";
    } else if ($newsfeed['reference_info']['status_id'] == MATCH_STATUS_UPCOMING && $newsfeed['reference_info']['is_predicted'] == 1 && $newsfeed['reference_info']['my_prediction_id'] == MATCH_STATUS_DRAW) {
        $draw_css_class = "progress_bar_width_catulate bgcolor_blue";
    } else {
        $draw_css_class = "progress_bar_width_catulate bgcolor_light_gray";
    }
    ?>
                                        <div class="progress_bar_backgraound">                                    
                                            <span class="progress_bar_content">Draw</span>
                                            <span class="progress_bar_percentage_text"> <?php echo $draw_percentage; ?> </span>
                                            <div class="<?php echo $draw_css_class; ?>" style="width:<?php echo $draw_percentage; ?>"> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group" onclick = "prediction_modal('<?php echo $newsfeed['reference_info']['team_title_away']; ?>', '<?php echo $newsfeed['reference_info']['match_id'] ?>', '<?php echo MATCH_STATUS_WIN_AWAY ?>', '<?php echo $newsfeed['reference_info']['is_predicted'] ?>', '<?php echo $newsfeed['reference_info']['status_id'] ?>', '<?php echo MATCH_PREDICTION_FROM_NEWSFEED ?>')">
                                    <div class="col-md-12">
    <?php
    $away_percentage = $newsfeed['reference_info']['prediction_info']['away'];
    $away_css_class = "";
    if ($newsfeed['reference_info']['status_id'] != MATCH_STATUS_UPCOMING && $newsfeed['reference_info']['status_id'] == MATCH_STATUS_WIN_AWAY) {
        $away_css_class = "progress_bar_width_catulate bgcolor_green";
    } else if ($newsfeed['reference_info']['status_id'] != MATCH_STATUS_UPCOMING && $newsfeed['reference_info']['is_predicted'] == 1 && $newsfeed['reference_info']['my_prediction_id'] != $newsfeed['reference_info']['status_id'] && $newsfeed['reference_info']['my_prediction_id'] == MATCH_STATUS_WIN_AWAY) {
        $away_css_class = "progress_bar_width_catulate bgcolor_red";
    } else if ($newsfeed['reference_info']['status_id'] == MATCH_STATUS_UPCOMING && $newsfeed['reference_info']['is_predicted'] == 1 && $newsfeed['reference_info']['my_prediction_id'] == MATCH_STATUS_WIN_AWAY) {
        $away_css_class = "progress_bar_width_catulate bgcolor_blue";
    } else {
        $away_css_class = "progress_bar_width_catulate bgcolor_light_gray";
    }
    ?>
                                        <div class="progress_bar_backgraound">                                    
                                            <span class="progress_bar_content"> <?php echo $newsfeed['reference_info']['team_title_away']; ?> </span>
                                            <span class="progress_bar_percentage_text"> <?php echo $away_percentage; ?> </span>
                                            <div class="<?php echo $away_css_class; ?>" style="width:<?php echo $away_percentage; ?>"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


