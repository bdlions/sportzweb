<?php //echo $region_id_is_news_ignored_map;exit;?>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
    <?php $this->load->view("applications/news_app/templates/header_menu"); ?>   
    <h1><?php echo $title; ?></h1>
    <?php if(!empty($region_id_is_news_ignored_map)){?>
<div class="col-md-9" style="padding-left: 0px; padding-right: 30px;">
<?php if($region_id_is_news_ignored_map[0]==0) : ?>
    <div class="row" style="padding-bottom: 20px"><!--Greatest news-->
        <div class="col-md-6 col-lg-6">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[0]]['id']; ?>">
                <img id="image_position_1" style="width:100%;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_TOP_LEFT_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[0]]['picture'] ?>"/>
            </a>
        </div>
            <input type="hidden" name="position_of_news_1" id="position_of_news_1" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[0]]['id'])?$news_id_news_info_map[$region_id_news_id_map[0]]['id']:'';?>">
            <input type="hidden" name="get_selected_id" id="get_selected_id" value="">
        <div class="col-md-6 col-lg-6">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[0]]['id']; ?>">
                <span class="cus_news_headline">
                    <p id="heading_1"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[0]]['headline']));?></p>
                </span>
            </a>
            <span class="cus_news_descr">
                <p id="summary_1"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[0]]['summary']));?></p>
            </span>
        </div>
    </div>
