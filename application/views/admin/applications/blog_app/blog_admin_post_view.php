<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<div class="col-md-9" style="background-color: #F5F5F5">
    <div class="col-md-12" style="padding-bottom: 8px;">
        <div class="col-md-12">
            <span class="blog_post_title"><?php echo isset($blog['title']) ? html_entity_decode(html_entity_decode($blog['title'])):''; ?></span>
        </div>
        <div class="col-md-12 blog_post_subtitle_bar">
            <span class="blog_post_body_text">
                By 
                <a href="#comment-form">
                    <?php echo isset($blog['first_name']) ? $blog['first_name'].' '.$blog['last_name'] : '';?>
                </a>
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
        </div>
        <div class="blog_post_body_text">
            <?php echo isset($blog['description']) ? html_entity_decode(html_entity_decode($blog['description'])) : ''; ?>
        </div>
    </div>
</div>
<div class="col-md-3">
</div>