<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<?php $this->load->view("applications/blog_app/templates/header_menu"); ?>
    <?php if ($show_advertise): ?>
        <div class="row col-md-9" >
            <div style="padding: 8px; background-color: #F5F5F5; padding-right:25px;">
            <?php else: ?>
                <div class="col-md-12" style="padding: 8px; background-color: #F5F5F5">
                <?php endif; ?>

                <div class="row"><!--place cards here-->
                    <?php if ($show_advertise): ?>
                        <div class="col-md-12" style="padding-right: 0px;">
                        <?php else: ?>
                            <div class="col-md-9" style="padding-right: 0px;">
                            <?php endif; ?>

                            <?php if (count($region_id_blog_id_map) > 0): ?>
                                <?php $cardcount = 0; ?>
                                <div class="col-md-4" style="padding-left: 0px;">
                                    <?php if (array_key_exists($cardcount, $region_id_blog_id_map)): ?>
                                        <div class="blog_post_home_cards"><!--cards-->
                                            <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['blog_id']; ?>">
                                                <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['picture']; ?>"/>
                                                <br>
                                                <span class="heading_medium"><!--card heading-->
                                                    <h2>
                                                        <?php echo html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['title'])); ?>
                                                    </h2>
                                                </span>
                                            </a>
                                            <div class="content_text"><?php echo substr(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['description'])), 0, 256) . ' ...'; ?>
                                                <!--line and below-->
                                                <hr>
                                                <div class="pull-left"><?php // echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['created_on'];     ?></div>
                                                <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['total_comments']; ?></div>
                                            </div>
                                        </div>
                                        <?php $cardcount++; ?>
                                    <?php endif; ?>

                                    <?php if (array_key_exists($cardcount, $region_id_blog_id_map)): ?>
                                        <div class="blog_post_home_cards"><!--cards-->
                                            <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['blog_id']; ?>">
                                                <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['picture']; ?>"/>
                                                <br>
                                                <span class="heading_medium"><!--card heading-->
                                                    <h2>
                                                        <?php echo html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['title'])); ?>
                                                    </h2>
                                                </span>
                                            </a>
                                            <div class="content_text"><?php echo substr(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['description'])), 0, 256) . ' ...'; ?>
                                                <!--line and below-->
                                                <hr>
                                                <div class="pull-left"><?php // echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['created_on'];     ?></div>
                                                <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['total_comments']; ?></div>
                                            </div>
                                        </div>                        
                                        <?php $cardcount++; ?>
                                    <?php endif; ?>

                                </div>
                                <div class="col-md-4" style="padding-left: 0px;">
                                    <?php if (array_key_exists($cardcount, $region_id_blog_id_map)): ?>
                                        <div class="blog_post_home_cards"><!--cards-->
                                            <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['blog_id']; ?>">
                                                <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['picture']; ?>"/>
                                                <br>
                                                <span class="heading_medium"><!--card heading-->
                                                    <h2>
                                                        <?php echo html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['title'])); ?>
                                                    </h2>
                                                </span>
                                            </a>
                                            <div class="content_text"><?php echo substr(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['description'])), 0, 256) . ' ...'; ?>
                                                <!--line and below-->
                                                <hr>
                                                <div class="pull-left"><?php // echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['created_on'];     ?></div>
                                                <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['total_comments']; ?></div>
                                            </div>
                                        </div>
                                        <?php $cardcount++; ?>
                                    <?php endif; ?>

                                    <?php if (array_key_exists($cardcount, $region_id_blog_id_map)): ?>
                                        <div class="blog_post_home_cards"><!--cards-->
                                            <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['id']; ?>">
                                                <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['picture']; ?>"/>
                                                <br>
                                                <span class="heading_medium"><!--card heading-->
                                                    <h2>
                                                        <?php echo html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['title'])); ?>
                                                    </h2>
                                                </span>
                                            </a>
                                            <div class="content_text"><?php echo substr(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['description'])), 0, 256) . ' ...'; ?>
                                                <!--line and below-->
                                                <hr>
                                                <div class="pull-left"><?php // echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['created_on'];     ?></div>
                                                <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['total_comments']; ?></div>
                                            </div>
                                        </div>
                                        <?php $cardcount++; ?>
                                    <?php endif; ?>

                                </div>
                                <div class="col-md-4" style="padding-left: 0px;">
                                    <?php if (array_key_exists($cardcount, $region_id_blog_id_map)): ?>
                                        <div class="blog_post_home_cards"><!--cards-->
                                            <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['id']; ?>">
                                                <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['picture']; ?>"/>
                                                <br>
                                                <span class="heading_medium"><!--card heading-->
                                                    <h2>
                                                        <?php echo html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['title'])); ?>
                                                    </h2>
                                                </span>
                                            </a>
                                            <div class="content_text"><?php echo substr(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['description'])), 0, 256) . ' ...'; ?>
                                                <!--line and below-->
                                                <hr>
                                                <div class="pull-left"><?php // echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['created_on'];     ?></div>
                                                <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['total_comments']; ?></div>
                                            </div>
                                        </div>
                                        <?php $cardcount++; ?>
                                    <?php endif; ?>

                                    <?php if (array_key_exists($cardcount, $region_id_blog_id_map)): ?>
                                        <div class="blog_post_home_cards"><!--cards-->
                                            <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['id']; ?>">
                                                <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['picture']; ?>"/>
                                                <br>
                                                <span class="heading_medium"><!--card heading-->
                                                    <h2>
                                                        <?php echo html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['title'])); ?>
                                                    </h2>
                                                </span>
                                            </a>
                                            <div class="content_text"><?php echo substr(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['description'])), 0, 256) . ' ...'; ?>
                                                <!--line and below-->
                                                <hr>
                                                <div class="pull-left"><?php // echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['created_on'];     ?></div>
                                                <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['total_comments']; ?></div>
                                            </div>
                                        </div>
                                        <?php $cardcount++; ?>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!$show_advertise) { ?>
                            <div class="col-md-3" style="padding-left: 0px;">
                                <div class="col-md-12" style="padding-left: 0px;">
                                    <?php if (array_key_exists($cardcount, $region_id_blog_id_map)): ?>
                                        <div class="blog_post_home_cards"><!--cards-->
                                            <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['id']; ?>">
                                                <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['picture']; ?>"/>
                                                <br>
                                                <span class="heading_medium"><!--card heading-->
                                                    <h2>
                                                        <?php echo html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['title'])); ?>
                                                    </h2>
                                                </span>
                                            </a>
                                            <div class="content_text"><?php echo substr(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['description'])), 0, 256) . ' ...'; ?>
                                                <!--line and below-->
                                                <hr>
                                                <div class="pull-left"><?php // echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['created_on'];     ?></div>
                                                <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['total_comments']; ?></div>
                                            </div>
                                        </div>
                                        <?php $cardcount++; ?>
                                    <?php endif; ?>

                                    <?php if (array_key_exists($cardcount, $region_id_blog_id_map)): ?>
                                        <div class="blog_post_home_cards"><!--cards-->
                                            <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['id']; ?>">
                                                <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['picture']; ?>"/>
                                                <br>
                                                <span class="heading_medium"><!--card heading-->
                                                    <h2>
                                                        <?php echo html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['title'])); ?>
                                                    </h2>
                                                </span>
                                            </a>
                                            <div class="content_text"><?php echo substr(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['description'])), 0, 256) . ' ...'; ?>
                                                <!--line and below-->
                                                <hr>
                                                <div class="pull-left"><?php // echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['created_on'];     ?></div>
                                                <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$cardcount]]['total_comments']; ?></div>
                                            </div>
                                        </div>
                                        <?php $cardcount++; ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php } ?>    
                    </div>
                </div>    
            </div>
        </div>
    </div>


<script type="text/javascript">
    var a = <?php echo $show_advertise; ?>;

    if (a == 1)
        $('#right_panel').hide();
</script>