<?php endif; ?>
    <div class="row" style="padding-bottom: 20px"><!--top news loop...3 news per row-->
        <div class="col-md-4 col-lg-4">
        <?php if($region_id_is_news_ignored_map[1]==0) : ?>
                <input type="hidden" name="position_of_news_2" id="position_of_news_2" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[1]]['id'])?$news_id_news_info_map[$region_id_news_id_map[1]]['id']:'';?>">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[1]]['id']; ?>">
                    <img id="image_position_2" style="width:100%;height:130px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[1]]['picture'] ?>"/>
                </a>
                <br>
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[1]]['id']; ?>">
                    <span class="cus_news_subheadline">
                        <p id="heading_2"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[1]]['headline']));?></p>
                    </span>
                </a>
                <span class="cus_news_descr">
                    <p id="summary_2"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[1]]['summary']));?></p>
                </span>
        <?php endif; ?>
        </div>
        <div class="col-md-4 col-lg-4">
        <?php if($region_id_is_news_ignored_map[2]==0) : ?>

                <input type="hidden" name="position_of_news_3" id="position_of_news_3" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[2]]['id'])?$news_id_news_info_map[$region_id_news_id_map[2]]['id']:'';?>">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[2]]['id']; ?>">
                    <img id="image_position_3" style="width:100%;height:130px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[2]]['picture'] ?>"/>
                </a>
                <br>
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[2]]['id']; ?>">
                    <span class="cus_news_subheadline">
                        <p id="heading_3">
                            <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[2]]['headline']))?>
                        </p>
                    </span>
                </a>
                <span class="cus_news_descr">
                    <p id="summary_3"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[2]]['summary']));?></p>
                </span>
        <?php endif;  ?>
        </div>
        <div class="col-md-4 col-lg-4" >
        <?php if($region_id_is_news_ignored_map[3]==0) : ?>
                <input type="hidden" name="position_of_news_4" id="position_of_news_4" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[3]]['id'])?$news_id_news_info_map[$region_id_news_id_map[3]]['id']:'';?>">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[3]]['id']; ?>">
                    <img id="image_position_4" style="width:100%;height:130px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[3]]['picture'] ?>"/>
                </a>
                <br>
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[3]]['id']; ?>">
                    <span class="cus_news_subheadline">
                        <p id="heading_4">
                            <?php echo $news_id_news_info_map[$region_id_news_id_map[3]]['headline']?>
                        </p>
                    </span>
                </a>
                <span class="cus_news_descr">
                    <p id="summary_4">
                        <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[3]]['summary']));?>
                    </p>
                </span>
        <?php endif;  ?>
        </div>
    </div>

    <div class="row" style="padding-bottom: 10px"><!--small news loop...2 news per row-->
        <div class="col-md-6" style="padding-left: 0px;">
        <?php if($region_id_is_news_ignored_map[4]==0) : ?>
            <div class="col-md-6">
                <input type="hidden" name="position_of_news_5" id="position_of_news_5" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[4]]['id'])?$news_id_news_info_map[$region_id_news_id_map[4]]['id']:'';?>">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[4]]['id']; ?>">
                    <img id="image_position_5" style="width:100%;height:100px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[4]]['picture'] ?>"/>
                </a>
            </div>
            <div class="col-md-6" style="padding-left: 0px;">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[4]]['id']; ?>">
                    <span class="cus_news_subheadline">
                        <p id="heading_5">
                            <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[4]]['headline']));?>
                        </p>
                    </span>
                </a>
            </div>
        <?php endif; ?>
        </div>
        <div class="col-md-6"  style="padding-left: 0px;">
        <?php if($region_id_is_news_ignored_map[5]==0) : ?>
            <div class="col-md-6">
                <input type="hidden" name="position_of_news_6" id="position_of_news_6" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[5]]['id'])?$news_id_news_info_map[$region_id_news_id_map[5]]['id']:'';?>">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[5]]['id']; ?>">
                    <img id="image_position_6" style="width:100%;height:100px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[5]]['picture'] ?>"/>
                </a>
            </div>
            <div class="col-md-6" style="padding-left: 0px;">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[5]]['id']; ?>">
                    <span class="cus_news_subheadline">
                        <p id="heading_6">
                            <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[5]]['headline']));?>
                        </p>
                    </span>
                </a>
            </div>
        <?php endif; ?>
        </div>
    </div>
    <div class="row" style="padding-bottom: 10px"><!--small news loop...2 news per row-->
        <div class="col-md-6"  style="padding-left: 0px;">
        <?php if($region_id_is_news_ignored_map[6]==0) : ?>
            <div class="col-md-6">
                <input type="hidden" name="position_of_news_7" id="position_of_news_7" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[6]]['id'])?$news_id_news_info_map[$region_id_news_id_map[6]]['id']:'';?>">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[6]]['id']; ?>">
                    <img id="image_position_7" style="width:100%;height:100px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[6]]['picture'] ?>"/>
                </a>
            </div>
            <div class="col-md-6" style="padding-left: 0px;">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[6]]['id']; ?>">
                    <span class="cus_news_subheadline">
                        <p id="heading_7"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[6]]['headline']));?></p>
                    </span>
                </a>
            </div>
        <?php endif; ?>
        </div>
        <div class="col-md-6"  style="padding-left: 0px;">
        <?php if($region_id_is_news_ignored_map[7]==0): ?>
            <div class="col-md-6">
                <input type="hidden" name="position_of_news_8" id="position_of_news_8" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[7]]['id'])?$news_id_news_info_map[$region_id_news_id_map[7]]['id']:'';?>">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[7]]['id']; ?>">
                    <img id="image_position_8" style="width:100%;height:100px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[7]]['picture'] ?>"/>
                </a>
            </div>
            <div class="col-md-6" style="padding-left: 0px;">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[7]]['id']; ?>">
                    <span class="cus_news_subheadline">
                        <p id="heading_8"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[7]]['headline']));?></p>
                    </span>
                </a>
            </div>
        <?php endif; ?>
        </div>

    </div>
    <div class="row" style="padding-bottom: 10px; padding-top: 30px"><!--small news area-->
        <div class="col-md-8 col-lg-8"><!--small news loop...2 news per row-->
            <div class="row">
                <div class="col-md-6 col-lg-6">
                <?php if($region_id_is_news_ignored_map[8]==0): ?>
                    <input type="hidden" name="position_of_news_9" id="position_of_news_9" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[8]]['id'])?$news_id_news_info_map[$region_id_news_id_map[8]]['id']:'';?>">
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[8]]['id']; ?>">
                            <span class="cus_news_smallheadline">
                                <p id="heading_9"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[8]]['headline']));?></p>
                            </span>
                        </a>
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[8]]['id']; ?>">
                            <span class="cus_news_descr">
                                <p id="summary_9"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[8]]['summary']));?></p>
                            </span>
                        </a>
                <?php endif; ?>
                </div>
                <div class="col-md-6 col-lg-6">
                <?php if($region_id_is_news_ignored_map[9]==0) : ?>

                        <input type="hidden" name="position_of_news_10" id="position_of_news_10" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[9]]['id'])?$news_id_news_info_map[$region_id_news_id_map[9]]['id']:'';?>">
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[9]]['id']; ?>">
                            <span class="cus_news_smallheadline">
                                <p id="heading_10"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[9]]['headline'])) ;?></p>
                            </span>
                        </a>
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[9]]['id']; ?>">
                            <span  class="cus_news_descr">
                                <p id="summary_10"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[9]]['summary']));?></p>
                            </span>
                        </a>
                <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-6">
                <?php if($region_id_is_news_ignored_map[10]==0) : ?>

                        <input type="hidden" name="position_of_news_11" id="position_of_news_11" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[10]]['id'])?$news_id_news_info_map[$region_id_news_id_map[10]]['id']:'';?>">
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[10]]['id']; ?>">
                            <span class="cus_news_smallheadline">
                                <p id="heading_11"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[10]]['headline']));?></p>
                            </span>
                        </a>
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[10]]['id']; ?>">
                            <span class="cus_news_descr">
                                <p id="summary_11"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[10]]['summary']));?></p>
                            </span>
                        </a>
                <?php endif; ?>
                </div>
                <div class="col-md-6 col-lg-6">
                <?php if($region_id_is_news_ignored_map[11]==0) : ?>

                        <input type="hidden" name="position_of_news_12" id="position_of_news_12" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[11]]['id'])?$news_id_news_info_map[$region_id_news_id_map[11]]['id']:'';?>">
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[11]]['id']; ?>">
                            <span class="cus_news_smallheadline">
                                <p id="heading_12"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[11]]['headline']));?></p>
                            </span>
                        </a>
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[11]]['id']; ?>">
                            <span class="cus_news_descr">
                                <p id="summary_12"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[11]]['summary']));?></p>
                            </span>
                        </a>

                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
        <?php if($region_id_is_news_ignored_map[12]==0) : ?>

                <input type="hidden" name="position_of_news_13" id="position_of_news_13" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[12]]['id'])?$news_id_news_info_map[$region_id_news_id_map[12]]['id']:'';?>">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[12]]['id']; ?>">
                    <img style="min-width: 100%;" id="image_position_13" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[12]]['picture'] ?>"/>
                </a>
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[12]]['id']; ?>">
                    <span class="cus_news_subheadline" id="heading_13">
                        <p>
                            <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[12]]['headline']));?>
                        </p>
                    </span>
                </a>
        <?php endif; ?>
        </div>
    </div>
    </div>
    <?php } ?>
<div class="col-md-3" id="side_panel">
    <?php for($fi=0;$fi<4;$fi++):?>
        <?php if(array_key_exists(13+$fi, $region_id_news_id_map)) : ?>
            <div class="row" style="padding-bottom: 20px; min-height: 10px;"><!--top news loop...3 news per row-->
                <?php if($region_id_is_news_ignored_map[13+$fi]==0) : ?>
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[13+$fi]]['id']; ?>"><img style="width:100%;height: 150px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[13+$fi]]['picture'] ?>"/></a>
                <br>
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[13+$fi]]['id']; ?>"><span class="cus_news_subheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[13+$fi]]['headline']));?></p></span></a>
<!--                <span class="cus_news_descr"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[13+$fi]]['summary']));?></p></span>-->
                <?php endif;  ?>                
            </div>
        <?php endif;  ?>
    <?php endfor;?>
</div>
<script>
    var a = <?php echo $show_advertise?>;
    
    if(a) $('#side_panel').hide();
</script>    
