<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
<script src="<?php echo base_url(); ?>resources/bootstrap3/js/tmpl.js"></script>
<script type="text/javascript">
    $(function() {
        var show_advertise = <?php echo $show_advertise;?>;    
        if(show_advertise == 1) $('#side_panel').hide();
        var news_id_list = Array();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/news_app/get_breaking_latest_news_list",
            data: {
            },
            success: function(data) {
                $("#news").html(tmpl("tmpl_breaking_news_list", data['breaking_news_list']));
                $("#news").html($("#news").html()+tmpl("tmpl_latest_news_list", data['latest_news_list']));
                var news_counter = 0;
                for(var counter = 0; counter < data['breaking_news_list'].length; counter++)
                {
                    news_id_list[news_counter++] = data['breaking_news_list'][counter]['news_id'];
                }
                for(var counter = 0; counter < data['latest_news_list'].length; counter++)
                {
                    news_id_list[news_counter++] = data['latest_news_list'][counter]['news_id'];
                }
                var randomNewsNumber = Math.floor(Math.random() * news_id_list.length);
                $("#news_" + randomNewsNumber).show();
                setInterval(function() {
                    var randomNewsNumber = Math.floor(Math.random() * news_id_list.length);
//                    console.log(news_id_list[randomNewsNumber]);
                    for (var i = 0; i < news_id_list.length; i++) {
                        $("#news_" + news_id_list[i]).hide();
                    }
                    $("#news_" + news_id_list[randomNewsNumber]).show();
                }, 6000);
            }
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_breaking_news_list">
    {% var i=0, breaking_news = ((o instanceof Array) ? o[i++] : o); %}
    {% while(breaking_news){ %}
        <div class="col-md-12 cus_news_flyer cus_news_flyer_breaking" style="display:none;" id = "news_{%= breaking_news.news_id%}"><a href="<?php echo base_url().'applications/news_app/news_item/{%= breaking_news.news_id%}';?>"><?php echo '{%= breaking_news.headline%}'; ?></a></div>
    {% breaking_news = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<script type="text/x-tmpl" id="tmpl_latest_news_list">
    {% var i=0, latest_news = ((o instanceof Array) ? o[i++] : o); %}
    {% while(latest_news){ %}
        <div class="col-md-12 cus_news_flyer cus_news_flyer_latest" style="display:none;" id = "news_{%= latest_news.news_id%}"><a href="<?php echo base_url().'applications/news_app/news_item/{%= latest_news.news_id%}';?>"><?php echo '{%= latest_news.headline%}'; ?></a></div>
    {% latest_news = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h1>News</h1>
<?php $this->load->view("applications/news_app/templates/header_menu"); ?>
<div class="col-md-9" style="padding-left: 0px; padding-right: 30px;">
    <div id="news">
        <!-- this is an empty div for all news. do not delete this -->
    </div>
    <?php if (array_key_exists(0, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[0], $news_id_news_info_map)){ ?>
    <div class="row" style="padding-bottom: 20px"><!--Greatest news-->
        <div class="col-md-6 col-lg-6">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[0]]['id']; ?>"><img style="width:100%;" class="img-responsive" src="<?php echo base_url() . NEWS_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[0]]['picture'] ?>"/></a>
        </div>
        <div class="col-md-6 col-lg-6">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[0]]['id']; ?>">
                <span class="heading_big">
                    <p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[0]]['headline']));?></p>
                </span>
            </a>
            <span class="content_text">
                <p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[0]]['summary']));?></p>
            </span>
        </div>
    </div>
    <?php } ?>
    <div class="row" style="padding-bottom: 20px"><!--top news loop...3 news per row-->
        <?php for($i=1;$i<=3;$i++):?>
            <?php if (array_key_exists($i, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[$i], $news_id_news_info_map)){ ?> 
                <div class="col-md-4 col-lg-4">
                    <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[$i]]['id']; ?>"><img style="width:100%;height: 150px;" class="img-responsive" src="<?php echo base_url() . NEWS_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[$i]]['picture'] ?>"/></a>
                    <br>
                    <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[$i]]['id']; ?>"><span class="heading_medium"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[$i]]['headline']));?></p></span></a>
                    <span class="content_text"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[$i]]['summary']));?></p></span>
                </div>
            <?php } ?>
        <?php endfor; ?>
    </div>    
    <div class="row" style="padding-bottom: 10px"><!--small news loop...2 news per row-->
        <?php if(array_key_exists(4, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[4], $news_id_news_info_map)){?>
            <div class="col-md-3 col-lg-3">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[4]]['id']; ?>"><img style="width:100%" class="img-responsive" src="<?php echo base_url() . NEWS_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[4]]['picture'] ?>"/></a>
            </div>        
            <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[4]]['id']; ?>"><span class="heading_medium"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[4]]['headline']));?></p></span></a>
            </div>
        <?php } ?>
        <?php if(array_key_exists(5, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[5], $news_id_news_info_map)){?>
            <div class="col-md-3 col-lg-3">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[5]]['id']; ?>"><img style="width:100%" class="img-responsive" src="<?php echo base_url() . NEWS_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[5]]['picture'] ?>"/></a>
            </div>
            <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[5]]['id']; ?>"><span class="heading_medium"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[5]]['headline']));?></p></span></a>
            </div>
        <?php } ?>
    </div>
    <div class="row" style="padding-bottom: 10px"><!--small news loop...2 news per row-->
    <?php if(array_key_exists(6, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[6], $news_id_news_info_map)){?>
        <div class="col-md-3 col-lg-3">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[6]]['id']; ?>"><img style="width:100%;" class="img-responsive" src="<?php echo base_url() . NEWS_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[6]]['picture'] ?>"/></a>
        </div>
        <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[6]]['id']; ?>"><span class="heading_medium"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[6]]['headline']));?></p></span></a>
        </div>
    <?php } ?>
    <?php if(array_key_exists(7, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[7], $news_id_news_info_map)){?>
        <div class="col-md-3 col-lg-3">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[7]]['id']; ?>"><img style="width:100%;" class="img-responsive" src="<?php echo base_url() . NEWS_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[7]]['picture'] ?>"/></a>
        </div>
        <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[7]]['id']; ?>"><span class="heading_medium"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[7]]['headline']));?></p></span></a>
        </div>
    <?php } ?>
    </div>
    <div class="row" style="padding-bottom: 10px; padding-top: 30px"><!--small news area-->
        <div class="col-md-8 col-lg-8"><!--small news loop...2 news per row-->            
            <div class="row">
                <?php if(array_key_exists(8, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[8], $news_id_news_info_map)){?>
                    <div class="col-md-6 col-lg-6">
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[8]]['id']; ?>"><span class="cus_news_smallheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[8]]['headline']));?></p></span></a>
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[8]]['id']; ?>"><span class="content_text"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[8]]['summary']));?></p></span></a>
                    </div>
                <?php } ?>                    
                <?php if(array_key_exists(9, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[9], $news_id_news_info_map)){?>
                    <div class="col-md-6 col-lg-6">
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[9]]['id']; ?>"><span class="cus_news_smallheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[9]]['headline'])) ;?></p></span></a>
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[9]]['id']; ?>"><span class="content_text"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[9]]['summary']));?></p></span></a>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <?php if(array_key_exists(10, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[10], $news_id_news_info_map)){?>
                    <div class="col-md-6 col-lg-6">
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[10]]['id']; ?>"><span class="cus_news_smallheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[10]]['headline']));?></p></span></a>
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[10]]['id']; ?>"><span class="content_text"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[10]]['summary']));?></p></span></a>
                    </div>
                <?php } ?>                    
                <?php if(array_key_exists(11, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[11], $news_id_news_info_map)){?>
                    <div class="col-md-6 col-lg-6">
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[11]]['id']; ?>"><span class="cus_news_smallheadline"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[11]]['headline']));?></p></span></a>
                        <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[11]]['id']; ?>"><span class="content_text"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[11]]['summary']));?></p></span></a>
                    </div>
                <?php } ?>
            </div>            
        </div>        
        <?php if(array_key_exists(12, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[12], $news_id_news_info_map)){?>
        <div class="col-md-4 col-lg-4">
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[12]]['id']; ?>"><img style="width: 100%;" class="img-responsive" src="<?php echo base_url() . NEWS_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[12]]['picture'] ?>"/></a>
            <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[12]]['id']; ?>"><span class="heading_medium"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[12]]['headline']));?></p></span></a>
            <span class="content_text"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[12]]['summary']));?></p></span>
        </div>
        <?php } ?>
    </div>
</div>
<div class="col-md-3" id="side_panel">
    <?php for($fi=0;$fi<4;$fi++):?>
        <?php if(array_key_exists(13+$fi, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[13+$fi], $news_id_news_info_map)){?>
            <div class="row" style="padding-bottom: 20px"><!--top news loop...3 news per row-->
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[13+$fi]]['id']; ?>"><img style="width:100%;" class="img-responsive" src="<?php echo base_url() . NEWS_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[13+$fi]]['picture'] ?>"/></a>
                <br>
                <a href="<?php echo base_url() . 'applications/news_app/news_item/'.$news_id_news_info_map[$region_id_news_id_map[13+$fi]]['id']; ?>"><span class="heading_medium"><p><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[13+$fi]]['headline']));?></p></span></a>
                <span class="content_text"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[13+$fi]]['summary']));?></span>
            </div>
        <?php }  ?>
    <?php endfor;?>
</div>