<?php if($newsfeed['shared_type_id'] == STATUS_SHARE_OTHER_STATUS&& isset($newsfeed['reference_info']) ){ ?>
<?php 
if (strpos($newsfeed['reference_info']['description'], 'youtube.com') !== false) {
    echo '<div class="row col-md-12">';
}
else
{
    echo '<div class="row col-md-12 feed_shared_status" style="font-size:15px;">';
}
?>
    <?php echo $newsfeed['reference_info']['description']?>
</div>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_HEALTHY_RECIPE && isset($newsfeed['reference_info']) ){ ?>
<div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
    <div class="col-md-4" style="padding:0px;">
        <a href="<?php echo base_url().APPLICATION_HEALTHY_RECIPE_PATH.$newsfeed['reference_info']['id']?>">
            <img class="img-responsive" style="height: 128px" 
                 src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $newsfeed['reference_info']['main_picture']; ?>">
        </a>
    </div>
    <div class="col-md-8">
        <div class="row col-md-12">
            <a href="<?php echo base_url().APPLICATION_HEALTHY_RECIPE_PATH.$newsfeed['reference_info']['id']?>">
                <h4 class="content_text"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['title'])); ?></h4>
            </a>
        </div>
        <div class="row col-md-12">
            <span class="small_text_pale"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['description'])); ?></span>
        </div>
    </div>
</div> 
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_SERVICE_DIRECTORY && isset($newsfeed['reference_info']) ){ ?>
<div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
    <div class="col-md-4" style="padding:0px;">
        <a href="<?php echo base_url().APPLICATION_SERVICE_PATH.$newsfeed['reference_info']['id']?>">
            <img class="img-responsive" style="height: 128px" 
                 src="<?php echo base_url() . SERVICE_IMAGE_PATH . $newsfeed['reference_info']['picture']; ?>">
        </a>
    </div>
    <div class="col-md-8">
        <div class="row col-md-12">
            <a href="<?php echo base_url().APPLICATION_SERVICE_PATH.$newsfeed['reference_info']['id']?>">
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
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_NEWS && isset($newsfeed['reference_info']) ){ ?>
<div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
    <div class="col-md-4" style="padding:0px;">
        <a href="<?php echo base_url().APPLICATION_NEWS_PATH.$newsfeed['reference_info']['id']?>">
            <img class="img-responsive" style="height: 128px" 
                 src="<?php echo base_url() . NEWS_IMAGE_PATH . $newsfeed['reference_info']['picture']; ?>">
        </a>
    </div>
    <div class="col-md-8">
        <div class="row col-md-12">
            <a href="<?php echo base_url().APPLICATION_NEWS_PATH.$newsfeed['reference_info']['id']?>">
                <h4 class="content_text"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['headline'])); ?></h4>
            </a>
        </div>
        <div class="row col-md-12">
            <span  class="small_text_pale"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['summary'])); ?></span>
        </div>
    </div>
</div> 
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_BLOG && isset($newsfeed['reference_info']) ){ ?>
<div class="row col-md-12 feed_shared_link_box" style="padding:0px;margin:0px;">
    <div class="col-md-4" style="padding:0px;">
        <a href="<?php echo base_url().APPLICATION_BLOG_PATH.$newsfeed['reference_info']['id']?>">
            <img class="img-responsive" style="height: 128px" 
                 src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $newsfeed['reference_info']['picture']; ?>">
        </a>
    </div>
    <div class="col-md-8">
        <div class="row col-md-12">
            <a href="<?php echo base_url().APPLICATION_BLOG_PATH.$newsfeed['reference_info']['id']?>">
                <h4 class="content_text"><?php echo html_entity_decode(html_entity_decode($newsfeed['reference_info']['title'])); ?></h4>
            </a>
        </div>
        <div class="row col-md-12">
            <span class="small_text_pale"><?php echo substr(html_entity_decode(html_entity_decode($newsfeed['reference_info']['description'])), 0, NEWSFEED_BLOG_DESCRIPTION_TOTAL_CHARACTERS) . ' ...'; ?></span>
        </div>
    </div>
</div> 
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_PHOTO && isset($newsfeed['reference_info']) ){ ?>
<div class="row col-md-12" style="padding-top: 10px; padding-bottom:10px;">               
    <div class="list-inline list-unstyled row col-md-12">
        <li class="col-md-12">
            <img src="<?php echo base_url().ALBUM_IMAGE_PATH.$newsfeed['reference_info']['img'] ?>" class="img-responsive" 
                 onclick="mediaDisplay('<?php echo base_url().ALBUM_IMAGE_PATH.$newsfeed['reference_info']['img'] ?>', <?php echo $newsfeed['reference_info']['photo_id']?>)"/> 
        </li>
    </div>
</div> 
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_SERVICE_DIRECTORY){ ?>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
        <img class="img-responsive" src="<?php echo base_url().SERVICE_HOME_LOGO_PATH?>">
    </div>
    <?php echo form_open("applications/service_directory/service_directory_map", array('id' => 'form_service_directory', 'class' => 'form-vertical')); ?>
        <div class="form-group">
            <input placeholder="Enter your location here" class="sd_home_input" name="towncode">
        </div>
        <div class="form-group">
            <input class="btn pull-right" name="submit_service_directory" type="submit" value="Find" id="submit_service_directory">
        </div>
    <?php echo form_close();?>
    </div>
</div> 
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_PTPRO){ ?>
<div class="row">
    <div class="col-sm-12">
        <a href="<?php echo base_url().GYMPRO_HOME_PAGE_PATH?>">
        <img class="img-responsive" style="width: 100%" 
             src="<?php echo base_url().GYMPRO_IMAGES_DEFAULT_PATH.GYMPRO_ADDVERT_PICTURE_NAME ?>"/>
        </a>
    </div>
</div> 
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_BMI_CALCULATOR){ ?>
<div class="row">
</div> 
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_PHOTOGRAPHY){ ?>
<div class="form-group">
    <div class="row form-group">
        <a href="<?php echo base_url().PHOTOGRAPHY_HOME_PAGE_PATH ?>">
            <div class="col-sm-2">
                <img class="img-responsive" style="width: 100%" 
                     src="<?php echo base_url().APPLICATION_ICON_PATH.PHOTOGRAPHY_ICON_512X512 ?>">
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
</div> 
<?php }?>


