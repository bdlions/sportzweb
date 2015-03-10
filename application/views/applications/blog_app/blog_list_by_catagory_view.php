<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<?php $this->load->view("applications/blog_app/templates/header_menu"); ?>
<div class="col-md-9" style="background-color: #F5F5F5">
    <div class="col-md-12" style="border-bottom: 1px solid #cccccc; padding-bottom: 8px;"><!--heading-->

        <div class="row"><!--place cards here-->
            <?php if (!empty($all_blogs_by_category)) { ?>
                <?php $blog_count = count($all_blogs_by_category); ?>
                <?php $all_blogs = $all_blogs_by_category; ?>
                <?php $height = (int) ($blog_count / 3); ?>
                <?php $mod = $blog_count % 3; ?>
                <?php $card = 0; ?>
            
            
                    <?php if (count($all_blogs) > 0): ?>
                        <div class="col-md-4" style="padding-left: 0px;">
                        <?php for($cardcount=0;$cardcount<count($blog_col_1);$cardcount++): ?>
                            <?php if (array_key_exists($cardcount, $blog_col_1)): ?>
                                <div class="blog_post_home_cards"><!--cards-->
                                    <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $blog_col_1[$cardcount]['id']; ?>">
                                        <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_col_1[$cardcount]['picture']; ?>"/>
                                        <br>
                                        <span class="heading_medium"><!--card heading-->
                                            <h2>
                                                <?php echo html_entity_decode(html_entity_decode($blog_col_1[$cardcount]['title'])); ?>
                                            </h2>
                                        </span>
                                    </a>
                                    <div class="content_text"><?php echo substr(html_entity_decode(html_entity_decode($blog_col_1[$cardcount]['description'])), 0, 256) . ' ...'; ?>
                                        <!--line and below-->
                                        <hr>
                                        <div class="pull-left"><?php echo unix_to_human($blog_col_1[$cardcount]['created_on']); ?></div>
                                        <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $blog_col_1[$cardcount]['counted_comment']; ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php endfor; ?>
                            
                        </div>
                        <?php $cardcount = 0; ?>
                        <div class="col-md-4" style="padding-left: 0px;">
                            <?php for($cardcount=0;$cardcount<count($blog_col_2);$cardcount++): ?>
                            <?php if (array_key_exists($cardcount, $blog_col_2)): ?>
                                <div class="blog_post_home_cards"><!--cards-->
                                    <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $blog_col_2[$cardcount]['id']; ?>">
                                        <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_col_2[$cardcount]['picture']; ?>"/>
                                        <br>
                                        <span class="heading_medium"><!--card heading-->
                                            <h2>
                                                <?php echo html_entity_decode(html_entity_decode($blog_col_2[$cardcount]['title'])); ?>
                                            </h2>
                                        </span>
                                    </a>
                                    <div class="content_text"><?php echo substr(html_entity_decode(html_entity_decode($blog_col_2[$cardcount]['description'])), 0, 256) . ' ...'; ?>
                                        <!--line and below-->
                                        <hr>
                                        <div class="pull-left"><?php echo unix_to_human($blog_col_2[$cardcount]['created_on']); ?></div>
                                        <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $blog_col_2[$cardcount]['counted_comment']; ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php endfor; ?>


                        </div>
                        <?php $cardcount = 0; ?>
                        <div class="col-md-4" style="padding-left: 0px;">
                            <?php for($cardcount=0;$cardcount<count($blog_col_3);$cardcount++): ?>
                            <?php if (array_key_exists($cardcount, $blog_col_3)): ?>
                                <div class="blog_post_home_cards"><!--cards-->
                                    <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $blog_col_3[$cardcount]['id']; ?>">
                                        <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_col_3[$cardcount]['picture']; ?>"/>
                                        <br>
                                        <span class="heading_medium"><!--card heading-->
                                            <h2>
                                                <?php echo html_entity_decode(html_entity_decode($blog_col_3[$cardcount]['title'])); ?>
                                            </h2>
                                        </span>
                                    </a>
                                    <div class="content_text"><?php echo substr(html_entity_decode(html_entity_decode($blog_col_3[$cardcount]['description'])), 0, 256) . ' ...'; ?>
                                        <!--line and below-->
                                        <hr>
                                        <div class="pull-left"><?php echo unix_to_human($blog_col_3[$cardcount]['created_on']); ?></div>
                                        <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $blog_col_3[$cardcount]['counted_comment']; ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php endfor; ?>

                        </div>
                        <?php $cardcount = 0; ?>
                    <?php endif; ?>

            
            <?php } ?>
        </div>
    </div>



</div>
<div class="col-md-3">
</div>
