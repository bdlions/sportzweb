<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/common_styles.css">
<div class="col-md-9" style="background-color: #F5F5F5">
    <div class="form-group">
        <div class="form-group"></div>
        <div class="col-md-12 heading_big">
            <?php echo isset($blog['title']) ? html_entity_decode(html_entity_decode($blog['title'])):''; ?>
        </div>
        <div class="col-md-12 blog_post_subtitle_bar small_text_dark form-group">
            By 
            <?php if($blog['is_user_member'] == 1){ ?>
                <a href="<?php echo base_url(); ?>admin/users_usermanage/display_user_info/<?php echo $blog['user_id']; ?>">
                    <?php echo isset($blog['first_name']) ? $blog['first_name'].' '.$blog['last_name'] : '';?>
                </a>
            <?php }else{
                echo $blog['first_name'].' '.$blog['last_name'];
            } ?>
            
            
            <span class="pull-right small_text_pale">
                <?php
                    if($total_comments<=1){
                        echo '<span id="comment_counter">'.$total_comments.' comment</span>';
                    }
                    else
                    {
                        echo '<span id="comment_counter">'.$total_comments.' comments</span>';
                    }
                ?>
            </span>
        </div>
        <div class="col-md-12 form-group"><!--Images-->
            <?php if(isset($blog['picture'])): ?>
                <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH ?><?php echo $blog['picture']; ?>"/>
            <?php endif; ?>
        </div>
        <div class="col-md-12 form-group small_text_pale">
            <?php echo isset($blog['picture_description']) ? html_entity_decode(html_entity_decode($blog['picture_description'])) : '';?>
        </div>
        <div class="col-md-12 form-group content_text">
            <?php echo isset($blog['description']) ? html_entity_decode(html_entity_decode($blog['description'])) : ''; ?>
        </div>
        <div class="col-md-12 blog_post_subtitle_bar" style="text-align:center;">
            <span class="heading_medium">Related Posts</span>
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
            <?php //$this->load->view("admin/applications/comments", $this->data); ?>
        </div>
    </div>
</div>
<div class="col-md-3">
</div>