<script>
    $(function() {
        $("#button_share_news").on("click", function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "share/share_application",
                dataType: 'json',
                data: {
                    status_category_id: '<?php echo STATUS_CATEGORY_USER_NEWSFEED ?>',
                    description: $("#text_share").val(),
                    shared_type_id: '<?php echo STATUS_SHARE_NEWS ?>',
                    reference_id: <?php echo $news['id'] ?>
                },
                success: function(data) {
                    window.location = '<?php echo base_url() ?>';
                }
            });
        });
    });
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />

<div class="row">
    <div class="col-md-12">
        <h2>News</h2>
        <?php $this->load->view("applications/news_app/templates/header_menu"); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-2">
                <div class="row">
                    <div class="col-md-12">
                        <img class="news_item_logo" src="<?php echo base_url(); ?>resources/images/news_logo.png">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a style="text-decoration: none; color: #000" target="_blank" href="http://www.bbc.com/news" ><h4>BBC News</h4></a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">

                <div class="heading_big">
                    <?php echo html_entity_decode(html_entity_decode($news['headline'])); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="small_text_pale">
                    <?php echo $news['created_on'] ?>
                </div>
                <img style="width: 100%" class="img-responsive"
                     src="<?php echo base_url() . NEWS_IMAGE_PATH . $news['picture']; ?>"
                     alt="<?php echo strip_tags(html_entity_decode(html_entity_decode($news['headline']))); ?>"/>
                <div class="small_text_pale">
                    <?php
                    echo isset($news['picture_description']) ? html_entity_decode(html_entity_decode($news['picture_description'])) : '';
                    ?>
                </div>
                <div class="form-group content_text"><?php echo html_entity_decode(html_entity_decode($news['description'])); ?></div>
                <div class="row">
                    <div class="col-md-12">
                        <button data-toggle="modal" data-target="#modal_share_news" class="btn btn-default pull-right">Share</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <?php $this->load->view("applications/comments", $this->data); ?>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_share_news" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalLabel">Share This News</h3>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-6"><img src="<?php echo base_url() . NEWS_IMAGE_PATH . $news['picture']; ?>" class="img-responsive" alt="<?php echo html_entity_decode(html_entity_decode($news['summary'])); ?>" /></div>    
                    <div class="col-md-6"><h4><?php echo html_entity_decode(html_entity_decode($news['headline'])); ?></h4><?php echo html_entity_decode(html_entity_decode($news['summary'])); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><textarea id="text_share" class="form-control"></textarea></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="button_share_news" name="button_share_news" class="btn btn-primary" data-dismiss="modal"><b>Share</b></button>
            </div>
        </div>
    </div>
</div>

