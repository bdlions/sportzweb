<style type="text/css">
    .sonuto_box {
        border: 1px solid #888888;
        font-size: 16px;
        padding: 10px;
    }
    .heading_align{
        text-align: center;
        font-weight: bold;
    }
    
    .paddin_for_paragraph{
        padding-bottom: 20px;
    }
    
    .image_heading {
        color: #FF0000;
        text-align:center;
        padding-top: 8px;
        font-size: 12px;
    }
</style>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/newsfeed.css">

<div class="col-md-12" style="text-align: left;">
    <div class="col-md-4" style="font-size: 18px">
        <h3>Vision, Objective and Mission</h3>
        <?php echo $region_text_map[VISSION_OBJECT_MISSION_ID]?>
    </div>
    <div class="col-md-7 pull-right" style="padding-top: 30px">
        <h3>Mission statement: </h3>
        <span style="text-align: justify; color: #0081c2;font-size: 20px; font-family: serif; font-style: italic">
            <?php echo $region_text_map[MISSION_STATEMENT_ID]?>
        </span>
    </div>
</div>



<div class="col-md-12" style="padding-bottom: 50px; padding-top: 40px;">
    <div class="col-md-3">
        <img width="100%" height="230px" src="<?php echo base_url().ABOUT_US_IMAGE_PATH.$region_image_map[ABOUT_US_IMAGE_REGION1_ID] ?>" alt="social_networing"/>
        <h4 class="image_heading"><?php echo $region_text_map[MIDDLE_HEADING1_ID];?></h4>
    </div>
    <div class="col-md-3">
        <img width="100%" height="230px" src="<?php echo base_url().ABOUT_US_IMAGE_PATH.$region_image_map[ABOUT_US_IMAGE_REGION2_ID] ?>" alt="social_community"/>
        <h4 class="image_heading"><?php echo $region_text_map[MIDDLE_HEADING2_ID];?></h4>
    </div>
    <div class="col-md-3">
        <img width="100%" height="230px" src="<?php echo base_url().ABOUT_US_IMAGE_PATH.$region_image_map[ABOUT_US_IMAGE_REGION3_ID] ?>" alt="application_img"/>
        <h4 class="image_heading"><?php echo $region_text_map[MIDDLE_HEADING3_ID];?></h4>
    </div>
    <div class="col-md-3">
        <img width="100%" height="230px" src="<?php echo base_url().ABOUT_US_IMAGE_PATH.$region_image_map[ABOUT_US_IMAGE_REGION4_ID] ?>" alt="sportz_logo"/>
        <h4 class="image_heading"><?php echo $region_text_map[MIDDLE_HEADING4_ID];?></h4>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-3" style="height: 350px">
        <h3>Social</h3>
        <div style="font-size: 18px">
            <?php echo $region_text_map[SOCIAL_ID];?>
        </div>
    </div>
    <div class="col-md-3" style="border-left: 1px solid #0081c2; height: 350px">
        <h3>Features</h3>
        <div style="font-size: 18px">
            <?php echo $region_text_map[FEATURES_ID];?>
        </div>
    </div>
    <div class="col-md-3" style="border-left: 1px solid #0081c2; height: 350px">
        <h3>Security</h3>
        <div style="font-size: 18px">
            <?php echo $region_text_map[SECURITY_ID];?>
        </div>
    </div>
    <div class="col-md-3" style="border-left: 1px solid #0081c2; height: 350px">
        <h3>Mobile</h3>
        <div style="font-size: 18px">
            <?php echo $region_text_map[MOBILE_ID]?>
        </div>
    </div>
    
</div>

