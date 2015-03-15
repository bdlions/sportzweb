<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/common_styles.css">
<div class="col-md-9">
    <div class="col-md-12"><!--news display actual-->
        <div class="row">
            <div class="col-md-12 heading_big">
                <?php echo html_entity_decode(html_entity_decode($news['headline'])); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 small_text_pale">
                <?php echo unix_to_human($news['created_on']) ?><br>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <img style="width: 100%" src="<?php echo base_url() . NEWS_IMAGE_PATH . $news['picture']; ?>" class="img-responsive" alt="<?php //echo html_entity_decode(html_entity_decode($news['headline'])); ?>"/>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12 small_text_pale">
                <?php echo isset($news['picture_description']) ? html_entity_decode(html_entity_decode($news['picture_description'])) : '----no image description----'; ?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12 content_text">
                <?php echo isset($news['description']) ? html_entity_decode(html_entity_decode($news['description'])) : '----no description----'; ?>
            </div>
        </div>
        
    </div>
</div>
<div class="col-md-3">

</div>