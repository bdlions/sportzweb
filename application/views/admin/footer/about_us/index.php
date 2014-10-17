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

<nav class="navbar navbar-default navbar-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#open-collapse"> 
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button> 
    </div>

    <div class="collapse navbar-collapse" id="open-collapse">
        <div class="container">
            <div class="row">
                
                <div class="col-md-8">
                    <?php if($allow_edit){ ?><button id="position_<?php echo NAVIGATION_HEADER_ID; ?>" class="btn button-custom pull-right" onclick="openModal('<?php echo NAVIGATION_HEADER_ID; ?>')" value="" style="z-index: 500; position: relative;"> Edit </button><?php } ?>
                    <div class="row pull-right" style="padding-top:35px; padding-left: 130px; text-align: justify; color: #FFFFFF;font-size: 16px; font-family: serif; font-style: italic;">
                        
                        <?php echo $region_text_map[NAVIGATION_HEADER_ID]?> 
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</nav>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/newsfeed.css">

<div class="col-md-12" style="text-align: left;">
    <div class="col-md-4" style="font-size: 18px">
        <h3>Vision, Objective and Mission</h3>
        <?php if($allow_edit){ ?><button id="position_<?php echo VISSION_OBJECT_MISSION_ID; ?>" class="btn button-custom pull-right" onclick="openModal('<?php echo VISSION_OBJECT_MISSION_ID; ?>')" value="" style="z-index: 500; position: relative;"> Edit </button><?php } ?>
        <?php echo $region_text_map[VISSION_OBJECT_MISSION_ID]?>        
    </div>
    <div class="col-md-7 pull-right" style="padding-top: 30px">
        <h3>Mission statement: </h3>
        <?php if($allow_edit){ ?><button id="position_<?php echo MISSION_STATEMENT_ID; ?>" class="btn button-custom pull-right" onclick="openModal('<?php echo MISSION_STATEMENT_ID; ?>')" value="" style="z-index: 500; position: relative;"> Edit </button><?php } ?>
        <span style="text-align: justify; color: #0081c2;font-size: 20px; font-family: serif; font-style: italic">
            <?php echo $region_text_map[MISSION_STATEMENT_ID]?>
        </span>
    </div>
</div>



