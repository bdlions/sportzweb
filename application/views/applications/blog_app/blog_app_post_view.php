<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<script>
    $(function(){
        $("#button_share_blog").on("click", function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "share/share_application",
                dataType: 'json',
                data: {
                    status_category_id: '<?php echo STATUS_CATEGORY_USER_NEWSFEED?>',                    
                    description: $("#text_share").val(),
                    shared_type_id: '<?php echo STATUS_SHARE_BLOG?>',
                    reference_id: <?php echo $blog['id']?>
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
                <h3 class="modal-title" id="myModalLabel">Share This Blog Post</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6"><img src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog['picture']; ?>" class="img-responsive" alt="<?php echo isset($blog['title']) ? html_entity_decode(html_entity_decode($blog['title'])):'<no_title>'; ?>" /></div>    
                    <div class="col-md-6"><h4><?php echo isset($blog['title']) ? html_entity_decode(html_entity_decode($blog['title'])):'<no_title>'; ?></h4>By: <?php echo isset($blog['first_name']) ? $blog['first_name'].' '.$blog['last_name'] : '';?></div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="padding-top: 24px; padding-bottom: 0px"><textarea id="text_share" name="text_share" style="height: 128px; width: 100%; resize: none;"></textarea></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="button_share_blog" name="button_share_blog" class="btn btn-primary" data-dismiss="modal"><b>Share</b></button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("applications/blog_app/templates/header_menu"); ?>
<div class="col-md-9" style="background-color: #F5F5F5">
    <div class="col-md-12" style="padding-bottom: 8px;">
        <div class="col-md-12">
            <span class="blog_post_title"><?php echo isset($blog['title']) ? html_entity_decode(html_entity_decode($blog['title'])):''; ?></span>
        </div>
        <div class="col-md-12 blog_post_subtitle_bar">
            <span class="blog_post_body_text">
                By
                <?php if($blog['is_user_member'] == 1){ ?>
                    <a href="<?php echo base_url(); ?>member_profile/show/<?php echo $blog['user_id']; ?>">
                        <?php echo isset($blog['first_name']) ? $blog['first_name'].' '.$blog['last_name'] : '';?>
                    </a>
                <?php }else{
                    echo $blog['first_name'].' '.$blog['last_name'];
                } ?>
            </span>
            <div id="total_comments">
                <span class="pull-right">
                    <a href="#">
                        <?php
                            if($total_comments<=1){
                                echo '<span id="comment_counter">'.$total_comments.' comment</span>';
                            }
                            else
                            {
                                echo '<span id="comment_counter">'.$total_comments.' comments</span>';
                            }
                        ?>
                    </a>
                </span>
            </div>
        </div>
        <div class="col-md-12" style="padding:24px"><!--Images-->
            <?php if(isset($blog['picture'])): ?>
                <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH ?><?php echo $blog['picture']; ?>"/>
            <?php endif; ?>
                <div class="col-md-12" style="padding-top:20px;padding-right: 0px;padding-left: 0px;">
                    <?php echo isset($blog['picture_description']) ? html_entity_decode(html_entity_decode($blog['picture_description'])) : '';?>
                </div>
        </div>
        
        <div class="blog_post_body_text">
            <?php echo isset($blog['description']) ? html_entity_decode(html_entity_decode($blog['description'])) : ''; ?>
        </div>
        <div class="col-md-12 blog_post_subtitle_bar" style="text-align:center;">
            <span class="blog_post_body_text" style="font-size: 24px; font-weight: normal;">Related Posts</span>
        </div>
        <div>
            <div class="col-md-12" style="margin-top: 30px; margin-bottom: 30px;">
                <?php if (count($related_blogs) > 0) : ?>
                    <?php foreach ($related_blogs as $row): ?>
                        <div class="col-md-4">
                            <img width="200"  class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH ?><?php echo $row['picture']; ?>"/>
                            <br>
                            <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $row['id']; ?>"><?php echo html_entity_decode(html_entity_decode($row['title'])); ?></a>
                        </div>
                       
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <br>
           
            <div class="row">
                <div class="col-md-12"><button data-toggle="modal" data-target="#modal_share_news" style="float: right" class="btn btn-default">Share</button></div>
            </div>
            <?php $this->load->view("applications/comments", $this->data); ?>
        </div>
    </div>
</div>
<div class="col-md-3">
</div>