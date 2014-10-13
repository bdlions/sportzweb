<script>
    $(function(){
        $("#button_share_news").on("click", function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "share/share_application",
                dataType: 'json',
                data: {
                    status_category_id: '<?php echo STATUS_CATEGORY_USER_NEWSFEED?>',                    
                    description: $("#text_share").val(),
                    shared_type_id: '<?php echo STATUS_SHARE_NEWS?>',
                    reference_id: <?php echo $news['id']?>
                },
                success: function(data) {
                    window.location = '<?php echo base_url()?>';
                }
            });
        });
    });
</script>


<!-- Modal -->
<div class="modal fade" id="modal_share_news" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalLabel">Share This News</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6"><img src="<?php echo base_url() . NEWS_IMAGE_PATH .$news['picture']; ?>" class="img-responsive" alt="<?php echo html_entity_decode(html_entity_decode($news['summary'])); ?>" /></div>    
                    <div class="col-md-6"><h4><?php echo html_entity_decode(html_entity_decode($news['headline'])); ?></h4><?php echo html_entity_decode(html_entity_decode($news['summary'])); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="padding-top: 24px; padding-bottom: 0px"><textarea id="text_share" name="text_share" style="height: 128px; width: 100%; resize: none;"></textarea></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="button_share_news" name="button_share_news" class="btn btn-primary" data-dismiss="modal"><b>Share</b></button>
            </div>
        </div>
    </div>
</div>



<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
<div class="col-md-9">

    <h2>News</h2>
    <?php $this->load->view("applications/news_app/templates/header_menu"); ?>
    <div class="col-md-12" style="background-color: #F2F2FF;"><!--news display actual-->
        <div class="row">
            <div class="col-md-12">
                <span style="font-size: 18px; color: #0044cc;"><?php echo html_entity_decode(html_entity_decode($news['headline'])); ?></span>
            </div>
        </div>

        <?php echo unix_to_human($news['created_on']) ?><br>
        <img style="width: 100%" src="<?php echo base_url() . NEWS_IMAGE_PATH . $news['picture']; ?>" class="img-responsive" alt="<?php echo strip_tags(html_entity_decode(html_entity_decode($news['headline']))); ?>"/>
        <div class="col-md-12" style="padding-top:20px;padding-right: 0px;">
            <?php echo isset($news['picture_description']) ? html_entity_decode(html_entity_decode($news['picture_description'])) : '';?>
        </div>
        <br><span class="cus_news_descr"><?php echo html_entity_decode(html_entity_decode($news['description'])); ?></span>
    </div>
<!--    <div class="col-md-2 pull-right" style="padding: 16px;"><img src="<?php echo base_url() . NEWS_IMAGE_PATH . "vote_star_active_32.png"; ?>"  alt="Liked:"/> &nbsp;&nbsp;<?php echo count($news['user_liked_list']); ?></div>-->
    <div class="row">
        <div class="col-md-12"><button data-toggle="modal" data-target="#modal_share_news" style="float: right" class="btn btn-default">Share</button></div>
    </div>
    <?php $this->load->view("applications/comments", $this->data); ?>
    
</div>
<div class="col-md-3">

</div>