<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
<script type="text/javascript">
    $(function() {
        var latestNews = <?php echo json_encode($latest_news) ?>;
        var breakingNews = <?php echo json_encode($breaking_news) ?>;
        var totalNews = latestNews.length + breakingNews.length;
        var count = 1;
        for (var i = 0; i < latestNews.length; i++) {
            var content = latestNews[ i ]['headline'];
            var text = $(content).text();
            $("#news").append("<div class='col-md-12 cus_news_flyer cus_news_flyer_latest' style='display:none;' id = 'news_" + count + "'><a href='<?php echo base_url().'applications/news_app/news_item/';?>"+latestNews[ i ]['id']+"'>Latest News: " + text + "</a> </div>");
            count++;
        }

        for (var i = 0; i < breakingNews.length; i++) {
            var content  = breakingNews[ i ]['headline'];
            var text = $(content).text();
            $("#news").append("<div class='col-md-12 cus_news_flyer cus_news_flyer_breaking' style='display:none;' id = 'news_" + count + "'><a href='<?php echo base_url()."applications/news_app/news_item/"; ?>"+breakingNews[ i ]['id']+"'>Breaking News: " + text + "</a> </div>");
            count++;
        }
        var randomNewsNumber = Math.floor(Math.random() * totalNews) + 1;
        $("#news_" + randomNewsNumber).show();
        setInterval(function() {
            var randomNewsNumber = Math.floor(Math.random() * totalNews) + 1;

            for (var i = 1; i <= totalNews; i++) {
                $("#news_" + i).hide();
            }
            $("#news_" + randomNewsNumber).show();

        }, 6000);

    });
</script>

<h1>News</h1>
<?php $this->load->view("applications/news_app/templates/header_menu"); ?>
<div class="col-md-9" style="padding-left: 0px; padding-right: 30px;">
    <div id="news">
        <!-- this is an empty div for all news. do not delete this -->
    </div>
<?php if(count($region_id_news_id_map) >= 13): ?>
<?php if (array_key_exists(0, $region_id_news_id_map)) : ?>
    <div class="row" style="padding-bottom: 20px"><!--Greatest news-->
        <div class="col-md-6 col-lg-6">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[0]]['id']; ?>"><img style="width:100%;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_TOP_LEFT_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[0]]['picture'] ?>"/></a>
        </div>
        <div class="col-md-6 col-lg-6">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[0]]['id']; ?>"><span class="cus_news_headline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[0]]['headline']));?></p></span></a>
            <span class="cus_news_descr"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[0]]['summary']));?></p></span>
        </div>
    </div>
<?php endif; ?>
<?php endif; ?>
    
<?php if(count($region_id_news_id_map)>=4): ?>
    <div class="row" style="padding-bottom: 20px"><!--top news loop...3 news per row-->
<?php for($i=1;$i<=3;$i++):?>
    <?php if (array_key_exists($i, $region_id_news_id_map)) : ?> 
        <div class="col-md-4 col-lg-4">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[$i]]['id']; ?>"><img style="width:100%;height: 150px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[$i]]['picture'] ?>"/></a>
            <br>
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[$i]]['id']; ?>"><span class="cus_news_subheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[$i]]['headline']));?></p></span></a>
            <span class="cus_news_descr"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[$i]]['summary']));?></p></span>
        </div>
    <?php endif; ?>
<?php endfor; ?>
    </div>
<?php endif; ?>
    
<?php if(count($region_id_news_id_map)>=8): ?>
    <div class="row" style="padding-bottom: 10px"><!--small news loop...2 news per row-->
    <?php if(array_key_exists(4, $region_id_news_id_map)) : ?>
        <div class="col-md-3 col-lg-3">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[4]]['id']; ?>"><img style="width:100%" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[4]]['picture'] ?>"/></a>
        </div>
    <?php endif; ?>
        <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[4]]['id']; ?>"><span class="cus_news_subheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[4]]['headline']));?></p></span></a>
        </div>
    <?php if(array_key_exists(5, $region_id_news_id_map)) : ?>
        <div class="col-md-3 col-lg-3">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[5]]['id']; ?>"><img style="width:100%" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[5]]['picture'] ?>"/></a>
        </div>
        <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[5]]['id']; ?>"><span class="cus_news_subheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[5]]['headline']));?></p></span></a>
        </div>
    <?php endif; ?>
    </div>
