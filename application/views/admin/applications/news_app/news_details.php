
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
<div class="col-md-9">
    <div class="col-md-12" style="background-color: #F2F2FF;"><!--news display actual-->
        <div class="row">
            <div class="col-md-12">
                <span style="font-size: 18px; color: #0044cc;"><?php echo html_entity_decode(html_entity_decode($news['headline'])); ?></span>
            </div>
        </div>

        <?php echo unix_to_human($news['created_on']) ?><br>
        <img style="width: 100%" src="<?php echo base_url() . NEWS_IMAGE_PATH . $news['picture']; ?>" class="img-responsive" alt="<?php echo html_entity_decode(html_entity_decode($news['headline'])); ?>"/>
        <div class="col-md-12" style="padding-top:20px;padding-right: 0px;">
            <?php echo isset($news['picture_description']) ? html_entity_decode(html_entity_decode($news['picture_description'])) : '';?>
        </div>
        <br><span class="cus_news_descr"><?php echo html_entity_decode(html_entity_decode($news['description'])); ?></span>
    </div>
<!--    <div class="col-md-2 pull-right" style="padding: 16px;"><img src="<?php echo base_url() . NEWS_IMAGE_PATH . "vote_star_active_32.png"; ?>"  alt="Liked:"/> &nbsp;&nbsp;<?php echo count($news['user_liked_list']); ?></div>-->
    
    <?php $this->load->view("admin/applications/comments"); ?>
    
</div>
<div class="col-md-3">

</div>