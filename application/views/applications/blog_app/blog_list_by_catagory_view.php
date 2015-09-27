<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<?php $this->load->view("applications/blog_app/templates/header_menu"); ?>
<div class="col-md-12" style="background-color: #F5F5F5">
    <div class="col-md-12" style="border-bottom: 1px solid #cccccc; padding-bottom: 8px;"><!--heading-->
        <div class="row"><!--place cards here-->
            <?php
            for($column_counter = 0; $column_counter < $total_columns; $column_counter++){
            ?>
            <div class="col-md-3" style="padding-left: 0px;">
                <?php
                $blog_counter = $column_counter;
                while($blog_counter <= $total_blogs){
                    if(array_key_exists($blog_counter, $blog_list))
                    {
                        $blog_info = $blog_list[$blog_counter];
                ?>
                        <div class="blog_post_home_cards"><!--cards-->
                            <a href="<?php echo base_url(); ?>applications/blog_app/view_blog_post/<?php echo $blog_info['id']; ?>">
                                <?php if(isset($blog_info['picture']) && !empty($blog_info['picture'])){?>
                                <img class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_info['picture']; ?>"/>
                                <?php } ?>
                                <br>
                                <span class="heading_medium"><!--card heading-->
                                    <h2>
                                        <?php echo html_entity_decode(html_entity_decode($blog_info['title'])); ?>
                                    </h2>
                                </span>
                            </a>
                            <div class="content_text"><?php echo substr(strip_tags(html_entity_decode(html_entity_decode($blog_info['description']))), 0, 256) . ' ...'; ?>
                                <!--line and below-->
                                <hr>
                                <div class="pull-right"><img src="<?php echo base_url(); ?>resources/images/chatbubble.png" /><?php echo $blog_info['total_comments']; ?></div>
                            </div>
                        </div>
                <?php
                    }                    
                    $blog_counter = $blog_counter + $total_columns;
                }
                ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>