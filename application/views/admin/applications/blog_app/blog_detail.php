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
                    <?php echo isset($user_info['first_name']) ? $user_info['first_name'].' '.$user_info['last_name'] : '';?>
                </a><!-- / in 
                <a href="#comment-form">Models Photos
                    
                </a>-->
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
            <!--body caption-->

            <!--            <div class="col-md-offset-2 col-md-8 blog_post_body_caption">
                The bedding was hardly able to cover it and seemed ready to slide off any moment.
            </div>-->

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
            <?php $this->load->view("admin/applications/comments", $this->data); ?>
        </div>
    </div>
</div>
<div class="col-md-3">
</div>