<div class="col-md-12" style="padding-bottom: 50px; padding-top: 40px;">
    <div class="col-md-3">
        <?php if($allow_edit){ ?>
        <a id="position_<?php echo IMAGE1_ID; ?>" class="btn button-custom pull-right" value="" style="z-index: 500; position: relative;" href="<?php echo base_url().'admin/footer/update_image/'.ABOUT_US_IMAGE_REGION1_ID;?>">
            Edit 
        </a>
        <?php } ?>
        <img width="100%" height="230px" src="<?php echo base_url().ABOUT_US_IMAGE_PATH.$region_image_map[ABOUT_US_IMAGE_REGION1_ID] ?>" alt="social_networing"/>
        <?php if($allow_edit){ ?><button id="position_<?php echo MIDDLE_HEADING1_ID; ?>" class="btn button-custom pull-right" onclick="openModal('<?php echo MIDDLE_HEADING1_ID; ?>')" value="" style="z-index: 500; position: relative;"> Edit </button><?php } ?>
        <h4 class="image_heading"><?php echo $region_text_map[MIDDLE_HEADING1_ID];?></h4>
    </div>
    <div class="col-md-3">
        <?php if($allow_edit){ ?>
        <a id="position_<?php echo IMAGE2_ID; ?>" class="btn button-custom pull-right" value="" style="z-index: 500; position: relative;" href="<?php echo base_url().'admin/footer/update_image/'.ABOUT_US_IMAGE_REGION2_ID;?>">
            Edit 
        </a>
        <?php } ?>
        <img width="100%" height="230px" src="<?php echo base_url().ABOUT_US_IMAGE_PATH.$region_image_map[ABOUT_US_IMAGE_REGION2_ID] ?>" alt="social_community"/>
        <?php if($allow_edit){ ?><button id="position_<?php echo MIDDLE_HEADING2_ID; ?>" class="btn button-custom pull-right" onclick="openModal('<?php echo MIDDLE_HEADING2_ID; ?>')" value="" style="z-index: 500; position: relative;"> Edit </button><?php } ?>
        <h4 class="image_heading"><?php echo $region_text_map[MIDDLE_HEADING2_ID];?></h4>
    </div>
    <div class="col-md-3">
        <?php if($allow_edit){ ?>
        <a id="position_<?php echo IMAGE2_ID; ?>" class="btn button-custom pull-right" value="" style="z-index: 500; position: relative;" href="<?php echo base_url().'admin/footer/update_image/'.ABOUT_US_IMAGE_REGION3_ID;?>">
            Edit 
        </a>
        <?php } ?>
        <img width="100%" height="230px" src="<?php echo base_url().ABOUT_US_IMAGE_PATH.$region_image_map[ABOUT_US_IMAGE_REGION3_ID] ?>" alt="application_img"/>
        <?php if($allow_edit){ ?><button id="position_<?php echo MIDDLE_HEADING3_ID; ?>" class="btn button-custom pull-right" onclick="openModal('<?php echo MIDDLE_HEADING3_ID; ?>')" value="" style="z-index: 500; position: relative;"> Edit </button><?php } ?>
        <h4 class="image_heading"><?php echo $region_text_map[MIDDLE_HEADING3_ID];?></h4>
    </div>
    <div class="col-md-3">
        <?php if($allow_edit){ ?>
        <a id="position_<?php echo IMAGE2_ID; ?>" class="btn button-custom pull-right" value="" style="z-index: 500; position: relative;" href="<?php echo base_url().'admin/footer/update_image/'.ABOUT_US_IMAGE_REGION4_ID;?>">
            Edit 
        </a>
        <?php } ?>
        <img width="100%" height="230px" src="<?php echo base_url().ABOUT_US_IMAGE_PATH.$region_image_map[ABOUT_US_IMAGE_REGION4_ID] ?>" alt="sportz_logo"/>
        <?php if($allow_edit){ ?><button id="position_<?php echo MIDDLE_HEADING4_ID; ?>" class="btn button-custom pull-right" onclick="openModal('<?php echo MIDDLE_HEADING4_ID; ?>')" value="" style="z-index: 500; position: relative;"> Edit </button><?php } ?>
        <h4 class="image_heading"><?php echo $region_text_map[MIDDLE_HEADING4_ID];?></h4>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-3" style="height: 350px">
        <?php if($allow_edit){ ?>
        <button id="position_<?php echo SOCIAL_ID; ?>" class="btn button-custom pull-right" onclick="openModal('<?php echo SOCIAL_ID; ?>')" value="" style="z-index: 500; position: relative;">
            Edit
        </button>
        <?php } ?>
        <h3>Social</h3>
        <div style="font-size: 18px">
            <?php echo $region_text_map[SOCIAL_ID];?>
        </div>
    </div>
    <div class="col-md-3" style="border-left: 1px solid #0081c2; height: 350px">
        <?php if($allow_edit){ ?>
        <button id="position_<?php echo FEATURES_ID; ?>" class="btn button-custom pull-right" onclick="openModal('<?php echo FEATURES_ID; ?>')" value="" style="z-index: 500; position: relative;">
            Edit
        </button>
        <?php } ?>
        <h3>Features</h3>
        <div style="font-size: 18px">
            <?php echo $region_text_map[FEATURES_ID];?>
        </div>
    </div>
    <div class="col-md-3" style="border-left: 1px solid #0081c2; height: 350px">
       <?php if($allow_edit){ ?>
        <button id="position_<?php echo SECURITY_ID; ?>" class="btn button-custom pull-right" onclick="openModal('<?php echo SECURITY_ID; ?>')" value="" style="z-index: 500; position: relative;">
            Edit
        </button>
        <?php } ?>
        <h3>Security</h3>
        <div style="font-size: 18px">
            <?php echo $region_text_map[SECURITY_ID];?>
        </div>
    </div>
    <div class="col-md-3" style="border-left: 1px solid #0081c2; height: 350px">
        <?php if($allow_edit){ ?>
        <button id="position_<?php echo MOBILE_ID; ?>" class="btn button-custom pull-right" onclick="openModal('<?php echo MOBILE_ID; ?>')" value="" style="z-index: 500; position: relative;">
            Edit
        </button>
        <?php } ?>
        <h3>Mobile</h3> 
        <div style="font-size: 18px">
            <?php echo $region_text_map[MOBILE_ID]?>
        </div>
    </div>
</div>
<?php $this->load->view("admin/footer/about_us/modal_change_content"); ?>
<script type="text/javascript">
    function openModal(region_id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/footer/get_about_us_info",
            data: {
                region_id: region_id
            },
            success: function(data) {
                $('#region_id').val(region_id);
                $('#input_text').val(data.region_text);
                $('#modal_chnage_content').modal('show');
            }
        });        
    }
</script>