<?php endif; ?>
    
    <div class="row" style="padding-bottom: 10px"><!--small news loop...2 news per row-->
    <?php if(array_key_exists(6, $region_id_news_id_map)) : ?>
        <div class="col-md-3 col-lg-3">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[6]]['id']; ?>"><img style="width:100%;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[6]]['picture'] ?>"/></a>
        </div>
        <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[6]]['id']; ?>"><span class="cus_news_subheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[6]]['headline']));?></p></span></a>
        </div>
    <?php endif; ?>

    <?php if(array_key_exists(7, $region_id_news_id_map)) : ?>
        <div class="col-md-3 col-lg-3">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[7]]['id']; ?>"><img style="width:100%;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[7]]['picture'] ?>"/></a>
        </div>
        <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[7]]['id']; ?>"><span class="cus_news_subheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[7]]['headline']));?></p></span></a>
        </div>
    <?php endif; ?>
    </div>
    <div class="row" style="padding-bottom: 10px; padding-top: 30px"><!--small news area-->
        <div class="col-md-8 col-lg-8"><!--small news loop...2 news per row-->
            
                <div class="row">
                    <?php if(array_key_exists(8, $region_id_news_id_map)) : ?>
                        <div class="col-md-6 col-lg-6">
                            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[8]]['id']; ?>"><span class="cus_news_smallheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[8]]['headline']));?></p></span></a>
                            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[8]]['id']; ?>"><span class="cus_news_descr"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[8]]['summary']));?></p></span></a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(array_key_exists(9, $region_id_news_id_map)) : ?>
                        <div class="col-md-6 col-lg-6">
                            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[9]]['id']; ?>"><span class="cus_news_smallheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[9]]['headline'])) ;?></p></span></a>
                            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[9]]['id']; ?>"><span class="cus_news_descr"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[9]]['summary']));?></p></span></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <?php if(array_key_exists(10, $region_id_news_id_map)) : ?>
                        <div class="col-md-6 col-lg-6">
                            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[10]]['id']; ?>"><span class="cus_news_smallheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[10]]['headline']));?></p></span></a>
                            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[10]]['id']; ?>"><span class="cus_news_descr"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[10]]['summary']));?></p></span></a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(array_key_exists(11, $region_id_news_id_map)) : ?>
                        <div class="col-md-6 col-lg-6">
                            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[11]]['id']; ?>"><span class="cus_news_smallheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[11]]['headline']));?></p></span></a>
                            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[11]]['id']; ?>"><span class="cus_news_descr"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[11]]['summary']));?></p></span></a>
                        </div>
                    <?php endif; ?>
                </div>
            
        </div>
        
    <?php if(array_key_exists(12, $region_id_news_id_map)) : ?>
        <div class="col-md-4 col-lg-4">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[12]]['id']; ?>"><img style="width: 100%;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[12]]['picture'] ?>"/></a>
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[12]]['id']; ?>"><span class="cus_news_subheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[12]]['headline']));?></p></span></a>
            <span class="cus_news_descr"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[12]]['summary']));?></p></span>
        </div>
    <?php endif; ?>
    </div>
</div>

<div class="col-md-3" id="side_panel">
    <?php for($fi=0;$fi<4;$fi++):?>
        <?php if(array_key_exists(13+$fi, $region_id_news_id_map)) : ?>
            <div class="row" style="padding-bottom: 20px"><!--top news loop...3 news per row-->
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[13+$fi]]['id']; ?>"><img style="width:100%;height: 150px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[13+$fi]]['picture'] ?>"/></a>
                <br>
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[13+$fi]]['id']; ?>"><span class="cus_news_subheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[13+$fi]]['headline']));?></p></span></a>
<!--                <span class="cus_news_descr"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[13+$fi]]['summary']));?></p></span>-->
            </div>
        <?php endif;  ?>
    <?php endfor;?>
</div>

<script>
    var a = <?php echo $show_advertise;?>;
    
    if(a) $('#side_panel').hide();
</script>
