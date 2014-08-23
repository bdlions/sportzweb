<div class="blog_post_home_cards"><!--cards-->
    <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $all_blogs[$cardcount]['id']; ?>">
        <div class="row col-md-12">
            <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $all_blogs[$cardcount]['picture']; ?>"/>
        </div>
        <div class="row col-md-12 top-bottom-padding blog_post_home_cards_heading">
            <?php echo html_entity_decode(html_entity_decode($all_blogs[$cardcount]['title'])); ?>
        </div>
    </a>
    <div class="blog_post_body_text"><?php echo substr(html_entity_decode(html_entity_decode($all_blogs[$cardcount]['description'])), 0, 256) . ' ...'; ?>
        <!--line and below-->
        <hr>
        <a href="#">asdasdasdasd</a>
        <div class="pull-left"><?php echo unix_to_human($all_blogs[$cardcount]['created_on']); ?></div>
        <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $all_blogs[$cardcount]['counted_comment']; ?></div>
    </div>
</div>
